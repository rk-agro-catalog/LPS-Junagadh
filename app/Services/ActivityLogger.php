<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class ActivityLogger
{
    /**
     * Record an activity log entry.
     *
     * @param  string  $action  Internal action identifier (e.g. 'bhumidan_submitted')
     * @param  string  $description  Human-friendly description in Gujarati/English
     * @param  Request|null  $request  Current HTTP request
     * @param  array  $extraPayload  Additional structured metadata
     * @param  string  $userType  'public' or 'admin'
     * @param  string|null  $userName  Submitter / Actor name
     * @param  string|null  $userContact  Phone or email
     */
    public static function log(
        string $action,
        string $description,
        ?Request $request = null,
        array $extraPayload = [],
        string $userType = 'public',
        ?string $userName = null,
        ?string $userContact = null
    ): ?ActivityLog {
        try {
            $request = $request ?? request();
            $userAgent = (string) $request->header('User-Agent', '');

            // 1. Extract client-side telemetry if submitted
            $clientSystem = [];
            if ($rawClient = $request->input('_client_system')) {
                if (is_string($rawClient)) {
                    $decoded = json_decode($rawClient, true);
                    if (is_array($decoded)) {
                        $clientSystem = $decoded;
                    }
                } elseif (is_array($rawClient)) {
                    $clientSystem = $rawClient;
                }
            }

            // 2. Parse User-Agent & Exact Device Details
            $deviceInfo = self::parseUserAgent($userAgent, $clientSystem);

            // 3. Resolve Exact IP & Location
            $ip = self::resolveClientIp($request);
            $location = self::resolveLocation($request, $clientSystem);

            // 4. Authenticated Admin Context
            $userId = null;
            if ($userType === 'admin' && Auth::check()) {
                $user = Auth::user();
                $userId = $user->id;
                $userName = $userName ?: $user->name;
                $userContact = $userContact ?: $user->email;
            }

            // 5. Sanitize Payload
            $sanitizedPayload = array_merge(
                self::sanitizePayload($request->except(['password', 'password_confirmation', '_token', '_client_system'])),
                ! empty($clientSystem) ? ['_client_system' => $clientSystem] : [],
                $extraPayload
            );

            $entry = ActivityLog::create([
                'user_type' => $userType,
                'user_id' => $userId,
                'user_name' => $userName,
                'user_contact' => $userContact,
                'action' => $action,
                'description' => $description,
                'ip_address' => $ip,
                'device_type' => $deviceInfo['device_type'],
                'os' => $deviceInfo['os'],
                'browser' => $deviceInfo['browser'],
                'device_name' => mb_substr($deviceInfo['device_name'], 0, 250),
                'location' => mb_substr($location, 0, 250),
                'url' => mb_substr($request->fullUrl(), 0, 250),
                'method' => $request->method(),
                'payload' => $sanitizedPayload,
            ]);

            // Self-healing automatic retention: prune logs older than 90 days (~2% of requests)
            // Guarantees automatic 90-day cleanup even without an active system cron daemon
            if (random_int(1, 50) === 1) {
                try {
                    ActivityLog::where('created_at', '<=', now()->subDays(90))->delete();
                } catch (Throwable $ignore) {
                    // Failsafe
                }
            }

            return $entry;
        } catch (Throwable $e) {
            // Failsafe: Never allow logging issues to interrupt the main user workflow
            report($e);

            return null;
        }
    }

    /**
     * Helper to log admin actions.
     */
    public static function logAdmin(
        string $action,
        string $description,
        ?Request $request = null,
        array $extraPayload = []
    ): ?ActivityLog {
        return self::log(
            action: $action,
            description: $description,
            request: $request,
            extraPayload: $extraPayload,
            userType: 'admin'
        );
    }

    /**
     * Parse client user-agent string and telemetry to determine Device Type, OS, Browser, and Exact Device Name.
     *
     * @return array{device_type: string, os: string, browser: string, device_name: string}
     */
    public static function parseUserAgent(string $ua, array $clientSystem = []): array
    {
        $deviceType = 'Desktop';
        $os = 'Unknown OS';
        $browser = 'Unknown Browser';

        // 1. Detect Device Type
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            $deviceType = 'Tablet';
        } elseif (preg_match('/(mobile|iphone|ipod|android|blackberry|iemobile|opera mini|webos|windows phone)/i', $ua)) {
            $deviceType = 'Mobile';
        }

        // 2. Detect Operating System
        if (preg_match('/android/i', $ua)) {
            $os = 'Android';
            if (preg_match('/android\s+([0-9\.]+)/i', $ua, $matches)) {
                $os = 'Android '.$matches[1];
            }
        } elseif (preg_match('/iphone/i', $ua)) {
            $os = 'iOS (iPhone)';
            if (preg_match('/os\s+([0-9_]+)\s+like\s+mac/i', $ua, $matches)) {
                $os = 'iOS '.str_replace('_', '.', $matches[1]);
            }
        } elseif (preg_match('/ipad/i', $ua)) {
            $os = 'iPadOS';
        } elseif (preg_match('/windows nt 10/i', $ua)) {
            $os = 'Windows 10 / 11';
        } elseif (preg_match('/windows nt 6\.3/i', $ua)) {
            $os = 'Windows 8.1';
        } elseif (preg_match('/windows nt 6\.1/i', $ua)) {
            $os = 'Windows 7';
        } elseif (preg_match('/windows/i', $ua)) {
            $os = 'Windows';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            // Distinguish iPad desktop mode
            if (! empty($clientSystem['touch']) && $clientSystem['touch'] === 'yes') {
                $os = 'iPadOS';
                $deviceType = 'Tablet';
            } else {
                $os = 'macOS';
            }
        } elseif (preg_match('/cros/i', $ua)) {
            $os = 'Chrome OS';
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
        }

        // 3. Detect Browser
        if (preg_match('/edg\/([0-9\.]+)/i', $ua, $matches)) {
            $browser = 'Edge '.explode('.', $matches[1])[0];
        } elseif (preg_match('/opr\/([0-9\.]+)|opera/i', $ua, $matches)) {
            $browser = 'Opera';
        } elseif (preg_match('/samsungbrowser\/([0-9\.]+)/i', $ua, $matches)) {
            $browser = 'Samsung Internet';
        } elseif (preg_match('/chrome\/([0-9\.]+)/i', $ua, $matches)) {
            $browser = 'Chrome '.explode('.', $matches[1])[0];
        } elseif (preg_match('/firefox\/([0-9\.]+)/i', $ua, $matches)) {
            $browser = 'Firefox '.explode('.', $matches[1])[0];
        } elseif (preg_match('/version\/([0-9\.]+).*safari/i', $ua, $matches)) {
            $browser = 'Safari '.explode('.', $matches[1])[0];
        }

        // 4. Resolve Exact Device Model Name
        $deviceName = self::resolveExactDeviceName($ua, $clientSystem, $deviceType, $os);

        return [
            'device_type' => $deviceType,
            'os' => $os,
            'browser' => $browser,
            'device_name' => $deviceName,
        ];
    }

    /**
     * Resolve the exact hardware model name of the device.
     */
    public static function resolveExactDeviceName(string $ua, array $clientSystem, string $deviceType, string $os): string
    {
        $rawModel = '';

        // Check if browser provided high-entropy model hint (Chromium Client Hints)
        if (! empty($clientSystem['deviceModel'])) {
            $rawModel = trim((string) $clientSystem['deviceModel']);
        }

        // If not, extract model token from Android User-Agent header
        if (empty($rawModel) && stripos($ua, 'Android') !== false) {
            if (preg_match('/\(Linux;\s*(?:U;\s*)?Android\s*[^;]*;\s*([^;)]+?)(?:\s*Build\/|\))/i', $ua, $matches)) {
                $candidate = trim($matches[1]);
                if (! in_array(strtolower($candidate), ['k', 'wv', 'mobile', 'android'])) {
                    $rawModel = $candidate;
                }
            }
        }

        // Format and identify brand from hardware model token
        if (! empty($rawModel)) {
            $friendlyModel = self::formatFriendlyDeviceModel($rawModel);
            if (! empty($clientSystem['screen'])) {
                return "{$friendlyModel} [{$clientSystem['screen']}]";
            }

            return $friendlyModel;
        }

        // Apple iPhone / iPad identification
        if (stripos($ua, 'iPhone') !== false || ($os === 'iOS (iPhone)')) {
            $screen = $clientSystem['screen'] ?? '';
            $iphoneModel = self::detectIphoneModel($screen);
            if (! empty($screen)) {
                return "{$iphoneModel} [{$screen}]";
            }

            return $iphoneModel;
        }

        if (stripos($ua, 'iPad') !== false || $os === 'iPadOS') {
            $screen = $clientSystem['screen'] ?? '';

            return ! empty($screen) ? "Apple iPad [{$screen}]" : 'Apple iPad';
        }

        // Desktop / Laptop identification with GPU hints
        if ($deviceType === 'Desktop') {
            $gpu = (string) ($clientSystem['gpuRenderer'] ?? '');
            $screen = $clientSystem['screen'] ?? '';
            $screenSuffix = ! empty($screen) ? " [{$screen}]" : '';

            if (str_starts_with($os, 'Windows')) {
                if (stripos($gpu, 'NVIDIA') !== false || stripos($gpu, 'GeForce') !== false) {
                    return "Windows 11/10 PC (NVIDIA GeForce){$screenSuffix}";
                }
                if (stripos($gpu, 'Intel') !== false || stripos($gpu, 'Iris') !== false) {
                    return "Windows 11/10 Laptop (Intel Iris/HD Graphics){$screenSuffix}";
                }
                if (stripos($gpu, 'AMD') !== false || stripos($gpu, 'Radeon') !== false) {
                    return "Windows 11/10 PC (AMD Radeon){$screenSuffix}";
                }

                return "Windows 11/10 PC / Laptop{$screenSuffix}";
            }

            if (str_starts_with($os, 'macOS')) {
                if (preg_match('/Apple\s+M([0-9]+)/i', $gpu, $mMatches)) {
                    return "Apple Mac / MacBook (Apple M{$mMatches[1]}){$screenSuffix}";
                }

                return "Apple Mac / MacBook (macOS){$screenSuffix}";
            }

            if ($os === 'Linux') {
                return "Linux Workstation / PC{$screenSuffix}";
            }

            if ($os === 'Chrome OS') {
                return "Google Chromebook{$screenSuffix}";
            }

            return "Desktop / Laptop ({$os}){$screenSuffix}";
        }

        // Fallback for generic mobile / tablet
        $screen = $clientSystem['screen'] ?? '';
        $screenSuffix = ! empty($screen) ? " [{$screen}]" : '';

        return "{$deviceType} ({$os}){$screenSuffix}";
    }

    /**
     * Map Android model tokens to popular manufacturer and marketing names.
     */
    protected static function formatFriendlyDeviceModel(string $model): string
    {
        $clean = trim($model);

        // Samsung Galaxy Models
        if (preg_match('/^SM-S928/i', $clean)) {
            return 'Samsung Galaxy S24 Ultra ('.$clean.')';
        }
        if (preg_match('/^SM-S926/i', $clean)) {
            return 'Samsung Galaxy S24+ ('.$clean.')';
        }
        if (preg_match('/^SM-S921/i', $clean)) {
            return 'Samsung Galaxy S24 ('.$clean.')';
        }
        if (preg_match('/^SM-S918/i', $clean)) {
            return 'Samsung Galaxy S23 Ultra ('.$clean.')';
        }
        if (preg_match('/^SM-S916/i', $clean)) {
            return 'Samsung Galaxy S23+ ('.$clean.')';
        }
        if (preg_match('/^SM-S911/i', $clean)) {
            return 'Samsung Galaxy S23 ('.$clean.')';
        }
        if (preg_match('/^SM-S908/i', $clean)) {
            return 'Samsung Galaxy S22 Ultra ('.$clean.')';
        }
        if (preg_match('/^SM-S901/i', $clean)) {
            return 'Samsung Galaxy S22 ('.$clean.')';
        }
        if (preg_match('/^SM-G998/i', $clean)) {
            return 'Samsung Galaxy S21 Ultra ('.$clean.')';
        }
        if (preg_match('/^SM-G991/i', $clean)) {
            return 'Samsung Galaxy S21 ('.$clean.')';
        }
        if (preg_match('/^SM-F946/i', $clean)) {
            return 'Samsung Galaxy Z Fold 5 ('.$clean.')';
        }
        if (preg_match('/^SM-F731/i', $clean)) {
            return 'Samsung Galaxy Z Flip 5 ('.$clean.')';
        }
        if (preg_match('/^SM-A546/i', $clean)) {
            return 'Samsung Galaxy A54 5G ('.$clean.')';
        }
        if (preg_match('/^SM-A346/i', $clean)) {
            return 'Samsung Galaxy A34 5G ('.$clean.')';
        }
        if (preg_match('/^SM-A146|^SM-A145/i', $clean)) {
            return 'Samsung Galaxy A14 ('.$clean.')';
        }
        if (preg_match('/^SM-A156/i', $clean)) {
            return 'Samsung Galaxy A15 5G ('.$clean.')';
        }
        if (preg_match('/^SM-A256/i', $clean)) {
            return 'Samsung Galaxy A25 5G ('.$clean.')';
        }
        if (preg_match('/^SM-A356/i', $clean)) {
            return 'Samsung Galaxy A35 5G ('.$clean.')';
        }
        if (preg_match('/^SM-A556/i', $clean)) {
            return 'Samsung Galaxy A55 5G ('.$clean.')';
        }
        if (preg_match('/^SM-M346/i', $clean)) {
            return 'Samsung Galaxy M34 5G ('.$clean.')';
        }
        if (preg_match('/^SM-M146/i', $clean)) {
            return 'Samsung Galaxy M14 5G ('.$clean.')';
        }
        if (preg_match('/^SM-S/i', $clean)) {
            return 'Samsung Galaxy S Series ('.$clean.')';
        }
        if (preg_match('/^SM-A/i', $clean)) {
            return 'Samsung Galaxy A Series ('.$clean.')';
        }
        if (preg_match('/^SM-M/i', $clean)) {
            return 'Samsung Galaxy M Series ('.$clean.')';
        }
        if (preg_match('/^SM-F/i', $clean)) {
            return 'Samsung Galaxy Z Series ('.$clean.')';
        }
        if (preg_match('/^SM-/i', $clean)) {
            return 'Samsung Galaxy ('.$clean.')';
        }

        // Google Pixel
        if (stripos($clean, 'Pixel') !== false) {
            return 'Google '.$clean;
        }

        // OnePlus
        if (preg_match('/^CPH2447|^CPH2451/i', $clean)) {
            return 'OnePlus 11 5G ('.$clean.')';
        }
        if (preg_match('/^CPH2581/i', $clean)) {
            return 'OnePlus 12 ('.$clean.')';
        }
        if (preg_match('/^CPH2585/i', $clean)) {
            return 'OnePlus 12R ('.$clean.')';
        }
        if (preg_match('/^CPH2467/i', $clean)) {
            return 'OnePlus Nord CE 3 Lite ('.$clean.')';
        }
        if (preg_match('/^CPH2487/i', $clean)) {
            return 'OnePlus Nord CE 3 ('.$clean.')';
        }
        if (preg_match('/^CPH2493/i', $clean)) {
            return 'OnePlus Nord 3 5G ('.$clean.')';
        }
        if (preg_match('/^CPH[0-9]{4}/i', $clean) || stripos($clean, 'OnePlus') !== false) {
            return 'OnePlus / Oppo ('.$clean.')';
        }
        if (preg_match('/^NE2211/i', $clean)) {
            return 'OnePlus 10 Pro ('.$clean.')';
        }
        if (preg_match('/^KB2001/i', $clean)) {
            return 'OnePlus 8T ('.$clean.')';
        }

        // Xiaomi / Redmi / POCO
        if (preg_match('/^2312DRA50G|^2312DRA50I/i', $clean)) {
            return 'Xiaomi Redmi Note 13 Pro ('.$clean.')';
        }
        if (preg_match('/^23076RN4BI/i', $clean)) {
            return 'Xiaomi Redmi 12 5G ('.$clean.')';
        }
        if (preg_match('/^22101316G/i', $clean)) {
            return 'Xiaomi 13 Pro ('.$clean.')';
        }
        if (stripos($clean, 'Redmi') !== false) {
            return 'Xiaomi '.$clean;
        }
        if (stripos($clean, 'POCO') !== false) {
            return 'POCO '.$clean;
        }
        if (preg_match('/^[0-9]{8}[A-Z]/i', $clean)) {
            return 'Xiaomi / Redmi ('.$clean.')';
        }

        // Vivo / iQOO
        if (stripos($clean, 'vivo') !== false) {
            return 'Vivo '.str_ireplace('vivo', '', $clean);
        }
        if (preg_match('/^V[0-9]{4}/i', $clean)) {
            return 'Vivo ('.$clean.')';
        }
        if (preg_match('/^I[0-9]{4}/i', $clean)) {
            return 'iQOO ('.$clean.')';
        }

        // Realme
        if (preg_match('/^RMX3771/i', $clean)) {
            return 'Realme 11 Pro 5G ('.$clean.')';
        }
        if (preg_match('/^RMX3840/i', $clean)) {
            return 'Realme 12 Pro+ 5G ('.$clean.')';
        }
        if (preg_match('/^RMX3842/i', $clean)) {
            return 'Realme 12 Pro 5G ('.$clean.')';
        }
        if (preg_match('/^RMX[0-9]{4}/i', $clean)) {
            return 'Realme ('.$clean.')';
        }
        if (stripos($clean, 'Realme') !== false) {
            return $clean;
        }

        // Motorola
        if (preg_match('/^XT[0-9]{4}/i', $clean) || stripos($clean, 'moto') !== false) {
            return 'Motorola ('.$clean.')';
        }

        return ucfirst($clean);
    }

    /**
     * Map iPhone screen viewport resolutions to model generations.
     */
    protected static function detectIphoneModel(string $screen): string
    {
        return match ($screen) {
            '430x932' => 'Apple iPhone 14 / 15 / 16 Pro Max',
            '393x852' => 'Apple iPhone 14 / 15 / 16 Pro',
            '390x844' => 'Apple iPhone 12 / 13 / 14',
            '428x926' => 'Apple iPhone 12 / 13 / 14 Plus',
            '414x896' => 'Apple iPhone 11 / XR / XS Max',
            '375x812' => 'Apple iPhone X / XS / 11 Pro / 12 mini / 13 mini',
            '375x667' => 'Apple iPhone SE / 8 / 7',
            default => 'Apple iPhone',
        };
    }

    /**
     * Resolve reliable client IP taking Cloudflare and reverse proxies into account.
     */
    public static function resolveClientIp(Request $request): string
    {
        if ($cfIp = $request->header('CF-Connecting-IP')) {
            return trim($cfIp);
        }

        if ($forwarded = $request->header('X-Forwarded-For')) {
            $ips = explode(',', $forwarded);

            return trim($ips[0]);
        }

        if ($realIp = $request->header('X-Real-IP')) {
            return trim($realIp);
        }

        return $request->ip() ?? '127.0.0.1';
    }

    /**
     * Resolve exact client location using client telemetry, Cloudflare headers, and IP Geolocation API.
     */
    public static function resolveLocation(Request $request, array $clientSystem = []): string
    {
        // 1. Priority 1: Check Client-side precise telemetry (fetched directly from user device)
        if (! empty($clientSystem['city'])) {
            $locParts = [];
            $locParts[] = $clientSystem['city'];

            if (! empty($clientSystem['region']) && $clientSystem['region'] !== $clientSystem['city']) {
                $locParts[] = $clientSystem['region'];
            }
            if (! empty($clientSystem['postal'])) {
                $locParts[] = '('.$clientSystem['postal'].')';
            }
            if (! empty($clientSystem['country'])) {
                $locParts[] = $clientSystem['country'];
            }

            $locString = implode(', ', $locParts);
            if (! empty($clientSystem['isp'])) {
                $locString .= ' • '.$clientSystem['isp'];
            }

            return $locString;
        }

        // 2. Priority 2: Cloudflare Edge Proxy Headers
        $cfCity = $request->header('CF-IPCity');
        $cfRegion = $request->header('CF-Region');
        $cfCountry = $request->header('CF-IPCountry');
        $cfPostal = $request->header('CF-Postal-Code');

        if (! empty($cfCity)) {
            $parts = [$cfCity];
            if (! empty($cfRegion) && $cfRegion !== $cfCity) {
                $parts[] = $cfRegion;
            }
            if (! empty($cfPostal)) {
                $parts[] = '('.$cfPostal.')';
            }
            if (! empty($cfCountry)) {
                $parts[] = $cfCountry;
            }

            return implode(', ', $parts);
        }

        // 3. Priority 3: Server-side IP Geolocation API with 24-hour cache
        $ip = self::resolveClientIp($request);
        $isLocal = ($ip === '127.0.0.1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.') || str_starts_with($ip, '172.'));

        if (! $isLocal) {
            $geo = Cache::remember('ip_geo_v3_'.$ip, 86400, function () use ($ip) {
                try {
                    // Try ipwho.is with 1.5s timeout
                    $res = Http::withoutVerifying()->timeout(1.5)->get('https://ipwho.is/'.$ip);
                    if ($res->successful()) {
                        $data = $res->json();
                        if (! empty($data['success'])) {
                            return [
                                'city' => $data['city'] ?? '',
                                'region' => $data['region'] ?? '',
                                'country' => $data['country'] ?? 'India',
                                'postal' => $data['postal'] ?? '',
                                'isp' => $data['connection']['isp'] ?? '',
                            ];
                        }
                    }

                    // Fallback to ip-api.com
                    $fallback = Http::timeout(1.5)->get('http://ip-api.com/json/'.$ip);
                    if ($fallback->successful()) {
                        $fData = $fallback->json();
                        if (! empty($fData['status']) && $fData['status'] === 'success') {
                            return [
                                'city' => $fData['city'] ?? '',
                                'region' => $fData['regionName'] ?? '',
                                'country' => $fData['country'] ?? 'India',
                                'postal' => $fData['zip'] ?? '',
                                'isp' => $fData['isp'] ?? '',
                            ];
                        }
                    }
                } catch (Throwable $e) {
                    // Silently fail to fallback
                }

                return null;
            });

            if ($geo && ! empty($geo['city'])) {
                $parts = [$geo['city']];
                if (! empty($geo['region']) && $geo['region'] !== $geo['city']) {
                    $parts[] = $geo['region'];
                }
                if (! empty($geo['postal'])) {
                    $parts[] = '('.$geo['postal'].')';
                }
                if (! empty($geo['country'])) {
                    $parts[] = $geo['country'];
                }
                $result = implode(', ', $parts);
                if (! empty($geo['isp'])) {
                    $result .= ' • '.$geo['isp'];
                }

                return $result;
            }
        }

        // 4. Priority 4: Localhost fallback
        if ($isLocal) {
            $tz = ! empty($clientSystem['timezone']) ? $clientSystem['timezone'] : 'Asia/Kolkata';

            return 'Localhost / Internal ('.$tz.')';
        }

        return 'India (IN)';
    }

    /**
     * Sanitize array to strip passwords and prevent uploading raw binary data into JSON.
     */
    protected static function sanitizePayload(array $data): array
    {
        $clean = [];
        foreach ($data as $key => $val) {
            if (in_array(strtolower($key), ['password', 'password_confirmation', '_token', '_method'])) {
                continue;
            }
            if (is_object($val)) {
                $clean[$key] = '[Uploaded File: '.($val->getClientOriginalName() ?? 'file').']';
            } elseif (is_array($val)) {
                $clean[$key] = self::sanitizePayload($val);
            } else {
                $clean[$key] = $val;
            }
        }

        return $clean;
    }
}

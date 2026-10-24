<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $deviceInfo = self::parseUserAgent($userAgent);

            $ip = self::resolveClientIp($request);
            $location = self::resolveLocation($request);

            $userId = null;
            if ($userType === 'admin' && Auth::check()) {
                $user = Auth::user();
                $userId = $user->id;
                $userName = $userName ?: $user->name;
                $userContact = $userContact ?: $user->email;
            }

            $sanitizedPayload = array_merge(
                self::sanitizePayload($request->except(['password', 'password_confirmation', '_token'])),
                $extraPayload
            );

            return ActivityLog::create([
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
                'device_name' => $deviceInfo['device_name'],
                'location' => $location,
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'payload' => $sanitizedPayload,
            ]);
        } catch (Throwable $e) {
            // Failsafe: Never allow logging issues to interrupt the user request
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
     * Parse client user-agent string to determine Device Type, OS, and Browser.
     *
     * @return array{device_type: string, os: string, browser: string, device_name: string}
     */
    public static function parseUserAgent(string $ua): array
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
            $os = 'macOS';
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

        // 4. Construct human-readable device name
        $deviceName = match ($deviceType) {
            'Mobile' => "Mobile ({$os})",
            'Tablet' => "Tablet ({$os})",
            default => "Desktop / Laptop ({$os})",
        };

        return [
            'device_type' => $deviceType,
            'os' => $os,
            'browser' => $browser,
            'device_name' => $deviceName,
        ];
    }

    /**
     * Resolve reliable client IP taking Cloudflare and reverse proxies into account.
     */
    public static function resolveClientIp(Request $request): string
    {
        // Cloudflare real visitor IP
        if ($cfIp = $request->header('CF-Connecting-IP')) {
            return trim($cfIp);
        }

        // X-Forwarded-For chain (take the first public IP)
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
     * Resolve approximate client location using edge proxy headers.
     */
    public static function resolveLocation(Request $request): string
    {
        $city = $request->header('CF-IPCity');
        $country = $request->header('CF-IPCountry');
        $region = $request->header('CF-Region');

        $parts = [];
        if (! empty($city)) {
            $parts[] = $city;
        }
        if (! empty($region) && $region !== $city) {
            $parts[] = $region;
        }
        if (! empty($country)) {
            $parts[] = $country;
        }

        if (! empty($parts)) {
            return implode(', ', $parts);
        }

        $ip = self::resolveClientIp($request);
        if ($ip === '127.0.0.1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return 'Localhost / Internal';
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

<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminInactivityTimeout
{
    /**
     * Handle an incoming request.
     * Logs out the user if inactive for more than 30 minutes, recording an audit log.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session('admin_last_activity_time');
            $timeoutSeconds = 30 * 60; // 30 minutes

            if ($lastActivity && (time() - $lastActivity) > $timeoutSeconds) {
                $user = Auth::user();

                // Log the automatic timeout logout
                ActivityLogger::log(
                    action: 'admin_auto_timeout_logout',
                    description: "એડમિન યુઝર '{$user->name}' ({$user->email}) ૩૦ મિનિટ સુધી નિષ્ક્રિય રહેવાને કારણે આપોઆપ લૉગ આઉટ થયા (Inactivity Session Timeout).",
                    request: $request,
                    extraPayload: [
                        'timeout_minutes' => 30,
                        'last_activity_at' => date('Y-m-d H:i:s', $lastActivity),
                        'inactivity_seconds' => time() - $lastActivity,
                    ],
                    userType: 'admin',
                    userName: $user->name,
                    userContact: $user->email
                );

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('admin.login')->with('warning', '૩૦ મિનિટ સુધી કોઈ પ્રવૃત્તિ ન થવાથી સુરક્ષાના કારણોસર આપ આપોઆપ લૉગ આઉટ થઈ ગયા છો. કૃપા કરીને ફરી લૉગિન કરો.');
            }

            // Update last activity timestamp
            session(['admin_last_activity_time' => time()]);
        }

        return $next($request);
    }
}

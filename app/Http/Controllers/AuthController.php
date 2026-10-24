<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle admin login attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'કૃપા કરીને એડમિન ઇમેઇલ દાખલ કરો.',
            'email.email' => 'માન્ય ઇમેઇલ એડ્રેસ દાખલ કરો.',
            'password.required' => 'કૃપા કરીને પાસવર્ડ દાખલ કરો.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            $request->session()->regenerate();

            ActivityLogger::log(
                action: 'admin_login_success',
                description: "એડમિન યુઝર '{$user->name}' ({$user->email}) સફળતાપૂર્વક લૉગિન થયા.",
                request: $request,
                extraPayload: ['email' => $user->email],
                userType: 'admin',
                userName: $user->name,
                userContact: $user->email
            );

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'એડમિન પોર્ટલમાં આપનું હાર્દિક સ્વાગત છે!');
        }

        ActivityLogger::log(
            action: 'admin_login_failed',
            description: "એડમિન લૉગિન નિષ્ફળ પ્રયાસ: '{$credentials['email']}' (અમાન્ય પાસવર્ડ અથવા ઇમેઇલ).",
            request: $request,
            extraPayload: ['attempted_email' => $credentials['email']],
            userType: 'public',
            userName: 'અજાણ્યો લૉગિન પ્રયાસ',
            userContact: $credentials['email']
        );

        return back()
            ->withErrors([
                'email' => 'આપેલા ઇમેઇલ અથવા પાસવર્ડ અમાન્ય છે. કૃપા કરીને ફરી પ્રયાસ કરો.',
            ])
            ->onlyInput('email');
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            ActivityLogger::log(
                action: 'admin_logout',
                description: "એડમિન યુઝર '{$user->name}' ({$user->email}) લૉગ આઉટ થયા.",
                request: $request,
                userType: 'admin',
                userName: $user->name,
                userContact: $user->email
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'આપ સુરક્ષિત રીતે એડમિન પોર્ટલમાંથી લોગ આઉટ થઈ ગયા છો.');
    }

    /**
     * Handle automatic logout due to 30 minutes of inactivity.
     */
    public function autoLogout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            ActivityLogger::log(
                action: 'admin_auto_timeout_logout',
                description: "એડમિન યુઝર '{$user->name}' ({$user->email}) ૩૦ મિનિટ સુધી નિષ્ક્રિય રહેવાને કારણે બ્રાઉઝરમાંથી આપોઆપ લૉગ આઉટ થયા.",
                request: $request,
                extraPayload: ['reason' => 'inactivity_timeout_30_minutes'],
                userType: 'admin',
                userName: $user->name,
                userContact: $user->email
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('warning', '૩૦ મિનિટ સુધી કોઈ પ્રવૃત્તિ ન થવાથી સુરક્ષાના કારણોસર આપ આપોઆપ લૉગ આઉટ થઈ ગયા છો. કૃપા કરીને ફરી લૉગિન કરો.');
    }
}

<?php

namespace App\Http\Controllers;

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
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'એડમિન પોર્ટલમાં આપનું હાર્દિક સ્વાગત છે!');
        }

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
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'આપ સુરક્ષિત રીતે એડમિન પોર્ટલમાંથી લોગ આઉટ થઈ ગયા છો.');
    }
}

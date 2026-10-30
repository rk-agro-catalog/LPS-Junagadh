@extends('layouts.admin')

@section('title', 'સિક્યુરિટી સેટિંગ્સ & પાસવર્ડ પરિવર્તન')
@section('header_title', 'એડમિન સુરક્ષા & પાસવર્ડ મેનેજમેન્ટ')

@section('content')

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; align-items: start;">
    
    <!-- Change Password Card -->
    <div class="admin-card">
        <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 1.25rem;">
            <div style="width: 42px; height: 42px; border-radius: 12px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                <i class="ri-lock-password-line"></i>
            </div>
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #780d28; margin: 0;">એડમિન પાસવર્ડ બદલો</h3>
                <p style="font-size: 0.8rem; color: #64748b; margin: 0;">એકાઉન્ટને હેકથી સુરક્ષિત રાખવા માટે મજબૂત પાસવર્ડ સેટ કરો.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 1.25rem; background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.75rem 1rem; border-radius: var(--radius-md);">
                <i class="ri-error-warning-fill"></i>
                <ul style="margin: 0; padding-left: 1rem; font-size: 0.85rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.security.password') }}" method="POST" autocomplete="off">
            @csrf

            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="font-size: 0.84rem; font-weight: 700; color: #334155;">હાલનો પાસવર્ડ (Current Password) *</label>
                <input type="password" name="current_password" class="form-control" placeholder="હાલનો પાસવર્ડ દાખલ કરો" autocomplete="off" required>
            </div>

            <div class="form-group" style="margin-bottom: 1rem;">
                <label class="form-label" style="font-size: 0.84rem; font-weight: 700; color: #334155;">નવો પાસવર્ડ (New Password) *</label>
                <input type="password" name="password" class="form-control" placeholder="ઓછામાં ઓછા ૮ અક્ષરનો પાસવર્ડ" autocomplete="off" required>
                <small style="font-size: 0.74rem; color: #64748b; margin-top: 3px; display: block;">અક્ષરો, અંકો અને સ્પેશિયલ સિમ્બોલ (@, #, $, !) વાપરો.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="font-size: 0.84rem; font-weight: 700; color: #334155;">નવો પાસવર્ડ ફરીથી લખો (Confirm New Password) *</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="નવો પાસવર્ડ ફરી દાખલ કરો" autocomplete="off" required>
            </div>

            <button type="submit" class="admin-quick-pill primary" style="width: 100%; justify-content: center; font-size: 0.92rem; padding: 0.75rem; border: none; cursor: pointer;">
                <i class="ri-shield-check-fill" style="color: #fbbf24;"></i> સુરક્ષિત પાસવર્ડ અપડેટ કરો
            </button>
        </form>
    </div>

    <!-- Security Audit Status & Defense Checklist Card -->
    <div class="admin-card">
        <div style="display: flex; align-items: center; gap: 0.65rem; margin-bottom: 1.25rem;">
            <div style="width: 42px; height: 42px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                <i class="ri-shield-keyhole-fill"></i>
            </div>
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #065f46; margin: 0;">સિસ્ટમ સિક્યુરિટી ઓડિટ સ્ટેટસ</h3>
                <p style="font-size: 0.8rem; color: #64748b; margin: 0;">OWASP & સાયબર સિક્યુરિટી શિલ્ડ પ્રોટેક્શન</p>
            </div>
        </div>

        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.85rem; padding: 0; margin-bottom: 1.5rem;">
            <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.88rem;">
                <i class="ri-checkbox-circle-fill" style="color: #10b981; font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                <div>
                    <strong style="color: #0f172a;">બ્રુટ-ફોર્સ રેટ લિમિટીંગ (Rate Limiting) :</strong>
                    <div style="font-size: 0.76rem; color: #64748b;">લોગિન પર પ્રતિ મિનિટ વધુમાં વધુ ૫ પ્રયાસોની મર્યાદા સક્રિય છે.</div>
                </div>
            </li>

            <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.88rem;">
                <i class="ri-checkbox-circle-fill" style="color: #10b981; font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                <div>
                    <strong style="color: #0f172a;">CSRF પ્રોટેક્શન (Anti-Forgery) :</strong>
                    <div style="font-size: 0.76rem; color: #64748b;">તમામ પબ્લિક અને એડમિન ફોર્મ્સ ટોકન-સિક્યોર્ડ છે.</div>
                </div>
            </li>

            <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.88rem;">
                <i class="ri-checkbox-circle-fill" style="color: #10b981; font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                <div>
                    <strong style="color: #0f172a;">SQL Injection રોકથામ :</strong>
                    <div style="font-size: 0.76rem; color: #64748b;">સંપૂર્ણ ડેટાબેઝ ક્વેરીઝ PDO Parameterized બાઈન્ડિંગ્સ દ્વારા સુરક્ષિત છે.</div>
                </div>
            </li>

            <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.88rem;">
                <i class="ri-checkbox-circle-fill" style="color: #10b981; font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                <div>
                    <strong style="color: #0f172a;">XSS (Cross-Site Scripting) શિલ્ડ :</strong>
                    <div style="font-size: 0.76rem; color: #64748b;">તમામ આઉટપુટ ઓટો-એસ્કેપિંગ (`htmlspecialchars`) થી સુરક્ષિત છે.</div>
                </div>
            </li>

            <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.88rem;">
                <i class="ri-checkbox-circle-fill" style="color: #10b981; font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                <div>
                    <strong style="color: #0f172a;">OWASP ડિફેન્સિવ HTTP હેડર્સ :</strong>
                    <div style="font-size: 0.76rem; color: #64748b;">X-Frame-Options, X-Content-Type-Options, Referrer-Policy સક્રિય.</div>
                </div>
            </li>

            <li style="display: flex; align-items: flex-start; gap: 0.65rem; font-size: 0.88rem;">
                <i class="ri-checkbox-circle-fill" style="color: #10b981; font-size: 1.2rem; flex-shrink: 0; margin-top: 1px;"></i>
                <div>
                    <strong style="color: #0f172a;">સુરક્ષિત સેશન મેનેજમેન્ટ :</strong>
                    <div style="font-size: 0.76rem; color: #64748b;">HttpOnly & Lax SameSite કૂકીઝ, લોગઆઉટ પર સેશન ઇનવેલિડેશન.</div>
                </div>
            </li>
        </ul>

        <div style="background: #fffbeb; border: 1.5px solid #fef08a; border-radius: 12px; padding: 0.85rem 1rem;">
            <div style="font-size: 0.82rem; font-weight: 800; color: #854d0e; display: flex; align-items: center; gap: 0.4rem;">
                <i class="ri-lightbulb-flash-line"></i> લાઈવ પ્રોડક્શન હોસ્ટિંગ સલાહ:
            </div>
            <div style="font-size: 0.76rem; color: #78350f; margin-top: 0.35rem; line-height: 1.5;">
                સાઇટને લાઈવ સર્વર (Production) પર મૂકતી વખતે `.env` ફાઈલમાં `APP_DEBUG=false` રાખવું અને SSL સર્ટિફિકેટ (HTTPS) ફરજિયાત ચાલુ રાખવું.
            </div>
        </div>
    </div>
</div>

@endsection

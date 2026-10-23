@extends('layouts.app')

@section('title', 'સેવા સંકલ્પ (વિભાગ ૧ & ૨) | શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ')

@section('content')

<!-- Banner Header -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;"><i class="ri-building-line"></i> સેવા સંકલ્પ દર્શન</span>
        <h1>સંકુલ નિર્માણ & સુવિધાઓ</h1>
        <p>
            પ્રમુખ સેવા સંકલ્પ (વિભાગ-૧) તથા નાના અને મધ્યમ વર્ગ માટે વિશેષ સેવા સંકલ્પ (વિભાગ-૨) ની સંપૂર્ણ રૂપરેખા
        </p>
    </div>
</div>

<div class="container section-padding">

    <!-- Mission statement quote from flyer -->
    <div style="background: #fffbeb; border: 2px solid #fef08a; border-radius: var(--radius-lg); padding: clamp(1.25rem, 3vw, 2rem); margin-bottom: clamp(1.75rem, 4vw, 3rem); box-shadow: var(--shadow-sm);">
        <div style="display: flex; gap: 1rem; align-items: flex-start;">
            <i class="ri-double-quotes-l" style="font-size: 2rem; color: var(--color-primary-light); line-height: 1; flex-shrink: 0;"></i>
            <div>
                <h2 style="font-size: clamp(1.1rem, 2.5vw, 1.3rem); color: #92400e; font-weight:800; margin-bottom: 0.4rem;">
                    વિશેષ સેવા સંકલ્પનું હૃદયસ્પર્શી વિઝન :
                </h2>
                <p style="font-size: clamp(0.92rem, 2vw, 1.08rem); line-height: 1.7; color: #78350f;">
                    "આપણે સંકુલમાં નાના તથા મધ્યમ વર્ગના જ્ઞાતિજનોને સમૂહ લગ્નમાં જવાની જરૂરીયાત ન પડે અને સારા લોકેશન સાથે ઉચ્ચકક્ષાની સવલત મળી રહે તે માટે અલગથી વ્યવસ્થા કરવામાં આવશે."
                </p>

                <div style="margin-top: 0.75rem; font-weight:700; color: var(--color-maroon); font-size: 0.95rem;">
                    - શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ
                </div>
            </div>
        </div>
    </div>

    <!-- Comparative Visual Table -->
    <div class="sankalp-grid" style="margin-bottom: 4rem;">
        <!-- Vibhag 1 -->
        <div class="sankalp-card">
            <div class="sankalp-header">
                <span class="badge badge-gold" style="position: absolute; top: 1.25rem; right: 1.5rem;">વિભાગ-૧</span>
                <h3>પ્રમુખ સેવા સંકલ્પ : વિભાગ-૧</h3>
                <p>ભવ્ય સામાજિક પ્રસંગો અને મહા સંમેલનો માટે</p>
            </div>
            <div class="sankalp-body">
                <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
                    વિશાળ ક્ષમતા ધરાવતો પાર્ટી પ્લોટ, અદ્યતન એ.સી. સેન્ટ્રલાઇઝ્ડ બેન્કવેટ હોલ અને સગા-સંબંધીઓ માટે આલીશાન ડીલક્સ અતિથિ ભવન.
                </p>

                <ul class="facility-list">
                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon"><i class="ri-landscape-line"></i></div>
                            <div>
                                <strong>પાર્ટી પ્લોટ</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">લીલોછમ લૉન & સ્ટેજ</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૧૫૦૦ વ્યક્તિ માટે</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon"><i class="ri-hotel-line"></i></div>
                            <div>
                                <strong>સેન્ટ્રલ AC બેન્કવેટ હોલ</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">આધુનિક સાઉન્ડ & લાઇટિંગ</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૬૦૦ વ્યક્તિ માટે</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon"><i class="ri-restaurant-line"></i></div>
                            <div>
                                <strong>ભોજનાલય (ડાઇનિંગ હોલ)</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">હાઈજેનિક રસોડું & ટેબલ વ્યવસ્થા</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૮૦૦ વ્યક્તિ માટે</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon"><i class="ri-hotel-bed-line"></i></div>
                            <div>
                                <strong>અતિથિ ભવન</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">એ.સી. એટેચ્ડ બાથરૂમ સાથે</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૬૦ રૂમ</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon"><i class="ri-parking-box-line"></i></div>
                            <div>
                                <strong>વિશાળ પાર્કિંગ ક્ષેત્ર</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">સીસીટીવી & સિક્યુરિટી સજ્જ</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૪૦૦+ વાહનો</span>
                    </li>
                </ul>
            </div>
            <div class="sankalp-footer">
                <a href="{{ route('booking') }}?section=વિભાગ-૧" class="btn btn-primary" style="width: 100%;">
                    વિભાગ-૧ માટે બુકિંગ ઇન્ક્વાયરી કરો
                </a>
            </div>
        </div>

        <!-- Vibhag 2 -->
        <div class="sankalp-card">
            <div class="sankalp-header section-two">
                <span class="badge badge-gold" style="position: absolute; top: 1.25rem; right: 1.5rem;">વિભાગ-૨</span>
                <h3>વિશેષ સેવા સંકલ્પ : વિભાગ-૨</h3>
                <p>નાના તથા મધ્યમ વર્ગના જ્ઞાતિજનો માટે સમર્પિત</p>
            </div>
            <div class="sankalp-body">
                <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
                    મધ્યમ વર્ગના પરિવારો કોઈ પણ પ્રકારની સંકોચ વિના ગૌરવભેર પોતાનો શુભ પ્રસંગ કરી શકે તે હેતુથી તમામ અદ્યતન સવલતો સાથેનું અલાયદું નિર્માણ.
                </p>

                <ul class="facility-list">
                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-landscape-line"></i></div>
                            <div>
                                <strong>પાર્ટી પ્લોટ</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">સુંદર સુશોભિત ઓપન પ્લોટ</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૫૦૦ વ્યક્તિ માટે</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-hotel-line"></i></div>
                            <div>
                                <strong>બેન્કવેટ હોલ</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">વાતાનુકૂલિત હોલ સુવિધા</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૫૦૦ વ્યક્તિ માટે</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-restaurant-line"></i></div>
                            <div>
                                <strong>ભોજનાલય</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">શુદ્ધ અને સ્વચ્છ જમણવાર હોલ</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૫૦૦ વ્યક્તિ માટે</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-home-wifi-line"></i></div>
                            <div>
                                <strong>ઉતારા માટે સુવિધા</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">વ્યવસ્થિત રહેઠાણ રૂમ</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૨૦ રૂમ</span>
                    </li>

                    <li class="facility-item">
                        <div class="facility-name">
                            <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-parking-box-line"></i></div>
                            <div>
                                <strong>વિશાળ પાર્કિંગ</strong>
                                <div style="font-size: 0.8rem; color: var(--color-text-muted);">અલાયદી પાર્કિંગ વ્યવસ્થા</div>
                            </div>
                        </div>
                        <span class="facility-capacity">૨૦૦+ વાહનો</span>
                    </li>
                </ul>
            </div>
            <div class="sankalp-footer">
                <a href="{{ route('booking') }}?section=વિભાગ-૨" class="btn btn-maroon" style="width: 100%;">
                    વિભાગ-૨ માટે બુકિંગ ઇન્ક્વાયરી કરો
                </a>
            </div>
        </div>
    </div>

    <!-- Location & River Bank Ambience -->
    <div style="background: var(--color-surface); border-radius: var(--radius-lg); padding: 3rem; text-align: center;">
        <h3 style="font-size: 1.8rem; font-weight:800; color: var(--color-maroon); margin-bottom: 1rem;">
            પ્રકૃતિના સાન્નિધ્યમાં સોનરખ નદીના તટે
        </h3>
        <p style="font-size: 1.05rem; color: var(--color-text-muted); max-width: 750px; margin: 0 auto 1.5rem; line-height: 1.8;">
            જૂનાગઢ બાયપાસ રોડ પર ખલીલપુર ચોકડી પાસે સોનરખ નદીના પવિત્ર કાંઠે સ્થિત આ સંકુલ વાહન વ્યવહાર માટે સુગમ, શાંત અને કુદરતી વાતાવરણથી ભરપૂર છે.
        </p>
        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('bhumidan') }}" class="btn btn-primary">
                <i class="ri-heart-3-fill"></i> ભૂમિદાન યોજનામાં સહયોગ કરો
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-gold">
                <i class="ri-map-pin-line"></i> સંકુલ લોકેશન નકશો જુઓ
            </a>
        </div>
    </div>
</div>

@endsection

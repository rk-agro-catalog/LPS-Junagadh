@extends('layouts.app')

@section('title', 'મુખ્ય પૃષ્ઠ | શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ (LPS Junagadh)')

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-left">
            <div class="hero-tagline">
                <i class="ri-shield-star-fill" style="color: var(--color-gold-bright);"></i>
                <span>॥ સંગઠન એ જ શક્તિ ॥ • શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ</span>
            </div>
            <h1 class="hero-title">
                <span class="hero-title-main" style="color: #ffffff !important; display: inline-block;">સમાજ ગૌરવ અને સેવા સંકલ્પનું</span>
                <span>ભવ્ય સંકુલ નિર્માણ</span>
            </h1>
            <p class="hero-description">
                જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, પવિત્ર સોનરખ નદીના કાંઠે સમસ્ત લેઉવા પટેલ જ્ઞાતિજનોના શુભ પ્રસંગો અને સામાજિક ઉત્કર્ષ માટે ભવ્ય સંકુલનું નિર્માણ થઈ રહ્યું છે.
            </p>

            <div class="hero-cta-group">
                <a href="{{ route('bhumidan') }}" class="btn btn-primary">
                    <i class="ri-heart-3-fill"></i> ભૂમિદાન આપો (રૂા. ૨૫૦૦/-)
                </a>
                <a href="{{ route('sankalp') }}" class="btn btn-white">
                    <i class="ri-building-4-line"></i> સેવા સંકલ્પ દર્શન
                </a>
            </div>

            <div class="hero-highlights">
                <div class="hero-highlight-item">
                    <span class="hero-highlight-num">૧,૫૦૦+</span>
                    <span class="hero-highlight-lbl">વિભાગ-૧ પ્લોટ ક્ષમતા</span>
                </div>
                <div class="hero-highlight-item">
                    <span class="hero-highlight-num">૮૦ રૂમ</span>
                    <span class="hero-highlight-lbl">અતિથિ ભવન & ઉતારા</span>
                </div>
                <div class="hero-highlight-item">
                    <span class="hero-highlight-num">૨,૫૦૦/-</span>
                    <span class="hero-highlight-lbl">પ્રતિ ચોરસ વાર ભૂમિદાન</span>
                </div>
            </div>
        </div>

        <!-- Hero Right: Quick Bhumidan Calculator -->
        <div class="hero-right">
            <div class="hero-card">
                <div class="hero-card-header">
                    <span class="badge badge-gold"><i class="ri-hand-heart-fill"></i> પવિત્ર ભૂમિદાન યોજના</span>
                    <h3 style="margin-top: 0.45rem; font-size: 1.15rem; font-weight: 650; color: var(--color-maroon);">એક ચોરસ વાર ભૂમિદાન</h3>
                    <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.15rem;">
                        માત્ર રૂા. ૨૫૦૦/- માં આપ પણ સંકુલ નિર્માણમાં ભાગીદાર બનો
                    </p>
                </div>

                <div style="margin-bottom: 0.75rem;">
                    <label style="font-size: 0.82rem; font-weight:600; color: var(--color-text-muted);">વાર પસંદ કરો:</label>
                    <div class="calc-pill-group">
                        <button type="button" class="calc-pill-btn active" data-yards="1">૧ વાર</button>
                        <button type="button" class="calc-pill-btn" data-yards="2">૨ વાર</button>
                        <button type="button" class="calc-pill-btn" data-yards="5">૫ વાર</button>
                        <button type="button" class="calc-pill-btn" data-yards="10">૧૦ વાર</button>
                        <button type="button" class="calc-pill-btn" data-yards="20">૨૦ વાર</button>
                        <button type="button" class="calc-pill-btn" data-yards="40">૪૦ વાર</button>
                        <button type="button" class="calc-pill-btn" data-yards="50">૫૦ વાર</button>
                        <button type="button" class="calc-pill-btn" data-yards="100">૧૦૦ વાર</button>
                    </div>
                </div>

                <div class="calc-result-box" style="margin-bottom: 0.75rem;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #854d0e; text-transform: uppercase;">કુલ સહયોગ રાશિ</div>
                    <div class="calc-amount" id="calcAmountDisplay">₹ 2,500/-</div>
                    <div style="font-size: 0.75rem; color: #a16207; margin-top: 0.2rem;">(૧ ચોરસ વાર જગ્યાનું ભૂમિદાન)</div>
                </div>

                <!-- Instant UPI button for mobile devices -->
                <a id="homeDynamicUpiBtn" href="upi://pay?pa=9093390934@sbi&pn=Shree%20Samast%20Leuva%20Patel%20Samaj%20Trust&am=2500&cu=INR&tn=LPS%20Junagadh%20Bhumidan%20(1%20Yards)" class="btn mobile-only" style="width: 100%; background: #059669; color: #fff; font-size: 0.88rem; padding: 0.55rem; align-items: center; justify-content: center; gap: 0.4rem; border-radius: var(--radius-md); margin-bottom: 0.75rem; font-weight: 600;">
                    <i class="ri-smartphone-line"></i> ૧-ક્લિક UPI થી ચુકવો (GPay / PhonePe)
                </a>

                <form action="{{ route('bhumidan.store') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="sq_yards" id="formSqYards" value="1">
                    <input type="hidden" name="payment_method" value="UPI">
                    <input type="hidden" name="city" value="જૂનાગઢ">
                    
                    <div style="display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 0.75rem;">
                        <input type="text" name="donor_name" class="form-control" placeholder="તમારું પૂરું નામ (દાતાશ્રી)" autocomplete="off" required style="min-height: 40px; padding: 0.55rem 0.85rem; font-size: 0.88rem;">
                        <input type="tel" name="phone" class="form-control" placeholder="મોબાઈલ નંબર" autocomplete="off" required style="min-height: 40px; padding: 0.55rem 0.85rem; font-size: 0.88rem;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 0.92rem; padding: 0.62rem; font-weight: 600;">
                        <i class="ri-check-double-line"></i> ભૂમિદાન સંકલ્પ નોંધાવો
                    </button>
                </form>
                
                <div style="text-align: center; margin-top: 0.65rem;">
                    <a href="{{ route('bhumidan') }}" style="font-size: 0.82rem; color: var(--color-primary-dark); font-weight: 600; text-decoration: underline;">
                        સંપૂર્ણ દાતા યાદી & બેંક વિગતો જુઓ <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mobile App Quick Actions Launcher -->
<section class="app-quick-actions-section">
    <div class="container">
        <div class="app-quick-grid">
            <a href="{{ route('bhumidan') }}" class="app-action-card">
                <div class="app-action-icon gold-grad">
                    <i class="ri-hand-heart-fill"></i>
                </div>
                <div class="app-action-text">
                    <strong>૧ વાર ભૂમિદાન</strong>
                    <span>રૂા. ૨,૫૦૦/- સહયોગ</span>
                </div>
                <i class="ri-arrow-right-s-line app-action-arrow"></i>
            </a>

            <a href="{{ route('booking') }}" class="app-action-card">
                <div class="app-action-icon maroon-grad">
                    <i class="ri-building-line"></i>
                </div>
                <div class="app-action-text">
                    <strong>હોલ & પ્લોટ બુકિંગ</strong>
                    <span>વિભાગ ૧ & ૨ પ્રસંગ</span>
                </div>
                <i class="ri-arrow-right-s-line app-action-arrow"></i>
            </a>

            <a href="{{ route('sankalp') }}" class="app-action-card">
                <div class="app-action-icon amber-grad">
                    <i class="ri-service-line"></i>
                </div>
                <div class="app-action-text">
                    <strong>સેવા સંકલ્પ દર્શન</strong>
                    <span>સંકુલ સુવિધાઓ</span>
                </div>
                <i class="ri-arrow-right-s-line app-action-arrow"></i>
            </a>

            <a href="{{ route('events') }}" class="app-action-card">
                <div class="app-action-icon emerald-grad">
                    <i class="ri-calendar-event-line"></i>
                </div>
                <div class="app-action-text">
                    <strong>સમાજ કાર્યક્રમો</strong>
                    <span>ઉત્સવ & સ્નેહમિલન</span>
                </div>
                <i class="ri-arrow-right-s-line app-action-arrow"></i>
            </a>

            <a href="{{ route('membership') }}" class="app-action-card">
                <div class="app-action-icon blue-grad">
                    <i class="ri-team-line"></i>
                </div>
                <div class="app-action-text">
                    <strong>જ્ઞાતિ ડિરેક્ટરી</strong>
                    <span>સભ્ય નોંધણી & સર્ચ</span>
                </div>
                <i class="ri-arrow-right-s-line app-action-arrow"></i>
            </a>

            <a href="{{ route('gallery') }}" class="app-action-card">
                <div class="app-action-icon rose-grad">
                    <i class="ri-gallery-fill"></i>
                </div>
                <div class="app-action-text">
                    <strong>ફોટો & રીલ્સ</strong>
                    <span>સંકલ્પ યાત્રા વિડીયો</span>
                </div>
                <i class="ri-arrow-right-s-line app-action-arrow"></i>
            </a>
        </div>
    </div>
</section>

<!-- Section 1 & 2: Sankalp Facilities (Matching the Official Pamphlet) -->
<section class="section-padding">
    <div class="container">
        <div class="section-header">
            <span class="section-pretitle"><i class="ri-building-line"></i> ભવ્ય નિર્માણ યોજના</span>
            <h2 class="section-title">સંકુલ સેવા સંકલ્પ દર્શન</h2>
            <p class="section-desc">
                જ્ઞાતિના દરેક પરિવારોની જરૂરિયાતને ધ્યાને રાખી આયોજિત બે અલાયદા અને સુવિધાસભર વિભાગો.
            </p>
        </div>

        <div class="sankalp-grid">
            <!-- Vibhag-1 Card -->
            <div class="sankalp-card">
                <div class="sankalp-header">
                    <div class="badge badge-gold" style="position: absolute; top: 1.25rem; right: 1.5rem;">મેગા ઇવેન્ટ્સ</div>
                    <h3 style="color: #ffffff !important;">પ્રમુખ સેવા સંકલ્પ : વિભાગ-૧</h3>
                    <p>મોટા લગ્ન સમારંભો, સામાજિક સંમેલનો અને ભવ્ય ઉત્સવો માટે</p>
                </div>
                <div class="sankalp-body">
                    <ul class="facility-list">
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon"><i class="ri-landscape-line"></i></div>
                                <span>પાર્ટી પ્લોટ</span>
                            </div>
                            <span class="facility-capacity">૧૫૦૦ વ્યક્તિ માટે</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon"><i class="ri-hotel-line"></i></div>
                                <span>એ.સી. બેન્કવેટ હોલ</span>
                            </div>
                            <span class="facility-capacity">૬૦૦ વ્યક્તિ માટે</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon"><i class="ri-restaurant-line"></i></div>
                                <span>વિશાળ ભોજનાલય</span>
                            </div>
                            <span class="facility-capacity">૮૦૦ વ્યક્તિ માટે</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon"><i class="ri-hotel-bed-line"></i></div>
                                <span>અતિથિ ભવન (ડીલક્સ રૂમ)</span>
                            </div>
                            <span class="facility-capacity">૬૦ રૂમ</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon"><i class="ri-parking-box-line"></i></div>
                                <span>વિશાળ પાર્કિંગની વ્યવસ્થા</span>
                            </div>
                            <span class="facility-capacity">૪૦૦+ વાહનો</span>
                        </li>
                    </ul>
                </div>
                <div class="sankalp-footer">
                    <span style="font-size: 0.9rem; font-weight:700; color: var(--color-primary-dark);">વિભાગ-૧ પ્લોટ & હોલ</span>
                    <a href="{{ route('booking') }}?section=વિભાગ-૧" class="btn btn-primary" style="padding: 0.45rem 1.1rem; font-size: 0.85rem;">
                        બુકિંગ પૂછપરછ <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>

            <!-- Vibhag-2 Card -->
            <div class="sankalp-card">
                <div class="sankalp-header section-two">
                    <div class="badge badge-gold" style="position: absolute; top: 1.25rem; right: 1.5rem;">ખાસ આયોજન</div>
                    <h3 style="color: #ffffff !important;">વિશેષ સેવા સંકલ્પ : વિભાગ-૨</h3>
                    <p>નાના તથા મધ્યમ વર્ગના જ્ઞાતિજનો માટે વિશેષ સુવિધા</p>
                </div>
                <div class="sankalp-body">
                    <div class="sankalp-note">
                        <strong>સમાજ સંકલ્પ:</strong> આપણે સંકુલમાં નાના તથા મધ્યમ વર્ગના જ્ઞાતિજનોને સમૂહ લગ્નમાં જવાની જરૂરીયાત ન પડે અને સારા લોકેશન સાથે ઉચ્ચકક્ષાની સવલત મળી રહે તે માટે અલગથી વ્યવસ્થા કરવામાં આવશે.
                    </div>
                    <ul class="facility-list">
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-landscape-line"></i></div>
                                <span>પાર્ટી પ્લોટ</span>
                            </div>
                            <span class="facility-capacity">૫૦૦ વ્યક્તિ માટે</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-hotel-line"></i></div>
                                <span>બેન્કવેટ હોલ</span>
                            </div>
                            <span class="facility-capacity">૫૦૦ વ્યક્તિ માટે</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-restaurant-line"></i></div>
                                <span>ભોજનાલય</span>
                            </div>
                            <span class="facility-capacity">૫૦૦ વ્યક્તિ માટે</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-home-wifi-line"></i></div>
                                <span>ઉતારા માટે સુવિધા</span>
                            </div>
                            <span class="facility-capacity">૨૦ રૂમ</span>
                        </li>
                        <li class="facility-item">
                            <div class="facility-name">
                                <div class="facility-icon" style="background:#e0e7ff; color:#3730a3;"><i class="ri-parking-box-line"></i></div>
                                <span>વિશાળ પાર્કિંગની વ્યવસ્થા</span>
                            </div>
                            <span class="facility-capacity">૨૦૦+ વાહનો</span>
                        </li>
                    </ul>
                </div>
                <div class="sankalp-footer">
                    <span style="font-size: 0.9rem; font-weight:700; color: #1e3a8a;">વિભાગ-૨ સુવિધાઓ</span>
                    <a href="{{ route('booking') }}?section=વિભાગ-૨" class="btn btn-maroon" style="padding: 0.45rem 1.1rem; font-size: 0.85rem;">
                        બુકિંગ પૂછપરછ <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events Section -->
@if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
<section style="background: var(--color-bg-ivory); padding: clamp(2rem, 5vw, 3.5rem) 0; border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="badge badge-gold" style="margin-bottom: 0.4rem;">
                    <i class="ri-calendar-event-fill"></i> સમાજ ઉત્સવ કેલેન્ડર
                </span>
                <h2 style="font-size: clamp(1.3rem, 2.5vw, 1.85rem); font-weight: 700; color: var(--color-maroon); line-height: 1.3;">
                    આગામી સમાજ કાર્યક્રમો & ઉત્સવો
                </h2>
                <p style="font-size: 0.92rem; color: var(--color-text-muted); margin-top: 0.35rem;">
                    શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ દ્વારા આયોજિત પાવન સામાજિક આયોજન.
                </p>
            </div>
            <div>
                <a href="{{ route('events') }}" class="btn btn-outline-gold" style="font-size: 0.88rem; font-weight: 600;">
                    તમામ કાર્યક્રમો જુઓ <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
            @foreach($upcomingEvents as $evt)
                <div class="event-card-clickable"
                     onclick="openEventModal(this)"
                     data-title="{{ $evt->title }}"
                     data-category="{{ $evt->category }}"
                     data-date="{{ $evt->event_date->format('d M, Y') }}"
                     data-time="{{ $evt->event_time ?? '' }}"
                     data-venue="{{ $evt->venue }}"
                     data-description="{{ $evt->description }}"
                     data-organizer="{{ $evt->organizer }}"
                     data-contact="{{ $evt->contact_person }}"
                     data-image="{{ $evt->image_url ?? '' }}"
                     data-whatsapp="https://wa.me/919093390934?text={{ urlencode('જય સરદાર. મને ' . $evt->title . ' કાર્યક્રમ વિશે માહિતી મેળવવી છે.') }}"
                     style="background: #fff; border-radius: var(--radius-lg); border: 1.5px solid var(--color-border); overflow: hidden; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='var(--color-primary-light)';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow-sm)'; this.style.borderColor='var(--color-border)';">
                    @if($evt->image_url)
                        <div style="height: 180px; position: relative; overflow: hidden;">
                            <img src="{{ $evt->image_url }}" alt="{{ $evt->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <span class="badge badge-gold" style="position: absolute; top: 0.75rem; right: 0.75rem;">{{ $evt->category }}</span>
                        </div>
                    @else
                        <div style="height: 100px; background: var(--gradient-royal); display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem;">
                            <i class="ri-calendar-event-line" style="font-size: 2rem; color: #fef08a;"></i>
                            <span class="badge badge-gold">{{ $evt->category }}</span>
                        </div>
                    @endif
                    <div style="padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.82rem; color: var(--color-primary-light); font-weight: 600; margin-bottom: 0.5rem;">
                            <span><i class="ri-calendar-2-line"></i> {{ $evt->event_date->format('d M, Y') }}</span>
                            @if($evt->event_time)
                                <span><i class="ri-time-line"></i> {{ $evt->event_time }}</span>
                            @endif
                        </div>
                        <h3 style="font-size: 1.05rem; font-weight: 650; color: var(--color-maroon); line-height: 1.35; margin-bottom: 0.5rem;">
                            {{ $evt->title }}
                        </h3>
                        <div style="font-size: 0.82rem; color: var(--color-text-muted); margin-bottom: 0.85rem;">
                            <i class="ri-map-pin-line" style="color: var(--color-primary-light);"></i> {{ Str::limit($evt->venue, 45) }}
                        </div>
                        <div style="margin-top: auto; border-top: 1px dashed var(--color-border); padding-top: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.78rem; color: var(--color-primary-dark); font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i class="ri-eye-line"></i> સંપૂર્ણ વિગત જુઓ
                            </span>
                            <span style="font-size: 0.82rem; font-weight: 600; color: #15803d; background: #f0fdf4; border: 1px solid #86efac; border-radius: var(--radius-pill); padding: 0.2rem 0.65rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i class="ri-arrow-right-up-line"></i> વિગત
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Bhumidan Callout Banner -->
<section style="padding: 1rem 0 4rem;">
    <div class="container">
        <div class="bhumidan-banner">
            <div class="bhumidan-content">
                <div class="bhumidan-text">
                    <span class="badge badge-gold" style="font-size: 0.85rem; margin-bottom: 0.75rem;">
                        <i class="ri-hand-heart-fill"></i> પવિત્ર સહયોગ આહ્વાન
                    </span>
                    <h2 style="color: #ffffff !important;">એક ચોરસ વાર જગ્યાનું ભૂમિદાન <span style="color: #fef08a !important;">રૂા. ૨૫૦૦/-</span></h2>
                    <p style="font-size: 0.98rem; line-height: 1.74; color: rgba(255, 255, 255, 0.92); margin-bottom: 1.25rem;">
                        આપણા ભવ્ય સંકુલના પાયામાં આપના અને આપના પરિવાર તરફથી ૧ ચોરસ વાર કે તેથી વધુ ભૂમિદાન અર્પણ કરી અક્ષય પુણ્યના સહભાગી બનો. તમામ દાતાઓનું નામ સંકુલની કાયમી દાતા તક્તી (Wall of Honor) પર અંકિત કરવામાં આવશે.
                    </p>

                    <div class="bhumidan-stats-bar">
                        <div>
                            <div class="bhumidan-stat-val">{{ number_format($totalYards) }} વાર</div>
                            <div class="bhumidan-stat-lbl">કુલ નોંધાયેલ ભૂમિદાન</div>
                        </div>
                        <div>
                            <div class="bhumidan-stat-val">₹ {{ number_format($totalDonation) }}/-</div>
                            <div class="bhumidan-stat-lbl">એકત્રિત સહયોગ રાશિ</div>
                        </div>
                        <div>
                            <div class="bhumidan-stat-val">{{ $totalDonorsCount }} +</div>
                            <div class="bhumidan-stat-lbl">સન્માનિત દાતાઓ</div>
                        </div>
                    </div>
                </div>

                <div style="text-align: center;">
                    <div style="background: rgba(255,255,255,0.15); border: 2px dashed rgba(254, 240, 138, 0.6); padding: 2rem; border-radius: var(--radius-lg); backdrop-filter: blur(8px);">
                        <i class="ri-qr-code-line" style="font-size: 3.5rem; color: #fef08a;"></i>
                        <h4 style="color: #ffffff !important; font-size: 1.15rem; font-weight:650; margin: 0.75rem 0 0.5rem;">ઓનલાઇન સહયોગ QR</h4>
                        <p style="font-size: 0.88rem; color: #fef08a; margin-bottom: 1.25rem;">GPay / PhonePe / Paytm / BHIM</p>
                        <a href="{{ route('bhumidan') }}" class="btn btn-white" style="font-weight: 600; width: 100%;">
                            <i class="ri-bank-card-line"></i> દાન નોંધણી & બેંક ખાતું
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Donors Wall Preview -->
<section style="background: var(--color-surface); padding: 5rem 0;">
    <div class="container">
        <div class="section-header">
            <span class="section-pretitle"><i class="ri-award-fill"></i> ગૌરવવંતા દાતાશ્રીઓ</span>
            <h2 class="section-title">સન્માનિત ભૂમિદાતાઓ</h2>
            <p class="section-desc">સંકુલ નિર્માણ માટે અગ્રેસર રહેલા સમાજના પરોપકારી મહાનુભાવોની સૂચિ</p>
        </div>

        <div class="donors-grid">
            @foreach($featuredDonors as $donor)
                <div class="donor-card">
                    <div class="donor-top">
                        <div class="donor-name">{{ $donor->donor_name }}</div>
                        <span class="donor-yard-badge">{{ $donor->sq_yards }} વાર ભૂમિદાન</span>
                    </div>
                    <div class="donor-location">
                        <i class="ri-map-pin-line" style="color: var(--color-primary-light);"></i>
                        <span>ગામ: {{ $donor->village ?? 'જૂનાગઢ' }} ({{ $donor->city }})</span>
                    </div>
                    @if($donor->notes)
                        <div style="font-size: 0.82rem; color: #78716c; margin-bottom: 0.75rem; font-style: italic;">
                            "{{ $donor->notes }}"
                        </div>
                    @endif
                    <div class="donor-amount">
                        <span style="font-size: 0.85rem; color: var(--color-text-muted); font-weight:600;">સહયોગ રકમ:</span>
                        <span>₹ {{ number_format($donor->total_amount) }}/-</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="{{ route('bhumidan') }}" class="btn btn-maroon">
                તમામ દાતાઓની યાદી જુઓ <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>
</section>

<!-- Trustees & Leadership (Prominent leaders from the flyer) -->
<section class="section-padding">
    <div class="container">
        <div class="section-header">
            <span class="section-pretitle"><i class="ri-team-line"></i> સમાજ નેતૃત્વ</span>
            <h2 class="section-title">ટ્રસ્ટી મંડળ & પ્રેરક આગેવાનો</h2>
            <p class="section-desc">જેમના માર્ગદર્શન અને અથાગ પ્રયાસોથી આ ગૌરવવંતો સંકલ્પ સાકાર થઈ રહ્યો છે.</p>
        </div>

        <div class="trustees-grid">
            @foreach($trustees as $trustee)
                <div class="trustee-card">
                    <div class="trustee-avatar">
                        <i class="ri-user-star-line"></i>
                    </div>
                    <div class="trustee-info">
                        <h4 class="trustee-name">{{ $trustee->name }}</h4>
                        <div class="trustee-designation">{{ $trustee->designation }}</div>
                        @if($trustee->company_or_business)
                            <div class="trustee-business">{{ $trustee->company_or_business }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="{{ route('trustees') }}" class="btn btn-outline-gold">
                સમગ્ર કારોબારી સમિતિ પરિચય <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>
</section>

<!-- Gallery & Instagram Reels Integration -->
<section style="background: #14110f; color: #fff; padding: 5rem 0;">
    <div class="container">
        <div class="section-header">
            <span class="section-pretitle" style="color: var(--color-gold);"><i class="ri-camera-lens-fill"></i> ફોટો & વિડીયો ઝાંખી</span>
            <h2 class="section-title" style="color: #fff;">સંકલ્પ યાત્રા & તાજા કાર્યક્રમો</h2>
            <p class="section-desc" style="color: #a8a29e;">
                શ્રી લેઉવા પટેલ ટ્રસ્ટ જૂનાગઢ દ્વારા આયોજિત સંમેલનો અને સોશિયલ મીડિયા રીલ્સ
            </p>
        </div>

        <div class="gallery-grid">
            @foreach($galleryItems as $item)
                <div class="gallery-card">
                    <div class="gallery-media">
                        <img src="{{ $item->thumbnail_url ?: $item->media_url }}" alt="{{ $item->title }}" loading="lazy">
                        @if($item->media_type === 'instagram_reel')
                            <div class="gallery-type-badge" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                                <i class="ri-instagram-line"></i> Reel
                            </div>
                        @else
                            <div class="gallery-type-badge">
                                <i class="ri-image-line"></i> ફોટો
                            </div>
                        @endif
                    </div>
                    <div class="gallery-content">
                        <h4 class="gallery-title">{{ $item->title }}</h4>
                        @if($item->caption)
                            <p class="gallery-caption">{{ $item->caption }}</p>
                        @endif
                        @if($item->media_type === 'instagram_reel')
                            <div style="margin-top: 0.75rem;">
                                <a href="https://www.instagram.com/reel/DeaWR2ft4JS/" target="_blank" style="font-size: 0.82rem; color: #fef08a; font-weight:700;">
                                    ઇન્સ્ટાગ્રામ પર રીલ જુઓ <i class="ri-external-link-line"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('gallery') }}" class="btn btn-primary">
                તમામ ફોટો & વિડીયો ગેલેરી જુઓ <i class="ri-arrow-right-line"></i>
            </a>
        </div>
    </div>
</section>

<!-- Location & Direct Inquiry -->
<section class="section-padding">
    <div class="container contact-grid">
        <div class="contact-info-card">
            <span class="badge badge-gold" style="margin-bottom: 0.75rem;">સંકુલ સ્થળ નિર્દેશ</span>
            <h3>શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ</h3>
            <p style="font-size: 0.95rem; line-height: 1.74; opacity: 0.92;">
                ગિરનારની પવિત્ર ગોદમાં, પ્રકૃતિની વચ્ચે સોનરખ નદીના કાંઠે આકાર લઈ રહેલું ગૌરવશાળી સંકુલ.
            </p>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-map-pin-2-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 0.95rem; font-weight: 600;">મુખ્ય સંકુલ સરનામું:</strong>
                    <span style="font-size: 0.9rem; line-height: 1.6;">જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, સોનરખ નદીના કાંઠે, જૂનાગઢ, ગુજરાત.</span>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-phone-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 0.92rem; font-weight: 600;">સત્તાવાર હેલ્પલાઇન:</strong>
                    <a href="tel:9093390934" style="color: #fef08a; font-weight:600; font-family: var(--font-latin); font-size: 1.1rem;">909 33 909 34</a>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-instagram-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1rem;">ઇન્સ્ટાગ્રામ પેજ:</strong>
                    <a href="https://www.instagram.com/explore/locations/265511100633813/khodaldham-yuva-samiti-junagadh/" target="_blank" style="color: #fef08a; font-size: 0.92rem;">
                        @leuvapateltrust_junagadh
                    </a>
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <a href="https://wa.me/919093390934" target="_blank" class="btn btn-white" style="width: 100%; font-weight: 600;">
                    <i class="ri-whatsapp-fill" style="color: #25d366;"></i> વોટ્સએપ પર લોકેશન મેળવો
                </a>
            </div>
        </div>

        <!-- Quick Inquiry Form -->
        <div class="form-card">
            <h3 style="font-size: 1.35rem; color: var(--color-maroon); font-weight:700; margin-bottom: 0.35rem;">
                બુકિંગ અથવા સામાન્ય પૂછપરછ
            </h3>
            <p style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">
                નીચેની વિગતો ભરીને મોકલો, કાર્યાલય દ્વારા આપનો તુરંત સંપર્ક કરવામાં આવશે.
            </p>

            <form action="{{ route('contact.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">આપનું પૂરું નામ *</label>
                        <input type="text" name="name" class="form-control" placeholder="નામ લખો" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">મોબાઈલ નંબર *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="૧૦ અંકનો નંબર" autocomplete="off" required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">વિષય / પૂછપરછ પ્રકાર *</label>
                        <select name="subject" class="form-control" autocomplete="off" required>
                            <option value="ભૂમિદાન અંગે માહિતી">ભૂમિદાન યોજના અંગે માહિતી</option>
                            <option value="વિભાગ-૧ હોલ/પ્લોટ બુકિંગ">વિભાગ-૧ હોલ/પ્લોટ બુકિંગ</option>
                            <option value="વિભાગ-૨ મધ્યમ વર્ગ સુવિધા">વિભાગ-૨ મધ્યમ વર્ગ સુવિધા</option>
                            <option value="અતિથિ ભવન રૂમ બુકિંગ">અતિથિ ભવન રૂમ બુકિંગ</option>
                            <option value="અન્ય પ્રશ્ન">અન્ય પ્રશ્ન / સૂચન</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">સંદેશ / પ્રશ્ન વિગત *</label>
                        <textarea name="message" rows="3" class="form-control" placeholder="તમારી પૂછપરછ વિગતવાર અહીં લખો..." autocomplete="off" required></textarea>
                    </div>

                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.8rem;">
                            <i class="ri-send-plane-fill"></i> સંદેશો મોકલો
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Event Details Modal Dialog -->
<div id="eventDetailsModal" class="event-modal-backdrop" onclick="if(event.target === this) closeEventModal()" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); z-index: 99999; backdrop-filter: blur(5px); align-items: center; justify-content: center; padding: 1rem; overflow-y: auto;">
    <div class="event-modal-dialog" style="background: #ffffff; width: 100%; max-width: 640px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden; margin: auto; animation: eventModalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1); border: 1px solid var(--color-border); max-height: 90vh; display: flex; flex-direction: column;">
        <!-- Header Banner -->
        <div id="modalBannerWrap" style="height: 200px; position: relative; background: var(--gradient-royal); overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
            <img id="modalImage" src="" alt="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
            <div id="modalFallbackIcon" style="text-align: center; color: #fef08a;">
                <i class="ri-calendar-event-fill" style="font-size: 3.5rem;"></i>
            </div>
            <span id="modalCategory" class="badge badge-gold" style="position: absolute; top: 1rem; left: 1rem; font-size: 0.82rem; box-shadow: var(--shadow-sm);"></span>
            <button type="button" onclick="closeEventModal()" aria-label="Close" style="position: absolute; top: 0.85rem; right: 0.85rem; width: 34px; height: 34px; border-radius: 50%; background: rgba(0,0,0,0.55); color: #ffffff; border: none; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.85)'" onmouseout="this.style.background='rgba(0,0,0,0.55)'">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <!-- Content Area -->
        <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1;">
            <h2 id="modalTitle" style="font-size: 1.3rem; font-weight: 750; color: var(--color-maroon); margin-bottom: 1rem; line-height: 1.35;"></h2>

            <!-- Quick Details Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem; background: #fafaf9; padding: 1rem; border-radius: 12px; border: 1px solid #f0eeeb;">
                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-calendar-2-fill" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">તારીખ & સમય</div>
                        <div style="font-weight: 650; color: #1f2937; font-size: 0.88rem;"><span id="modalDate"></span> <span id="modalTime" style="color: #4b5563; font-weight: 500;"></span></div>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-map-pin-2-fill" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">સ્થળ (Venue)</div>
                        <div id="modalVenue" style="font-weight: 600; color: #1f2937; font-size: 0.88rem; line-height: 1.4;"></div>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-building-line" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">આયોજક</div>
                        <div id="modalOrganizer" style="font-weight: 600; color: #1f2937; font-size: 0.88rem;"></div>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-phone-fill" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">સંપર્ક / ઇન્ક્વાયરી</div>
                        <div id="modalContact" style="font-weight: 600; color: #1f2937; font-size: 0.88rem;"></div>
                    </div>
                </div>
            </div>

            <!-- Full Description -->
            <div style="margin-bottom: 0.5rem;">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: #374151; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.35rem;">
                    <i class="ri-information-fill" style="color: var(--color-primary-light);"></i> કાર્યક્રમ પરિચય & વિગત
                </h4>
                <div id="modalDescription" style="font-size: 0.9rem; color: #4b5563; line-height: 1.7; white-space: pre-line; background: #ffffff; padding: 0.85rem 1rem; border-radius: 8px; border: 1.5px dashed var(--color-border);"></div>
            </div>
        </div>

        <!-- Footer -->
        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem; padding: 1rem 1.5rem; background: #f9fafb; border-top: 1px solid #e5e7eb; flex-shrink: 0;">
            <button type="button" onclick="closeEventModal()" class="btn btn-outline" style="font-size: 0.85rem; padding: 0.45rem 1.25rem;">
                બંધ કરો
            </button>
            <a id="modalWhatsAppBtn" href="#" target="_blank" class="btn" style="background: #15803d; color: #ffffff; font-size: 0.85rem; padding: 0.45rem 1.25rem; display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none; border-radius: var(--radius-md);">
                <i class="ri-whatsapp-line" style="font-size: 1.1rem;"></i> WhatsApp પર પૂછપરછ
            </a>
        </div>
    </div>
</div>

<style>
@keyframes eventModalPop {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
function openEventModal(card) {
    const modal = document.getElementById('eventDetailsModal');
    if (!modal) return;

    document.getElementById('modalTitle').textContent = card.dataset.title || '';
    document.getElementById('modalCategory').textContent = card.dataset.category || 'સમાજ ઉત્સવ';
    document.getElementById('modalDate').textContent = card.dataset.date || '';
    document.getElementById('modalTime').textContent = card.dataset.time ? (' | ' + card.dataset.time) : '';
    document.getElementById('modalVenue').textContent = card.dataset.venue || 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ, જૂનાગઢ';
    document.getElementById('modalOrganizer').textContent = card.dataset.organizer || 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ';
    document.getElementById('modalContact').textContent = card.dataset.contact || 'ટ્રસ્ટ કાર્યાલય';
    document.getElementById('modalDescription').textContent = card.dataset.description || 'કાર્યક્રમની વધુ માહિતી કાર્યાલય ખાતેથી મળી રહેશે.';
    document.getElementById('modalWhatsAppBtn').href = card.dataset.whatsapp || '#';

    const img = document.getElementById('modalImage');
    const fallback = document.getElementById('modalFallbackIcon');
    if (card.dataset.image && card.dataset.image.trim() !== '') {
        img.src = card.dataset.image;
        img.style.display = 'block';
        fallback.style.display = 'none';
    } else {
        img.style.display = 'none';
        fallback.style.display = 'block';
    }

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEventModal() {
    const modal = document.getElementById('eventDetailsModal');
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventModal();
    }
});
</script>

@endsection

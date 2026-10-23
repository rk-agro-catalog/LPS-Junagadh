@extends('layouts.app')

@section('title', 'મુખ્ય પૃષ્ઠ | શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ (LPS Junagadh)')

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-left">
            <div class="hero-tagline">
                <i class="ri-fire-fill" style="color: #f59e0b;"></i>
                <span>શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ પ્રસ્તુત</span>
            </div>
            <h1 class="hero-title">
                સમાજ ગૌરવ અને સેવા સંકલ્પનું <span>ભવ્ય સંકુલ નિર્માણ</span>
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
                    <span class="hero-card-badge">પવિત્ર ભૂમિદાન યોજના</span>
                    <h3 style="margin-top: 0.5rem;">એક ચોરસ વાર ભૂમિદાન</h3>
                    <p style="font-size: 0.9rem; color: var(--color-text-muted); margin-top: 0.2rem;">
                        માત્ર રૂા. ૨૫૦૦/- માં આપ પણ સંકુલ નિર્માણમાં ભાગીદાર બનો
                    </p>
                </div>

                <div style="margin-bottom: 0.85rem;">
                    <label style="font-size: 0.85rem; font-weight:700; color: var(--color-text-muted);">વાર પસંદ કરો:</label>
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

                <div class="calc-result-box">
                    <div style="font-size: 0.85rem; font-weight: 700; color: #854d0e; text-transform: uppercase;">કુલ સહયોગ રાશિ</div>
                    <div class="calc-amount" id="calcAmountDisplay">₹ 2,500/-</div>
                    <div style="font-size: 0.78rem; color: #a16207; margin-top: 0.25rem;">(૧ ચોરસ વાર જગ્યાનું ભૂમિદાન)</div>
                </div>

                <form action="{{ route('bhumidan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sq_yards" id="formSqYards" value="1">
                    <input type="hidden" name="payment_method" value="UPI">
                    <input type="hidden" name="city" value="જૂનાગઢ">
                    
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1rem;">
                        <input type="text" name="donor_name" class="form-control" placeholder="તમારું પૂરું નામ (દાતાશ્રી)" required>
                        <input type="tel" name="phone" class="form-control" placeholder="મોબાઈલ નંબર" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1rem; padding: 0.75rem;">
                        <i class="ri-check-double-line"></i> ભૂમિદાન સંકલ્પ નોંધાવો
                    </button>
                </form>
                
                <div style="text-align: center; margin-top: 0.75rem;">
                    <a href="{{ route('bhumidan') }}" style="font-size: 0.82rem; color: var(--color-primary-dark); font-weight: 700; text-decoration: underline;">
                        સંપૂર્ણ દાતા યાદી & બેંક વિગતો જુઓ <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
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
                    <h3>પ્રમુખ સેવા સંકલ્પ : વિભાગ-૧</h3>
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
                    <h3>વિશેષ સેવા સંકલ્પ : વિભાગ-૨</h3>
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

<!-- Bhumidan Callout Banner -->
<section style="padding: 1rem 0 4rem;">
    <div class="container">
        <div class="bhumidan-banner">
            <div class="bhumidan-content">
                <div class="bhumidan-text">
                    <span class="badge badge-gold" style="font-size: 0.85rem; margin-bottom: 0.75rem;">
                        <i class="ri-hand-heart-fill"></i> પવિત્ર સહયોગ આહ્વાન
                    </span>
                    <h2>એક ચોરસ વાર જગ્યાનું ભૂમિદાન <span>રૂા. ૨૫૦૦/-</span></h2>
                    <p style="font-size: 1.1rem; line-height: 1.8; color: #f5f5f4;">
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
                        <h4 style="font-size: 1.35rem; font-weight:800; margin: 0.75rem 0 0.5rem;">ઓનલાઇન સહયોગ QR</h4>
                        <p style="font-size: 0.9rem; color: #fef08a; margin-bottom: 1.25rem;">GPay / PhonePe / Paytm / BHIM</p>
                        <a href="{{ route('bhumidan') }}" class="btn btn-white" style="font-weight: 800; width: 100%;">
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
                        <img src="{{ $item->media_url }}" alt="{{ $item->title }}" loading="lazy">
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
            <p style="font-size: 1.05rem; line-height: 1.7; opacity: 0.95;">
                ગિરનારની પવિત્ર ગોદમાં, પ્રકૃતિની વચ્ચે સોનરખ નદીના કાંઠે આકાર લઈ રહેલું ગૌરવશાળી સંકુલ.
            </p>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-map-pin-2-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1.05rem;">મુખ્ય સંકુલ સરનામું:</strong>
                    <span>જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, સોનરખ નદીના કાંઠે, જૂનાગઢ, ગુજરાત.</span>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-phone-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1.05rem;">સત્તાવાર હેલ્પલાઇન:</strong>
                    <a href="tel:9093390934" style="color: #fef08a; font-weight:800; font-size: 1.15rem;">909 33 909 34</a>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-instagram-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1.05rem;">ઇન્સ્ટાગ્રામ પેજ:</strong>
                    <a href="https://www.instagram.com/explore/locations/265511100633813/khodaldham-yuva-samiti-junagadh/" target="_blank" style="color: #fef08a;">
                        @leuvapateltrust_junagadh
                    </a>
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <a href="https://wa.me/919093390934" target="_blank" class="btn btn-white" style="width: 100%;">
                    <i class="ri-whatsapp-fill" style="color: #25d366;"></i> વોટ્સએપ પર લોકેશન મેળવો
                </a>
            </div>
        </div>

        <!-- Quick Inquiry Form -->
        <div class="form-card">
            <h3 style="font-size: 1.5rem; color: var(--color-maroon); font-weight:800; margin-bottom: 0.35rem;">
                બુકિંગ અથવા સામાન્ય પૂછપરછ
            </h3>
            <p style="font-size: 0.9rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">
                નીચેની વિગતો ભરીને મોકલો, કાર્યાલય દ્વારા આપનો તુરંત સંપર્ક કરવામાં આવશે.
            </p>

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">આપનું પૂરું નામ *</label>
                        <input type="text" name="name" class="form-control" placeholder="નામ લખો" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">મોબાઈલ નંબર *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="૧૦ અંકનો નંબર" required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">વિષય / પૂછપરછ પ્રકાર *</label>
                        <select name="subject" class="form-control" required>
                            <option value="ભૂમિદાન અંગે માહિતી">ભૂમિદાન યોજના અંગે માહિતી</option>
                            <option value="વિભાગ-૧ હોલ/પ્લોટ બુકિંગ">વિભાગ-૧ હોલ/પ્લોટ બુકિંગ</option>
                            <option value="વિભાગ-૨ મધ્યમ વર્ગ સુવિધા">વિભાગ-૨ મધ્યમ વર્ગ સુવિધા</option>
                            <option value="અતિથિ ભવન રૂમ બુકિંગ">અતિથિ ભવન રૂમ બુકિંગ</option>
                            <option value="અન્ય પ્રશ્ન">અન્ય પ્રશ્ન / સૂચન</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">સંદેશ / પ્રશ્ન વિગત *</label>
                        <textarea name="message" rows="3" class="form-control" placeholder="તમારી પૂછપરછ વિગતવાર અહીં લખો..." required></textarea>
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

@endsection

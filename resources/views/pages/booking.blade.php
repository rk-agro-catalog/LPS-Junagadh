@extends('layouts.app')

@section('title', 'પાર્ટી પ્લોટ & હોલ બુકિંગ પૂછપરછ | LPS Junagadh')

@section('content')

<!-- Banner Header -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;">
            <i class="ri-calendar-check-fill"></i> હોલ & પ્લોટ બુકિંગ
        </span>
        <h1>સંકુલ સુવિધાઓ બુકિંગ પૂછપરછ</h1>
        <p>
            લગ્ન પ્રસંગ, સગાઈ, સામાજિક સંમેલન કે અતિથિ ભવન રૂમ માટે તારીખ અને ઉપલબ્ધતા ચકાસો.
        </p>
    </div>
</div>

<div class="container section-padding">
    <div class="page-split-grid">
        <!-- Left: Form -->
        <div class="form-card">
            <h2 style="font-size: clamp(1.2rem, 2.5vw, 1.45rem); color: var(--color-maroon); font-weight: 650; margin-bottom: 0.4rem;">
                ઓનલાઇન બુકિંગ ઇન્ક્વાયરી ફોર્મ
            </h2>
            <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: var(--color-text-muted); margin-bottom: 1.25rem;">
                તમારા પ્રસંગની વિગતો નીચે દર્શાવો. ટ્રસ્ટ કાર્યાલય દ્વારા તુરંત તારીખ કન્ફર્મ કરવામાં આવશે.
            </p>

            <form action="{{ route('booking.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">અરજદારનું પૂરું નામ *</label>
                        <input type="text" name="applicant_name" class="form-control" placeholder="નામ લખો..." required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">મોબાઈલ નંબર *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="૧૦ અંકનો મોબાઈલ નંબર" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">ઈમેઈલ એડ્રેસ (વૈકલ્પિક)</label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">ગામ / શહેર *</label>
                        <input type="text" name="city_or_village" class="form-control" placeholder="દા.ત. જૂનાગઢ, જેતપુર..." required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">સંકુલ વિભાગ પસંદ કરો *</label>
                        <select name="section_type" id="bookingSectionSelect" class="form-control" required>
                            <option value="">-- વિભાગ પસંદ કરો --</option>
                            <option value="વિભાગ-૧" {{ request('section') == 'વિભાગ-૧' ? 'selected' : '' }}>વિભાગ-૧ (૧૫૦૦ વ્યક્તિ ક્ષમતા)</option>
                            <option value="વિભાગ-૨" {{ request('section') == 'વિભાગ-૨' ? 'selected' : '' }}>વિભાગ-૨ (મધ્યમ વર્ગ - ૫૦૦ વ્યક્તિ)</option>
                            <option value="અતિથિ ભવન" {{ request('section') == 'અતિથિ ભવન' ? 'selected' : '' }}>માત્ર અતિથિ ભવન (રૂમ ઉતારા)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">સુવિધા પ્રકાર *</label>
                        <select name="facility_name" id="bookingFacilitySelect" class="form-control" required>
                            <option value="">-- સુવિધા પસંદ કરો --</option>
                            <option value="પાર્ટી પ્લોટ (૧૫૦૦ વ્યક્તિ માટે)">પાર્ટી પ્લોટ (૧૫૦૦ વ્યક્તિ માટે)</option>
                            <option value="બેન્કવેટ હોલ (૬૦૦ વ્યક્તિ માટે)">બેન્કવેટ હોલ (૬૦૦ વ્યક્તિ માટે)</option>
                            <option value="વિભાગ-૧ સમગ્ર સંકુલ">વિભાગ-૧ સમગ્ર સંકુલ (પ્લોટ + હોલ + ભોજનાલય)</option>
                            <option value="વિભાગ-૨ સમગ્ર સંકુલ (૫૦૦ વ્યક્તિ)">વિભાગ-૨ સમગ્ર સંકુલ (૫૦૦ વ્યક્તિ)</option>
                            <option value="અતિથિ ભવન રૂમ">અતિથિ ભવન રૂમ</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">પ્રસંગ પ્રકાર *</label>
                        <select name="event_type" class="form-control" required>
                            <option value="લગ્ન પ્રસંગ">લગ્ન પ્રસંગ</option>
                            <option value="સગાઈ / વાગ્દાન">સગાઈ / વાગ્દાન</option>
                            <option value="શ્રીમંત પ્રસંગ">શ્રીમંત પ્રસંગ</option>
                            <option value="સામાજિક મેળાવડો / સ્નેહમિલન">સામાજિક મેળાવડો / સ્નેહમિલન</option>
                            <option value="સેમિનાર / સંમેલન">સેમિનાર / સંમેલન</option>
                            <option value="અતિથિ ઉતારો (યાત્રાળુ)">અતિથિ ઉતારો (યાત્રાળુ)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">પ્રસંગ તારીખ (Event Date) *</label>
                        <input type="date" name="event_date" class="form-control" min="{{ date('Y-m-d') }}" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">અંદાજિત મહેમાનોની સંખ્યા *</label>
                        <input type="number" name="approx_guests" class="form-control" placeholder="દા.ત. ૫૦૦, ૧૦૦૦" min="10" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label class="form-label">જરૂરી રૂમ સંખ્યા</label>
                        <input type="number" name="required_rooms" class="form-control" placeholder="રૂમની સંખ્યા" min="0" value="0" autocomplete="off">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">વિશેષ જરૂરિયાત અથવા નોંધ</label>
                        <textarea name="user_notes" rows="3" class="form-control" placeholder="સમય, સાઉન્ડ, ભોજન તૈયારી વગેરે વિશેષ વિગત..."></textarea>
                    </div>

                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.05rem; padding: 0.85rem;">
                            <i class="ri-check-line"></i> બુકિંગ ઇન્ક્વાયરી સબમિટ કરો
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right: Rules & Helpline Card -->
        <div>
            <div style="background: var(--color-surface); border: 1.5px solid var(--color-border); border-radius: var(--radius-lg); padding: 1.75rem; margin-bottom: 1.75rem;">
                <h4 style="font-size: 1.15rem; font-weight: 650; color: var(--color-maroon); margin-bottom: 0.85rem;">
                    <i class="ri-information-line"></i> બુકિંગ નિયમો & માર્ગદર્શિકા
                </h4>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.88rem; color: var(--color-text-muted);">
                    <li style="display: flex; gap: 0.5rem;">
                        <i class="ri-checkbox-circle-fill" style="color: var(--color-accent-green);"></i>
                        <span>બુકિંગની પ્રાથમિકતા લેઉવા પટેલ સમાજના જ્ઞાતિજનો માટે રહેશે.</span>
                    </li>
                    <li style="display: flex; gap: 0.5rem;">
                        <i class="ri-checkbox-circle-fill" style="color: var(--color-accent-green);"></i>
                        <span>વિભાગ-૨ ખાસ કરીને નાના અને મધ્યમ વર્ગના પરિવારો માટે રાહતદરે ઉપલબ્ધ કરાવવામાં આવશે.</span>
                    </li>
                    <li style="display: flex; gap: 0.5rem;">
                        <i class="ri-checkbox-circle-fill" style="color: var(--color-accent-green);"></i>
                        <span>તારીખ કન્ફર્મ કરવા માટે ટ્રસ્ટ કાર્યાલયે સંપર્ક કરી નિયત ડિપોઝિટ ભરવાની રહેશે.</span>
                    </li>
                    <li style="display: flex; gap: 0.5rem;">
                        <i class="ri-checkbox-circle-fill" style="color: var(--color-accent-green);"></i>
                        <span>સ્વચ્છતા અને સંકુલની ગરિમા જાળવવી અનિવાર્ય રહેશે.</span>
                    </li>
                </ul>
            </div>

            <div style="background: var(--gradient-royal); color: #fff; border-radius: var(--radius-lg); padding: 2rem; text-align: center; box-shadow: var(--shadow-lg);">
                <i class="ri-customer-service-2-fill" style="font-size: 2.8rem; color: #fef08a;"></i>
                <h4 style="font-size: 1.25rem; font-weight: 650; margin: 0.65rem 0 0.4rem; color: #ffffff !important;">
                    તાત્કાલિક બુકિંગ સહાય
                </h4>
                <p style="font-size: 0.9rem; color: rgba(255, 255, 255, 0.92) !important; margin-bottom: 1.25rem;">
                    ફોન પર સીધી તારીખ ચકાસવા માટે અમારી હેલ્પલાઇન પર સંપર્ક કરો:
                </p>
                <a href="tel:9093390934" class="btn btn-white" style="font-size: 1.15rem; font-weight: 600; font-family: var(--font-latin); width: 100%; margin-bottom: 0.75rem;">
                    <i class="ri-phone-fill"></i> 909 33 909 34
                </a>
                <a href="https://wa.me/919093390934?text={{ urlencode('જય સરદાર, મારે સંકુલ બુકિંગ માટે તારીખ ઉપલબ્ધતા જાણવી છે.') }}" target="_blank" class="btn btn-outline-gold" style="width: 100%; font-size: 0.95rem; border-color: #fef08a; color: #fff;">
                    <i class="ri-whatsapp-line"></i> વોટ્સએપ પર પૂછપરછ
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

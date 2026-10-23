@extends('layouts.app')

@section('title', 'એક ચોરસ વાર ભૂમિદાન યોજના (રૂા. ૨૫૦૦/-) | LPS Junagadh')

@section('content')

<!-- Header Banner -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;">
            <i class="ri-hand-heart-fill"></i> પવિત્ર સંકલ્પ
        </span>
        <h1>એક ચોરસ વાર જગ્યાનું ભૂમિદાન રૂા. ૨૫૦૦/-</h1>
        <p>
            શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ સંકુલ નિર્માણમાં આપનો યથાશક્તિ સહયોગ અર્પણ કરો.
        </p>
    </div>
</div>

<div class="container section-padding">

    <!-- Overview Stats Counter -->
    <div class="stats-grid-3">
        <div class="stat-box">
            <div class="stat-box-val" style="color: var(--color-primary-light);">{{ number_format($totalYards) }}</div>
            <div class="stat-box-lbl">કુલ નોંધાયેલ ચોરસ વાર</div>
        </div>

        <div class="stat-box">
            <div class="stat-box-val" style="color: var(--color-maroon);">₹ {{ number_format($totalDonation) }}/-</div>
            <div class="stat-box-lbl">કુલ એકત્રિત સહયોગ રાશિ</div>
        </div>

        <div class="stat-box">
            <div class="stat-box-val" style="color: var(--color-accent-green);">{{ $totalDonors }}</div>
            <div class="stat-box-lbl">કુલ નોંધાયેલ દાતાશ્રીઓ</div>
        </div>
    </div>

    <!-- Main Grid: Form & Bank/QR Details -->
    <div class="page-split-grid">
        <!-- Left: Online Pledge Form with Live Calculator -->
        <div class="form-card">
            <h2 style="font-size: clamp(1.25rem, 3vw, 1.55rem); color: var(--color-maroon); font-weight:800; margin-bottom: 0.35rem;">
                ઓનલાઇન ભૂમિદાન સંકલ્પ ફોર્મ
            </h2>
            <p style="font-size: clamp(0.85rem, 2vw, 0.95rem); color: var(--color-text-muted); margin-bottom: 1.25rem;">
                આપ જેટલા ચોરસ વાર ભૂમિદાન આપવા માંગતા હોવ તે વાર પસંદ કરો. (૧ ચોરસ વાર = રૂા. ૨,૫૦૦/-)
            </p>

            <!-- Pill selection for quick amounts -->
            <div style="margin-bottom: 1rem;">
                <label class="form-label">વાર પસંદ કરો (અથવા નીચે જાતે લખો):</label>
                <div class="calc-pill-group" style="margin-top: 0.35rem;">
                    <button type="button" class="calc-pill-btn active" data-yards="1">૧ વાર (₹૨.૫K)</button>
                    <button type="button" class="calc-pill-btn" data-yards="2">૨ વાર (₹૫K)</button>
                    <button type="button" class="calc-pill-btn" data-yards="5">૫ વાર (₹૧૨.૫K)</button>
                    <button type="button" class="calc-pill-btn" data-yards="10">૧૦ વાર (₹૨૫K)</button>
                    <button type="button" class="calc-pill-btn" data-yards="20">૨૦ વાર (₹૫૦K)</button>
                    <button type="button" class="calc-pill-btn" data-yards="40">૪૦ વાર (₹૧L)</button>
                    <button type="button" class="calc-pill-btn" data-yards="50">૫૦ વાર (₹૧.૨૫L)</button>
                    <button type="button" class="calc-pill-btn" data-yards="100">૧૦૦ વાર (₹૨.૫L)</button>
                </div>
            </div>

            <!-- Live Calculation Display -->
            <div class="calc-result-box" style="margin-bottom: 1.25rem;">
                <div style="font-size: 0.82rem; font-weight: 700; color: #854d0e;">કુલ સહયોગ રાશિ :</div>
                <div class="calc-amount" id="calcAmountDisplay">₹ 2,500/-</div>
            </div>

            <form action="{{ route('bhumidan.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">દાતાશ્રીનું પૂરું નામ *</label>
                        <input type="text" name="donor_name" class="form-control" placeholder="શ્રી / શ્રીમતી ..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">મોબાઈલ નંબર *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="૧૦ અંકનો નંબર" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">મૂળ ગામ</label>
                        <input type="text" name="village" class="form-control" placeholder="દા.ત. વંથલી, કેશોદ, વિસાવદર...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">હાલનું શહેર *</label>
                        <input type="text" name="city" class="form-control" value="જૂનાગઢ" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ચોરસ વાર સંખ્યા *</label>
                        <input type="number" id="calcYards" name="sq_yards" class="form-control" value="1" min="1" max="1000" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">ચુકવણી માધ્યમ *</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="UPI">UPI (GPay / PhonePe / Paytm / QR)</option>
                            <option value="Bank Transfer">Bank Transfer (NEFT / RTGS)</option>
                            <option value="Cheque">ચેક (Cheque)</option>
                            <option value="Cash">રોકડ (ટ્રસ્ટ કાર્યાલયે)</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">ટ્રાન્ઝેક્શન / રેફરન્સ નંબર (જો ઓનલાઇન કરેલ હોય તો)</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="UPI Ref ID / UTR નંબર...">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">સંકલ્પ સંદેશ / નોંધ</label>
                        <textarea name="notes" rows="2" class="form-control" placeholder="દા.ત. પરિવાર વતી શુભ સંકલ્પ..."></textarea>
                    </div>

                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1rem; padding: 0.75rem;">
                            <i class="ri-check-line"></i> ભૂમિદાન સંકલ્પ સબમિટ કરો & પહોંચ મેળવો
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right: Official Bank Account & UPI QR Details -->
        <div>
            <div style="background: var(--gradient-royal); color: #fff; padding: clamp(1.25rem, 3vw, 1.75rem); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); margin-bottom: 1.5rem;">
                <h3 style="font-size: clamp(1.1rem, 2.5vw, 1.25rem); font-weight: 800; margin-bottom: 0.4rem; color: #fef08a;">
                    <i class="ri-bank-line"></i> સત્તાવાર બેંક એકાઉન્ટ
                </h3>
                <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 1rem;">
                    ટ્રસ્ટના અધિકૃત બેંક ખાતામાં સીધા RTGS / NEFT / ચેક જમા કરાવી શકાય છે.
                </p>

                <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: var(--radius-md); font-size: 0.88rem; line-height: 1.7; backdrop-filter: blur(6px);">
                    <div><strong>ખાતાનું નામ:</strong><br>શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ</div>
                    <div style="margin-top: 0.4rem;"><strong>બેંક:</strong> State Bank of India (SBI)</div>
                    <div><strong>ખાતા નંબર:</strong> <span style="color: #fef08a; font-weight:800;">909339093401</span></div>
                    <div><strong>IFSC કોડ:</strong> SBIN0001234</div>
                    <div><strong>શાખા:</strong> જૂનાગઢ મેઈન બ્રાન્ચ</div>
                </div>
            </div>

            <!-- UPI QR Code Block -->
            <div style="background: #fff; border: 2px dashed var(--color-gold); border-radius: var(--radius-lg); padding: clamp(1.25rem, 3vw, 1.75rem); text-align: center; box-shadow: var(--shadow-sm);">
                <span class="badge badge-gold" style="margin-bottom: 0.5rem;">ડાયરેક્ટ UPI પેમેન્ટ</span>
                <h3 style="font-size: clamp(1.05rem, 2.5vw, 1.2rem); font-weight:800; color: var(--color-maroon);">
                    કોઈપણ UPI એપથી સ્કેન કરો
                </h3>

                <div style="margin: 1rem auto; width: 150px; height: 150px; background: #fff; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); padding: 8px; display: flex; align-items: center; justify-content: center;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=upi%3A%2F%2Fpay%3Fpa%3D9093390934%40sbi%26pn%3DShree%2520Samast%2520Leuva%2520Patel%2520Samaj%2520Trust%26cu%3DINR" alt="UPI QR Code" style="width: 134px; height: 134px;">
                </div>

                <div style="font-weight: 700; color: var(--color-text-main); font-size: 0.9rem;">
                    UPI ID: <span style="color: var(--color-primary-light);">9093390934@sbi</span>
                </div>
                <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-top: 0.2rem;">
                    Google Pay • PhonePe • Paytm • BHIM
                </div>

                <div style="margin-top: 1rem;">
                    <a href="https://wa.me/919093390934?text={{ urlencode('મેં શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ જૂનાગઢમાં ભૂમિદાન કર્યું છે. તેની રસીદ મોકલવા વિનંતી.') }}" target="_blank" class="btn btn-outline-gold" style="width: 100%; font-size: 0.82rem; padding: 0.5rem 0.75rem;">
                        <i class="ri-whatsapp-line"></i> સ્ક્રીનશોટ વોટ્સએપ કરો
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Donors Wall of Honor Table Card -->
    <div class="responsive-table-card">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
            <div>
                <span class="badge badge-gold">કાયમી નામાવલી</span>
                <h3 style="font-size: clamp(1.2rem, 3vw, 1.6rem); font-weight:800; color: var(--color-maroon); margin-top: 0.35rem;">
                    ગૌરવવંતા ભૂમિદાતાશ્રીઓની યાદી
                </h3>
            </div>

            <!-- Search Form -->
            <form action="{{ route('bhumidan') }}" method="GET" style="display: flex; gap: 0.4rem; width: 100%; max-width: 320px;">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="નામ, ગામ કે રસીદ નં..." class="form-control" style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 0.85rem;">
                    <i class="ri-search-line"></i>
                </button>
                @if(!empty($search))
                    <a href="{{ route('bhumidan') }}" class="btn btn-outline-gold" style="padding: 0.5rem 0.75rem;" title="Clear">
                        <i class="ri-close-line"></i>
                    </a>
                @endif
            </form>
        </div>

        <div class="table-responsive-wrapper">
            <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 620px; font-size: 0.9rem;">
                <thead>
                    <tr style="background: var(--color-surface); border-bottom: 2px solid var(--color-border);">
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon);">રસીદ નં.</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon);">દાતાશ્રીનું નામ</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon);">ગામ / શહેર</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon); text-align: center;">ચોરસ વાર</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon); text-align: right;">સહયોગ રકમ</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon); text-align: center;">ડિજિટલ રસીદ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donors as $donor)
                        <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                            <td style="padding: 0.75rem; font-family: var(--font-latin); font-weight: 700; color: var(--color-primary-light);">
                                {{ $donor->receipt_number }}
                            </td>
                            <td style="padding: 0.75rem; font-weight: 700;">
                                {{ $donor->donor_name }}
                                @if($donor->is_featured)
                                    <span class="badge badge-gold" style="font-size: 0.68rem; margin-left: 0.25rem;">મુખ્ય દાતા</span>
                                @endif
                            </td>
                            <td style="padding: 0.75rem; color: var(--color-text-muted);">
                                {{ $donor->village ? $donor->village . ', ' : '' }}{{ $donor->city }}
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <span class="badge badge-gold" style="font-size: 0.8rem;">{{ $donor->sq_yards }} વાર</span>
                            </td>
                            <td style="padding: 0.75rem; text-align: right; font-weight: 800; color: var(--color-maroon);">
                                ₹ {{ number_format($donor->total_amount) }}/-
                            </td>
                            <td style="padding: 0.75rem; text-align: center;">
                                <a href="{{ route('receipt', $donor->receipt_number) }}" class="btn btn-outline-gold" style="padding: 0.25rem 0.65rem; font-size: 0.78rem;">
                                    <i class="ri-file-text-line"></i> રસીદ જુઓ
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">
                                કોઈ દાતા રેકોર્ડ મળેલ નથી.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.25rem;">
            {{ $donors->links() }}
        </div>
    </div>
</div>

@endsection

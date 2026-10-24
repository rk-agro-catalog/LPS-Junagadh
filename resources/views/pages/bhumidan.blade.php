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
            <h2 style="font-size: clamp(1.2rem, 2.5vw, 1.45rem); color: var(--color-maroon); font-weight: 650; margin-bottom: 0.35rem;">
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

            <!-- Live Calculation Display & 1-Click UPI Pay -->
            <div class="calc-result-box" style="margin-bottom: 1.25rem;">
                <div style="font-size: 0.82rem; font-weight: 600; color: #854d0e;">કુલ સહયોગ રાશિ :</div>
                <div class="calc-amount" id="calcAmountDisplay">₹ 2,500/-</div>
            </div>

            <!-- Instant Mobile UPI 1-Click Pay Action (Mobile Only) -->
            <div class="mobile-only" style="margin-bottom: 1.5rem; background: #ecfdf5; border: 1.5px solid #10b981; border-radius: var(--radius-md); padding: 1rem; text-align: center; flex-direction: column;">
                <div style="font-size: 0.85rem; font-weight: 600; color: #065f46; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.35rem;">
                    <i class="ri-smartphone-line" style="font-size: 1.1rem;"></i> મોબાઈલ દ્વારા ૧-ક્લિક UPI પેમેન્ટ
                </div>
                <a id="dynamicUpiPayBtn" href="upi://pay?pa=9093390934@sbi&pn=Shree%20Samast%20Leuva%20Patel%20Samaj%20Trust&am=2500&cu=INR&tn=LPS%20Junagadh%20Bhumidan%20(1%20Yards)" class="btn btn-primary" style="width: 100%; background: #059669; border-color: #059669; font-size: 0.95rem; padding: 0.65rem 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-weight: 600;">
                    <i class="ri-wallet-3-line"></i> UPI એપથી ચુકવો (GPay / PhonePe / Paytm)
                </a>
                <div style="font-size: 0.75rem; color: #047857; margin-top: 0.4rem;">
                    ચુકવણી પૂર્ણ થયા બાદ નીચે ફોર્મમાં Transaction ID લખી સબમિટ કરો
                </div>
            </div>

            <form action="{{ route('bhumidan.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label class="form-label" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.25rem;">
                            <span><i class="ri-image-add-line" style="color: var(--color-primary-light);"></i> પેમેન્ટ સ્ક્રીનશોટ / રસીદ ફોટો અપલોડ કરો</span>
                            <span style="font-size: 0.75rem; color: var(--color-text-muted); font-weight: normal;">(વૈકલ્પિક - JPG, PNG, WEBP, PDF max 5MB)</span>
                        </label>
                        <div style="border: 2px dashed var(--color-border); border-radius: var(--radius-md); padding: 1rem; text-align: center; background: #fafafa; transition: border-color 0.2s;" id="screenshotDropZone">
                            <input type="file" name="payment_screenshot" id="paymentScreenshotInput" accept="image/*,.pdf" style="display: none;" onchange="handleScreenshotSelect(this)">
                            <label for="paymentScreenshotInput" style="cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 0.35rem; margin: 0;">
                                <i class="ri-upload-cloud-2-line" style="font-size: 2.2rem; color: var(--color-primary-light);"></i>
                                <span style="font-weight: 600; color: var(--color-maroon); font-size: 0.92rem;">સ્ક્રીનશોટ ફાઇલ પસંદ કરો</span>
                                <span style="font-size: 0.78rem; color: var(--color-text-muted);" id="screenshotFileName">Google Pay / PhonePe / UPI પેમેન્ટનો સ્ક્રીનશોટ</span>
                            </label>
                            <div id="screenshotPreviewWrapper" style="display: none; margin-top: 0.75rem;">
                                <img id="screenshotPreviewImg" src="" alt="Screenshot Preview" style="max-height: 140px; border-radius: 6px; box-shadow: var(--shadow-sm); border: 1px solid var(--color-border);">
                                <div style="margin-top: 0.4rem;">
                                    <button type="button" onclick="clearScreenshotSelect()" class="btn btn-outline-gold" style="padding: 0.2rem 0.7rem; font-size: 0.76rem; color: #dc2626; border-color: #fca5a5;">
                                        <i class="ri-delete-bin-line"></i> રદ કરો
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">સંકલ્પ સંદેશ / નોંધ</label>
                        <textarea name="notes" rows="2" class="form-control" placeholder="દા.ત. પરિવાર વતી શુભ સંકલ્પ..."></textarea>
                    </div>

                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1rem; padding: 0.75rem; font-weight: 700;">
                            <i class="ri-check-line"></i> ભૂમિદાન સંકલ્પ સબમિટ કરો
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right: Official Bank Account & UPI QR Details -->
        <div>
            <div style="background: var(--gradient-royal); color: #fff; padding: clamp(1.25rem, 3vw, 1.75rem); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); margin-bottom: 1.5rem;">
                <h3 style="font-size: clamp(1.05rem, 2.2vw, 1.2rem); font-weight: 650; margin-bottom: 0.4rem; color: #fef08a !important;">
                    <i class="ri-bank-line"></i> સત્તાવાર બેંક એકાઉન્ટ
                </h3>
                <p style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.92) !important; margin-bottom: 1rem;">
                    ટ્રસ્ટના અધિકૃત બેંક ખાતામાં સીધા RTGS / NEFT / ચેક જમા કરાવી શકાય છે.
                </p>

                <div style="background: rgba(255,255,255,0.12); padding: 1rem; border-radius: var(--radius-md); font-size: 0.88rem; line-height: 1.7; backdrop-filter: blur(6px); color: #ffffff;">
                    <div><strong style="color: #fef08a !important;">ખાતાનું નામ:</strong><br><span style="color: #ffffff;">શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ</span></div>
                    <div style="margin-top: 0.4rem;"><strong style="color: #fef08a !important;">બેંક:</strong> <span style="color: #ffffff;">State Bank of India (SBI)</span></div>
                    <div><strong style="color: #fef08a !important;">ખાતા નંબર:</strong> <span style="color: #fef08a; font-weight: 700; font-family: var(--font-latin);">909339093401</span></div>
                    <div><strong style="color: #fef08a !important;">IFSC કોડ:</strong> <span style="color: #ffffff; font-family: var(--font-latin);">SBIN0001234</span></div>
                    <div><strong style="color: #fef08a !important;">શાખા:</strong> <span style="color: #ffffff;">જૂનાગઢ મેઈન બ્રાન્ચ</span></div>
                </div>
            </div>

            <!-- UPI QR Code Block -->
            <div style="background: #fff; border: 2px dashed var(--color-gold); border-radius: var(--radius-lg); padding: clamp(1.25rem, 3vw, 1.75rem); text-align: center; box-shadow: var(--shadow-sm);">
                <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span class="badge badge-gold">ડાયરેક્ટ UPI પેમેન્ટ</span>
                    <span class="badge" id="upiQrAmountBadge" style="background: #ecfdf5; color: #047857; font-weight: 600; border: 1px solid #a7f3d0; font-family: var(--font-latin);">₹ 2,500/-</span>
                </div>
                <h3 style="font-size: clamp(1.05rem, 2.2vw, 1.18rem); font-weight: 650; color: var(--color-maroon);">
                    કોઈપણ UPI એપથી સ્કેન કરો
                </h3>

                <div style="margin: 1rem auto; width: 160px; height: 160px; background: #fff; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); padding: 8px; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-sm);">
                    <img id="dynamicUpiQrImg" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=upi%3A%2F%2Fpay%3Fpa%3D9093390934%40sbi%26pn%3DShree%2520Samast%2520Leuva%2520Patel%2520Samaj%2520Trust%26am%3D2500%26cu%3DINR%26tn%3DLPS%20Junagadh%20Bhumidan" alt="UPI QR Code" style="width: 144px; height: 144px;">
                </div>

                <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                    <div style="font-weight: 600; color: var(--color-text-main); font-size: 0.92rem;">
                        UPI ID: <span style="color: var(--color-primary-light);">9093390934@sbi</span>
                    </div>
                    <button type="button" onclick="copyUpiId('9093390934@sbi', this)" class="btn btn-outline-gold" style="padding: 0.2rem 0.6rem; font-size: 0.75rem; border-radius: var(--radius-pill); font-weight: 600;">
                        <i class="ri-file-copy-line"></i> કોપી કરો
                    </button>
                </div>

                <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-bottom: 1rem;">
                    Google Pay • PhonePe • Paytm • BHIM • Amazon Pay
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <a href="https://wa.me/919093390934?text={{ urlencode('જય સરદાર. મેં શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ જૂનાગઢ સંકુલ નિર્માણ માટે ભૂમિદાન આપેલ છે. કૃપા કરીને રસીદ મોકલવા વિનંતી.') }}" target="_blank" class="btn btn-outline-gold" style="width: 100%; font-size: 0.85rem; padding: 0.55rem 0.75rem; color: #15803d; border-color: #86efac; background: #f0fdf4;">
                        <i class="ri-whatsapp-line"></i> પેમેન્ટ સ્ક્રીનશોટ વોટ્સએપ કરો
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

        @include('partials.datatable-toolbar', ['paginator' => $donors])

        <div class="table-responsive-wrapper">
            <table style="width: 100%; border-collapse: collapse; text-align: left; min-width: 620px; font-size: 0.9rem;">
                <thead>
                    <tr style="background: var(--color-surface); border-bottom: 2px solid var(--color-border);">
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon);">રસીદ નં.</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon);">દાતાશ્રીનું નામ</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon);">ગામ / શહેર</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon);">ચોરસ વાર</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon); text-align: right;">સહયોગ રકમ</th>
                        <th style="padding: 0.75rem; font-weight:800; color: var(--color-maroon); text-align: center;">સ્થિતિ</th>
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
                                <span class="badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.78rem; padding: 0.25rem 0.65rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    <i class="ri-checkbox-circle-fill"></i> નોંધાયેલ દાતા
                                </span>
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

<script>
function handleScreenshotSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileNameEl = document.getElementById('screenshotFileName');
        const previewWrap = document.getElementById('screenshotPreviewWrapper');
        const previewImg = document.getElementById('screenshotPreviewImg');
        const dropZone = document.getElementById('screenshotDropZone');

        fileNameEl.textContent = 'પસંદ કરેલ: ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        dropZone.style.borderColor = 'var(--color-gold)';
        dropZone.style.background = '#fefce8';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrap.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewWrap.style.display = 'none';
        }
    }
}

function clearScreenshotSelect() {
    const input = document.getElementById('paymentScreenshotInput');
    const fileNameEl = document.getElementById('screenshotFileName');
    const previewWrap = document.getElementById('screenshotPreviewWrapper');
    const previewImg = document.getElementById('screenshotPreviewImg');
    const dropZone = document.getElementById('screenshotDropZone');

    input.value = '';
    fileNameEl.textContent = 'Google Pay / PhonePe / UPI પેમેન્ટનો સ્ક્રીનશોટ';
    previewImg.src = '';
    previewWrap.style.display = 'none';
    dropZone.style.borderColor = 'var(--color-border)';
    dropZone.style.background = '#fafafa';
}
</script>

@endsection

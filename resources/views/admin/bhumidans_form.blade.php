@extends('layouts.admin')

@section('title', $mode === 'create' ? 'નવા ભૂમિદાતા ઉમેરો' : 'દાતા વિગતો સુધારો')
@section('header_title', $mode === 'create' ? 'ઓફલાઇન ભૂમિદાન નોંધણી' : 'દાતા વિગતો સુધારો')

@section('content')

<div style="max-width: 820px; margin: 0 auto;">
    <div style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
        <a href="{{ route('admin.bhumidans') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.84rem;">
            <i class="ri-arrow-left-line"></i> દાતા યાદી પર પાછા જાઓ
        </a>
        <span class="badge badge-gold">
            {{ $mode === 'create' ? 'ઓફિસ / ઓફલાઇન નોંધણી' : 'રસીદ: ' . $bhumidan->receipt_number }}
        </span>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 1.25rem; background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.75rem 1rem; border-radius: 12px;">
            <div style="font-weight: 700; margin-bottom: 0.25rem;">કૃપા કરીને ભૂલો સુધારો:</div>
            <ul style="margin: 0; padding-left: 1.2rem; font-size: 0.85rem;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-card">
        <form action="{{ $mode === 'create' ? route('admin.bhumidans.store') : route('admin.bhumidans.updateRecord', $bhumidan->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">દાતાશ્રીનું પૂરું નામ *</label>
                    <input type="text" name="donor_name" class="form-control" value="{{ old('donor_name', $bhumidan->donor_name) }}" placeholder="દા.ત. શ્રી રમેશભાઈ પટેલ" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="form-label">મોબાઈલ નંબર *</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $bhumidan->phone) }}" placeholder="૧૦ અંકનો નંબર" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="form-label">મૂળ ગામ</label>
                    <input type="text" name="village" class="form-control" value="{{ old('village', $bhumidan->village) }}" placeholder="દા.ત. વંથલી, કેશોદ, વિસાવદર..." autocomplete="off">
                </div>

                <div class="form-group">
                    <label class="form-label">હાલનું શહેર *</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $bhumidan->city ?? 'જૂનાગઢ') }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="form-label">સમર્પિત ચોરસ વાર સંખ્યા *</label>
                    <input type="number" id="sqYardsInput" name="sq_yards" class="form-control" value="{{ old('sq_yards', $bhumidan->sq_yards ?? 1) }}" min="1" max="5000" autocomplete="off" required>
                    <div style="font-size: 0.78rem; color: #b45309; font-weight: 700; margin-top: 0.25rem;">
                        (૧ ચોરસ વાર = રૂા. ૨,૫૦૦/-)
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">કુલ ગણતરી રકમ</label>
                    <div id="calcTotalBox" style="padding: 0.65rem 1rem; background: #fffbeb; border: 1.5px solid #fef08a; border-radius: 12px; font-size: 1.15rem; font-weight: 800; color: #780d28;">
                        ₹ {{ number_format(old('sq_yards', $bhumidan->sq_yards ?? 1) * 2500) }}/-
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">ચુકવણી પદ્ધતિ (Payment Method) *</label>
                    <select name="payment_method" class="form-control" autocomplete="off" required>
                        <option value="Cash" {{ old('payment_method', $bhumidan->payment_method) == 'Cash' ? 'selected' : '' }}>રોકડ (Cash - કાર્યાલયે)</option>
                        <option value="Cheque" {{ old('payment_method', $bhumidan->payment_method) == 'Cheque' ? 'selected' : '' }}>ચેક (Cheque)</option>
                        <option value="UPI" {{ old('payment_method', $bhumidan->payment_method) == 'UPI' ? 'selected' : '' }}>UPI (GPay/PhonePe/Paytm)</option>
                        <option value="Bank Transfer" {{ old('payment_method', $bhumidan->payment_method) == 'Bank Transfer' ? 'selected' : '' }}>બેંક ટ્રાન્સફર (NEFT/RTGS)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">ટ્રાન્ઝેક્શન / ચેક નંબર</label>
                    <input type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id', $bhumidan->transaction_id) }}" placeholder="ચેક નંબર અથવા UPI ID..." autocomplete="off">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">પેમેન્ટ સ્ક્રીનશોટ / રસીદ સ્લિપ (Payment Screenshot / Slip)</label>
                    @if($bhumidan->payment_screenshot)
                        <div style="margin-bottom: 0.75rem; display: flex; align-items: center; gap: 1rem; background: #f8fafc; padding: 0.75rem; border-radius: 10px; border: 1px solid #e2e8f0;">
                            <img src="{{ asset($bhumidan->payment_screenshot) }}" alt="Payment Proof" style="height: 60px; width: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                            <div>
                                <div style="font-size: 0.82rem; font-weight: 600; color: #334155;">હાલ અપલોડ થયેલ સ્લિપ</div>
                                <a href="{{ asset($bhumidan->payment_screenshot) }}" target="_blank" style="font-size: 0.8rem; color: #0284c7; text-decoration: underline; font-weight: 600;">
                                    <i class="ri-external-link-line"></i> પૂર્ણ સાઈઝમાં જુઓ
                                </a>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="payment_screenshot" class="form-control" accept="image/*,application/pdf" autocomplete="off">
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">
                        નવી સ્લિપ બદલવા અથવા અપલોડ કરવા માટે ફાઇલ સિલેક્ટ કરો (JPG, PNG, WebP, PDF - મહત્તમ 5MB)
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">રસીદ સ્ટેટસ (Verification Status) *</label>
                    <select name="status" class="form-control" autocomplete="off" required>
                        <option value="verified" {{ old('status', $bhumidan->status) == 'verified' ? 'selected' : '' }}>સ્વીકૃત & પ્રમાણિત (Verified)</option>
                        <option value="pending" {{ old('status', $bhumidan->status) == 'pending' ? 'selected' : '' }}>પેન્ડિંગ (Pending)</option>
                        <option value="completed" {{ old('status', $bhumidan->status) == 'completed' ? 'selected' : '' }}>સંપૂર્ણ (Completed)</option>
                    </select>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-top: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $bhumidan->is_featured) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #b45309;">
                        <span style="font-weight: 700; color: #1e293b; font-size: 0.92rem;">મુખ્ય દાતા તરીકે દર્શાવો (Featured Donor)</span>
                    </label>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">વિશેષ નોંધ / સંકલ્પ</label>
                    <textarea name="notes" rows="2" class="form-control" placeholder="દાતાશ્રી તરફથી કોઈ ખાસ નોંધ અથવા સ્મૃતિ સંકલ્પ..." autocomplete="off">{{ old('notes', $bhumidan->notes) }}</textarea>
                </div>

                <div class="form-group full-width" style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="submit" class="admin-quick-pill primary" style="padding: 0.75rem 1.75rem; font-size: 0.95rem; border: none; cursor: pointer;">
                        <i class="ri-save-line"></i> {{ $mode === 'create' ? 'દાતા નોંધણી કરો & રસીદ જનરેટ કરો' : 'ફેરફાર સેવ કરો' }}
                    </button>
                    <a href="{{ route('admin.bhumidans') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.75rem 1.5rem;">
                        રદ કરો
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const sqYardsInput = document.getElementById('sqYardsInput');
    const calcTotalBox = document.getElementById('calcTotalBox');
    if (sqYardsInput && calcTotalBox) {
        sqYardsInput.addEventListener('input', function() {
            const yards = parseInt(this.value) || 0;
            const total = yards * 2500;
            calcTotalBox.innerText = '₹ ' + total.toLocaleString('en-IN') + '/-';
        });
    }
</script>

@endsection

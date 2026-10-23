@extends('layouts.admin')

@section('title', $mode === 'create' ? 'નવું હોલ/પ્લોટ બુકિંગ ઉમેરો' : 'બુકિંગ વિગતો સુધારો')
@section('header_title', $mode === 'create' ? 'ઓફલાઇન બુકિંગ નોંધણી' : 'બુકિંગ સુધારો')

@section('content')

<div style="max-width: 820px; margin: 0 auto;">
    <div style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
        <a href="{{ route('admin.bookings') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.84rem;">
            <i class="ri-arrow-left-line"></i> બુકિંગ યાદી પર પાછા જાઓ
        </a>
        <span class="badge badge-gold">
            {{ $mode === 'create' ? 'ઓફલાઇન / ફોન બુકિંગ' : 'બુકિંગ નં: ' . $booking->inquiry_number }}
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
        <form action="{{ $mode === 'create' ? route('admin.bookings.store') : route('admin.bookings.updateRecord', $booking->id) }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">અરજદારશ્રીનું પૂરું નામ *</label>
                    <input type="text" name="applicant_name" class="form-control" value="{{ old('applicant_name', $booking->applicant_name) }}" placeholder="શ્રી ..." required>
                </div>

                <div class="form-group">
                    <label class="form-label">મોબાઈલ નંબર *</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $booking->phone) }}" placeholder="૧૦ અંકનો મોબાઈલ નંબર" required>
                </div>

                <div class="form-group">
                    <label class="form-label">ઇમેઇલ</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $booking->email) }}" placeholder="example@gmail.com">
                </div>

                <div class="form-group">
                    <label class="form-label">ગામ / શહેર</label>
                    <input type="text" name="city_or_village" class="form-control" value="{{ old('city_or_village', $booking->city_or_village ?? 'જૂનાગઢ') }}" placeholder="દા.ત. જૂનાગઢ, કેશોદ...">
                </div>

                <div class="form-group">
                    <label class="form-label">સંકુલ વિભાગ *</label>
                    <select id="bookingSectionSelect" name="section_type" class="form-control" required>
                        <option value="વિભાગ-૧" {{ old('section_type', $booking->section_type) == 'વિભાગ-૧' ? 'selected' : '' }}>પ્રમુખ સેવા સંકલ્પ : વિભાગ-૧ (મેગા ઇવેન્ટ્સ)</option>
                        <option value="વિભાગ-૨" {{ old('section_type', $booking->section_type) == 'વિભાગ-૨' ? 'selected' : '' }}>વિશેષ સેવા સંકલ્પ : વિભાગ-૨ (મધ્યમ વર્ગ શુભ પ્રસંગ)</option>
                        <option value="અતિથિ ભવન" {{ old('section_type', $booking->section_type) == 'અતિથિ ભવન' ? 'selected' : '' }}>અતિથિ ભવન / ઉતારા રૂમ</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">સુવિધા / હોલ *</label>
                    <input type="text" name="facility_name" class="form-control" value="{{ old('facility_name', $booking->facility_name) }}" placeholder="દા.ત. પાર્ટી પ્લોટ, સેન્ટ્રલ AC હોલ..." required>
                </div>

                <div class="form-group">
                    <label class="form-label">પ્રસંગ પ્રકાર *</label>
                    <input type="text" name="event_type" class="form-control" value="{{ old('event_type', $booking->event_type) }}" placeholder="દા.ત. લગ્ન પ્રસંગ, સગાઈ, સામાજિક મેળાવડો..." required>
                </div>

                <div class="form-group">
                    <label class="form-label">પ્રસંગ તારીખ *</label>
                    <input type="date" name="event_date" class="form-control" value="{{ old('event_date', optional($booking->event_date)->format('Y-m-d') ?? $booking->event_date) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">અંદાજિત મહેમાનો સંખ્યા *</label>
                    <input type="number" name="approx_guests" class="form-control" value="{{ old('approx_guests', $booking->approx_guests ?? 500) }}" min="10" required>
                </div>

                <div class="form-group">
                    <label class="form-label">જરૂરી રૂમની સંખ્યા</label>
                    <input type="number" name="required_rooms" class="form-control" value="{{ old('required_rooms', $booking->required_rooms ?? 0) }}" min="0">
                </div>

                <div class="form-group">
                    <label class="form-label">બુકિંગ સ્ટેટસ *</label>
                    <select name="status" class="form-control" required>
                        <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>કન્ફર્મ (Confirmed)</option>
                        <option value="in_review" {{ old('status', $booking->status) == 'in_review' ? 'selected' : '' }}>તપાસ હેઠળ (In Review)</option>
                        <option value="new" {{ old('status', $booking->status) == 'new' ? 'selected' : '' }}>નવી ઇન્ક્વાયરી (New)</option>
                        <option value="rejected" {{ old('status', $booking->status) == 'rejected' ? 'selected' : '' }}>રદ કરેલ (Cancelled/Rejected)</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">એડમિન નોંધ / ટ્રસ્ટ શરતો</label>
                    <textarea name="admin_notes" rows="3" class="form-control" placeholder="એડમિન તરફથી બુકિંગ વિગતો, એડવાન્સ રકમ અથવા ખાસ સૂચનો...">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                </div>

                <div class="form-group full-width" style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="submit" class="admin-quick-pill primary" style="padding: 0.75rem 1.75rem; font-size: 0.95rem; border: none; cursor: pointer;">
                        <i class="ri-save-line"></i> {{ $mode === 'create' ? 'બુકિંગ સેવ કરો' : 'ફેરફાર સેવ કરો' }}
                    </button>
                    <a href="{{ route('admin.bookings') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.75rem 1.5rem;">
                        રદ કરો
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

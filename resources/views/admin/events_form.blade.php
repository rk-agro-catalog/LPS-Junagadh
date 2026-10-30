@extends('layouts.admin')

@section('title', $mode === 'create' ? 'નવો કાર્યક્રમ ઉમેરો' : 'કાર્યક્રમ સુધારો')
@section('header_title', $mode === 'create' ? 'નવો સમાજ કાર્યક્રમ ઉમેરો' : 'કાર્યક્રમ સુધારો')

@section('content')

<div style="max-width: 820px; margin: 0 auto;">
    <div style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
        <a href="{{ route('admin.events') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.84rem;">
            <i class="ri-arrow-left-line"></i> કાર્યક્રમો યાદી પર પાછા જાઓ
        </a>
        <span class="badge badge-gold">
            {{ $mode === 'create' ? 'નવી ઇવેન્ટ' : 'ઇવેન્ટ #' . $event->id }}
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
        <form action="{{ $mode === 'create' ? route('admin.events.store') : route('admin.events.update', $event->id) }}" method="POST" autocomplete="off">
            @csrf

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">કાર્યક્રમ શીર્ષક (Event Title) *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" placeholder="દા.ત. ભવ્ય સ્નેહમિલન & સંકુલ ભૂમિ પૂજન સમારોહ..." autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="form-label">કાર્યક્રમ કેટેગરી *</label>
                    <select name="category" class="form-control" autocomplete="off" required>
                        <option value="સ્નેહમિલન" {{ old('category', $event->category) == 'સ્નેહમિલન' ? 'selected' : '' }}>સ્નેહમિલન & સભા (Gathering)</option>
                        <option value="સામાજિક" {{ old('category', $event->category) == 'સામાજિક' ? 'selected' : '' }}>સામાજિક ઉત્સવ (Social Event)</option>
                        <option value="આરોગ્ય" {{ old('category', $event->category) == 'આરોગ્ય' ? 'selected' : '' }}>રક્તદાન & આરોગ્ય કેમ્પ (Health Camp)</option>
                        <option value="ધાર્મિક" {{ old('category', $event->category) == 'ધાર્મિક' ? 'selected' : '' }}>ધાર્મિક મહોત્સવ (Religious)</option>
                        <option value="શૈક્ષણિક" {{ old('category', $event->category) == 'શૈક્ષણિક' ? 'selected' : '' }}>શૈક્ષણિક & સન્માન સમારોહ (Education)</option>
                        <option value="યુવા મહોત્સવ" {{ old('category', $event->category) == 'યુવા મહોત્સવ' ? 'selected' : '' }}>યુવા પાંખ પ્રવૃત્તિ (Youth)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">તારીખ (Event Date) *</label>
                    <input type="date" name="event_date" class="form-control" value="{{ old('event_date', optional($event->event_date)->format('Y-m-d') ?? $event->event_date) }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="form-label">સમય (Event Time)</label>
                    <input type="text" name="event_time" class="form-control" value="{{ old('event_time', $event->event_time ?? 'સવારે ૯:૦૦ કલાકે') }}" placeholder="દા.ત. સાંજે ૫:૩૦ કલાકે" autocomplete="off">
                </div>

                <div class="form-group">
                    <label class="form-label">સ્થળ (Venue) *</label>
                    <input type="text" name="venue" class="form-control" value="{{ old('venue', $event->venue ?? 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ સંકુલ, ખલીલપુર ચોકડી પાસે, જૂનાગઢ') }}" autocomplete="off" required>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">બેનર / ફોટો URL (Image URL)</label>
                    <input type="url" name="image_url" class="form-control" value="{{ old('image_url', $event->image_url) }}" placeholder="https://images.unsplash.com/... અથવા ઇમેજ લિંક" autocomplete="off">
                </div>

                <div class="form-group">
                    <label class="form-label">આયોજક (Organizer)</label>
                    <input type="text" name="organizer" class="form-control" value="{{ old('organizer', $event->organizer ?? 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ') }}" autocomplete="off">
                </div>

                <div class="form-group">
                    <label class="form-label">સંપર્ક સૂત્ર / હેલ્પલાઇન</label>
                    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $event->contact_person ?? 'ટ્રસ્ટ કાર્યાલય: 909 33 909 34') }}" autocomplete="off">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">કાર્યક્રમ વિગત / આમંત્રણ સંદેશ (Description)</label>
                    <textarea name="description" rows="4" class="form-control" placeholder="કાર્યક્રમનો ઉદ્દેશ્ય, ઉપસ્થિત મહાનુભાવો અને સમસ્ત સમાજને આમંત્રણ વિગત..." autocomplete="off">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #b45309;">
                        <span style="font-weight: 700; color: #1e293b; font-size: 0.92rem;">મુખ્ય પૃષ્ઠ (Homepage) પર દર્શાવો</span>
                    </label>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #b45309;">
                        <span style="font-weight: 700; color: #1e293b; font-size: 0.92rem;">સક્રિય સ્થિતિ (Active / Published)</span>
                    </label>
                </div>

                <div class="form-group full-width" style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="submit" class="admin-quick-pill primary" style="padding: 0.75rem 1.75rem; font-size: 0.95rem; border: none; cursor: pointer;">
                        <i class="ri-save-line"></i> {{ $mode === 'create' ? 'કાર્યક્રમ જાહેર કરો' : 'ફેરફાર સેવ કરો' }}
                    </button>
                    <a href="{{ route('admin.events') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.75rem 1.5rem;">
                        રદ કરો
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

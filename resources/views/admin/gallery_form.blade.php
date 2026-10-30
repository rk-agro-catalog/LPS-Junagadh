@extends('layouts.admin')

@section('title', $mode === 'create' ? 'નવી ગેલેરી આઇટમ ઉમેરો' : 'ગેલેરી આઇટમ સુધારો')
@section('header_title', $mode === 'create' ? 'ગેલેરી ફોટો / વિડીયો ઉમેરો' : 'ગેલેરી સુધારો')

@section('content')

<div style="max-width: 820px; margin: 0 auto;">
    <div style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
        <a href="{{ route('admin.gallery') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.84rem;">
            <i class="ri-arrow-left-line"></i> ગેલેરી યાદી પર પાછા જાઓ
        </a>
        <span class="badge badge-gold">
            {{ $mode === 'create' ? 'નવું મીડિયા' : 'આઇડી: #' . $item->id }}
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
        <form action="{{ $mode === 'create' ? route('admin.gallery.store') : route('admin.gallery.update', $item->id) }}" method="POST" autocomplete="off">
            @csrf

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">શીર્ષક (Title) *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $item->title) }}" placeholder="દા.ત. સંકુલ ભૂમિ પૂજન મહોત્સવ તસવીર..." autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="form-label">કેટેગરી *</label>
                    <select name="category" class="form-control" autocomplete="off" required>
                        <option value="events" {{ old('category', $item->category) == 'events' ? 'selected' : '' }}>સમાજ કાર્યક્રમો (Events)</option>
                        <option value="bhumipujan" {{ old('category', $item->category) == 'bhumipujan' ? 'selected' : '' }}>ભૂમિ પૂજન (Bhoomi Pujan)</option>
                        <option value="construction" {{ old('category', $item->category) == 'construction' ? 'selected' : '' }}>સંકુલ નિર્માણ કાર્ય (Construction)</option>
                        <option value="reels" {{ old('category', $item->category) == 'reels' ? 'selected' : '' }}>રીલ્સ & શોર્ટ્સ (Reels / Videos)</option>
                        <option value="youth" {{ old('category', $item->category) == 'youth' ? 'selected' : '' }}>યુવા પાંખ & પ્રવૃત્તિઓ (Youth)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">મીડિયા પ્રકાર (Media Type) *</label>
                    <select name="media_type" class="form-control" autocomplete="off" required>
                        <option value="image" {{ old('media_type', $item->media_type) == 'image' ? 'selected' : '' }}>ફોટો (Image)</option>
                        <option value="video" {{ old('media_type', $item->media_type) == 'video' ? 'selected' : '' }}>વિડીયો (Video File / URL)</option>
                        <option value="youtube" {{ old('media_type', $item->media_type) == 'youtube' ? 'selected' : '' }}>YouTube વિડીયો</option>
                        <option value="instagram_reel" {{ old('media_type', $item->media_type) == 'instagram_reel' ? 'selected' : '' }}>ઇન્સ્ટાગ્રામ રીલ (Instagram Reel)</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">મીડિયા URL (Image / Video URL) *</label>
                    <input type="url" name="media_url" class="form-control" value="{{ old('media_url', $item->media_url) }}" placeholder="https://example.com/image.jpg અથવા YouTube લિંક" autocomplete="off" required>
                    <div style="font-size: 0.76rem; color: #64748b; margin-top: 0.25rem;">
                        ઇમેજ લિંક, YouTube લિંક અથવા Instagram Reel લિંક પેસ્ટ કરો.
                    </div>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">થમ્બનેઈલ URL (વૈકલ્પિક)</label>
                    <input type="url" name="thumbnail_url" class="form-control" value="{{ old('thumbnail_url', $item->thumbnail_url) }}" placeholder="https://example.com/thumb.jpg" autocomplete="off">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">કેપ્શન / વર્ણન</label>
                    <textarea name="caption" rows="2" class="form-control" placeholder="તસવીર અથવા વિડીયો વિશે ટૂંકી વિગત..." autocomplete="off">{{ old('caption', $item->caption) }}</textarea>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #b45309;">
                        <span style="font-weight: 700; color: #1e293b; font-size: 0.92rem;">મુખ્ય પૃષ્ઠ (Homepage) પર દર્શાવો</span>
                    </label>
                </div>

                <div class="form-group full-width" style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="submit" class="admin-quick-pill primary" style="padding: 0.75rem 1.75rem; font-size: 0.95rem; border: none; cursor: pointer;">
                        <i class="ri-save-line"></i> {{ $mode === 'create' ? 'ગેલેરી આઇટમ ઉમેરો' : 'ફેરફાર સેવ કરો' }}
                    </button>
                    <a href="{{ route('admin.gallery') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.75rem 1.5rem;">
                        રદ કરો
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

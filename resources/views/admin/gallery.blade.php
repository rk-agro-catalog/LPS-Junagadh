@extends('layouts.admin')

@section('title', 'ગેલેરી વ્યવસ્થાપન')
@section('header_title', 'ફોટો, વિડીયો & રીલ્સ વ્યવસ્થાપન')

@section('content')

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">બધી ગેલેરી આઇટમ્સ</h3>
            <p class="admin-card-desc">સંકુલ નિર્માણ, ભૂમિ પૂજન, સમાજ કાર્યક્રમો અને રીલ્સનું વ્યવસ્થાપન</p>
        </div>

        <div class="admin-filter-bar">
            <a href="{{ route('admin.gallery.create') }}" class="admin-quick-pill primary" style="font-size: 0.84rem; padding: 0.45rem 0.9rem;">
                <i class="ri-add-line"></i> + નવી ગેલેરી આઇટમ
            </a>

            <form action="{{ route('admin.gallery') }}" method="GET" class="admin-search-form" autocomplete="off">
                <select name="category" class="form-control" autocomplete="off" style="font-size: 0.82rem; padding: 0.42rem 0.65rem; width: 150px; border-radius: 8px;" onchange="this.form.submit()">
                    <option value="">બધી કેટેગરી</option>
                    <option value="events" {{ request('category') == 'events' ? 'selected' : '' }}>કાર્યક્રમો (Events)</option>
                    <option value="bhumipujan" {{ request('category') == 'bhumipujan' ? 'selected' : '' }}>ભૂમિ પૂજન</option>
                    <option value="construction" {{ request('category') == 'construction' ? 'selected' : '' }}>સંકુલ નિર્માણ</option>
                    <option value="reels" {{ request('category') == 'reels' ? 'selected' : '' }}>રીલ્સ & શોર્ટ્સ</option>
                </select>
            </form>
        </div>
    </div>

    @include('partials.datatable-toolbar', ['paginator' => $items])

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 70px;">મીડિયા</th>
                    <th>શીર્ષક (Title)</th>
                    <th>કેટેગરી</th>
                    <th>પ્રકાર</th>
                    <th style="text-align: center;">ફીચર્ડ</th>
                    <th style="text-align: center;">એક્શન</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>
                            <img src="{{ $item->thumbnail_url ?? $item->media_url }}" alt="{{ $item->title }}" style="width: 52px; height: 40px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;" onerror="this.src='https://placehold.co/100x75?text=LPS'">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $item->title }}</div>
                            @if($item->caption)
                                <div style="font-size: 0.74rem; color: #64748b;">{{ Str::limit($item->caption, 40) }}</div>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <span class="badge badge-gold" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">{{ $item->category }}</span>
                        </td>
                        <td style="font-size: 0.82rem; white-space: nowrap;">
                            <span style="display: inline-flex; align-items: center; gap: 0.25rem;">
                                @if($item->media_type === 'video' || $item->media_type === 'youtube')
                                    <i class="ri-video-line" style="color: #dc2626;"></i> વિડીયો
                                @elseif($item->media_type === 'instagram_reel')
                                    <i class="ri-instagram-line" style="color: #c026d3;"></i> રીલ
                                @else
                                    <i class="ri-image-line" style="color: #2563eb;"></i> ફોટો
                                @endif
                            </span>
                        </td>
                        <td style="text-align: center; white-space: nowrap;">
                            @if($item->is_featured)
                                <span class="badge badge-green" style="font-size: 0.72rem; padding: 0.15rem 0.45rem;">હા</span>
                            @else
                                <span style="color: #94a3b8; font-size: 0.8rem;">-</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div class="admin-actions">
                                <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn-admin-action edit" title="વિગતો સુધારો">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <a href="{{ $item->media_url }}" target="_blank" class="btn-admin-action view" title="મીડિયા ખોલો">
                                    <i class="ri-external-link-line"></i>
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('શું આપ આ ગેલેરી આઇટમ ડીલીટ કરવા માંગો છો?');" style="display: inline; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-action delete" title="ડીલીટ કરો">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 2.5rem; text-align: center; color: #94a3b8;">
                            કોઈ ગેલેરી આઇટમ મળેલ નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $items->links() }}
    </div>
</div>

@endsection

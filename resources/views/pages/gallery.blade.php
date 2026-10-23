@extends('layouts.app')

@section('title', 'ફોટો & વિડીયો ગેલેરી | LPS Junagadh')

@section('content')

<!-- Banner Header -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;">
            <i class="ri-gallery-fill"></i> સ્મૃતિ દર્શન
        </span>
        <h1>ફોટો & વિડીયો ગેલેરી</h1>
        <p>
            સંકલ્પ સંમેલન, ભૂમિપૂજન, આર્કિટેક્ચર મોડેલ અને તાજા સામાજિક કાર્યક્રમોની તસવીરો
        </p>
    </div>
</div>


<div class="container section-padding">

    <!-- Instagram Official Callout -->
    <div style="background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%); color: #fff; border-radius: var(--radius-lg); padding: 1.5rem 2rem; margin-bottom: 3rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; box-shadow: var(--shadow-md);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <i class="ri-instagram-line" style="font-size: 2.5rem;"></i>
            <div>
                <h3 style="font-size: 1.35rem; font-weight: 800;">Instagram : @leuvapateltrust_junagadh</h3>
                <p style="font-size: 0.9rem; opacity: 0.95;">ખોડલધામ યુવા સમિતિ અને લેઉવા પટેલ ટ્રસ્ટ જૂનાગઢના લેટેસ્ટ રીલ્સ અને અપડેટ્સ</p>
            </div>
        </div>
        <a href="https://www.instagram.com/explore/locations/265511100633813/khodaldham-yuva-samiti-junagadh/" target="_blank" class="btn btn-white" style="font-weight: 800;">
            <i class="ri-external-link-line"></i> ઇન્સ્ટાગ્રામ પેજ ખોલો
        </a>
    </div>

    <!-- Category Filter Tabs -->
    <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 2.5rem;">
        <a href="{{ route('gallery') }}" class="btn {{ empty($category) || $category == 'all' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.45rem 1.25rem;">
            બધા ફોટો & વિડીયો
        </a>
        <a href="{{ route('gallery', ['category' => 'bhumipujan']) }}" class="btn {{ $category == 'bhumipujan' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.45rem 1.25rem;">
            ભૂમિપૂજન ઉત્સવ
        </a>
        <a href="{{ route('gallery', ['category' => 'events']) }}" class="btn {{ $category == 'events' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.45rem 1.25rem;">
            સામાજિક કાર્યક્રમો
        </a>
        <a href="{{ route('gallery', ['category' => 'construction']) }}" class="btn {{ $category == 'construction' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.45rem 1.25rem;">
            આર્કિટેક્ચર & બાંધકામ
        </a>
        <a href="{{ route('gallery', ['category' => 'social']) }}" class="btn {{ $category == 'social' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.45rem 1.25rem;">
            યુવા & સેવા પ્રવૃત્તિ
        </a>
    </div>

    <!-- Gallery Grid -->
    <div class="gallery-grid">
        @forelse($items as $item)
            <div class="gallery-card">
                <div class="gallery-media">
                    <img src="{{ $item->media_url }}" alt="{{ $item->title }}" loading="lazy">
                    @if($item->media_type === 'instagram_reel')
                        <div class="gallery-type-badge" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);">
                            <i class="ri-instagram-line"></i> Instagram Reel
                        </div>
                    @else
                        <div class="gallery-type-badge">
                            <i class="ri-image-line"></i> ફોટો
                        </div>
                    @endif
                </div>
                <div class="gallery-content">
                    <h3 class="gallery-title">{{ $item->title }}</h3>
                    @if($item->caption)
                        <p class="gallery-caption">{{ $item->caption }}</p>
                    @endif
                    @if($item->media_type === 'instagram_reel')
                        <div style="margin-top: 1rem;">
                            <a href="https://www.instagram.com/reel/DeaWR2ft4JS/" target="_blank" class="btn btn-outline-gold" style="width: 100%; font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                                <i class="ri-play-circle-line"></i> રીલ પ્લે કરો
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column: span 3; text-align: center; padding: 3rem; color: var(--color-text-muted);">
                કોઈ મીડિયા મળેલ નથી.
            </div>
        @endforelse
    </div>

    <div style="margin-top: 2rem;">
        {{ $items->links() }}
    </div>

</div>

@endsection

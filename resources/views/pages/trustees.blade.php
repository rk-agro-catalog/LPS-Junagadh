@extends('layouts.app')

@section('title', 'ટ્રસ્ટી મંડળ & પ્રેરક આગેવાનો | LPS Junagadh')

@section('content')

<!-- Banner Header -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;">
            <i class="ri-user-star-fill"></i> સમાજ નેતૃત્વ
        </span>
        <h1>ટ્રસ્ટી મંડળ & કારોબારી સમિતિ</h1>
        <p>
            શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢના સેવાભાવી આગેવાનો અને માર્ગદર્શકો
        </p>
    </div>
</div>


<div class="container section-padding">

    <div class="trustees-grid" style="margin-bottom: 4rem;">
        @foreach($trustees as $trustee)
            <div class="trustee-card">
                <div class="trustee-avatar">
                    <i class="ri-user-star-line"></i>
                </div>
                <div class="trustee-info">
                    <h3 class="trustee-name">{{ $trustee->name }}</h3>
                    <div class="trustee-designation">{{ $trustee->designation }}</div>
                    @if($trustee->company_or_business)
                        <div class="trustee-business">{{ $trustee->company_or_business }}</div>
                    @endif
                    <div style="margin-top: 1rem; font-size: 0.85rem; color: var(--color-text-muted);">
                        <i class="ri-map-pin-line"></i> {{ $trustee->city }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Sardar Patel Inspiration Card -->
    <div style="background: linear-gradient(135deg, #1c1917 0%, #292524 100%); color: #fff; border-radius: var(--radius-xl); padding: 3rem; text-align: center; border: 2px solid var(--color-primary-light);">
        <i class="ri-medal-fill" style="font-size: 3rem; color: var(--color-gold);"></i>
        <h3 style="font-size: 1.8rem; font-weight: 800; margin: 1rem 0 0.5rem; color: #fef08a;">
            "સંગઠન એ જ આપણી સૌથી મોટી તાકાત છે"
        </h3>
        <p style="font-size: 1.1rem; line-height: 1.8; color: #e7e5e4; max-width: 800px; margin: 0 auto 1.5rem;">
            સરદાર વલ્લભભાઈ પટેલના આદર્શો અને માઁ ખોડલના આશીર્વાદ સાથે જૂનાગઢ લેઉવા પટેલ સમાજ તમામ જ્ઞાતિજનોના શિક્ષણ, સંસ્કાર અને સુખાકારી માટે કટિબદ્ધ છે.
        </p>
        <a href="{{ route('bhumidan') }}" class="btn btn-primary" style="font-size: 1rem;">
            <i class="ri-heart-3-fill"></i> સંકુલ નિર્માણમાં સહયોગ કરો
        </a>
    </div>

</div>

@endsection

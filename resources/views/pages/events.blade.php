@extends('layouts.app')

@section('title', 'સમાજ કાર્યક્રમો & ઉત્સવો | શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ')

@section('content')

<!-- Header Banner -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;">
            <i class="ri-calendar-event-fill"></i> સમાજ ઉત્સવ દર્શન
        </span>
        <h1>સમાજ કાર્યક્રમો & આગામી ઉત્સવો</h1>
        <p>
            શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ દ્વારા આયોજિત તમામ સામાજિક, શૈક્ષણિક અને ધાર્મિક કાર્યક્રમોની વિગત.
        </p>
    </div>
</div>

<div class="container section-padding">

    <!-- Category Filter Bar -->
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 2rem; justify-content: center;">
        <a href="{{ route('events') }}" class="btn {{ empty($category) || $category === 'all' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">
            તમામ કાર્યક્રમો
        </a>
        <a href="{{ route('events') }}?category=સ્નેહમિલન" class="btn {{ $category === 'સ્નેહમિલન' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">
            સ્નેહમિલન & સભા
        </a>
        <a href="{{ route('events') }}?category=આરોગ્ય" class="btn {{ $category === 'આરોગ્ય' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">
            રક્તદાન & આરોગ્ય
        </a>
        <a href="{{ route('events') }}?category=સામાજિક" class="btn {{ $category === 'સામાજિક' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">
            સામાજિક ઉત્સવો
        </a>
        <a href="{{ route('events') }}?category=ધાર્મિક" class="btn {{ $category === 'ધાર્મિક' ? 'btn-primary' : 'btn-outline-gold' }}" style="padding: 0.4rem 1rem; font-size: 0.85rem; border-radius: var(--radius-pill);">
            ધાર્મિક મહોત્સવ
        </a>
    </div>

    <!-- Section: Upcoming Events -->
    <div style="margin-bottom: 4rem;">
        <div style="margin-bottom: 1.5rem;">
            <span class="badge badge-gold">લાઈવ કેલેન્ડર</span>
            <h2 style="font-size: clamp(1.3rem, 2.5vw, 1.75rem); font-weight:700; color: var(--color-maroon); margin-top: 0.35rem;">
                આગામી કાર્યક્રમો (Upcoming Events)
            </h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.75rem;">
            @forelse($upcomingEvents as $event)
                <div style="background: #fff; border-radius: var(--radius-lg); overflow: hidden; border: 1.5px solid var(--color-border); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; transition: var(--transition-fast);">
                    
                    @if($event->image_url)
                        <div style="height: 190px; overflow: hidden; position: relative;">
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position: absolute; top: 1rem; right: 1rem;">
                                <span class="badge badge-gold" style="box-shadow: var(--shadow-sm);">{{ $event->category }}</span>
                            </div>
                        </div>
                    @else
                        <div style="height: 120px; background: var(--gradient-royal); display: flex; align-items: center; justify-content: space-between; padding: 1.25rem;">
                            <div class="brand-emblem" style="width: 48px; height: 48px; font-size: 1.5rem;">
                                <i class="ri-calendar-check-fill"></i>
                            </div>
                            <span class="badge badge-gold">{{ $event->category }}</span>
                        </div>
                    @endif

                    <div style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                        <!-- Date & Time Row -->
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.75rem; font-size: 0.85rem; color: var(--color-primary-light); font-weight: 600;">
                            <div>
                                <i class="ri-calendar-2-fill"></i> {{ $event->event_date->format('d M, Y') }}
                            </div>
                            @if($event->event_time)
                                <div>
                                    <i class="ri-time-fill"></i> {{ $event->event_time }}
                                </div>
                            @endif
                        </div>

                        <h3 style="font-size: 1.08rem; font-weight: 650; color: var(--color-maroon); margin-bottom: 0.65rem; line-height: 1.4;">
                            {{ $event->title }}
                        </h3>

                        <div style="font-size: 0.85rem; color: #4b5563; margin-bottom: 0.85rem; display: flex; align-items: flex-start; gap: 0.4rem;">
                            <i class="ri-map-pin-2-fill" style="color: var(--color-primary-light); font-size: 1rem; flex-shrink: 0; margin-top: 2px;"></i>
                            <span>{{ $event->venue }}</span>
                        </div>

                        @if($event->description)
                            <p style="font-size: 0.88rem; color: var(--color-text-muted); line-height: 1.6; margin-bottom: 1.25rem; flex-grow: 1;">
                                {{ Str::limit($event->description, 130) }}
                            </p>
                        @endif

                        <div style="border-top: 1px dashed var(--color-border); padding-top: 1rem; margin-top: auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                            <div style="font-size: 0.78rem; color: var(--color-text-muted);">
                                <strong>આયોજક:</strong> {{ Str::limit($event->organizer, 30) }}
                            </div>
                            <a href="https://wa.me/919093390934?text={{ urlencode('જય સરદાર. મને ' . $event->title . ' કાર્યક્રમ વિશે માહિતી મેળવવી છે.') }}" target="_blank" class="btn btn-outline-gold" style="font-size: 0.78rem; padding: 0.35rem 0.75rem; color: #15803d; border-color: #86efac; background: #f0fdf4;">
                                <i class="ri-whatsapp-line"></i> માહિતી મેળવો
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; background: #fff; border-radius: var(--radius-lg); padding: 3rem; text-align: center; border: 1.5px dashed var(--color-border);">
                    <i class="ri-calendar-line" style="font-size: 3rem; color: #9ca3af; margin-bottom: 0.5rem;"></i>
                    <h3 style="color: var(--color-text-main); font-weight:700;">હાલ કોઈ આગામી કાર્યક્રમ ઉપલબ્ધ નથી</h3>
                    <p style="color: var(--color-text-muted); font-size: 0.9rem; margin-top: 0.25rem;">નવા કાર્યક્રમો ટૂંક સમયમાં અહીં જાહેર કરવામાં આવશે.</p>
                </div>
            @endforelse
        </div>

        <div style="margin-top: 2rem;">
            {{ $upcomingEvents->links() }}
        </div>
    </div>

    <!-- Past Events Section -->
    @if($pastEvents->count() > 0)
    <div>
        <div style="margin-bottom: 1.5rem;">
            <span class="badge" style="background: #e2e8f0; color: #475569;">ઇતિહાસ દર્શન</span>
            <h2 style="font-size: clamp(1.15rem, 2vw, 1.4rem); font-weight: 700; color: var(--color-maroon); margin-top: 0.35rem;">
                સંપન્ન થયેલ સ્મૃતિ કાર્યક્રમો (Past Events)
            </h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">
            @foreach($pastEvents as $past)
                <div style="background: #fff; border-radius: var(--radius-md); padding: 1.25rem; border: 1px solid var(--color-border-subtle); box-shadow: var(--shadow-sm);">
                    <div style="font-size: 0.78rem; color: #64748b; font-weight: 600; margin-bottom: 0.35rem;">
                        <i class="ri-calendar-check-line"></i> {{ $past->event_date->format('d/m/Y') }}
                    </div>
                    <h4 style="font-size: 0.98rem; font-weight: 650; color: var(--color-text-main); margin-bottom: 0.35rem;">
                        {{ $past->title }}
                    </h4>
                    <div style="font-size: 0.8rem; color: var(--color-text-muted);">
                        <i class="ri-map-pin-line"></i> {{ Str::limit($past->venue, 35) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection

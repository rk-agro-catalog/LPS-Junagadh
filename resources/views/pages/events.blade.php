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
                <div class="event-card-clickable" 
                     onclick="openEventModal(this)"
                     data-title="{{ $event->title }}"
                     data-category="{{ $event->category }}"
                     data-date="{{ $event->event_date->format('d M, Y') }}"
                     data-time="{{ $event->event_time ?? '' }}"
                     data-venue="{{ $event->venue }}"
                     data-description="{{ $event->description }}"
                     data-organizer="{{ $event->organizer }}"
                     data-contact="{{ $event->contact_person }}"
                     data-image="{{ $event->image_url ?? '' }}"
                     data-whatsapp="https://wa.me/919093390934?text={{ urlencode('જય સરદાર. મને ' . $event->title . ' કાર્યક્રમ વિશે માહિતી મેળવવી છે.') }}"
                     style="background: #fff; border-radius: var(--radius-lg); overflow: hidden; border: 1.5px solid var(--color-border); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='var(--shadow-md)'; this.style.borderColor='var(--color-primary-light)';"
                     onmouseout="this.style.transform='none'; this.style.boxShadow='var(--shadow-sm)'; this.style.borderColor='var(--color-border)';">
                    
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
                            <span style="font-size: 0.8rem; color: var(--color-primary-dark); font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <i class="ri-eye-line"></i> વિગત જુઓ
                            </span>
                            <a href="https://wa.me/919093390934?text={{ urlencode('જય સરદાર. મને ' . $event->title . ' કાર્યક્રમ વિશે માહિતી મેળવવી છે.') }}" target="_blank" onclick="event.stopPropagation()" class="btn btn-outline-gold" style="font-size: 0.78rem; padding: 0.35rem 0.75rem; color: #15803d; border-color: #86efac; background: #f0fdf4;">
                                <i class="ri-whatsapp-line"></i> WhatsApp
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

<!-- Event Details Modal Dialog -->
<div id="eventDetailsModal" class="event-modal-backdrop" onclick="if(event.target === this) closeEventModal()" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); z-index: 99999; backdrop-filter: blur(5px); align-items: center; justify-content: center; padding: 1rem; overflow-y: auto;">
    <div class="event-modal-dialog" style="background: #ffffff; width: 100%; max-width: 640px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden; margin: auto; animation: eventModalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1); border: 1px solid var(--color-border); max-height: 90vh; display: flex; flex-direction: column;">
        <!-- Header Banner -->
        <div id="modalBannerWrap" style="height: 200px; position: relative; background: var(--gradient-royal); overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
            <img id="modalImage" src="" alt="" style="width: 100%; height: 100%; object-fit: cover; display: none;">
            <div id="modalFallbackIcon" style="text-align: center; color: #fef08a;">
                <i class="ri-calendar-event-fill" style="font-size: 3.5rem;"></i>
            </div>
            <span id="modalCategory" class="badge badge-gold" style="position: absolute; top: 1rem; left: 1rem; font-size: 0.82rem; box-shadow: var(--shadow-sm);"></span>
            <button type="button" onclick="closeEventModal()" aria-label="Close" style="position: absolute; top: 0.85rem; right: 0.85rem; width: 34px; height: 34px; border-radius: 50%; background: rgba(0,0,0,0.55); color: #ffffff; border: none; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='rgba(0,0,0,0.85)'" onmouseout="this.style.background='rgba(0,0,0,0.55)'">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <!-- Content Area -->
        <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1;">
            <h2 id="modalTitle" style="font-size: 1.3rem; font-weight: 750; color: var(--color-maroon); margin-bottom: 1rem; line-height: 1.35;"></h2>

            <!-- Quick Details Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem; background: #fafaf9; padding: 1rem; border-radius: 12px; border: 1px solid #f0eeeb;">
                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-calendar-2-fill" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">તારીખ & સમય</div>
                        <div style="font-weight: 650; color: #1f2937; font-size: 0.88rem;"><span id="modalDate"></span> <span id="modalTime" style="color: #4b5563; font-weight: 500;"></span></div>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-map-pin-2-fill" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">સ્થળ (Venue)</div>
                        <div id="modalVenue" style="font-weight: 600; color: #1f2937; font-size: 0.88rem; line-height: 1.4;"></div>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-building-line" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">આયોજક</div>
                        <div id="modalOrganizer" style="font-weight: 600; color: #1f2937; font-size: 0.88rem;"></div>
                    </div>
                </div>

                <div style="display: flex; align-items: flex-start; gap: 0.6rem;">
                    <i class="ri-phone-fill" style="color: var(--color-primary-light); font-size: 1.15rem; flex-shrink: 0; margin-top: 1px;"></i>
                    <div>
                        <div style="font-size: 0.72rem; color: #6b7280; font-weight: 600; text-transform: uppercase;">સંપર્ક / ઇન્ક્વાયરી</div>
                        <div id="modalContact" style="font-weight: 600; color: #1f2937; font-size: 0.88rem;"></div>
                    </div>
                </div>
            </div>

            <!-- Full Description -->
            <div style="margin-bottom: 0.5rem;">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: #374151; margin-bottom: 0.4rem; display: flex; align-items: center; gap: 0.35rem;">
                    <i class="ri-information-fill" style="color: var(--color-primary-light);"></i> કાર્યક્રમ પરિચય & વિગત
                </h4>
                <div id="modalDescription" style="font-size: 0.9rem; color: #4b5563; line-height: 1.7; white-space: pre-line; background: #ffffff; padding: 0.85rem 1rem; border-radius: 8px; border: 1.5px dashed var(--color-border);"></div>
            </div>
        </div>

        <!-- Footer -->
        <div style="display: flex; justify-content: flex-end; align-items: center; gap: 0.75rem; padding: 1rem 1.5rem; background: #f9fafb; border-top: 1px solid #e5e7eb; flex-shrink: 0;">
            <button type="button" onclick="closeEventModal()" class="btn btn-outline" style="font-size: 0.85rem; padding: 0.45rem 1.25rem;">
                બંધ કરો
            </button>
            <a id="modalWhatsAppBtn" href="#" target="_blank" class="btn" style="background: #15803d; color: #ffffff; font-size: 0.85rem; padding: 0.45rem 1.25rem; display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none; border-radius: var(--radius-md);">
                <i class="ri-whatsapp-line" style="font-size: 1.1rem;"></i> WhatsApp પર પૂછપરછ
            </a>
        </div>
    </div>
</div>

<style>
@keyframes eventModalPop {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
function openEventModal(card) {
    const modal = document.getElementById('eventDetailsModal');
    if (!modal) return;

    document.getElementById('modalTitle').textContent = card.dataset.title || '';
    document.getElementById('modalCategory').textContent = card.dataset.category || 'સમાજ ઉત્સવ';
    document.getElementById('modalDate').textContent = card.dataset.date || '';
    document.getElementById('modalTime').textContent = card.dataset.time ? (' | ' + card.dataset.time) : '';
    document.getElementById('modalVenue').textContent = card.dataset.venue || 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ, જૂનાગઢ';
    document.getElementById('modalOrganizer').textContent = card.dataset.organizer || 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ';
    document.getElementById('modalContact').textContent = card.dataset.contact || 'ટ્રસ્ટ કાર્યાલય';
    document.getElementById('modalDescription').textContent = card.dataset.description || 'કાર્યક્રમની વધુ માહિતી કાર્યાલય ખાતેથી મળી રહેશે.';
    document.getElementById('modalWhatsAppBtn').href = card.dataset.whatsapp || '#';

    const img = document.getElementById('modalImage');
    const fallback = document.getElementById('modalFallbackIcon');
    if (card.dataset.image && card.dataset.image.trim() !== '') {
        img.src = card.dataset.image;
        img.style.display = 'block';
        fallback.style.display = 'none';
    } else {
        img.style.display = 'none';
        fallback.style.display = 'block';
    }

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEventModal() {
    const modal = document.getElementById('eventDetailsModal');
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventModal();
    }
});
</script>

@endsection

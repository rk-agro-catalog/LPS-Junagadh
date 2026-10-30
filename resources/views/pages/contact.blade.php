@extends('layouts.app')

@section('title', 'સંપર્ક & સંકુલ સ્થળ નિર્દેશ | LPS Junagadh')

@section('content')

<!-- Header Banner -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;">
            <i class="ri-map-pin-2-fill"></i> સંકુલ દર્શન
        </span>
        <h1>સંપર્ક & સંકુલ સરનામું</h1>
        <p>
            શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ (LPS) સાથે સીધો સંપર્ક કરો
        </p>
    </div>
</div>


<div class="container section-padding">
    <div class="contact-grid" style="margin-bottom: 4rem;">
        <!-- Left: Official Contact Details -->
        <div class="contact-info-card">
            <span class="badge badge-gold" style="margin-bottom: 0.75rem;">સત્તાવાર ટ્રસ્ટ કાર્યાલય</span>
            <h3 style="font-size: clamp(1.25rem, 2.5vw, 1.55rem); font-weight: 700; color: #ffffff !important;">શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ</h3>
            <p style="font-size: 1rem; line-height: 1.7; color: rgba(255, 255, 255, 0.92) !important;">
                કોઈપણ પ્રકારની પૂછપરછ, હોલ કે પાર્ટી પ્લોટ બુકિંગ, અથવા ભૂમિદાન યોજના અંગે માહિતી મેળવવા માટે અમારો સંપર્ક કરો.
            </p>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-map-pin-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1rem; color: #fef08a !important;">સંકુલ સરનામું:</strong>
                    <span style="font-size: 0.95rem; line-height: 1.6; color: #ffffff;">
                        જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, સોનરખ નદીના કાંઠે, જૂનાગઢ, ગુજરાત - ૩૬૨૦૦૧.
                    </span>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-phone-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1rem; color: #fef08a;">સત્તાવાર હેલ્પલાઇન:</strong>
                    <a href="tel:9093390934" style="color: #fff; font-size: 1.25rem; font-weight:700; font-family: var(--font-latin);">
                        909 33 909 34
                    </a>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-whatsapp-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1rem; color: #fef08a;">વોટ્સએપ સપોર્ટ:</strong>
                    <a href="https://wa.me/919093390934" target="_blank" style="color: #fff; font-size: 1.05rem; font-weight:600;">
                        909 33 909 34 પર મેસેજ કરો
                    </a>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon"><i class="ri-instagram-fill"></i></div>
                <div>
                    <strong style="display:block; font-size: 1.1rem; color: #fef08a;">ઇન્સ્ટાગ્રામ હેન્ડલ:</strong>
                    <a href="https://www.instagram.com/explore/locations/265511100633813/khodaldham-yuva-samiti-junagadh/" target="_blank" style="color: #fef08a; font-weight:700;">
                        @leuvapateltrust_junagadh
                    </a>
                </div>
            </div>
        </div>

        <!-- Right: Inquiry Form -->
        <div class="form-card">
            <h3 style="font-size: 1.35rem; color: var(--color-maroon); font-weight: 700; margin-bottom: 0.4rem;">
                સંદેશો અથવા સૂચન મોકલો
            </h3>
            <p style="font-size: 0.95rem; color: var(--color-text-muted); margin-bottom: 1.5rem;">
                આપનું કોઈ પણ સૂચન કે પ્રશ્ન હોય તો નીચેનું ફોર્મ ભરી મોકલી શકો છો.
            </p>

            <form action="{{ route('contact.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">આપનું નામ *</label>
                        <input type="text" name="name" class="form-control" placeholder="પૂરું નામ લખો" autocomplete="off" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">મોબાઈલ નંબર *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="૧૦ અંકનો નંબર" autocomplete="off" required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">ઈમેઈલ (વૈકલ્પિક)</label>
                        <input type="email" name="email" class="form-control" placeholder="email@example.com" autocomplete="off">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">વિષય *</label>
                        <input type="text" name="subject" class="form-control" placeholder="પૂછપરછનો વિષય" autocomplete="off" required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">વિગતવાર સંદેશો *</label>
                        <textarea name="message" rows="4" class="form-control" placeholder="તમારો સંદેશો અહીં લખો..." autocomplete="off" required></textarea>
                    </div>

                    <div class="form-group full-width">
                        <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.05rem; padding: 0.85rem;">
                            <i class="ri-send-plane-fill"></i> સંદેશો સબમિટ કરો
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Location Map View -->
    <div style="background: #fff; border-radius: var(--radius-lg); overflow: hidden; border: 1.5px solid var(--color-border); box-shadow: var(--shadow-md);">
        <div style="padding: 1.5rem 2rem; background: var(--color-surface); border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h4 style="font-size: 1.25rem; font-weight: 800; color: var(--color-maroon);">
                    <i class="ri-map-2-line"></i> સંકુલ લોકેશન નકશો (Google Maps)
                </h4>
                <p style="font-size: 0.88rem; color: var(--color-text-muted);">જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, સોનરખ નદી કાંઠે</p>
            </div>
            <a href="https://maps.google.com/?q=Junagadh+Bypass+Khalilpur+Chowkdi+Junagadh" target="_blank" class="btn btn-primary" style="font-size: 0.85rem; padding: 0.45rem 1rem;">
                <i class="ri-direction-line"></i> દિશા-નિર્દેશ (Directions)
            </a>
        </div>
        <div style="height: 380px; width: 100%; background: #e2e8f0; position: relative;">
            <iframe 
                src="https://maps.google.com/maps?q=Khalilpur+Chowkdi+Junagadh+Gujarat&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>

@endsection

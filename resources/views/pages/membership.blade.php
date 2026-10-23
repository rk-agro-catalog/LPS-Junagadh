@extends('layouts.app')

@section('title', 'સમાજ ડિરેક્ટરી સભ્ય નોંધણી | LPS Junagadh')

@section('content')

<!-- Header Banner -->
<div class="page-header-banner">
    <div class="container">
        <span class="badge badge-gold" style="margin-bottom: 0.5rem;">
            <i class="ri-user-add-fill"></i> એકતા અને સંગઠન
        </span>
        <h1>સમાજ ડિરેક્ટરી સભ્ય નોંધણી</h1>
        <p>
            સમસ્ત લેઉવા પટેલ સમાજ - જૂનાગઢ પરિવારના સભ્ય બનો અને સમાજની તમામ પ્રવૃત્તિઓ સાથે જોડાયેલા રહો.
        </p>
    </div>
</div>

<div class="container section-padding">
    <div style="max-width: 850px; margin: 0 auto;">
        <div class="form-card">
            <h2 style="font-size: clamp(1.2rem, 3vw, 1.55rem); color: var(--color-maroon); font-weight: 800; margin-bottom: 0.4rem;">
                જ્ઞાતિ સભ્ય રજીસ્ટ્રેશન ફોર્મ
            </h2>
            <p style="font-size: 0.95rem; color: var(--color-text-muted); margin-bottom: 1.75rem;">
                નીચેની તમામ વિગતો યોગ્ય રીતે ભરો જેથી આપની વિગતો સમાજ ડિરેક્ટરીમાં સુરક્ષિત રીતે સચવાયેલી રહે.
            </p>

            <form action="{{ route('membership.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">પૂરું નામ (પોતાનું નામ) *</label>
                        <input type="text" name="full_name" class="form-control" placeholder="નામ લખો..." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">પિતા / પતિનું નામ</label>
                        <input type="text" name="father_or_husband_name" class="form-control" placeholder="પિતા અથવા પતિનું નામ...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">અટક (Surname) *</label>
                        <input type="text" name="surname" class="form-control" value="પટેલ" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">લિંગ (Gender) *</label>
                        <select name="gender" class="form-control" required>
                            <option value="male">પુરૂષ (Male)</option>
                            <option value="female">મહિલા (Female)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">બ્લડ ગ્રૂપ (Blood Group)</label>
                        <select name="blood_group" class="form-control">
                            <option value="">-- બ્લડ ગ્રૂપ પસંદ કરો --</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">મૂળ ગામ (Native Village)</label>
                        <input type="text" name="native_village" class="form-control" placeholder="દા.ત. વંથલી, કેશોદ, બિલખા...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">મોબાઈલ નંબર *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="૧૦ અંકનો મોબાઈલ નંબર" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">વોટ્સએપ નંબર</label>
                        <input type="tel" name="whatsapp" class="form-control" placeholder="વોટ્સએપ નંબર">
                    </div>

                    <div class="form-group">
                        <label class="form-label">વ્યવસાય / નોકરી / ખેતી</label>
                        <input type="text" name="occupation" class="form-control" placeholder="દા.ત. વેપાર, નોકરી, ખેતી...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">પરિવારના કુલ સભ્યોની સંખ્યા *</label>
                        <input type="number" name="family_members_count" class="form-control" value="4" min="1" required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">હાલનું રહેઠાણનું સરનામું *</label>
                        <textarea name="current_address" rows="2" class="form-control" placeholder="સોસાયટી, રોડ, વિસ્તાર..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">શહેર / તાલુકો *</label>
                        <input type="text" name="city" class="form-control" value="જૂનાગઢ" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">પીનકોડ</label>
                        <input type="text" name="pincode" class="form-control" placeholder="362001">
                    </div>

                    <div class="form-group full-width" style="margin-top: 0.5rem;">
                        <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.05rem; padding: 0.85rem;">
                            <i class="ri-user-add-line"></i> સભ્ય તરીકે નોંધણી પૂર્ણ કરો
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

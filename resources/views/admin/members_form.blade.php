@extends('layouts.admin')

@section('title', $mode === 'create' ? 'નવા જ્ઞાતિ સભ્ય ઉમેરો' : 'સભ્ય વિગતો સુધારો')
@section('header_title', $mode === 'create' ? 'ઓફલાઇન સભ્ય નોંધણી' : 'સભ્ય વિગતો સુધારો')

@section('content')

<div style="max-width: 820px; margin: 0 auto;">
    <div style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
        <a href="{{ route('admin.members') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.84rem;">
            <i class="ri-arrow-left-line"></i> સભ્યો યાદી પર પાછા જાઓ
        </a>
        <span class="badge badge-gold">
            {{ $mode === 'create' ? 'ઓફલાઇન વસ્તી ગણતરી ફોર્મ' : 'સભ્ય કોડ: ' . $member->member_code }}
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
        <form action="{{ $mode === 'create' ? route('admin.members.store') : route('admin.members.updateRecord', $member->id) }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">પૂરું નામ *</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $member->full_name) }}" placeholder="દા.ત. રમેશભાઈ હરિભાઈ" required>
                </div>

                <div class="form-group">
                    <label class="form-label">પિતા / પતિનું નામ</label>
                    <input type="text" name="father_or_husband_name" class="form-control" value="{{ old('father_or_husband_name', $member->father_or_husband_name) }}" placeholder="દા.ત. હરિભાઈ">
                </div>

                <div class="form-group">
                    <label class="form-label">અટક *</label>
                    <input type="text" name="surname" class="form-control" value="{{ old('surname', $member->surname ?? 'પટેલ') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">જાતિ (Gender) *</label>
                    <select name="gender" class="form-control" required>
                        <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>પુરુષ (Male)</option>
                        <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>મહિલા (Female)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">બ્લડ ગ્રૂપ (Blood Group)</label>
                    <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', $member->blood_group) }}" placeholder="દા.ત. B+, O+, A+...">
                </div>

                <div class="form-group">
                    <label class="form-label">મૂળ વતન / ગામ</label>
                    <input type="text" name="native_village" class="form-control" value="{{ old('native_village', $member->native_village) }}" placeholder="દા.ત. વંથલી, કેશોદ, વિસાવદર...">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">હાલનું સરનામું *</label>
                    <input type="text" name="current_address" class="form-control" value="{{ old('current_address', $member->current_address) }}" placeholder="સોસાયટી, શેરી, વિસ્તાર..." required>
                </div>

                <div class="form-group">
                    <label class="form-label">હાલનું શહેર *</label>
                    <input type="text" name="city" class="form-control" value="{{ old('city', $member->city ?? 'જૂનાગઢ') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">પીનકોડ</label>
                    <input type="text" name="pincode" class="form-control" value="{{ old('pincode', $member->pincode ?? '362001') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">મોબાઈલ નંબર *</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}" placeholder="૧૦ અંકનો નંબર" required>
                </div>

                <div class="form-group">
                    <label class="form-label">વોટ્સએપ નંબર</label>
                    <input type="tel" name="whatsapp" class="form-control" value="{{ old('whatsapp', $member->whatsapp) }}" placeholder="વોટ્સએપ નંબર">
                </div>

                <div class="form-group">
                    <label class="form-label">વ્યવસાય / ધંધો</label>
                    <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $member->occupation) }}" placeholder="દા.ત. ખેતી, વેપાર, નોકરી...">
                </div>

                <div class="form-group">
                    <label class="form-label">પરિવારના સભ્યોની સંખ્યા *</label>
                    <input type="number" name="family_members_count" class="form-control" value="{{ old('family_members_count', $member->family_members_count ?? 4) }}" min="1" required>
                </div>

                <div class="form-group">
                    <label class="form-label">સભ્યપદ સ્ટેટસ *</label>
                    <select name="status" class="form-control" required>
                        <option value="approved" {{ old('status', $member->status) == 'approved' ? 'selected' : '' }}>મંજૂર (Approved)</option>
                        <option value="pending" {{ old('status', $member->status) == 'pending' ? 'selected' : '' }}>પેન્ડિંગ (Pending Review)</option>
                        <option value="rejected" {{ old('status', $member->status) == 'rejected' ? 'selected' : '' }}>અસ્વીકૃત (Rejected)</option>
                    </select>
                </div>

                <div class="form-group full-width" style="margin-top: 1rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="submit" class="admin-quick-pill primary" style="padding: 0.75rem 1.75rem; font-size: 0.95rem; border: none; cursor: pointer;">
                        <i class="ri-save-line"></i> {{ $mode === 'create' ? 'સભ્ય નોંધણી કરો' : 'ફેરફાર સેવ કરો' }}
                    </button>
                    <a href="{{ route('admin.members') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.75rem 1.5rem;">
                        રદ કરો
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

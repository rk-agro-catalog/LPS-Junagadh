@extends('layouts.admin')

@section('title', 'હોલ & પ્લોટ બુકિંગ ઇન્ક્વાયરી')
@section('header_title', 'બુકિંગ ઇન્ક્વાયરી વ્યવસ્થાપન')

@section('content')

<div style="background: #fff; border-radius: var(--radius-lg); padding: 1.75rem; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-maroon);">બધી બુકિંગ અરજીઓ</h3>
            <p style="font-size: 0.85rem; color: var(--color-text-muted);">વિભાગ-૧, વિભાગ-૨ અને અતિથિ ભવન બુકિંગ વિગતો</p>
        </div>

        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.bookings') }}" class="btn {{ empty(request('status')) ? 'btn-primary' : 'btn-outline-gold' }}" style="font-size: 0.8rem; padding: 0.35rem 0.8rem;">બધા</a>
            <a href="{{ route('admin.bookings', ['status' => 'new']) }}" class="btn {{ request('status') == 'new' ? 'btn-primary' : 'btn-outline-gold' }}" style="font-size: 0.8rem; padding: 0.35rem 0.8rem;">નવી અરજીઓ</a>
            <a href="{{ route('admin.bookings', ['status' => 'confirmed']) }}" class="btn {{ request('status') == 'confirmed' ? 'btn-primary' : 'btn-outline-gold' }}" style="font-size: 0.8rem; padding: 0.35rem 0.8rem;">કન્ફર્મ</a>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
            <thead>
                <tr style="background: var(--color-surface); border-bottom: 2px solid var(--color-border);">
                    <th style="padding: 0.75rem 1rem;">ઇન્ક્વાયરી નં.</th>
                    <th style="padding: 0.75rem 1rem;">અરજદારનું નામ</th>
                    <th style="padding: 0.75rem 1rem;">મોબાઈલ</th>
                    <th style="padding: 0.75rem 1rem;">વિભાગ & સુવિધા</th>
                    <th style="padding: 0.75rem 1rem;">પ્રસંગ તારીખ</th>
                    <th style="padding: 0.75rem 1rem; text-align: center;">મહેમાનો</th>
                    <th style="padding: 0.75rem 1rem; text-align: center;">સ્ટેટસ અપડેટ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                    <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                        <td style="padding: 0.75rem 1rem; font-family: var(--font-latin); font-weight: 700; color: var(--color-primary-light);">
                            {{ $b->inquiry_number }}
                        </td>
                        <td style="padding: 0.75rem 1rem; font-weight: 700;">
                            {{ $b->applicant_name }}
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $b->city_or_village }}</div>
                        </td>
                        <td style="padding: 0.75rem 1rem;">
                            <a href="tel:{{ $b->phone }}" style="color: var(--color-text-main); font-weight:600;">
                                <i class="ri-phone-line"></i> {{ $b->phone }}
                            </a>
                        </td>
                        <td style="padding: 0.75rem 1rem;">
                            <span class="badge badge-gold">{{ $b->section_type }}</span>
                            <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 2px;">{{ $b->facility_name }}</div>
                        </td>
                        <td style="padding: 0.75rem 1rem; font-weight: 700; color: var(--color-maroon);">
                            {{ $b->event_date->format('d/m/Y') }}
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $b->event_type }}</div>
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: center;">
                            {{ $b->approx_guests }}
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: center;">
                            <form action="{{ route('admin.bookings.update', $b->id) }}" method="POST" style="display: flex; gap: 0.35rem; justify-content: center;">
                                @csrf
                                <select name="status" class="form-control" style="font-size: 0.78rem; padding: 0.25rem 0.5rem; width: 110px;" onchange="this.form.submit()">
                                    <option value="new" {{ $b->status === 'new' ? 'selected' : '' }}>નવી (New)</option>
                                    <option value="in_review" {{ $b->status === 'in_review' ? 'selected' : '' }}>વિચારણા હેઠળ</option>
                                    <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>કન્ફર્મ</option>
                                    <option value="rejected" {{ $b->status === 'rejected' ? 'selected' : '' }}>રદ કરેલ</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">
                            કોઈ બુકિંગ ઇન્ક્વાયરી નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $bookings->links() }}
    </div>
</div>

@endsection

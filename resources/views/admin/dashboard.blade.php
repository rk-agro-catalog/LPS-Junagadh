@extends('layouts.admin')

@section('title', 'એડમિન ડેશબોર્ડ Overview')
@section('header_title', 'ટ્રસ્ટ પ્રબંધન ડેશબોર્ડ Overview')

@section('content')

<!-- Stat Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: #fff; padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
        <div style="font-size: 0.85rem; font-weight:700; color: var(--color-text-muted);">કુલ ભૂમિદાન રકમ</div>
        <div style="font-size: 1.8rem; font-weight:900; color: var(--color-maroon); margin: 0.25rem 0;">₹ {{ number_format($stats['total_donation']) }}/-</div>
        <span class="badge badge-gold">{{ number_format($stats['total_yards']) }} ચોરસ વાર</span>
    </div>

    <div style="background: #fff; padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
        <div style="font-size: 0.85rem; font-weight:700; color: var(--color-text-muted);">કુલ દાતાશ્રીઓ</div>
        <div style="font-size: 1.8rem; font-weight:900; color: var(--color-primary-light); margin: 0.25rem 0;">{{ $stats['total_donors'] }}</div>
        <a href="{{ route('admin.bhumidans') }}" style="font-size: 0.8rem; color: var(--color-primary-dark); font-weight:700;">દાતા યાદી જુઓ →</a>
    </div>

    <div style="background: #fff; padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
        <div style="font-size: 0.85rem; font-weight:700; color: var(--color-text-muted);">નવી બુકિંગ ઇન્ક્વાયરી</div>
        <div style="font-size: 1.8rem; font-weight:900; color: #d97706; margin: 0.25rem 0;">{{ $stats['new_inquiries'] }}</div>
        <span class="badge badge-maroon">કુલ: {{ $stats['total_inquiries'] }} ઇન્ક્વાયરી</span>
    </div>

    <div style="background: #fff; padding: 1.5rem; border-radius: var(--radius-lg); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
        <div style="font-size: 0.85rem; font-weight:700; color: var(--color-text-muted);">નોંધાયેલ જ્ઞાતિ સભ્યો</div>
        <div style="font-size: 1.8rem; font-weight:900; color: var(--color-accent-green); margin: 0.25rem 0;">{{ $stats['total_members'] }}</div>
        <a href="{{ route('admin.members') }}" style="font-size: 0.8rem; color: var(--color-accent-green); font-weight:700;">ડિરેક્ટરી ખોલો →</a>
    </div>
</div>

<!-- Two columns: Recent Donors & Recent Bookings -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    <!-- Recent Donors -->
    <div style="background: #fff; border-radius: var(--radius-lg); padding: 1.75rem; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--color-maroon);">તાજા ભૂમિદાતાઓ</h3>
            <a href="{{ route('admin.bhumidans') }}" class="btn btn-outline-gold" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">બધા જુઓ</a>
        </div>

        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-border); text-align: left; color: var(--color-text-muted);">
                    <th style="padding: 0.5rem 0;">દાતાનું નામ</th>
                    <th style="padding: 0.5rem 0;">ચોરસ વાર</th>
                    <th style="padding: 0.5rem 0; text-align: right;">રકમ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentDonations as $d)
                    <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                        <td style="padding: 0.75rem 0; font-weight: 700;">
                            {{ $d->donor_name }}
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $d->receipt_number }} • {{ $d->city }}</div>
                        </td>
                        <td style="padding: 0.75rem 0;">
                            <span class="badge badge-gold">{{ $d->sq_yards }} વાર</span>
                        </td>
                        <td style="padding: 0.75rem 0; text-align: right; font-weight: 800; color: var(--color-maroon);">
                            ₹ {{ number_format($d->total_amount) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Booking Inquiries -->
    <div style="background: #fff; border-radius: var(--radius-lg); padding: 1.75rem; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1.2rem; font-weight: 800; color: var(--color-maroon);">તાજી બુકિંગ ઇન્ક્વાયરી</h3>
            <a href="{{ route('admin.bookings') }}" class="btn btn-outline-gold" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;">બધી જુઓ</a>
        </div>

        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-border); text-align: left; color: var(--color-text-muted);">
                    <th style="padding: 0.5rem 0;">અરજદાર</th>
                    <th style="padding: 0.5rem 0;">સુવિધા / તારીખ</th>
                    <th style="padding: 0.5rem 0; text-align: right;">સ્ટેટસ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentInquiries as $b)
                    <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                        <td style="padding: 0.75rem 0; font-weight: 700;">
                            {{ $b->applicant_name }}
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $b->phone }}</div>
                        </td>
                        <td style="padding: 0.75rem 0;">
                            <div>{{ $b->section_type }}</div>
                            <div style="font-size: 0.75rem; color: var(--color-primary-light);">{{ $b->event_date->format('d/m/Y') }}</div>
                        </td>
                        <td style="padding: 0.75rem 0; text-align: right;">
                            <span class="badge {{ $b->status === 'new' ? 'badge-maroon' : 'badge-green' }}">
                                {{ $b->status === 'new' ? 'નવી' : $b->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 1rem; text-align: center; color: var(--color-text-muted);">હાલ કોઈ ઇન્ક્વાયરી નથી.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

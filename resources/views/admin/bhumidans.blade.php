@extends('layouts.admin')

@section('title', 'ભૂમિદાન વ્યવસ્થાપન')
@section('header_title', 'ભૂમિદાન દાતાઓનું વ્યવસ્થાપન')

@section('content')

<div style="background: #fff; border-radius: var(--radius-lg); padding: 1.75rem; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-maroon);">બધા ભૂમિદાતાઓ</h3>
            <p style="font-size: 0.85rem; color: var(--color-text-muted);">સંકુલ નિર્માણમાં સહયોગી દાતાઓની સંપૂર્ણ યાદી</p>
        </div>

        <form action="{{ route('admin.bhumidans') }}" method="GET" style="display: flex; gap: 0.5rem;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="દાતાનું નામ, ફોન, ગામ..." class="form-control" style="width: 250px;">
            <button type="submit" class="btn btn-primary" style="padding: 0.45rem 1rem;">
                <i class="ri-search-line"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.bhumidans') }}" class="btn btn-outline-gold" style="padding: 0.45rem 0.8rem;">
                    <i class="ri-close-line"></i>
                </a>
            @endif
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
            <thead>
                <tr style="background: var(--color-surface); border-bottom: 2px solid var(--color-border);">
                    <th style="padding: 0.75rem 1rem;">રસીદ નં.</th>
                    <th style="padding: 0.75rem 1rem;">દાતાશ્રીનું નામ</th>
                    <th style="padding: 0.75rem 1rem;">સંપર્ક નંબર</th>
                    <th style="padding: 0.75rem 1rem;">ગામ / શહેર</th>
                    <th style="padding: 0.75rem 1rem; text-align: center;">ચોરસ વાર</th>
                    <th style="padding: 0.75rem 1rem; text-align: right;">સહયોગ રકમ</th>
                    <th style="padding: 0.75rem 1rem; text-align: center;">સ્ટેટસ</th>
                    <th style="padding: 0.75rem 1rem; text-align: center;">એક્શન</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bhumidans as $d)
                    <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                        <td style="padding: 0.75rem 1rem; font-family: var(--font-latin); font-weight: 700; color: var(--color-primary-light);">
                            {{ $d->receipt_number }}
                        </td>
                        <td style="padding: 0.75rem 1rem; font-weight: 700;">
                            {{ $d->donor_name }}
                        </td>
                        <td style="padding: 0.75rem 1rem; font-family: var(--font-latin);">
                            {{ $d->phone }}
                        </td>
                        <td style="padding: 0.75rem 1rem; color: var(--color-text-muted);">
                            {{ $d->village ? $d->village . ', ' : '' }}{{ $d->city }}
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: center;">
                            <span class="badge badge-gold">{{ $d->sq_yards }} વાર</span>
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: right; font-weight: 800; color: var(--color-maroon);">
                            ₹ {{ number_format($d->total_amount) }}/-
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: center;">
                            <span class="badge {{ $d->status === 'verified' ? 'badge-green' : 'badge-maroon' }}">
                                {{ $d->status === 'verified' ? 'વેરીફાઈડ' : 'પેન્ડિંગ' }}
                            </span>
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: center;">
                            <a href="{{ route('receipt', $d->receipt_number) }}" target="_blank" class="btn btn-outline-gold" style="font-size: 0.75rem; padding: 0.25rem 0.6rem;">
                                <i class="ri-printer-line"></i> રસીદ
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">
                            કોઈ ભૂમિદાન રેકોર્ડ મળેલ નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $bhumidans->links() }}
    </div>
</div>

@endsection

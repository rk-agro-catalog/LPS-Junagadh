@extends('layouts.admin')

@section('title', 'જ્ઞાતિ સભ્યો ડિરેક્ટરી')
@section('header_title', 'જ્ઞાતિ સભ્યો ડિરેક્ટરી વ્યવસ્થાપન')

@section('content')

<div style="background: #fff; border-radius: var(--radius-lg); padding: 1.75rem; border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--color-maroon);">નોંધાયેલ પરિવારો</h3>
            <p style="font-size: 0.85rem; color: var(--color-text-muted);">સમસ્ત લેઉવા પટેલ સમાજ - જૂનાગઢ ડિરેક્ટરી</p>
        </div>

        <form action="{{ route('admin.members') }}" method="GET" style="display: flex; gap: 0.5rem;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="નામ, સભ્ય કોડ, ગામ..." class="form-control" style="width: 250px;">
            <button type="submit" class="btn btn-primary" style="padding: 0.45rem 1rem;">
                <i class="ri-search-line"></i>
            </button>
            @if(request('search'))
                <a href="{{ route('admin.members') }}" class="btn btn-outline-gold" style="padding: 0.45rem 0.8rem;">
                    <i class="ri-close-line"></i>
                </a>
            @endif
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; text-align: left;">
            <thead>
                <tr style="background: var(--color-surface); border-bottom: 2px solid var(--color-border);">
                    <th style="padding: 0.75rem 1rem;">સભ્ય કોડ</th>
                    <th style="padding: 0.75rem 1rem;">સભ્યનું પૂરું નામ</th>
                    <th style="padding: 0.75rem 1rem;">મૂળ ગામ</th>
                    <th style="padding: 0.75rem 1rem;">સંપર્ક નંબર</th>
                    <th style="padding: 0.75rem 1rem;">બ્લડ ગ્રૂપ</th>
                    <th style="padding: 0.75rem 1rem;">વ્યવસાય</th>
                    <th style="padding: 0.75rem 1rem; text-align: center;">પરિવાર સભ્યો</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $m)
                    <tr style="border-bottom: 1px solid var(--color-border-subtle);">
                        <td style="padding: 0.75rem 1rem; font-family: var(--font-latin); font-weight: 700; color: var(--color-primary-light);">
                            {{ $m->member_code }}
                        </td>
                        <td style="padding: 0.75rem 1rem; font-weight: 700;">
                            {{ $m->full_name }} {{ $m->father_or_husband_name ? '(' . $m->father_or_husband_name . ')' : '' }} {{ $m->surname }}
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $m->current_address }}, {{ $m->city }}</div>
                        </td>
                        <td style="padding: 0.75rem 1rem;">
                            {{ $m->native_village ?? '-' }}
                        </td>
                        <td style="padding: 0.75rem 1rem; font-family: var(--font-latin);">
                            {{ $m->phone }}
                        </td>
                        <td style="padding: 0.75rem 1rem;">
                            <span class="badge badge-maroon">{{ $m->blood_group ?? '-' }}</span>
                        </td>
                        <td style="padding: 0.75rem 1rem; color: var(--color-text-muted);">
                            {{ $m->occupation ?? '-' }}
                        </td>
                        <td style="padding: 0.75rem 1rem; text-align: center; font-weight: 700;">
                            {{ $m->family_members_count }} સભ્યો
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 2rem; text-align: center; color: var(--color-text-muted);">
                            કોઈ સભ્ય રેકોર્ડ મળેલ નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $members->links() }}
    </div>
</div>

@endsection

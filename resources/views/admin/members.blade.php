@extends('layouts.admin')

@section('title', 'જ્ઞાતિ સભ્યો ડિરેક્ટરી')
@section('header_title', 'જ્ઞાતિ સભ્યો ડિરેક્ટરી વ્યવસ્થાપન')

@section('content')

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">નોંધાયેલ પરિવારો</h3>
            <p class="admin-card-desc">સમસ્ત લેઉવા પટેલ સમાજ - જૂનાગઢ ડિરેક્ટરી & ઓફલાઇન સભ્ય નોંધણી</p>
        </div>

        <div class="admin-filter-bar">
            <a href="{{ route('admin.members.create') }}" class="admin-quick-pill primary" style="font-size: 0.84rem; padding: 0.45rem 0.9rem;">
                <i class="ri-add-line"></i> + નવા સભ્ય (ઓફલાઇન)
            </a>

            <form action="{{ route('admin.members') }}" method="GET" class="admin-search-form" autocomplete="off">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="નામ, સભ્ય કોડ, ગામ..." autocomplete="off" class="form-control" style="width: 200px; font-size: 0.82rem; padding: 0.42rem 0.75rem;">
                <button type="submit" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.75rem;" title="Search">
                    <i class="ri-search-line"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.members') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.65rem;" title="Clear Search">
                        <i class="ri-close-line"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    @include('partials.datatable-toolbar', ['paginator' => $members])

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>સભ્ય કોડ</th>
                    <th>સભ્યનું પૂરું નામ</th>
                    <th>મૂળ ગામ</th>
                    <th>સંપર્ક</th>
                    <th>બ્લડ ગ્રૂપ</th>
                    <th>વ્યવસાય</th>
                    <th style="text-align: center;">પરિવાર સભ્યો</th>
                    <th style="text-align: center;">એક્શન</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $m)
                    <tr>
                        <td style="font-family: var(--font-latin); font-weight: 700; color: #b45309; white-space: nowrap;">
                            {{ $m->member_code }}
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">
                                {{ $m->full_name }} {{ $m->father_or_husband_name ? '(' . $m->father_or_husband_name . ')' : '' }} {{ $m->surname }}
                            </div>
                            <div style="font-size: 0.74rem; color: #64748b;">{{ $m->current_address }}, {{ $m->city }}</div>
                        </td>
                        <td style="color: #475569; font-size: 0.84rem;">
                            {{ $m->native_village ?? '-' }}
                        </td>
                        <td style="font-family: var(--font-latin); white-space: nowrap;">
                            <a href="tel:{{ $m->phone }}" style="color: #475569; text-decoration: none; font-weight: 600;">
                                <i class="ri-phone-line" style="color: #059669; font-size: 0.85rem;"></i> {{ $m->phone }}
                            </a>
                        </td>
                        <td style="white-space: nowrap;">
                            <span class="badge badge-maroon" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">{{ $m->blood_group ?? '-' }}</span>
                        </td>
                        <td style="color: #64748b; font-size: 0.84rem;">
                            {{ $m->occupation ?? '-' }}
                        </td>
                        <td style="text-align: center; white-space: nowrap; font-weight: 700; color: #0f172a;">
                            {{ $m->family_members_count }} સભ્યો
                        </td>
                        <td style="text-align: center;">
                            <div class="admin-actions">
                                <a href="{{ route('admin.members.edit', $m->id) }}" class="btn-admin-action edit" title="વિગતો સુધારો">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.members.destroy', $m->id) }}" method="POST" onsubmit="return confirm('શું આપ ખરેખર આ સભ્ય રેકોર્ડ ({{ $m->member_code }}) ડીલીટ કરવા માંગો છો?');" style="display: inline; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-action delete" title="ડીલીટ કરો">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding: 2.5rem; text-align: center; color: #94a3b8;">
                            કોઈ સભ્ય રેકોર્ડ મળેલ નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $members->links() }}
    </div>
</div>

@endsection

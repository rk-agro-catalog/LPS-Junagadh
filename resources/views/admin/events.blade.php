@extends('layouts.admin')

@section('title', 'સમાજ કાર્યક્રમો (ઇવેન્ટ્સ)')
@section('header_title', 'કાર્યક્રમો & ઉત્સવ વ્યવસ્થાપન')

@section('content')

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">બધા સમાજ કાર્યક્રમો</h3>
            <p class="admin-card-desc">આગામી અને સંપન્ન થયેલ સામાજિક મેળાવડા, ઉત્સવ અને આરોગ્ય શિબિર</p>
        </div>

        <div class="admin-filter-bar">
            <a href="{{ route('admin.events.create') }}" class="admin-quick-pill primary" style="font-size: 0.84rem; padding: 0.45rem 0.9rem;">
                <i class="ri-add-line"></i> + નવો કાર્યક્રમ ઉમેરો
            </a>

            <form action="{{ route('admin.events') }}" method="GET" class="admin-search-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="કાર્યક્રમ નામ, સ્થળ..." class="form-control" style="width: 190px; font-size: 0.82rem; padding: 0.42rem 0.75rem;">
                <button type="submit" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.75rem;" title="Search">
                    <i class="ri-search-line"></i>
                </button>
            </form>
        </div>
    </div>

    @include('partials.datatable-toolbar', ['paginator' => $events])

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>તારીખ & સમય</th>
                    <th>કાર્યક્રમ શીર્ષક</th>
                    <th>કેટેગરી</th>
                    <th>સ્થળ / સંકુલ</th>
                    <th>સંપર્ક</th>
                    <th style="text-align: center;">સ્થિતિ</th>
                    <th style="text-align: center;">એક્શન</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $ev)
                    <tr>
                        <td style="white-space: nowrap;">
                            <div style="font-weight: 800; color: #780d28;">
                                <i class="ri-calendar-line"></i> {{ $ev->event_date->format('d/m/Y') }}
                            </div>
                            <div style="font-size: 0.74rem; color: #ea580c; font-weight: 600;">
                                {{ $ev->event_time ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $ev->title }}</div>
                            @if($ev->is_featured)
                                <span class="badge badge-gold" style="font-size: 0.65rem; padding: 0.1rem 0.4rem; margin-top: 0.2rem;">મુખ્ય ઉત્સવ</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <span class="badge badge-gold" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">{{ $ev->category }}</span>
                        </td>
                        <td style="color: #64748b; font-size: 0.84rem;">
                            {{ Str::limit($ev->venue, 35) }}
                        </td>
                        <td style="font-size: 0.82rem; color: #475569; white-space: nowrap;">
                            {{ $ev->contact_person ?? '-' }}
                        </td>
                        <td style="text-align: center; white-space: nowrap;">
                            @if($ev->is_active)
                                <span class="badge badge-green" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">સક્રિય</span>
                            @else
                                <span class="badge badge-maroon" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">નિષ્ક્રિય</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div class="admin-actions">
                                <a href="{{ route('admin.events.edit', $ev->id) }}" class="btn-admin-action edit" title="વિગતો સુધારો">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <a href="{{ route('events') }}" target="_blank" class="btn-admin-action view" title="સાઇટ પર જુઓ">
                                    <i class="ri-external-link-line"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $ev->id) }}" method="POST" onsubmit="return confirm('શું આપ ખરેખર આ કાર્યક્રમ ({{ $ev->title }}) ડીલીટ કરવા માંગો છો?');" style="display: inline; margin: 0;">
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
                        <td colspan="7" style="padding: 2.5rem; text-align: center; color: #94a3b8;">
                            કોઈ કાર્યક્રમ રેકોર્ડ મળેલ નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $events->links() }}
    </div>
</div>

@endsection

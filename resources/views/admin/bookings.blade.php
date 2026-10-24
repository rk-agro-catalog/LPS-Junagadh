@extends('layouts.admin')

@section('title', 'હોલ & પ્લોટ બુકિંગ ઇન્ક્વાયરી')
@section('header_title', 'બુકિંગ ઇન્ક્વાયરી & હોલ વ્યવસ્થાપન')

@section('content')

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">બધી બુકિંગ અરજીઓ & ઓફલાઇન બુકિંગ</h3>
            <p class="admin-card-desc">વિભાગ-૧, વિભાગ-૨ અને અતિથિ ભવન બુકિંગ વિગતો</p>
        </div>

        <div class="admin-filter-bar">
            <a href="{{ route('admin.bookings.create') }}" class="admin-quick-pill primary" style="font-size: 0.84rem; padding: 0.45rem 0.9rem;">
                <i class="ri-add-line"></i> + નવું બુકિંગ (ઓફલાઇન)
            </a>

            <div style="display: flex; gap: 0.35rem;">
                <a href="{{ route('admin.bookings') }}" class="admin-header-btn {{ empty(request('status')) && empty(request('search')) ? 'admin-header-btn-site' : '' }}" style="font-size: 0.78rem; padding: 0.35rem 0.65rem; background: {{ empty(request('status')) && empty(request('search')) ? '#b45309; color:#fff;' : '#f8fafc;' }}">
                    બધા
                </a>
                <a href="{{ route('admin.bookings', ['status' => 'new']) }}" class="admin-header-btn" style="font-size: 0.78rem; padding: 0.35rem 0.65rem; background: {{ request('status') == 'new' ? '#780d28; color:#fff;' : '#f8fafc;' }}">
                    નવી
                </a>
                <a href="{{ route('admin.bookings', ['status' => 'confirmed']) }}" class="admin-header-btn" style="font-size: 0.78rem; padding: 0.35rem 0.65rem; background: {{ request('status') == 'confirmed' ? '#059669; color:#fff;' : '#f8fafc;' }}">
                    કન્ફર્મ
                </a>
            </div>

            <form action="{{ route('admin.bookings') }}" method="GET" class="admin-search-form">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="અરજદાર, ફોન..." class="form-control" style="width: 170px; font-size: 0.82rem; padding: 0.42rem 0.75rem;">
                <button type="submit" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.75rem;" title="Search">
                    <i class="ri-search-line"></i>
                </button>
            </form>
        </div>
    </div>

    @include('partials.datatable-toolbar', ['paginator' => $bookings])

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ઇન્ક્વાયરી નં.</th>
                    <th>અરજદારનું નામ</th>
                    <th>મોબાઈલ</th>
                    <th>વિભાગ & સુવિધા</th>
                    <th>પ્રસંગ તારીખ</th>
                    <th style="text-align: center;">મહેમાનો</th>
                    <th style="text-align: center;">સ્ટેટસ</th>
                    <th style="text-align: center;">એક્શન</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                    <tr>
                        <td style="font-family: var(--font-latin); font-weight: 700; color: #b45309; white-space: nowrap;">
                            {{ $b->inquiry_number }}
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $b->applicant_name }}</div>
                            <div style="font-size: 0.74rem; color: #64748b;">{{ $b->city_or_village }}</div>
                        </td>
                        <td style="font-family: var(--font-latin); white-space: nowrap;">
                            <a href="tel:{{ $b->phone }}" style="color: #475569; text-decoration: none; font-weight: 600;">
                                <i class="ri-phone-line" style="color: #ea580c; font-size: 0.85rem;"></i> {{ $b->phone }}
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-gold" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">{{ $b->section_type }}</span>
                            <div style="font-size: 0.74rem; color: #64748b; margin-top: 2px;">{{ $b->facility_name }}</div>
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="font-weight: 700; color: #780d28;">
                                <i class="ri-calendar-line"></i> {{ $b->event_date->format('d/m/Y') }}
                            </div>
                            <div style="font-size: 0.74rem; color: #64748b;">{{ $b->event_type }}</div>
                        </td>
                        <td style="text-align: center; white-space: nowrap; font-family: var(--font-latin);">
                            {{ $b->approx_guests }}
                        </td>
                        <td style="text-align: center; white-space: nowrap;">
                            <form action="{{ route('admin.bookings.update', $b->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <select name="status" class="form-control" style="font-size: 0.78rem; padding: 0.25rem 0.5rem; width: 120px; border-radius: 8px;" onchange="this.form.submit()">
                                    <option value="new" {{ $b->status === 'new' ? 'selected' : '' }}>નવી (New)</option>
                                    <option value="in_review" {{ $b->status === 'in_review' ? 'selected' : '' }}>વિચારણા હેઠળ</option>
                                    <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>કન્ફર્મ</option>
                                    <option value="rejected" {{ $b->status === 'rejected' ? 'selected' : '' }}>રદ કરેલ</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: center;">
                            <div class="admin-actions">
                                <a href="{{ route('admin.bookings.edit', $b->id) }}" class="btn-admin-action edit" title="વિગતો સુધારો">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <form action="{{ route('admin.bookings.destroy', $b->id) }}" method="POST" onsubmit="return confirm('શું આપ ખરેખર આ બુકિંગ રેકોર્ડ ({{ $b->inquiry_number }}) ડીલીટ કરવા માંગો છો?');" style="display: inline; margin: 0;">
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
                            કોઈ બુકિંગ ઇન્ક્વાયરી નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $bookings->links() }}
    </div>
</div>

@endsection

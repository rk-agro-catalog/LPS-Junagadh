@extends('layouts.admin')

@section('title', 'ભૂમિદાન વ્યવસ્થાપન')
@section('header_title', 'ભૂમિદાન દાતાઓનું વ્યવસ્થાપન')

@section('content')

<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">બધા ભૂમિદાતાઓ</h3>
            <p class="admin-card-desc">સંકુલ નિર્માણમાં સહયોગી દાતાઓની સંપૂર્ણ યાદી & ઓફલાઇન વ્યવસ્થા</p>
        </div>

        <div class="admin-filter-bar">
            <a href="{{ route('admin.bhumidans.create') }}" class="admin-quick-pill primary" style="font-size: 0.84rem; padding: 0.45rem 0.9rem;">
                <i class="ri-add-line"></i> + નવું ભૂમિદાન (ઓફલાઇન)
            </a>

            <form action="{{ route('admin.bhumidans') }}" method="GET" class="admin-search-form" autocomplete="off">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="દાતાનું નામ, ફોન, ગામ..." autocomplete="off" class="form-control" style="width: 200px; font-size: 0.82rem; padding: 0.42rem 0.75rem;">
                <button type="submit" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.75rem;" title="Search">
                    <i class="ri-search-line"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.bhumidans') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.65rem;" title="Clear Search">
                        <i class="ri-close-line"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    @include('partials.datatable-toolbar', ['paginator' => $bhumidans])

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>રસીદ નં.</th>
                    <th>દાતાશ્રીનું નામ</th>
                    <th>સંપર્ક</th>
                    <th>ગામ / શહેર</th>
                    <th style="text-align: center;">ચોરસ વાર</th>
                    <th style="text-align: right;">સહયોગ રકમ</th>
                    <th style="text-align: center;">માધ્યમ</th>
                    <th style="text-align: center;">સ્ટેટસ</th>
                    <th style="text-align: center;">એક્શન</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bhumidans as $d)
                    <tr>
                        <td style="font-family: var(--font-latin); font-weight: 700; color: #b45309; white-space: nowrap;">
                            {{ $d->receipt_number }}
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $d->donor_name }}</div>
                            @if($d->is_featured)
                                <span class="badge badge-gold" style="font-size: 0.65rem; padding: 0.1rem 0.4rem; margin-top: 0.2rem;">મુખ્ય દાતા</span>
                            @endif
                        </td>
                        <td style="font-family: var(--font-latin); white-space: nowrap;">
                            <a href="tel:{{ $d->phone }}" style="color: #475569; text-decoration: none; font-weight: 600;">
                                <i class="ri-phone-line" style="color: #b45309; font-size: 0.85rem;"></i> {{ $d->phone }}
                            </a>
                        </td>
                        <td style="color: #64748b; font-size: 0.84rem;">
                            {{ $d->village ? $d->village . ', ' : '' }}{{ $d->city }}
                        </td>
                        <td style="text-align: center; white-space: nowrap;">
                            <span class="badge badge-gold" style="font-size: 0.74rem; padding: 0.2rem 0.55rem;">
                                {{ $d->sq_yards }} વાર
                            </span>
                        </td>
                        <td style="text-align: right; font-weight: 800; color: #780d28; white-space: nowrap;">
                            ₹ {{ number_format($d->total_amount) }}/-
                        </td>
                        <td style="text-align: center; font-size: 0.8rem; color: #475569; white-space: nowrap;">
                            <div>{{ $d->payment_method }}</div>
                            @if($d->payment_screenshot)
                                <a href="{{ asset($d->payment_screenshot) }}" target="_blank" class="badge" style="background: #e0f2fe; color: #0369a1; text-decoration: none; margin-top: 4px; display: inline-flex; align-items: center; gap: 3px; font-size: 0.72rem; padding: 0.2rem 0.5rem;" title="ચુકવણી સ્ક્રીનશોટ જુઓ">
                                    <i class="ri-image-line"></i> સ્લિપ જુઓ
                                </a>
                            @endif
                        </td>
                        <td style="text-align: center; white-space: nowrap;">
                            <span class="badge {{ $d->status === 'verified' ? 'badge-green' : 'badge-maroon' }}" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">
                                {{ $d->status === 'verified' ? 'વેરીફાઈડ' : 'પેન્ડિંગ' }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <div class="admin-actions">
                                @if($d->payment_screenshot)
                                    <a href="{{ asset($d->payment_screenshot) }}" target="_blank" class="btn-admin-action" style="background: #eff6ff; color: #2563eb;" title="પેમેન્ટ સ્ક્રીનશોટ">
                                        <i class="ri-file-image-line"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.bhumidans.edit', $d->id) }}" class="btn-admin-action edit" title="વિગતો સુધારો">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <a href="{{ route('receipt', $d->receipt_number) }}" target="_blank" class="btn-admin-action view" title="રસીદ પ્રિન્ટ કરો">
                                    <i class="ri-printer-line"></i>
                                </a>
                                <form action="{{ route('admin.bhumidans.destroy', $d->id) }}" method="POST" onsubmit="return confirm('શું આપ ખરેખર આ દાતા રેકોર્ડ ({{ $d->receipt_number }}) ડીલીટ કરવા માંગો છો?');" style="display: inline; margin: 0;">
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
                        <td colspan="9" style="padding: 2.5rem; text-align: center; color: #94a3b8;">
                            કોઈ ભૂમિદાન રેકોર્ડ મળેલ નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $bhumidans->links() }}
    </div>
</div>

@endsection

@extends('layouts.admin')

@section('title', 'એડમિન ડેશબોર્ડ Overview')
@section('header_title', 'ટ્રસ્ટ પ્રબંધન ડેશબોર્ડ')

@section('content')

<!-- Quick Action Shortcuts -->
<div class="admin-quick-strip">
    <div class="admin-quick-header">
        <i class="ri-flashlight-fill"></i> ઝડપી ઓફલાઇન નોંધણી (Quick Actions)
    </div>
    <div class="admin-quick-grid">
        <a href="{{ route('admin.bhumidans.create') }}" class="admin-quick-pill primary">
            <i class="ri-hand-heart-fill"></i>
            <span>+ નવું ભૂમિદાન ઉમેરો</span>
        </a>
        <a href="{{ route('admin.bookings.create') }}" class="admin-quick-pill">
            <i class="ri-calendar-check-fill"></i>
            <span>+ નવું હોલ બુકિંગ</span>
        </a>
        <a href="{{ route('admin.members.create') }}" class="admin-quick-pill">
            <i class="ri-user-add-fill"></i>
            <span>+ નવા જ્ઞાતિ સભ્ય</span>
        </a>
        <a href="{{ route('admin.events.create') }}" class="admin-quick-pill">
            <i class="ri-calendar-event-fill"></i>
            <span>+ નવો કાર્યક્રમ (ઇવેન્ટ)</span>
        </a>
        <a href="{{ route('admin.gallery.create') }}" class="admin-quick-pill">
            <i class="ri-gallery-fill"></i>
            <span>+ નવી ગેલેરી આઇટમ</span>
        </a>
    </div>
</div>

<!-- Stat KPI Cards Grid (Desktop 6 cols / Mobile 2 cols) -->
<div class="admin-stat-grid">
    <!-- Bhumidan Donation Amount -->
    <div class="admin-stat-card maroon">
        <div class="admin-stat-top">
            <span class="admin-stat-title">કુલ ભૂમિદાન રકમ</span>
            <div class="admin-stat-icon maroon">
                <i class="ri-hand-heart-line"></i>
            </div>
        </div>
        <div class="admin-stat-value">₹ {{ number_format($stats['total_donation']) }}</div>
        <div class="admin-stat-footer">
            <span class="badge badge-gold" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">
                {{ number_format($stats['total_yards']) }} વાર
            </span>
            <a href="{{ route('admin.bhumidans') }}" class="admin-stat-link">યાદી →</a>
        </div>
    </div>

    <!-- Total Donors -->
    <div class="admin-stat-card orange">
        <div class="admin-stat-top">
            <span class="admin-stat-title">કુલ દાતાશ્રીઓ</span>
            <div class="admin-stat-icon orange">
                <i class="ri-user-heart-line"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $stats['total_donors'] }}</div>
        <div class="admin-stat-footer">
            <span style="color: #64748b; font-size: 0.75rem;">સંકુલ સહયોગીઓ</span>
            <a href="{{ route('admin.bhumidans') }}" class="admin-stat-link">વિગતો →</a>
        </div>
    </div>

    <!-- Booking Inquiries -->
    <div class="admin-stat-card amber">
        <div class="admin-stat-top">
            <span class="admin-stat-title">નવી બુકિંગ ઇન્ક્વાયરી</span>
            <div class="admin-stat-icon amber">
                <i class="ri-calendar-check-line"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $stats['new_inquiries'] }}</div>
        <div class="admin-stat-footer">
            <span class="badge badge-maroon" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">
                કુલ: {{ $stats['total_inquiries'] }}
            </span>
            <a href="{{ route('admin.bookings') }}" class="admin-stat-link">ખોલો →</a>
        </div>
    </div>

    <!-- Caste Members -->
    <div class="admin-stat-card green">
        <div class="admin-stat-top">
            <span class="admin-stat-title">નોંધાયેલ પરિવારો</span>
            <div class="admin-stat-icon green">
                <i class="ri-team-line"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $stats['total_members'] }}</div>
        <div class="admin-stat-footer">
            <span style="color: #059669; font-weight: 700; font-size: 0.75rem;">સમાજ ડિરેક્ટરી</span>
            <a href="{{ route('admin.members') }}" class="admin-stat-link">જોવો →</a>
        </div>
    </div>

    <!-- Events -->
    <div class="admin-stat-card indigo">
        <div class="admin-stat-top">
            <span class="admin-stat-title">સમાજ કાર્યક્રમો</span>
            <div class="admin-stat-icon indigo">
                <i class="ri-calendar-event-line"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $stats['total_events'] }}</div>
        <div class="admin-stat-footer">
            <span style="color: #6366f1; font-weight: 700; font-size: 0.75rem;">ઇવેન્ટ કેલેન્ડર</span>
            <a href="{{ route('admin.events') }}" class="admin-stat-link">મેનેજ →</a>
        </div>
    </div>

    <!-- Gallery Media -->
    <div class="admin-stat-card sky">
        <div class="admin-stat-top">
            <span class="admin-stat-title">ગેલેરી તસવીરો & રીલ્સ</span>
            <div class="admin-stat-icon sky">
                <i class="ri-image-line"></i>
            </div>
        </div>
        <div class="admin-stat-value">{{ $stats['total_gallery'] }}</div>
        <div class="admin-stat-footer">
            <span style="color: #0284c7; font-weight: 700; font-size: 0.75rem;">મીડિયા આર્કાઇવ</span>
            <a href="{{ route('admin.gallery') }}" class="admin-stat-link">ગેલેરી →</a>
        </div>
    </div>
</div>

<!-- Two columns: Recent Donors & Recent Bookings -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 1.75rem;">
    <!-- Recent Donors -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3 class="admin-card-title">તાજા ભૂમિદાતાઓ</h3>
                <div class="admin-card-desc">છેલ્લે નોંધાયેલ સહયોગી દાતાઓ</div>
            </div>
            <a href="{{ route('admin.bhumidans') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.78rem; padding: 0.3rem 0.75rem;">
                બધા જુઓ
            </a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>દાતાનું નામ</th>
                        <th>ચોરસ વાર</th>
                        <th style="text-align: right;">રકમ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentDonations as $d)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">{{ $d->donor_name }}</div>
                                <div style="font-size: 0.74rem; color: #64748b;">
                                    <span style="font-family: var(--font-latin); font-weight: 600; color: #b45309;">{{ $d->receipt_number }}</span> • {{ $d->city }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-gold" style="font-size: 0.72rem; padding: 0.2rem 0.5rem;">
                                    {{ $d->sq_yards }} વાર
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 800; color: #780d28;">
                                ₹ {{ number_format($d->total_amount) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #94a3b8; padding: 1.5rem;">કોઈ દાતા નોંધાયેલ નથી.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Booking Inquiries -->
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h3 class="admin-card-title">તાજી બુકિંગ ઇન્ક્વાયરી</h3>
                <div class="admin-card-desc">હોલ / પ્લોટ બુકિંગ માટેની અરજીઓ</div>
            </div>
            <a href="{{ route('admin.bookings') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.78rem; padding: 0.3rem 0.75rem;">
                બધી જુઓ
            </a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>અરજદાર</th>
                        <th>સુવિધા & તારીખ</th>
                        <th style="text-align: right;">સ્ટેટસ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentInquiries as $b)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #1e293b;">{{ $b->applicant_name }}</div>
                                <div style="font-size: 0.74rem; color: #64748b; font-family: var(--font-latin);">{{ $b->phone }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600;">{{ $b->section_type }}</div>
                                <div style="font-size: 0.74rem; color: #ea580c; font-weight: 600;">
                                    {{ $b->event_date->format('d/m/Y') }}
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span class="badge {{ $b->status === 'new' ? 'badge-maroon' : 'badge-green' }}" style="font-size: 0.72rem; padding: 0.2rem 0.55rem;">
                                    {{ $b->status === 'new' ? 'નવી' : $b->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #94a3b8; padding: 1.5rem;">હાલ કોઈ ઇન્ક્વાયરી નથી.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upcoming Events on Dashboard -->
@if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">આગામી સમાજ કાર્યક્રમો (Upcoming Events)</h3>
            <div class="admin-card-desc">નજીકના દિવસોમાં આયોજિત સમાજના કાર્યક્રમો</div>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.events.create') }}" class="admin-quick-pill primary" style="font-size: 0.78rem; padding: 0.35rem 0.75rem;">
                + નવો કાર્યક્રમ
            </a>
            <a href="{{ route('admin.events') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.78rem; padding: 0.35rem 0.75rem;">
                બધા જુઓ
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem;">
        @foreach($upcomingEvents as $ue)
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="font-size: 0.76rem; color: #ea580c; font-weight: 700; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.3rem;">
                        <i class="ri-calendar-line"></i> {{ $ue->event_date->format('d/m/Y') }} • {{ $ue->event_time ?? '' }}
                    </div>
                    <h4 style="font-size: 0.98rem; font-weight: 800; color: #780d28; margin-bottom: 0.35rem; line-height: 1.3;">
                        {{ $ue->title }}
                    </h4>
                    <div style="font-size: 0.78rem; color: #64748b;">
                        <i class="ri-map-pin-line"></i> {{ Str::limit($ue->venue, 32) }}
                    </div>
                </div>
                <div style="margin-top: 0.85rem; padding-top: 0.65rem; border-top: 1px dashed #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                    <span class="badge badge-gold" style="font-size: 0.68rem; padding: 0.15rem 0.45rem;">{{ $ue->category }}</span>
                    <a href="{{ route('admin.events.edit', $ue->id) }}" style="font-size: 0.78rem; font-weight: 700; color: #b45309; text-decoration: none; display: inline-flex; align-items: center; gap: 0.2rem;">
                        સુધારો <i class="ri-arrow-right-line"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Recent Activity & Audit Logs on Dashboard -->
@if(isset($recentLogs) && $recentLogs->count() > 0)
<div class="admin-card" style="margin-top: 1.75rem;">
    <div class="admin-card-header" style="flex-wrap: wrap; gap: 0.75rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <h3 class="admin-card-title">તાજેતરના સિસ્ટમ એક્ટિવિટી & સબમિશન લૉગ્સ</h3>
                <span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 0.72rem; padding: 0.15rem 0.5rem; font-weight: 700;">
                    Live Feed
                </span>
            </div>
            <div class="admin-card-desc">એડમિન લૉગિન, ઓનલાઇન ફોર્મ સબમિશન અને ડેટા સુધારાની તાજી પ્રવૃત્તિઓ</div>
        </div>
        <a href="{{ route('admin.logs') }}" class="admin-header-btn admin-header-btn-site" style="font-size: 0.8rem; padding: 0.35rem 0.85rem;">
            તમામ લૉગ્સ જુઓ (View All) →
        </a>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="white-space: nowrap;">સમય</th>
                    <th>યુઝર / એક્ટર</th>
                    <th>પ્રવૃત્તિ & વર્ણન (Action)</th>
                    <th>ડિવાઇસ & ઓપરેટિંગ સિસ્ટમ</th>
                    <th>ચોક્કસ લોકેશન</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentLogs as $log)
                    <tr>
                        <td style="font-family: var(--font-latin); white-space: nowrap; font-size: 0.82rem; color: #475569;">
                            <div style="font-weight: 700; color: #0f172a;">{{ $log->created_at->format('d M, Y') }}</div>
                            <div style="color: #64748b; font-size: 0.76rem;">{{ $log->created_at->format('h:i A') }} ({{ $log->created_at->diffForHumans() }})</div>
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; gap: 0.35rem;">
                                @if($log->user_type === 'admin')
                                    <span class="badge" style="background: #fdf2f8; color: #9d174d; font-size: 0.68rem; padding: 0.12rem 0.4rem; border: 1px solid #fbcfe8;">
                                        <i class="ri-shield-star-line"></i> એડમિન
                                    </span>
                                @else
                                    <span class="badge" style="background: #f0fdf4; color: #166534; font-size: 0.68rem; padding: 0.12rem 0.4rem; border: 1px solid #bbf7d0;">
                                        <i class="ri-user-3-line"></i> પબ્લિક
                                    </span>
                                @endif
                                <strong style="color: #0f172a; font-size: 0.85rem;">{{ $log->user_name ?: 'અજ્ઞાત મુલાકાતી' }}</strong>
                            </div>
                        </td>
                        <td>
                            <div style="margin-bottom: 0.2rem;">
                                <span class="badge badge-gold" style="font-size: 0.7rem; padding: 0.12rem 0.45rem; font-family: var(--font-latin);">
                                    {{ $log->action }}
                                </span>
                            </div>
                            <div style="font-size: 0.82rem; color: #1e293b; font-weight: 500;">
                                {{ $log->description }}
                            </div>
                        </td>
                        <td style="white-space: nowrap; font-size: 0.8rem; font-family: var(--font-latin); color: #334155;">
                            <div><strong>{{ $log->device_name ?: $log->os }}</strong></div>
                            <div style="font-size: 0.74rem; color: #64748b;">{{ $log->os }} • {{ $log->browser }}</div>
                        </td>
                        <td style="font-size: 0.8rem; color: #475569;">
                            {{ $log->location ?: 'Localhost' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

@extends('layouts.admin')

@section('title', 'એક્ટિવિટી & સબમિશન લૉગ્સ')
@section('header_title', 'ઓડિટ & એક્ટિવિટી લૉગ વ્યવસ્થાપન')

@section('content')

<!-- KPI Stats Summary -->
<div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
    <div class="admin-stat-card" style="padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div class="admin-stat-label">કુલ લૉગ્સ</div>
                <div class="admin-stat-value" style="font-size: 1.8rem; font-family: var(--font-latin);">{{ number_format($stats['total']) }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #475569; font-size: 1.35rem;">
                <i class="ri-history-line"></i>
            </div>
        </div>
        <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.4rem;">
            આજના લૉગ્સ: <strong>{{ number_format($stats['today']) }}</strong>
        </div>
    </div>

    <div class="admin-stat-card" style="padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div class="admin-stat-label">પબ્લિક સબમિશન</div>
                <div class="admin-stat-value" style="font-size: 1.8rem; color: #0284c7; font-family: var(--font-latin);">{{ number_format($stats['public']) }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #e0f2fe; display: flex; align-items: center; justify-content: center; color: #0284c7; font-size: 1.35rem;">
                <i class="ri-user-follow-line"></i>
            </div>
        </div>
        <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.4rem;">
            ભૂમિદાન, બુકિંગ, સભ્યપદ ફોર્મ
        </div>
    </div>

    <div class="admin-stat-card" style="padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div class="admin-stat-label">એડમિન પ્રવૃત્તિ</div>
                <div class="admin-stat-value" style="font-size: 1.8rem; color: #780d28; font-family: var(--font-latin);">{{ number_format($stats['admin']) }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fdf2f8; display: flex; align-items: center; justify-content: center; color: #780d28; font-size: 1.35rem;">
                <i class="ri-admin-line"></i>
            </div>
        </div>
        <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.4rem;">
            બેકએન્ડ એડમિન એક્શન્સ
        </div>
    </div>

    <div class="admin-stat-card" style="padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div class="admin-stat-label">મોબાઈલ ડિવાઇસ</div>
                <div class="admin-stat-value" style="font-size: 1.8rem; color: #16a34a; font-family: var(--font-latin);">{{ number_format($stats['mobile']) }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #f0fdf4; display: flex; align-items: center; justify-content: center; color: #16a34a; font-size: 1.35rem;">
                <i class="ri-smartphone-line"></i>
            </div>
        </div>
        <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.4rem;">
            Android / iPhone યુઝર્સ
        </div>
    </div>

    <div class="admin-stat-card" style="padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <div class="admin-stat-label">લેપટોપ / ડેસ્કટોપ</div>
                <div class="admin-stat-value" style="font-size: 1.8rem; color: #b45309; font-family: var(--font-latin);">{{ number_format($stats['desktop']) }}</div>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fffbeb; display: flex; align-items: center; justify-content: center; color: #b45309; font-size: 1.35rem;">
                <i class="ri-macbook-line"></i>
            </div>
        </div>
        <div style="font-size: 0.78rem; color: #64748b; margin-top: 0.4rem;">
            Windows / Mac કમ્પ્યુટર
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header" style="flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 class="admin-card-title">સિસ્ટમ એક્ટિવિટી & સબમિશન રેકોર્ડ</h3>
            <p class="admin-card-desc">કોણે ક્યારે કયું ફોર્મ ભર્યું, મોબાઈલ કે કમ્પ્યુટરથી, લોકેશન અને સિસ્ટમ વિગતો સાથે</p>
        </div>

        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
            <form action="{{ route('admin.logs') }}" method="GET" style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin: 0;">
                <select name="user_type" class="form-control" style="width: auto; padding: 0.42rem 0.75rem; font-size: 0.82rem;" onchange="this.form.submit()">
                    <option value="">તમામ યુઝર્સ</option>
                    <option value="public" {{ request('user_type') === 'public' ? 'selected' : '' }}>પબ્લિક સબમિશન</option>
                    <option value="admin" {{ request('user_type') === 'admin' ? 'selected' : '' }}>એડમિન પ્રવૃત્તિ</option>
                </select>

                <select name="device_type" class="form-control" style="width: auto; padding: 0.42rem 0.75rem; font-size: 0.82rem;" onchange="this.form.submit()">
                    <option value="">તમામ ડિવાઇસ</option>
                    <option value="Mobile" {{ request('device_type') === 'Mobile' ? 'selected' : '' }}>Mobile (મોબાઈલ)</option>
                    <option value="Desktop" {{ request('device_type') === 'Desktop' ? 'selected' : '' }}>Desktop / Laptop</option>
                    <option value="Tablet" {{ request('device_type') === 'Tablet' ? 'selected' : '' }}>Tablet</option>
                </select>

                <div class="admin-search-box" style="margin: 0;">
                    <i class="ri-search-line"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="નામ, ફોન, IP, વર્ણન શોધો..." style="width: 220px;">
                </div>

                <button type="submit" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.75rem; font-size: 0.82rem;">
                    શોધો
                </button>

                @if(request()->anyFilled(['search', 'user_type', 'device_type', 'action']))
                    <a href="{{ route('admin.logs') }}" class="admin-header-btn admin-header-btn-site" style="padding: 0.42rem 0.65rem;" title="ક્લિયર ફિલ્ટર">
                        <i class="ri-close-line"></i> ક્લિયર
                    </a>
                @endif
            </form>

            <form action="{{ route('admin.logs.clearOld') }}" method="POST" onsubmit="return confirm('શું આપ ખરેખર ૬૦ દિવસથી જૂના લૉગ્સ સાફ કરવા માંગો છો?');" style="margin: 0;">
                @csrf
                <button type="submit" class="admin-header-btn admin-header-btn-site" style="color: #991b1b; border-color: #fecaca; background: #fef2f2; font-size: 0.8rem; padding: 0.42rem 0.75rem;" title="૬૦ દિવસથી જૂના લૉગ્સ દૂર કરો">
                    <i class="ri-delete-bin-line"></i> જૂના લૉગ સાફ કરો
                </button>
            </form>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="white-space: nowrap;">સમય</th>
                    <th>યુઝર / સબમિટર</th>
                    <th>પ્રવૃત્તિ & વર્ણન (Action)</th>
                    <th>ડિવાઇસ & સિસ્ટમ (OS/Browser)</th>
                    <th>IP એડ્રેસ & લોકેશન</th>
                    <th style="text-align: center;">વિગત</th>
                    <th style="text-align: center;">એક્શન</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <!-- Timestamp -->
                        <td style="font-family: var(--font-latin); white-space: nowrap; font-size: 0.82rem; color: #475569;">
                            <div style="font-weight: 700; color: #0f172a;">{{ $log->created_at->format('d M, Y') }}</div>
                            <div style="color: #64748b; font-size: 0.76rem;">{{ $log->created_at->format('h:i:s A') }}</div>
                            <div style="color: #94a3b8; font-size: 0.7rem;">({{ $log->created_at->diffForHumans() }})</div>
                        </td>

                        <!-- Submitter / User -->
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.2rem;">
                                @if($log->user_type === 'admin')
                                    <span class="badge" style="background: #fdf2f8; color: #9d174d; font-size: 0.68rem; padding: 0.15rem 0.45rem; border: 1px solid #fbcfe8;">
                                        <i class="ri-shield-star-line"></i> એડમિન
                                    </span>
                                @else
                                    <span class="badge" style="background: #f0fdf4; color: #166534; font-size: 0.68rem; padding: 0.15rem 0.45rem; border: 1px solid #bbf7d0;">
                                        <i class="ri-user-3-line"></i> પબ્લિક
                                    </span>
                                @endif
                                <strong style="color: #0f172a; font-size: 0.88rem;">{{ $log->user_name ?: 'અજ્ઞાત મુલાકાતી' }}</strong>
                            </div>
                            @if($log->user_contact)
                                <div style="font-family: var(--font-latin); font-size: 0.8rem; color: #475569;">
                                    <i class="ri-phone-line" style="color: #b45309; font-size: 0.78rem;"></i> {{ $log->user_contact }}
                                </div>
                            @endif
                        </td>

                        <!-- Action & Description -->
                        <td style="max-width: 320px;">
                            <div style="margin-bottom: 0.25rem;">
                                <span class="badge badge-gold" style="font-size: 0.72rem; padding: 0.15rem 0.5rem; font-family: var(--font-latin);">
                                    {{ $log->action }}
                                </span>
                            </div>
                            <div style="font-size: 0.85rem; color: #1e293b; line-height: 1.45; font-weight: 500;">
                                {{ $log->description }}
                            </div>
                        </td>

                        <!-- Device, OS, Browser -->
                        <td style="white-space: nowrap;">
                            <div style="display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.2rem;">
                                @if($log->device_type === 'Mobile')
                                    <span class="badge" style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; font-size: 0.72rem;">
                                        <i class="ri-smartphone-line"></i> મોબાઈલ
                                    </span>
                                @elseif($log->device_type === 'Tablet')
                                    <span class="badge" style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.72rem;">
                                        <i class="ri-tablet-line"></i> ટેબલેટ
                                    </span>
                                @else
                                    <span class="badge" style="background: #fafaf9; color: #44403c; border: 1px solid #e7e5e4; font-size: 0.72rem;">
                                        <i class="ri-macbook-line"></i> ડેસ્કટોપ / લેપટોપ
                                    </span>
                                @endif
                                <span style="font-weight: 650; font-size: 0.82rem; color: #334155; font-family: var(--font-latin);">
                                    {{ $log->os }}
                                </span>
                            </div>
                            <div style="font-size: 0.76rem; color: #64748b; font-family: var(--font-latin);">
                                <i class="ri-global-line" style="font-size: 0.78rem;"></i> {{ $log->browser }}
                            </div>
                        </td>

                        <!-- IP & Location -->
                        <td style="font-family: var(--font-latin); white-space: nowrap;">
                            <div style="font-weight: 700; color: #0284c7; font-size: 0.82rem;">
                                <i class="ri-router-line" style="font-size: 0.8rem;"></i> {{ $log->ip_address }}
                            </div>
                            <div style="font-size: 0.76rem; color: #64748b; display: flex; align-items: center; gap: 0.25rem; margin-top: 2px;">
                                <i class="ri-map-pin-2-fill" style="color: #e11d48; font-size: 0.75rem;"></i> {{ $log->location ?: 'India' }}
                            </div>
                        </td>

                        <!-- View Details Modal Trigger -->
                        <td style="text-align: center; white-space: nowrap;">
                            <button type="button" 
                                    class="btn-admin-action" 
                                    style="background: #f1f5f9; color: #0f172a;"
                                    title="સંપૂર્ણ વિગતો & પેલોડ જુઓ"
                                    onclick="viewLogDetails({{ json_encode($log) }})">
                                <i class="ri-eye-line"></i>
                            </button>
                        </td>

                        <!-- Delete Button -->
                        <td style="text-align: center; white-space: nowrap;">
                            <form action="{{ route('admin.logs.destroy', $log->id) }}" method="POST" onsubmit="return confirm('શું આપ આ લૉગ રેકોર્ડ ડીલીટ કરવા માંગો છો?');" style="margin: 0; display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-action delete" title="લૉગ ડીલીટ કરો">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 3rem; text-align: center; color: #94a3b8;">
                            <i class="ri-inbox-line" style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem; color: #cbd5e1;"></i>
                            કોઈ એક્ટિવિટી લૉગ્સ મળ્યા નથી.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $logs->links() }}
    </div>
</div>

<!-- Log Details Modal Dialog -->
<div id="logDetailsModal" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); z-index: 99999; backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem; overflow-y: auto;" onclick="if(event.target === this) closeLogModal()">
    <div style="background: #ffffff; width: 100%; max-width: 680px; border-radius: 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); overflow: hidden; margin: auto; animation: logModalPop 0.2s ease-out; border: 1px solid var(--color-border); max-height: 90vh; display: flex; flex-direction: column;">
        <!-- Header -->
        <div style="background: #0f172a; color: #ffffff; padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 0.6rem;">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #38bdf8;">
                    <i class="ri-file-info-line" style="font-size: 1.25rem;"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin: 0; color: #ffffff;">લૉગ વિગત & ટેક્નિકલ માહિતી</h3>
                    <div id="modalLogTime" style="font-size: 0.75rem; color: #94a3b8; font-family: var(--font-latin);"></div>
                </div>
            </div>
            <button type="button" onclick="closeLogModal()" style="background: transparent; border: none; color: #94a3b8; font-size: 1.5rem; cursor: pointer; line-height: 1;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#94a3b8'">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <!-- Body -->
        <div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1;">
            <!-- Action & Description Box -->
            <div style="background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; padding: 1rem; margin-bottom: 1.25rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <span id="modalActionBadge" class="badge badge-gold" style="font-family: var(--font-latin); font-size: 0.75rem;"></span>
                    <span id="modalUserTypeBadge"></span>
                </div>
                <div id="modalDescription" style="font-weight: 600; color: #0f172a; font-size: 0.95rem; line-height: 1.5;"></div>
            </div>

            <!-- Technical Attributes Grid -->
            <h4 style="font-size: 0.82rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.6rem; letter-spacing: 0.5px;">
                સિસ્ટમ & ક્લાયન્ટ વિગતો (Device & Network)
            </h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem; margin-bottom: 1.25rem; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.85rem;">
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">યુઝર / સબમિટર:</div>
                    <div id="modalUserName" style="font-weight: 700; color: #0f172a; font-size: 0.88rem;"></div>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">સંપર્ક નંબર / ઇમેઇલ:</div>
                    <div id="modalUserContact" style="font-weight: 650; color: #0f172a; font-size: 0.88rem; font-family: var(--font-latin);"></div>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">ડિવાઇસ પ્રકાર:</div>
                    <div id="modalDeviceType" style="font-weight: 650; color: #0f172a; font-size: 0.88rem;"></div>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">ઓપરેટિંગ સિસ્ટમ (OS):</div>
                    <div id="modalOS" style="font-weight: 650; color: #0f172a; font-size: 0.88rem; font-family: var(--font-latin);"></div>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">બ્રાઉઝર (Browser):</div>
                    <div id="modalBrowser" style="font-weight: 650; color: #0f172a; font-size: 0.88rem; font-family: var(--font-latin);"></div>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">IP એડ્રેસ:</div>
                    <div id="modalIp" style="font-weight: 700; color: #0284c7; font-size: 0.88rem; font-family: var(--font-latin);"></div>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">અંદાજિત લોકેશન:</div>
                    <div id="modalLocation" style="font-weight: 650; color: #0f172a; font-size: 0.88rem;"></div>
                </div>
                <div>
                    <div style="font-size: 0.72rem; color: #64748b;">HTTP Method & URL:</div>
                    <div id="modalMethodUrl" style="font-size: 0.78rem; color: #475569; font-family: var(--font-latin); word-break: break-all;"></div>
                </div>
            </div>

            <!-- Payload Box -->
            <h4 style="font-size: 0.82rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.6rem; letter-spacing: 0.5px;">
                સબમિટ કરેલ ફોર્મ ડેટા / પેલોડ (Form Payload)
            </h4>
            <div id="modalPayloadWrap" style="background: #0f172a; color: #38bdf8; padding: 1rem; border-radius: 10px; font-family: Consolas, monospace; font-size: 0.82rem; max-height: 250px; overflow-y: auto; white-space: pre-wrap; line-height: 1.5;"></div>
        </div>

        <!-- Footer -->
        <div style="padding: 0.85rem 1.5rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeLogModal()" class="admin-header-btn admin-header-btn-site" style="padding: 0.45rem 1.25rem;">
                બંધ કરો
            </button>
        </div>
    </div>
</div>

<style>
@keyframes logModalPop {
    from {
        opacity: 0;
        transform: scale(0.96);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<script>
function viewLogDetails(log) {
    const modal = document.getElementById('logDetailsModal');
    if (!modal) return;

    document.getElementById('modalLogTime').textContent = log.created_at || '';
    document.getElementById('modalActionBadge').textContent = log.action || '';
    document.getElementById('modalDescription').textContent = log.description || '';

    const typeBadge = document.getElementById('modalUserTypeBadge');
    if (log.user_type === 'admin') {
        typeBadge.innerHTML = '<span class="badge" style="background: #fdf2f8; color: #9d174d; border: 1px solid #fbcfe8;">એડમિન પ્રવૃત્તિ</span>';
    } else {
        typeBadge.innerHTML = '<span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">પબ્લિક ફોર્મ સબમિશન</span>';
    }

    document.getElementById('modalUserName').textContent = log.user_name || 'અજ્ઞાત';
    document.getElementById('modalUserContact').textContent = log.user_contact || 'N/A';
    document.getElementById('modalDeviceType').textContent = log.device_type + (log.device_name ? ' (' + log.device_name + ')' : '');
    document.getElementById('modalOS').textContent = log.os || 'N/A';
    document.getElementById('modalBrowser').textContent = log.browser || 'N/A';
    document.getElementById('modalIp').textContent = log.ip_address || '127.0.0.1';
    document.getElementById('modalLocation').textContent = log.location || 'India';
    document.getElementById('modalMethodUrl').textContent = (log.method || 'POST') + ' ' + (log.url || '');

    const payloadWrap = document.getElementById('modalPayloadWrap');
    if (log.payload && Object.keys(log.payload).length > 0) {
        payloadWrap.textContent = JSON.stringify(log.payload, null, 2);
    } else {
        payloadWrap.textContent = '(કોઈ વધારાનો પેલોડ ડેટા નથી)';
    }

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeLogModal() {
    const modal = document.getElementById('logDetailsModal');
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLogModal();
    }
});
</script>

@endsection

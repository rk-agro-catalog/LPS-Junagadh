<div class="datatable-toolbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem; padding: 0.5rem 0.25rem; flex-wrap: wrap; gap: 0.75rem;">
    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.84rem; color: #475569;">
        <span style="font-weight: 600;">દર્શાવો (Show):</span>
        <select onchange="window.location.href = updateTablePerPage(this.value)" class="form-control" style="width: auto; padding: 0.35rem 0.65rem; font-size: 0.82rem; border-radius: 8px; font-weight: 700; background: #ffffff; border: 1.5px solid #cbd5e1; color: #0f172a; cursor: pointer;" title="પ્રતિ પેજ રેકોર્ડ સંખ્યા પસંદ કરો">
            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500</option>
        </select>
        <span>એન્ટ્રીઓ પ્રતિ પેજ</span>
    </div>

    @if(isset($paginator) && method_exists($paginator, 'total'))
        <div style="font-size: 0.82rem; color: #64748b; font-family: var(--font-latin); display: flex; align-items: center; gap: 0.35rem;">
            <i class="ri-list-check-2" style="color: #b45309; font-size: 1rem;"></i>
            <span>Showing <strong>{{ $paginator->firstItem() ?? 0 }}</strong> to <strong>{{ $paginator->lastItem() ?? 0 }}</strong> of <strong>{{ number_format($paginator->total()) }}</strong> entries</span>
        </div>
    @endif
</div>

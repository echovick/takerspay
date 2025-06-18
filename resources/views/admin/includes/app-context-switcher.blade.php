<!-- App Context Switcher Component -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Application Context</h6>
    </div>
    <div class="card-body">
        <div class="btn-group w-100" role="group" aria-label="Application Context">
            <a href="{{ route('admin.dashboard', ['context' => 'all']) }}"
                class="btn {{ request()->get('context') == 'all' || !request()->has('context') ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-globe-americas mr-1"></i> Unified View
            </a>
            <a href="{{ route('admin.dashboard', ['context' => 'crypto']) }}"
                class="btn {{ request()->get('context') == 'crypto' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fab fa-bitcoin mr-1"></i> Crypto & Gift Card App
            </a>
            <a href="{{ route('admin.dashboard', ['context' => 'finance']) }}"
                class="btn {{ request()->get('context') == 'finance' ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-money-bill-wave mr-1"></i> Financial App
            </a>
        </div>
    </div>
</div>

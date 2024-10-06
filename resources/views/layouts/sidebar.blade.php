<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <div class="app-brand-link">
        <span>
          <img src="{{ asset('backend/assets/img/branding/logo-koperasi.png') }}" alt="logo" width="35">
        </span>
        <span class="app-brand-text demo menu-text fw-bold">Kopwan - KM</span>
      </div>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Dashboards">Dashboards</div>
        </a>
      </li>
     
      @if (auth()->user()->role != 'anggota')
        <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
          <a href="{{ route('users.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-users"></i>
            <div data-i18n="Anggota">Anggota</div>
          </a>
        </li>
      @endif

      <li class="menu-item {{ request()->routeIs('savings.index') ? 'active' : '' }}">
        <a href="{{ route('savings.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-credit-card"></i>
          <div data-i18n="Simpanan">Simpanan</div>
        </a>
      </li>

      <li class="menu-item {{ request()->routeIs('loans.index') ? 'active' : '' }}">
        <a href="{{ route('loans.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-credit-card"></i>
          <div data-i18n="Pinjaman">Pinjaman</div>
        </a>
      </li>

      <li class="menu-item {{ request()->routeIs('installments.index') ? 'active' : '' }}">
        <a href="{{ route('installments.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-credit-card"></i>
          <div data-i18n="Angsuran">Angsuran</div>
        </a>
      </li>

      @if (auth()->user()->role == 'anggota')
        <li class="menu-item {{ request()->routeIs('payments.index') ? 'active' : '' }}">
          <a href="{{ route('payments.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-credit-card-pay"></i>
            <div data-i18n="Pembayaran">Pembayaran</div>
          </a>
        </li>
      @endif

      <li class="menu-item {{ request()->routeIs('transactions.index') ? 'active' : '' }}">
        <a href="{{ route('transactions.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-report"></i>
          <div data-i18n="Laporan">Laporan</div>
        </a>
      </li>
    </ul>
</aside>
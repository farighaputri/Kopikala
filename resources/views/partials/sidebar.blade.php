@php
    $user = auth('staff')->user();
@endphp

@if($user)

<aside class="sidebar">

    {{-- ================= LOGO SECTION ================= --}}
    <div class="sidebar-logo" style="text-align: center; padding: 20px 10px; margin-bottom: 10px;">
        <img src="{{ asset('img/logo_kopikala.png') }}" alt="Kopikala Logo" style="max-width: 120px; height: auto; object-fit: contain;">
    </div>

    {{-- ================= MAIN MENU ================= --}}
    <ul>

        @if($user->hasPermission('Main Dashboard'))
        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>
        @endif

        @if($user->hasPermission('Kopikala Branch'))
        <li>
            {{-- Hanya aktif jika membuka halaman Branch Index/Create/Edit Pusat --}}
            <a href="{{ route('branch.index') }}"
               class="{{ (request()->routeIs('branch.*') && !request()->routeIs('branch.stock')) ? 'active' : '' }}">
                Kopikala Branch
            </a>
        </li>
        @endif

        @if($user->hasPermission('Staff'))
        <li>
            <a href="{{ route('staff.index') }}"
               class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">
                Staff
            </a>
        </li>
        @endif

        @if($user->hasPermission('Role'))
        <li>
            <a href="{{ route('roles.index') }}"
               class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                Role
            </a>
        </li>
        @endif

        @if($user->hasPermission('Products'))
        <li>
            <a href="{{ route('products.index') }}"
               class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                Products
            </a>
        </li>
        @endif

        @if($user->hasPermission('Main Transaction'))
        <li>
            <a href="{{ route('transactions.index') }}"
               class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                Transaction
            </a>
        </li>
        @endif

        @if($user->hasPermission('Stock'))
        <li>
            <a href="{{ route('stock.index') }}"
               class="{{ request()->routeIs('stock.*') ? 'active' : '' }}">
                Stocks
            </a>
        </li>
        @endif

    </ul>


    {{-- ================= BRANCH SECTION ================= --}}
    <div style="margin-top:30px">

        {{-- SEMERU SECTION --}}
        @if($user->hasPermission('Semeru Branch') || $user->hasPermission('Semeru Stock'))
        <p style="font-size:12px;color:#999;margin-bottom:10px">
            Semeru
        </p>

        <ul>
            @if($user->hasPermission('Semeru Dashboard'))
            <li>
                <a href="{{ route('semeru.dashboard') }}"
                   class="{{ request()->routeIs('semeru.dashboard') ? 'active' : '' }}">
                    Semeru Dashboard
                </a>
            </li>
            @endif

            @if($user->hasPermission('Semeru Staff'))
            <li>
                <a href="{{ route('semeru.staff') }}"
                   class="{{ request()->routeIs('semeru.staff') ? 'active' : '' }}">
                    Semeru Staff
                </a>
            </li>
            @endif

            @if($user->hasPermission('Semeru Transaction'))
            <li>
                <a href="{{ route('semeru.transaction') }}"
                   class="{{ request()->routeIs('semeru.transaction') ? 'active' : '' }}">
                    Semeru Transaction
                </a>
            </li>
            @endif

            @if($user->hasPermission('Semeru Stock'))
            <li>
                <a href="{{ route('semeru.stock') }}"
                   class="{{ request()->routeIs('semeru.stock*') ? 'active' : '' }}">
                    Semeru Stock
                </a>
            </li>
            @endif
        </ul>
        @endif


        {{-- DJUANDA SECTION --}}
        @if($user->hasPermission('Djuanda Branch') || $user->hasPermission('Djuanda Stock'))
        <p style="font-size:12px;color:#999;margin:14px 0 10px">
            Djuanda
        </p>

        <ul>
            @if($user->hasPermission('Djuanda Dashboard'))
            <li>
                <a href="{{ route('djuanda.dashboard') }}"
                   class="{{ request()->routeIs('djuanda.dashboard') ? 'active' : '' }}">
                    Djuanda Dashboard
                </a>
            </li>
            @endif

            @if($user->hasPermission('Djuanda Staff'))
            <li>
                <a href="{{ route('djuanda.staff') }}"
                   class="{{ request()->routeIs('djuanda.staff') ? 'active' : '' }}">
                    Djuanda Staff
                </a>
            </li>
            @endif

            @if($user->hasPermission('Djuanda Transaction'))
            <li>
                <a href="{{ route('djuanda.transaction') }}"
                   class="{{ request()->routeIs('djuanda.transaction') ? 'active' : '' }}">
                    Djuanda Transaction
                </a>
            </li>
            @endif

            @if($user->hasPermission('Djuanda Stock'))
            <li>
                {{-- FIX TOTAL: Mengarah ke rute baru djuanda.stock dan sub-path CRUD-nya (* untuk wildcard active) --}}
                <a href="{{ route('djuanda.stock') }}"
                   class="{{ request()->routeIs('djuanda.stock*') ? 'active' : '' }}">
                    Djuanda Stock
                </a>
            </li>
            @endif
        </ul>
        @endif

    </div>

    {{-- ================= LOGOUT ================= --}}
    <form method="POST" action="{{ route('logout') }}" class="logout" style="margin-top: 40px; padding: 0 15px;">
        @csrf
        <button type="submit" style="background: none; border: none; color: #d8000c; font-family: inherit; font-size: 16px; font-weight: bold; cursor: pointer; padding: 5px 0; transition: color 0.3s ease; display: inline-flex; align-items: center;">
            Logout
        </button>
    </form>

</aside>

@endif
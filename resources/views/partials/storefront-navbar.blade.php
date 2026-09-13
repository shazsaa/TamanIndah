@php

    $collapseId = $collapseId ?? 'storefrontNav';

    $active = $active ?? null;

    $homeAnchors = $homeAnchors ?? false;

    $requireAuth = $requireAuth ?? false;



    $catalogHref = $homeAnchors ? '#catalog' : url('/').'#catalog';

    $howHref = $homeAnchors ? '#how-to-order' : url('/').'#how-to-order';

    $myOrdersHref = route('my-orders.index');

@endphp



<nav id="storefront-navbar" class="navbar navbar-expand-lg navbar-dark storefront-navbar sticky-top">

    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ url('/') }}">Taman Indah</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-controls="{{ $collapseId }}" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="{{ $collapseId }}">

            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1 text-center text-lg-start">

                <li class="nav-item">

                    <a class="nav-link {{ $active === 'catalog' ? 'active' : '' }}" href="{{ $catalogHref }}">Katalog</a>

                </li>

                <li class="nav-item">

                    <a class="nav-link {{ $active === 'how-to-order' ? 'active' : '' }}" href="{{ $howHref }}">Cara Pesan</a>

                </li>

                @unless(auth()->check() && auth()->user()->isAdmin())

                    <li class="nav-item">

                        <a class="nav-link {{ $active === 'my-orders' ? 'active' : '' }}" href="{{ $myOrdersHref }}">Pesanan Saya</a>

                    </li>

                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('wishlist.index') }}">
                            Favorit
                        </a>
                    </li>
                    @endauth

                    <li class="nav-item">

                        <a class="nav-link {{ $active === 'cart' ? 'active' : '' }}" href="{{ route('cart.index') }}">Keranjang</a>

                    </li>

                @endunless

            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                @auth

                    @if(auth()->user()->isAdmin())

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>

                        </li>

                    @endif

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            {{ Auth::user()->name }}

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>

                            <li><hr class="dropdown-divider"></li>

                            <li>

                                <form method="POST" action="{{ route('logout') }}">

                                    @csrf

                                    <button type="submit" class="dropdown-item">Keluar</button>

                                </form>

                            </li>

                        </ul>

                    </li>

                @else

                    @if(! $requireAuth)

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('login') }}">Login</a>

                        </li>

                        @if (Route::has('register'))

                            <li class="nav-item">

                                <a class="nav-link" href="{{ route('register') }}">Daftar</a>

                            </li>

                        @endif

                    @endif

                @endauth

            </ul>

        </div>

    </div>

</nav>


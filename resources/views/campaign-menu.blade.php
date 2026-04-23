<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $page['title'] }} | {{ config('app.name', 'MyAds') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:500,700|plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/auth-portal.css') }}">
    </head>
    <body>
        <main class="portal-shell">
            <button type="button" class="portal-overlay" data-menu-close aria-label="Tutup menu"></button>

            <aside class="portal-sidebar" id="mobile-menu">
                <div class="portal-sidebar__bg"></div>

                <div class="portal-sidebar__inner">
                    <div class="portal-sidebar__mobile-head">
                        <p class="portal-sidebar__mobile-title">Menu</p>
                        <button type="button" class="portal-sidebar__close" data-menu-close aria-label="Tutup menu">
                            <span></span>
                            <span></span>
                        </button>
                    </div>

                    <div class="portal-brand">
                        <img src="{{ asset('assets/logo.png') }}" alt="MyAds Logo" class="portal-brand__logo">
                        <p class="portal-brand__text">MyAds</p>
                    </div>

                    <a href="{{ route('dashboard') }}" class="portal-create-btn portal-create-btn--link">Dashboard Utama</a>

                    <nav class="portal-nav" aria-label="Main navigation">
                        <div class="portal-nav__item">
                            <a href="{{ route('dashboard') }}" class="portal-nav__head">
                                <span class="portal-nav__icon-wrap">
                                    <svg class="portal-nav__svg" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M4 4h7v7H4zM13 4h7v4h-7zM13 10h7v10h-7zM4 13h7v7H4z" fill="currentColor"/>
                                    </svg>
                                </span>
                                <span>Dashboard</span>
                            </a>
                        </div>

                        @php
                            $menus = [
                                'sms' => ['label' => 'SMS', 'items' => ['location-based-area' => 'Location Based Area', 'broadcast' => 'Broadcast', 'targeted' => 'Targeted']],
                                'wa-business' => ['label' => 'WA Business', 'items' => ['location-based-area' => 'Location Based Area', 'broadcast' => 'Broadcast', 'targeted' => 'Targeted']],
                            ];
                        @endphp

                        @foreach ($menus as $navChannel => $navData)
                            <div class="portal-nav__item {{ $channel === $navChannel ? 'portal-nav__item--active' : '' }}">
                                <div class="portal-nav__head">
                                    <span class="portal-nav__icon-wrap">
                                        @if ($navChannel === 'sms')
                                            <svg class="portal-nav__svg" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v7A2.5 2.5 0 0 1 17.5 16h-7.2L6 19.5V16.3A2.5 2.5 0 0 1 4 13.8z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                <path d="M7.5 8.5h9M7.5 11.5h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                            </svg>
                                        @else
                                            <svg class="portal-nav__svg" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M12 4a8 8 0 0 0-6.93 12l-.87 4 4.1-.8A8 8 0 1 0 12 4Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                <path d="M9 9.7c.2-.5.4-.5.7-.5h.6c.2 0 .4 0 .6.5.2.6.8 2 .8 2.2s.1.3 0 .5c-.1.2-.2.3-.4.5l-.3.3c-.1.1-.3.3-.1.6.2.3.8 1.3 2 2 .8.5 1.4.7 1.7.8.3.1.5.1.7-.1l.9-1.1c.2-.2.4-.2.7-.1l1.8.8c.3.1.5.2.5.4 0 .2-.1 1-.6 1.4-.5.4-1.2.5-1.5.5-.4 0-1-.1-1.8-.5a10 10 0 0 1-3-2 10.6 10.6 0 0 1-2.1-2.8c-.4-.8-.6-1.5-.6-2 0-.5.2-1 .5-1.3.3-.3.8-.6 1-.6Z" fill="currentColor"/>
                                            </svg>
                                        @endif
                                    </span>
                                    <span>{{ $navData['label'] }}</span>
                                </div>
                                <div class="portal-subnav">
                                    @foreach ($navData['items'] as $navMenu => $navLabel)
                                        <a href="{{ route('campaign.menu', ['channel' => $navChannel, 'menu' => $navMenu]) }}" class="portal-subnav__item {{ $channel === $navChannel && $menu === $navMenu ? 'portal-subnav__item--active' : '' }}">
                                            <span class="portal-subnav__icon">◎</span>
                                            <span>{{ $navLabel }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </nav>

                    <div class="portal-mobile-actions">
                        <form method="POST" action="{{ route('logout') }}" class="portal-mobile-actions__form">
                            @csrf
                            <button type="submit" class="portal-logout portal-logout--menu">
                                <span class="portal-logout__icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M14 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M10 17l5-5-5-5M15 12H4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <section class="portal-main">
                <header class="portal-topbar">
                    <div class="portal-topbar__left">
                        <button type="button" class="portal-burger" data-menu-toggle aria-label="Buka menu" aria-controls="mobile-menu" aria-expanded="false">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <div class="portal-topbar__spacer"></div>
                    </div>
                    <div class="portal-topbar__actions">
                        <div class="portal-user">
                            <span class="portal-user__avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="portal-user__name">{{ auth()->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="portal-logout">
                                <span class="portal-logout__icon">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M14 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                        <path d="M10 17l5-5-5-5M15 12H4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </header>

                <div class="portal-content">
                    <section class="flow-hero">
                        <div class="flow-hero__copy">
                            <p class="flow-badge">{{ $page['badge'] }}</p>
                            <h1 class="flow-title">{{ $page['title'] }}</h1>
                            <p class="flow-description">{{ $page['description'] }}</p>
                        </div>

                        <div class="flow-summary-card">
                            <p class="flow-summary-card__label">Sumber Referensi</p>
                            <p class="flow-summary-card__title">SMS.pptx</p>
                            <p class="flow-summary-card__copy">{{ $page['headline'] }}</p>
                        </div>
                    </section>

                    <section class="flow-card">
                        <div class="flow-card__header">
                            <h2>Urutan Flow</h2>
                            <a href="{{ route('dashboard') }}">Kembali ke dashboard</a>
                        </div>

                        <div class="flow-steps">
                            @foreach ($page['steps'] as $index => $step)
                                <div class="flow-step">
                                    <span class="flow-step__number">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="flow-step__text">{{ $step }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="flow-section">
                        <h2 class="portal-section__title">Screen Mapping dari PPT</h2>
                        <div class="flow-gallery">
                            @foreach ($page['screenshots'] as $image => $caption)
                                <article class="flow-shot">
                                    <img src="{{ asset('assets/ppt/' . $image) }}" alt="{{ $caption }}" class="flow-shot__image">
                                    <div class="flow-shot__body">
                                        <p class="flow-shot__name">{{ basename($image, '.png') }}</p>
                                        <p class="flow-shot__caption">{{ $caption }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                </div>
            </section>
        </main>

        <script>
            (() => {
                const root = document.documentElement;
                const toggleButtons = document.querySelectorAll('[data-menu-toggle]');
                const closeButtons = document.querySelectorAll('[data-menu-close]');

                const setMenuState = (isOpen) => {
                    root.classList.toggle('portal-menu-open', isOpen);
                    toggleButtons.forEach((button) => {
                        button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    });
                };

                setMenuState(false);

                toggleButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        const nextState = !root.classList.contains('portal-menu-open');
                        setMenuState(nextState);
                    });
                });

                closeButtons.forEach((button) => {
                    button.addEventListener('click', () => setMenuState(false));
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        setMenuState(false);
                    }
                });

                window.addEventListener('resize', () => {
                    if (window.innerWidth > 1080) {
                        setMenuState(false);
                    }
                });
            })();
        </script>
    </body>
</html>

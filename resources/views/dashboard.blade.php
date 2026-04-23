@php
    $title = 'Dashboard | ' . config('app.name', 'MyAds');
    $navMenus = [
        [
            'key' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => 'dashboard',
            'href' => route('dashboard'),
            'dashboard' => true,
            'interactive' => true,
        ],
        [
            'key' => 'sms',
            'label' => 'SMS',
            'icon' => 'sms',
            'children' => [
                [
                    'key' => 'sms-location-based-area',
                    'label' => 'Location Based Area',
                    'icon' => 'location',
                    'href' => route('campaign.menu', ['channel' => 'sms', 'menu' => 'location-based-area']),
                    'interactive' => true,
                ],
                [
                    'key' => 'sms-broadcast',
                    'label' => 'Broadcast',
                    'icon' => 'broadcast',
                    'href' => '#',
                    'interactive' => true,
                ],
                [
                    'key' => 'sms-targeted',
                    'label' => 'Targeted',
                    'icon' => 'targeted',
                    'href' => '#',
                    'interactive' => true,
                ],
            ],
        ],
        [
            'key' => 'wa-business',
            'label' => 'WA Business',
            'icon' => 'wa',
            'children' => [
                [
                    'key' => 'wa-location-based-area',
                    'label' => 'Location Based Area',
                    'icon' => 'location',
                    'href' => '#',
                    'interactive' => true,
                ],
                [
                    'key' => 'wa-broadcast',
                    'label' => 'Broadcast',
                    'icon' => 'broadcast',
                    'href' => '#',
                    'interactive' => true,
                ],
                [
                    'key' => 'wa-targeted',
                    'label' => 'Targeted',
                    'icon' => 'targeted',
                    'href' => '#',
                    'interactive' => true,
                ],
            ],
        ],
    ];
    $activeNav = 'dashboard';
@endphp

@extends('layouts.portal')

@section('content')
    <section class="portal-hero">
        <div class="portal-welcome">
            <p class="portal-welcome__lead">Selamat Datang,</p>
            <h1 class="portal-welcome__name">{{ auth()->user()->name }}</h1>
        </div>

        <article class="portal-balance">
            <div class="portal-balance__top">
                <div>
                    <p class="portal-balance__label">Saldo Utama</p>
                    <p class="portal-balance__value">Rp 2.443.005</p>
                </div>
            </div>

            <div class="portal-balance__bottom">
                <span>Exp. 17 Apr 2027</span>
                <span>Exp. 17 Apr 2027</span>
                <a href="#">Lihat Riwayat Saldo</a>
            </div>
        </article>
    </section>

    <section class="portal-card portal-card--insight">
        <div class="portal-card__header">
            <h2>Ringkasan Dashboard</h2>
            <a href="#">Refresh</a>
        </div>

        <div class="portal-stats">
            <div class="portal-stats__item">
                <p class="portal-stats__value">3</p>
                <p class="portal-stats__label">Menu utama tampil</p>
            </div>
            <div class="portal-stats__item">
                <p class="portal-stats__value">6</p>
                <p class="portal-stats__label">Submenu placeholder</p>
            </div>
            <div class="portal-stats__item">
                <p class="portal-stats__value">Empty</p>
                <p class="portal-stats__label">Semua isi menu campaign masih dikosongkan sementara</p>
            </div>
            <div class="portal-stats__item">
                <p class="portal-stats__value">Ready</p>
                <p class="portal-stats__label">Struktur navigasi sudah siap untuk diisi kembali nanti</p>
            </div>
        </div>
    </section>

    <section class="portal-section">
        <h2 class="portal-section__title">Menu Campaign</h2>

        <div class="portal-service-grid">
            <article class="portal-service-card">
                <div class="portal-service-card__title-row">
                    <h3>SMS</h3>
                    <span>kosong</span>
                </div>
                <div class="portal-service-list">
                    <span class="portal-service-list__item">Location Based Area belum diisi.</span>
                    <span class="portal-service-list__item">Broadcast belum diisi.</span>
                    <span class="portal-service-list__item">Targeted belum diisi.</span>
                </div>
            </article>

            <article class="portal-service-card">
                <div class="portal-service-card__title-row">
                    <h3>WA Business</h3>
                    <span>kosong</span>
                </div>
                <div class="portal-service-list">
                    <span class="portal-service-list__item">Location Based Area belum diisi.</span>
                    <span class="portal-service-list__item">Broadcast belum diisi.</span>
                    <span class="portal-service-list__item">Targeted belum diisi.</span>
                </div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (() => {
            const dashboardLink = document.querySelector('[data-dashboard-link]');
            const subnavLinks = document.querySelectorAll('[data-subnav-link]');

            const clearNavSelection = () => {
                document.querySelectorAll('.portal-nav__item').forEach((item) => {
                    item.classList.remove('portal-nav__item--active', 'portal-nav__item--selected');
                });

                subnavLinks.forEach((link) => {
                    link.classList.remove('portal-subnav__item--active');
                });
            };

            dashboardLink?.addEventListener('click', () => {
                clearNavSelection();
                dashboardLink.closest('.portal-nav__item')?.classList.add('portal-nav__item--active');
            });

            document.querySelectorAll('[data-nav-toggle]').forEach((button) => {
                button.addEventListener('click', () => {
                    const parent = button.closest('[data-nav-group]');
                    const isOpen = parent.classList.toggle('portal-nav__item--open');

                    button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });
            });

            subnavLinks.forEach((link) => {
                link.addEventListener('click', (event) => {
                    const isPlaceholder = link.getAttribute('href') === '#';

                    if (isPlaceholder) {
                        event.preventDefault();
                    }

                    const parentGroup = link.closest('[data-nav-group]');
                    const parentToggle = parentGroup?.querySelector('[data-nav-toggle]');

                    clearNavSelection();
                    link.classList.add('portal-subnav__item--active');
                    parentGroup?.classList.add('portal-nav__item--selected', 'portal-nav__item--open');
                    parentToggle?.setAttribute('aria-expanded', 'true');
                });
            });
        })();
    </script>
@endpush

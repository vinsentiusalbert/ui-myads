@php
    $title = $page['title'] . ' | ' . config('app.name', 'MyAds');
    $mainClass = 'campaign-main';
    $contentClass = 'campaign-content';
    $navMenus = [
        [
            'key' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => 'dashboard',
            'href' => route('dashboard'),
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
                ],
                [
                    'key' => 'sms-targeted',
                    'label' => 'Targeted',
                    'icon' => 'targeted',
                    'href' => route('campaign.menu', ['channel' => 'sms', 'menu' => 'targeted']),
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
                    'href' => route('campaign.menu', ['channel' => 'wa-business', 'menu' => 'location-based-area']),
                ],
                [
                    'key' => 'wa-campaign-template',
                    'label' => 'Campaign Template',
                    'icon' => 'template',
                    'href' => route('campaign-template.index'),
                ],
                [
                    'key' => 'wa-targeted',
                    'label' => 'Targeted',
                    'icon' => 'targeted',
                    'href' => route('campaign.menu', ['channel' => 'wa-business', 'menu' => 'targeted']),
                ],
            ],
        ],
    ];
    $activeNav = 'wa-business';
    $activeSubnav = 'wa-location-based-area';
@endphp

@extends('layouts.portal')

@section('content')
    <section class="campaign-page-intro">
        <p class="campaign-page-intro__crumb">Dashboard / Buat Iklan WA Business LBA</p>
        <h1 class="campaign-page-intro__title">Buat Iklan WA Business LBA</h1>
    </section>

    <section class="campaign-stepper-card">
        <div class="campaign-stepper">
            @foreach ($page['steps'] as $index => $step)
                <div class="campaign-step {{ $index === 0 ? 'campaign-step--active' : '' }}">
                    <span class="campaign-step__dot">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="campaign-step__label">{{ $step }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="campaign-info-banner">
        <span class="campaign-info-banner__icon">i</span>
        <p>Pelajari cara membuat iklan Anda agar lebih menarik. <a href="#">Pelajari Selengkapnya.</a></p>
    </section>

    <section class="campaign-compose-card campaign-compose-card--single">
        <div class="campaign-compose-card__header campaign-compose-card__header--single">
            <div>
                <h2 class="campaign-compose-card__section-title">Template Pesan</h2>
            </div>
        </div>

        <div class="campaign-wa-lba-step">
            <div class="field-group campaign-wa-lba-step__field">
                <label for="waLbaTemplate" class="field-label sr-only">Template Pesan</label>
                <select id="waLbaTemplate" class="text-input text-input--select">
                    <option value="">Template Pesan</option>
                    <option value="promo-flash-sale">Promo Flash Sale</option>
                    <option value="promo-lokal-bisnis">Promo Lokal Bisnis</option>
                    <option value="event-grand-opening">Event Grand Opening</option>
                    <option value="product-launch">Product Launch</option>
                </select>
            </div>

            <div class="campaign-form-actions campaign-form-actions--wa-lba">
                <button type="button" class="campaign-draft-btn">
                    <span class="campaign-draft-btn__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M6 3.75h8.75L19.5 8.5v11a1.75 1.75 0 0 1-1.75 1.75H6A1.75 1.75 0 0 1 4.25 19.5V5.5A1.75 1.75 0 0 1 6 3.75Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M14.75 3.75V8.5h4.75" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M8 12h8M8 16h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <span>Simpan Iklan Sebagai Draft</span>
                </button>

                <button type="button" class="submit-btn lba-primary-btn campaign-step-nav-btn" id="waLbaNextButton" disabled>
                    Lanjutkan
                </button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const templateSelect = document.getElementById('waLbaTemplate');
            const nextButton = document.getElementById('waLbaNextButton');

            const syncNextState = () => {
                if (!templateSelect || !nextButton) {
                    return;
                }

                nextButton.disabled = !templateSelect.value;
            };

            templateSelect?.addEventListener('change', syncNextState);
            syncNextState();
        });
    </script>
@endpush

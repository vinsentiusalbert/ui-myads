@php
    $title = $page['title'] . ' | ' . config('app.name', 'MyAds');
    $bodyClass = 'campaign-title-locked';
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
                    'key' => 'sms-broadcast',
                    'label' => 'Broadcast',
                    'icon' => 'broadcast',
                    'href' => '#',
                ],
                [
                    'key' => 'sms-targeted',
                    'label' => 'Targeted',
                    'icon' => 'targeted',
                    'href' => '#',
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
                ],
                [
                    'key' => 'wa-broadcast',
                    'label' => 'Broadcast',
                    'icon' => 'broadcast',
                    'href' => '#',
                ],
                [
                    'key' => 'wa-targeted',
                    'label' => 'Targeted',
                    'icon' => 'targeted',
                    'href' => '#',
                ],
            ],
        ],
    ];
    $activeNav = 'sms';
    $activeSubnav = 'sms-location-based-area';
@endphp

@extends('layouts.portal')

@push('styles')
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    >
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"
    >
@endpush

@section('content')
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

    <section class="campaign-compose-card" id="campaignComposeCard">
        <div class="campaign-compose-card__header">
            <div>
                <p class="campaign-section-kicker">Step 01</p>
                <h1>Konten Pesan Iklan</h1>
            </div>
            <div class="campaign-title-chip">
                <span>Judul Iklan</span>
                <strong id="campaignTitlePreview">Belum diisi</strong>
            </div>
        </div>

        <div class="campaign-compose-grid">
            <div class="campaign-compose-form">
                <div class="campaign-radio-row">
                    <label class="campaign-radio">
                        {{-- <input type="radio" name="compose_type" checked> --}}
                        <span>Isi Konten Pesan Manual</span>
                    </label>
                    {{-- <label class="campaign-radio">
                        <input type="radio" name="compose_type">
                        <span>Buat Pesan Otomatis dengan GenAI</span>
                    </label> --}}
                </div>

                <div class="field-group">
                    <label for="campaign_sender" class="field-label">Nama Pengirim</label>
                    <div class="campaign-inline-field">
                        <select id="campaign_sender" class="text-input text-input--select">
                            <option>MyAds SMS</option>
                            <option>Promo Outlet</option>
                            <option>Info Bisnis</option>
                        </select>
                        <a href="#" class="campaign-inline-link">Buat Nama Pengirim Baru</a>
                    </div>
                </div>

                <a href="#" class="campaign-template-link">Gunakan dari Template</a>

                <div class="field-group">
                    <label for="campaign_message" class="field-label">Isi Konten</label>
                    <textarea id="campaign_message" class="text-input campaign-message-input">Promosi outlet makin untung di MyAds! Top up MyAds Rp50k dapat BONUS SALDO Rp300k. Aktifkan di bit.ly/JoinMyAds</textarea>
                    <div class="campaign-message-meta">
                        <span>Mohon pastikan pesan iklan Anda tidak mengandung unsur terlarang.</span>
                        <strong id="campaignMessageCount">117/160 karakter</strong>
                    </div>
                </div>

                <section class="campaign-block">
                    <div class="campaign-button-builder__head">
                        <div>
                            <h2 class="campaign-block__title">Buttons</h2>
                            <p class="campaign-block__copy">Tambahkan tombol aksi singkat ke pesan dan lihat preview-nya langsung di sisi kanan.</p>
                        </div>
                        <button type="button" class="campaign-outline-button campaign-outline-button--compact" id="campaignAddButton">
                            <span class="campaign-outline-button__icon">+</span>
                            <span>Add Button</span>
                        </button>
                    </div>
                    <p class="campaign-button-builder__warning" id="campaignButtonWarning" hidden>Button hanya bisa 2.</p>

                    <div class="campaign-button-builder" id="campaignButtonBuilder"></div>

                    <p class="campaign-block__copy">
                        Link Singkat adalah halaman situs yang ditampilkan otomatis saat gambar pada iklan diklik oleh penerima. Pastikan Link Singkat yang Anda masukkan benar.
                    </p>
                </section>

                <section class="campaign-block">
                    <h2 class="campaign-block__title">Atur Lokasi Target</h2>
                    <div class="campaign-location-row campaign-location-row--single">
                        <button type="button" class="campaign-outline-button campaign-outline-button--wide" id="campaignOpenLocationModal" onclick="window.openCampaignLocationModal && window.openCampaignLocationModal()">
                            <span class="campaign-outline-button__icon">+</span>
                            <span>Tambah Lokasi</span>
                        </button>
                    </div>
                </section>

                <section class="campaign-block">
                    <h2 class="campaign-block__title">Atur Profil Target</h2>
                    <p class="campaign-block__copy">
                        Anda dapat membuat target lebih spesifik dengan menentukan profil dan lokasi penerima. Semakin banyak profil dan lokasi yang dipilih akan mengurangi jumlah penerima iklan Anda, sehingga menurunkan jumlah iklan yang ditampilkan pada laman situs yang dikunjungi.
                    </p>

                    <div class="campaign-profile-grid">
                        <div class="field-group campaign-field-group--compact">
                            <label for="campaign_gender" class="field-label">Jenis Kelamin</label>
                            <select id="campaign_gender" class="campaign-search-multiselect" multiple data-placeholder="Cari jenis kelamin">
                                <option value="male" selected>Laki-laki</option>
                                <option value="female">Perempuan</option>
                                <option value="all">Semua</option>
                            </select>
                        </div>

                        <div class="field-group campaign-field-group--compact">
                            <label for="campaign_age" class="field-label">Rentang Umur</label>
                            <select id="campaign_age" class="campaign-search-multiselect" multiple data-placeholder="Cari rentang umur">
                                <option value="under-15" selected>&lt; 15 tahun</option>
                                <option value="15-24">15 - 24 tahun</option>
                                <option value="25-34">25 - 34 tahun</option>
                                <option value="35-44">35 - 44 tahun</option>
                                <option value="45-plus">45+ tahun</option>
                            </select>
                        </div>

                        <div class="field-group campaign-field-group--compact">
                            <label for="campaign_religion" class="field-label">Agama</label>
                            <select id="campaign_religion" class="campaign-search-multiselect" multiple data-placeholder="Cari agama">
                                <option value="islam">Islam</option>
                                <option value="kristen">Kristen</option>
                                <option value="katolik">Katolik</option>
                                <option value="hindu">Hindu</option>
                                <option value="budha">Budha</option>
                                <option value="konghucu">Konghucu</option>
                            </select>
                        </div>

                        {{-- <a href="#" class="campaign-inline-link campaign-inline-link--strong campaign-inline-link--arrow">Atur Profil Lebih Spesifik</a> --}}
                    </div>

                    {{-- <a href="#" class="campaign-collapse-link campaign-collapse-link--subtle">
                        <span class="campaign-collapse-link__icon">+</span>
                        <span>Pilih Profil dari Daftar</span>
                    </a> --}}

                    {{-- <a href="#" class="campaign-inline-link campaign-inline-link--arrow campaign-inline-link--stacked">Buat Pesan yang Sama atau Berbeda ke Beberapa Profil dan Lokasi</a> --}}
                </section>

                <div class="campaign-form-actions">
                    {{-- <button type="button" class="campaign-draft-btn">
                        <span class="campaign-draft-btn__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                <path d="M14 3v5h5M9 12h6M9 16h6" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span>Simpan Iklan Sebagai Draft</span>
                    </button> --}}
                    <button type="button" class="submit-btn lba-primary-btn">Lanjutkan</button>
                </div>
            </div>

            <aside class="campaign-phone-preview">
                <div class="campaign-phone">
                    <div class="campaign-phone__notch"></div>
                    <div class="campaign-phone__top">
                        <span>9:41</span>
                        <span>{{ $channel === 'sms' ? 'SMS' : 'WA' }}</span>
                    </div>
                    <div class="campaign-phone__avatar"></div>
                    <p class="campaign-phone__time">Hari ini 13:59</p>
                    <div class="campaign-phone__sheet">
                        <div class="campaign-phone__bubble" id="campaignMessagePreview">
                            Promosi outlet makin untung di MyAds! Top up MyAds Rp50k dapat BONUS SALDO Rp300k. Aktifkan di bit.ly/JoinMyAds
                        </div>
                        <div class="campaign-phone__actions" id="campaignPhoneActions"></div>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection

@section('after_shell')
    <div class="campaign-title-modal" id="campaignTitleModal" aria-hidden="false">
        <div class="campaign-title-modal__backdrop"></div>
        <div class="campaign-title-modal__card" role="dialog" aria-modal="true" aria-labelledby="campaignTitleHeading">
            <h2 id="campaignTitleHeading">Buat Judul Iklan</h2>
            <div class="field-group">
                <label for="campaign_title" class="field-label">Judul Iklan</label>
                <input id="campaign_title" type="text" class="text-input" value="tes" placeholder="Masukkan judul iklan">
            </div>
            <div class="campaign-title-modal__actions">
                <a href="{{ route('dashboard') }}" class="campaign-modal-btn campaign-modal-btn--ghost">Batal</a>
                <button type="button" class="campaign-modal-btn campaign-modal-btn--primary" id="campaignTitleSubmit" onclick="window.unlockCampaignTitleModal && window.unlockCampaignTitleModal()">Lanjutkan</button>
            </div>
        </div>
    </div>

    <div class="campaign-map-modal" id="campaignMapModal" hidden aria-hidden="true">
        <div class="campaign-map-modal__backdrop" data-location-close onclick="window.closeCampaignLocationModal && window.closeCampaignLocationModal()"></div>
        <div class="campaign-map-modal__card" role="dialog" aria-modal="true" aria-labelledby="campaignMapHeading">
            <div class="campaign-map-modal__layout">
                <div class="campaign-map-panel">
                    <div class="campaign-map-panel__canvas campaign-map-panel__canvas--live" id="campaignMapCanvas"></div>
                    <p class="campaign-map-panel__hint">Klik peta atau cari alamat untuk menentukan titik target.</p>
                </div>

                <div class="campaign-map-controls">
                    <div class="campaign-map-controls__top">
                        <h2 id="campaignMapHeading">Tambah Lokasi</h2>
                        <button type="button" class="campaign-map-close" data-location-close aria-label="Tutup lokasi" onclick="window.closeCampaignLocationModal && window.closeCampaignLocationModal()">×</button>
                    </div>

                    <div class="campaign-map-search-host" id="campaignLocationSearchHost"></div>
                    <p class="campaign-map-search-feedback" id="campaignMapFeedback">Cari lokasi atau klik langsung pada peta untuk menentukan area target.</p>

                    <p class="campaign-block__copy">
                        Tentukan lokasi yang Anda inginkan dengan mengetik nama atau alamat lokasi pada kolom pencarian, lalu atur radius pengiriman.
                    </p>

                    <label class="campaign-location-toggle">
                        <input type="checkbox" disabled>
                        <span>Gunakan Lokasi Saat Ini</span>
                        <strong>Lokasi tidak aktif, mohon aktifkan lokasi</strong>
                    </label>

                    <section class="campaign-map-settings">
                        <h3>Pengaturan</h3>
                        <div class="campaign-map-settings__grid">
                            <div class="field-group campaign-field-group--compact">
                                <label for="campaignLocationRadius" class="field-label">Radius (dalam Meter)</label>
                                <input id="campaignLocationRadius" type="number" class="text-input" min="0" step="100" value="300">
                            </div>
                        </div>

                        {{-- <div class="campaign-map-estimate">
                            <button type="button" class="campaign-outline-button campaign-map-estimate__button" id="campaignCalcAudience">
                                <span class="campaign-outline-button__icon">✓</span>
                                <span>Hitung Penerima Potensial</span>
                            </button>
                            <div class="campaign-map-estimate__result">
                                <span>Estimasi Penerima Potensial</span>
                                <strong id="campaignAudienceEstimate">0</strong>
                            </div>
                        </div> --}}

                        {{-- <label class="campaign-map-checkbox">
                            <input type="checkbox" id="campaignLocationRemember">
                            <span>Simpan pengaturan lokasi agar dapat digunakan kembali</span>
                        </label> --}}
                    </section>

                    <div class="campaign-map-actions">
                        <button type="button" class="campaign-modal-btn campaign-modal-btn--primary" id="campaignApplyLocation">Gunakan Lokasi</button>
                        <button type="button" class="campaign-map-cancel" data-location-close onclick="window.closeCampaignLocationModal && window.closeCampaignLocationModal()">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.unlockCampaignTitleModal = function () {
            const body = document.body;
            const titleInput = document.getElementById('campaign_title');
            const titlePreview = document.getElementById('campaignTitlePreview');

            if (titlePreview) {
                titlePreview.textContent = titleInput?.value?.trim() || 'Tanpa Judul';
            }

            body.classList.remove('campaign-title-locked');
            body.classList.add('campaign-title-ready');
        };

        window.openCampaignLocationModal = function () {
            const body = document.body;
            const modal = document.getElementById('campaignMapModal');

            if (!modal) {
                return;
            }

            modal.hidden = false;
            modal.setAttribute('aria-hidden', 'false');
            body.classList.add('campaign-map-open');
        };

        window.closeCampaignLocationModal = function () {
            const body = document.body;
            const modal = document.getElementById('campaignMapModal');

            if (!modal) {
                return;
            }

            modal.hidden = true;
            modal.setAttribute('aria-hidden', 'true');
            body.classList.remove('campaign-map-open');
        };
    </script>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        (() => {
            const body = document.body;
            const titleInput = document.getElementById('campaign_title');
            const titleSubmit = document.getElementById('campaignTitleSubmit');
            const titlePreview = document.getElementById('campaignTitlePreview');
            const messageInput = document.getElementById('campaign_message');
            const messagePreview = document.getElementById('campaignMessagePreview');
            const messageCount = document.getElementById('campaignMessageCount');
            const addButton = document.getElementById('campaignAddButton');
            const buttonBuilder = document.getElementById('campaignButtonBuilder');
            const phoneActions = document.getElementById('campaignPhoneActions');
            const buttonWarning = document.getElementById('campaignButtonWarning');
            const locationModal = document.getElementById('campaignMapModal');
            const openLocationModalButton = document.getElementById('campaignOpenLocationModal');
            const locationCloseButtons = document.querySelectorAll('[data-location-close]');
            const locationCanvas = document.getElementById('campaignMapCanvas');
            const locationSearchHost = document.getElementById('campaignLocationSearchHost');
            const mapFeedback = document.getElementById('campaignMapFeedback');
            const locationRadiusInput = document.getElementById('campaignLocationRadius');
            const calcAudienceButton = document.getElementById('campaignCalcAudience');
            const audienceEstimate = document.getElementById('campaignAudienceEstimate');
            const applyLocationButton = document.getElementById('campaignApplyLocation');

            let buttonIndex = 0;
            const locationState = {
                name: 'Bundaran HI, Jakarta',
                audience: 2400,
                lat: -6.1944491,
                lng: 106.8229198,
            };
            let liveMap = null;
            let liveMarker = null;
            let liveCircle = null;
            let geocoderControl = null;

            const initCampaignMultiselects = () => {
                document.querySelectorAll('.campaign-search-multiselect').forEach((select) => {
                    if (select.dataset.enhanced === 'true') {
                        return;
                    }

                    const wrapper = document.createElement('div');
                    wrapper.className = 'campaign-multiselect';
                    wrapper.innerHTML = `
                        <div class="campaign-multiselect__control" tabindex="0">
                            <div class="campaign-multiselect__chips"></div>
                            <input type="text" class="campaign-multiselect__search" placeholder="${select.dataset.placeholder || 'Cari data'}">
                        </div>
                        <div class="campaign-multiselect__dropdown">
                            <div class="campaign-multiselect__empty" hidden>Data tidak ditemukan</div>
                            <div class="campaign-multiselect__options"></div>
                        </div>
                    `;

                    select.dataset.enhanced = 'true';
                    select.classList.add('campaign-multiselect__native');
                    select.after(wrapper);

                    const control = wrapper.querySelector('.campaign-multiselect__control');
                    const chips = wrapper.querySelector('.campaign-multiselect__chips');
                    const search = wrapper.querySelector('.campaign-multiselect__search');
                    const optionsWrap = wrapper.querySelector('.campaign-multiselect__options');
                    const empty = wrapper.querySelector('.campaign-multiselect__empty');

                    const render = (filter = '') => {
                        const keyword = filter.trim().toLowerCase();
                        const options = Array.from(select.options);
                        const selected = options.filter((option) => option.selected);
                        const filtered = options.filter((option) => option.text.toLowerCase().includes(keyword));

                        chips.innerHTML = selected.map((option) => `
                            <button type="button" class="campaign-multiselect__chip" data-chip-value="${option.value}">
                                <span class="campaign-multiselect__chip-remove">×</span>
                                <span>${option.text}</span>
                            </button>
                        `).join('');

                        optionsWrap.innerHTML = filtered.map((option) => `
                            <button type="button" class="campaign-multiselect__option${option.selected ? ' campaign-multiselect__option--selected' : ''}" data-option-value="${option.value}">
                                <span>${option.text}</span>
                                ${option.selected ? '<span class="campaign-multiselect__check">✓</span>' : ''}
                            </button>
                        `).join('');

                        empty.hidden = filtered.length > 0;
                    };

                    const toggleDropdown = (isOpen) => {
                        wrapper.classList.toggle('campaign-multiselect--open', isOpen);
                        if (isOpen) {
                            search.focus();
                        }
                    };

                    render();

                    control.addEventListener('click', () => toggleDropdown(true));
                    search.addEventListener('input', () => render(search.value));

                    optionsWrap.addEventListener('click', (event) => {
                        const optionButton = event.target.closest('[data-option-value]');
                        if (!optionButton) {
                            return;
                        }

                        const option = Array.from(select.options).find((item) => item.value === optionButton.dataset.optionValue);
                        if (!option) {
                            return;
                        }

                        option.selected = !option.selected;
                        render(search.value);
                    });

                    chips.addEventListener('click', (event) => {
                        const chip = event.target.closest('[data-chip-value]');
                        if (!chip) {
                            return;
                        }

                        const option = Array.from(select.options).find((item) => item.value === chip.dataset.chipValue);
                        if (!option) {
                            return;
                        }

                        option.selected = false;
                        render(search.value);
                    });

                    document.addEventListener('click', (event) => {
                        if (!wrapper.contains(event.target)) {
                            toggleDropdown(false);
                        }
                    });

                    control.addEventListener('keydown', (event) => {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            toggleDropdown(true);
                        }
                    });
                });
            };

            const syncButtonLimitState = () => {
                const count = buttonBuilder.querySelectorAll('[data-button-card]').length;
                const reachedLimit = count >= 2;

                addButton.disabled = reachedLimit;
                addButton.classList.toggle('campaign-outline-button--disabled', reachedLimit);
                buttonWarning.hidden = !reachedLimit;
            };

            const renderPhoneActions = () => {
                const cards = Array.from(buttonBuilder.querySelectorAll('[data-button-card]'));

                if (!cards.length) {
                    phoneActions.innerHTML = '';
                    return;
                }

                phoneActions.innerHTML = cards.map((card) => {
                    const buttonText = card.querySelector('[data-button-text]').value.trim();
                    const previewLabel = buttonText || 'Visit website';

                    return `<div class="campaign-phone__action">${previewLabel}</div>`;
                }).join('');
            };

            const updateButtonCardMeta = (card) => {
                const buttonText = card.querySelector('[data-button-text]');
                const websiteInput = card.querySelector('[data-action-url]');
                const buttonMeta = card.querySelector('[data-button-meta]');
                const urlMeta = card.querySelector('[data-url-meta]');

                buttonMeta.innerHTML = `${buttonText.value.length} / 25`;
                urlMeta.innerHTML = `${websiteInput.value.length} / 2000`;
                renderPhoneActions();
            };

            const createButtonCard = () => {
                if (buttonBuilder.querySelectorAll('[data-button-card]').length >= 2) {
                    buttonWarning.hidden = false;
                    return;
                }

                buttonIndex += 1;

                const card = document.createElement('article');
                card.className = 'campaign-button-card';
                card.dataset.buttonCard = String(buttonIndex);
                card.innerHTML = `
                    <div class="campaign-button-card__header">
                        <h3>Call to Action</h3>
                        <button type="button" class="campaign-button-card__remove" data-remove-button aria-label="Hapus tombol">×</button>
                    </div>
                    <div class="campaign-button-card__fields">
                        <div class="campaign-button-card__field">
                            <label>Type of action</label>
                            <select class="text-input text-input--select" data-action-type>
                                <option value="visit_website">Visit website</option>
                            </select>
                        </div>
                        <div class="campaign-button-card__field">
                            <label>Button Text</label>
                            <input type="text" class="text-input" data-button-text maxlength="25" value="tes">
                            <div class="campaign-button-card__meta" data-button-meta>3 / 25</div>
                        </div>
                        <div class="campaign-button-card__field">
                            <label>Url Type</label>
                            <select class="text-input text-input--select" data-url-type>
                                <option value="static">static</option>
                            </select>
                        </div>
                        <div class="campaign-button-card__field">
                            <label>Website URL</label>
                            <input type="text" class="text-input" data-action-url maxlength="2000" value="https://asd.com">
                            <div class="campaign-button-card__meta" data-url-meta>15 / 2000</div>
                        </div>
                    </div>
                `;

                buttonBuilder.appendChild(card);

                const removeButton = card.querySelector('[data-remove-button]');
                const buttonText = card.querySelector('[data-button-text]');
                const websiteInput = card.querySelector('[data-action-url]');

                const syncCard = () => updateButtonCardMeta(card);

                buttonText.addEventListener('input', syncCard);
                websiteInput.addEventListener('input', syncCard);
                removeButton.addEventListener('click', () => {
                    card.remove();
                    renderPhoneActions();
                    syncButtonLimitState();
                });

                syncCard();
                syncButtonLimitState();
            };

            const unlockCampaign = window.unlockCampaignTitleModal || (() => {
                titlePreview.textContent = titleInput.value.trim() || 'Tanpa Judul';
                body.classList.remove('campaign-title-locked');
                body.classList.add('campaign-title-ready');
            });

            const syncMessagePreview = () => {
                const message = messageInput.value.trim();
                messagePreview.textContent = message || 'Preview pesan akan muncul di sini.';
                messageCount.textContent = `${messageInput.value.length}/160 karakter`;
            };

            const normalizeAudience = (value) => new Intl.NumberFormat('id-ID').format(value);

            const calculateAudience = () => {
                const radius = Number(locationRadiusInput.value || 0);
                const base = Math.max(0, radius) * 6;
                locationState.audience = Math.max(0, base);
                audienceEstimate.textContent = normalizeAudience(locationState.audience);
            };

            const updateLiveRadius = () => {
                if (!liveCircle || !liveMarker) {
                    return;
                }

                liveCircle.setRadius(Number(locationRadiusInput.value || 0));
                liveCircle.setLatLng(liveMarker.getLatLng());
            };

            const updateLocationPoint = (latlng, label) => {
                if (!liveMap) {
                    return;
                }

                locationState.lat = latlng.lat;
                locationState.lng = latlng.lng;
                locationState.name = label || `${latlng.lat.toFixed(5)}, ${latlng.lng.toFixed(5)}`;

                if (!liveMarker) {
                    liveMarker = L.marker(latlng).addTo(liveMap);
                } else {
                    liveMarker.setLatLng(latlng);
                }

                if (!liveCircle) {
                    liveCircle = L.circle(latlng, {
                        radius: Number(locationRadiusInput.value || 0),
                        color: '#ff475d',
                        weight: 2,
                        fillColor: '#ff475d',
                        fillOpacity: 0.16,
                    }).addTo(liveMap);
                } else {
                    liveCircle.setLatLng(latlng);
                }

                updateLiveRadius();

                if (mapFeedback) {
                    mapFeedback.textContent = `Titik aktif: ${locationState.name}`;
                }
            };

            const initLiveMap = () => {
                if (liveMap || !locationCanvas || typeof window.L === 'undefined') {
                    if (!locationCanvas || typeof window.L !== 'undefined') {
                        return;
                    }

                    locationCanvas.innerHTML = '<div class="campaign-map-fallback">Peta tidak dapat dimuat saat ini. Periksa koneksi internet atau cache browser, lalu coba buka lagi popup lokasi.</div>';
                    return;
                }

                liveMap = L.map(locationCanvas, {
                    zoomControl: true,
                }).setView([locationState.lat, locationState.lng], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }).addTo(liveMap);

                updateLocationPoint(L.latLng(locationState.lat, locationState.lng), locationState.name);

                liveMap.on('click', (event) => {
                    updateLocationPoint(event.latlng);
                });

                if (locationSearchHost && window.L.Control?.Geocoder) {
                    geocoderControl = L.Control.geocoder({
                        defaultMarkGeocode: false,
                        placeholder: 'Masukkan lokasi pencarian',
                    })
                        .on('markgeocode', (event) => {
                            const center = event.geocode.center;
                            updateLocationPoint(center, event.geocode.name);
                            liveMap.setView(center, 15);
                        })
                        .addTo(liveMap);

                    const geocoderContainer = geocoderControl.getContainer?.();
                    if (geocoderContainer) {
                        locationSearchHost.appendChild(geocoderContainer);
                    }
                }
            };

            const openLocationModal = () => {
                locationModal.hidden = false;
                locationModal.setAttribute('aria-hidden', 'false');
                body.classList.add('campaign-map-open');
                initLiveMap();
                calculateAudience();
                updateLiveRadius();
                window.setTimeout(() => {
                    liveMap?.invalidateSize();
                }, 120);
            };

            const closeLocationModal = () => {
                locationModal.hidden = true;
                locationModal.setAttribute('aria-hidden', 'true');
                body.classList.remove('campaign-map-open');
            };

            window.openCampaignLocationModal = openLocationModal;
            window.closeCampaignLocationModal = closeLocationModal;

            syncMessagePreview();
            initCampaignMultiselects();
            createButtonCard();
            calculateAudience();
            closeLocationModal();

            openLocationModalButton?.addEventListener('click', openLocationModal);
            locationCloseButtons.forEach((button) => {
                button.addEventListener('click', closeLocationModal);
            });
            locationRadiusInput?.addEventListener('input', () => {
                updateLiveRadius();
                calculateAudience();
            });
            calcAudienceButton?.addEventListener('click', calculateAudience);
            applyLocationButton?.addEventListener('click', () => {
                calculateAudience();
                openLocationModalButton?.classList.add('campaign-outline-button--applied');
                openLocationModalButton?.querySelector('span:last-child')?.replaceChildren(document.createTextNode('Ubah Lokasi'));
                closeLocationModal();
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' && body.classList.contains('campaign-title-locked')) {
                    event.preventDefault();
                    unlockCampaign();
                }

                if (event.key === 'Escape' && !locationModal.hidden) {
                    closeLocationModal();
                }
            });

            titleSubmit?.addEventListener('click', unlockCampaign);
            document.addEventListener('click', (event) => {
                if (event.target.closest('#campaignTitleSubmit')) {
                    unlockCampaign();
                }
            });
            messageInput?.addEventListener('input', syncMessagePreview);
            addButton?.addEventListener('click', createButtonCard);
        })();
    </script>
@endpush

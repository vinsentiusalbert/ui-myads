<script>
    (() => {
        const templateBodyInput = document.getElementById('templateBodyInput');
        const templateBodyCount = document.getElementById('templateBodyCount');
        const templatePreviewBody = document.getElementById('templatePreviewBody');
        const templateAssetInput = document.getElementById('templateAssetInput');
        const templatePreviewImage = document.getElementById('templatePreviewImage');
        const templateAssetLabel = document.getElementById('templateAssetLabel');
        const templateAddButton = document.getElementById('templateAddButton');
        const templateButtonList = document.getElementById('templateButtonList');
        const templatePreviewActions = document.getElementById('templatePreviewActions');
        const templateButtonWarning = document.getElementById('templateButtonWarning');
        const templateTypeInputs = Array.from(document.querySelectorAll('input[name="template_type"]'));
        const isTemplateRead = @json($isWaTemplateRead);
        let templateButtonIndex = 0;

        const syncTemplateChoiceState = () => {
            templateTypeInputs.forEach((input) => {
                input.closest('.template-builder-choice')?.classList.toggle('template-builder-choice--active', input.checked);
            });
        };

        const syncTemplateBodyPreview = () => {
            if (!templateBodyInput || !templatePreviewBody || !templateBodyCount) {
                return;
            }

            const value = templateBodyInput.value.trim();
            templatePreviewBody.textContent = value || `Halo Pelanggan Setia ComboFit, kamu mendapatkan akses Exercise Plan GRATIS selama 30 hari 🔥

✅ Akses ke program latihan fisik oleh Coach profesional
✅ Panduan video latihan yang mudah diikuti
✅ Tips dan trik kebugaran

Aktifkan akunmu di link ini
https://bit.ly/Fita_Combofit

#SehatMakinNikmat bersama Fita!`;
            templateBodyCount.textContent = `${templateBodyInput.value.length} / 1024`;
        };

        const syncTemplateAssetPreview = () => {
            if (!templateAssetInput || !templatePreviewImage || !templateAssetLabel) {
                return;
            }

            const [file] = templateAssetInput.files || [];
            if (!file) {
                templatePreviewImage.src = "{{ asset('assets/logo.png') }}";
                templateAssetLabel.textContent = 'Upload an asset';
                return;
            }

            templateAssetLabel.textContent = file.name;
            const reader = new FileReader();
            reader.onload = (event) => {
                if (typeof event.target?.result === 'string') {
                    templatePreviewImage.src = event.target.result;
                }
            };
            reader.readAsDataURL(file);
        };

        const syncTemplateButtons = () => {
            if (!templateButtonList || !templatePreviewActions || !templateAddButton || !templateButtonWarning) {
                return;
            }

            const cards = Array.from(templateButtonList.querySelectorAll('[data-template-button-card]'));
            templateButtonWarning.hidden = cards.length < 2;
            templateAddButton.disabled = cards.length >= 2;

            if (!cards.length) {
                templatePreviewActions.innerHTML = '<div class="template-builder-phone__cta">Coba Sekarang</div>';
                return;
            }

            templatePreviewActions.innerHTML = cards.map((card) => {
                const label = card.querySelector('[data-template-button-text]')?.value?.trim() || 'Visit website';
                return `<div class="template-builder-phone__cta">${label}</div>`;
            }).join('');
        };

        const bindTemplateButtonCard = (card) => {
            const textInput = card.querySelector('[data-template-button-text]');
            const urlInput = card.querySelector('[data-template-button-url]');
            const removeButton = card.querySelector('[data-template-button-remove]');
            const textMeta = card.querySelector('[data-template-button-meta]');
            const urlMeta = card.querySelector('[data-template-url-meta]');

            const syncCard = () => {
                if (textMeta && textInput) {
                    textMeta.textContent = `${textInput.value.length} / 25`;
                }
                if (urlMeta && urlInput) {
                    urlMeta.textContent = `${urlInput.value.length} / 2000`;
                }
                syncTemplateButtons();
            };

            textInput?.addEventListener('input', syncCard);
            urlInput?.addEventListener('input', syncCard);
            removeButton?.addEventListener('click', () => {
                card.remove();
                syncTemplateButtons();
            });

            syncCard();
        };

        syncTemplateBodyPreview();
        syncTemplateChoiceState();

        templateBodyInput?.addEventListener('input', syncTemplateBodyPreview);
        templateTypeInputs.forEach((input) => {
            input.addEventListener('change', syncTemplateChoiceState);
        });

        if (!isTemplateRead) {
            syncTemplateAssetPreview();
            templateAssetInput?.addEventListener('change', syncTemplateAssetPreview);
        }

        templateAddButton?.addEventListener('click', () => {
            if (!templateButtonList || templateButtonList.querySelectorAll('[data-template-button-card]').length >= 2) {
                syncTemplateButtons();
                return;
            }

            templateButtonIndex += 1;
            const card = document.createElement('article');
            card.className = 'template-builder-button-card';
            card.dataset.templateButtonCard = String(templateButtonIndex);
            card.innerHTML = `
                <div class="template-builder-button-card__head">
                    <h3>Call to Action</h3>
                </div>
                <div class="template-builder-button-card__grid">
                    <div class="template-builder-button-card__field">
                        <label>Type of action</label>
                        <select>
                            <option>Visit website</option>
                        </select>
                    </div>
                    <div class="template-builder-button-card__field">
                        <label>Button Text</label>
                        <input type="text" value="Visit website" maxlength="25" data-template-button-text>
                        <span class="template-builder-button-card__meta" data-template-button-meta>13 / 25</span>
                    </div>
                    <div class="template-builder-button-card__field">
                        <label>Url Type</label>
                        <select>
                            <option>static</option>
                        </select>
                    </div>
                    <div class="template-builder-button-card__field">
                        <label>Website URL</label>
                        <input type="text" value="" maxlength="2000" placeholder="Website URL" data-template-button-url>
                        <span class="template-builder-button-card__meta" data-template-url-meta>0 / 2000</span>
                    </div>
                    <button type="button" class="template-builder-button-card__remove" data-template-button-remove aria-label="Hapus tombol">×</button>
                </div>
                <div class="template-builder-button-card__alert">
                    <span>⚠</span>
                    <p>Direct WhatsApp links are not allowed in CTA buttons as per Meta's policy. Please place the link (e.g. wa.me/6281xxx) in the message body instead</p>
                </div>
            `;

            templateButtonList.appendChild(card);
            bindTemplateButtonCard(card);
            syncTemplateButtons();
        });

        syncTemplateButtons();
    })();
</script>

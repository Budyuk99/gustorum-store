// Оборачиваем весь код, чтобы $ работал в WordPress
jQuery(function ($) {

    // ============================
    // Dropdown — выбор языка
    // ============================

    const langBtn = document.querySelector(".lang-dropdown");
    const langDropdown = document.querySelector(".lang-dropdown");

    if (langBtn && langDropdown) {
        langBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            langDropdown.classList.toggle("active");
        });

        document.addEventListener("click", (e) => {
            if (!langDropdown.contains(e.target)) {
                langDropdown.classList.remove("active");
            }
        });

        window.addEventListener('orientationchange', () => {
            langDropdown.classList.remove("active");
        });

        window.addEventListener('scroll', () => {
            langDropdown.classList.remove("active");
        });
    }

    // ============================
    // Owl Carousel
    // ============================

    $(".gallery-slider").owlCarousel({
        loop: true,
        center: true,
        margin: 20,
        nav: true,
        dots: true,
        smartSpeed: 600,
        responsive: {
            0: { items: 1.05, stagePadding: 30 },
            768: { items: 1.05, stagePadding: 60 },
            1200: { items: 1.05, stagePadding: 100 },
            1600: { items: 1.05, stagePadding: 140 },
        },
    });

    // ============================
    // Toggle text
    // ============================

    document.querySelectorAll('.toggle-text-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const parent = this.closest('.content-block_item-text');
            const fullText = parent.querySelector('.full-text');
            const isExpanded = parent.classList.contains('expanded');

            if (!isExpanded) {
                parent.classList.add('expanded');
                fullText.style.maxHeight = fullText.scrollHeight + "px";
                this.textContent = "Скрыть";
            } else {
                fullText.style.maxHeight = fullText.scrollHeight + "px";
                requestAnimationFrame(() => {
                    fullText.style.maxHeight = "0";
                });

                fullText.addEventListener('transitionend', function handler() {
                    parent.classList.remove('expanded');
                    fullText.removeEventListener('transitionend', handler);
                });

                this.textContent = "Узнать больше";
            }
        });
    });

    // ============================
    // Мессенджер-кнопка
    // ============================

    const messengerBtn = document.querySelector('.messenger-btn');
    const messengerWrapper = document.querySelector('.messenger-wrapper');

    if (messengerBtn && messengerWrapper) {
        messengerBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            messengerWrapper.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!messengerWrapper.contains(e.target)) {
                messengerWrapper.classList.remove('active');
            }
        });

        document.querySelectorAll('.messenger-option').forEach(option => {
            option.addEventListener('click', () => {
                setTimeout(() => {
                    messengerWrapper.classList.remove('active');
                }, 300);
            });
        });
    }

});

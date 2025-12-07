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
        autoplay: true,
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
            
            // Получаем тексты из data-атрибутов
            const learnMoreText = this.dataset.learnMore || 'Узнать больше';
            const hideText = this.dataset.hideText || 'Скрыть';

            if (!isExpanded) {
                parent.classList.add('expanded');
                fullText.style.maxHeight = fullText.scrollHeight + "px";
                this.textContent = hideText;
            } else {
                fullText.style.maxHeight = fullText.scrollHeight + "px";
                requestAnimationFrame(() => {
                    fullText.style.maxHeight = "0";
                });

                fullText.addEventListener('transitionend', function handler() {
                    parent.classList.remove('expanded');
                    fullText.removeEventListener('transitionend', handler);
                });

                this.textContent = learnMoreText;
            }
        });
    });

    // ============================
    // Кнопка мессенджера
    // ============================

    const messengerBtnTrigger = document.querySelector('.messenger-btn'); // Переименовал
    const messengerWrapper = document.querySelector('.messenger-wrapper');

    if (messengerBtnTrigger && messengerWrapper) {
        messengerBtnTrigger.addEventListener('click', (e) => {
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

    // ============================
    // Скрытие кнопки мессенджера при прокрутке к футеру
    // ============================

    const footer = document.querySelector('.footer');
    
    if (messengerWrapper && footer) {
        // Функция для проверки видимости футера
        function checkFooterVisibility() {
            const footerRect = footer.getBoundingClientRect();
            const footerTop = footerRect.top;
            const windowHeight = window.innerHeight;
            
            // Если верх футера находится в видимой области окна (или выше)
            if (footerTop <= windowHeight) {
                // Футер виден или почти виден - скрываем кнопку
                messengerWrapper.style.opacity = '0';
                messengerWrapper.style.visibility = 'hidden';
                messengerWrapper.style.pointerEvents = 'none';
                messengerWrapper.style.transition = 'opacity 0.3s ease, visibility 0.3s ease';
            } else {
                // Футер не виден - показываем кнопку
                messengerWrapper.style.opacity = '1';
                messengerWrapper.style.visibility = 'visible';
                messengerWrapper.style.pointerEvents = 'auto';
                messengerWrapper.style.transition = 'opacity 0.3s ease, visibility 0.3s ease';
            }
        }
        
        // Проверяем при загрузке страницы
        checkFooterVisibility();
        
        // Проверяем при прокрутке
        window.addEventListener('scroll', checkFooterVisibility);
        
        // Проверяем при изменении размера окна
        window.addEventListener('resize', checkFooterVisibility);
    }

}); // Конец jQuery(function ($)
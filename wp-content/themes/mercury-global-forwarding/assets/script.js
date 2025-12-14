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
    // Owl Carousel с невидимой Hover Navigation
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
            0: { 
                items: 1.05, 
                stagePadding: 30
            },
            768: { 
                items: 1.05, 
                stagePadding: 60
            },
            1200: { 
                items: 1.05, 
                stagePadding: 100
            },
            1600: { 
                items: 1.05, 
                stagePadding: 140
            },
        }
    });

    // Невидимая hover навигация
    function initInvisibleHoverNav() {
        const slider = $('.gallery-slider');
        
        // Отключаем на мобильных
        if (window.innerWidth < 768) {
            removeHoverZones();
            return;
        }
        
        // Если зоны уже есть - удаляем
        removeHoverZones();
        
        // Создаем невидимые зоны
        slider.css('position', 'relative');
        slider.append(`
            <div class="invisible-hover-zone left-hover-zone"></div>
            <div class="invisible-hover-zone right-hover-zone"></div>
        `);
        
        // Настройка зон
        const leftZone = $('.left-hover-zone');
        const rightZone = $('.right-hover-zone');
        const zoneWidth = 80; // Ширина зоны в пикселях
        
        leftZone.css({
            'position': 'absolute',
            'left': '0',
            'top': '0',
            'width': zoneWidth + 'px',
            'height': '100%',
            'z-index': '10',
            'cursor': 'pointer'
        });
        
        rightZone.css({
            'position': 'absolute',
            'right': '0',
            'top': '0',
            'width': zoneWidth + 'px',
            'height': '100%',
            'z-index': '10',
            'cursor': 'pointer'
        });
        
        // Обработчики для левой зоны
        let leftTimer;
        leftZone.hover(
            function() {
                // Навели курсор
                leftTimer = setTimeout(function() {
                    slider.trigger('prev.owl.carousel');
                }, 300); // Задержка 300ms
            },
            function() {
                // Убрали курсор
                clearTimeout(leftTimer);
            }
        );
        
        // Обработчики для правой зоны
        let rightTimer;
        rightZone.hover(
            function() {
                rightTimer = setTimeout(function() {
                    slider.trigger('next.owl.carousel');
                }, 300);
            },
            function() {
                clearTimeout(rightTimer);
            }
        );
        
        // Также клик для мгновенного переключения
        leftZone.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            slider.trigger('prev.owl.carousel');
        });
        
        rightZone.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            slider.trigger('next.owl.carousel');
        });
    }
    
    // Удаление зон
    function removeHoverZones() {
        $('.invisible-hover-zone').remove();
    }
    
    // Инициализация после загрузки
    $(document).ready(function() {
        // Даем время Owl Carousel на инициализацию
        setTimeout(initInvisibleHoverNav, 1000);
    });
    
    // Обновление при ресайзе
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            removeHoverZones();
            initInvisibleHoverNav();
        }, 250);
    });

    // ============================
    // Toggle text
    // ============================

    document.querySelectorAll('.toggle-text-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const parent = this.closest('.content-block_item-text');
            const isExpanded = parent.classList.contains('expanded');

            const item = this.closest('.content-block_item');
            const textWrapper = item.querySelector('.content-block_item-text');
            const fullText = item.querySelector('.full-text');
            
            if (!isExpanded) {
                item.classList.add('expanded');
                textWrapper.classList.add('expanded');
                fullText.style.maxHeight = fullText.scrollHeight + "px";
                this.textContent = hideText;
            } else {
                fullText.style.maxHeight = fullText.scrollHeight + "px";
                requestAnimationFrame(() => {
                    fullText.style.maxHeight = "0";
                });

                fullText.addEventListener('transitionend', function handler() {
                    item.classList.remove('expanded');
                    textWrapper.classList.remove('expanded');
                    fullText.removeEventListener('transitionend', handler);
                });

                this.textContent = learnMoreText;
            }
        });
    });

    // ============================
    // Кнопка мессенджера
    // ============================

    const messengerBtnTrigger = document.querySelector('.messenger-btn');
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
        function checkFooterVisibility() {
            const footerRect = footer.getBoundingClientRect();
            const footerTop = footerRect.top;
            const windowHeight = window.innerHeight;
            
            if (footerTop <= windowHeight) {
                messengerWrapper.style.opacity = '0';
                messengerWrapper.style.visibility = 'hidden';
                messengerWrapper.style.pointerEvents = 'none';
                messengerWrapper.style.transition = 'opacity 0.3s ease, visibility 0.3s ease';
            } else {
                messengerWrapper.style.opacity = '1';
                messengerWrapper.style.visibility = 'visible';
                messengerWrapper.style.pointerEvents = 'auto';
                messengerWrapper.style.transition = 'opacity 0.3s ease, visibility 0.3s ease';
            }
        }
        
        checkFooterVisibility();
        window.addEventListener('scroll', checkFooterVisibility);
        window.addEventListener('resize', checkFooterVisibility);
    }

}); // Конец jQuery(function ($)
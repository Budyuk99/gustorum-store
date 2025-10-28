// Защита от двойной инициализации
if (typeof window.sweetgiftInitialized !== 'undefined') {
    console.log('Gustorum script already initialized, skipping...');
} else {
    window.sweetgiftInitialized = true;
    
    jQuery(document).ready(function($){
        console.log('Gustorum script initialized');
        
        // ===== МОБИЛЬНОЕ МЕНЮ =====
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileMenuClose = document.querySelector('.mobile-menu__close');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
        const mobileMenuLinks = document.querySelectorAll('.mobile-menu__nav a');

        // Флаг для отслеживания состояния меню
        let isMenuOpen = false;

        // Функция открытия меню
        function openMobileMenu() {
            if (isMenuOpen) return; // Предотвращаем повторное открытие
 
            console.log('Opening mobile menu');
            isMenuOpen = true;
            mobileMenu.classList.add('active');
            mobileMenuOverlay.classList.add('active');
            mobileMenuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Функция закрытия меню
        function closeMobileMenu() {
            if (!isMenuOpen) return; // Предотвращаем повторное закрытие
            
            console.log('Closing mobile menu');
            isMenuOpen = false;
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            mobileMenuToggle.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Открытие меню по клику на бургер
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (!isMenuOpen) {
                    openMobileMenu();
                } else {
                    closeMobileMenu();
                }
            });
        }

        // Закрытие меню
        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMobileMenu();
            });
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeMobileMenu();
            });
        }

        // Закрытие меню при клике на ссылку
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                closeMobileMenu();
            });
        });

        // Закрытие меню при нажатии Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isMenuOpen) {
                closeMobileMenu();
            }
        });

        // ===== ИЗБРАННОЕ ДЛЯ КАРТОЧЕК ТОВАРОВ =====
        document.querySelectorAll('.add-favorite').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                this.classList.toggle('active');
                
                if (this.classList.contains('active')) {
                    this.style.color = '#d24a43';
                    this.textContent = '♥';
                } else {
                    this.style.color = '';
                    this.textContent = '♥';
                }
            });
        });

        // ===== БЕГУЩАЯ СТРОКА =====
        const marqueeTrack = document.querySelector('.marquee-track');
        if (marqueeTrack) {
            const items = marqueeTrack.querySelectorAll('.marquee-item');
            
            // Клонируем элементы для бесшовной анимации
            items.forEach(item => {
                const clone = item.cloneNode(true);
                marqueeTrack.appendChild(clone);
            });
            
            let animationId;
            let position = 0;
            const speed = 0.8;
            
            function animateMarquee() {
                const firstItem = marqueeTrack.firstElementChild;
                const itemWidth = firstItem.offsetWidth + 60;
                
                position -= speed;
                
                // Бесшовный цикл
                if (Math.abs(position) >= itemWidth) {
                    position += itemWidth;
                    marqueeTrack.appendChild(marqueeTrack.firstElementChild);
                }
                
                marqueeTrack.style.transform = `translateX(${position}px)`;
                animationId = requestAnimationFrame(animateMarquee);
            }
            
            // Запускаем анимацию
            animateMarquee();
            
            // Оптимизация производительности
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    cancelAnimationFrame(animationId);
                } else {
                    animateMarquee();
                }
            });
        }

        $(".owl-carousel-second").owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            nav: true,
            dots: false,
            responsive: {
                0: { items: 1 },
                480: { items: 1 },
                768: { items: 2 },
                992: { items: 3 },
                1200: { items: 5 }
            }
        });

        Fancybox.bind("[data-fancybox='gallery']", {
            Thumbs: false,
            Toolbar: true,
            infinite: true
        });

        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;
                item.classList.toggle('active');
            });
        });

        // ===== ПОПАПЫ =====
        const popup = document.getElementById('product-popup');
        const closeBtn = document.querySelector('.popup-close');

        function openPopup({ imgSrc, title, price, card, content, gallery }) {
            if (!popup) return;
            
            popup.classList.add('show');
            document.body.style.overflow = 'hidden';

            const popupLeft = popup.querySelector('.popup-left');
            if (popupLeft) {
                popupLeft.innerHTML = '';

                // ==== СТАРЫЙ ВАРИАНТ ====
                // Берем все изображения внутри карточки
                const images = card ? card.querySelectorAll('img') : [{ src: imgSrc }];

                const mainImage = document.createElement('img');
                mainImage.src = images[0].src;
                mainImage.classList.add('popup-main-image');
                mainImage.dataset.fancybox = 'popup-gallery';
                popupLeft.appendChild(mainImage);

                const galleryContainer = document.createElement('div');
                galleryContainer.classList.add('popup-thumbnails');

                images.forEach((img, i) => {
                    const thumbLink = document.createElement('a');
                    thumbLink.href = img.src;
                    thumbLink.dataset.fancybox = 'popup-gallery';
                    thumbLink.classList.add('popup-thumb');

                    const thumbImg = document.createElement('img');
                    thumbImg.src = img.src;
                    thumbImg.alt = `Фото ${i + 1}`;
                    thumbLink.appendChild(thumbImg);

                    galleryContainer.appendChild(thumbLink);
                });

                popupLeft.appendChild(galleryContainer);

                // Если передан массив gallery из data-gallery
                if (gallery && Array.isArray(gallery) && gallery.length > 0) {
                    popupLeft.innerHTML = ''; // очищаем старую версию, если есть галерея

                    // Главное изображение
                    const mainImg = document.createElement('img');
                    mainImg.src = gallery[0];
                    mainImg.classList.add('popup-main-image');
                    mainImg.dataset.fancybox = 'popup-gallery';
                    popupLeft.appendChild(mainImg);

                    // Миниатюры (начинаем со второго элемента, чтобы не дублировать главное)
                    if (gallery.length > 1) {
                        const thumbsContainer = document.createElement('div');
                        thumbsContainer.classList.add('popup-thumbnails');

                        gallery.slice(1).forEach((src, index) => {
                            const thumbLink = document.createElement('a');
                            thumbLink.href = src;
                            thumbLink.dataset.fancybox = 'popup-gallery';
                            thumbLink.classList.add('popup-thumb');

                            const thumbImg = document.createElement('img');
                            thumbImg.src = src;
                            thumbImg.alt = `Фото ${index + 2}`;
                            thumbLink.appendChild(thumbImg);

                            thumbsContainer.appendChild(thumbLink);
                        });

                        popupLeft.appendChild(thumbsContainer);
                    }
                }
            }

            // Заполняем информацию
            const productTitle = document.getElementById('popup-product-title');
            const productPrice = document.getElementById('popup-product-price');

            if (productTitle) productTitle.textContent = title;
            if (productPrice) productPrice.textContent = price;

            // Берём контейнер
            const contentsContainer = document.querySelector('.popup-product-info_description');

            if (contentsContainer && content) {
                // Если content — строка с HTML
                contentsContainer.innerHTML = content;
            }

            // Fancybox
            Fancybox.bind("[data-fancybox='popup-gallery']", {
                Thumbs: true,
                Toolbar: true,
                dragToClose: true,
            });
        }

        function closePopup() {
            if (!popup) return;
            
            popup.classList.remove('show');
            document.body.style.overflow = '';

            // Показываем кнопки обратно
            const whatsappButton = document.getElementById('whatsappButton');
            const scrollToTop = document.getElementById('scrollToTop');
            if (whatsappButton) whatsappButton.classList.remove('hidden');
            if (scrollToTop) scrollToTop.classList.remove('hidden');
        }

        // Обработка клика на кнопку "Посмотреть"
        document.querySelectorAll('.btn-buy').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const card = btn.closest('.product-card');
                const imgSrc = card.querySelector('.main-img').src;
                const title = card.querySelector('.product-info h3').innerText;
                const price = card.querySelector('.price-current').innerText;
                const content = JSON.parse(btn.dataset.contents || '[]');
                const gallery = JSON.parse(btn.dataset.gallery || '[]');
  
                openPopup({
                    imgSrc: imgSrc,
                    title: title,
                    price: price,
                    content: content,
                    gallery: gallery,
                });
            });
        });

        // Обработка клика на картинку товара
        document.querySelectorAll('.product-link').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const card = btn.closest('.product-card');
                const imgSrc = card.querySelector('.main-img').src;
                const title = card.querySelector('.product-info h3').innerText;
                const price = card.querySelector('.price-current').innerText;
                const content = JSON.parse(btn.dataset.contents || '[]');
                const gallery = JSON.parse(btn.dataset.gallery || '[]');

                openPopup({
                    imgSrc: imgSrc,
                    title: title,
                    price: price,
                    content: content,
                    gallery: gallery,
                });
            });
        });

        // Закрытие попапа
        if (closeBtn) {
            closeBtn.addEventListener('click', closePopup);
        }

        if (popup) {
            popup.addEventListener('click', (e) => {
                if (e.target === popup) closePopup();
            });
        }

        // ===== КНОПКА "НАВЕРХ" =====
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('#scrollToTop').addClass('show');
            } else {
                $('#scrollToTop').removeClass('show');
            }
        });

        $('#scrollToTop').click(function() {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        });

        // ===== БЕГУЩАЯ СТРОКА ПАРТНЕРОВ =====
        const track = document.querySelector('.partners-marquee__track');
        if (track) {
            const items = Array.from(track.children);
            const MARQUEE_SPEED = 30;
            
            if (items.length === 0) return;

            function createInfiniteScroll() {
                track.innerHTML = '';
                items.forEach(item => track.appendChild(item));
                
                let totalWidth = 0;
                items.forEach(item => {
                    totalWidth += item.offsetWidth + 60;
                });
                
                const screenWidth = window.innerWidth;
                const speedFactor = Math.max(3, Math.ceil(60 / MARQUEE_SPEED));
                const neededCopies = Math.ceil((screenWidth * speedFactor) / totalWidth) + 3;
                
                for (let i = 0; i < neededCopies; i++) {
                    items.forEach(item => {
                        const clone = item.cloneNode(true);
                        track.appendChild(clone);
                    });
                }
                
                restartAnimation();
            }

            function restartAnimation() {
                track.style.animation = 'none';
                void track.offsetWidth;
                track.style.animation = null;
            }

            function updateAnimationSpeed() {
                track.style.animationDuration = `${MARQUEE_SPEED}s`;
            }

            createInfiniteScroll();
            updateAnimationSpeed();
        }

        // ===== КАРУСЕЛЬ ОТЗЫВОВ =====
        $('.owl-carousel-reviews').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            smartSpeed: 600,
            lazyLoad: true,
            responsive: {
                0: { items: 1 },
                480: { items: 1 },
                768: { items: 2 },
                992: { items: 3 },
                1200: { items: 5 }
            }
        });

        // ===== СИСТЕМА ПОПАПОВ =====
        class PopupManager {
            constructor() {
                this.popup = document.getElementById('universal-popup');
                if (!this.popup) return;
                
                this.popupContent = this.popup.querySelector('.popup-content');
                this.popupTitle = document.getElementById('popup-title');
                this.popupSubmitBtn = document.getElementById('popup-submit-btn');
                
                this.init();
            }
            
            init() {
                document.querySelectorAll('[data-popup]').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const popupType = btn.dataset.popup;
                        const formType = btn.dataset.popupType || 'default';
                        
                        if (popupType === 'call') {
                            this.openFormPopup(formType);
                        }
                    });
                });
                
                this.setupCloseHandlers();
            }
            
            openFormPopup(formType = 'default') {
                this.popupContent.classList.add('form-only');
                
                switch(formType) {
                    case 'kp':
                        this.popupTitle.textContent = 'Запросить коммерческое предложение';
                        this.popupSubmitBtn.textContent = 'Запросить КП';
                        break;
                    case 'callback':
                        this.popupTitle.textContent = 'Заказать обратный звонок';
                        this.popupSubmitBtn.textContent = 'Заказать звонок';
                        break;
                    case 'discount':
                        this.popupTitle.textContent = 'Получить скидку';
                        this.popupSubmitBtn.textContent = 'Получить скидку';
                        break;
                    default:
                        this.popupTitle.textContent = 'Наш менеджер свяжется с вами в ближайшее время';
                        this.popupSubmitBtn.textContent = 'Отправить';
                }
                
                this.showPopup();
            }
            
            showPopup() {
                this.popup.classList.add('show');
                document.body.style.overflow = 'hidden';
                this.hideFloatingButtons();
            }
            
            closePopup() {
                this.popup.classList.remove('show');
                document.body.style.overflow = '';
                this.showFloatingButtons();
            }
            
            hideFloatingButtons() {
                const whatsappButton = document.getElementById('whatsappButton');
                const scrollToTop = document.getElementById('scrollToTop');
                
                if (whatsappButton) whatsappButton.classList.add('hidden');
                if (scrollToTop) scrollToTop.classList.add('hidden');
            }
            
            showFloatingButtons() {
                const whatsappButton = document.getElementById('whatsappButton');
                const scrollToTop = document.getElementById('scrollToTop');
                
                if (whatsappButton) whatsappButton.classList.remove('hidden');
                if (scrollToTop) scrollToTop.classList.remove('hidden');
            }
            
            setupCloseHandlers() {
                this.popup.querySelector('.popup-close').addEventListener('click', () => {
                    this.closePopup();
                });
                
                this.popup.addEventListener('click', (e) => {
                    if (e.target === this.popup) {
                        this.closePopup();
                    }
                });
                
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.popup.classList.contains('show')) {
                        this.closePopup();
                    }
                });
            }
        }

        // Инициализация менеджера попапов
        const popupManager = new PopupManager();

        // ===== FANCYBOX =====
        Fancybox.bind("[data-fancybox='gallery']", {
            Thumbs: false,
            Toolbar: true,
            infinite: true,
            on: {
                reveal: () => {
                    const whatsappButton = document.getElementById('whatsappButton');
                    const scrollToTop = document.getElementById('scrollToTop');
                    if (whatsappButton) whatsappButton.classList.add('hidden');
                    if (scrollToTop) scrollToTop.classList.add('hidden');
                },
                destroy: () => {
                    const whatsappButton = document.getElementById('whatsappButton');
                    const scrollToTop = document.getElementById('scrollToTop');
                    if (whatsappButton) whatsappButton.classList.remove('hidden');
                    if (scrollToTop) scrollToTop.classList.remove('hidden');
                }
            }
        });
    });
}
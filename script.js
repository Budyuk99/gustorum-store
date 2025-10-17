document.addEventListener('DOMContentLoaded', function() {
  // ===== МОБИЛЬНОЕ МЕНЮ =====
  const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');
  const mobileMenuClose = document.querySelector('.mobile-menu__close');
  const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
  const mobileMenuLinks = document.querySelectorAll('.mobile-menu__nav a');

  // Функция открытия меню
  function openMobileMenu() {
    mobileMenu.classList.add('active');
    mobileMenuOverlay.classList.add('active');
    mobileMenuToggle.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  // Функция закрытия меню
  function closeMobileMenu() {
    mobileMenu.classList.remove('active');
    mobileMenuOverlay.classList.remove('active');
    mobileMenuToggle.classList.remove('active');
    document.body.style.overflow = '';
  }

  // Открытие меню по клику на бургер
  if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener('click', openMobileMenu);
  }

  // Закрытие меню
  if (mobileMenuClose) {
    mobileMenuClose.addEventListener('click', closeMobileMenu);
  }

  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener('click', closeMobileMenu);
  }

  // Закрытие меню при клике на ссылку
  mobileMenuLinks.forEach(link => {
    link.addEventListener('click', closeMobileMenu);
  });

  // Закрытие меню при нажатии Escape
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
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

  // ===== КНОПКИ КУПИТЬ =====
  document.querySelectorAll('.btn-buy').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Анимация клика
      this.style.transform = 'scale(0.95)';
      setTimeout(() => {
        this.style.transform = '';
      }, 150);
      
      // Временное уведомление
      const originalText = this.textContent;
      this.textContent = 'Добавлено!';
      this.style.backgroundColor = '#2a7a53';
      
      setTimeout(() => {
        this.textContent = originalText;
        this.style.backgroundColor = '';
      }, 2000);
    });
  });
});

$('.owl-carousel-first').owlCarousel({
  loop: true,               // Бесконечная прокрутка
  margin: 0,
  nav: true,                // Стрелки
  dots: true,               // Точки
  autoplay: true,           // Автопрокрутка
  autoplayTimeout: 5000,    // Интервал (5 секунд)
  autoplayHoverPause: true, // Останавливается при наведении
  items: 1,                 // Один слайд за раз
  smartSpeed: 800,          // Плавность анимации
});

$(".owl-carousel-second").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    dots: false,
    responsive: {
        0: { items: 1 },
        480: { items: 1 },
        768: { items: 2 },
        992: { items: 3 },
        1200: { items: 5 }  // 5 слайдов на больших экранах
    }
});

document.querySelectorAll('.accordion-header').forEach(header => {
  header.addEventListener('click', () => {
    const item = header.parentElement;
    item.classList.toggle('active');
  });
});


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

Fancybox.bind("[data-fancybox='gallery']", {
    Thumbs: false,  // отключить миниатюры
    Toolbar: true,  // показать кнопки "закрыть, следующая, предыдущая"
    infinite: true  // бесконечный просмотр
});


document.querySelectorAll('.accordion-header').forEach(header => {
  header.addEventListener('click', () => {
    const item = header.parentElement;
    item.classList.toggle('active');
  });
});

// Получаем элементы
const popup = document.getElementById('product-popup');
const popupImage = document.getElementById('popup-image');
const popupTitle = document.getElementById('popup-title');
const popupPrice = document.getElementById('popup-price');
const popupSold = document.getElementById('popup-sold');
const closeBtn = document.querySelector('.popup-close');

// Обработка кнопки "Посмотреть"
document.querySelectorAll('.btn-buy').forEach(btn => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    const card = btn.closest('.product-card');

    // Получаем данные с карточки
    const imgSrc = card.querySelector('.main-img').src;
    const title = card.querySelector('.product-info h3').innerText;
    const price = card.querySelector('.price-current').innerText;
    const sold = card.querySelector('.sold-count').innerText;

    // Вставляем в попап
    popupImage.src = imgSrc;
    popupTitle.innerText = title;
    popupPrice.innerText = price;
    popupSold.innerText = sold;

    // Показываем попап с плавностью
    popup.classList.add('show');
  });
});

// Закрытие
closeBtn.addEventListener('click', () => {
  popup.classList.remove('show');
});

// Закрытие по клику вне окна
popup.addEventListener('click', (e) => {
  if (e.target === popup) {
    popup.classList.remove('show');
  }
});

$(document).ready(function() {
  // Показ кнопки при прокрутке
  $(window).scroll(function() {
    if ($(this).scrollTop() > 300) {
      $('#scrollToTop').addClass('show');
    } else {
      $('#scrollToTop').removeClass('show');
    }
  });

  // Скролл наверх при клике
  $('#scrollToTop').click(function() {
    $('html, body').animate({scrollTop: 0}, 600);
    return false;
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector('.partners-marquee__track');
  const items = Array.from(track.children);
  
  const screenWidth = window.innerWidth;
  let trackWidth = track.offsetWidth;

  // Клонируем элементы, пока ширина трека не станет >= 2 * ширины экрана
  let i = 0;
  while (trackWidth < screenWidth * 2) {
    const clone = items[i % items.length].cloneNode(true);
    track.appendChild(clone);
    trackWidth = track.offsetWidth;
    i++;
  }
});


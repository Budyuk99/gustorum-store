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

// Получаем элементы попапа и кнопок
const popup = document.getElementById('product-popup');
const popupImage = document.getElementById('popup-image');
const closeBtn = document.querySelector('.popup-close');

// Функция открытия попапа
function openPopup(imgSrc, title) {
  popupImage.src = imgSrc;
  popup.classList.add('show');
  document.body.style.overflow = 'hidden';

  // Скрываем кнопки
  if (whatsappButton) whatsappButton.classList.add('hidden');
  if (scrollToTop) scrollToTop.classList.add('hidden');
}

// Функция закрытия попапа
function closePopup() {
  popup.classList.remove('show');
  document.body.style.overflow = '';

  // Показываем кнопки обратно
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
    openPopup(imgSrc, title);
  });
});

// Закрытие кнопкой
if (closeBtn) {
  closeBtn.addEventListener('click', closePopup);
}

// Закрытие кликом вне попапа
if (popup) {
  popup.addEventListener('click', (e) => {
    if (e.target === popup) closePopup();
  });
}


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
  
  // НАСТРОЙКА СКОРОСТИ - изменяйте здесь
  const MARQUEE_SPEED = 30; // ← МЕНЯЙТЕ ЭТУ ПЕРЕМЕННУЮ
  
  if (!track || items.length === 0) return;

  // Функция для создания бесконечной прокрутки
  function createInfiniteScroll() {
    // Очищаем трек и добавляем оригинальные элементы
    track.innerHTML = '';
    items.forEach(item => track.appendChild(item));
    
    // Рассчитываем общую ширину оригинальных элементов
    let totalWidth = 0;
    items.forEach(item => {
      totalWidth += item.offsetWidth + 60; // 60px = margin (30px + 30px)
    });
    
    // Для высоких скоростей нужно БОЛЬШЕ копий
    const screenWidth = window.innerWidth;
    
    // Рассчитываем необходимое количество копий в зависимости от скорости
    // Чем выше скорость, тем больше копий нужно для плавности
    const speedFactor = Math.max(3, Math.ceil(60 / MARQUEE_SPEED)); // Больше копий для высокой скорости
    const neededCopies = Math.ceil((screenWidth * speedFactor) / totalWidth) + 3;
    
    // Добавляем копии
    for (let i = 0; i < neededCopies; i++) {
      items.forEach(item => {
        const clone = item.cloneNode(true);
        track.appendChild(clone);
      });
    }
    
    // Перезапускаем анимацию для плавности
    restartAnimation();
  }

  // Функция для перезапуска анимации
  function restartAnimation() {
    track.style.animation = 'none';
    void track.offsetWidth; // Принудительный reflow
    track.style.animation = null;
  }

  // Функция для установки фиксированной скорости
  function updateAnimationSpeed() {
    track.style.animationDuration = `${MARQUEE_SPEED}s`;
  }

  // Инициализация
  createInfiniteScroll();
  updateAnimationSpeed();
  
  // Ждем загрузки всех изображений
  const images = track.querySelectorAll('img');
  let loadedImages = 0;
  
  if (images.length > 0) {
    images.forEach(img => {
      if (img.complete) {
        imageLoaded();
      } else {
        img.addEventListener('load', imageLoaded);
        img.addEventListener('error', imageLoaded);
      }
    });
  } else {
    setTimeout(() => {
      updateAnimationSpeed();
      restartAnimation();
    }, 100);
  }
  
  function imageLoaded() {
    loadedImages++;
    if (loadedImages === images.length) {
      setTimeout(() => {
        createInfiniteScroll();
        updateAnimationSpeed();
      }, 100);
    }
  }

  // Оптимизированный обработчик изменения размера
  let resizeTimeout;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      createInfiniteScroll();
      updateAnimationSpeed();
    }, 250);
  });
});

const toggleButton = document.getElementById('mobileMenuToggle');
const closeButton = document.getElementById('mobileMenuClose');
const whatsappButton = document.getElementById('whatsappButton');
const scrollToTop = document.getElementById('scrollToTop');

toggleButton.addEventListener('click', () => {
  toggleButton.classList.toggle('active'); // анимация бургер-меню
  
  if(toggleButton.classList.contains('active')) {
    // Меню открыто — скрываем кнопку
    whatsappButton.classList.add('hidden');
    scrollToTop.classList.add('hidden');
  } else {
    // Меню закрыто — показываем кнопку
    whatsappButton.classList.remove('hidden');
    scrollToTop.classList.remove('hidden');
  }
});

closeButton.addEventListener('click', () => {
  toggleButton.classList.toggle('active'); // анимация бургер-меню
  
  if(toggleButton.classList.contains('active')) {
    // Меню открыто — показываем кнопку
    whatsappButton.classList.add('hidden');
    scrollToTop.classList.add('hidden');
  } else {
    // Меню закрыто — скрываем кнопку
    whatsappButton.classList.remove('hidden');
    scrollToTop.classList.remove('hidden');
  }
});

$('.owl-carousel-reviews').owlCarousel({
  loop: true,
  margin: 10,
  nav: false,
  dots: false,
  autoplay: true,
  autoplayTimeout: 4000,
  smartSpeed: 600,
  responsive: {
    0: { items: 1 },
    480: { items: 1 },
    768: { items: 2 },
    992: { items: 3 },
    1200: { items: 5 }  // 5 слайдов на больших экранах
  }
});

// Единая система попапов
class PopupManager {
  constructor() {
    this.popup = document.getElementById('universal-popup');
    if (!this.popup) return;
    
    this.popupContent = this.popup.querySelector('.popup-content');
    this.popupImage = document.getElementById('popup-image');
    this.popupTitle = document.getElementById('popup-title');
    this.popupSubmitBtn = document.getElementById('popup-submit-btn');
    
    this.init();
  }
  
  init() {
    // Обработчики для всех кнопок с data-popup атрибутом
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
    
    // Закрытие попапа
    this.setupCloseHandlers();
  }
  
  // Открытие попапа с формой
  openFormPopup(formType = 'default') {
    this.popupContent.classList.add('form-only');
    
    // Настраиваем контент в зависимости от типа формы
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
  
  // Открытие попапа с товаром
  openProductPopup(imgSrc, title) {
    this.popupContent.classList.remove('form-only');
    this.popupImage.src = imgSrc;
    this.popupTitle.textContent = 'Наш менеджер свяжется с вами в ближайшее время';
    this.popupSubmitBtn.textContent = 'Отправить';
    
    this.showPopup();
  }
  
  // Показать попап
  showPopup() {
    this.popup.classList.add('show');
    document.body.style.overflow = 'hidden';
    this.hideFloatingButtons();
    this.closeMobileMenu();
  }
  
  // Закрыть попап
  closePopup() {
    this.popup.classList.remove('show');
    document.body.style.overflow = '';
    this.showFloatingButtons();
  }
  
  // Скрыть плавающие кнопки
  hideFloatingButtons() {
    const whatsappButton = document.getElementById('whatsappButton');
    const scrollToTop = document.getElementById('scrollToTop');
    
    if (whatsappButton) whatsappButton.classList.add('hidden');
    if (scrollToTop) scrollToTop.classList.add('hidden');
  }
  
  // Показать плавающие кнопки
  showFloatingButtons() {
    const whatsappButton = document.getElementById('whatsappButton');
    const scrollToTop = document.getElementById('scrollToTop');
    
    if (whatsappButton) whatsappButton.classList.remove('hidden');
    if (scrollToTop) scrollToTop.classList.remove('hidden');
  }
  
  // Закрытие мобильного меню
  closeMobileMenu() {
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    
    if (mobileMenu && mobileMenu.classList.contains('active')) {
      mobileMenu.classList.remove('active');
      mobileMenuOverlay.classList.remove('active');
      mobileMenuToggle.classList.remove('active');
    }
  }
  
  // Настройка обработчиков закрытия
  setupCloseHandlers() {
    // Кнопка закрытия
    this.popup.querySelector('.popup-close').addEventListener('click', () => {
      this.closePopup();
    });
    
    // Клик вне контента
    this.popup.addEventListener('click', (e) => {
      if (e.target === this.popup) {
        this.closePopup();
      }
    });
    
    // Клавиша Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.popup.classList.contains('show')) {
        this.closePopup();
      }
    });
  }
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
  new PopupManager();
});

// ===== СКРЫТИЕ КНОПОК ПРИ ОТКРЫТИИ FANCYBOX =====
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



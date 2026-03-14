/**
 * Brokar Cultureel Huis — Main JavaScript
 * Award-winning interactions & animations
 */

(function () {
  'use strict';

  // ──────────────────────────────────────────────────────────────
  // Utilities
  // ──────────────────────────────────────────────────────────────
  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ──────────────────────────────────────────────────────────────
  // Header: scroll effects + transparent → solid
  // ──────────────────────────────────────────────────────────────
  function initHeader() {
    const header = $('#site-header');
    if (!header) return;

    let lastY = 0;
    let ticking = false;

    function update() {
      const y = window.scrollY;
      if (y > 60) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
      // Hide on scroll down, show on scroll up (after 300px)
      if (y > 300) {
        if (y > lastY) {
          header.style.transform = 'translateY(-100%)';
        } else {
          header.style.transform = 'translateY(0)';
        }
      } else {
        header.style.transform = 'translateY(0)';
      }
      lastY = y;
      ticking = false;
    }

    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(update);
        ticking = true;
      }
    }, { passive: true });

    // Transition only after first scroll (avoid flash on page load)
    setTimeout(() => {
      header.style.transition = 'transform 0.4s cubic-bezier(0.4,0,0.2,1), background 0.35s ease, box-shadow 0.35s ease, height 0.35s ease';
    }, 200);
  }

  // ──────────────────────────────────────────────────────────────
  // Reading Progress Bar
  // ──────────────────────────────────────────────────────────────
  function initReadingProgress() {
    const bar = $('#reading-progress');
    if (!bar) return;

    function update() {
      const scrollTop    = window.scrollY;
      const docHeight    = document.documentElement.scrollHeight - window.innerHeight;
      const progress     = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
      bar.style.setProperty('--progress', `${Math.min(100, progress)}%`);
    }

    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  // ──────────────────────────────────────────────────────────────
  // Mobile Menu
  // ──────────────────────────────────────────────────────────────
  function initMobileMenu() {
    const hamburger = $('#hamburger');
    const overlay   = $('#mobile-nav-overlay');
    const body      = document.body;

    if (!hamburger || !overlay) return;

    function open() {
      hamburger.setAttribute('aria-expanded', 'true');
      overlay.classList.add('is-open');
      overlay.setAttribute('aria-hidden', 'false');
      body.classList.add('menu-open');
      hamburger.setAttribute('aria-label', 'Menu sluiten');
    }

    function close() {
      hamburger.setAttribute('aria-expanded', 'false');
      overlay.classList.remove('is-open');
      overlay.setAttribute('aria-hidden', 'true');
      body.classList.remove('menu-open');
      hamburger.setAttribute('aria-label', 'Menu openen');
    }

    hamburger.addEventListener('click', () => {
      const isOpen = hamburger.getAttribute('aria-expanded') === 'true';
      isOpen ? close() : open();
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') close();
    });

    // Close on outside click
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) close();
    });
  }

  // ──────────────────────────────────────────────────────────────
  // Scroll Animations (Intersection Observer)
  // ──────────────────────────────────────────────────────────────
  function initScrollAnimations() {
    if (prefersReducedMotion) {
      $$('[data-animate]').forEach(el => el.classList.add('is-animated'));
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const delay = parseInt(entry.target.dataset.delay || 0, 10);
            setTimeout(() => {
              entry.target.classList.add('is-animated');
            }, delay);
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    $$('[data-animate]').forEach(el => observer.observe(el));
  }

  // ──────────────────────────────────────────────────────────────
  // Custom cursor glow (desktop only)
  // ──────────────────────────────────────────────────────────────
  function initCursorGlow() {
    if (prefersReducedMotion || window.matchMedia('(pointer: coarse)').matches) return;

    const cursor = document.createElement('div');
    cursor.className = 'cursor-glow';
    document.body.appendChild(cursor);

    let cx = 0, cy = 0, tx = 0, ty = 0;
    let raf;

    document.addEventListener('mousemove', (e) => {
      tx = e.clientX;
      ty = e.clientY;
    });

    function animate() {
      cx += (tx - cx) * 0.12;
      cy += (ty - cy) * 0.12;
      cursor.style.left = cx + 'px';
      cursor.style.top  = cy + 'px';
      raf = requestAnimationFrame(animate);
    }
    raf = requestAnimationFrame(animate);

    // Hover state on interactive elements
    $$('a, button, .pillar-card, .post-card, .event-row').forEach(el => {
      el.addEventListener('mouseenter', () => cursor.classList.add('is-hover'));
      el.addEventListener('mouseleave', () => cursor.classList.remove('is-hover'));
    });
  }

  // ──────────────────────────────────────────────────────────────
  // Number Counter Animation
  // ──────────────────────────────────────────────────────────────
  function initCounters() {
    if (prefersReducedMotion) return;

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          const el  = entry.target;
          const end = parseInt(el.dataset.count, 10);
          if (isNaN(end)) return;

          const duration = 1800;
          const start    = Date.now();

          function tick() {
            const elapsed  = Date.now() - start;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = Math.round(eased * end);
            // Preserve any suffix (sup tags etc.)
            const sup = el.querySelector('sup');
            el.childNodes[0].textContent = current.toLocaleString('nl-BE');
            if (progress < 1) requestAnimationFrame(tick);
          }
          requestAnimationFrame(tick);
          observer.unobserve(el);
        });
      },
      { threshold: 0.5 }
    );

    $$('[data-count]').forEach(el => observer.observe(el));
  }

  // ──────────────────────────────────────────────────────────────
  // Parallax (hero image, section backgrounds)
  // ──────────────────────────────────────────────────────────────
  function initParallax() {
    if (prefersReducedMotion) return;

    const heroImg = $('.hero__bg-img');
    if (!heroImg) return;

    let ticking = false;

    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          const y = window.scrollY;
          if (y < window.innerHeight * 1.5) {
            heroImg.style.transform = `translate3d(0, ${y * 0.25}px, 0)`;
          }
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  // ──────────────────────────────────────────────────────────────
  // Hero loaded class (for CSS transition)
  // ──────────────────────────────────────────────────────────────
  function initHero() {
    const hero = $('.hero');
    if (hero) {
      requestAnimationFrame(() => hero.classList.add('is-loaded'));
    }
  }

  // ──────────────────────────────────────────────────────────────
  // Sticky event ticker pause on hover (already in CSS, ensure marquee dup)
  // ──────────────────────────────────────────────────────────────
  function initTicker() {
    const inner = $('.event-ticker__inner');
    if (!inner) return;
    // Duplicate items to create seamless loop
    inner.innerHTML += inner.innerHTML;
  }

  // ──────────────────────────────────────────────────────────────
  // Smooth anchor scroll (for non-supported browsers)
  // ──────────────────────────────────────────────────────────────
  function initSmoothScroll() {
    $$('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const id = this.getAttribute('href');
        if (id === '#') return;
        const target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        const offset = 80 + 20;
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      });
    });
  }

  // ──────────────────────────────────────────────────────────────
  // Lazy images: add loading="lazy" to all images without it
  // ──────────────────────────────────────────────────────────────
  function initLazyImages() {
    $$('img:not([loading])').forEach(img => {
      img.setAttribute('loading', 'lazy');
    });
  }

  // ──────────────────────────────────────────────────────────────
  // Language switcher: set cookie via JS (fallback mode)
  // ──────────────────────────────────────────────────────────────
  function initLangSwitcher() {
    $$('.lang-switcher__link[data-lang]').forEach(link => {
      link.addEventListener('click', function () {
        const lang = this.dataset.lang;
        document.cookie = `brokar_lang=${lang};path=/;max-age=${60 * 60 * 24 * 365}`;
      });
    });
  }

  // ──────────────────────────────────────────────────────────────
  // Cookie consent (basic)
  // ──────────────────────────────────────────────────────────────
  function initCookieBanner() {
    if (document.cookie.indexOf('brokar_cookies=1') !== -1) return;

    const banner = document.createElement('div');
    banner.className = 'cookie-banner';
    banner.innerHTML = `
      <p>Wij gebruiken cookies om uw ervaring te verbeteren.
         <a href="/cookies">Meer info</a></p>
      <div class="cookie-banner__actions">
        <button class="btn btn--gold btn--sm" id="cookie-accept">Accepteren</button>
        <button class="btn btn--ghost btn--sm" id="cookie-decline">Weigeren</button>
      </div>
    `;
    document.body.appendChild(banner);

    // Inline styles for banner
    Object.assign(banner.style, {
      position: 'fixed',
      bottom: '1.5rem',
      left:  '1.5rem',
      right: '1.5rem',
      maxWidth: '600px',
      background: '#112036',
      border: '1px solid rgba(201,168,76,0.25)',
      borderRadius: '12px',
      padding: '1.25rem 1.5rem',
      display: 'flex',
      justifyContent: 'space-between',
      alignItems: 'center',
      gap: '1rem',
      zIndex: '1000',
      flexWrap: 'wrap',
      color: '#F5F0E8',
      fontFamily: 'Inter, system-ui, sans-serif',
      fontSize: '0.875rem',
      lineHeight: '1.5',
      boxShadow: '0 16px 64px rgba(0,0,0,0.3)',
    });

    function dismiss() {
      banner.style.transform = 'translateY(150%)';
      setTimeout(() => banner.remove(), 400);
    }
    banner.style.transition = 'transform 0.4s ease';

    $('#cookie-accept').addEventListener('click', () => {
      document.cookie = 'brokar_cookies=1;path=/;max-age=' + (60 * 60 * 24 * 365);
      dismiss();
    });
    $('#cookie-decline').addEventListener('click', dismiss);

    // Animate in
    banner.style.transform = 'translateY(150%)';
    setTimeout(() => { banner.style.transform = 'translateY(0)'; }, 800);
  }

  // ──────────────────────────────────────────────────────────────
  // External links: add rel + aria-label
  // ──────────────────────────────────────────────────────────────
  function initExternalLinks() {
    const host = window.location.hostname;
    $$('a[href]').forEach(link => {
      try {
        const url = new URL(link.href);
        if (url.hostname && url.hostname !== host) {
          if (!link.getAttribute('rel')) link.setAttribute('rel', 'noopener noreferrer');
          if (link.getAttribute('target') === '_blank') {
            link.setAttribute('aria-label', (link.textContent.trim() || 'link') + ' (opent in nieuw venster)');
          }
        }
      } catch (_) {}
    });
  }

  // ──────────────────────────────────────────────────────────────
  // Init all
  // ──────────────────────────────────────────────────────────────
  function init() {
    initHeader();
    initReadingProgress();
    initMobileMenu();
    initScrollAnimations();
    initCursorGlow();
    initCounters();
    initParallax();
    initHero();
    initTicker();
    initSmoothScroll();
    initLazyImages();
    initLangSwitcher();
    initCookieBanner();
    initExternalLinks();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();

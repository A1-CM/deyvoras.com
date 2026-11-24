const closeMenus = () => {
    document.querySelectorAll('.site-nav.is-open, .workspace-sidebar.is-open').forEach((menu) => menu.classList.remove('is-open'));
    document.body.classList.remove('menu-open');
    document.querySelectorAll('.menu-toggle[aria-expanded="true"]').forEach((button) => {
        button.setAttribute('aria-expanded', 'false');
        if (button.hasAttribute('aria-controls') && button.getAttribute('aria-controls') === 'site-nav') {
            button.setAttribute('aria-label', 'Open navigation');
        }
    });
};

document.querySelectorAll('.menu-toggle[aria-controls="site-nav"]').forEach((button) => {
    button.addEventListener('click', () => {
        const menu = document.getElementById(button.getAttribute('aria-controls'));
        const isOpen = menu.classList.toggle('is-open');
        button.setAttribute('aria-expanded', String(isOpen));
        button.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
        document.body.classList.toggle('menu-open', isOpen);
    });
});

document.querySelectorAll('#site-nav a').forEach((link) => {
    link.addEventListener('click', closeMenus);
});

document.querySelectorAll('.workspace-menu-toggle').forEach((button) => {
    button.addEventListener('click', () => {
        const sidebar = document.querySelector('.workspace-sidebar');
        const isOpen = sidebar.classList.toggle('is-open');
        button.setAttribute('aria-expanded', String(isOpen));
        document.body.classList.toggle('menu-open', isOpen);
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeMenus();
});

document.querySelectorAll('.copy-invite-link').forEach((button) => {
    button.addEventListener('click', async () => {
        const input = document.getElementById(button.dataset.copyTarget);
        try {
            await navigator.clipboard.writeText(input.value);
            button.textContent = 'Copied';
        } catch {
            input.select();
            document.execCommand('copy');
            button.textContent = 'Copied';
        }
    });
});

document.querySelectorAll('[data-testimonial-carousel]').forEach((carousel) => {
    const track = carousel.querySelector('[data-testimonial-track]');
    const slides = [...track.children];
    const dots = [...carousel.querySelectorAll('[data-testimonial-dot]')];
    const status = carousel.querySelector('[data-testimonial-status]');
    let activeIndex = 0;

    const showSlide = (index) => {
        activeIndex = (index + slides.length) % slides.length;
        track.style.transform = `translateX(-${activeIndex * 100}%)`;
        slides.forEach((slide, slideIndex) => {
            const isActive = slideIndex === activeIndex;
            slide.setAttribute('aria-hidden', String(!isActive));
            slide.inert = !isActive;
        });
        dots.forEach((dot, dotIndex) => {
            dot.setAttribute('aria-current', String(dotIndex === activeIndex));
        });
        status.textContent = `Perspective ${activeIndex + 1} of ${slides.length}`;
    };

    carousel.querySelector('[data-testimonial-prev]')?.addEventListener('click', () => showSlide(activeIndex - 1));
    carousel.querySelector('[data-testimonial-next]')?.addEventListener('click', () => showSlide(activeIndex + 1));
    dots.forEach((dot) => dot.addEventListener('click', () => showSlide(Number(dot.dataset.testimonialDot))));
    carousel.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            showSlide(activeIndex - 1);
        } else if (event.key === 'ArrowRight') {
            event.preventDefault();
            showSlide(activeIndex + 1);
        }
    });

    showSlide(0);
});

document.querySelectorAll('[data-billing-switch]').forEach((billingSwitch) => {
    const buttons = [...billingSwitch.querySelectorAll('[data-billing-period]')];
    const cards = billingSwitch.closest('.pricing-section')?.querySelectorAll('[data-plan-card]') ?? [];

    const setPeriod = (period) => {
        buttons.forEach((button) => {
            button.setAttribute('aria-pressed', String(button.dataset.billingPeriod === period));
        });
        cards.forEach((card) => {
            card.querySelectorAll('[data-price-value]').forEach((element) => {
                element.textContent = element.dataset[period];
            });
            card.querySelectorAll('[data-price-period]').forEach((element) => {
                element.textContent = element.dataset[period];
            });
            card.querySelectorAll('[data-price-detail]').forEach((element) => {
                element.textContent = element.dataset[`${period}Note`] ?? element.dataset[period];
            });
        });
    };

    buttons.forEach((button) => button.addEventListener('click', () => setPeriod(button.dataset.billingPeriod)));
});

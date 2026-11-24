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
            card.querySelectorAll('[data-checkout-plan]').forEach((link) => {
                const checkoutUrl = new URL(link.href, window.location.origin);
                checkoutUrl.searchParams.set('billing', period);
                link.href = checkoutUrl.toString();
            });
        });
    };

    buttons.forEach((button) => button.addEventListener('click', () => setPeriod(button.dataset.billingPeriod)));
});

document.querySelectorAll('[data-sandbox-checkout]').forEach((form) => {
    const numberInput = form.querySelector('[data-card-number]');
    const expiryInput = form.querySelector('[data-card-expiry]');
    const cvcInput = form.querySelector('[data-card-cvc]');

    const setError = (input, message) => {
        const error = form.querySelector(`[data-${input.dataset.cardError}]`);
        input.setCustomValidity(message);
        error.textContent = message;
        error.hidden = !message;
    };

    const luhnValid = (value) => {
        const digits = value.replace(/\D/g, '');
        if (digits.length < 12 || digits.length > 19) return false;
        let sum = 0;
        let doubleDigit = false;
        for (let index = digits.length - 1; index >= 0; index -= 1) {
            let digit = Number(digits[index]);
            if (doubleDigit) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }
            sum += digit;
            doubleDigit = !doubleDigit;
        }
        return sum % 10 === 0;
    };

    numberInput.dataset.cardError = 'card-number-error';
    expiryInput.dataset.cardError = 'card-expiry-error';
    cvcInput.dataset.cardError = 'card-cvc-error';

    numberInput.addEventListener('input', () => {
        const digits = numberInput.value.replace(/\D/g, '').slice(0, 19);
        numberInput.value = digits.replace(/(.{4})/g, '$1 ').trim();
        setError(numberInput, '');
    });
    expiryInput.addEventListener('input', () => {
        const digits = expiryInput.value.replace(/\D/g, '').slice(0, 4);
        expiryInput.value = digits.length > 2 ? `${digits.slice(0, 2)} / ${digits.slice(2)}` : digits;
        setError(expiryInput, '');
    });
    cvcInput.addEventListener('input', () => {
        cvcInput.value = cvcInput.value.replace(/\D/g, '').slice(0, 4);
        setError(cvcInput, '');
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const digits = numberInput.value.replace(/\D/g, '');
        const expiry = expiryInput.value.match(/^(0[1-9]|1[0-2])\s*\/\s*(\d{2})$/);
        let valid = true;

        setError(numberInput, luhnValid(digits) ? '' : 'Enter a card number that passes the Luhn check.');
        const month = expiry ? Number(expiry[1]) : 0;
        const year = expiry ? 2000 + Number(expiry[2]) : 0;
        const today = new Date();
        const isCurrentOrFuture = expiry && (year > today.getFullYear() || (year === today.getFullYear() && month >= today.getMonth() + 1));
        setError(expiryInput, isCurrentOrFuture ? '' : 'Enter a valid, current expiry date (MM / YY).');
        setError(cvcInput, /^\d{3,4}$/.test(cvcInput.value) ? '' : 'Enter a 3 or 4 digit security code.');

        if (!luhnValid(digits) || !isCurrentOrFuture || !/^\d{3,4}$/.test(cvcInput.value)) valid = false;
        if (!form.reportValidity()) valid = false;
        if (!valid) return;

        // Card values are deliberately unnamed, never posted, and cleared before submitting.
        numberInput.value = '';
        expiryInput.value = '';
        cvcInput.value = '';
        HTMLFormElement.prototype.submit.call(form);
    });
});

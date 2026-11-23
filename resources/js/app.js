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

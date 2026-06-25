(() => {
    const navLinks = Array.from(document.querySelectorAll('.main-nav a[href^="#"]'));
    const sections = navLinks.map((link) => {
        const id = link.getAttribute('href');
        const section = id ? document.querySelector(id) : null;

        return section ? { id, link, section } : null;
    }).filter(Boolean);

    let navTicking = false;

    const updateActiveNav = () => {
        const headerHeight = document.querySelector('[data-header]')?.offsetHeight || 0;
        const activationLine = headerHeight + Math.min(window.innerHeight * 0.28, 220);
        let active = null;

        sections.forEach((item) => {
            if (item.section.getBoundingClientRect().top <= activationLine) {
                active = item;
            }
        });

        navLinks.forEach((link) => {
            link.classList.toggle('is-active', active?.link === link);
        });
    };

    const scheduleActiveNav = () => {
        if (navTicking) {
            return;
        }

        navTicking = true;
        window.requestAnimationFrame(() => {
            updateActiveNav();
            navTicking = false;
        });
    };

    document.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const id = link.getAttribute('href');
            const target = id && id !== '#' ? document.querySelector(id) : null;

            if (!target) {
                return;
            }

            event.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            history.pushState(null, '', id);
            scheduleActiveNav();
        });
    });

    const updateStickyCall = () => {
        document.body.classList.toggle('has-sticky', window.scrollY > 420);
    };

    updateStickyCall();
    updateActiveNav();
    window.addEventListener('scroll', scheduleActiveNav, { passive: true });
    window.addEventListener('resize', scheduleActiveNav);
    window.addEventListener('scroll', updateStickyCall, { passive: true });
})();

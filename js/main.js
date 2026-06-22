(() => {
    const navLinks = Array.from(document.querySelectorAll('.main-nav a[href^="#"]'));
    const sections = navLinks
        .map((link) => document.querySelector(link.getAttribute('href')))
        .filter(Boolean);

    if ('IntersectionObserver' in window && navLinks.length > 0 && sections.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

            if (!visible) {
                return;
            }

            navLinks.forEach((link) => {
                link.classList.toggle('is-active', link.getAttribute('href') === `#${visible.target.id}`);
            });
        }, {
            rootMargin: '-25% 0px -60% 0px',
            threshold: [0.15, 0.35, 0.6],
        });

        sections.forEach((section) => observer.observe(section));
    }

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
        });
    });

    const updateStickyCall = () => {
        document.body.classList.toggle('has-sticky', window.scrollY > 420);
    };

    updateStickyCall();
    window.addEventListener('scroll', updateStickyCall, { passive: true });
})();

(function () {
    'use strict';

    function openModal(id) {
        const el = document.getElementById(id);
        if (el) el.classList.add('open');
    }

    function closeModal(id) {
        const el = document.getElementById(id);
        if (el) el.classList.remove('open');
    }

    document.addEventListener('click', function (e) {
        const openTrigger = e.target.closest('[data-modal-open]');
        if (openTrigger) {
            openModal(openTrigger.getAttribute('data-modal-open'));
        }
        const closeTrigger = e.target.closest('[data-modal-close]');
        if (closeTrigger) {
            closeModal(closeTrigger.getAttribute('data-modal-close'));
        }
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('open');
        }
    });

    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const message = form.getAttribute('data-confirm');
            if (message && !window.confirm(message)) {
                e.preventDefault();
            }
        });
    });

    document.querySelectorAll('[data-mark-read]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = btn.getAttribute('data-mark-read');
            const token = document.querySelector('meta[name="csrf-token"]').content;
            fetch(window.NOVABANK_BASE_URL + '/api/mark-notification-read.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + encodeURIComponent(id) + '&csrf_token=' + encodeURIComponent(token)
            }).then(function (res) {
                if (res.ok) {
                    const item = document.querySelector('[data-notification="' + id + '"]');
                    if (item) item.classList.remove('unread');
                    btn.remove();
                }
            });
        });
    });

    const amountInputs = document.querySelectorAll('input[data-amount-live]');
    amountInputs.forEach(function (input) {
        input.addEventListener('input', function () {
            const target = document.querySelector(input.getAttribute('data-amount-live'));
            if (target) {
                const val = parseFloat(input.value);
                target.textContent = isNaN(val) ? '' : val.toFixed(2);
            }
        });
    });

    const sidebarToggle = document.getElementById('mobile-menu-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            const open = document.body.classList.toggle('mobile-nav-open');
            sidebarToggle.setAttribute('aria-expanded', String(open));
            sidebarToggle.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
        });
    }

    document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            document.body.classList.remove('mobile-nav-open');
            if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'false');
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            document.body.classList.remove('mobile-nav-open');
            const nav = document.querySelector('.landing-nav');
            if (nav) {
                nav.classList.remove('is-open');
                const trigger = nav.querySelector('.landing-nav-burger');
                if (trigger) trigger.setAttribute('aria-expanded', 'false');
            }
            if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('click', function (event) {
        if (document.body.classList.contains('mobile-nav-open') && event.target === document.body) {
            document.body.classList.remove('mobile-nav-open');
            if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'false');
        }
    });

    const landingNav = document.querySelector('.landing-nav');
    if (landingNav) {
        const landingToggle = landingNav.querySelector('.landing-nav-burger');
        if (landingToggle) {
            landingToggle.addEventListener('click', function () {
                const open = landingNav.classList.toggle('is-open');
                landingToggle.setAttribute('aria-expanded', String(open));
                landingToggle.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
            });
            landingNav.querySelectorAll('.landing-nav-links a').forEach(function (link) {
                link.addEventListener('click', function () {
                    landingNav.classList.remove('is-open');
                    landingToggle.setAttribute('aria-expanded', 'false');
                });
            });
        }
        const updateLandingNav = function () {
            landingNav.classList.toggle('is-scrolled', window.scrollY > 24);
        };
        updateLandingNav();
        window.addEventListener('scroll', updateLandingNav, { passive: true });
    }
})();

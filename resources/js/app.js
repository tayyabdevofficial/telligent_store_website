document.querySelectorAll('[data-mobile-nav]').forEach((navRoot) => {
    const toggle = navRoot.querySelector('[data-mobile-nav-toggle]');
    const menu = navRoot.querySelector('[data-mobile-nav-menu]');

    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener('click', () => {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
        menu.classList.toggle('hidden', isOpen);
    });
});

document.querySelectorAll('[data-copy-link]').forEach((button) => {
    button.addEventListener('click', async () => {
        const value = button.getAttribute('data-copy-value');

        if (!value) {
            return;
        }

        try {
            await navigator.clipboard.writeText(value);

            const defaultLabel = button.getAttribute('data-copy-label-default') ?? 'Copy';
            const successLabel = button.getAttribute('data-copy-label-success') ?? 'Copied';

            button.textContent = successLabel;

            window.setTimeout(() => {
                button.textContent = defaultLabel;
            }, 1500);
        } catch {
            button.textContent = 'Copy failed';

            window.setTimeout(() => {
                button.textContent = button.getAttribute('data-copy-label-default') ?? 'Copy';
            }, 1500);
        }
    });
});

const removePaymentLinkModal = document.querySelector('[data-remove-payment-link-modal]');

if (removePaymentLinkModal) {
    const confirmButton = removePaymentLinkModal.querySelector('[data-remove-payment-link-confirm]');
    const cancelButton = removePaymentLinkModal.querySelector('[data-remove-payment-link-cancel]');
    let activeForm = null;

    const closeRemoveModal = () => {
        removePaymentLinkModal.classList.add('hidden');
        removePaymentLinkModal.classList.remove('flex');
        removePaymentLinkModal.setAttribute('aria-hidden', 'true');
        activeForm = null;
    };

    document.querySelectorAll('[data-remove-payment-link-trigger]').forEach((button) => {
        button.addEventListener('click', () => {
            activeForm = button.closest('[data-remove-payment-link-form]');

            if (!activeForm) {
                return;
            }

            removePaymentLinkModal.classList.remove('hidden');
            removePaymentLinkModal.classList.add('flex');
            removePaymentLinkModal.setAttribute('aria-hidden', 'false');
        });
    });

    cancelButton?.addEventListener('click', closeRemoveModal);

    removePaymentLinkModal.addEventListener('click', (event) => {
        if (event.target === removePaymentLinkModal) {
            closeRemoveModal();
        }
    });

    confirmButton?.addEventListener('click', () => {
        if (activeForm) {
            activeForm.submit();
        }
    });
}

document.querySelectorAll('[data-dashboard-recent-orders]').forEach((container) => {
    const url = container.getAttribute('data-dashboard-poll-url');
    const interval = Number(container.getAttribute('data-dashboard-poll-interval') ?? 5000);

    if (!url || interval <= 0) {
        return;
    }

    let isFetching = false;

    const refreshRecentOrders = async () => {
        if (isFetching || document.hidden) {
            return;
        }

        isFetching = true;

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin',
            });

            if (!response.ok) {
                return;
            }

            container.innerHTML = await response.text();
        } catch {
            // Ignore transient polling errors and retry on the next interval.
        } finally {
            isFetching = false;
        }
    };

    window.setInterval(refreshRecentOrders, interval);
});

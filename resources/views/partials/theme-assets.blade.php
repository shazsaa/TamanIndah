<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/css/storefront.css', 'resources/js/app.js'])

<div id="toast-container"></div>

<script>
// Scroll reveal
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Toast function — global
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = 'toast-item' + (type === 'accent' ? ' toast-accent' : '');
        toast.innerHTML = `<span>${type === 'success' ? '✓' : 'ℹ'}</span><span>${message}</span>`;
        container.appendChild(toast);
        requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.add('show')));
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 350);
        }, 3000);
    };

    // Auto-show Laravel session flash as toast
    const flashSuccess = document.getElementById('flash-success');
    const flashError = document.getElementById('flash-error');
    if (flashSuccess) showToast(flashSuccess.dataset.msg, 'success');
    if (flashError) showToast(flashError.dataset.msg, 'error');
});
</script>

<script>
(function() {
    const navbar = document.getElementById('storefront-navbar');
    if (!navbar) return;

    function updateNavbar() {
        if (window.scrollY > 60) {
            navbar.classList.add('nav-scrolled');
            navbar.classList.remove('nav-transparent');
        } else {
            navbar.classList.add('nav-transparent');
            navbar.classList.remove('nav-scrolled');
        }
    }

    updateNavbar();
    window.addEventListener('scroll', updateNavbar, { passive: true });
})();
</script>

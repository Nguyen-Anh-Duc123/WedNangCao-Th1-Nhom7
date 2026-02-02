(function () {
    function findProductImage(form) {
        var root = form.closest('.product-card, .product-image-wrapper, .product-details, .productinfo, .single-products, .news-card') || form.parentElement;
        if (!root) {
            return form.querySelector('img');
        }
        var img = root.querySelector('img');
        return img || form.querySelector('img');
    }

    function handleSubmit(event) {
        var form = event.currentTarget;
        var cartLink = document.querySelector('.cart-link');
        if (!cartLink) {
            return;
        }
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        var img = findProductImage(form);
        if (!img) {
            return;
        }

        var rect = img.getBoundingClientRect();
        var cartRect = cartLink.getBoundingClientRect();
        if (rect.width === 0 || rect.height === 0) {
            return;
        }

        event.preventDefault();

        var clone = img.cloneNode(true);
        clone.classList.add('fly-to-cart');
        clone.style.left = rect.left + 'px';
        clone.style.top = rect.top + 'px';
        clone.style.width = rect.width + 'px';
        clone.style.height = rect.height + 'px';
        document.body.appendChild(clone);

        requestAnimationFrame(function () {
            var dx = cartRect.left - rect.left + 8;
            var dy = cartRect.top - rect.top + 8;
            clone.style.transform = 'translate(' + dx + 'px,' + dy + 'px) scale(0.2)';
            clone.style.opacity = '0.2';
        });

        var badge = cartLink.querySelector('.cart-badge');
        if (badge) {
            var current = parseInt(badge.dataset.count || badge.textContent || '0', 10);
            var next = isNaN(current) ? 1 : current + 1;
            badge.dataset.count = String(next);
            badge.textContent = String(next);
        }

        setTimeout(function () {
            if (clone.parentNode) {
                clone.parentNode.removeChild(clone);
            }
            form.submit();
        }, 500);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var forms = document.querySelectorAll('form[action*="/save-cart"]');
        forms.forEach(function (form) {
            form.addEventListener('submit', handleSubmit);
        });
    });
})();

(function () {
    function clamp(value, min, max) {
        return Math.max(min, Math.min(max, value));
    }

    function getMax(input) {
        var max = parseInt(input.getAttribute('data-max') || '99', 10);
        return isNaN(max) ? 99 : max;
    }

    function updateValue(input, next) {
        var max = getMax(input);
        var clamped = clamp(next, 0, max);
        input.value = String(clamped);
        return clamped;
    }

    function handleClick(event) {
        var btn = event.target.closest('.qty-btn');
        if (!btn) {
            return;
        }
        var form = btn.closest('form');
        if (!form) {
            return;
        }
        var input = form.querySelector('.cart_quantity_input');
        if (!input) {
            return;
        }
        var current = parseInt(input.value || '0', 10);
        current = isNaN(current) ? 0 : current;
        var delta = btn.getAttribute('data-action') === 'plus' ? 1 : -1;
        var next = updateValue(input, current + delta);
        if (next < 0) {
            return;
        }
        form.submit();
    }

    function handleBlur(event) {
        var input = event.target;
        if (!input.classList.contains('cart_quantity_input')) {
            return;
        }
        var current = parseInt(input.value || '0', 10);
        current = isNaN(current) ? 0 : current;
        updateValue(input, current);
    }

    document.addEventListener('click', handleClick);
    document.addEventListener('blur', handleBlur, true);
})();

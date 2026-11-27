@php
    $initialToasts = [];

    if (session('success')) {
        $initialToasts[] = ['type' => 'success', 'message' => session('success')];
    }

    if (session('warning')) {
        $initialToasts[] = ['type' => 'warning', 'message' => session('warning')];
    }

    if (session('error')) {
        $initialToasts[] = ['type' => 'error', 'message' => session('error')];
    }
@endphp

<div id="flora-toast-container"
     class="fixed top-20 right-4 sm:right-6 z-50 flex flex-col gap-3 w-[calc(100vw-2rem)] max-w-sm pointer-events-none"
     aria-live="polite"
     aria-atomic="false">
</div>

<script>
    (function () {
        const container = document.getElementById('flora-toast-container');
        if (!container) return;

        const DURATION_MS = 5000;

        const icons = {
            success: 'fa-circle-check',
            warning: 'fa-triangle-exclamation',
            error: 'fa-circle-exclamation',
        };

        function createToast(message, type = 'success') {
            const safeType = icons[type] ? type : 'success';
            const toast = document.createElement('div');
            toast.className = `flora-toast flora-toast--${safeType} pointer-events-auto`;
            toast.setAttribute('role', safeType === 'error' ? 'alert' : 'status');

            toast.innerHTML = `
                <div class="flex items-start gap-3">
                    <span class="flora-toast-icon mt-0.5 shrink-0">
                        <i class="fa-solid ${icons[safeType]}"></i>
                    </span>
                    <p class="text-sm font-medium leading-snug flex-1"></p>
                    <button type="button"
                            class="flora-toast-close shrink-0 p-1 rounded-lg transition"
                            aria-label="Dismiss notification">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>
                <div class="flora-toast-progress">
                    <div class="flora-toast-progress-bar"></div>
                </div>
            `;

            toast.querySelector('p').textContent = message;

            const closeBtn = toast.querySelector('.flora-toast-close');
            const progressBar = toast.querySelector('.flora-toast-progress-bar');

            let remaining = DURATION_MS;
            let startTime = Date.now();
            let timerId = null;
            let dismissed = false;

            function dismiss() {
                if (dismissed) return;
                dismissed = true;
                clearTimeout(timerId);
                toast.classList.add('is-leaving');
                setTimeout(() => toast.remove(), 260);
            }

            function startTimer() {
                startTime = Date.now();
                progressBar.style.transition = `width ${remaining}ms linear`;
                requestAnimationFrame(() => {
                    progressBar.style.width = '0%';
                });
                timerId = setTimeout(dismiss, remaining);
            }

            function pauseTimer() {
                clearTimeout(timerId);
                remaining = Math.max(0, remaining - (Date.now() - startTime));
                const computedWidth = getComputedStyle(progressBar).width;
                progressBar.style.transition = 'none';
                progressBar.style.width = computedWidth;
            }

            closeBtn.addEventListener('click', dismiss);
            toast.addEventListener('mouseenter', pauseTimer);
            toast.addEventListener('mouseleave', () => {
                if (!dismissed) startTimer();
            });

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.add('is-visible');
                startTimer();
            });
        }

        window.FloraToast = {
            show: createToast,
        };

        const initial = @json($initialToasts);
        initial.forEach((item, index) => {
            setTimeout(() => createToast(item.message, item.type), index * 120);
        });
    })();
</script>

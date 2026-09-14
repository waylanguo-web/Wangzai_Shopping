(function () {
    var style = document.createElement('style');
    style.textContent =
        '.lw-btn-loading{pointer-events:none !important;opacity:.75;position:relative}' +
        '.lw-btn-loading::after{content:"";display:inline-block;width:1em;height:1em;margin-left:.5em;border:2px solid currentColor;border-right-color:transparent;border-radius:50%;vertical-align:middle;animation:lw-btn-spin .6s linear infinite}' +
        '@keyframes lw-btn-spin{to{transform:rotate(360deg)}}';
    document.head.appendChild(style);

    function init() {
        var lastClicked = null;

        document.addEventListener('click', function (e) {
            lastClicked = e.target.closest('[wire\\:click], [wire\\:submit], button, input[type="submit"]');
        }, true);

        Livewire.hook('commit', function (_ref) {
            var respond = _ref.respond;
            var el = lastClicked;
            if (!el || el.classList.contains('lw-btn-loading')) return;

            el.classList.add('lw-btn-loading');
            var timer = setTimeout(function () { el.classList.remove('lw-btn-loading'); }, 30000);

            respond(function () {
                clearTimeout(timer);
                el.classList.remove('lw-btn-loading');
            });
        });
    }

    if (typeof window.Livewire === 'undefined') {
        document.addEventListener('livewire:init', init);
    } else {
        init();
    }
})();
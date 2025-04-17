// Microsoft MVP Link Tracker: Append WT.mc_id to Microsoft links and log clicks
(function(){
    var mvpId = window.mvp_settings && window.mvp_settings.mvp_id ? window.mvp_settings.mvp_id : null;
    if (!mvpId) return;

    function appendTrackingIdToLinks() {
        var links = document.querySelectorAll('a[href*="microsoft.com"], a[href*="aka.ms"]');
        links.forEach(function(link) {
            var url = new URL(link.href, window.location.origin);
            if (!url.searchParams.has('WT.mc_id')) {
                url.searchParams.set('WT.mc_id', mvpId);
                link.href = url.toString();
            }
        });
    }

    function logClick(e) {
        var link = e.currentTarget;
        var url = link.href;
        if (window.mvp_ajax && window.mvp_ajax.ajax_url && window.mvp_ajax.nonce) {
            fetch(window.mvp_ajax.ajax_url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=mvp_log_click&url=' + encodeURIComponent(url) + '&nonce=' + encodeURIComponent(window.mvp_ajax.nonce)
            });
        }
    }

    function addClickListeners() {
        var links = document.querySelectorAll('a[href*="microsoft.com"], a[href*="aka.ms"]');
        links.forEach(function(link) {
            link.addEventListener('click', logClick);
        });
    }

    function init() {
        appendTrackingIdToLinks();
        addClickListeners();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

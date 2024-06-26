jQuery(document).ready(function($) {
    var options = page1NotifyOptions;
    var notificationHtml = `
        <div id="page1-notify" class="page1-notify">
            <div class="page1-notify-icon">🔔</div>
            <div class="page1-notify-content">
                <strong>${options.title}</strong>
                <p>${options.description}</p>
                <div class="page1-notify-verify">✔ Verified</div>
            </div>
        </div>
    `;

    var showNotification = function() {
        var maxDisplays = options.max_displays || 1;
        var displayCount = sessionStorage.getItem('page1_notify_display_count') || 0;

        if (displayCount < maxDisplays && !sessionStorage.getItem('page1_notify_clicked')) {
            $('body').append(notificationHtml);
            $('#page1-notify').fadeIn();
            displayCount++;
            sessionStorage.setItem('page1_notify_display_count', displayCount);
        }
    };

    if (options.time > 0) {
        setTimeout(showNotification, options.time * 1000);
    } else if (options.scroll > 0) {
        $(window).on('scroll', function() {
            if ($(window).scrollTop() / ($(document).height() - $(window).height()) * 100 >= options.scroll) {
                showNotification();
                $(window).off('scroll');
            }
        });
    }

    $(document).on('click', function(e) {
        if ($(e.target).closest('#page1-notify').length === 0 || e.target.id === 'page1-notify') {
            $('#page1-notify').fadeOut();
        }
    });

    $(document).on('click', '#page1-notify', function() {
        window.open(options.url, '_blank');
        sessionStorage.setItem('page1_notify_clicked', 'true');
        $('#page1-notify').fadeOut();
    });
});

// NOW TIMER
// ----------------------------------- 

(function (window, document, $, undefined) {

    $(function () {

        $('[data-now]').each(function () {
            var element = $(this),
                format = element.data('format');

            function updateTime() {
                var now = new Date();
                now = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds());

                var dt = moment(now).format(format);
                element.text(dt);
            }

            updateTime();
            setInterval(updateTime, 1000);

        });
    });

})(window, document, window.jQuery);

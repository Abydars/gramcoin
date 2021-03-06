/*!
 *
 * Angle - Bootstrap Admin App + jQuery
 *
 * Version: 3.5.3
 * Author: @themicon_co
 * Website: http://themicon.co
 * License: https://wrapbootstrap.com/help/licenses
 *
 */


(function (window, document, $, undefined) {

    if (typeof $ === 'undefined') {
        throw new Error('This application\'s JavaScript requires jQuery');
    }

    $(function () {

        // Restore body classes
        // -----------------------------------
        var $body = $('body');
        new StateToggler().restoreState($body);

        // enable settings toggle after restore
        $('#chk-fixed').prop('checked', $body.hasClass('layout-fixed'));
        $('#chk-collapsed').prop('checked', $body.hasClass('aside-collapsed'));
        $('#chk-collapsed-text').prop('checked', $body.hasClass('aside-collapsed-text'));
        $('#chk-boxed').prop('checked', $body.hasClass('layout-boxed'));
        $('#chk-float').prop('checked', $body.hasClass('aside-float'));
        $('#chk-hover').prop('checked', $body.hasClass('aside-hover'));

        // When ready display the offsidebar
        $('.offsidebar.hide').removeClass('hide');

        // Disable warning "Synchronous XMLHttpRequest on the main thread is deprecated.."
        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
            options.async = true;
        });

        // Copy button task
        $('button[data-copy-text]').on('click', function (e) {
            $target = $($(this).data('copy-text'));
            $target.select();

            try {
                document.execCommand('copy');
            } catch (e) {
                console.log('failed to copy');
            }
        });

        $('.datetimepicker').datetimepicker({
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-crosshairs',
                clear: 'fa fa-trash'
            },
            format: "YYYY-MM-DD H:m"
        });

        $("a[href='#aside_navbar_support']").on('click', function (e) {
            e.preventDefault();

            var name = $(this).data('name');
            var email = $(this).data('email');
            var nonce = $(this).data('nonce');

            var $form = $('<form action="http://gramcoin.net/support/?page=sign-in&redirect_to=http%3A%2F%2Fgramcoin.net%2Fsupport%2F" method="POST" />');
            var $inputs = [
                {name: 'name', value: name},
                {name: 'email', value: email},
                {name: 'action', value: 'wpsp_guest_signin'},
                {name: 'nonce', value: nonce}
            ];

            for (var i in $inputs) {
                $form.append('<input name="' + $inputs[i].name + '" value="' + $inputs[i].value + '" type="hidden" />');
            }

            $("body").append($form);
            $form.submit();
        });
    })
    ; // doc ready

})(window, document, window.jQuery);
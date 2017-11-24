(function(window, document, $, undefined) {
    $(function() {

        if(typeof window.byuapp != "undefined") {
            window.byuapp.formatMoneyWithCurrency = function (n, c) {
                try {
                    n = parseFloat(n);
                    return c + n.toFixed(2).replace(/./g, function(c, i, a) {
                        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                    });
                } catch (e) {
                    console.log(e);
                    return c+'0';
                }
            };

            window.byuapp.formatMoneyWithoutCurrency = function (n) {
                try {
                    n = parseFloat(n);
                    return n.toFixed(2).replace(/./g, function(c, i, a) {
                        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                    });
                } catch (e) {
                    console.log(e);
                    return '0';
                }
            };

            window.byuapp.formatMoney = function (n) {
                var currency = this.currency;
                /*
                 var money = new Number(money);
                 var ret = currency.symbol + money.toFixed(currency.decimal_digits);
                 return ret;
                 */
                return this.formatMoneyWithCurrency(n, currency.symbol);
            };

            window.byuapp.addNotification = function(d) {
                $.ajax({
                    url: window.byuapp.url + "notifications/data/?notification_id=" + d.notification_id,
                    success: function(data) {
                        console.log(data);

                        $menu = $(".notification-menu");
                        $not_exists = true;

                        $counter = parseInt($("#notification-counter").text());

                        if(isNaN($counter))
                            $counter = 0;

                        if(data.length > 0)
                            $not_exists = $menu.find('.list-group').find('.list-group-item[data-id="'+data[0].notification_id+'"]').length <= 0;

                        if($not_exists) {
                            $item = '<a href="' + data[0].link + '" class="list-group-item active" data-id="' + data[0].notification_id + '">'
                                + '<div class="media-box">'
                                + '<div class="pull-left">'
                                + '<em class="fa fa-' + data[0].content.icon + ' fa-2x text-info"></em>'
                                + '</div>'
                                + '<div class="media-box-body clearfix">'
                                + '<p class="m0">' + data[0].content.title + '</p>'
                                + '<p class="m0 text-muted">'
                                + '<small>' + data[0].content.text + '</small>'
                                + '</p>'
                                + '</div>'
                                + '</div>'
                                + '</a>';

                            $counter++;

                            $("#notification-counter").text($counter);
                            $("#notification-counter").attr('data-count', $counter);

                            $menu.find('.list-group').prepend($item);
                        }

                        if($counter > 0)
                            $("#notification-counter").fadeIn();
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            };

            $("#btn-notification-menu").on("click", function(e) {
                $("#notification-counter").text(0);
                $("#notification-counter").attr('data-count', 0);

                $.ajax({
                    url: window.byuapp.url + "notifications/mark_read",
                    type: "GET",
                    success: function(d) {
                        console.log(d);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            });

        }
    });
})(window, document, window.jQuery);
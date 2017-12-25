(function (window, document, $, undefined) {
    $(function () {

        if (typeof window.grm != "undefined") {
            window.grm.formatMoneyWithCurrency = function (n, c) {
                try {
                    n = parseFloat(n);
                    return c + n.toFixed(2).replace(/./g, function (c, i, a) {
                            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                        });
                } catch (e) {
                    console.log(e);
                    return c + '0';
                }
            };

            window.grm.formatMoneyWithoutCurrency = function (n) {
                try {
                    n = parseFloat(n);
                    return n.toFixed(2).replace(/./g, function (c, i, a) {
                        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                    });
                } catch (e) {
                    console.log(e);
                    return '0';
                }
            };

            window.grm.formatMoney = function (n) {
                var currency = this.currency;
                /*
                 var money = new Number(money);
                 var ret = currency.symbol + money.toFixed(currency.decimal_digits);
                 return ret;
                 */
                return this.formatMoneyWithCurrency(n, currency.symbol);
            };

            window.grm.daysBetween = function (date1, date2) {
                //Get 1 day in milliseconds
                var one_day = 1000 * 60 * 60 * 24;

                // Convert both dates to milliseconds
                var date1_ms = date1.getTime();
                var date2_ms = date2.getTime();

                // Calculate the difference in milliseconds
                var difference_ms = date2_ms - date1_ms;
                //take out milliseconds
                difference_ms = difference_ms / 1000;
                var seconds = Math.floor(difference_ms % 60);
                difference_ms = difference_ms / 60;
                var minutes = Math.floor(difference_ms % 60);
                difference_ms = difference_ms / 60;
                var hours = Math.floor(difference_ms % 24);
                var days = Math.floor(difference_ms / 24);

                return {
                    days: days,
                    hours: hours,
                    minutes: minutes,
                    seconds: seconds
                };
                //return days + ' days, ' + hours + ' hours, ' + minutes + ' minutes, and ' + seconds + ' seconds';
            }
        }
    });
})(window, document, window.jQuery);
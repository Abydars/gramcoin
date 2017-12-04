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
        }
    });
})(window, document, window.jQuery);
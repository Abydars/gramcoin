jQuery(function ($) {

    $('.referral-table > table > tbody > tr.ref > td').on('click', function () {
        $(this).parent().next().children('td').children('.referral-table').slideToggle();
        $(this).parent().toggleClass('open');
    });

});
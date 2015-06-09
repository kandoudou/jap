$(function() {
    function ratingEnable() {
        $('#example-a').barrating();

        $('#example-b').barrating('show', {
            wrapperClass: 'br-wrapper-b',
            //readonly: true
        });

        $('#example-b').barrating('set', 'Mediocre');

        $('#example-c').barrating('show', {
            wrapperClass: 'br-wrapper-c',
            showValues: true,
            showSelectedRating: false
        });

        $('#example-d').barrating('show', {
            wrapperClass: 'br-wrapper-d',
            showValues: true,
            showSelectedRating: false
        });

        $('.example_result').barrating({
            wrapperClass: 'br-wrapper',
            showValues: false,
            showSelectedRating: false,
            readonly: true
        });

        $('#example1').barrating({
            wrapperClass: 'br-wrapper',
            showSelectedRating: false
        });

        $('#example2').barrating('show', {
            wrapperClass: 'br-wrapper',
            showSelectedRating: false
        });

        $('#example-h').barrating('show', {
            wrapperClass: 'br-wrapper-h',
            reverse: true
        });
    }

    function ratingDisable() {
        $('select').barrating('destroy');
    }

    $('.rating-enable').click(function(event) {
        event.preventDefault();

        ratingEnable();

        $(this).addClass('deactivated');
        $('.rating-disable').removeClass('deactivated');
    });

    $('.rating-disable').click(function(event) {
        event.preventDefault();

        ratingDisable();

        $(this).addClass('deactivated');
        $('.rating-enable').removeClass('deactivated');
    });

    ratingEnable();
});

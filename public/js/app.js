jQuery(document).ready(function ($) {
    $(document).on('click', '.more-products__link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        const $container = $('.products');
        const w = parseFloat($container.css('width'));
        const imgSrc = '/public/img/loading.gif';

        $.ajax({
            url: "/catalog?page=" + page,
            beforeSend: function (xhr) {
                $container.append('<div id="ajaxblock" style="width:' + w + 'px;height:30px;margin-top:20px;text-align:center;border:none !important;"><img src="' + imgSrc + '" /></div>');
            }
        })
            .done(function (html) {
                $('#ajaxblock').remove();
                const $html = $(html);
                const products = $html.find('.products').html();
                $container.append(products);
                $container.parent().find('.more-products').html($html.find('.more-products').html());
            });
    });

    $(".validate").validate();

});

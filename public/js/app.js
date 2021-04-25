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

    $('.addToCart').click(function(e) {
        e.preventDefault();
        const product_id = $(this).data('id');
        const quantity = 1;

        $.ajax({
            type: "POST",
            url: "checkout/cartAdd",
            data: { product_id: product_id, quantity: quantity },
            dataType: "json"
        }).done(function(json) {
            if (json['success']) {
                const $modal = $('.addToCartModal');

                $modal.find('.modal-title').html('Товар успешно добавлен в корзину');

                $modal.modal('show');

                let headerCart = '<a class="cart__link" href="/cart">Корзина (' + json['count'] + ')</a>';

                if (json['products']) {
                    headerCart += '<div class="cart-content">';
                    headerCart += '<table><tbody>';
                    for (const key in json['products']) {
                        if (Object.hasOwnProperty.call(json['products'], key)) {
                            const product = json['products'][key];
                            headerCart += '<tr>';
                            headerCart += '<td><img src="img/' + product.image + '" alt="' + product.name + '" width="24"></td>';
                            headerCart += '<td><a class="cart__link" href="/product.php?product_id=' + product.product_id + '">' + product.name + '</a></td>';
                            headerCart += '<td class="price">' + formatPrice(product.price) + '</td>';
                            headerCart += '<td>' + product.quantity + '</td>';
                            headerCart += '<td class="price">' + formatPrice(product.total) + '</td>';
                            headerCart += '</tr>';
                        }
                    }
                    headerCart += '</tbody><tfoot>';
                    headerCart += '<tr><td colspan="3">Итого</td><td>' + json.count + '</td><td class="price">' + formatPrice(json.total) + '</td></tr>';
                    headerCart += '</tfoot></table>';

                    headerCart += '<div class="order-button"><a class="btn btn-primary" href="/checkout">Оформить заказ</a></div>';

                    headerCart += '</div>';
                }

                $('.header-cart').html(headerCart);

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }
        });
    });
});

function formatPrice(price) {
    return summStr = Math.round(price).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1 ");
}


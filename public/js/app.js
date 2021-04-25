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
            url: "cart/cartAdd",
            data: { product_id: product_id, quantity: quantity },
            dataType: "json"
        }).done(function(json) {
            if (json['success']) {
                const $modal = $('.addToCartModal');

                $modal.find('.modal-title').html('Товар успешно добавлен в корзину');

                $modal.modal('show');

                $('.header-cart .cart__link').html('Корзина (' + json['count'] + ')');

                let headerCart = '';

                if (json['products']) {
                    headerCart += '<table><tbody>';
                    for (const key in json['products']) {
                        if (Object.hasOwnProperty.call(json['products'], key)) {
                            const product = json['products'][key];
                            headerCart += '<tr>';
                            headerCart += '<td><img src="img/' + product.image + '" alt="' + product.name + '" width="24"></td>';
                            headerCart += '<td><a class="cart__link" href="/product.php?product_id=' + product.product_id + '">' + product.name + '</a></td>';
                            headerCart += '<td class="price">' + product.price + '</td>';
                            headerCart += '<td>' + product.quantity + '</td>';
                            headerCart += '<td class="price">' + product.total + '</td>';
                            headerCart += '</tr>';
                        }
                    }
                    headerCart += '</tbody><tfoot>';
                    headerCart += '<tr><td colspan="3">Итого</td><td>' + json.count + '</td><td class="price">' + json.total + '</td></tr>';
                    headerCart += '</tfoot></table>';
                }

                $('.header-cart').find('table').replaceWith(headerCart);

                $('html, body').animate({ scrollTop: 0 }, 'slow');
            }
        });
    });

    function changeQuantity(product_id, quantity) {
        const $container = $('body').find('.cart-section');
        const w = parseFloat($container.css('width'));
        const imgSrc = '/public/img/loading.gif';
        $.ajax({
            url: "/checkout/changeQuantity?product_id=" + product_id+"&quantity=" + quantity,
            beforeSend: function (xhr) {
                $container.css({opacity:0.5});
            }
        })
            .done(function (html) {
                $container.css({opacity:1});
                const $html = $(html);
                const cartSection = $html.find('.cart-section').html();
                $container.replaceWith('<div class="cart-section">'+cartSection+'</div>');
            });
    }

    $(document).on('click', '.quantity-btn', function (e) {
        e.preventDefault();
        const $quantity = $(this).closest('.quantity');
        const product_id = $quantity.data('id');

        let action = 'minus';

        if ($(this).hasClass('plus')) {
            action = 'plus';
        }

        const quantity = parseInt($quantity.find('.quantity-value').val());

        let newQuantity = quantity;

        if (action === 'plus') {
            newQuantity++;
        } else
        if (action === 'minus' && quantity > 1) {
            newQuantity--;
        }

        if (newQuantity !== quantity) {
            changeQuantity(product_id, newQuantity);
        }
    });

    $('.quantity-value').blur(function(e) {
        const $quantity = $(this).closest('.quantity');
        const product_id = $quantity.data('id');

        const quantity = parseInt($quantity.find('.quantity-value').val());

        if (quantity > 0) {
            changeQuantity(product_id, quantity);
        }
    });
});

function formatPrice(price) {
    return summStr = Math.round(price).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1 ");
}


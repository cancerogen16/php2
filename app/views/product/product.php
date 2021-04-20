<?php if (empty($product_info)) : ?>
    <p>Нет товара в базе данных</p>
<?php else : ?>
    <h1>
        <?= $product_info['name'] ?>
    </h1>
    <div class="product-section">
        <div class="product-image">
            <?php if (empty($product_info['image'])) : ?>
                <p>Нет изображения в базе данных</p>
            <?php else : ?>
                <img class="full-image" src="/public/img/<?= $product_info['thumb'] ?>" alt="<?= $product_info['name'] ?>">
            <?php endif; ?>
        </div>
        <div class="product-description">
            <div class="description-item">Наименование:
                <?= $product_info['name'] ?>
            </div>
            <div class="description-item">Количество:
                <?= $product_info['quantity'] ?>
            </div>
            <div class="description-item">Цена:
                <?= number_format((float)$product_info['price'], 0, ',', ' ') ?>
            </div>
            <div class="description-item">Число просмотров:
                <?= $product_info['views'] ?>
            </div>
            <div class="product-cart">
                <a class="btn addToCart" data-id="<?= $product_info['product_id'] ?>"
                   href="product.php?addToCart=1&product_id=<?= $product_info['product_id'] ?>"
                   title="Добавить товар в корзину">Добавить в корзину</a>
            </div>
        </div>
    </div>
<?php endif; ?>
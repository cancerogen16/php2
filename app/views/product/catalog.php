<h1><?php echo (!empty($title)) ? $title : ''; ?></h1>

<div class="products">
    <?php if (!empty($products)) : ?>
        <?php foreach ($products as $product) : ?>
            <div class="product">
                <div class="product__image">
                    <a class="image__link" href="/product?product_id=<?= $product['product_id'] ?>" title="<?= $product['name'] ?>">
                        <img class="image" src="/public/img/<?= $product['thumb'] ?>" alt="<?= $product['name'] ?>" width="250">
                    </a>
                </div>
                <div class="product__info">
                    <h3>
                        <a class="product__link" href="/product?product_id=<?= $product['product_id'] ?>" title="<?= $product['name'] ?>">
                            <?= $product['name'] ?>
                        </a>
                    </h3>
                    <div class="price">
                        <?= $product['price'] ?>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    <?php else : ?>
        <p>Нет товаров в каталоге</p>
    <?php endif; ?>
</div>
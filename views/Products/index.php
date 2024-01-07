<h1>Products</h1>

<a href="/products/new">New Product</a>

<p>Total: <?= $total ?></p>

<?php foreach ($products as $product) { ?>
    <h2>
        <a href="/products/<?= $product['id'] ?>/show">
            <?= htmlspecialchars($product['name']) ?>
        </a>
    </h2>
<?php } ?>

</body>
</html>

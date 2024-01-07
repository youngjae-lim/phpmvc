<h1>Delete Product</h1>

<h2><?= htmlspecialchars($product['name']) ?></h2>
<p><?= htmlspecialchars($product['description']) ?></p>

<form method="POST" action="/products/<?= $product['id'] ?>/destroy">
    <p>Delete this product?</p>
    <button>Yes</button>
</form>

<p><a href="/products/<?= $product['id'] ?>/show">Cancel</a></p>

</body>
</html>

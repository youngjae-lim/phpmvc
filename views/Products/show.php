<p><a href="/products">Back to products</a></p>
<h1><?= htmlspecialchars($product['name']) ?></h1>
<p><?= htmlspecialchars($product['description']) ?></p>
<p>
    <a href="/products/<?= $product['id'] ?>/edit">Edit</a>
</p>
<p>
    <a href="/products/<?= $product['id'] ?>/delete">Delete</a>
</p>

</body>
</html>

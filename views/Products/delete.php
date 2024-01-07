<h1>Edit Product</h1>


<form method="POST" action="/products/<?= $product['id'] ?>/delete">
    <p>Delete this product?</p>
    <button>Yes</button>
</form>

<p><a href="/products/<?= $product['id'] ?>/show">Cancel</a></p>

</body>
</html>

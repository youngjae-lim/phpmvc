<h1>Edit Product</h1>

<p><a href="/products/<?= $product['id'] ?>/show">Cancel</a></p>

<form method="POST" action="/products/<?= $product['id'] ?>/update">
<?php require 'form.php' ?>
</form>

</body>
</html>

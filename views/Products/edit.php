<h1>Edit Product</h1>


<form method="POST" action="/products/<?= $product['id'] ?>/update">
<?php require 'form.php' ?>
</form>

<p><a href="/products/<?= $product['id'] ?>/show">Cancel</a></p>

</body>
</html>

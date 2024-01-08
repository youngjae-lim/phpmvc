<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="/css/style.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
<title>{{ title }}</title>
</head>
<body>
<h1>Products</h1>

<a href="/products/new">New Product</a>

<p>Total: {{ total }} </p>

<?php foreach ($products as $product) { ?>
    <h2>
        <a href="/products/{{ product['id'] }}/show">
            {{ product['name'] }}
        </a>
    </h2>
<?php } ?>

</body>
</html>

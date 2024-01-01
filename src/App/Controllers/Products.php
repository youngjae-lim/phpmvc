<?php

namespace App\Controllers;

use App\Models\Product;

class Products
{
    public function index()
    {
        $model = new Product;

        $products = $model->getData();

        require_once '../views/products_index.php';
    }

    public function show(string $id)
    {
        echo "ID: $id<br>";
        require_once '../views/products_show.php';
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo "Title: $title<br>";
        echo "ID: $id<br>";
        echo "Page: $page<br>";
    }
}

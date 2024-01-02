<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function index()
    {
        $model = new Product;

        $products = $model->getData();

        $viewer = new Viewer;

        echo $viewer->render('shared/header.php', [
            'title' => 'Products',
        ]);

        echo $viewer->render('Products/index.php', [
            'products' => $products,
        ]);

    }

    public function show(string $id)
    {
        $viewer = new Viewer;

        echo $viewer->render('shared/header.php', [
            'title' => "Product {$id}",
        ]);

        echo $viewer->render('Products/show.php', [
            'id' => $id,
        ]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo "Title: $title<br>";
        echo "ID: $id<br>";
        echo "Page: $page<br>";
    }
}

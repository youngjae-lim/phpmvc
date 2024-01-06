<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function __construct(private Viewer $viewer, private Product $model)
    {
    }

    public function index()
    {
        $products = $this->model->getData();

        echo $this->viewer->render('shared/header.php', [
            'title' => 'Products',
        ]);

        echo $this->viewer->render('Products/index.php', [
            'products' => $products,
        ]);

    }

    public function show(string $id)
    {
        $product = $this->model->find($id);

        echo $this->viewer->render('shared/header.php', [
            'title' => "Product {$id}",
        ]);

        echo $this->viewer->render('Products/show.php', [
            'product' => $product,
        ]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo "Title: $title<br>";
        echo "ID: $id<br>";
        echo "Page: $page<br>";
    }
}

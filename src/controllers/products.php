<?php

class Products
{
    public function index()
    {
        require_once '../src/models/product.php';

        $model = new Product;

        $products = $model->getData();

        require_once '../views/products_index.php';
    }

    public function show()
    {
        require_once '../views/products_show.php';
    }
}

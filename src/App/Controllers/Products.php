<?php

// Must be at the top of the file. This will enable strict typing mode.
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Controller;
use Framework\Exceptions\PageNotFoundException;
use Framework\Response;

class Products extends Controller
{
    public function __construct(private Product $model)
    {
    }

    private function getProduct(string $id): array
    {
        $product = $this->model->find($id);

        if (! $product) {
            throw new PageNotFoundException('Product not found');
        }

        return $product;
    }

    public function index(): Response
    {
        $products = $this->model->findAll();

        return $this->view('Products/index.mvc.php', [
            'products' => $products,
            'total' => $this->model->getTotal(),
        ]);
    }

    public function show(string $id): Response
    {
        $product = $this->getProduct($id);

        return $this->view('Products/show.mvc.php', [
            'product' => $product,
        ]);
    }

    public function edit(string $id): Response
    {
        $product = $this->getProduct($id);

        return $this->view('Products/edit.mvc.php', [
            'product' => $product,
        ]);
    }

    public function new(): Response
    {
        return $this->view('Products/new.mvc.php');
    }

    public function create(): Response
    {
        $data = [
            'name' => $this->request->post['name'],
            'description' => empty($this->request->post['description']) ? null : $this->request->post['description'],
        ];

        if ($this->model->insert($data)) {
            return $this->redirect("/products/{$this->model->getInsertID()}/show");
        } else {
            return $this->view('Products/new.mvc.php', [
                'product' => $data,
                'errors' => $this->model->getErrors(),
            ]);
        }

    }

    public function update(string $id): Response
    {
        $product = $this->getProduct($id);

        // Overwrite the name and description with the new values.
        $product['name'] = $this->request->post['name'];
        $product['description'] = empty($this->request->post['description']) ? null : $this->request->post['description'];

        if ($this->model->update($id, $product)) {
            return $this->redirect("/products/{$id}/show");
        } else {
            return $this->view('Products/edit.mvc.php', [
                'product' => $product,
                'errors' => $this->model->getErrors(),
            ]);
        }
    }

    public function delete(string $id): Response
    {
        $product = $this->getProduct($id);

        return $this->view('Products/delete.mvc.php', [
            'product' => $product,
        ]);
    }

    public function destroy(string $id): Response
    {
        $this->getProduct($id);

        $this->model->delete($id);

        return $this->redirect('/products/index');
    }
}

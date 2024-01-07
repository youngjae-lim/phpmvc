<h1>New Product</h1>

<form method="POST" action="/products/create">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">

    <?php if (isset($errors['name'])) { ?>
        <p style="color:red;"><?= $errors['name'] ?></p>
    <?php } ?>

    <label for="descirption">Description</label>
    <textarea name="description" id="description"></textarea>

    <button>Save</button>
</form>

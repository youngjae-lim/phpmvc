<label for="name">Name</label>
<input type="text" name="name" id="name" value="<?= $product['name'] ?? '' ?>">

<?php if (isset($errors['name'])) { ?>
    <p style="color:red;"><?= $errors['name'] ?></p>
<?php } ?>

<label for="descirption">Description</label>
<textarea name="description" id="description"><?= $product['description'] ?? '' ?></textarea>

<button>Save</button>

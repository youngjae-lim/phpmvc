{% extends "base.mvc.php" %}

{% block title %}New Product{% endblock %}

{% block body %}
    <h1>New Product</h1>

    <form method="POST" action="/products/create">
    <?php require '../views/Products/form.php' ?>
    </form>
{% endblock %}


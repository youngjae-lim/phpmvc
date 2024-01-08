{% extends "base.mvc.php" %}

{% block title %}Delete Product{% endblock %}

{% block body %}
    <h1>Delete Product</h1>

    <h2>{{ product['name'] }}</h2>
    <p>{{ product['description'] }}</p>

    <form method="POST" action="/products/{{ product['id'] }}/destroy">
        <p>Delete this product?</p>
        <button>Yes</button>
    </form>

    <p><a href="/products/{{ product['id'] }}/show">Cancel</a></p>

{% endblock %}

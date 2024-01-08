{% extends "base.mvc.php" %}

{% block title %}Product{% endblock %}

{% block body %}
    <p><a href="/products">Back to products</a></p>
    <h1>{{ product['name'] }}</h1>
    <p>{{ product['description'] }}</p>
    <p>
        <a href="/products/{{ product['id'] }}/edit">Edit</a>
    </p>
    <p>
        <a href="/products/{{ product['id'] }}/delete">Delete</a>
    </p>
{% endblock %}


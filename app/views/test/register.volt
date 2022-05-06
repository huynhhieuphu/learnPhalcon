{% extends 'layouts/layout.volt' %}

{% block content %}
<div class="row">
    <div class="col-md-4 offset-md-4">
        <h1 class="text-center">Register</h1>
        <form action="/test/add" method="POST" class="border p-4">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" id="btnSignIn">Add</button>
            <a href="/test/index">Sign in</a>
        </form>
    </div>
</div>
{% endblock %}


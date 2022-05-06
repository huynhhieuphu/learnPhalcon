{% extends 'layouts/layout.volt' %}

{% block content %}
<div class="row">
    <div class="col-md-4 offset-md-4">
        <h1 class="text-center">Sign in</h1>
        <form action="/test/login" method="POST" class="border p-4">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
                <span class="text-danger" id="errUsername"></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" id="btnSignIn">Sign in</button>
            <a href="/test/register">Register</a>
        </form>
    </div>
</div>
{% endblock %}

{% block script %}
    <script>
        $(document).ready(function(){
            $('#btnSignIn').on('click', function(e){
                let username = $('#username').val().trim();
                let password = $('#password').val().trim();

                let flagUsername = true;

                if(username == '' || username == null){
                    $('#errUsername').text( 'Vui long khong de trong');
                    flag = false;
                }else if(username.length < 3){
                    $('#errUsername').text('Do dai toi thieu 3 ky tu');
                    flag = false;
                }else if(username.length > 60){
                    $('#errUsername').text('Do dai toi da 60 ky tu');
                    flag = false;
                }

                if(flag){
                    $('#errUsername').text('');
                    $('#btnSignIn').submit();
                }else{
                    e.preventDefault();
                }
            });
        });
    </script>
{% endblock %}
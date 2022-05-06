<!DOCTYPE html>
<html>
<head>
    <?= $this->partial('partials/header_view') ?>
</head>
<body>
<div class="container-fluid">
    
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

</div>

<?= $this->partial('partials/fooder_view') ?>

<!-- jQuery first, then Popper.js, and then Bootstrap's JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

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

</body>
</html>

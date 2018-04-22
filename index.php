<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Тестовое задание для компании InsVisions">
    <meta name="author" content="Леонид Марков">

    <title>Тестовое задание для компании InsVisions</title>

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
</head>

<body class="text-center">
<div class="container">
    <div class="row m-auto">
        <form action="check.php" method="POST" class="form-signin">
            <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Укажите URL сайта</h1>
            <label for="inputText" class="sr-only">What you search</label>
            <input type="text" id="inputText" name="URL" class="form-control" placeholder="https://yandex.ru" required autofocus>

            <br>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Проверить</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2018 Леонид Марков</p>
        </form>
    </div>
</div>


</body>
</html>
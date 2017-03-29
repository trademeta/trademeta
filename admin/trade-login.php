<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/model/Trademeta.php');
session_start();

$trade = Trademeta::Instance();

if (isset($_POST['login']) && !empty($_POST['login'])) {

    if ($trade->Login($_POST['login'], $_POST['pass']) && $_SESSION['captcha'] == $_POST['captcha']) {
        $_SESSION['auth'] = true;
        header('Location: admin.php');
        exit();
    }

} ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>trade-meta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="wrap col-md-10">
        <form role="form" method="post">
            <div class="form-group">
                <label for="login" class="col-xs-2">Login</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Введите Login">
            </div>
            <div class="form-group">
                <label for="pass" class="col-xs-2">Пароль</label>
                <input type="password" class="form-control" id="pass" name="pass" placeholder="Пароль">
            </div>
            <div class="form-group">
                <label for="captcha" class="col-xs-2">Капча</label>
                <div class="captcha"><img src="captcha.php" alt=""></div>
                <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Капча">
            </div>
            <button type="submit" class="btn btn-success">Войти</button>
        </form>
    </div>
</body>
</html>

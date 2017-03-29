<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('Location: trade-login.php');
    exit();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/model/MSQL.php');

if ($_POST['title']) {
    $msql = MSQL::Instance();

    $insert = array();
    $insert['title'] = $_POST['title'];
    if (isset($_POST['description'])) {
        $insert['description'] = $_POST['description'];
    }
    if (isset($_POST['li'])) {
        $insert['li'] = _encode($_POST['li']);
    }
    if (isset($_POST['m_text']) && !empty($_POST['m_text'][0])) {
        $insert['m_text'] = _encode($_POST['m_text']);
    }
    if (isset($_POST['m_img']) && !empty($_POST['m_img'][0])) {
        $insert['m_img'] = _encode($_POST['m_img']);
    }
    if (isset($_POST['link'])) {
        $insert['link'] = $_POST['link'];
    }
    if (isset($_POST['image'])) {
        $insert['image'] = $_POST['image'];
    }
    if (isset($_POST['github'])) {
        $insert['github'] = $_POST['github'];
    }

    $id = $msql->Insert('works', $insert);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>trade-meta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
</head>
<body>

<!--head: Start-->
<div class="head">
    <header class="header">
        <div class="wrap">
            <div class="buttons">
                <a href="/" class="btn btn-default" target="_blank">trade-meta.ru</a>
                <a href="admin.php" class="btn btn-default">Портфолио</a>
            </div>
            <h1>Добавление новой работы</h1>
        </div>
    </header>
</div>
<!--head: End-->

<div class="wrap">
    <!--Message-->
    <?php if($id): ?>
        <div class="col-xs-5 alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3>Успешно добавлено!</h3>
        </div>
    <?php endif; ?>

    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="title" id="title" placeholder="Title">
            </div>
        </div>
        <div class="form-group">
            <label for="desc" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="description" id="desc" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="wrapper">
                <div class="col-sm-1">
                    <button type="button" class="add-item" data-btn="li">+</button>
                </div>
                <div class="col-sm-2">
                    <label class="control-label">li</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control li" name="li[]">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="wrapper">
                <div class="col-sm-1">
                    <button type="button" class="add-item" data-btn="p">+</button>
                </div>
                <div class="col-sm-2">
                    <label class="control-label">more p</label>
                </div>
                <div class="col-sm-9">
                    <textarea class="form-control m_text" name="m_text[]"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="wrapper">
                <div class="col-sm-1">
                    <button type="button" class="add-item" data-btn="img">+</button>
                </div>
                <div class="col-sm-2">
                    <label class="control-label">more img</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control m_img" name="m_img[]">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="link" class="col-sm-3 control-label">link</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="link" id="link" placeholder="link">
            </div>
        </div>
        <div class="form-group">
            <label for="image" class="col-sm-3 control-label">image</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="image" id="image" placeholder="image">
            </div>
        </div>
        <div class="form-group">
            <label for="github" class="col-sm-3 control-label">github</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="github" id="github" placeholder="github">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-success">Добавить</button>
            </div>
        </div>
    </form>
</div>


<!--footer: Start-->
<div class="footer-block">
    <div class="wrap">
        <footer>
            <p>© 2017 Trade-meta.<span>Создание сайтов. Вёрстка сайтов</span></p>
            <p><a href="skype:trademeta">Skype: trademeta</a></p>
            <p><a href="mailto:trade-meta@mail.ru">E-mail: trade-meta@mail.ru</a></p>
            <div class="trademeta"><span>Trade-meta</span></div>
        </footer>
    </div>
</div>
<!--footer: End-->


<script src="js/jquery-2.2.2.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>
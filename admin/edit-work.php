<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('Location: trade-login.php');
    exit();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/model/MSQL.php');

$msql = MSQL::Instance();

$id = $_GET['id'];
$query = "select * from works where `id`=".$id;
$work = $msql->Select($query)[0];

if (count($work)) {
    function wrapElement($array, $data) {
        $inputName = array(
            'li'  => 'li[]',
            'p'   => 'm_text[]',
            'img' => 'm_img[]'
        );
        $name = $inputName[$data];
        $i = 0; $ar = '';
        $btn = 'add-item';

        do {
            if (isset($array[$i]) && !empty($array[$i])) {
                $ar = htmlspecialchars($array[$i], ENT_QUOTES);
            }
            if($i > 0){ $btn = "delete-item";} ?>
            <div class="wrapper">
                <div class="col-sm-1">
                    <button type="button" class="<?= $btn ?>" data-btn="<?= $data ?>"><?php echo ($i > 0)? '-': '+'; ?></button>
                </div>
                <div class="col-sm-2">
                    <label class="control-label"><?= $data ?></label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $ar ?>" name="<?= $name ?>">
                </div>
            </div>
            <?php $i++;
        } while ($i < count($array));
    }
}

if ($_POST['title']) {
    $msql = MSQL::Instance();

    $update = array();
    $update['title'] = $_POST['title'];
    if (isset($_POST['description'])) {
        $update['description'] = $_POST['description'];
    }
    if (isset($_POST['li'])) {
        $update['li'] = _encode($_POST['li']);
    }
    if (isset($_POST['m_text']) && !empty($_POST['m_text'][0])) {
        $update['m_text'] = _encode($_POST['m_text']);
    }
    if (isset($_POST['m_img']) && !empty($_POST['m_img'][0])) {
        $update['m_img'] = _encode($_POST['m_img']);
    }
    if (isset($_POST['link'])) {
        $update['link'] = $_POST['link'];
    }
    if (isset($_POST['image'])) {
        $update['image'] = $_POST['image'];
    }
    if (isset($_POST['github'])) {
        $update['github'] = $_POST['github'];
    }
    $where = sprintf("id='%s'", $msql->getMsql()->real_escape_string($_POST['id']));

    $cols = $msql->Update('works', $update, $where);
}

/*
 * Проверить и сформировать переменные,
 *  содержащие либо уже отредактированные данные для сохранения в бд после нажатия на "Обновить",
 *  либо только пришедшие данные работы для редактирования
*/
$title = (isset($_POST['title']))? $_POST['title'] : $work['title'];
$desc = (isset($_POST['description']))? $_POST['description'] : $work['description'];
$li = (isset($_POST['li']))? $_POST['li'] : _decode($work['li']);
$m_text = (isset($_POST['m_text']))? $_POST['m_text'] : _decode($work['m_text']);
$m_img = (isset($_POST['m_img']))? $_POST['m_img'] : _decode($work['m_img']);
$link = (isset($_POST['link']))? $_POST['link'] : $work['link'];
$image = (isset($_POST['image']))? $_POST['image'] : $work['image'];
$github = (isset($_POST['github']))? $_POST['github'] : $work['github'];
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
            <h1>Изменение работы</h1>
        </div>
    </header>
</div>
<!--head: End-->

<div class="wrap">

    <!--Message-->
    <?php if(!count($work)): ?>
        <div class="col-xs-5 alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3>Нет такой работы!</h3>
        </div>
    <?php endif; ?>
    <?php if($cols): ?>
        <div class="col-xs-5 alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3>Успешно изменено!</h3>
        </div>
    <?php endif; ?>

    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label for="title" class="col-sm-3 control-label">Title</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?= $title ?>" name="title" id="title">
            </div>
        </div>
        <div class="form-group">
            <label for="desc" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="description" id="desc"><?= $desc ?></textarea>
            </div>
        </div>
        <?php
        if (function_exists('wrapElement')) {
            $array_li = (!empty($li))? $li : array();
            if (is_array($array_li)) { ?>
                <div class="form-group">
                    <?php wrapElement($array_li, 'li'); ?>
                </div>
            <?php }
            $array_p = (!empty($m_text))? $m_text : array();
            if (is_array($array_p)) { ?>
                <div class="form-group">
                    <?php wrapElement($array_p, 'p'); ?>
                </div>
            <?php }
            $array_img = (!empty($m_img))? $m_img : array();
            if (is_array($array_img)) { ?>
                <div class="form-group">
                    <?php wrapElement($array_img, 'img'); ?>
                </div>
            <?php }
        }
        ?>
        <div class="form-group">
            <label for="link" class="col-sm-3 control-label">link</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?= $link ?>" name="link" id="link">
            </div>
        </div>
        <div class="form-group">
            <label for="image" class="col-sm-3 control-label">image</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?= $image ?>" name="image" id="image">
            </div>
        </div>
        <div class="form-group">
            <label for="github" class="col-sm-3 control-label">github</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" value="<?= $github ?>" name="github" id="github">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn btn-success">Обновить</button>
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
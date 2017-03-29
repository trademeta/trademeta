<?php
session_start();
if (!isset($_SESSION['auth'])) {
    header('Location: trade-login.php');
    exit();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/model/MSQL.php');
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
                <a href="add-work.php" class="btn btn-default">Добавить</a>
            </div>
            <h1>Портфолио</h1>
        </div>
    </header>
</div>
<!--head: End-->

<div class="wrap">

    <?php
    $msql = MSQL::Instance();
    $query = "select * from works order by id desc";
    $portfolio = $msql->Select($query);
    ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>id</th>
            <th>title</th>
            <th>description</th>
            <th>li</th>
            <th>more p</th>
            <th>link</th>
            <th>image</th>
            <th>github</th>
        </tr>
        </thead>
        <tbody>
        <?php
        function wrapElement($array) {
            $list = '<ul>';
            foreach ($array as $ar) {
                $list .= '<li>' . htmlspecialchars($ar, ENT_QUOTES) . '</li>';
            }
            $list .= '</ul>';
            return $list;
        }

        foreach ($portfolio as $work){
            $li = _decode($work['li']);
            if ($li) {
                $li = wrapElement($li);
            }
            $m_text = _decode($work['m_text']);
            if ($m_text) {
                $m_text = wrapElement($m_text);
            }
            ?>

            <tr data-id="<?= $work['id'] ?>">
                <td>
                    <button class='btn-del' title='Удалить'>-</button>
                    <a href="edit-work.php?id=<?= $work['id'] ?>" class='btn-edit' title='Редактировать'>
                        <i class="fa fa-wrench" aria-hidden="true"></i>
                    </a>
                </td>
                <td><div><?= $work['id'] ?></div></td>
                <td><div contenteditable='true' class='title'><?= $work['title'] ?></div></td>
                <td><div contenteditable='true' class='description'><?= $work['description'] ?></div></td>
                <td><div contenteditable='true' class='li'><?= $li ?></div></td>
                <td><div contenteditable='true' class='m_text'><?= $m_text ?></div></td>
                <td><div contenteditable='true' class='link'><?= $work['link'] ?></div></td>
                <td><div contenteditable='true' class='image'><?= $work['image'] ?></div></td>
                <td><div contenteditable='true' class='github'><?= $work['github'] ?></div></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
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
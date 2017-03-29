<?php
session_start();
if (!isset($_SESSION['auth'])) {
    exit();
}

if (isset($_POST['id'])) {
    include_once($_SERVER['DOCUMENT_ROOT'].'/model/MSQL.php');
    $msql = MSQL::Instance();

    $id = $_POST['id'];

    $where = sprintf("id='%s'", $msql->getMsql()->real_escape_string($id));

    $res = $msql->Delete('works', $where);
    if ($res) {
        echo 'delete-ok';
    }else{
        echo 'error';
    }
}

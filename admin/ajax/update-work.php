<?php
session_start();
if (!isset($_SESSION['auth'])) {
    exit();
}

if (isset($_POST['action']) && isset($_POST['id']) && isset($_POST['value'])) {
    include_once($_SERVER['DOCUMENT_ROOT'].'/model/MSQL.php');
    $msql = MSQL::Instance();

    $update = array();
    $field = $_POST['action'];
    $id = $_POST['id'];
    $value = $_POST['value'];
    $update[$field] = (is_array($value))? _encode($value) : $value;

    $where = sprintf("id='%s'", $msql->getMsql()->real_escape_string($id));

    $res = $msql->Update('works', $update, $where);

    if ($res) {
        echo 'ok';
    }else{
        echo 'error';
    }
}

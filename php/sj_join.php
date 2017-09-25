<?php

$mode = $_POST['mode'];

switch($mode) {
    case 'findId' :
        findId();
        break;
    case 'join' :
        user_join();
        break;
}

function findId() {
    $id = $_POST['id'];

    $con = mysqli_connect("localhost", "root", "autoset");
    mysqli_select_db($con, "sj");

    $sql = "select * from sj_user where id='$id'";

    $result = mysqli_query($con, $sql);
    $row = mysqli_num_rows($result);

    echo $row;
    mysqli_close($con);
}

function user_join() {
    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $name = $_POST['name'];

    $con = mysqli_connect("localhost", "root", "autoset");
    mysqli_select_db($con, "sj");

    $date = date("Y-m-d H:i:s");
    $sql = "insert into sj_user (id, password, name, sign_date) values ('$id', '$pw', '$name', '$date')";

    $result = mysqli_query($con, $sql);

    if($result)
        echo "complete";
    else
        echo "회원가입 실패!";

    mysqli_close($con);
}
<?php
session_start();

$id = $_POST['id'];
$pw = $_POST['pw'];

$con = mysqli_connect("localhost", "root", "autoset");
mysqli_select_db($con, "sj");

$query = "select * from sj_user where id='$id' and password='$pw'";

$result = mysqli_query($con, $query);
$row = mysqli_num_rows($result);

if($row >= 1) {
    session_start();
    $array = mysqli_fetch_array($result);
    $_SESSION['user_id'] = $array['id'];
    $_SESSION['user_name'] = $array['name'];
    $_SESSION['user_date'] = $array['sign_date'];
    echo "success";
} else {
    echo "아이디 또는 비밀번호를 확인해주세요.";
}

mysqli_close($con);
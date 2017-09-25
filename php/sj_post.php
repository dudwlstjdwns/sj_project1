<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    echo "글쓰기 권한이 없습니다.";
    return;
}

$title = $_POST['title'];
$contents = $_POST['contents'];
$user_id = $_SESSION['user_id'];

$con = mysqli_connect('localhost', 'root', 'autoset');
mysqli_select_db($con, 'sj');

$date = date("Y-m-d H:i:s");
$query = "insert into sj_board (user_id, title, contents, reg_date) values ('$user_id', '$title', '$contents', '$date')";

$result = mysqli_query($con, $query);

if($result)
    echo "성공적으로 등록되었습니다.";
else
    echo "등록에 실패했습니다.";

mysqli_close($con);
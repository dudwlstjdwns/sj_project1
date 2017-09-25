<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    echo "댓글 쓰기 권한이 없습니다.";
    return;
}

$board_id = $_POST['board_id'];
$comment = $_POST['comment'];
$user_id = $_SESSION['user_id'];

$con = mysqli_connect('localhost', 'root', 'autoset');
mysqli_select_db($con, 'sj');

$date = date("Y-m-d H:i:s");
$query = "insert into sj_comment (board_id, user_id, comment, reg_date) values ('$board_id', '$user_id', '$comment', '$date')";

$result = mysqli_query($con, $query);

$query = "update sj_board set comment = comment + 1 where board_id = $board_id";

$result = mysqli_query($con, $query);

if($result)
    echo "성공적으로 등록되었습니다.";
else
    echo "등록에 실패했습니다.";

mysqli_close($con);
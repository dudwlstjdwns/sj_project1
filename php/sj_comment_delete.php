<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    echo "권한이 없습니다.";
    return;
}

$comment_id = $_POST['comment_id'];
$user_id = $_SESSION['user_id'];
$board_id = $_POST['board_id'];

$con = mysqli_connect('localhost', 'root', 'autoset');
mysqli_select_db($con, 'sj');

$query = "select * from sj_comment where comment_id=$comment_id and user_id='$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_num_rows($result);

$query = "select * from sj_user where id='$user_id'";
$power_check = mysqli_query($con, $query);
$result_power = mysqli_fetch_array($power_check);

if($row < 1 && $result_power['power'] != 1) {
    echo "권한이 없습니다!";
    mysqli_close($con);
    return;
}

$query = "delete from sj_comment where comment_id=$comment_id";
$result = mysqli_query($con, $query);
if($result) {
    $query = "update sj_board set comment = comment - 1 where board_id=$board_id";
    $result = mysqli_query($con, $query);

    if($result) {
        echo "댓글이 삭제되었습니다.";
    } else {
        echo "댓글 삭제 실패! error code 2";
    }
} else {
    echo "댓글 삭제 실패! error code 1";
}

mysqli_close($con);
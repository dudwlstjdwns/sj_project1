<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    echo "삭제 권한이 없습니다.";
    return;
}

$board_id = $_POST['board_id'];
$user_id = $_SESSION['user_id'];

$con = mysqli_connect('localhost', 'root', 'autoset');
mysqli_select_db($con, 'sj');

$query = "select * from sj_board where board_id='$board_id' and user_id='$user_id'";
$row_check = mysqli_query($con, $query);
$row = mysqli_num_rows($row_check);

$query = "select * from sj_user where id='$user_id'";
$power_check = mysqli_query($con, $query);
$result_power = mysqli_fetch_array($power_check);

if($row < 1 && $result_power['power'] != 1) {
    echo "권한이 없습니다!";
    mysqli_close($con);
    return;
}

$query = "delete from sj_board where board_id=$board_id";
$result = mysqli_query($con, $query);

if($result)
    echo "성공적으로 삭제 되었습니다.";
else
    echo "삭제에 실패했습니다.";

mysqli_close($con);
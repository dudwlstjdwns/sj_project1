<?php

session_start();

function getNowPage() {
    if(!isset($_SESSION['nowPage']) || !isset($_GET['page'])) {
        $_SESSION['nowPage'] = 1;
    } else {
        $_SESSION['nowPage'] = $_GET['page'];
    }
}

function getLogin() {
    if(isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $name = $_SESSION['user_name'];
        echo "<li><a><span class='text-danger'>$id($name)님</span></a>";
        echo "<li><a href='#information' data-toggle='modal'>회원정보</a></li>";
        echo "<li><a href='' onclick='logout()'>로그아웃</a></li>";
    } else {
        echo "<li><a href='#join' data-toggle='modal'>회원가입</a></li>";
        echo "<li><a href='#login' data-toggle='modal'>로그인</a></li>";
    }
}

function getInfo() {
    if(isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $name = $_SESSION['user_name'];
        $join_date = $_SESSION['user_date'];

        echo "<p>아이디 : $id</p>";
        echo "<p>이름 : $name</p>";
        echo "<p>가입일시 : $join_date</p>";
    }
}

function getList() {
    $con = mysqli_connect('localhost', 'root', 'autoset');
    mysqli_select_db($con, 'sj');

    $limit = ($_SESSION['nowPage'] - 1) * 10;

    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $key = $_GET['key'];

        $query = "select * from sj_board where $type like '%$key%' order by board_id desc limit $limit, 10";
    } else {
        $query = "select * from sj_board order by board_id desc limit $limit, 10";
    }
    $result = mysqli_query($con, $query);
    $row = mysqli_num_rows($result);

    if($row == 0 && isset($_GET['type'])) {
        echo "<tr>";
        echo "<td colspan='5'>검색된 글이 없습니다.</td>";
        echo "<tr>";
    }

    for($i = 0; $i < $row; $i++) {
        $array = mysqli_fetch_array($result);
        $board_id = $array['board_id'];
        $title = $array['title'];
        $comment = $array['comment'];
        $user_id = $array['user_id'];
        $date = $array['reg_date'];
        $hits = $array['hits'];

        echo "<tr>";
        echo "  <td>$board_id</td>";
        if(isset($_GET['type'])) {
            $type = $_GET['type'];
            $key = $_GET['key'];

            if($comment == 0)
                echo "  <td><a href='sj_contents.php?board_id=$board_id&type=$type&key=$key'>$title</a></td>";
            else
                echo "  <td><a href='sj_contents.php?board_id=$board_id&type=$type&key=$key'>$title</a> <span style='color: red'>[$comment]</span></td>";
        } else {
            if($comment == 0)
                echo "  <td><a href='sj_contents.php?board_id=$board_id'>$title</a></td>";
            else
                echo "  <td><a href='sj_contents.php?board_id=$board_id'>$title</a> <span style='color: red'>[$comment]</span></td>";
        }
        echo "  <td>$user_id</td>";
        echo "  <td>$date</td>";
        echo "  <td>$hits</td>";
        echo "</tr>";
    }

    mysqli_close($con);
}

function getWrite() {
    if(isset($_SESSION['user_id'])) {
        echo "<a class='btn btn-default pull-right' href='#write' data-toggle='modal'>글쓰기</a>";
    }
}

function getPagination() {
    $con = mysqli_connect('localhost', 'root', 'autoset');
    mysqli_select_db($con, 'sj');

    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $key = $_GET['key'];

        $query = "select * from sj_board where $type like '%$key%'";
    } else {
        $query = "select * from sj_board";
    }

    $result = mysqli_query($con, $query);
    $row = mysqli_num_rows($result);

    $nowPage = $_SESSION['nowPage'];
    $totalPage = ceil($row / 10);
    $start = $nowPage % 5;
    if($start == 0)
        $start = $nowPage - 4;
    else
        $start = (floor($nowPage / 5)) * 5 + 1;
    $end = MIN(($start + 4), $totalPage);

    $pre = $nowPage - 1;
    $next = $nowPage + 1;

    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $key = $_GET['key'];

        if ($nowPage == 1) {
            echo "<li class='disabled'><a href='#'><<</a></li>";
            echo "<li class='disabled'><a href='#'><</a></li>";
        } else {
            echo "<li><a href='index.php?page=1&type=$type&key=$key'><<</a></li>";
            echo "<li><a href='index.php?page=$pre&type=$type&key=$key'><</a></li>";
        }
    } else {
        if ($nowPage == 1) {
            echo "<li class='disabled'><a href='#'><<</a></li>";
            echo "<li class='disabled'><a href='#'><</a></li>";
        } else {
            echo "<li><a href='index.php?page=1'><<</a></li>";
            echo "<li><a href='index.php?page=$pre'><</a></li>";
        }
    }

    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $key = $_GET['key'];

        for($i = $start; $i <= $end; $i++) {
            if($i == $nowPage)
                echo "<li class='active'><a>$i</a></li>";
            else
                echo "<li><a href='index.php?page=$i&type=$type&key=$key'>$i</a></li>";
        }
    } else {
        for($i = $start; $i <= $end; $i++) {
            if($i == $nowPage)
                echo "<li class='active'><a>$i</a></li>";
            else
                echo "<li><a href='index.php?page=$i'>$i</a></li>";
        }
    }

    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $key = $_GET['key'];

        if ($nowPage == $totalPage) {
            echo "<li class='disabled'><a href='#'>></a></li>";
            echo "<li class='disabled'><a href='#'>>></a></li>";
        } else {
            echo "<li><a href='index.php?page=$next&type=$type&key=$key'>></a></li>";
            echo "<li><a href='index.php?page=$totalPage&type=$type&key=$key'>>></a></li>";
        }
    } else {
        if ($nowPage == $totalPage) {
            echo "<li class='disabled'><a href='#'>></a></li>";
            echo "<li class='disabled'><a href='#'>>></a></li>";
        } else {
            echo "<li><a href='index.php?page=$next'>></a></li>";
            echo "<li><a href='index.php?page=$totalPage'>>></a></li>";
        }
    }

    mysqli_close($con);
}

function getSearch() {
    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $key = $_GET['key'];

        echo "<script>document.getElementById('key').value = '$key'</script>";
        switch($type) {
            case 'title' :
                echo "<script>document.getElementById('such').selectedIndex = 0</script>";
                break;
            case 'contents' :
                echo "<script>document.getElementById('such').selectedIndex = 1</script>";
                break;
            case 'user_id' :
                echo "<script>document.getElementById('such').selectedIndex = 2</script>";
                break;
        }
    }
}

function getBoard($arg) {
    $con = mysqli_connect('localhost', 'root', 'autoset');
    mysqli_select_db($con, 'sj');

    $board_id = $_GET['board_id'];

    $query = "select * from sj_board where board_id=$board_id";

    $result = mysqli_query($con, $query);

    $array = mysqli_fetch_array($result);

    switch($arg) {
        case 'getTitle' :
            $title = $array['title'];
            $date = $array['reg_date'];

            echo "<th><h2>$title</h2></th>";
            echo "<th class='text-right' width='150px'>$date</th>";
            break;
        case 'getUser' :
            $user_id = $array['user_id'];
            $hits = $array['hits'];

            echo "<td colspan='2'><b>$user_id</b><span class='pull-right'>조회 : $hits</span></td>";
            break;
        case 'getContents' :
            $contents = $array['contents'];

            echo nl2br(htmlspecialchars($contents));
            break;
        case 'changeTitle' :
            $title = $array['title'];

            echo $title;
            break;
        case 'changeContents' :
            $contents = $array['contents'];

            echo $contents;
            break;
        case 'getBoard_id' :
            echo $board_id;
            break;
        case 'hitsUp' :
            $query = "update sj_board set hits=hits+1 where board_id=$board_id";

            mysqli_query($con, $query);
            break;
    }
    mysqli_close($con);
}

function getButton() {
    $page = $_SESSION['nowPage'];
    if(isset($_GET['type'])) {
        $type = $_GET['type'];
        $key = $_GET['key'];

        echo "<a class='btn btn-default' href='index.php?page=$page&type=$type&key=$key'>목록</a>";
    } else {
        echo "<a class='btn btn-default' href='index.php?page=$page'>목록</a>";
    }

    $con = mysqli_connect("localhost", "root", "autoset");
    mysqli_select_db($con, "sj");

    $board_id = $_GET['board_id'];
    $query = "select * from sj_board where board_id=$board_id";
    $result_contents = mysqli_query($con, $query);
    $array_contents = mysqli_fetch_array($result_contents);

    $user_id = $_SESSION['user_id'];

    $query = "select * from sj_user where id='$user_id'";
    $result_user = mysqli_query($con, $query);
    $array_user = mysqli_fetch_array($result_user);

    if($_SESSION['user_id'] == $array_contents['user_id'] || $array_user['power'] == 1) {
        echo "<a class='btn btn-danger pull-right' href='#delete' data-toggle='modal'>삭제</a>";
        echo "<a class='btn btn-default pull-right' href='#change' data-toggle='modal'>수정</a>";
    }

    mysqli_close($con);
}

function getComment() {
    $con = mysqli_connect("localhost", "root", "autoset");
    mysqli_select_db($con, "sj");

    $board_id = $_GET['board_id'];
    $query = "select * from sj_comment where board_id=$board_id";

    $result = mysqli_query($con, $query);
    $row = mysqli_num_rows($result);

    $user_id = $_SESSION['user_id'];

    $query = "select * from sj_user where id='$user_id'";
    $result_user = mysqli_query($con, $query);
    $array_user = mysqli_fetch_array($result_user);

    if($row == 0) {
        echo "댓글이 없습니다.";
        echo "<br><br>";
    } else {
        echo "<table class='table table-bordered' style='background-color: #fbfbfb; table-layout: fixed';>";
        echo "<thead style='background-color: #dbdbdb'>";
        echo "<tr>";
        echo "<td width='150px'>작성자</td><td width='600px'>내용</td><td width='150px'>작성일시</td><td width='80px'>수정/삭제</td>";
        echo "</tr>";
        echo "</thead>";
        for($i = 0; $i < $row; $i++) {
            $array = mysqli_fetch_array($result);
            $comment_id = $array['comment_id'];
            $user_id = $array['user_id'];
            $comment = nl2br(htmlspecialchars($array['comment']));
            $date = $array['reg_date'];
            $power = $array_user['power'];

            echo "<tr>";
            echo "<td>$user_id</td>";
            echo "<td id='comment$comment_id' class='text-left' style='word-break:break-all'>$comment</td>";
            echo "<td>$date</td>";
            if($_SESSION['user_id'] == $user_id || $power == 1) {
                echo "<td><button class='btn btn-default btn-xs' onclick='commentChange(\"$comment_id\")'>수정</button>";
                echo "<button class='btn btn-danger btn-xs' href='#delete_comment' data-toggle='modal' onclick='commentId=\"$comment_id\", boardId=$board_id'>x</button></td>";
            } else {
                echo "<td></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    if(!isset($_SESSION['user_id'])) {
        echo "댓글은 로그인 후 작성 가능합니다.";
        echo "<br><br>";
    } else {
        echo "<textarea id='comment' class='form-control' rows='3' maxlength='200' style='resize: none'></textarea>";
        echo "<br>";
        echo "<button class='btn btn-default pull-right' onclick='commentIt($board_id)'>입력</button><br><br>";
    }
}
<?php include "php/sj_action.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SJ Index</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<? getBoard('hitsUp') ?>
<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand">SJ Board</a>
            </div>
            <div>
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li class="active"><a href="#">Contents</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <? getLogin() ?>
                </ul>
            </div>
        </div>
    </nav>

    <table class="table" style="table-layout: fixed">
        <thead>
        <tr>
            <? getBoard('getTitle') ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <? getBoard('getUser') ?>
        </tr>
        </tbody>
    </table>
    <? getBoard('getContents') ?>
    <hr>
    <? getButton() ?>
    <hr>
    <div class="text-center">
    <? getComment() ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input id="user_id" class="form-control" placeholder="아이디">
                </div>
                <input id="user_pw" type="password" class="form-control" placeholder="비밀번호">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="login()">로그인</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="join" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">회원가입</h4>
            </div>
            <div class="modal-body">
                <div id="form_id" class="form-group">
                    <input id="join_id" class="form-control" placeholder="아이디" onfocusout="idCheck()" onfocus="idClear()">
                </div>
                <div id="form_pw1" class="form-group">
                    <input id="join_pw1" type="password" class="form-control" placeholder="비밀번호" onfocusout="pw1Check(), pw2Check()" onfocus="pw1Clear(), pw2Clear()">
                </div>
                <div id="form_pw2" class="form-group">
                    <input id="join_pw2" type="password" class="form-control" placeholder="비밀번호 확인" onfocusout="pw2Check()" onfocus="pw2Clear()">
                </div>
                <div id="form_name" class="form-group">
                    <input id="join_name" class="form-control" placeholder="이름(별명)" onfocusout="nameCheck()" onfocus="nameClear()">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="join()">회원가입</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="change" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h2 class="modal-title">수정</h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input id="title" class="form-control" placeholder="제목" value="<? getBoard('changeTitle') ?>">
                </div>
                <textarea id="contents" class="form-control" placeholder="내용을 입력하세요" rows="20" style="resize: none"><? getBoard('changeContents') ?></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary pull-left" onclick="postClear()">초기화</button>
                <button class="btn btn-success" onclick="changeIt(<? getBoard('getBoard_id') ?>)">수정</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">게시글 삭제</h2>
            </div>
            <div class="modal-body">
                정말 삭제하시겠습니까?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="deleteIt(<? getBoard('getBoard_id') ?>)">삭제</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="information" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h2 class="modal-title">회원정보</h2>
            </div>
            <div class="modal-body">
                <? getInfo() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_comment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">댓글 삭제</h2>
            </div>
            <div class="modal-body">
                정말 삭제하시겠습니까?
            </div>
            <div class="modal-footer">
                <button id="del_com" type="button" class="btn btn-danger" onclick="commentDelete(commentId, boardId)">삭제</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">취소</button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/sj_index.js"></script>
</body>
</html>
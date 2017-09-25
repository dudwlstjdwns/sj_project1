var id_pass = "";
var nonKorean = /[^(a-zA-Z0-9)]/;
var commentId = 0;
var boardId = 0;

function login() {
    var id = document.getElementById("user_id");
    var pw = document.getElementById("user_pw");

    if(id.value.length < 1) {
        alert("아이디를 입력하세요.");
        id.focus();
        return;
    } else if(pw.value.length < 1) {
        alert("비밀번호를 입력하세요.");
        pw.focus();
        return;
    }

    var xml = new XMLHttpRequest();
    var url = "php/sj_login.php";

    xml.open('POST', url, true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xml.onreadystatechange = function() {
        if(xml.readyState == 4 && xml.status == 200) {
            if(xml.responseText == "success") {
                location.reload();
            } else {
                alert(xml.responseText);
            }
        }
    };

    xml.send("id=" + id.value + "&pw=" + pw.value);
}

function logout() {
    var xml = new XMLHttpRequest();
    var url = "php/sj_logout.php";

    xml.open('POST', url, true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xml.onreadystatechange = function() {
        if(xml.readyState == 4 && xml.status == 200) {
            alert("로그아웃 되었습니다.");
            location.reload();
        }
    };

    xml.send();
}

function postIt() {
    var title = document.getElementById("title");
    var contents = document.getElementById("contents");

    if(title.value.length < 2) {
        alert("제목은 최소 2글자 이상입니다.");
        title.focus();
        return;
    } else if(contents.value.length == 0) {
        alert("내용을 입력하세요.");
        contents.focus();
        return;
    }

    var http = new XMLHttpRequest();
    var url = "php/sj_post.php";

    http.open("POST", url, true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            alert(http.responseText);
            location.reload();
        }
    };

    http.send("title=" + title.value + "&contents=" + contents.value);
}

function changeIt(board_id) {
    var title = document.getElementById("title");
    var contents = document.getElementById("contents");

    if(title.value.length < 2) {
        alert("제목은 최소 2글자 이상입니다.");
        title.focus();
        return;
    } else if(contents.value.length == 0) {
        alert("내용을 입력하세요.");
        contents.focus();
        return;
    }

    var http = new XMLHttpRequest();
    var url = "php/sj_change.php";

    http.open("POST", url, true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            alert(http.responseText);
            location.reload();
        }
    };

    http.send("board_id=" + board_id + "&title=" + title.value + "&contents=" + contents.value);
}

function deleteIt(board_id) {
    var http = new XMLHttpRequest();
    var url = "php/sj_delete.php";

    http.open("POST", url, true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            alert(http.responseText);
            location.href = "index.php";
        }
    };

    http.send("board_id=" + board_id);
}

function postClear() {
    var title = document.getElementById("title");
    var contents = document.getElementById("contents");

    title.value = "";
    contents.value = "";
}

function idCheck() {
    var join_id = document.getElementById("join_id");

    if(join_id.value.length < 5 || join_id.value.length > 20 || nonKorean.test(join_id.value)) {
        $("#form_id").attr("class", "form-group has-error has-feedback");
        $("#form_id").append("<span id='span_id' class='glyphicon glyphicon-remove form-control-feedback'></span>");
        return;
    }

    var xml = new XMLHttpRequest();
    var url = 'php/sj_join.php';

    xml.open('POST', url, true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xml.onreadystatechange = function() {
        if(xml.readyState == 4 && xml.status == 200) {
            if(xml.responseText >= 1) {
                $("#form_id").attr("class", "form-group has-error has-feedback");
                $("#form_id").append("<span id='span_id' class='glyphicon glyphicon-remove form-control-feedback'></span>");
                id_pass = "no";
            } else {
                $("#form_id").attr("class", "form-group has-success has-feedback");
                $("#form_id").append("<span id='span_id' class='glyphicon glyphicon-ok form-control-feedback'></span>");
                id_pass = "yes";
            }
        }
    };

    xml.send("mode=findId&id=" + join_id.value);
}

function idClear() {
    $("#form_id").attr("class", "form-group");
    $("#span_id").remove();
}

function pw1Check() {
    var join_pw1 = document.getElementById('join_pw1');

    if(join_pw1.value.length < 6 || join_pw1.length > 16) {
        $("#form_pw1").attr("class", "form-group has-error has-feedback");
        $("#form_pw1").append("<span id='span_pw1' class='glyphicon glyphicon-remove form-control-feedback'></span>");
    }
}

function pw2Check() {
    var join_pw1 = document.getElementById('join_pw1');
    var join_pw2 = document.getElementById('join_pw2');

    if(join_pw1.value != join_pw2.value) {
        $("#form_pw2").attr("class", "form-group has-error has-feedback");
        $("#form_pw2").append("<span id='span_pw2' class='glyphicon glyphicon-remove form-control-feedback'></span>");
    } else {
        $("#form_pw2").attr("class", "form-group has-success has-feedback");
        $("#form_pw2").append("<span id='span_pw2' class='glyphicon glyphicon-ok form-control-feedback'></span>");
    }
}

function nameCheck() {
    var join_name = document.getElementById('join_name');

    if(join_name.value.length < 2 || join_name.value.length > 12) {
        $("#form_name").attr("class", "form-group has-error has-feedback");
        $("#form_name").append("<span id='span_name' class='glyphicon glyphicon-remove form-control-feedback'></span>");
    } else {
        $("#form_name").attr("class", "form-group has-success has-feedback");
        $("#form_name").append("<span id='span_name' class='glyphicon glyphicon-ok form-control-feedback'></span>");

    }
}

function pw1Clear() {
    $("#form_pw1").attr("class", "form-group");
    $("#span_pw1").remove();
}

function pw2Clear() {
    $("#form_pw2").attr("class", "form-group");
    $("#span_pw2").remove();
}

function nameClear() {
    $("#form_name").attr("class", "form-group");
    $("#span_name").remove();
}

function join() {
    var id = document.getElementById("join_id");
    var pw1 = document.getElementById("join_pw1");
    var pw2 = document.getElementById("join_pw2");
    var name = document.getElementById("join_name");

    if(id.value.length < 5 || id.value.length > 20 || nonKorean.test(id.value)) {
        alert("아이디는 5~20자의 영문 소문자와 숫자만 가능합니다.");
        return;
    } else if(id_pass == "no") {
        alert("이미 사용중인 아이디입니다.");
        id.focus();
        return;
    } else if(pw1.value.length < 1) {
        alert("비밀번호는 필수 입력 항목입니다.");
        pw1.focus();
        return;
    } else if(pw1.value.length < 6 || pw1.value.length > 16) {
        alert("비밀번호는 6~16자 사이만 가능합니다.");
        pw1.focus();
        return;
    } else if(pw2.value.length < 1) {
        alert("비밀번호는 필수 입력 항목입니다.");
        pw2.focus();
        return;
    } else if(pw1.value != pw2.value) {
        alert("비밀번호가 서로 다릅니다.");
        pw2.focus();
        return;
    } else if(name.value.length < 1) {
        alert("이름은 필수 입력 항목입니다.");
        name.focus();
        return;
    } else if(name.value.length < 2 || name.value.length > 12) {
        alert("이름은 2~12자 사이만 가능합니다.");
        name.focus();
        return;
    }

    var xml = new XMLHttpRequest();
    var url = 'php/sj_join.php';

    xml.open('POST', url, true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xml.onreadystatechange = function() {
        if(xml.readyState == 4 && xml.status == 200) {
            if(xml.responseText == "complete") {
                alert("회원가입 완료!");
                location.reload();
            } else {
                alert(xml.responseText);
            }
        }
    };

    xml.send("mode=join&id=" + id.value + "&pw=" + pw1.value + "&name=" + name.value);
}

function searchIt() {
    var select = document.getElementById('such');
    var key = document.getElementById('key');

    if(key.value == "") {
        alert("검색 키워드를 입력하세요.");
        key.focus();
        return;
    }

    switch(select.value) {
        case "제목" :
            location.href = "index.php?type=title&key=" + key.value;
            break;
        case "내용" :
            location.href = "index.php?type=contents&key=" + key.value;
            break;
        case "작성자" :
            location.href = "index.php?type=user_id&key=" + key.value;
            break;
    }
}

function commentIt(board_id) {
    var comment = document.getElementById('comment');

    if(comment.value == "") {
        alert("내용을 입력하세요.");
        comment.focus();
        return;
    }
    var http = new XMLHttpRequest();
    var url = "php/sj_comment.php";

    http.open("POST", url, true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            alert(http.responseText);
            location.reload();
        }
    };

    http.send("comment=" + comment.value + "&board_id=" + board_id);
}

function commentDelete(comment_id, board_id) {
    var http = new XMLHttpRequest();
    var url = "php/sj_comment_delete.php";

    http.open("POST", url, true);

    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function() {
        if(http.readyState == 4 && http.status == 200) {
            alert(http.responseText);
            location.reload();
        }
    };

    http.send("comment_id=" + comment_id + "&board_id=" + board_id);
}

function commentChange(comment_id) {
    var comment = document.getElementById("comment" + comment_id);
    var input = document.createElement("input");

    if(comment.childNodes[0].nodeName == "INPUT") {
        var comment = document.getElementById('input' + comment_id);

        if(comment.value == "") {
            alert("댓글 내용을 입력하세요.");
            comment.focus();
            return;
        }
        var http = new XMLHttpRequest();
        var url = "php/sj_comment_change.php";

        http.open("POST", url, true);

        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        http.onreadystatechange = function() {
            if(http.readyState == 4 && http.status == 200) {
                alert(http.responseText);
                location.reload();
            }
        };

        http.send("comment_id=" + comment_id + "&comment=" + comment.value);
    }

    input.className = "form-control";
    input.value = comment.innerHTML;
    input.id = "input" + comment_id;
    input.maxLength = 200;

    comment.innerHTML = "";
    comment.appendChild(input);
}
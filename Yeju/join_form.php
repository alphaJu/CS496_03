<?php 
include "header.php";
include "config.php";  
include "util.php";     

   error_reporting(E_ALL);

ini_set("display_errors", 1);
$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read committed");
mysqli_query($conn, "begin");

$member_id = $_GET["ID"];
$query =  "select * from member where member_id = '$member_id'";
$res = mysqli_query($conn, $query);

if(!$res) {
	mysqli_query($conn, "rollback");
	msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
}

else {
	mysqli_query($conn, "commit");
}

$member = mysqli_fetch_array($res);
if(!$member) {
	msg("NOT VALID ACCESS."); // 회원이 존재하지 않음
}

?>
	<div class="container">
		<h1>MY INFO</h1>
		<?
            echo "<p align='right'><a href='my_product.php?my_ID={$member_id}'><button class='button primary large'>MY PRODUCTS</button></a></p>";
            ?>
        <form name="join_form" action="join_modify.php" method="post" class="fullwidth form-group">
            <input type="hidden" id="ID" name="ID" value="<?=$member['member_id']?>"/>
            
            <div class="form-group">
                <label for="member_name">MY NAME</label>
                <input class="form-control" type="text" id="name" name="name" value="<?=$member['member_name']?>"/>
            </div>
            
            <div class="form-group">
            	<label for="member_password">PASSWORD</label>
                <input class="form-control" type="password" id="passwd" name="passwd" rows="10"/>
            </div>
            
            <div class="form-group">
            	<label for="c_member_password">PASSWORD CONFIRM</label>
                <input class="form-control" type="password" id="c_passwd" name="c_passwd" rows="10"/>
            </div>
            
            <div class="form-group">
            	<label for="phone">PHONE</label>
                <input class="form-control" type="number" id="m_phone" name="m_phone" value="<?=$member['phone']?>" />
            </div>
            
            <div class="form-group">
            	<label for="address">ADDRESS</label>
                <input class="form-control" type="text" id="m_address" name="m_address" value="<?=$member['address']?>" />
            </div>
            
            <p align="center"><button class="button primary large" onclick="javascript:return validate();">UPDATE</button></p>
	
            <script>
                function validate() {
                    if(document.getElementById("name").value == "") {
                        alert ("What's your name?"); return false;
                    }
                    else if(document.getElementById("passwd").value == "") {
                        alert ("What's your password?"); return false;
                    }
                    else if(document.getElementById("m_phone").value == "") {
                        alert ("What's your phone number?"); return false;
                    }
                    else if(document.getElementById("m_address").value == "") {
                        alert ("What's your address?"); return false;
                    }
                    return true;
                }
            </script>
        </form>
   <!--
        <script>
        function deleteConfirm(member_id) {
            if (confirm("정말 탈퇴하시겠습니까?") == true){    //확인
                window.location = "join_delete.php?d_ID=" + member_id;
            }else{   //취소
                return;
            }
        }
    	</script>
    -->
    	<?php
    		echo "<p align='center'><a href='join_delete.php?d_ID={$member_id}'><button class='button primary large'>탈퇴하기</button></a></p>";
        ?>
    </div>
<? include ("footer.php") ?>
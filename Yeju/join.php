<?php 
include "header.php";
include "config.php";  
include "util.php";     

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

?>
	<div class="container">
        <form name="join_form" action="join_insert.php" method="post" class="form-group">
            <h1>JOIN</h1>
            </br>
            <div class="form-group">
            	<label for="member_id">ID</label>
                <input class="form-control" type="text" id="member_id" name="member_id"/>
            </div>
            <div class="form-group">
            	<label for="member_name">NAME</label>
                <input class="form-control" type="text" id="member_name" name="member_name" value="<?=$member['member_name']?>"/>
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
            	<label for="phone">PHONE (without -)</label>
                <input class="form-control" type="number" id="phone" name="phone" value="<?=$member['phone']?>" />
            </div>
            <div class="form-group">
            	<label for="address">ADDRESS</label>
                <input class="form-control" type="text" id="address" name="address" value="<?=$member['address']?>" />
            </div>
            <p align="center"><button class="button primary large" onclick="javascript:return validate();">JOIN</button></p>

            <script>
                function validate() {
                    if(document.getElementById("member_name").value == "") {
                        alert ("What's your name?"); return false;
                    }
                    else if(document.getElementById("passwd").value == "") {
                        alert ("What's your password?"); return false;
                    }
                    else if(document.getElementById("phone").value == "") {
                        alert ("What's your phone number?"); return false;
                    }
                    else if(document.getElementById("address").value == "") {
                        alert ("What's your address?"); return false;
                    }
                    return true;
                }
            </script>
            
        </form>
    </div>
<? include ("footer.php") ?>
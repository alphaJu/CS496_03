 <?php
 include "header.php";
include "config.php";  
include "util.php";    
 
 ?>
	<div id="page" class="container">
        <form name="form" action="login_confirm.php" method="post" class="form-group">
            <div class="form-group">
            	<label for="mem_id">ID</label>
                <input class="form-control" type="text" id="mem_id" name="mem_id"/>
            </div>
            <div class="form-group">
            	<label for="mem_pwd">PASSWORD</label>
                <input class="form-control" type="password"id="mem_pwd" name="mem_pwd"/>
            </div>
			<p align="center"><button class="button primary large">LOGIN</button></p>
        </form>
        <p align="center"><a href="join.php"><button class='button primary large'>JOIN</button></a></p>
    </div>
	
<?php include “footer.php”; ?>
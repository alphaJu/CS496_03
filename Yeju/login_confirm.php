<?php
   include "config.php"; 
   include "util.php"; 
   error_reporting(E_ALL);

   ini_set("display_errors", 1);

   $conn = dbconnect($host,$dbid,$dbpass,$dbname);
   $id = $_POST['mem_id'];
   $pwd = $_POST['mem_pwd'];
   
   mysqli_query($conn, "set autocommit = 0");
   mysqli_query($conn, "set transaction isolation level read committed");
   mysqli_query($conn, "begin");
   
   $mem_ret = mysqli_query($conn, "select * from member where member_id = '$id'");
   
   if(!$mem_ret) {
	  mysqli_query($conn, "rollback");
	  msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
   }
   
   else {
   		mysqli_query($conn, "commit");
   }
   
   $mem_num = mysqli_num_rows($mem_ret); 
   
	if(!$mem_num) {
    	msg('NOT VALID ID');
	}
	else {
    	$mem_array = mysqli_fetch_array($mem_ret);
    	$db_name = $mem_array['member_name'];
    	$db_pwd = $mem_array['member_password'];
    	if($db_pwd == $pwd) {
        	SetCookie("cookie_id", $id,0,"/"); // 0 : browser lifetime – 0 or omitted : end of session
        	SetCookie("cookie_name", $db_name,0, "/");

        	echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    	}
    	else {
      		msg('WRONG PASSWORD');
    	}   
	}
   
   mysqli_close($conn);
?>
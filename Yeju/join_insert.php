<?php
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
   error_reporting(E_ALL);

ini_set("display_errors", 1);
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$id = $_POST['member_id'];
$pass = $_POST['passwd']; 
$c_pass = $_POST['c_passwd'];
$name = $_POST['member_name'];
$phone = $_POST['phone'];
$add = $_POST['address'];

mysqli_query($connect, "set autocommit = 0");
mysqli_query($connect, "set transaction isolation level serializable");
mysqli_query($connect, "begin");

$ret = mysqli_query($connect, "select member_id from member where member_id='$id'"); //ID 조사

if(!$ret) {
	mysqli_query($connect, "rollback");
	msg('불러오기에 실패하였습니다. 다시 시도하여 주십시오.');
}

else {
	$num = mysqli_num_rows($ret);

	if($num) {
		mysqli_query($connect, "commit");
		msg('ID ALREADY EXISTS');
	}
	else if(check_pass($pass,$c_pass)!=0) {
		mysqli_query($connect, "commit");
		msg('WRONG PASSWORD'); 
	}	
	else {
//PASS 조사
	
	$insert_query = "insert into member (member_id, member_name, address, member_password, phone) values ('$id','$name','$add','$pass', '$phone')";
	$insert_ret = mysqli_query($connect, $insert_query);
	
		if(!$insert_ret) {
			mysqli_query($connect, "rollback");
			msg('가입하기에 실패하였습니다. 다시 시도하여 주십시오');
		}
		else {
			mysqli_query($connect, "commit");
			s_msg('WELCOME');
			echo "<meta http-equiv='refresh' content='0;url=login.php'>";
		}
	}
}
mysqli_close($connect);
?>
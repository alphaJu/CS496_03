<?php
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
error_reporting(E_ALL);

ini_set("display_errors", 1);
	$connect = dbconnect($host,$dbid,$dbpass,$dbname);
	$product_id = $_POST['product_id'];
	$price_arr = $_POST['price'];
	$count = $_POST['count'];
	
	mysqli_query($connect, "set autocommit = 0");
    mysqli_query($connect, "set transaction isolation level serializable");
    mysqli_query($connect, "begin");
    
	if(!$_COOKIE['cookie_id'] || !$_COOKIE['cookie_name']) {
		msg('LOGIN PLEASE'); 
	}
	else {
		$id = $_COOKIE['cookie_id'];
		$ret = mysqli_query($connect, "insert into order_list (member_id, order_date, product_id, quantity) 
		values ('$id', NOW(), $product_id, $count)");
		
		if(!$ret) {
			mysqli_query($connect, "rollback");
			msg('주문하기에 실패하였습니다. 다시 시도하여 주십시오');
		}
		else {
			mysqli_query($connect, "commit");
			echo "<meta http-equiv='refresh' content='0;url=order_list.php?ID={$id}'>";
		}
		
	}
?>
<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$review_id = $_GET['r_id'];
$product_id = $_GET['p_id'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read uncommitted");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "delete from review_list where review_id = $review_id");
?>

<?php
	if(!$ret){
		mysqli_query($conn, "rollback");
		msg('Query Error : '.mysqli_error($conn));
	}
	else {
		mysqli_query($conn, "commit");
    	s_msg ('SUCCESSFULLY DELETED');
    	echo "<meta http-equiv='refresh' content='0;url=review_list.php?r_ID=$product_id'>";
	}
?>


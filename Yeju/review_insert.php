<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
error_reporting(E_ALL);

ini_set("display_errors", 1);
$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$product_review = $_POST['product_review'];
$product_id = $_POST['product_id'];
$member_id = $_POST['member_id'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "insert into review_list (review_date, member_id, product_id, review) values (NOW(), '$member_id', $product_id, '$product_review')");

if(!$ret)
{
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{
	mysqli_query($conn, "commit");
    s_msg ('SUCCESSFULLY UPLOADED');
    echo "<meta http-equiv='refresh' content='0;url=review_list.php?r_ID=$product_id'>";
}

?>


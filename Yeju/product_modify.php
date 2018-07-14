<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_desc = $_POST['product_desc'];
$manufacturer_id = $_POST['manufacturer_id'];
$price = $_POST['price'];
$move = $_COOKIE['cookie_id'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "update product set product_name = '$product_name', description = '$product_desc', manufacturer_id = $manufacturer_id, price = $price where product_id = $product_id");


if(!$ret){
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else{
	$query =  "select * from product natural join manufacturer where product_id = $product_id";
	$res = mysqli_query($conn, $query);
	
	if(!$res) {
		mysqli_query($conn, "rollback");
	}
	else {
		mysqli_query($conn, "commit");
		$product = mysqli_fetch_array($res);
    	s_msg ('제품번호 '.$product['product_id'].' 제품명 '.$product['product_name'].' 제조사 '.$product['manufacturer_name'].' 제품이 성공적으로 수정 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=my_product.php?my_ID=$move'>";
	}
}

?>


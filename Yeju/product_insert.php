<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$product_name = $_POST['product_name'];
$product_desc = $_POST['product_desc'];
$manufacturer_id = $_POST['manufacturer_id'];
$price = $_POST['price'];
$owner = $_POST['owner'];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level serializable");
mysqli_query($conn, "begin");

$ret = mysqli_query($conn, "insert into product (product_name, description, manufacturer_id, price, added_date_time, owner) values('$product_name', '$product_desc', '$manufacturer_id', '$price', NOW(), '$owner')");


if(!$ret){
	mysqli_query($conn, "rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else{
	
	$query =  "select * from product natural join manufacturer where product_name = '$product_name' and added_date_time = NOW()";
	$res = mysqli_query($conn, $query);
	
	if(!$res) {
		mysqli_query($conn, "rollback");
	}
	
	else {
		mysqli_query($conn, "commit");
		$product = mysqli_fetch_array($res);
		s_msg ('제품번호 '.$product['product_id'].' 제품명 '.$product['product_name'].' 제조사 '.$product['manufacturer_name'].' 제품이 성공적으로 입력 되었습니다');
    	echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
	}
}

?>


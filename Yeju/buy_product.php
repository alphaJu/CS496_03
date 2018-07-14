<? include ("header.php"); 
error_reporting(E_ALL);

ini_set("display_errors", 1);
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$check = $_GET["ID"];

mysqli_query($connect, "set autocommit = 0");
mysqli_query($connect, "set transaction isolation level read committed");
mysqli_query($connect, "begin");

$ret = mysqli_query($connect, "select * from product where product_id = $check");
if (!$ret) {
	mysqli_query($connect, "rollback");
	msg('불러오기가 실패하였습니다. 다시 시도하여 주십시오.');
}

else {
	mysqli_query($connect, "commit");
}
$row=mysqli_fetch_array($ret);
?>

<form name='form' method='post' action='order_insert.php'>
	<div class="box">
		<table class="table table-striped table-bordered">
			<tr>
				
				<th style="border: 1px solid purple" width="20%" scope="col">ID</th>
				<th style="border: 1px solid purple" width="20%" scope="col">PRODUCT</th>
				<th style="border: 1px solid purple" width="20%" scope="col">PRICE</th>
				<th style="border: 1px solid purple" width="20%" scope="col">QUANTITY</th>
			</tr>
<?php

echo " <tr>
	<th style='border: 1px solid purple' width='20%' scope='col'>$row[0]</th>
	<th style='border: 1px solid purple' width='20%' scope='col'>$row[1]</th>
	<th style='border: 1px solid purple' width='20%' scope='col'>$row[4]</th> 
	<th style='border: 1px solid purple' width='20%' scope='col'>
	<input type='text' name='count' value = '1' size=‘3'/></th>
	</tr>
	<input type='hidden' name='product_id' value='$row[0]'/>
	<input type='hidden' name='price' value='$row[4]'/>";
 ?>
		</table>
<input type="submit" name="button" value="ORDER"/>
</div> </form>
<? include ("footer.php") ?>
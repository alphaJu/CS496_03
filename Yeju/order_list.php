<?php 
include ("header.php");
include "config.php"; //데이터베이스 연결 설정파일 
include "util.php"; //유틸 함수
error_reporting(E_ALL);

ini_set("display_errors", 1);
if (!array_key_exists("ID", $_GET)) {
    msg("로그인 후 이용해주세요.");
}
$connect = dbconnect($host,$dbid,$dbpass,$dbname);
$check = $_GET["ID"];

mysqli_query($connect, "set autocommit = 0");
mysqli_query($connect, "set transaction isolation level read committed");
mysqli_query($connect, "begin");

$ret = mysqli_query($connect, "select * from order_list natural join product where member_id = '$check'");
if (!$ret) {
 	mysqli_query($connect, "rollback");
    die('Query Error : ' . mysqli_error());
}
else {
	mysqli_query($connect, "commit");
}
?>
<div id="page" class="container">
	<h1>ORDER LIST</h1></br>
	<table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>ORDER DATE</th>
            <th>PRODUCT</th>
            <th>QUANTITY</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($ret)) {
            echo "<tr>";
            echo "<td>{$row['order_id']}</td>";
            echo "<td>{$row['order_date']}</td>";
            echo "<td><a href='product_view.php?product_id={$row['product_id']}'>{$row['product_name']}</a></td>";
            echo "<td>{$row['quantity']}</td>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>	
</div>



<?include ("footer.php") ?>

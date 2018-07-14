<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

   error_reporting(E_ALL);

ini_set("display_errors", 1);
?>

<div id="page" class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    
    mysqli_query($conn, "set autocommit = 0");
	mysqli_query($conn, "set transaction isolation level read committed");
	mysqli_query($conn, "begin");
    
    $query = "select * from product natural join manufacturer";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where product_name like '%$search_keyword%' or manufacturer_name like '%$search_keyword%'";
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
    	mysqli_query($conn, "rollback");
        die('Query Error : ' . mysqli_error());
    }
    else {
    	mysqli_query($conn, "commit");
    }
    ?>
	<h1>PRODUCTS</h1></br></br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>PRODUCT ID</th>
            <th>MANUFACTURER</th>
            <th>PRODUCT</th>
            <th>PRICE</th>
            <th>REGISTERED DATE</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row['product_id']}</td>";
            echo "<td>{$row['manufacturer_name']}</td>";
            echo "<td><a href='product_view.php?product_id={$row['product_id']}'>{$row['product_name']}</a></td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>{$row['added_date_time']}</td>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
</div>
<? include("footer.php") ?>

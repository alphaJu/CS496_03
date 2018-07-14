<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

   error_reporting(E_ALL);

ini_set("display_errors", 1);
?>

<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $product_id = $_GET["r_ID"];
    
    mysqli_query($conn, "set autocommit = 0");
	mysqli_query($conn, "set transaction isolation level read committed");
	mysqli_query($conn, "begin");
    
    $query = "select * from product natural join review_list natural join member where product_id = '$product_id'";
    
    $res = mysqli_query($conn, $query);
    if (!$res) {
    	mysqli_query($conn, "rollback");
        die('Query Error : ' . mysqli_error());
    }
    else {
    	mysqli_query($conn, "commit");
    }
    ?>
	<h1>REVIEWS</h1></br></br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>PRODUCT</th>
            <th>CONSUMER</th>
            <th>REVIEWD DATE</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td><a href='review_view.php?review_id={$row['review_id']}'>{$row['product_name']}</a></td>";
            echo "<td>{$row['member_name']}</td>";
            echo "<td>{$row['review_date']}</td>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
</div>
<? include("footer.php") ?>

<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
 $move = $_COOKIE['cookie_id'];
if (!$move) {
    msg("LOGIN PLEASE.");
}
$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "REWRITE";
$action = "review_modify.php";

$product_id = $_GET["p_ID"];

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read committed");
mysqli_query($conn, "begin");

$query3 = "select * from order_list where member_id ='$move' and product_id = $product_id";
$res3 = mysqli_query($conn, $query3);

if(!$res3) {
	mysqli_query($conn, "rollback");
}
else {
	$didBuy = mysqli_fetch_array($res3);
	if(!$didBuy) {
		mysqli_query($conn, "commit");
		msg('AUTHORIZATION FAILED.');
	}
	$query =  "select * from (review_list natural join product) natural join member where product_id = $product_id and member_id = '$move'";
	$res = mysqli_query($conn, $query);
	if(!$res) {
		mysqli_query($conn, "rollback");
	}
	else {
		$review = mysqli_fetch_array($res);
		if(!$review) {
    		$mode = "WRITE";
    		$action = "review_insert.php";
		}
		$query2 = "select * from product where product_id = $product_id";
		$res2 = mysqli_query($conn, $query2);

		if(!$res2) {
			mysqli_query($conn, "rollback");
		}
		else {
			mysqli_query($conn, "commit");
			$product = mysqli_fetch_array($res2);
		}
	}
}


?>
    <div id="page" class="container">
        <form name="review_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="product_id" value="<?=$product_id?>"/>
            <input type="hidden" name="member_id" value="<?=$move?>"/>
            <h1><?=$mode?> PRODUCT RIVEW</h1></br></br>
            <p>
                <label for="product_name">PRODUCT</label>
                <input readonly type="text" id="product_name" name="product_name" value="<?=$product['product_name'] ?>"/>
            </p>
            <p>
                <label for="product_review">REVIEW</label>
                <textarea class="form-control" placeholder="WRITE REVIEW" id="product_review" name="product_review" rows="10"><?=$review['review']?></textarea>
            </p>

            <p align="center"><button class="button" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("product_review").value == "") {
                        alert ("PLEASE WRITE REVIEW"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>
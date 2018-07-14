<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);
if (array_key_exists("review_id", $_GET)) {
    $review_id = $_GET["review_id"];
    
    mysqli_query($conn, "set autocommit = 0");
	mysqli_query($conn, "set transaction isolation level read committed");
	mysqli_query($conn, "begin");
    
    $query = "select * from (product natural join review_list) natural join member where review_id = $review_id";
    $res = mysqli_query($conn, $query);
    
    if(!$res) {
    	mysqli_query($conn, "rollback");
    }
    else {
    	mysqli_query($conn, "commit");
    }
    
    $review = mysqli_fetch_assoc($res);
    $product_id = $review['product_id'];
    if (!$review) {
        msg("NO REVIEW.");
    }
}
?>
    <div class="container fullwidth">
        <h3>PRODUCT REVIEW</h3>
        <p>
            <label for="product_id">PRODUCT ID</label>
            <input readonly type="text" id="product_id" name="product_id" value="<?= $review['product_id'] ?>"/>
        </p>

        <p>
            <label for="product_name">PRODUCT NAME</label>
            <input readonly type="text" id="product_name" name="product_name" value="<?= $review['product_name'] ?>"/>
        </p>
        
		<p>
            <label for="member_name">CONSUMER</label>
            <input readonly type="text" id="member_name" name="member_name" value="<?= $review['member_name'] ?>"/>
        </p>
        
        <p>
            <label for="product_review">REVIEW</label>
            <textarea class="form-control" readonly id="product_review" name="product_review" rows="10"><?= $review['review'] ?></textarea>
        </p>
<?php
		$m = 0;
		$d = 1;
		
		echo "<p><a href='review_auth.php?p_ID={$product_id}&m_ID={$review['member_id']}&mode={$m}'><button class='button primary large'>REWRITE</button></a></p>";
	//	 echo "<button onclick='javascript:deleteConfirm({$review['review_id']}, {$review['member_id']}, $d)' class='button danger large'>후기삭제</button>";
		echo "<p><a href='review_auth.php?p_ID={$product_id}&r_ID={$review['review_id']}&m_ID={$review['member_id']}&mode={$d}'><button class='button danger large'>DELETE</button></a></p>";
	//echo "<button onclick='javascript:deleteConfirm({$review['review_id']})' class='button danger large'>후기삭제</button>";
		?>
    </div>
    
    
   

<? include("footer.php") ?>
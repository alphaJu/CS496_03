<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("product_id", $_GET)) {
    $product_id = $_GET["product_id"];
    
    mysqli_query($conn, "set autocommit = 0");
	mysqli_query($conn, "set transaction isolation level serializable");
	mysqli_query($conn, "begin");
    
    $query = "select * from product natural join manufacturer where product_id = $product_id";
    $res = mysqli_query($conn, $query);
    
    if(!$res) {
    	mysqli_query($conn, "rollback");
    }
    else {
    	mysqli_query($conn, "commit");
    }
    
    $product = mysqli_fetch_assoc($res);
    if (!$product) {
        msg("PRODUCT DOESN'T EXIST.");
    }
}
$product_id = $_GET["product_id"];
$move = $_COOKIE[cookie_id];
?>
    <div class="container fullwidth">
        <h1>DETAILS</h1></br>
        <?php echo "<p align='right'><a href='buy_product.php?ID={$product_id}'><button class='button'>BUY</button></a></p>";?>
		<div class="form-group">
			<label for="product_id">PRODUCT ID</label>
            <input class="form-control" readonly type="text" id="product_id" name="product_id" value="<?= $product['product_id'] ?>"/>
		</div>
		<div class="form-group">
			<label for="manufacturer_id">MANUFACTURER ID</label>
            <input class="form-control" readonly type="text" id="manufacturer_id" name="manufacturer_id" value="<?= $product['manufacturer_id'] ?>"/>
		</div>
		<div class="form-group">
			<label for="manufacturer_name">MANUFACTURER</label>
            <input class="form-control" readonly type="text" id="manufacturer_name" name="manufacturer_name" value="<?= $product['manufacturer_name'] ?>"/>
		</div>
		<div class="form-group">
			 <label for="product_name">PRODUCT</label>
            <input class="form-control" readonly type="text" id="product_name" name="product_name" value="<?= $product['product_name'] ?>"/>
		</div>
		<div class="form-group">
			 <label for="product_desc">PRODUCT DESCRIPTION</label>
            <textarea class="form-control" readonly id="product_desc" name="product_desc" rows="10"><?= $product['description'] ?></textarea>
		</div>
		<div class="form-group">
			 <label for="price">PRICE</label>
            <input class="form-control" readonly type="number" id="price" name="price" value="<?= $product['price'] ?>"/>
		</div>
        
		<?php echo "<p align='center'><a href='review_form.php?p_ID={$product_id}'><button class='button'>WRITE REVIEW</button></a></p>";?>
		<?php echo "<p align='center'><a href='review_list.php?r_ID={$product_id}'><button class='button'>SHOW REVIEW</button></a></p>";?>
    </div>
    
   

<? include("footer.php") ?>
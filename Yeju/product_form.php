<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
 $move = $_COOKIE[cookie_id];
if (!$move) {
    msg("LOGIN PLEASE.");
}
$conn = dbconnect($host, $dbid, $dbpass, $dbname);
$mode = "REGISTER";
$action = "product_insert.php";

mysqli_query($conn, "set autocommit = 0");
mysqli_query($conn, "set transaction isolation level read committed");
mysqli_query($conn, "begin");

if (array_key_exists("product_id", $_GET)) {
    $product_id = $_GET["product_id"];
    $query =  "select * from product where product_id = $product_id";
    $res = mysqli_query($conn, $query);
    
    if(!$res) {
    	mysqli_query($conn, "rollback");
    }
    else {
    	$product = mysqli_fetch_array($res);
    	if(!$product) {
        	msg("PRODUCT DOESN'T EXIST.");
    	}
    	$mode = "UPDATE";
    	$action = "product_modify.php";
    	
    	$manufacturers = array();
		$query = "select * from manufacturer";
		$res = mysqli_query($conn, $query);

		if(!$res) {
			mysqli_query($conn, "rollback");
		}

		else {
			mysqli_query($conn, "commit");
		}

		while($row = mysqli_fetch_array($res)) {
    		$manufacturers[$row['manufacturer_id']] = $row['manufacturer_name'];
		}
    }
}

else {
	$manufacturers = array();
	$query = "select * from manufacturer";
	$res = mysqli_query($conn, $query);

	if(!$res) {
		mysqli_query($conn, "rollback");
	}

	else {
		mysqli_query($conn, "commit");
	}	

	while($row = mysqli_fetch_array($res)) {
    	$manufacturers[$row['manufacturer_id']] = $row['manufacturer_name'];
	}
}

?>
    <div id="page" class="container">
        <form name="product_form" action="<?=$action?>" method="post" class="form-group">
            <input type="hidden" name="product_id" value="<?=$product['product_id']?>"/>
            <input type="hidden" name="owner" value="<?=$move?>"/>
            <h1> <?=$mode?> PRODUCT INFO</h1></br>
            <div class="form-group">
            	<label for="manufacturer_id">MANUFACTURER</label>
                <select class="form-control" name="manufacturer_id" id="manufacturer_id">
                    <option value="0">PLEASE SELECT.</option>
                    <?
                        foreach($manufacturers as $id => $name) {
                            if($id == $product['manufacturer_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
            	<label for="product_name">PRODUCT NAME</label>
                <input class="form-control" type="text" placeholder="PRODUCT NAME" id="product_name" name="product_name" value="<?=$product['product_name']?>"/>
            </div>
            <div class="form-group">
            	<label for="product_desc">PRODUCT INFO</label>
                <textarea class="form-control" placeholder="PRODUCT INFO" id="product_desc" name="product_desc" rows="10"><?=$product['description']?></textarea>
            </div>
            <div class="form-group">
            	<label for="price">PRICE</label>
                <input class="form-control" type="number" placeholder="ONLY INTEGER" id="price" name="price" value="<?=$product['price']?>" />
            </div>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>
			
            <script>
                function validate() {
                    if(document.getElementById("manufacturer_id").value == "0") {
                        alert ("PLEASE SELECT MANUFACTURER"); return false;
                    }
                    else if(document.getElementById("product_name").value == "") {
                        alert ("WHAT'S THE NAME OF THIS PRODUCT?"); return false;
                    }
                    else if(document.getElementById("product_desc").value == "") {
                        alert ("PLEASE DESCRIBE THIS PRODUCT"); return false;
                    }
                    else if(document.getElementById("price").value == "") {
                        alert ("HOW MUCH IS IT?"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>
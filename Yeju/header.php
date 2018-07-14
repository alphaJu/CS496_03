<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : Effeminate 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20140123

-->
<html lang='ko'>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>YEJU SHOP</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" href="css/bootstrap.css">
<link href="http://fonts.googleapis.com/css?family=Varela" rel="stylesheet" />
<link href="default.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>

	<div id="wrapper">
		<div id="header" class="container">
			<div id="logo">
				<h1><a href="index.php">YEJU SHOP</a></h1>
			</div>
			<div id="menu">
				<ul>
    				<li><a href='product_list.php'>BUY</a></li>
            		<li><a href='product_form.php'>SELL</a></li>
                	<?php
                	$move = $_COOKIE['cookie_id'];
                		if(!$_COOKIE['cookie_id'] || !$_COOKIE['cookie_name']) {
                			echo "<li><a href='join.php'>JOIN</a></li>
                			<li><a href='login.php'>LOGIN</a></li>
                			<li><a href='order_list.php'>ORDER LIST</a></li>";
                		}
                		else {
                			echo"<li><a href='join_form.php?ID={$move}'>MY INFO</a></li>
                			<li><a href='logout.php'>LOGOUT</a></li>
                			<li><a href='order_list.php?ID={$move}'>ORDER LIST</a></li>";
                		}
                	?>
    			</ul>
			</div>
		 </div>

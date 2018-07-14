<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
$myID = $_COOKIE['cookie_id'];
$p_ID = $_GET["p_ID"];
$m_ID = $_GET["m_ID"];
$r_ID = $_GET["r_ID"];
$mode = $_GET["mode"];
if($myID!=$m_ID) {
	msg('AUTHORIZATION FAILED.');
}
else {
	if($mode == 0) {
		echo "<meta http-equiv='refresh' content='0;url=review_form.php?p_ID=$p_ID'>";
	}
	else if($mode == 1) {
		echo "<meta http-equiv='refresh' content='0;url=review_delete.php?r_id=$r_ID&p_id=$p_ID'>";
	}
}


?>
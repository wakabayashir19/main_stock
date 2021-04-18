<?php
class Checksalescls{

/*-----------   checksales関数  ----------*/
/*現時点での総売上表示関数*/
public function checksales(){

global $dsn,$user,$password;
 /*mysqlに接続*/
$pdo = new PDO($dsn,$user,$password);


/*総売上データを取得*/
$sql_checksales = "SELECT * from price where id=1";
$stmt_checksales = $pdo->query($sql_checksales);

/*総売上データを変数に格納*/
$result_checksales = $stmt_checksales->fetch(PDO::FETCH_ASSOC);

/*総売上データの表示*/
echo 'sales: '.round($result_checksales['total_price'],2);
}



}



?>

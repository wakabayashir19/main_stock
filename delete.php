<?php
class Deletecls{

/*-----------   deleteall関数  ----------- */
/*'stock_db'データベースに存在する全てのテーブルを削除する関数*/
public function deleteall(){
/*$pdo = new PDO('mysql:dbname=stock_db;host=127.0.0.1;charset=utf8mb4','root','');*/

global $dsn,$user,$password;
 /*mysqlに接続*/
$pdo = new PDO($dsn,$user,$password);


/*既存のテーブルを検索し、データとして取得*/
$stmt_search = $pdo->query("show tables");
$result_search = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

/*'stock_db'データベースに存在する全てのテーブルを削除*/
for($i=0 ; $i<count($result_search) ; $i++){
$sql_deleteall = "drop table ".$result_search[$i]['Tables_in_stock_db'];
$stmt_deleteall = $pdo->query($sql_deleteall);
}

}

}


?>
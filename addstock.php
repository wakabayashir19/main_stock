<?php
class Addstockcls{
public function addstock($add_name,$add_amount){

$this->add_name = $add_name;
$this->add_amount = $add_amount;

global $dsn,$user,$password;

/*mysqlに接続*/
$pdo = new PDO($dsn,$user,$password);



/*mysqlにstockテーブル(商品名・商品数を管理しているテーブル)が存在しなければ作成
*/
$res_create_add = $pdo->query("create table if not exists stock(name varchar(8),amount int)ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");

/*引数で受け取った商品名が在庫に既存かを確認し、データを取得*/
$sql_add_check = "SELECT * from stock where name=:name";
$stmt_add_check = $pdo->prepare($sql_add_check);
$stmt_add_check->bindParam(':name',$add_name,PDO::PARAM_STR);
$stmt_add_check->execute();

/*商品データを変数に格納*/
$result_add = $stmt_add_check->fetch(PDO::FETCH_ASSOC);

/*引数で受け取った商品名が存在しない時、引数で受け取った商品名・商品数データを追
>加*/
if(is_null($result_add['name'])){
$sql_insert = "INSERT INTO stock(name,amount) VALUES(:name,:amount)";
$stmt_insert = $pdo->prepare($sql_insert);
$stmt_insert->bindParam(':name',$add_name,PDO::PARAM_STR);
$stmt_insert->bindValue(':amount',$add_amount,PDO::PARAM_INT);
$res_insert=$stmt_insert->execute();

/*引数で受け取った商品名が既存の時、引数で受け取った商品数だけ既存データに加えて
>更新*/
}elseif(isset($result_add['name'])){

    $result_add['amount'] = intval($result_add['amount']) + $add_amount;
    
    
    $sql_update = "update stock set amount=:amount where name=:name";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':name',$add_name,PDO::PARAM_STR);
    $stmt_update->bindValue(':amount',$result_add['amount'],PDO::PARAM_INT);
    $stmt_update->execute();
    }
    
    }
    
    
    
    }
    
    
    ?>
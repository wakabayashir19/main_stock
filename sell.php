<?php
class Sellcls{

/*-----sell_all関数------*/
/*販売関数(URLクエリパラメータで'price'が指定されている時)*/
public function sell_all($sell_name,$sell_amount,$sell_price){

$this->sell_name = $sell_name;
$this->sell_amount = $sell_amount;
$this->sell_price = $sell_price;

global $dsn,$user,$password;
 /*mysqlに接続*/
$pdo = new PDO($dsn,$user,$password);

/*mysqlにpriceテーブル(総売上を管理しているテーブル)が存在しなければ作成*/
$res_create_sell = $pdo->query("create table if not exists price(id int,total_price float)");


$sql_sell = "SELECT * from stock where name=:name";
$stmt_sell = $pdo->prepare($sql_sell);
$stmt_sell->bindParam(':name',$sell_name,PDO::PARAM_STR);
$x = $stmt_sell->execute();


$sql_price = "SELECT * from price";
$stmt_price = $pdo->query($sql_price);
$result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);


/*商品データを変数に格納*/
$result_sell = $stmt_sell->fetch(PDO::FETCH_ASSOC);

if(isset($result_sell['name'])){

    #amountの更新
    $result_sell['amount'] = intval($result_sell['amount']) - $sell_amount;
    $sql_update = "update stock set amount=:amount where name=:name";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':name',$sell_name,PDO::PARAM_STR);
    $stmt_update->bindValue(':amount',$result_sell['amount'],PDO::PARAM_INT);
    $stmt_update->execute();
    
    
    if(empty($result_price)){
    $sql_insert = "INSERT INTO price(id,total_price) VALUES(1,:total_price)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindValue(':total_price',$sell_amount*$sell_price,PDO::PARAM_INT);
    $res_insert=$stmt_insert->execute();
    
    
    }elseif(isset($result_price)){
    
    #total_priceの更新
     $result_price['total_price'] = floatval($result_price['total_price']) + floatval($sell_amount*$sell_price);
     $sql_update = "update price set total_price=:total_price where id=1";
     $stmt_update = $pdo->prepare($sql_update);
     $stmt_update->bindValue(':total_price',$result_price['total_price'],PDO::PARAM_INT);
     $stmt_update->execute();
    
    
    }
    
    
    
    }else{
    exit('データがありません');
    }
    
    }
    
    
    /*-----sell_amount関数------*/
/*販売関数(URLクエリパラメータで'price'が指定されていない時)*/
public function sell_amount($sell_name,$sell_amount){

    $this->sell_name = $sell_name;
    $this->sell_amount = $sell_amount;
    
    global $dsn,$user,$password;
     /*mysqlに接続*/
    $pdo = new PDO($dsn,$user,$password);
    
    
    $sql_sell = "SELECT * from stock where name=:name";
    $stmt_sell = $pdo->prepare($sql_sell);
    $stmt_sell->bindParam(':name',$sell_name,PDO::PARAM_STR);
    $x = $stmt_sell->execute();
    
    $result_sell = $stmt_sell->fetch(PDO::FETCH_ASSOC);
    
    if(isset($result_sell['name'])){
    
    #amountの更新
    $result_sell['amount'] = intval($result_sell['amount']) - $sell_amount;
    $sql_update = "update stock set amount=:amount where name=:name";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':name',$sell_name,PDO::PARAM_STR);
    $stmt_update->bindValue(':amount',$result_sell['amount'],PDO::PARAM_INT);
    $stmt_update->execute();
    
    
    
    }
    
    }
    
    }/*クラスの終わり*/
    
    
    ?>
    
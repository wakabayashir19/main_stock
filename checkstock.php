<?php
class Checkstockcls{

/*-----------   checkstock関数   ----------*/
/*対象の商品と商品数を表示関数*/
public function checkstock($check_name){

$this->check_name = $check_name;

global $dsn,$user,$password;

/*mysqlに接続*/
$pdo = new PDO($dsn,$user,$password);


/*引数で受け取った商品名のデータ取得*/
$sql_checkstock = "SELECT * from stock where name=:name";

$stmt_checkstock = $pdo->prepare($sql_checkstock);
$stmt_checkstock->bindParam(':name',$check_name,PDO::PARAM_STR);
$stmt_checkstock->execute();

/*商品データを変数に格納*/
$result_checkstock = $stmt_checkstock->fetch(PDO::FETCH_ASSOC);

/*商品データを表示*/
echo $result_checkstock['name'].': '.$result_checkstock['amount'];
}

/*---------   checkstock_all関数  --------*/
/*全商品とそれらの商品数表示関数*/
public function checkstock_all(){

    global $dsn,$user,$password;
     /*mysqlに接続*/
    $pdo = new PDO($dsn,$user,$password);
    
    /*全商品名とそれらの商品数データを取得*/
    $sql_checkstock_all = "SELECT * from stock where amount !=0 order by name";
    
    
    $stmt_checkstock_all = $pdo->query($sql_checkstock_all);
    
    
    
    /*全商品とそれらの商品数データを変数に格納*/
    if($stmt_checkstock_all){
    $result_checkstock_all = $stmt_checkstock_all->fetchAll(PDO::FETCH_ASSOC);
    }else{
    exit('データが存在しません');
    }
    
    /*全商品とそれらの商品数データの表示*/
      for($i=0 ; $i<count($result_checkstock_all) ; $i++){
        echo $result_checkstock_all[$i]['name'].': '.$result_checkstock_all[$i]['amount']."\n";
      }
    }
    
    }/*classの終わり*/
    
    
    
    ?>
    
    
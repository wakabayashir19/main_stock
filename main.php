<?php

/*エラー表示*/
ini_set("display_errors","On");

############ クラス ##############

require 'check.php';
require 'addstock.php';
require 'checkstock.php';
require 'sell.php';
require 'checksales.php';
require 'delete.php';


#############    URL    ###############

/*parse_url でURLを分解してクエリパラメータのみ取得*/
$url= (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

/*指定したクエリパラメータを、変数に格納*/
parse_str(parse_url($url,PHP_URL_QUERY),$query);


/*functionの予期せぬ値判定*/
if($query['function'] != 'addstock' && $query['function'] != 'checkstock' && $query['function'] != 'sell' && $query['function'] != 'checksales' && $query['function'] != 'deleteall'){
exit('ERROR function name');
}


#############    main関数    ##############


/*-------------  mysql 初期値 ---------*/
$dsn = 'mysql:dbname=stock_db;host=127.0.0.1';
$user = 'root';
$password = '067506kK!';


/*------------- 初期値のcheck -----------*/
$check_instance = new Checkfunc();





/*-------  addstock時の処理-------*/
/*URLクエリパラメータの'function = addstock'時の処理*/

/*URLクエリパラメータの'amount'が指定されている時*/
switch(true){
  case $query['function'] === 'addstock' && isset($query['name']) :
    if(isset($query['amount'])){

      /*nameの型・文字数が想定通りかをチェック*/
      $check_instance->name_check($query['name']);

      /*amountの型・値の大きさが想定通りかを判定する関数*/
      $amount_numeric = $check_instance->amount_check($query['amount']);

      /*在庫追加(amount指定あり)*/
      $add_instance = new Addstockcls();
      $add_instance->addstock($query['name'],$amount_numeric);

      }else{
      /*在庫追加(amount指定なし)*/

      /*nameの型・文字数が想定通りかをチェック*/
      $check_instance->name_check($query['name']);

      $add_instance = new Addstockcls();
      $add_instance->addstock($query['name'],1);

      }
  break;


  case $query['function'] === 'checkstock' :
    if(isset($query['name'])){

      /*nameの型・文字数が想定通りかをチェック*/
      $check_instance->name_check($query['name']);

      $checkstock_instance = new Checkstockcls();
      $checkstock_instance->checkstock($query['name']);

    }else{
      $checkstock_instance = new Checkstockcls();
      $checkstock_instance->checkstock_all();

    }


    case $query['function'] === 'sell' && isset($query['name']) :
        if(isset($query['amount']) && isset($query['price'])){
          /*nameの型・文字数が想定通りかをチェック*/
          $check_instance->name_check($query['name']);
    
          /*amountの型・値の大きさが想定通りかを判定する関数*/
          $check_instance->amount_check($query['amount']);
    
          /*priceの型・値の大きさ判定*/
          $check_instance->price_check($query['price']);
    
          $sell_instance = new Sellcls();
          $sell_instance->sell_all($query['name'],$query['amount'],$query['price']);
    
    
        }elseif(isset($query['amount']) && empty($query['price'])){
          /*nameの型・文字数が想定通りかをチェック*/
          $check_instance->name_check($query['name']);
    
          /*amountの型・値の大きさが想定通りかを判定する関数*/
          $check_instance->amount_check($query['amount']);
    
          $sell_instance = new Sellcls();
          $sell_instance->sell_amount($query['name'],$query['amount']);
    
    
        }elseif(empty($query['amount']) && isset($query['price'])){
          /*nameの型・文字数が想定通りかをチェック*/
          $check_instance->name_check($query['name']);
    
          /*priceの型・値の大きさ判定*/
          $check_instance->price_check($query['price']);
    
          $sell_instance = new Sellcls();
          $sell_instance->sell_all($query['name'],1,$query['price']);
    
    
        }
      break;
    
      case $query['function'] === 'checksales' :
        $sales_instance = new Checksalescls();
        $sales_instance->checksales();
      break;
    
      case $query['function'] === 'deleteall' :
        $delete_instance = new Deletecls();
        $delete_instance->deleteall();
      break;
    
    
    }
?>
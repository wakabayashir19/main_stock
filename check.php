<?php
class Checkfunc{

/*-----name 型・文字数チェック関数------*/
/*nameの型・文字数が想定通りかを判定する関数*/
public function name_check($name){

$this->name = $name;

if(strlen($name)>8 || is_string($name)==false){
exit('ERROR name type');
}
}




/*-----amount 型チェック関数------*/
/*amountの型・値の大きさが想定通りかを判定する関数*/
public function amount_check($amount){

$this->amount = $amount;
if(is_int(eval("return {$amount};"))){
return eval("return {$amount};");

}else{
exit('ERROR amount 型が違っています');
}
}

/*-----price チェック関数------*/
/*priceの値の大きさが想定通りかを判定する関数*/
public function price_check($price){

$this->price = $price;
if(is_int(eval("return {$price};")) || is_float(eval("return {$price};"))){
$price_numeric = eval("return {$price};");
}else{
exit('ERROR price 型が違っています');
}
if($price_numeric <=0){
exit('ERROR price 0より大きい数値にしてください');
}
}


}
?>

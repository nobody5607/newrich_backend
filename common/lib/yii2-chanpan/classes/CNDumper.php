<?php
 
namespace cpn\chanpan\classes;
 
class CNDumper {
    /**
     * 
     * @param type $var
     */
   public static function dump($var){
       \yii\helpers\VarDumper::dump($var, 10, true);exit();
   }
}

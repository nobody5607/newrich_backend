<?php

namespace cpn\chanpan\widgets;
use yii\helpers\Html;
use yii\helpers\Url;
class JSlide extends \yii\base\Widget{
    public $image=[
        'src'=>'',
        'content'=>'',
        'options'=>[]
    ];
    public function init() {
        parent::init();
    }
    public function run() {
        parent::run();
        $this->registerScript();
        $this->CssRegister();
        $html = "";
        $html .= Html::beginTag("DIV", ['id'=>'jssor_1']);
        
            $html .= Html::beginTag("DIV", ['class'=>'jssorl-img', 'data-u'=>'slides','id'=>'lightgallery']);
                    foreach($this->image as $key=> $img){
                        $html .= Html::beginTag("DIV",['data-src'=>"{$img['src']}" , 'data-sub-html'=>"{$img['content']}"]);   
                            $this->image['options']['data-u']='image';
                            $html .= Html::a(Html::img($img['src'], $this->image['options']), '#', []);                         
                            $html .= Html::img($img['src'], ['data-u'=>'thumb', 'id'=>'chanpan'.$key]);                      
                        $html .= Html::endTag("DIV");
                    }
            $html .= Html::endTag("DIV");
            
            /* Thumbnail Navigator */            
            $html .= Html::beginTag("DIV", ['class'=>'jssort101', 'data-u'=>'thumbnavigator','data-autocenter'=>"2",'data-scale-left'=>"0.75", "style"=>"position:absolute;left:0px;top:0px;width:240px;height:480px;background-color:#fff;"]);
                $html .= Html::beginTag("DIV" ,['data-u'=>'slides']);
                    $html .= Html::beginTag("DIV" ,['data-u'=>'prototype', 'class'=>'p', 'style'=>'width:99px;height:66px;']);
                        $html .= Html::tag("DIV", "", ['data-u'=>'thumbnailtemplate', 'class'=>'t']);
                        $html .= Html::beginTag("svg" ,['viewBox'=>'0 0 16000 16000', 'class'=>'cv']);
                            $html .= Html::tag("circle", "", ['class'=>"a" ,'cx'=>"8000" ,'cy'=>"8000" ,'r'=>"3238.1"]);
                            $html .= Html::tag("line", "", ['class'=>"a" ,'x1'=>"6190.5", 'y1'=>"8000", 'x2'=>"9809.5" ,'y2'=>"8000"]);
                            $html .= Html::tag("line", "", ['class'=>"a" ,'x1'=>"8000", 'y1'=>"9809.5", 'x2'=>"8000" ,'y2'=>"6190.5"]);
                        $html .= Html::endTag("svg");
                    $html .= Html::endTag("DIV");
                $html .= Html::endTag("DIV");
            $html .= Html::endTag("DIV");
            
          /*Arrow Navigator*/  
            $html .= Html::beginTag("DIV", ['data-u'=>"arrowleft", 'class'=>"jssora093", 'style'=>"width:50px;height:50px;top:0px;left:270px;" ,'data-autocenter'=>"2"]);
                 $html .= Html::beginTag("svg", ['viewBox'=>"0 0 16000 16000", 'style'=>"position:absolute;top:0;left:0;width:100%;height:100%;"]);
                    $html .= Html::tag("circle", "", ['class'=>"c", 'cx'=>"8000", 'cy'=>"8000", 'r'=>"5920"]);
                    $html .= Html::tag("polyline", "", ['class'=>"a", 'points'=>"7777.8,6080 5857.8,8000 7777.8,9920 "]);
                    $html .= Html::tag("line", "", ['class'=>"a", 'x1'=>"10142.2", 'y1'=>"8000", 'x2'=>"5857.8", 'y2'=>"8000"]);
                 $html .= Html::endTag("svg");
            $html .= Html::endTag("DIV");
            
            $html .= Html::beginTag("DIV", ['data-u'=>"arrowright", 'class'=>"jssora093", 'style'=>"width:50px;height:50px;top:0px;right:30px;" ,'data-autocenter'=>"2"]);
                 $html .= Html::beginTag("svg", ['viewBox'=>"0 0 16000 16000", 'style'=>"position:absolute;top:0;left:0;width:100%;height:100%;"]);
                    $html .= Html::tag("circle", "", ['class'=>"c", 'cx'=>"8000", 'cy'=>"8000", 'r'=>"5920"]);
                    $html .= Html::tag("polyline", "", ['class'=>"a", 'points'=>"8222.2,6080 10142.2,8000 8222.2,9920 "]);
                    $html .= Html::tag("line", "", ['class'=>"a", 'x1'=>"5857.8", 'y1'=>"8000", 'x2'=>"10142.2", 'y2'=>"8000"]);
                 $html .= Html::endTag("svg");
            $html .= Html::endTag("DIV");
        
        $html .= Html::endTag("DIV");
        echo $html;
        
    }
    public function registerScript(){
        $view = $this->getView();
        \cpn\chanpan\assets\jslide\JSlideAsset::register($view);
        $js="$('#lightgallery').lightGallery();";
        $view->registerJs($js);
        
    }
    public function CssRegister(){
       $view = $this->getView();
       $css="
           #jssor_1{
                position:relative;
                margin:0 auto;
                top:0px;
                left:0px;
                width:960px;
                height:480px;
                overflow:hidden;
                visibility:hidden;
                background-color:#24262e;
            }
           .jssorl-img{
                cursor:default;
                position:relative;
                top:0px;
                left:240px;
                width:720px;
                height:480px;
                overflow:hidden;
            }
           .jssort101{
                position:absolute;
                left:0px;
                top:0px;
                width:240px;
                height:480px;
                background-color:#000;
            }
        ";
       $view->registerCss($css);
    }
}

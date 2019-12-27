<?php
 
namespace cpn\chanpan\widgets;
use yii\helpers\Html; 
class JLightBox extends \yii\base\Widget{
    //put your code here
    public $image=[
        'src'=>'',
        'content'=>'',
        'options'=>[]
    ];
    public $options; 
    public function init() {
        parent::init();
    }
    public function run() {
        parent::run();
        $html = "";
        $html .= Html::beginTag("DIV", $this->options);
            $html .= Html::beginTag("DIV", ['class'=>'demo-gallery']);
                $html .= Html::beginTag("DIV", ['id'=>'lightgallery']);
                    foreach($this->image as $key=>$value){
                        $html .= Html::beginTag("DIV", ['data-src'=>"{$value['src']}", 'data-sub-html'=>"{$value['content']}"]);
                            $html .= Html::a(Html::img($value['src'], $value['options']), '#', []);
                        $html .= Html::endTag("DIV");
                    }

                $html .= Html::endTag("DIV");         
            $html .= Html::endTag("DIV");
        $html .= Html::endTag("DIV"); 
        $this->registerScript();
        echo $html;
    }
    public function registerScript(){
        $view = $this->getView();
        \cpn\chanpan\assets\jlightbox\JLightBoxAsset::register($view);
        $js="$('#lightgallery').lightGallery();";
        $view->registerJs($js);
    }
}

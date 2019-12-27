<?php

namespace cpn\chanpan\widgets;
use yii\helpers\Url; 

class JHtmlEditor extends \yii\base\Widget{
    public $setting=[];
    public $isUploadImage=FALSE;
    public $isFullPlugin=FALSE;
    public $height="";
    /**
     * echo cpn\chanpan\widgets\JHtmlEditor::widget([
            'isUploadImage'=>true,
            'isFullPlugin'=>true,
            'height'=>100
//            'setting'=>[
//                'minHeight' => 100,
//            ]
        ]);
     */
    public function run() {
        if($this->height != ''){            
            $this->setting['minHeight']= $this->height;
        }
        if($this->isUploadImage){
            $this->setting['imageUpload']=Url::to(['/core/upload/image-upload']);
            $this->setting['imageDelete']=Url::to(['/core/upload/file-delete']);
            $this->setting['imageManagerJson']=Url::to(['/core/upload/images-get']);
            //$this->setting['setting']['plugins']['imagemanager']='vova07\imperavi\bundles\ImageManagerAsset';
        }
        if($this->isFullPlugin){
            $this->setting['paragraphize']=false;
            $this->setting['replaceDivs']=false;
            $this->setting['plugins'] = ['fontcolor',
                    'fontfamily',
                    'fontsize',
                    'textdirection',
                    'textexpander',
                    'counter',
                    'table',
                    'definedlinks',
                    'video',
                    'imagemanager',//=>'vova07\imperavi\bundles\ImageManagerAsset',
                    'filemanager',
                    'limiter',
                    'fullscreen'];
               //\appxq\sdii\utils\VarDumper::dump($this->setting);
        }       
        
         echo \vova07\imperavi\Widget::widget([
            'name' => 'comment',
            'settings' => $this->setting
            //[
                 
//                'minHeight' => 200,
//                'imageUpload' => Url::to(['/core/upload/image-upload']),
//                'imageDelete' => Url::to(['/core/upload/file-delete']),
//                'imageManagerJson' => Url::to(['/core/upload/images-get']),
//                'plugins' => [
//                    'fontcolor',
//                    'fontsize',
//                    'imagemanager' => 'vova07\imperavi\bundles\ImageManagerAsset',
//                ],
           // ],
        ]);
    }
     
}

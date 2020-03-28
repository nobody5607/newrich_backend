<?php

namespace backend\modules\admins;

/**
 * admins module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\admins\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        \Yii::$app->params['bsVersion']='4.x';
        $this->layout = 'admin';
        parent::init();

        // custom initialization code goes here
    }
}

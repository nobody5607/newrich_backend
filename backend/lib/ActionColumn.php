<?php
namespace app\lib;
use yii\helpers\Html;
use Yii;

class ActionColumn extends \yii\grid\ActionColumn
{
    public function init()
    {
        parent::init();
//        $this->initDefaultButtons();
    }
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye');
        $this->initDefaultButton('view', 'print');
        $this->initDefaultButton('update', 'edit');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {

                switch ($name) {
                    case 'view':

                        $title = Yii::t('yii', 'View');
                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'class'=>'btn btn-info btn-sm'
                        ], $additionalOptions, $this->buttonOptions);
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'class'=>'btn btn-info btn-sm'
                        ], $additionalOptions, $this->buttonOptions);
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'class'=>'btn btn-danger btn-sm'
                        ], $additionalOptions, $this->buttonOptions);
                        break;
                    case 'invoice':
                        $title = Yii::t('yii', 'invoice');
                        $options = array_merge([
                            'title' => $title,
                            'aria-label' => $title,
                            'data-pjax' => '0',
                            'class'=>'btn btn-warning btn-sm'
                        ], $additionalOptions, $this->buttonOptions);
                        break;
                    default:
                        $title = ucfirst($name);
                }

                $icon = Html::tag('span', '', ['class' => "fa fa-$iconName"]);
                $button = '';
                if($name == 'view'){
                    $permission = CNUtils::checkPermission('view');
                    if($permission){
                        $button = Html::a($icon, $url, $options);
                    }
                }else if($name == 'create'){
                    $permission = CNUtils::checkPermission('create');
                    if($permission){
                        $button = Html::a($icon, $url, $options);
                    }
                }else if($name == 'update'){
                    $permission = CNUtils::checkPermission('update');
                    if($permission){
                        $button = Html::a($icon, $url, $options);
                    }
                }else if($name == 'delete'){
                    $permission = CNUtils::checkPermission('delete');
                    if($permission){
                        $button = Html::a($icon, $url, $options);
                    }
                }else if($name == 'print'){
                    $permission = CNUtils::checkPermission('print');
                    if($permission){
                        $button = Html::a($icon, $url, $options);
                    }
                }

                return $button;

            };
        }
    }
}

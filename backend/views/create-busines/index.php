<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Busines';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-header">
         <i class=""></i> <?=  Html::encode($this->title) ?>
         <div class="pull-right">
             <?= Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['create-busines/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-create-busines']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['create-busines/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-create-busines', 'disabled'=>false]) 
             ?>
         </div>
    </div>
<div class="box-body">    

    <?php  Pjax::begin(['id'=>'create-busines-grid-pjax']);?>
    <?= GridView::widget([
	'id' => 'create-busines-grid',
/*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['create-busines/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-create-busines']). ' ' .
		      Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['create-busines/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-create-busines', 'disabled'=>true]),*/
	'dataProvider' => $dataProvider,
	'columns' => [
	    [
		'class' => 'yii\grid\CheckboxColumn',
		'checkboxOptions' => [
		    'class' => 'selectionCreateBusineIds'
		],
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:40px;text-align: center;'],
	    ],
	    [
		'class' => 'yii\grid\SerialColumn',
		'headerOptions' => ['style'=>'text-align: center;'],
		'contentOptions' => ['style'=>'width:60px;text-align: center;'],
	    ],

            'id',
            'title',
            'detail',
            'createBy',
            'createDate',
            // 'orderBy',

	    [
		'class' => 'appxq\sdii\widgets\ActionColumn',
		'contentOptions' => ['style'=>'width:180px;text-align: center;'],
		'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fa fa-pencil"></span> '.Yii::t('app', 'Update'),
                                    yii\helpers\Url::to(['create-busines/update?id='.$model->id]), [
                                    'title' => Yii::t('app', 'Update'),
                                    'class' => 'btn btn-primary btn-xs',
                                    'data-action'=>'update',
                                    'data-pjax'=>0
                        ]);
                    },
                    'delete' => function ($url, $model) {                         
                        return Html::a('<span class="fa fa-trash"></span> '.Yii::t('app', 'Delete'), 
                                yii\helpers\Url::to(['create-busines/delete?id='.$model->id]), [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn btn-danger btn-xs',
                                'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax'=>0
                        ]);
                            
                        
                    },
                ]
	    ],
        ],
    ]); ?>
    <?php  Pjax::end();?>

</div>
</div>
<?=  ModalForm::widget([
    'id' => 'modal-create-busines',
    //'size'=>'modal-lg',
]);
?>

<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script

function loadData(url){
    $.get(url, function (result) {
        $("#reloadDive").html(result);
    });
    return false;
}
$(".pagination li a").on('click', function () {
    let url = $(this).attr('href');
    loadData(url)
    return false;
});

$('#modal-addbtn-create-busines').on('click', function() {
    modalCreateBusine($(this).attr('data-url'));
});

$('#modal-delbtn-create-busines').on('click', function() {
    selectionCreateBusineGrid($(this).attr('data-url'));
});

$('#create-busines-grid-pjax').on('click', '.select-on-check-all', function() {
    window.setTimeout(function() {
	var key = $('#create-busines-grid').yiiGridView('getSelectedRows');
	disabledCreateBusineBtn(key.length);
    },100);
});

$('.selectionCoreOptionIds').on('click',function() {
    var key = $('input:checked[class=\"'+$(this).attr('class')+'\"]');
    disabledCreateBusineBtn(key.length);
});

$('#create-busines-grid-pjax').on('dblclick', 'tbody tr', function() {
    var id = $(this).attr('data-key');
    modalCreateBusine('<?= Url::to(['create-busines/update', 'id'=>''])?>'+id);
});	

$('#create-busines-grid-pjax').on('click', 'tbody tr td a', function() {
    var url = $(this).attr('href');
    var action = $(this).attr('data-action');

    if(action === 'update' || action === 'view') {
	modalCreateBusine(url);
    } else if(action === 'delete') {
	yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function() {
	    $.post(
		url
	    ).done(function(result) {
		if(result.status == 'success') {
            swal({
                title: result.message,
                text: result.message,
                type: result.status,
                timer: 1000
            });
		    $.pjax.reload({container:'#create-busines-grid-pjax'});
		} else {
            swal({
                title: result.message,
                text: result.message,
                type: result.status,
                timer: 1000
            });
		}
	    }).fail(function() {
		<?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
		console.log('server error');
	    });
	});
    }
    return false;
});

function disabledCreateBusineBtn(num) {
    if(num>0) {
	$('#modal-delbtn-create-busines').attr('disabled', false);
    } else {
	$('#modal-delbtn-create-busines').attr('disabled', true);
    }
}

function selectionCreateBusineGrid(url) {
    yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function() {
	$.ajax({
	    method: 'POST',
	    url: url,
	    data: $('.selectionCreateBusineIds:checked[name=\"selection[]\"]').serialize(),
	    dataType: 'JSON',
	    success: function(result, textStatus) {
		if(result.status == 'success') {
            swal({
                title: result.status,
                text: result.message,
                type: result.status,
                timer: 2000
            });
		    $.pjax.reload({container:'#create-busines-grid-pjax'});
		} else {
            swal({
                title: result.status,
                text: result.message,
                type: result.status,
                timer: 2000
            });
		}
	    }
	});
    });
}

function modalCreateBusine(url) {
    $('#modal-create-busines .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
    $('#modal-create-busines').modal('show')
    .find('.modal-content')
    .load(url);
}
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>
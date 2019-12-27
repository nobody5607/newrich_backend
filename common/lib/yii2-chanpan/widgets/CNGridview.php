<?php
namespace cpn\chanpan\widgets;

 

use Yii;
use yii\helpers\Html;
use yii\grid\GridView as BaseGridView;
 
class CNGridview extends BaseGridView {

	/**
	 * @var array the HTML attributes for the grid table element.
	 * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
	 */
	public $tableOptions = ['class' => 'table table-striped table-bordered table-hover'];
	public $responsiveTable = true;
	public $panel = true;
	public $panelBtn = '';

	/**
	 * Initializes the widget.
	 */
	public function init() {
		parent::init();

		if ($this->panel) {
			$items = ($this->responsiveTable) ? Html::tag('div', '{items}', ['class' => 'table-responsive']) : '{items}';
			$this->layout = <<<EOD
	    <div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
			    <div class="col-md-6">{summary}</div>
			    <div class="col-md-6 text-right">
				    $this->panelBtn
			    </div>
			</div>
		</div>
		$items
		<div class="panel-footer">{pager}</div>
	    </div>	
EOD;
		}
	}

}

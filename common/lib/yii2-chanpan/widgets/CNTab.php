<?php

namespace cpn\chanpan\widgets;

class CNTab extends \yii\base\Widget{

    public $options = [];
    public $id = '';

    public function run(){
        $html = "";
        $html .= "<div><ul class='nav nav-tabs tabs-up' id='" . $this->id . "'>";
        foreach ($this->options as $key => $o) {
            if (isset($o['active']) ? $o['active'] : '' == true) {
                $html .= "
                    <li class='active'>
                        <a href='" . $o['url'] . "' 
                            data-target='#contacts' 
                            class='media_node active span' 
                            id='contacts_tab' 
                            data-toggle='tabajax' 
                            rel='tooltip'> <i class='" . $o['icon'] . "'></i> " . $o['title'] . "
                        </a>
                    </li>
                ";
            } else {
                $html .= "
                    <li>
                        <a href='" . $o['url'] . "' 
                            data-target='#contacts' 
                            class='media_node active span' 
                            id='contacts_tab' 
                            data-toggle='tabajax' 
                            rel='tooltip'> <i class='" . $o['icon'] . "'></i> " . $o['title'] . "
                        </a>
                    </li>
                ";
            }
        }
        $html .= "</ul>";
        $html .= "<div class='tab-content' style='margin-top:10px;'>";
        $html .= "<div class='tab-pane active' id='contacts'>";
        $html .= "</div>";
        $html .= "<div class='tab-pane' id='friends_list'>";
        $html .= "</div>";
        $html .= "<div class='tab-pane  urlbox span8' id='awaiting_request'>";
        $html .= "</div>";
        $html .= "</div>";
        $html .= "</div>";
        $this->registerClientScript();
        echo $html;
    }
    public function registerClientScript() {
	$view = $this->getView();       
        $view->registerJs("
            if($('li').hasClass('active')){
                   let \$this =   $('li.active [data-toggle=\'tabajax\']');
                   let loadurl = \$this.attr('href');
                   let targ = \$this.attr('data-target');                   
                   //alert(loadurl);
                   getData(loadurl,targ);             
                }
                $('li [data-toggle=\'tabajax\']').click(function(e) {
                    let \$this = $(this);  
                    let loadurl = \$this.attr('href');
                    let targ = \$this.attr('data-target');
                    getData(loadurl,targ);             
                    \$this.tab('show');
                    return false;
                });

                function getData(loadurl,targ){
                    $(targ).html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
                    $.get(loadurl, function(data) {
                        $(targ).html(data);
                    });
                }
        ");
    }

//run
}

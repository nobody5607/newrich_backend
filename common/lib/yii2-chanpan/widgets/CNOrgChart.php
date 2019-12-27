<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\widgets;

use kongoon\orgchart\OrgChart as BaseOrgChart;
class CNOrgChart extends BaseOrgChart{
    //put your code here
    
    /*
     * การใช้งาน
     * [['v' => 'ค่าอ้างอิง(NodeID)', 'f' => 'ส่วนแสดงผลใช้ HTML ได้'],'ระบุ NodeID ที่ต้องการนำไปต่อ', 'Tooltip ตอน Mouse over'],
     */
    
    /**การใช้งาน
        echo \cpn\chanpan\widgets\OrgChart::widget([
            'data' => [
                [['v' => 'Mike', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Mike&w=120&h=150" /><br  /> <strong>Mike</strong><br  />The President'], '', 'The President'],
                [['v' => 'Jim', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Jim&w=120&h=150" /><br  /><strong>Jim</strong><br  />The Test'], 'Mike', 'VP'],
                [['v' => 'ทดสอบ', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=ทดสอบ&w=120&h=150" /><br  /><strong>ทดสอบ</strong><br  />The Test'], 'Mike', ''],
                [['v' => 'Caral', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Caral&w=120&h=150" /><br  /><strong>Caral</strong><br  />The Test'], 'Mike', 'Caral Title'],
                [['v' => 'Bob', 'f' => '<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=Bob&w=120&h=150" /><br  /><strong>Bob</strong><br  />The Test'], 'Jim', 'Bob Sponge'],
                [
                    [
                        'v' => 'Nut', 
                        'f' => '<img style="width:120px;height:150px" src="http://www.majorcineplex.com/uploads/content/2551/skkltn.jpg" /><br  /><strong>Nut</strong><br  />Chanpan'
                    ], 'Caral', 'Bob Sponge'],
            ]
        ]);
     */
}

<?php
    $this->title='ตั้งค่าระบบ';
?>

<h1>ตั้งค่าระบบ</h1>
<div class="card">
    <div class="card-header">
        ตั้งค่าการเก็บเงิน
    </div>
    <div class="card-body">
        <div id="app">
            <div class="row">
                <div class="col-3">
                    <label for="">ลูกค้า %:</label>
                    <input type="text" name="customerPercent" class="form-control text-right">
                </div>
                <div class="col-3">
                    <label for="">ผู้แนะนำ %:</label>
                    <input type="text" name="parentPercent" class="form-control text-right">
                </div>
                <div class="col-3">
                    <label for="">นิวริช %:</label>
                    <input type="text" name="percentPercent" class="form-control text-right">
                </div>
                <div class="col-3 ">
                    <button class="btn btn-primary mt-4">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php \richardfan\widget\JSRegister::begin();?>
<script>
    var app = new Vue({
        el: '#app',
        created() {
            console.log('created called.');
        },
        data: {
            message: 'Hello Vue!'
        },
        methods: {
            greet: function (event) {

            }
        }
    })
</script>
<?php \richardfan\widget\JSRegister::end();?>

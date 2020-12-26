<?php
    $this->title='Setting';
?>
<div id="app">
    {{ message }}

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">สำหรับ Newriched</label>
                    <input type="text"  class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="">สำหรับผู้ซื้อ</label>
                    <input type="text"  class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="">สำหรับผู้แนะนำ</label>
                    <input type="text"  class="form-control">
                </div>
                <div class="col-md-3">
                    <button  class="btn btn-primary mt-4">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

</div>

<?php \richardfan\widget\JSRegister::begin();?>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!'
        }
    })
</script>
<?php \richardfan\widget\JSRegister::end();?>

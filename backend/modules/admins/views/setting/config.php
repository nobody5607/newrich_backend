<?php
$this->title = 'ตั้งค่าระบบ';
?>

<h1>ตั้งค่าระบบ</h1>
<div class="card">
    <div class="card-header">
        ตั้งค่าการเก็บเงิน
    </div>
    <div class="card-body">
        <div id="app">
            <div class="row">
                <input type="hidden" v-model="id">
                <div class="col-6">
                    <label for="">ยอดซื้อรวม:</label>
                    <input type="text" v-model="totalPrice" name="totalPrice" class="form-control text-right">
                </div>
                <div class="col-6">
                    <label for="">ส่วนแบ่งเข้าระบบ:</label>
                    <input type="text" v-model="parentNewriched" name="parentNewriched" class="form-control text-right">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <label for="">ลูกค้า %:</label>
                    <input type="text" v-model="customerPercent" name="customerPercent" class="form-control text-right">
                </div>
                <div class="col-3">
                    <label for="">ผู้แนะนำ %:</label>
                    <input type="text" v-model="parentPercent" name="parentPercent" class="form-control text-right">
                </div>
                <div class="col-3">
                    <label for="">นิวริช %:</label>
                    <input type="text" v-model="percentPercent" name="percentPercent" class="form-control text-right">
                </div>
                <div class="col-3 ">
                    <button class="btn btn-primary mt-4" @click="submit">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php \richardfan\widget\JSRegister::begin(); ?>
<script>
    var app = new Vue({
        el: '#app',
        created() {
            this.getData();
        },
        data: {
            id:1,
            totalPrice: 0,
            parentNewriched: 0,
            customerPercent: 0,
            parentPercent: 0,
            percentPercent: 0,
            message: 'Hello Vue!'
        },
        methods: {
            getData:async function(){
                let url = '<?= \yii\helpers\Url::to(['/admins/setting/get-data'])?>';
                let result = await axios.get(url);
                if(result.data.status == 'success'){
                    let {data} = result.data;
                    this.totalPrice = data.totalPrice;
                    this.parentNewriched = data.parentNewriched;
                    this.customerPercent = data.customerPercent;
                    this.parentPercent = data.parentPercent;
                    this.percentPercent = data.percentPercent;
                    this.id = data.id;
                }
            },
            submit: async function () {
                try{
                    let url = '<?= \yii\helpers\Url::to(['/xadmins/setting/save-data'])?>';
                    let form = new FormData();
                    form.append('totalPrice',this.totalPrice);
                    form.append('parentNewriched',this.parentNewriched);
                    form.append('customerPercent',this.customerPercent);
                    form.append('parentPercent',this.parentPercent);
                    form.append('percentPercent',this.percentPercent);
                    form.append('id',this.id);
                    const response = await axios({
                        method: 'post',
                        url: url,
                        data: form
                    });

                    if(response.data.status == 'success'){
                        $.notify(response.data.msg,{
                            position:'top right',
                            className: 'success',
                            showDuration: 200,
                            showAnimation: 'slideDown',
                            hideAnimation: 'slideUp',
                            hideDuration: 200,
                        });
                        this.getData();
                    }

                }catch(error){
                    $.notify(error,{
                        position:'top right',
                        className: 'error',
                        autoHide:false,

                    });
                    console.log('error....');
                    console.log(error);
                    console.log('...error')
                }
            }
        }
    })
</script>
<?php \richardfan\widget\JSRegister::end(); ?>

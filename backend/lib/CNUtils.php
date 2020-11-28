<?php


namespace backend\lib;


use backend\modules\admins\models\User;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use Yii;

class CNUtils
{

    public static $statusApprove =['0'=>'รออนุมัติ','1'=>'อนุมัติ','2'=>'ไม่อนุมัติ'];
    /**
     * @param $model $model
     * @param $attribute field
     * @return array
     */
    public static function uploadFile($model, $attribute){
            $files = UploadedFile::getInstances($model,$attribute);
            $output=[];
            if ($files) {
                $file = $files[0];
                $realFileName = self::getMillisecTime();
                $folder = "/web/uploads/";
                $path = Yii::getAlias('@app') . "{$folder}";
                $type = $file->extension;
                $filePath = "{$path}/{$realFileName}.{$type}";

                if ($file->saveAs("{$filePath}")) {
                    $output = ['success'=>true,'filename'=>"{$realFileName}.{$type}"];
                }
                return $output;
            }
    }
    public static function getMillisecTime() {
        list($t1, $t2) = explode(' ', microtime());
        $mst = str_replace('.', '', $t2 . $t1);

        return $mst;
    }
//user id
    public static function getUserId()
    {
        return isset(Yii::$app->user->id)?Yii::$app->user->id:'';//isset(\Yii::$app->session['user_id']) ? \Yii::$app->session['user_id'] : '';
    }
    public static function getUserName(){
        return isset(\Yii::$app->user->identity->profile->name)?\Yii::$app->user->identity->profile->name:'';
    }

    //ชื่อลูกค้า
    public static function getCustomerNameById($id)
    {
        $customer = Customers::findOne($id);
        return isset($customer->c_name) ? $customer->c_name : '';
    }

    //ที่อยู่เปิดบิล
    public static function getCustomerArddress($id)
    {
        $customer = Customers::findOne($id);
        return isset($customer->c_address) ? $customer->c_address : '';
    }

    //ภาษี
    public static function getCustomerTagID($id)
    {
        $customer = Customers::findOne($id);
        return isset($customer->c_number) ? $customer->c_number : '';
    }

//    //Tag
//    public static function getCustomerTag($id){
//        $customer = Customers::findOne($id);
//        return isset($customer->c_ta)?$customer->c_address:'';
//    }
    //ชื่อ Agent
    public static function getAgentName($id)
    {
        $customer = Agents::findOne($id);
        return isset($customer->name) ? $customer->name : '';
    }

    //แสดงชื่อผู้ใช้
    public static function getUserById($id)
    {
        $user = User::findOne($id);
        return isset($user->profile->name) ? $user->profile->name : '-';
    }

    //ประเภทตู้
    public static function getContainerType($id)
    {
        $model = ContainerType::findOne($id);
        return isset($model->name) ? $model->name : '-';
    }

    //วันที่ของไทย
    public static function getDateDmy($date)
    {
        if ($date != '') {
            $date = explode('-', $date);
            return $date[2] . '/' . $date[1] . '/' . $date[0];
        }
        return '-';
    }

    //วันที่ของไทย
    public static function getDateDmyHis($date)
    {
        if ($date != '') {
            $date = explode(' ', $date);
            $date1 = explode('-', $date[0]);
            //CNUtils::Vardumper($date);
            return $date1[2] . '/' . $date1[1] . '/' . $date1[0] . ' ' . $date[1];
        }
        return '-';
    }

    /**
     * Convert baht number to Thai text
     * @param double|int $number
     * @param bool $include_unit
     * @param bool $display_zero
     * @return string|null
     */
    public static function getBathText($number, $include_unit = true, $display_zero = true)
    {

        $BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
        $BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
        $BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
        $BAHT_TEXT_TWENTY = 'ยี่';
        $BAHT_TEXT_INTEGER = 'ถ้วน';
        $BAHT_TEXT_BAHT = 'บาท';
        $BAHT_TEXT_SATANG = 'สตางค์';
        $BAHT_TEXT_POINT = 'จุด';

        if (!is_numeric($number)) {
            return null;
        }

        $log = floor(log($number, 10));
        if ($log > 5) {
            $millions = floor($log / 6);
            $million_value = pow(1000000, $millions);
            $normalised_million = floor($number / $million_value);
            $rest = $number - ($normalised_million * $million_value);
            $millions_text = '';
            for ($i = 0; $i < $millions; $i++) {
                $millions_text .= $BAHT_TEXT_UNITS[6];
            }
            return self::getBathText($normalised_million, false) . $millions_text . self::getBathText($rest, true, false);
        }

        $number_str = (string)floor($number);
        $text = '';
        $unit = 0;

        if ($display_zero && $number_str == '0') {
            $text = $BAHT_TEXT_NUMBERS[0];
        } else for ($i = strlen($number_str) - 1; $i > -1; $i--) {
            $current_number = (int)$number_str[$i];

            $unit_text = '';
            if ($unit == 0 && $i > 0) {
                $previous_number = isset($number_str[$i - 1]) ? (int)$number_str[$i - 1] : 0;
                if ($current_number == 1 && $previous_number > 0) {
                    $unit_text .= $BAHT_TEXT_ONE_IN_TENTH;
                } else if ($current_number > 0) {
                    $unit_text .= $BAHT_TEXT_NUMBERS[$current_number];
                }
            } else if ($unit == 1 && $current_number == 2) {
                $unit_text .= $BAHT_TEXT_TWENTY;
            } else if ($current_number > 0 && ($unit != 1 || $current_number != 1)) {
                $unit_text .= $BAHT_TEXT_NUMBERS[$current_number];
            }

            if ($current_number > 0) {
                $unit_text .= $BAHT_TEXT_UNITS[$unit];
            }

            $text = $unit_text . $text;
            $unit++;
        }

        if ($include_unit) {
            $text .= $BAHT_TEXT_BAHT;

            $satang = explode('.', number_format($number, 2, '.', ''))[1];
            $text .= $satang == 0
                ? $BAHT_TEXT_INTEGER
                : self::getBathText($satang, false) . $BAHT_TEXT_SATANG;
        } else {
            $exploded = explode('.', $number);
            if (isset($exploded[1])) {
                $text .= $BAHT_TEXT_POINT;
                $decimal = (string)$exploded[1];
                for ($i = 0; $i < strlen($decimal); $i++) {
                    $text .= $BAHT_TEXT_NUMBERS[$decimal[$i]];
                }
            }
        }

        return $text;
    }


    /**
     * @param array $data
     * @param $msg
     * @return array
     */
    public static function getSuccess($data = [], $msg)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => 'success', 'msg' => $msg, 'data' => $data];
    }

    /**
     * @param array $data
     * @param $msg
     * @return array
     */
    public static function getError($data = [], $msg)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['status' => 'error', 'msg' => $msg, 'data' => $data];
    }

    /**
     * @param $data
     */
    public static function Vardumper($data)
    {
        VarDumper::dump($data, 10, true);
        exit();
    }

    public static function getJobList($id)
    {
        $jobList = JobList::find()->where(['job_id' => $id])->all();
        return $jobList;
    }

    public static function getTotal($id)
    {
        $jobList = JobList::find()->where(['job_id' => $id])->all();
        $total = 0;
        foreach ($jobList as $k => $v) {
            $total += $v->sell;
        }
        return $total;
    }

    /**
     * @param $account
     * @param $stdate
     * @param $enddate
     * @param string $jobId
     * @param string $invID
     * @return array
     *
     */
    public static function getJobByDate($account, $stdate, $enddate, $jobId = '', $invID = '')
    {
        $output = [];
        if ($jobId != '') {
            $job = Jobs::find()->where(['id' => $jobId])->all();
//            return $jobId;
        } else {
            $customer = Customers::find()->where(['c_account' => $account])->one();
            $job = Jobs::find()->where('cus_name=:cus_name and get_date BETWEEN :value1 AND :value2', [
                ':cus_name' => $customer->id,
                ':value1' => $stdate,
                ':value2' => $enddate
            ])->all();
//            return $job;
        }

        if ($job) {
            $totalSell = 0;
            foreach ($job as $k => $j) {
                $output['jobid'][] = $j;
                $customer = Customers::findOne($j['car_customer']);
                $output['customer'] = $customer;

                if ($invID != '') {
                    $invoice = Invoices::findOne($invID);
                    $output['invoice'] = $invoice;
                }
                $output['jobs'][$k] = [
                    'job' => $j,
                    'jobList' => self::getJobList($j->id)
                ];
                $totalSell += self::getTotal($j->id);

            }
            $output['totalText'] = number_format($totalSell, 2);
            $output['total'] = $totalSell;
            return $output;
        } else {
            return [];
        }
    }

    private static function getDate($id, $date, $index)
    {
        if ($index == 0) {
            return $date;
        } else {
            return '';
        }
    }


    /**
     * @param $logs
     * @param $type | success or warning or error
     * @param $action | delete or edit
     * @param $table
     * @return bool true|false
     */
    public static function saveLog($logs, $type, $action, $table)
    {
        $log = new Logs();
        $log->log = Json::encode($logs);
        $log->type = $type;
        $log->user_id = self::getUserId();
        $log->actions = $action;
        $log->tables = $table;
        if ($log->save()) {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getBranchList()
    {
        return ['1' => 'สาขาหลัก', '2' => 'สาขาย่อย'];
    }

    /**
     * @return mixed|string
     */
    public static function getBranch()
    {
        $user = Users::findOne(self::getUserId());
        return isset($user->branch) ? $user->branch : '';
    }

    //current date
    public static function getCurrentDate()
    {
        return date('Y-m-d H:i:s');
    }

    //current year
    public static function checkConfigYear()
    {
        $year = date('Y');
        $yearConfig = self::getConfigs('year');
        if ($year > $yearConfig) {
            return true;
        }
        return false;
    }


    //job no
    public static function getJobNo()
    {
        $branch = self::getBranch();
        $branch = Branch::findOne($branch);
        $year = date('Y');
        $year = substr($year, -2);
        $month = date('m');
        $jobno = $branch->job_no . $year . '' . $month . '-';
        return $jobno;
    }

    /* get runnumer */
    public static function getRunNumberJob()
    {
        $job = Jobs::find()->where(['branch' => self::getBranch()])->orderBy(['id' => SORT_DESC])->one();

        //self::Vardumper(self::checkConfigYear());
        if (self::checkConfigYear()) {
            $job->runnumber = 0;
            $job->update();
            $year = date('Y');
            self::setConfigs('year', $year);
        }

        $branch = Branch::findOne(self::getBranch());
        $runnumber = $branch->run_number + 1;//branch run_number
        if ($job) {
            //return 'ok';
            return ['run_number' => $job->runnumber + 1, 'job_no' => sprintf("%0" . $runnumber . "d", $job->runnumber += 1)];
        } else {
            return ['run_number' => 1, 'job_no' => sprintf("%0" . $runnumber . "d", 1)];
        }
    }

    /**
     * @return string Job. NO.
     */
    public static function getJobGen()
    {
        return self::getJobNo() . self::getRunNumberJob()['job_no'];
    }

    //inv no first
    public static function getInvNo()
    {
        $branch = self::getBranch();
        $branch = Branch::findOne($branch);
        $year = date('Y');
        $year = substr($year, -2);
        $month = date('m');
        $jobno = $branch->inv_no . $year . '' . $month . '-';
        return $jobno;
    }

    /* get runnumer */
    public static function getRunNumberInv()
    {
        $inv = Invoices::find()->where(['branch' => self::getBranch()])->orderBy(['id' => SORT_DESC])->one();
        if (self::checkConfigYear()) {
            $inv->inv_autonumber = 0;
            $inv->update();
            $year = date('Y');
            self::setConfigs('year', $year);
        }

        $branch = Branch::findOne(self::getBranch());
        $runnumber = $branch->run_number + 1;
        if ($inv) {
            //return 'ok';
            return ['run_number' => $inv->inv_autonumber + 1, 'inv_no' => sprintf("%0" . $runnumber . "d", $inv->inv_autonumber += 1)];
        } else {
            return ['run_number' => 1, 'inv_no' => sprintf("%0" . $runnumber . "d", 1)];
        }
    }

    /**
     * @return string INV. NO.
     */
    public static function getInvGen()
    {
        return self::getInvNo() . self::getRunNumberInv()['inv_no'];
    }

    //reciept no first
    public static function getRecieptNo()
    {
        $branch = self::getBranch();
        $branch = Branch::findOne($branch);
        $year = date('Y');
        $year = substr($year, -2);
        $month = date('m');
        $jobno = $branch->reciept_no . $year . '' . $month . '-';
        return $jobno;
    }

    /* get reciept runnumer */
    public static function getRunNumberReciept()
    {
        $inv = Receipts::find()->where(['branch' => self::getBranch()])->orderBy(['id' => SORT_DESC])->one();
        if (self::checkConfigYear()) {
            $inv->rec_autonumber = 0;
            $inv->update();
            $year = date('Y');
            self::setConfigs('year', $year);
        }
        $branch = Branch::findOne(self::getBranch());
        $runnumber = $branch->reciept_number + 1;
        if ($inv) {
            return ['run_number' => $inv->rec_autonumber + 1, 'reciept_no' => sprintf("%0" . $runnumber . "d", $inv->rec_autonumber += 1)];
        } else {
            return ['run_number' => 1, 'reciept_no' => sprintf("%0" . $runnumber . "d", 1)];
        }
    }

    /**
     * @return string INV. NO.
     */
    public static function getRecieptGen()
    {
        return self::getRecieptNo() . self::getRunNumberReciept()['reciept_no'];
    }


    /**
     * @param $id
     */
    public static function getInvoiceById($id)
    {
        $output = [];
        $invoice = Invoices::findOne($id);

        //return $invoice;
        if (!$invoice) {
            return false;
        }
        $total2 = 0;
        $job = Jobs::findOne($invoice->job_id);
        $jobList = JobList::find()->where(['job_id' => $invoice->job_id])->all();
        $output['invoice'] = $invoice;
        $output['job'] = $job;
        $output['jobList'] = $jobList;
        $jobListSum = JobList::find()->where(['job_id' => $invoice->job_id])->sum('sell');
        $output['total'] = number_format($jobListSum, 2);
        foreach ($jobList as $k => $v) {
            if ($k != 0) {
                $total2 += $v['sell'];
            }
        }
        $output['total1'] = number_format($jobList[0]['sell'], 2);
        $output['total2'] = number_format($total2, 2);
        $output['customer'] = Customers::findOne($invoice->inv_customer);
        return $output;
    }

    public static function getPaymentSelect()
    {
        return [1 => 'เงินสด (Cash)', 2 => 'เช็ค (Cheque)'];
    }

    /**
     * @param $label
     * @return mixed|string
     */
    public static function getConfigs($label)
    {
        $config = Configs::find()->where(['label' => $label])->one();
        return isset($config->value) ? $config->value : '';
    }

    /**
     * @param $label
     * @param $value
     */
    public static function setConfigs($label, $value)
    {
        $model = Configs::find()->where(['label' => $label, 'branch' => CNUtils::getBranch()])->one();
        if (!$model) {
            $model = new Configs();
        }
        $model->label = (string)$label;
        $model->value = (string)$value;
        $model->branch = CNUtils::getBranch();
        $model->create_by = CNUtils::getUserId();
        $model->create_date = CNUtils::getCurrentDate();
        if ($model->save()) {
            return true;
        } else {
            self::Vardumper($model->errors);
        }
        return false;
    }

    /**
     * @param string $action action id or view
     * @param string $ctrl controller id
     * @return bool
     *
     */
    public static function checkPermission($action = '',$ctrl = '')
    {
        if($ctrl == ''){
            $ctrl = \Yii::$app->controller->id;
        }
        //return $ctrl;

        $form = Forms::find()->where(['ctrl' => $ctrl])->one();

        if (!$form) {
            return false;
        }
        $permission = Permissions::find()->where(['form' => $form->id])->all();

        if (!$permission) {
            return false;
        }
        foreach($permission as $k=>$v){
            if ($v['p_'.$action] != null) {
                return true;
            }
        }

        return false;
    }

    //cab_typ 000
}

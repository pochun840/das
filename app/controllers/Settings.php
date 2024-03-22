<?php

class Settings extends Controller
{
    private $SettingModel;
    private $AdminModel;
    private $ToolModel;
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->SettingModel = $this->model('Setting');
        $this->AdminModel = $this->model('Admin');
        $this->ToolModel = $this->model('Tool');
    }

    // 取得所有info
    public function index(){

        $isMobile = $this->isMobileCheck();
        $Controller_Info = $this->SettingModel->GetControllerInfo();
        $operator_priviledge = $this->SettingModel->GetOperator_priviledge();
        $priviledge = $this->intTo16BitArray($operator_priviledge);
        $priviledge['confirm'] = $priviledge[12];
        $priviledge['clear'] = $priviledge[11];
        $priviledge['seq_clear'] = $priviledge[10];
        $priviledge['export'] = $priviledge[13];
        $priviledge['switch'] = $priviledge[14];
        $priviledge['barcode'] = $priviledge[15];
        

        //admin connect setting
        $active_session = $this->AdminModel->GetActiveSession();
        $max_user = $this->AdminModel->Get_Das_Config('max_concurrent_users');
        $agent_server_ip = $this->AdminModel->Get_Das_Config('agent_server_ip');
        $agent_type = $this->AdminModel->Get_Das_Config('agent_type');
        $iDas_Vesion = $this->AdminModel->Get_Das_Config('idas_version');

        $barcodes = $this->GetBarcodes();
        $job_list = $this->SettingModel->get_job_list();

        //get tool info
        $Tool_Info = $this->ToolModel->GetToolInfo();
        $device_info = $this->Device_Info();

        $data = [
            'isMobile' => $isMobile,
            'Controller_Info' => $Controller_Info,
            'priviledge' => $priviledge,
            'barcodes' => $barcodes,
            'job_list' => $job_list,
            'active_session' => $active_session,
            'max_user' => $max_user,
            'agent_server_ip' => $agent_server_ip,
            'agent_type' => $agent_type,
            'iDas_Vesion' => $iDas_Vesion,
            'Tool_Info' => $Tool_Info,
            'device_info' => $device_info
        ];

        
        $this->view('setting/index', $data);

    }

    public function job_tree()
    {   
        // var_dump(PDO::ATTR_EMULATE_PREPARES);
        //select all job
        $jobs = $this->SettingModel->GetAllJobs();
        //select all sequence
        $seqs = $this->SettingModel->GetAllSequences();
        //select all step
        $steps = $this->SettingModel->GetAllSteps();

        // var_dump($steps);
        $data_array = array();
        foreach ($jobs as $key => $value) {
            $temp = ["id" => 'job_'.$value['job_id'], "parent" => "#", "text" => $value['job_name'] ];
            $data_array[] = $temp;
        }
        foreach ($seqs as $key => $value) {
            $temp = ["id" => 'job_'.$value['job_id'].'_'.'seq_'.$value['sequence_id'], "parent" => 'job_'.$value['job_id'], "text" => $value['sequence_name'] ];
            $data_array[] = $temp;
        }
        foreach ($steps as $key => $value) {
            $temp = ["id" => $value['job_id'].'_'.$value['sequence_id'].'_'.$value['step_id'], "parent" => 'job_'.$value['job_id'].'_'.'seq_'.$value['sequence_id'], "text" => $value['step_name'] ];
            $data_array[] = $temp;
        }

        echo json_encode($data_array);
    }

    public function edit_password()
    {

        // code... table `device`
        if( !empty($_GET['new_password']) && isset($_GET['new_password'])  ){
            $new_password = $_GET['new_password'];
        }else{ 
            $input_check = false; 
            $error_message .= "new_password,";
        }
        if( !empty($_GET['comfirm_password']) && isset($_GET['comfirm_password'])  ){
            $comfirm_password = $_GET['comfirm_password'];
        }else{ 
            $input_check = false; 
            $error_message .= "comfirm_password,";
        }

        if ( $new_password != '') {
            $result = $this->SettingModel->Edit_Login_Password($new_password);

            if($result){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('edit_password: copyDB success');
                }else{
                    $this->logMessage('edit_password: copyDB fail');
                }
            }
        }else{
            $result = false;
        }
        

        if(!$result){
            echo json_encode(array('error' => 'fail'));
            exit();
        }else{
            echo json_encode(array('error' => ''));
            exit();
        }

    }

    public function edit_permission()//等控制器來確認
    {
        //default array
        $input_check = true;
        $error_message = '';
        $priviledge = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        if( !empty($_POST['Permission_Confirm']) && isset($_POST['Permission_Confirm'])  ){
            if($_POST['Permission_Confirm'] == 'false'){
                $Permission_Confirm = 1;
            }else{
                $Permission_Confirm = 0;
            }
        }else{ 
            $input_check = false; 
            $error_message .= "Permission_Confirm,";
        }

        if( !empty($_POST['Permission_Clear']) && isset($_POST['Permission_Clear'])  ){
            if($_POST['Permission_Clear'] == 'false'){
                $Permission_Clear = 1;
            }else{
                $Permission_Clear = 0;
            }
        }else{ 
            $input_check = false; 
            $error_message .= "Permission_Clear,";
        }

        if( !empty($_POST['Permission_Seq_Clear']) && isset($_POST['Permission_Seq_Clear'])  ){
            if($_POST['Permission_Seq_Clear'] == 'false'){
                $Permission_Seq_Clear = 1;
            }else{
                $Permission_Seq_Clear = 0;
            }
        }else{ 
            $input_check = false; 
            $error_message .= "Permission_Seq_Clear,";
        }

        if( !empty($_POST['Permission_SW']) && isset($_POST['Permission_SW'])  ){
            if($_POST['Permission_SW'] == 'false'){
                $Permission_SW = 0;
            }else{
                $Permission_SW = 1;
            }
        }else{ 
            $input_check = false; 
            $error_message .= "Permission_SW,";
        }

        if( !empty($_POST['Permission_Export']) && isset($_POST['Permission_Export'])  ){
            if($_POST['Permission_Export'] == 'false'){
                $Permission_Export = 0;
            }else{
                $Permission_Export = 1;
            }
        }else{ 
            $input_check = false; 
            $error_message .= "Permission_Export,";
        }

        if( !empty($_POST['Permission_Barcode']) && isset($_POST['Permission_Barcode'])  ){
            if($_POST['Permission_Barcode'] == 'false'){
                $Permission_Barcode = 0;
            }else{
                $Permission_Barcode = 1;
            }
        }else{ 
            $input_check = false; 
            $error_message .= "Permission_Barcode,";
        }


        if($input_check){

            $priviledge[12] = $Permission_Confirm;
            $priviledge[11] = $Permission_Clear;
            $priviledge[10] = $Permission_Seq_Clear;
            $priviledge[13] = $Permission_Export;
            $priviledge[14] = $Permission_SW;
            $priviledge[15] = $Permission_Barcode;

            $array2int = $this->bitArrayToDecimal($priviledge);
            $result = $this->SettingModel->Edit_Priviledge($array2int);

            if($result){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('edit_permission:set '.$array2int.' copyDB success');
                }else{
                    $this->logMessage('edit_permission:set '.$array2int.' copyDB fail');
                }
            }


            echo json_encode(array('error' => ''));
            exit();
        }else{
            echo json_encode(array('error' => $error_message));
            exit();
        }
        
    }

    private function intTo16BitArray($value) {
        // 確保值在 0 到 65535 的範圍內
        $value = max(0, min(65535, $value));

         // 將值拆分為二進制位元的陣列
        $bitArray = [];
        for ($i = 15; $i >= 0; $i--) {
            $bitArray[] = ($value >> $i) & 1;
        }
        
        // 返回二進制位元的陣列
        return $bitArray;
    }

    private function bitArrayToDecimal($bitArray) {
        // 確保陣列長度為 16
        if (count($bitArray) !== 16) {
            throw new InvalidArgumentException("陣列長度必須為 16");
        }
        
        // 將位元陣列轉換為十進位整數
        $decimalValue = 0;
        for ($i = 15; $i >= 0; $i--) {
            $decimalValue += $bitArray[$i] * pow(2, 15 - $i);
        }
        
        return $decimalValue;
    }

    public function control_setting($value='')
    {
        $input_check = true;
        $error_message = '';
        $con_setting = array();

        if( !empty($_POST['control_id']) && isset($_POST['control_id'])  ){
            $con_setting['control_id'] = $_POST['control_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "control_id,";
        }
        if( !empty($_POST['control_name']) && isset($_POST['control_name'])  ){
            $con_setting['control_name'] = $_POST['control_name'];
        }else{ 
            $input_check = false; 
            $error_message .= "control_name,";
        }
        if( isset($_POST['torque_unit']) && $_POST['torque_unit']>=0 && $_POST['torque_unit'] <=3 ){
            $con_setting['torque_unit'] = $_POST['torque_unit'];
        }else{ 
            $input_check = false; 
            $error_message .= "torque_unit,";
        }
        if( isset($_POST['select_language']) && $_POST['select_language']>=0 && $_POST['select_language'] <=2 ){
            $con_setting['select_language'] = $_POST['select_language'];
        }else{ 
            $input_check = false; 
            $error_message .= "select_language,";
        }
        if( isset($_POST['batch_mode_option']) && $_POST['batch_mode_option']>=0 && $_POST['batch_mode_option'] <=1 ){
            $con_setting['batch_mode_option'] = $_POST['batch_mode_option'];
        }else{ 
            $input_check = false; 
            $error_message .= "batch_mode_option,";
        }
        if( isset($_POST['buzzer_mode_option']) && $_POST['buzzer_mode_option']>=0 && $_POST['buzzer_mode_option'] <=1 ){
            $con_setting['buzzer_mode_option'] = $_POST['buzzer_mode_option'];
        }else{ 
            $input_check = false; 
            $error_message .= "buzzer_mode_option,";
        }
        if( isset($_POST['blackout_recovery_option']) && $_POST['blackout_recovery_option']>=0 && $_POST['blackout_recovery_option'] <=1 ){
            $con_setting['blackout_recovery_option'] = $_POST['blackout_recovery_option'];
        }else{ 
            $input_check = false; 
            $error_message .= "blackout_recovery_option,";
        }
        if( isset($_POST['Diskfull_Warning']) && $_POST['Diskfull_Warning']>=0 && $_POST['Diskfull_Warning'] <=99  ){
            $con_setting['Diskfull_Warning'] = $_POST['Diskfull_Warning'];
        }else{ 
            $input_check = false; 
            $error_message .= "Diskfull_Warning,";
        }
        if( isset($_POST['Torque_Filter'])  ){
            $con_setting['Torque_Filter'] = $_POST['Torque_Filter'];
        }else{ 
            $input_check = false; 
            $error_message .= "Torque_Filter,";
        }
        if( isset($_POST['sample_rate'])  ){
            $con_setting['sample_rate'] = $_POST['sample_rate'];
        }else{ 
            $input_check = false; 
            $error_message .= "sample_rate,";
        }

        if($input_check){
            $result = $this->SettingModel->Controller_Setting($con_setting);

            if($result){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('con_setting:set '.json_encode($con_setting).'  copyDB success');
                }else{
                    $this->logMessage('con_setting:set '.json_encode($con_setting).' copyDB fail');
                }
            }

            if(!$result){
                echo json_encode(array('error' => 'fail'));
                exit();
            }else{
                echo json_encode(array('error' => ''));
                exit();
            }

        }else{
            echo json_encode(array('error' => ''));
            exit();
        }

        
    }

    public function edit_system_date()
    {
        if( PHP_OS_FAMILY == 'Linux'){
            $dateTime = $_POST["datetime"];
            // var_dump($dateTime);
            // 驗證日期時間格式
            if (!preg_match("/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/", $dateTime)) {
                // echo "請提供有效的日期和時間格式（YYYY-MM-DD HH:MM:SS）。";
                echo json_encode(array('error' => '請提供有效的日期和時間格式（YYYY-MM-DD HH:MM:SS）。'));
                exit;
            }
            exec("sudo timedatectl set-ntp no");
            $rr = exec("sudo date -s ".$dateTime." ");
            exec("sudo hwclock --systohc ");

            if($rr != false){
                $this->logMessage('set date -s '.$dateTime.' success');
            }else{
                $this->logMessage('set date -s '.$dateTime.' fail');
            }


            echo json_encode(array('error' => '','result' => $rr));
            exit();
        }else{
            echo json_encode(array('error' => ''));
            exit();
        }
    }

    public function get_system_time()
    {
        header("Content-Type: text/plain; charset=utf-8");
        
        // var_dump(date_default_timezone_get());
        date_default_timezone_set("GMT0");
        $systemTime = date('Y-m-d H:i:s');
        echo $systemTime;
    }

    public function firmware_reset()
    {
        // code...
    }

    public function export_sysytem_config()
    {
        if( PHP_OS_FAMILY == 'Linux'){
            require_once '../modules/phpmodbus-master/Phpmodbus/ModbusMaster.php';
            $modbus = new ModbusMaster("127.0.0.1", "TCP");
            try {
                $modbus->port = 502;
                $data = array(1);
                $dataTypes = array("INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT");

                // FC 16
                $modbus->writeMultipleRegister(0, 505, $data, $dataTypes);
                $this->logMessage('modbus write 505 ,array = '.implode("','", $data));
                $this->logMessage('modbus status:'.$modbus->status);
                // echo json_encode(array('error' => ''));
                // exit();

                header("Content-type: text/html; charset=utf-8");
                $file="/mnt/ramdisk/FTP/tcscon.cfg"; // 實際檔案的路徑+檔名
                $filename="tcscon.cfg"; // 下載的檔名
                //指定類型
                header("Content-type: ".filetype("$file"));
                //指定下載時的檔名
                header("Content-Disposition: attachment; filename=".$filename."");
                //輸出下載的內容。
                readfile($file);

            } catch (Exception $e) {
                $this->logMessage('modbus write 505 fail');
                $this->logMessage('db_sync D2C end');
                echo json_encode(array('error' => 'modbus error'));
                exit();
            }
        }else{//windows
            // echo json_encode(array('error' => ''));
                header("Content-type: text/html; charset=utf-8");
                $file="../tcscon.db"; // 實際檔案的路徑+檔名
                $filename="tcscon.cfg"; // 下載的檔名
                //指定類型
                header("Content-type: ".filetype("$file"));
                //指定下載時的檔名
                header("Content-Disposition: attachment; filename=".$filename."");
                //輸出下載的內容。
                readfile($file);
            exit();
        }
    }

    public function system_storage()
    {
        $EMMC_BASE = "/var/www/html/database/"; //目標目錄路徑
        if( PHP_OS_FAMILY == 'Linux'){
            $size = 0;
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($EMMC_BASE)) as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }

            $gigatmp = $size / 1024 / 1024 / 1024;
            $device_diskfull_percent = ceil(($gigatmp / 1.1) * 100);

            echo "{$device_diskfull_percent}";
        }else{
            echo "X";
        }
    }

    public function get_file_list($value='')
    {
        $year = date("Y");

        if( PHP_OS_FAMILY == 'Linux'){
            $folderPath = "/var/www/html/database/"; // 修改為你的資料夾路徑
        }else{
            $folderPath = "../"; // 修改為你的資料夾路徑
        }

        $excludeFiles = ["tcscon.db", "tcsdev.db"]; // 要排除的檔案名稱 ,"data{$year}.db"
        $allowedExtensions = ["db"]; // 允許的附檔名


        $fileList = scandir($folderPath);
        // 過濾不要顯示的檔案
        $fileList = array_filter($fileList, function ($fileName) use ($excludeFiles) {
            return !in_array($fileName, $excludeFiles);
        });

        // 過濾只顯示符合條件的檔案
        $fileList = array_filter($fileList, function ($fileName) {
            // 檢查檔案名稱是否以 "data" 開頭且副檔名為 ".db"
            return (strpos($fileName, "data") === 0 && pathinfo($fileName, PATHINFO_EXTENSION) === "db");
        });


        $fileList = array_diff($fileList, array(".", "..")); // 移除 . 和 .. 條目
        echo json_encode(array_values($fileList));
    }

    public function delete_files()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            $filesToDelete = $data["files"];

            if( PHP_OS_FAMILY == 'Linux'){
                $folderPath = "/var/www/html/database"; // 修改為你的資料夾路徑
            }else{
                $folderPath = "../"; // 修改為你的資料夾路徑
            }

            $result = ["message" => ""];

            foreach ($filesToDelete as $fileName) {
                $filePath = $folderPath . "/" . $fileName;
                if (file_exists($filePath) && is_file($filePath)) {
                    if (unlink($filePath)) {
                        $result["message"] .= "成功刪除檔案：$fileName\n";
                        $this->logMessage('delete DB success:'. json_encode($result).'');
                    } else {
                        $result["message"] .= "無法刪除檔案：$fileName\n";
                        $this->logMessage('delete DB fail:'. json_encode($result).'');
                    }
                } else {
                    $result["message"] .= "檔案不存在：$fileName\n";
                }
            }

            echo json_encode($result);
        } else {
            echo json_encode(["message" => "無效的請求方法"]);
        }

    }

    public function firmware_update() //FTP 上傳檔案大小限制 : 500M
    {
        // code...
    }

    public function db_sync()
    {
        // session_start();
        $this->language_auto(); //從瀏覽器帶入語系
        //multi language
        $language = array("language"=>$_SESSION['language']);

        // 如果檔案存在就引入它
        if(file_exists('../app/language/' . $language['language'] . '.php')){
            require_once '../app/language/' . $language['language'] . '.php';
        } else { //預設語系
            require_once '../app/language/en-us.php';
        }

        $error_message = '';
        if ( isset($_GET["way"]) ) {
            $way = $_GET["way"];
        }else if ( isset($_POST["way"]) ) {
            $way = $_POST["way"];
        }else{
            echo json_encode(array('error' => 'noway'));
            exit();
        }

        if($this->LoginCheck() == 1){
            echo json_encode(array('error' => $text['system_sync_warning_login']));
            exit();
        }

        // 1.先判斷系統linux才做事
        // 2.再分C2D or D2C
        //   C2D -> 把controller的db複製一份 並 取代目前iDas使用的db
        //   D2C -> 把iDas目前使用的db複製一份到 ftp資料夾，並取名為iDas.cfg -> 使用modbus指令 讓控制器更新設定
        if( PHP_OS_FAMILY == 'Linux'){

            if($way == 'C2D'){
                $this->logMessage('db_sync C2D start');
                $source = "/var/www/html/database/tcscon.db";
                $destination = "/var/www/html/database/iDas-tcscon.db";
                $source1 = "/var/www/html/database/tcsdev.db";
                $destination1 = "/var/www/html/database/iDas-tcsdev.db";
                if( file_exists($source) ){
                    copy($source, $destination);
                }else{
                    $error_message .= 'tcscon copy error,';
                }
                if( file_exists($source1) ){            
                    copy($source1, $destination1);
                }else{
                    $error_message .= 'tcsdev copy error';
                }

                $this->logMessage('error message:'.$error_message);
                $this->logMessage('db_sync C2D end');

                $data = array('error' => $error_message);
                echo json_encode($data);

            }else if ($way == 'D2C') {

                $check_result = $this->SyncCheck();
                if($check_result['warning'] != ''){
                    echo json_encode(array('error' => $check_result['warning']));
                    exit();
                }

                //判斷iDas的DB版本是否小於控制器
                // $C_DB_Version = $this->SettingModel->Get_Controller_DB_version();
                // $Controller_Info = $this->SettingModel->GetControllerInfo();
                // if($Controller_Info['tcscondb_version'] < $C_DB_Version){
                //     echo json_encode(array('error' => 'iDas的DB版本小於控制器'));
                //     exit();
                // }

                $this->logMessage('db_sync D2C start');
                $source = "/var/www/html/database/iDas-tcscon.db";
                $destination = "/mnt/ramdisk/FTP/iDas.cfg";
                
                if (copy($source, $destination)) {
                    require_once '../modules/phpmodbus-master/Phpmodbus/ModbusMaster.php';
                    $modbus = new ModbusMaster("127.0.0.1", "TCP");
                    try {
                        $modbus->port = 502;
                        $modbus->timeout_sec = 10;
                        $data = array(1, 26948, 24947);
                        $dataTypes = array("INT","INT","INT","INT","INT","INT","INT","INT","INT","INT","INT","INT","INT","INT","INT","INT");

                        // FC 3
                        // $recData = $modbus->readMultipleRegisters(1, 4096, 6);

                        // FC 16
                        $modbus->writeMultipleRegister(0, 506, $data, $dataTypes);
                        $this->logMessage('modbus write 506 ,array = '.implode("','",$data));
                        $this->logMessage('modbus status:'.$modbus->status);
                        echo json_encode(array('error' => ''));
                        exit();

                    }
                    catch (Exception $e) {
                        // Print error information if any
                        // echo $modbus;
                        // echo $e;
                        $this->logMessage('modbus write 506 fail');
                        $this->logMessage('modbus status:'.$modbus->status);
                        $this->logMessage('db_sync D2C end');
                        echo json_encode(array('error' => 'modbus error'));
                        exit();
                    }
                }else{
                    $this->logMessage('copy db error');
                    $this->logMessage('db_sync D2C end');
                    echo json_encode(array('error' => 'copy db error'));
                    exit();
                }
       
            }else{
                echo json_encode(array('error' => 'wrongway'));
                exit();
            }

        }else{
            echo json_encode(array('error' => ''));
            exit();
        }

    }

    //DB匯入提醒判斷
    public function SyncCheck($value='')
    {
        // session_start();
        $this->language_auto(); //從瀏覽器帶入語系
        //multi language
        $language = array("language"=>$_SESSION['language']);
        // 如果檔案存在就引入它
        if(file_exists('../app/language/' . $language['language'] . '.php')){
            require_once '../app/language/' . $language['language'] . '.php';
        } else { //預設語系
            require_once '../app/language/en-us.php';
        }
        
        //C2D可以不判斷
        if ( isset($_GET["way"]) ) {
            $way = $_GET["way"];
        }else if ( isset($_POST["way"]) ) {
            $way = $_POST["way"];
        }

        // 1. filetime
        // 2. db version
        // 3. compare
        $notice = '';
        $warning = '';
        $Das_DB_Location = '/var/www/html/database/iDas-tcscon.db';
        $Con_DB_Location = '/var/www/html/database/tcscon.db';

        if($this->LoginCheck() == 1){
            echo json_encode(array('warning' => $text['system_sync_warning_login']));
            exit();
        }

        if($way == 'C2D'){
            echo json_encode( array('notice'=>'','warning'=>'') );
            exit();
        }

        if( PHP_OS_FAMILY == 'Linux' && $way == 'D2C'){

            //時間差異提醒
            if( filemtime($Con_DB_Location) > filemtime($Das_DB_Location) ){
                $notice = $text['system_sync_notice'].date("Y-m-d H:i:s.", filemtime($Con_DB_Location));
            }

            //DB版本差異判斷
            $C_DB_Version = $this->SettingModel->Get_Controller_DB_version();
            $Controller_Info = $this->SettingModel->GetControllerInfo();
            if ($Controller_Info['tcscondb_version'] < $C_DB_Version) {
                $warning = $text['system_sync_warning'];
            }

            //idas版本驗證 符合match_gtcs_app_version
            $match_gtcs_app_version = $this->AdminModel->Get_Das_Config('match_gtcs_app_version');
            $C_Device_Vesion = $this->SettingModel->Get_Controller_Device_version();
            if($match_gtcs_app_version != $C_Device_Vesion){
                $warning = 'APP Version Not Match';
            }

            //DB欄位差異判斷
            if(!$this->Database_Column_Diff()){
                $warning .= 'DB is different';
            }
            
            //資料是否有Null判斷
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' && $_SERVER['REQUEST_METHOD'] == 'GET' ) {
            // 这是一个外部的 AJAX 请求
            echo json_encode( array('notice'=>$notice,'warning'=>$warning) );
            exit();
        } else {
            // 这是内部调用
            return array('notice'=>$notice,'warning'=>$warning);
        }

    }

    //get barcode
    public function GetBarcodes()
    {
        $barcodes = $this->SettingModel->GetAllBarcodes();

        return $barcodes;
    }

    //update barcode
    public function Update_Barcode()
    {
        $input_check = true;
        $error_message = '';
        if( !empty($_POST['barcode_name']) && isset($_POST['barcode_name'])  ){
            $barcode_name = $_POST['barcode_name'];
        }else{ 
            $input_check = false;
            $error_message .= "barcode_name,";
        }
        if( !empty($_POST['barcode_from']) && isset($_POST['barcode_from'])  ){
            $barcode_from = $_POST['barcode_from'];
        }else{ 
            $input_check = false;
            $error_message .= "barcode_from,";
        }
        if( !empty($_POST['barcode_count']) && isset($_POST['barcode_count'])  ){
            $barcode_count = $_POST['barcode_count'];
        }else{ 
            $input_check = false;
            $error_message .= "barcode_count,";
        }
        if(  isset($_POST['barcode_mode'])  ){
            $barcode_mode = $_POST['barcode_mode'];
        }else{ 
            $input_check = false;
            $error_message .= "barcode_mode,";
        }
        if(  isset($_POST['Job_Select'])  ){
            $Job_Select = $_POST['Job_Select'];
        }else{ 
            $input_check = false;
            $error_message .= "Job_Select,";
        }
        if(  isset($_POST['Seq_Select'])  ){
            $Seq_Select = $_POST['Seq_Select'];
        }else{ 
            $input_check = false;
            $error_message .= "Seq_Select,";
        }

        if($input_check){
            $barcode_result = $this->SettingModel->Update_Barcode($barcode_name,$barcode_from,$barcode_count,$barcode_mode,$Job_Select,$Seq_Select);
            if ($barcode_result) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('edit barcode job:'.$Job_Select.',barcodes:'.$barcode_name.' copyDB success');
                } else {
                    $this->logMessage('edit barcode job:'.$Job_Select.',barcodes:'.$barcode_name.' copyDB fail');
                }
                $data = [
                    'result' => 'success',
                    'error_message' => $error_message
                ];
            }else{
                $data = [
                    'result' => 'fail',
                    'error_message' => $error_message
                ];
            }
        }else{
            $data = [
                'result' => 'fail',
                'error_message' => $error_message
            ];
        }

        echo json_encode($data);
    }

    public function GetJobSeq()
    {
        $input_check = true;
        $error_message = '';
        if( !empty($_GET['job_id']) && isset($_GET['job_id'])  ){
            $job_id = $_GET['job_id'];
        }else{ 
            $input_check = false;
            $error_message .= "job_id,";
        }

        if($input_check){
            $result = $this->SettingModel->get_seq_list($job_id);
            echo json_encode($result);
            exit();
        }else{
            $data = [
                'result' => 'fail',
                'error_message' => $error_message
            ];
            echo json_encode($data);
            exit();
        }
    }

    public function GetJobBarcode()
    {
        $input_check = true;
        $error_message = '';
        if( !empty($_GET['job_id']) && isset($_GET['job_id'])  ){
            $job_id = $_GET['job_id'];
        }else{ 
            $input_check = false;
            $error_message .= "job_id,";
        }

        if($input_check){
            $result = $this->SettingModel->get_job_barcode($job_id);
            echo json_encode($result);
            exit();
        }else{
            $data = [
                'result' => 'fail',
                'error_message' => $error_message
            ];
            echo json_encode($data);
            exit();
        }
    }

    public function delete_barcodes()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = json_decode(file_get_contents("php://input"), true);
            $filesToDelete = $data["jobs"];

            $result = ["message" => ""];

            foreach ($filesToDelete as $job_id) {
                $this->SettingModel->delete_job_barcode($job_id);
            }

            echo json_encode($result);
        } else {
            echo json_encode(["message" => "無效的請求方法"]);
        }

    }

    public function iDas_Update()
    {
        $filename = 'update_package.pack';
        $file_location = '';
        $message = '';
        if( PHP_OS_FAMILY == 'Linux'){
            $file_location = '/mnt/ramdisk/';
        }else{//windows暫不考慮升級，可能整包升級
            $file_location = $_SERVER['DOCUMENT_ROOT'].'/';
            echo json_encode(["message" => 'not for windows']);
            exit();
        }

        if(empty($_FILES)){
            echo json_encode(["message" => 'no file']);
            exit();
        }

        if ( 0 < $_FILES['file']['error'] ) {
            echo json_encode(["message" => $_FILES['file']['error']]);
            exit();
        } else {
            //將檔案移到指定位置
            $result =  move_uploaded_file($_FILES['file']['tmp_name'], $file_location . $filename);
        }

        $extract_result = $this->Extract_File($file_location,$filename);
        $file_path = $file_location.'package_temp/package/verify';
        
        if (file_exists($file_path) && $extract_result) {
            $str = file_get_contents($file_path); //將整個檔案內容讀入到一個字串中
            $str = str_replace("\r\n", "<br />", $str);
            $verify_data = json_decode($str,true);
            $result = $verify_data;

            $package_version = $verify_data['Package_Version'];
            $match_gtcs_version = $verify_data['Match_GTCS_Version'];
            $match_gtcs_db_version = $verify_data['Match_GTCS_DB_Version'];

            $current_device_info = $this->SettingModel->get_update_info();

            //gtcs與gtcs db版本與更新包相符才會將檔案升級
            if( $match_gtcs_version == $current_device_info['device_version'] && $match_gtcs_db_version == $current_device_info['tcscondb_version'] ){
                if( PHP_OS_FAMILY == 'Linux'){
                    $destination = '/var/www/html/das/';
                }else{
                    $destination = $file_location.'/das';
                }
                exec("sudo chmod 777 -R /var/www/html/das");

                $this->copyFolder($file_location.'/package_temp/package/das',$destination); //複製資料夾
                
                //update current idas version
                $this->SettingModel->update_idas_vesrion($package_version);
                $this->SettingModel->update_idas_match_gtcs_app_version($match_gtcs_version);
                //update file permissions
                exec("sudo chmod 777 -R /var/www/html/das");

            }else{
                $message = 'version not match';
                // $message .= ', package device match version = '.$match_gtcs_version;
                // $message .= ', package db match version = '.$match_gtcs_db_version;
                // $message .= ', controller device version = '.$current_device_info['device_version'];
                // $message .= ', controller db version = '.$current_device_info['tcscondb_version'];
            }

            $this->deleteFolder($file_location.'package_temp'); //刪除資料夾
            unlink($file_location.''.$filename); //刪除檔案

        }else{
            $this->deleteFolder($file_location.'/package_temp'); //刪除資料夾
            unlink($file_location.''.$filename); //刪除檔案
            $message = 'wrong file';
        }

        echo json_encode(["message" => $message]);
    }

    public function Extract_File($file_location,$filename)
    {
        // $filename = 'update_package.pack';
        $zip = new ZipArchive;

        if($zip->open($file_location.''.$filename)===TRUE){
            if($zip->setPassword('Vfxh]QaXxZF-eT1L9b@%pJ-F#U>]95Fr_9GQf5]KtZRhXiHXJ-6QW86.gXQdp9yEZK@fxVF!WJ>PXMdK]>eeh*_-=0')){
                $res = $zip->extractTo($file_location.'package_temp/'); //避免覆蓋，將解壓縮資料放進該資料夾
                $zip->close();
                return $res;
            }else{
                return false;
            }
            // echo "解壓縮完成";
        }else{
            return false;
        }

    }

    public function copyFolder($source, $destination) {
        if (is_dir($source)) {
            @mkdir($destination);
            
            $directory = dir($source);

            while (false !== ($entry = $directory->read())) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }

                if (is_dir("$source/$entry")) {
                    $this->copyFolder("$source/$entry", "$destination/$entry");
                    continue;
                }

                copy("$source/$entry", "$destination/$entry");
            }

            $directory->close();
        } else {
            copy($source, $destination);
        }
    }

    public function deleteFolder($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        $this->deleteFolder($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function Import_Config()
    {
        $file_location = '';
        $result = '';

        if(empty($_FILES)){
            echo json_encode(["Error" => 'no file']);
            exit();
        }


        if( PHP_OS_FAMILY == 'Linux'){
            $this->logMessage('Import config start');

            $destination = "/mnt/ramdisk/FTP/iDas.cfg";
            //將檔案移到指定位置
            $result =  move_uploaded_file($_FILES['file']['tmp_name'], $destination);

            if ($result) {
                require_once '../modules/phpmodbus-master/Phpmodbus/ModbusMaster.php';
                $modbus = new ModbusMaster("127.0.0.1", "TCP");
                try {
                    $modbus->port = 502;
                    $modbus->timeout_sec = 10;
                    $data = array(1, 26948, 24947);
                    $dataTypes = array("INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT");

                    // FC 16
                    $modbus->writeMultipleRegister(0, 506, $data, $dataTypes);
                    $this->logMessage('modbus write 506 ,array = '.implode("','", $data));
                    $this->logMessage('modbus status:'.$modbus->status);
                    $this->logMessage('Import config end');
                    echo json_encode(array('error' => ''));
                    exit();

                } catch (Exception $e) {
                    // Print error information if any
                    // echo $modbus;
                    // echo $e;
                    $this->logMessage('modbus write 506 fail');
                    $this->logMessage('modbus status:'.$modbus->status);
                    $this->logMessage('Import config end');
                    echo json_encode(array('error' => 'modbus error'));
                    exit();
                }
            } else {
                $this->logMessage('copy db error');
                $this->logMessage('Import config end');
                echo json_encode(array('error' => 'copy db error'));
                exit();
            }

        }else{//windows暫不考慮升級，可能整包升級
            // $this->logMessage('Import config start');
            $destination = "../tcscon.db";
            $result =  move_uploaded_file($_FILES['file']['tmp_name'], $destination);
            if($result){
                echo json_encode(["error" => '']);
                exit();
            }else{
                echo json_encode(["error" => 'fail']);
                exit();
            }            
        }

        echo json_encode(["message" => $result]);
    }

    public function FirmwareUpdate()
    {
        $file_location = '';
        $result = '';

        if(empty($_FILES)){
            echo json_encode(["Error" => 'no file']);
            exit();
        }

        if( PHP_OS_FAMILY == 'Linux'){
            $this->logMessage('firmware update start');

            // $destination = "/mnt/ramdisk/FTP/iDas.cfg";
            $destination = "/mnt/ramdisk/FTP/".$_FILES['file']['name'];
            $filenameWithoutExtension = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
            //將檔案移到指定位置
            $result =  move_uploaded_file($_FILES['file']['tmp_name'], $destination);
            $name_int16 = $this->asciiToHexToInt($filenameWithoutExtension);

            if ($result) {
                require_once '../modules/phpmodbus-master/Phpmodbus/ModbusMaster.php';
                $modbus = new ModbusMaster("127.0.0.1", "TCP");
                try {
                    $modbus->port = 502;
                    $modbus->timeout_sec = 10;
                    $data = array(1, $name_int16[0], $name_int16[1], $name_int16[2], $name_int16[3], $name_int16[4], $name_int16[5], $name_int16[6], $name_int16[7], $name_int16[8], $name_int16[9], $name_int16[10], $name_int16[11]);
                    $dataTypes = array("INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT", "INT");

                    // FC 16
                    $modbus->writeMultipleRegister(0, 480, $data, $dataTypes);
                    $this->logMessage('modbus write 480 ,array = '.implode("','", $data));
                    $this->logMessage('modbus status:'.$modbus->status);
                    $this->logMessage('firmware update end');
                    echo json_encode(array('error' => ''));
                    exit();

                } catch (Exception $e) {
                    // Print error information if any
                    // echo $modbus;
                    // echo $e;
                    $this->logMessage('modbus write 480 fail');
                    $this->logMessage('modbus status:'.$modbus->status);
                    $this->logMessage('firmware update end');
                    echo json_encode(array('error' => 'modbus error'));
                    exit();
                }
            } else {
                $this->logMessage('copy db error');
                $this->logMessage('firmware update end');
                echo json_encode(array('error' => 'copy db error'));
                exit();
            }

        }else{//windows暫不考慮升級，可能整包升級
            // $this->logMessage('Import config start');
            $file_location = $_SERVER['DOCUMENT_ROOT'].'/';
            echo json_encode(["Error" => 'not for windows']);
            exit();
        }

        echo json_encode(["message" => $result]);
    }

    function asciiToHexToInt($input) {
        // 将 ASCII 字符转换为十六进制
        $hex = bin2hex($input);

        // 将十六进制字符串按每 4 个字符为一组进行分割
        $chunks = str_split($hex, 4);

        $result = array();
        foreach ($chunks as $chunk) {
            // 将每组 4 个字符的十六进制转换为整数
            $result[] = hexdec($chunk);
        }

        return $result;
    }

    //DB欄位差異判斷
    function Database_Column_Diff()
    {
        $dbPath1 = '/var/www/html/database/iDas-tcscon.db';
        $dbPath2 = '/var/www/html/database/tcscon.db';

        if ($this->validateTableStructure($dbPath1, $dbPath2)) {
            // echo "两个数据库的表结构相同。\n";
        } else {
            // echo "两个数据库的表结构不同。\n";
            return false;
        }

        //確認idas的設定db沒有null
        $result = $this->checkForNullValues($dbPath1);
        if(!$result){
            return false;
        }else{
            return true;
        }

    }


    // 連接到SQLite資料庫
    function connectToSQLite($dbPath) {
         try {
             $pdo = new PDO("sqlite:$dbPath");
             $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             return $pdo;
         } catch (PDOException $e) {
             echo "連線到資料庫失敗: " . $e->getMessage();
             return null;
         }
    }

    // 驗證兩個SQLite資料庫中所有表格的列數和列名是否相同
    function validateTableStructure($dbPath1, $dbPath2) {
         $pdo1 = $this->connectToSQLite($dbPath1);
         $pdo2 = $this->connectToSQLite($dbPath2);

         if (!$pdo1 || !$pdo2) {
             return false;
         }

         $tables1 = $this->getTablesInfo($pdo1);
         $tables2 = $this->getTablesInfo($pdo2);

         if (count($tables1) !== count($tables2)) {
             return false;
         }

         foreach ($tables1 as $table => $columns1) {
             if (!isset($tables2[$table])) {
                 return false;
             }

             $columns2 = $tables2[$table];
             if ($columns1 !== $columns2) {
                 return false;
             }
         }

         return true;
    }

    // 取得資料庫中所有表格的列數和列名
    function getTablesInfo($pdo) {
         $tables = array();

         $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
         $tableNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

         foreach ($tableNames as $tableName) {
             $stmt = $pdo->query("PRAGMA table_info('$tableName')");
             $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
             $tables[$tableName] = array_map(function($column) {
                 return $column['name'];
             }, $columns);
         }

         return $tables;
    }

    // 檢查SQLite資料庫中所有表格的欄位是否有NULL值
    function checkForNullValues($dbPath) {
         $pdo = $this->connectToSQLite($dbPath);

         if (!$pdo) {
             return false;
         }

         $tables = $this->getTablesInfo($pdo);

         foreach ($tables as $tableName => $columns) {
             foreach ($columns as $column) {
                 $stmt = $pdo->query("SELECT COUNT(*) FROM $tableName WHERE $column IS NULL");
                 $rowCount = $stmt->fetchColumn();
                 if ($rowCount > 0) {
                     // echo "在表 $tableName 的欄位 $column 中發現了 NULL 值。\n";
                     return false;
                 }
             }
         }

         return true;
    }

    
}
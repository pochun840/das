<?php

class Jobs extends Controller
{
    private $jobModel;
    private $DashboardModel;
    private $ToolModel;
    private $SettingModel;
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->jobModel = $this->model('Job');
        $this->DashboardModel = $this->model('Dashboard');
        $this->SettingModel = $this->model('Setting');
        $this->ToolModel = $this->model('Tool');
    }

    // 取得所有Jobs
    public function index($job_type){

        if(strtolower($job_type) == 'advanced'){
            $job_type = 'advanced';
        }else{
            $job_type = 'normal';
        }
        $isMobile = $this->isMobileCheck();

        $jobs = $this->jobModel->getJobs($job_type);
        $tool_info = $this->DashboardModel->get_tool_info();
        $controller_Info = $this->ToolModel->GetControllerInfo();
        $device_info = $this->Device_Info();

        $data = [
            'jobs' => $jobs,
            'job_type' => $job_type,
            'controller_Info' => $controller_Info,
            'tool_info' => $tool_info,
            'device_info' => $device_info,
        ];

        if($isMobile){
            $this->view('jobs/job_management_m', $data);
        }else{
            $this->view('jobs/job_management', $data);
        }

        
    }

    public function job_management($job_type){

        if(strtolower($job_type) == 'advanced'){
            $job_type = 'advanced';
        }else{
            $job_type = 'normal';
        }

        $jobs = $this->jobModel->getJobs($job_type);
        
        $data = [
            'jobs' => $jobs,
            'job_type' => $job_type
        ];
        
        $this->view('jobs/job_management', $data);
    }

    public function get_head_job_id_normal(){
        //因job id是由系統指派，在create job時，抓取最前面的job id 帶入
        $head_job_id = $this->jobModel->get_head_job_id('normal');

        echo json_encode($head_job_id);
    }

    public function get_head_job_id_advanced(){
        //因job id是由系統指派，在create job時，抓取最前面的job id 帶入
        $head_job_id = $this->jobModel->get_head_job_id('advanced');

        echo json_encode($head_job_id);
    }

    //get job by id
    public function get_job_by_id(){
        $input_check = true;
        //因job id是由系統指派，在create job時，抓取最前面的job id 帶入
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_data = $this->jobModel->get_job_by_id($job_id);
            //轉換扭力單位 - 輸出
            $system_unit = $this->SettingModel->Get_System_Toq_Unit();
            $TransType = $system_unit;
            $inputType = $job_data['torque_unit']; // 0:公斤米 1:牛頓米 2:公斤公分 3:英鎊英寸
            $job_data['reverse_threshold_torque'] = $this->unitConvert($job_data['reverse_threshold_torque'], $inputType, $TransType);
        }

        echo json_encode($job_data);
    }

    //create & update job
    public function create_job(){
        $input_check = true;
        $res = 'fail';
        $error_message = '';
        $tool_info = $this->DashboardModel->get_tool_info();
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = preg_replace('/[^0-9]/', '', $_POST['job_id']);
        }else{ 
            $input_check = false; 
            $error_message .= "job_id,";
        }

        if( !empty($_POST['job_name']) && isset($_POST['job_name'])  ){
            $job_name = preg_replace('/[^\p{L}0-9\-]+/u', '', $_POST['job_name']);
        }else{ 
            $input_check = false; 
            $error_message .= "job_name,";
        }

        if( isset($_POST['ok_job_option']) && $_POST['ok_job_option']>=0 ){
            $ok_job_option = $_POST['ok_job_option'];    
        }else{ 
            $input_check = false; 
            $error_message .= "ok_job_option,";
        }

        if( isset($_POST['ok_job_stop_option'])  && $_POST['ok_job_stop_option']>=0 ){
            $ok_job_stop_option = $_POST['ok_job_stop_option'];    
        }else{ 
            $input_check = false; 
            $error_message .= "ok_job_stop_option,";
        }

        if( isset($_POST['unfasten_direction_option'])  && $_POST['unfasten_direction_option']>=0 ){
            $unfasten_direction_option = $_POST['unfasten_direction_option'];    
        }else{ 
            $input_check = false; 
            $error_message .= "unfasten_direction_option,";
        }

        if( !empty($_POST['unfasten_RPM']) && isset($_POST['unfasten_RPM']) && ($_POST['unfasten_RPM'] <= $tool_info['tool_maxrpm']) && ($_POST['unfasten_RPM'] >= $tool_info['tool_minrpm'])  ){
            $unfasten_RPM = $_POST['unfasten_RPM'];
            $unfasten_RPM = preg_replace('/[^0-9]/', '', $_POST['unfasten_RPM']);
        }else{ 
            $input_check = false; 
            $error_message .= "unfasten_RPM,";
        }

        if( !empty($_POST['unfasten_force']) && isset($_POST['unfasten_force']) && ($_POST['unfasten_force'] <= 110)  ){
            $unfasten_force = $_POST['unfasten_force'];
            $unfasten_force = preg_replace('/[^0-9]/', '', $_POST['unfasten_force']);

        }else{ 
            $input_check = false; 
            $error_message .= "unfasten_force,";
        }

        if( isset($_POST['reverse_threshold_torque'])  && $_POST['reverse_threshold_torque']>=0 ){
            $reverse_threshold_torque = $_POST['reverse_threshold_torque'];    
        }else{ 
            $input_check = false; 
            $error_message .= "reverse_threshold_torque,";
        }

        if( isset($_POST['reverse_cnt_mode'])  && $_POST['reverse_cnt_mode']>=0 ){
            $reverse_cnt_mode = $_POST['reverse_cnt_mode'];    
        }else{ 
            $input_check = false; 
            $error_message .= "reverse_cnt_mode,";
        }

        if($input_check){
            $job_data = [
                'job_id' => $job_id,
                'job_name' => $job_name,
                'ok_job_option' => $ok_job_option,
                'ok_job_stop_option' => $ok_job_stop_option,
                'unfasten_direction_option' => $unfasten_direction_option,
                'unfasten_RPM' => $unfasten_RPM,
                'unfasten_force' => $unfasten_force,
                'reverse_threshold_torque' => $reverse_threshold_torque,
                'reverse_cnt_mode' => $reverse_cnt_mode
            ];

            //轉換扭力單位 - 輸入 看起來只要管輸出就好，輸入不轉換
            $system_unit = $this->SettingModel->Get_System_Toq_Unit();
            // $TransType = 1;
            // $inputType = $system_unit; // 0:公斤米 1:牛頓米 2:公斤公分 3:英鎊英寸
            // $job_data['reverse_threshold_torque'] = $this->unitConvert($job_data['reverse_threshold_torque'], $inputType, $TransType);
            $job_data['torque_unit'] = $system_unit;

            $validate_result = $this->validate_create_job($job_data);
            $error_message .= $validate_result['error_message'];

            if( !$validate_result['result'] ){
                //將資料寫入DB
                $res = $this->jobModel->create_Job($job_data);
                $data = [
                    'result' => 'success',
                    'error_message' => $error_message
                ];

                if($res){// copy DB
                    $copy_result =  $this->copyDB_to_RamdiskDB();
                    if($copy_result){
                        $this->logMessage('edit job job:'. $job_id.',job_name:'.$job_name.' copyDB success');
                    }else{
                        $this->logMessage('edit job job:'. $job_id.',job_name:'.$job_name.' copyDB fail');
                    }
                }
            }else{
                $data = [
                    'result' => 'validate fail',
                    'error_message' => $error_message
                ];
            }
        }else{
            $data = [
                'result' => $res
            ];
        }

        echo json_encode($data);
    }

    //delete job
    public function delete_job_by_id()
    {
        $input_check = true;
        //因job id是由系統指派，在create job時，抓取最前面的job id 帶入
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            //delete job table
            $job_data = $this->jobModel->delete_job_by_id($job_id);
            //delete sequecne table
            $job_data = $this->jobModel->delete_sequence_by_job_id($job_id);
            //delete normalsetp table
            if($job_id>100){
                $job_data = $this->jobModel->delete_advancedstep_by_job_id($job_id);
            }else{
                $job_data = $this->jobModel->delete_normalstep_by_job_id($job_id);    
            }
            //delete input/output/barcode table
            $job_data = $this->jobModel->delete_input_by_job_id($job_id);
            $job_data = $this->jobModel->delete_output_by_job_id($job_id);
            $job_data = $this->jobModel->delete_barcode_by_job_id($job_id);

            if($job_data){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('delete job job:'. $job_id.' copyDB success');
                }else{
                    $this->logMessage('delete job job:'. $job_id.' copyDB fail');
                }
            }
            
        }

        echo json_encode($job_data);
    }

    //copy job
    public function copy_job()
    {
        $input_check = true;
        $res = 'fail';
        $error_message = '';
        if( !empty($_POST['from_job_id']) && isset($_POST['from_job_id'])  ){
            $from_job_id = $_POST['from_job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "from_job_id,";
        }

        if( !empty($_POST['from_job_name']) && isset($_POST['from_job_name'])  ){
            $from_job_name = $_POST['from_job_name'];    
        }else{ 
            $input_check = false; 
            $error_message .= "from_job_name,";
        }

        if( !empty($_POST['to_job_id']) && isset($_POST['to_job_id'])  ){
            $to_job_id = $_POST['to_job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "to_job_id,";
        }

        if( !empty($_POST['to_job_name']) && isset($_POST['to_job_name'])  ){
            $to_job_name = $_POST['to_job_name'];    
        }else{ 
            $input_check = false; 
            $error_message .= "to_job_name,";
        }

        if($input_check){
            //check if to_job_id exist
            $dupli_flag = false;
            $dupli_flag = $this->jobModel->job_id_repeat($to_job_id);

            //copy job table
            $job_data = $this->jobModel->copy_job_by_id($from_job_id,$to_job_id,$to_job_name,$dupli_flag);
            //copy sequecne table
            $job_data = $this->jobModel->copy_sequence_by_job_id($from_job_id,$to_job_id,$dupli_flag);
            //copy normalsetp table
            if($from_job_id > 100 && $to_job_id >100){
                $job_data = $this->jobModel->copy_advancedstep_by_job_id($from_job_id,$to_job_id,$dupli_flag);
            }else{
                $job_data = $this->jobModel->copy_normalstep_by_job_id($from_job_id,$to_job_id,$dupli_flag);
            }

            if($job_data){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('copy job from_job_id:'. $from_job_id.',to_job_id:'.$to_job_id.' copyDB success');
                }else{
                    $this->logMessage('copy job from_job_id:'. $from_job_id.',to_job_id:'.$to_job_id.' copyDB fail');
                }
            }
            
        }

        echo json_encode($job_data);

    }

    //validate create job
    public function validate_create_job($data){
        $flag = false;
        $error_message = '';
        $tool_rpm = $this->jobModel->get_tool_rpm();
        // $tool_torque = $this->jobModel->max_rpm_check();

        if( empty($data['job_name']) || $data['job_name'] == '' )
            { 
                $flag = true;
                $error_message .= 'job_name為空值,';
            } //text
        
        if( $data['unfasten_RPM'] > $tool_rpm['tool_maxrpm'] || $data['unfasten_RPM'] < $tool_rpm['tool_minrpm'] )
            { 
                $flag = true; 
                $error_message .= 'unfasten_RPM 異常,';
            } //integer 

        if( $data['unfasten_force'] > 110 )
            { 
                $flag = true; 
                $error_message .= 'unfasten_force 異常,';
            } //integer max 110

        $data = [
                'result' => $flag,
                'error_message' => $error_message
            ];

        return $data;

    }

    public function job_id_repeat_check()
    {
        $job_id = $_POST['job_id'];
        $result = $this->jobModel->job_id_repeat($job_id);

        $data = [
                'result' => $result
            ];

        echo json_encode($data);
    }
    
}

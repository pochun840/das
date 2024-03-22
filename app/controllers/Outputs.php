<?php

class Outputs extends Controller
{
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->OutputModel = $this->model('Output');
        $this->InputModel = $this->model('Input');
    }

    // 取得所有Jobs
    public function index(){

        //要檢查是否有alljobinput，有的話要直接帶入

        $job_list = $this->InputModel->get_job_list();
        $isMobile = $this->isMobileCheck();
        $device_data = $this->InputModel->get_input_alljob();
        $device_info = $this->Device_Info();

        $data = [
            'isMobile' => $isMobile,
            'job_list' => $job_list,
            'device_data' => $device_data,
            'device_info' => $device_info
        ];
        
        if($isMobile){
            $this->view('output/index_m', $data);
        }else{
            $this->view('output/index', $data);
        }

    }

    // get_input_by_job_id
    public function get_output_by_job_id(){

        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }

        // if($input_check){
        //     $job_outputs = $this->OutputModel->get_output_by_job_id($job_id);    
        // }
        if($input_check){
            $job_outputs = $this->OutputModel->get_output_by_job_id($job_id);    
            //調整Array格式 event,pin,wave,time
            // $tempA = array();
            // $tempB = array();
            // foreach ($job_outputs as $key => $value) {
            //     $tempB['output_jobid'] = $value['output_jobid'];
            //     $tempB['output_event'] = $value['output_event'];
            //     for ($i=2; $i <= 10; $i++) { 
            //         if($value['output_pin'.$i] > 0){
            //             $tempB['output_pin'] = $i;
            //             $tempB['wave'] = $value['output_pin'.$i];
            //         }
            //     }
            //     $tempA[] = $tempB;
            //     $job_inputs[$key]['output_pin'] = $tempB['output_pin'];
            //     $job_inputs[$key]['wave'] = $tempB['wave'];
            // }
        }

        echo json_encode($job_outputs);

    }

    public function check_job_output_conflict($value='')
    {
        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['event_id']) && isset($_POST['event_id'])  ){
            $event_id = $_POST['event_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->OutputModel->check_job_output_conflict($job_id,$event_id);    
        }

        echo json_encode($job_inputs);
    }

    public function create_output_event($value='')
    {
        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['event_id']) && isset($_POST['event_id'])  ){
            $event_id = $_POST['event_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['output_pin']) && isset($_POST['output_pin'])  ){
            $output_pin = $_POST['output_pin'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['option']) && isset($_POST['option'])  ){
            $option = $_POST['option'];
        }else{ 
            $input_check = false; 
        }
        if( isset($_POST['time']) && $_POST['time']>=0 && $_POST['time'] <= 10000 ){
            $time = $_POST['time'];
            if($time == ''){
                $time = 0;//預設值
            }
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->OutputModel->create_output($job_id,$event_id,$output_pin,$option,$time);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('edit output job:'.$job_id.',event_id:'.$event_id.' copyDB success');
                } else {
                    $this->logMessage('edit output job:'.$job_id.',event_id:'.$event_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    public function copy_output()
    {
        $input_check = true;
        if( !empty($_POST['from_job_id']) && isset($_POST['from_job_id'])  ){
            $from_job_id = $_POST['from_job_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['to_job_id']) && isset($_POST['to_job_id'])  ){
            $to_job_id = $_POST['to_job_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->OutputModel->copy_output_by_id($from_job_id,$to_job_id);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('copy output from_job_id:'.$from_job_id.',to_job_id:'.$to_job_id.' copyDB success');
                } else {
                    $this->logMessage('copy output from_job_id:'.$from_job_id.',to_job_id:'.$to_job_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    public function delete_output(){
        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['event_id']) && isset($_POST['event_id'])  ){
            $event_id = $_POST['event_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->OutputModel->delete_output_event_by_id($job_id,$event_id);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('delete output from job:'.$job_id.',event_id:'.$event_id.' copyDB success');
                } else {
                    $this->logMessage('delete output from job:'.$job_id.',event_id:'.$event_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    public function output_alljob()
    {
        $input_check = true;
        if( isset($_POST['job_id']) && $_POST['job_id'] >= 0 ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->OutputModel->set_output_alljob($job_id);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('set outputall job:'.$job_id.' copyDB success');
                } else {
                    $this->logMessage('set outputall job:'.$job_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    


    
}
<?php

class Inputs extends Controller
{
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->InputModel = $this->model('Input');
        // $this->DashboardModel = $this->model('Dashboard');
    }

    // 取得所有Inputs
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
            $this->view('input/index_m', $data);
        }else{
            $this->view('input/index', $data);
        }
        

    }

    // get_input_by_job_id
    public function get_input_by_job_id(){

        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->InputModel->get_input_by_job_id($job_id);    
            //調整Array格式 event,pin,wave,time
            $tempA = array();
            $tempB = array();
            foreach ($job_inputs as $key => $value) {
                $tempB['input_jobid'] = $value['input_jobid'];
                $tempB['input_event'] = $value['input_event'];
                for ($i=2; $i <= 10; $i++) { 
                    if($value['input_pin'.$i] > 0){
                        $tempB['input_pin'] = $i;
                        $tempB['wave'] = $value['input_pin'.$i];
                    }
                }
                $tempA[] = $tempB;
                $job_inputs[$key]['input_pin'] = $tempB['input_pin'];
                $job_inputs[$key]['wave'] = $tempB['wave'];
            }
        }

        echo json_encode($job_inputs);

    }

    public function get_input_by_job_id_m(){

        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->InputModel->get_input_by_job_id($job_id);
            //調整Array格式 event,pin,wave,time
            $tempA = array();
            $tempB = array();
            foreach ($job_inputs as $key => $value) {
                $tempB['input_jobid'] = $value['input_jobid'];
                $tempB['input_event'] = $value['input_event'];
                for ($i=2; $i <= 10; $i++) { 
                    if($value['input_pin'.$i] > 0){
                        $tempB['input_pin'] = $i;
                        $tempB['wave'] = $value['input_pin'.$i];
                    }
                }
                $tempA[] = $tempB;
                $job_inputs[$key]['input_pin'] = $tempB['input_pin'];
                $job_inputs[$key]['wave'] = $tempB['wave'];
            }
        }

        echo json_encode($job_inputs);

    }

    public function check_job_event_conflict($value='')
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
            $job_inputs = $this->InputModel->check_job_event_conflict($job_id,$event_id);    
        }

        echo json_encode($job_inputs);
    }

    public function create_input_event($value='')
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
        if( !empty($_POST['input_pin']) && isset($_POST['input_pin'])  ){
            $input_pin = $_POST['input_pin'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['option']) && isset($_POST['option'])  ){
            $option = $_POST['option'];
        }else{ 
            $input_check = false; 
        }
        if( isset($_POST['gateconfirm'])  ){
            $gateconfirm = $_POST['gateconfirm'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->InputModel->create_input($job_id,$event_id,$input_pin,$option,$gateconfirm);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('edit input job:'.$job_id.',event_id:'.$event_id.' copyDB success');
                } else {
                    $this->logMessage('edit input job:'.$job_id.',event_id:'.$event_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    public function edit_input_event($value='')
    {
        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['event_id_new']) && isset($_POST['event_id_new'])  ){
            $event_id_new = $_POST['event_id_new'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['event_id_old']) && isset($_POST['event_id_old'])  ){
            $event_id_old = $_POST['event_id_old'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['input_pin']) && isset($_POST['input_pin'])  ){
            $input_pin = $_POST['input_pin'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['option']) && isset($_POST['option'])  ){
            $option = $_POST['option'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->InputModel->create_input($job_id,$event_id,$input_pin,$option);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('edit input job:'.$job_id.',event_id:'.$event_id.' copyDB success');
                } else {
                    $this->logMessage('edit input job:'.$job_id.',event_id:'.$event_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    public function copy_input()
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
            $job_inputs = $this->InputModel->copy_input_by_id($from_job_id,$to_job_id);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('copy input from job:'.$from_job_id.',to_job_id:'.$to_job_id.' copyDB success');
                } else {
                    $this->logMessage('copy input from job:'.$from_job_id.',to_job_id:'.$to_job_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    public function delete_input(){
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
            $job_inputs = $this->InputModel->delete_input_event_by_id($job_id,$event_id);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('delete input from job:'.$job_id.',event_id:'.$event_id.' copyDB success');
                } else {
                    $this->logMessage('delete input from job:'.$job_id.',event_id:'.$event_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }

    public function input_alljob()
    {
        $input_check = true;
        if( isset($_POST['job_id']) && $_POST['job_id'] >= 0 ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $job_inputs = $this->InputModel->set_input_alljob($job_id);
            if ($job_inputs) { // copy DB
                $copy_result = $this->copyDB_to_RamdiskDB();
                if ($copy_result) {
                    $this->logMessage('set inputall job:'.$job_id.' copyDB success');
                } else {
                    $this->logMessage('set inputall job:'.$job_id.' copyDB fail');
                }
            }
        }

        echo json_encode($job_inputs);
    }
    

    
}
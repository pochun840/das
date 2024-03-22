<?php

class Advancedsteps extends Controller
{
    private $advancedstepModel;
    private $DashboardModel;
    private $SettingModel;
    private $ToolModel;
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->advancedstepModel = $this->model('Advancedstep');
        $this->DashboardModel = $this->model('Dashboard');
        $this->SettingModel = $this->model('Setting');
        $this->ToolModel = $this->model('Tool');
    }

    // 取得所有Sequences
    public function index($job_id = 1,$sequence_id = 1){

        if( isset($job_id) && !empty($job_id) ){

        }else{
            $job_id = 101;
        }

        $advancedstep = $this->advancedstepModel->getAdvancedstep_by_job_seq_id($job_id,$sequence_id);
        $tool_info = $this->DashboardModel->get_tool_info();
        $controller_Info = $this->ToolModel->GetControllerInfo();

        //轉換扭力單位 - 輸出
        $system_unit = $this->SettingModel->Get_System_Toq_Unit();
        $TransType = $system_unit;
        $inputType = $advancedstep[0]['torque_unit']; // 0:公斤米 1:牛頓米 2:公斤公分 3:英鎊英寸

        //tool table的扭力單位是牛頓米
        $tool_info['tool_maxtorque'] = $this->unitConvert($tool_info['tool_maxtorque'], 1, $TransType);
        $tool_info['tool_mintorque'] = $this->unitConvert($tool_info['tool_mintorque'], 1, $TransType);

        $torque_delta = $this->TorqueDelta((int)$tool_info['tool_maxtorque'],$controller_Info['device_torque_unit']);

        if($job_id<100){
            $job_type = 'normal';
        }else{
            $job_type = 'advanced';
        }

        $isMobile = $this->isMobileCheck();
        $device_info = $this->Device_Info();

        $data = [
            'advancedstep' => $advancedstep,
            'tool_info' => $tool_info,
            'job_id' => $job_id,
            'sequence_id' => $sequence_id,
            'sequence_name' => $advancedstep[0]['sequence_name'],
            'job_type' => $job_type,
            'controller_Info' => $controller_Info,
            'delta' => $torque_delta,
            'device_info' => $device_info
        ];        

        if($isMobile){
            $this->view('advancedsteps/index_m', $data);
        }else{
            $this->view('advancedsteps/index', $data);
        }
        
    }

    //create seq
    public function create_step(){
        $input_check = true;
        $res = 'fail';
        $error_message = '';


        $valid_result = $this->validate_data($_POST);
        foreach ($_POST as $key => $value) {
            $step_data[$key] = $value;
        }

        if($valid_result['result']){
            //將資料寫入DB
            $step_data['torque_unit'] = $this->SettingModel->Get_System_Toq_Unit();
            $res = $this->advancedstepModel->edit_step($step_data);
            $data = [
                'result' => 'success',
                'error_message' => $valid_result['error_message']
            ];

            if($res){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('edit advancedstep job:'. $step_data['job_id'].',seq:'.$step_data['sequence_id'].',step_id:'.$step_data['step_id'].' copyDB success');
                }else{
                    $this->logMessage('edit advancedstep job:'.$step_data['job_id'].',seq:'.$step_data['sequence_id'].',step_id:'.$step_data['step_id'].' copyDB fail');
                }
            }

        }else{
            $data = [
                'result' => $valid_result['error_message']
            ];
        }

        echo json_encode($data);
    }

    public function validate_data($data)
    {
        $tool_info = $this->DashboardModel->get_tool_info();
        $input_check = true;
        $error_message = "";

        //把起子的上下線轉成目前系統的扭力單位，起子DB是存牛頓米
        $system_unit = $this->SettingModel->Get_System_Toq_Unit();
        $TransType = $system_unit; // 0:公斤米 1:牛頓米 2:公斤公分 3:英鎊英寸
        $tool_info['tool_maxtorque'] = $this->unitConvert($tool_info['tool_maxtorque'], 1, $TransType);
        $tool_info['tool_mintorque'] = $this->unitConvert($tool_info['tool_mintorque'], 1, $TransType);




        if (!empty($data['job_id']) && isset($data['job_id']) &&  $data['job_id'] >100 && $data['job_id'] < 171  ) {
            $job_id = $data['job_id'];
        } else {
            $input_check = false;
            $error_message .= "job_id, ";
        }

        if (!empty($data['sequence_id']) && isset($data['sequence_id']) && $data['sequence_id'] < 100 ) {
            $sequence_id = $data['sequence_id'];
        } else {
            $input_check = false;
            $error_message .= "sequence_id, ";
        }

        if (!empty($data['sequence_name']) && isset($data['sequence_name']) ) {
            $sequence_name = $data['sequence_name'];
        } else {
            $input_check = false;
            $error_message .= "sequence_name, ";
        }

        if ( isset($data['step_anglewindow']) && $data['step_anglewindow'] >=0 && $data['step_anglewindow'] <= 30600  ) {
            $step_anglewindow = $data['step_anglewindow'];
        } else {
            $input_check = false;
            $error_message .= "step_anglewindow, ";
        }

        if ( isset($data['step_angwin_target']) && $data['step_angwin_target'] >=0  && $data['step_angwin_target'] <= 30600) {
            $step_angwin_target = $data['step_angwin_target'];
        } else {
            $input_check = false;
            $error_message .= "step_angwin_target, ";
        }

        if (isset($data['step_delayttime']) && $data['step_delayttime'] >=0  && $data['step_delayttime'] <= 10 ) {
            $step_delayttime = $data['step_delayttime'];
        } else {
            $input_check = false;
            $error_message .= "step_delayttime, ";
        }

        if ( isset($data['step_highangle']) && $data['step_highangle'] >=0  && $data['step_highangle'] <=30600) {
            $step_highangle = $data['step_highangle'];
        } else {
            $input_check = false;
            $error_message .= "step_highangle, ";
        }

        if (isset($data['step_hightorque']) && $data['step_hightorque'] >= $tool_info['tool_mintorque']  && $data['step_hightorque'] <= $tool_info['tool_maxtorque']*1.1 ) {
            $step_hightorque = $data['step_hightorque'];
        } else {
            $input_check = false;
            $error_message .= "step_hightorque, ";
        }

        if (!empty($data['step_id']) && isset($data['step_id']) && $data['step_id'] <= 8 ) {
            $step_id = $data['step_id'];
        } else {
            $input_check = false;
            $error_message .= "step_id, ";
        }

        if ( isset($data['step_lowangle']) && $data['step_lowangle'] >=0  && $data['step_lowangle'] <= 30599) {
            $step_lowangle = $data['step_lowangle'];
        } else {
            $input_check = false;
            $error_message .= "step_lowangle, ";
        }

        if (isset($data['step_lowtorque']) && $data['step_lowtorque'] >=0 && $data['step_lowtorque'] <= $tool_info['tool_maxtorque']) {
            $step_lowtorque = $data['step_lowtorque'];
        } else {
            $input_check = false;
            $error_message .= "step_lowtorque, ";
        }

        if ( isset($data['step_monitoringangle']) && $data['step_monitoringangle'] >=0 && $data['step_monitoringangle'] <=2 ) {
            $step_monitoringangle = $data['step_monitoringangle'];
        } else {
            $input_check = false;
            $error_message .= "step_monitoringangle, ";
        }

        if ( isset($data['step_monitoringmode']) && $data['step_monitoringmode'] >=0  && $data['step_monitoringmode'] <=1 ) {
            $step_monitoringmode = $data['step_monitoringmode'];
        } else {
            $input_check = false;
            $error_message .= "step_monitoringmode, ";
        }

        if (!empty($data['step_name']) && isset($data['step_name'])) {
            $step_name = $data['step_name'];
        } else {
            $input_check = false;
            $error_message .= "step_name, ";
        }

        if ( isset($data['step_offsetdirection'])) {
            $step_offsetdirection = $data['step_offsetdirection'];
        } else {
            $input_check = false;
            $error_message .= "step_offsetdirection, ";
        }

        if (isset($data['step_rpm']) && $data['step_rpm'] >= $tool_info['tool_minrpm'] && $data['step_rpm'] <= $tool_info['tool_maxrpm'] ) {
            $step_rpm = $data['step_rpm'];
        } else {
            $input_check = false;
            $error_message .= "step_rpm, ";
        }

        if ( isset($data['step_targetangle']) && $data['step_targetangle'] >=0 && $data['step_targetangle'] <=30600 ) {
            $step_targetangle = $data['step_targetangle'];
        } else {
            $input_check = false;
            $error_message .= "step_targetangle, ";
        }

        if ( isset($data['step_targettorque']) && $data['step_targettorque'] >= 0 && $data['step_targettorque'] <= $tool_info['tool_maxtorque'] ) {
            $step_targettorque = $data['step_targettorque'];
        } else {
            $input_check = false;
            $error_message .= "step_targettorque, ";
        }

        if (!empty($data['step_targettype']) && isset($data['step_targettype'])) {
            $step_targettype = $data['step_targettype'];
        } else {
            $input_check = false;
            $error_message .= "step_targettype, ";
        }

        if (isset($data['step_tooldirection'])) {
            $step_tooldirection = $data['step_tooldirection'];
        } else {
            $input_check = false;
            $error_message .= "step_tooldirection, ";
        }

        if ( isset($data['step_torque_jointoffset']) && $data['step_torque_jointoffset'] >=0) {
            $step_torque_jointoffset = $data['step_torque_jointoffset'];
        } else {
            $input_check = false;
            $error_message .= "step_torque_jointoffset, ";
        }

        if ( isset($data['step_torquewindow']) && $data['step_torquewindow'] >=0) {
            $step_torquewindow = $data['step_torquewindow'];
        } else {
            $input_check = false;
            $error_message .= "step_torquewindow, ";
        }

        if ( isset($data['step_torwin_target']) && $data['step_torwin_target'] >=0) {
            $step_torwin_target = $data['step_torwin_target'];
        } else {
            $input_check = false;
            $error_message .= "step_torwin_target, ";
        }

        $result = [
            'result' => $input_check,
            'error_message' => $error_message,
        ];

        return $result;
    }

    public function get_advstep_by_id()
    {
        $error_message = '';
        if (!empty($_POST['job_id']) && isset($_POST['job_id'])) {
            $job_id = $_POST['job_id'];
        } else {
            $input_check = false;
            $error_message .= "job_id, ";
        }
        if (!empty($_POST['seq_id']) && isset($_POST['seq_id'])) {
            $seq_id = $_POST['seq_id'];
        } else {
            $input_check = false;
            $error_message .= "seq_id, ";
        }
        if (!empty($_POST['step_id']) && isset($_POST['step_id'])) {
            $step_id = $_POST['step_id'];
        } else {
            $input_check = false;
            $error_message .= "step_id, ";
        }

        $advancedstep = $this->advancedstepModel->getAdvancedstep_by_job_seq_step_id($job_id,$seq_id,$step_id);

        //轉換扭力單位 - 輸出
        $system_unit = $this->SettingModel->Get_System_Toq_Unit();
        $TransType = $system_unit;
        $inputType = $advancedstep['torque_unit']; // 0:公斤米 1:牛頓米 2:公斤公分 3:英鎊英寸

        $advancedstep['step_targettorque'] = $this->unitConvert($advancedstep['step_targettorque'], $inputType, $TransType);
        $advancedstep['step_hightorque'] = $this->unitConvert($advancedstep['step_hightorque'], $inputType, $TransType);
        $advancedstep['step_lowtorque'] = $this->unitConvert($advancedstep['step_lowtorque'], $inputType, $TransType);

        echo json_encode($advancedstep);

    }

    //swap advancedstep sort
    public function swap_advancedstep()
    {
        $error_message = '';
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "job_id,";
        }
        if( !empty($_POST['seq_id']) && isset($_POST['seq_id'])  ){
            $seq_id = $_POST['seq_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "seq_id,";
        }
        if( !empty($_POST['step_id1']) && isset($_POST['step_id1'])  ){
            $step_id1 = $_POST['step_id1'];
        }else{ 
            $input_check = false; 
            $error_message .= "step_id1,";
        }
        if( !empty($_POST['step_id2']) && isset($_POST['step_id2'])  ){
            $step_id2 = $_POST['step_id2'];
        }else{ 
            $input_check = false; 
            $error_message .= "step_id2,";
        }


        $flag = $this->advancedstepModel->swap_advancedstep($job_id,$seq_id,$step_id1,$step_id2);

        if($flag){// copy DB
            $copy_result =  $this->copyDB_to_RamdiskDB();
            if($copy_result){
                $this->logMessage('swap advancedstep job:'. $job_id.',seq:'.$seq_id.',step_id1:'.$step_id1.',step_id2:'.$step_id2.' copyDB success');
            }else{
                $this->logMessage('swap advancedstep job:'. $job_id.',seq:'.$seq_id.',step_id1:'.$step_id1.',step_id2:'.$step_id2.' copyDB fail');
            }
        }

        //normal step也要換

        $data = [
                'result' => $flag,
                'error_message' => $error_message
            ];

        echo json_encode($data);
    }

    public function get_head_step_id(){
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "job_id,";
        }
        if( !empty($_POST['seq_id']) && isset($_POST['seq_id'])  ){
            $seq_id = $_POST['seq_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "seq_id,";
        }
        //因job id是由系統指派，在create job時，抓取最前面的job id 帶入
        $head_job_id = $this->advancedstepModel->get_head_step_id($job_id,$seq_id);

        // return $head_job_id['missing_id'];
        echo json_encode($head_job_id);
    }

    //copy step
    public function copy_step()
    {
        $input_check = true;
        $reslut = 'fail';
        $error_message = '';

        if( !empty($_POST['from_job_id']) && isset($_POST['from_job_id'])  ){
            $from_job_id = $_POST['from_job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "from_job_id,";
        }

        if( !empty($_POST['from_seq_id']) && isset($_POST['from_seq_id'])  ){
            $from_seq_id = $_POST['from_seq_id'];    
        }else{ 
            $input_check = false; 
            $error_message .= "from_seq_id,";
        }

        if( !empty($_POST['from_step_id']) && isset($_POST['from_step_id'])  ){
            $from_step_id = $_POST['from_step_id'];    
        }else{ 
            $input_check = false; 
            $error_message .= "from_step_id,";
        }

        if( !empty($_POST['to_step_id']) && isset($_POST['to_step_id'])  ){
            $to_step_id = $_POST['to_step_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "to_step_id,";
        }

        if( !empty($_POST['to_step_name']) && isset($_POST['to_step_name'])  ){
            $to_step_name = $_POST['to_step_name'];    
        }else{ 
            $input_check = false; 
            $error_message .= "to_step_name,";
        }

        if($input_check){
            $reslut = $this->advancedstepModel->copy_step_by_step_id($from_job_id,$from_seq_id,$from_step_id,$to_step_id,$to_step_name);

            if($reslut){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('copy advancedstep job:'. $from_job_id.',seq:'.$from_seq_id.',from_step_id:'.$from_step_id.',to_step_id:'.$to_step_id.' copyDB success');
                }else{
                    $this->logMessage('copy advancedstep job:'. $from_job_id.',seq:'.$from_seq_id.',from_step_id:'.$from_step_id.',to_step_id:'.$to_step_id.' copyDB fail');
                }
            }
        }

        $data = [
                'result' => $reslut,
                'error_message' => $error_message
            ];

        echo json_encode($data);

    }

    //delete job
    public function delete_step_by_id()
    {
        $input_check = true;
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['seq_id']) && isset($_POST['seq_id'])  ){
            $seq_id = $_POST['seq_id'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['step_id']) && isset($_POST['step_id'])  ){
            $step_id = $_POST['step_id'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $result = $this->advancedstepModel->delete_advancedstep_by_id($job_id,$seq_id,$step_id);

            if($result){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('delete advancedstep job:'. $job_id.',seq:'.$seq_id.',step_id:'.$step_id.' copyDB success');
                }else{
                    $this->logMessage('delete advancedstep job:'. $job_id.',seq:'.$seq_id.',step_id:'.$step_id.' copyDB fail');
                }
            }
        }

        echo json_encode($result);
    }


    
}

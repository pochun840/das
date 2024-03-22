<?php

class Normalsteps extends Controller
{
    private $normalstepModel;
    private $DashboardModel;
    private $SettingModel;
    private $ToolModel;
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->normalstepModel = $this->model('Normalstep');
        $this->DashboardModel = $this->model('Dashboard');
        $this->SettingModel = $this->model('Setting');
        $this->ToolModel = $this->model('Tool');
    }

    // 取得所有Sequences
    public function index($job_id = 1,$sequence_id = 1){

        if(  isset($job_id) && !empty($job_id) ){

        }else{
            $job_id = 1;
        }

        $noramlstep = $this->normalstepModel->getNormalstep_by_job_seq_id($job_id,$sequence_id);
        $tool_info = $this->DashboardModel->get_tool_info();
        $controller_Info = $this->ToolModel->GetControllerInfo();

        //轉換扭力單位 - 輸出
        $system_unit = $this->SettingModel->Get_System_Toq_Unit();
        $TransType = $system_unit;
        $inputType = $noramlstep['torque_unit']; // 0:公斤米 1:牛頓米 2:公斤公分 3:英鎊英寸
        $noramlstep['step_targettorque'] = $this->unitConvert($noramlstep['step_targettorque'], $inputType, $TransType);
        $noramlstep['step_hightorque'] = $this->unitConvert($noramlstep['step_hightorque'], $inputType, $TransType);
        $noramlstep['step_lowtorque'] = $this->unitConvert($noramlstep['step_lowtorque'], $inputType, $TransType);
        $noramlstep['step_threshold_torque'] = $this->unitConvert($noramlstep['step_threshold_torque'], $inputType, $TransType);
        $noramlstep['step_downshift_torque'] = $this->unitConvert($noramlstep['step_downshift_torque'], $inputType, $TransType);

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
            'noramlstep' => $noramlstep,
            'tool_info' => $tool_info,
            'job_id' => $job_id,
            'job_type' => $job_type,
            'controller_Info' => $controller_Info,
            'delta' => $torque_delta,
            'device_info' => $device_info,
        ];

        if($isMobile){
            $this->view('normalsteps/index_m', $data);
        }else{
            $this->view('normalsteps/index', $data);    
        }
        
    }

    //create seq
    public function edit_step(){
        $input_check = true;
        $res = 'fail';
        $error_message = '';
        $tool_info = $this->DashboardModel->get_tool_info();
        $system_unit = $this->SettingModel->Get_System_Toq_Unit();
        $TransType = $system_unit; // 0:公斤米 1:牛頓米 2:公斤公分 3:英鎊英寸

        //把起子的上下線轉成目前系統的扭力單位，起子DB是存牛頓米
        $tool_info['tool_maxtorque'] = $this->unitConvert($tool_info['tool_maxtorque'], 1, $TransType);
        $tool_info['tool_mintorque'] = $this->unitConvert($tool_info['tool_mintorque'], 1, $TransType);

        if( !empty($_POST['job_id']) && isset($_POST['job_id']) && $_POST['job_id'] >0 && $_POST['job_id'] < 100 ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "job_id,";
        }

        if( isset($_POST['Seq_ID']) && $_POST['Seq_ID']>0  ){
            $Seq_ID = $_POST['Seq_ID'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Seq_ID,";
        }

        if( !empty($_POST['target_type']) && isset($_POST['target_type']) && isset($_POST['target_type']) > 0 ){
            $target_type = $_POST['target_type'];    
        }else{ 
            $input_check = false; 
            $error_message .= "target_type,";
        }

        if( isset($_POST['Target_Angle']) && $_POST['Target_Angle']>=0  ){
            $Target_Angle = $_POST['Target_Angle'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Target_Angle,";
        }

        if( isset($_POST['Threshold_Torque']) && $_POST['Threshold_Torque']>=0  ){
            $Threshold_Torque = $_POST['Threshold_Torque'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Threshold_Torque,";
        }

        if( isset($_POST['Run_Down_Speed']) && $_POST['Run_Down_Speed']>=0 && $_POST['Run_Down_Speed']>=$tool_info['tool_minrpm']  && $_POST['Run_Down_Speed'] <= $tool_info['tool_maxrpm'] ){
            $Run_Down_Speed = $_POST['Run_Down_Speed'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Run_Down_Speed,";
        }

        if( isset($_POST['Pre_Run_Unfasten']) && $_POST['Pre_Run_Unfasten']>=0  ){
            $Pre_Run_Unfasten = $_POST['Pre_Run_Unfasten'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Pre_Run_Unfasten,";
        }

        if( isset($_POST['Pre_Run_RPM']) && $_POST['Pre_Run_RPM']>=0 && $_POST['Pre_Run_RPM']>=$tool_info['tool_minrpm']  && $_POST['Pre_Run_RPM'] <= $tool_info['tool_maxrpm'] ){
            $Pre_Run_RPM = $_POST['Pre_Run_RPM'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Pre_Run_RPM,";
        }

        if( isset($_POST['Pre_Run_Angle']) && $_POST['Pre_Run_Angle']>=0  ){
            $Pre_Run_Angle = $_POST['Pre_Run_Angle'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Pre_Run_Angle,";
        }

        if( isset($_POST['Low_Torque']) && $_POST['Low_Torque']>=0  ){
            $Low_Torque = $_POST['Low_Torque'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Low_Torque,";
        }

        if( isset($_POST['Low_Angle']) && $_POST['Low_Angle']>=0  && $_POST['Low_Angle']<=30599  ){
            $Low_Angle = $_POST['Low_Angle'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Low_Angle,";
        }

        if( isset($_POST['High_Angle']) && $_POST['High_Angle']>=1 && $_POST['High_Angle']<=30600  ){
            $High_Angle = $_POST['High_Angle'];    
        }else{ 
            $input_check = false; 
            $error_message .= "High_Angle,";
        }

        if( isset($_POST['Hi_Torque']) && $_POST['Hi_Torque']>=0 && $_POST['Hi_Torque']<=$tool_info['tool_maxtorque']*1.1 ){
            $Hi_Torque = $_POST['Hi_Torque'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Hi_Torque,";
        }

        if( isset($_POST['Downshift_Enable']) && $_POST['Downshift_Enable']>=0  ){
            $Downshift_Enable = $_POST['Downshift_Enable'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Downshift_Enable,";
        }

        if( isset($_POST['Downshift_Speed']) && $_POST['Downshift_Speed']>=0 && $_POST['Downshift_Speed']<= $tool_info['tool_maxrpm'] ){
            $Downshift_Speed = $_POST['Downshift_Speed'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Downshift_Speed,";
        }

        if( isset($_POST['Downshift_Torque']) && $_POST['Downshift_Torque']>=0  && $_POST['Downshift_Torque']<= $tool_info['tool_maxtorque']  ){
            $Downshift_Torque = $_POST['Downshift_Torque'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Downshift_Torque,";
        }

        if($target_type == 'torque'){ //以下變數只有target type == torque時才會用到
            if( isset($_POST['Target_Torque']) && $_POST['Target_Torque']>0 && $_POST['Target_Torque'] >= $tool_info['tool_mintorque'] && $_POST['Target_Torque'] <= $tool_info['tool_maxtorque']*1.1   ){
                $Target_Torque = $_POST['Target_Torque'];    
            }else{ 
                $input_check = false; 
                $error_message .= "Target_Torque,";
            }

            if( isset($_POST['Monitoring_Angle']) && $_POST['Monitoring_Angle']>=0 && $_POST['Monitoring_Angle']<=30599  ){
                $Monitoring_Angle = $_POST['Monitoring_Angle'];    
            }else{ 
                $input_check = false; 
                $error_message .= "Monitoring_Angle,";
            }

            if( isset($_POST['Joint_OffSet_Option']) && $_POST['Joint_OffSet_Option']>=0  ){
                $Joint_OffSet_Option = $_POST['Joint_OffSet_Option'];    
            }else{ 
                $input_check = false; 
                $error_message .= "Joint_OffSet_Option,";
            }

            if( isset($_POST['Joint_OffSet']) && $_POST['Joint_OffSet']>=0 && $_POST['Joint_OffSet'] <= $tool_info['tool_maxtorque'] ){
                $Joint_OffSet = $_POST['Joint_OffSet'];    
            }else{ 
                $input_check = false; 
                $error_message .= "Joint_OffSet,";
            }
        }

        if( isset($_POST['Threshold_Type']) && $_POST['Threshold_Type']>=0  ){
            $Threshold_Type = $_POST['Threshold_Type'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Threshold_Type,";
        }

        if( isset($_POST['Threshold_Angle']) && $_POST['Threshold_Angle']>=0  ){
            $Threshold_Angle = $_POST['Threshold_Angle'];    
        }else{ 
            $input_check = false; 
            $error_message .= "Threshold_Angle,";
        }

        if($input_check){
            // $system_unit = $this->SettingModel->Get_System_Toq_Unit();
            
            $step_data = [
                'job_id' => $job_id,
                'sequence_id' => $Seq_ID,
                'target_type' => $target_type,
                'Target_Angle' => $Target_Angle,
                'threshold_torque' => $Threshold_Torque,
                'Run_Down_Speed' => $Run_Down_Speed,
                'Pre_Run_Unfasten' => $Pre_Run_Unfasten,
                'Pre_Run_RPM' => $Pre_Run_RPM,
                'Pre_Run_Angle' => $Pre_Run_Angle,
                'Low_Torque' => $Low_Torque,
                'Low_Angle' => $Low_Angle,
                'High_Angle' => $High_Angle,
                'Hi_Torque' => $Hi_Torque,
                'Downshift_Enable' => $Downshift_Enable,
                'Downshift_Speed' => $Downshift_Speed,
                'Downshift_Torque' => $Downshift_Torque,
                'torque_unit' => $system_unit,
                'Threshold_Type' => $Threshold_Type,
                'Threshold_Angle' => $Threshold_Angle,
            ];

            if($target_type == 'torque'){
                $torque_data = [
                    'Target_Torque' => $Target_Torque,
                    'Monitoring_Angle' => $Monitoring_Angle,
                    'Joint_OffSet_Option' => $Joint_OffSet_Option,
                    'Joint_OffSet' => $Joint_OffSet,
                ];
                $step_data = array_merge($step_data, $torque_data);
            }

            //將資料寫入DB
            $res = $this->normalstepModel->edit_step($step_data);

            if($res){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('edit noramlstep job:'.$job_id.',seq:'.$Seq_ID.' copyDB success');
                }else{
                    $this->logMessage('edit noramlstep job:'.$job_id.',seq:'.$Seq_ID.' copyDB fail');
                }
            }

            $data = [
                'result' => 'success',
                'error_message' => $error_message
            ];

        }else{
            $data = [
                'result' => $res . $error_message
            ];
        }

        echo json_encode($data);
    }



    
}

<?php

class Sequences extends Controller
{
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->sequenceModel = $this->model('Sequence');
    }

    // 取得所有Sequences
    public function index($job_id){

        if( isset($job_id) && !empty($job_id) ){

        }else{
            $job_id = 1;
        }

        $sequences = $this->sequenceModel->getSequences_by_job_id($job_id);

        if($job_id<100){
            $job_type = 'normal';
        }else{
            $job_type = 'advanced';
        }

        $isMobile = $this->isMobileCheck();
        $device_info = $this->Device_Info();

        $data = [
            'sequences' => $sequences,
            'job_id' => $job_id,
            'job_type' => $job_type,
            'device_info' => $device_info
        ];

        if($job_id<100){
            if($isMobile){
                $this->view('sequences/index_m', $data);
            }else{
                $this->view('sequences/index', $data);
            }
        }else{
            if($isMobile){
                $this->view('sequences/adv_index_m', $data);
            }else{
                $this->view('sequences/adv_index', $data);
            }
        }
        
    }

    public function get_head_seq_id_normal(){
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "job_id,";
        }
        //因job id是由系統指派，在create job時，抓取最前面的job id 帶入
        $head_job_id = $this->sequenceModel->get_head_seq_id($job_id);

        echo json_encode($head_job_id);
    }

    //create seq
    public function create_seq(){
        $input_check = true;
        $res = 'fail';
        $error_message = '';
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "job_id,";
        }

        if( !empty($_POST['sequence_id']) && isset($_POST['sequence_id'])  ){
            $sequence_id = $_POST['sequence_id'];    
        }else{ 
            $input_check = false; 
            $error_message .= "sequence_id,";
        }

        if( $_POST['sequence_id'] > 99){
            $input_check = false; 
            $error_message .= "sequence_id,";
        }

        if( $_POST['sequence_id'] > 50 && $_POST['job_id'] > 100){
            $input_check = false; 
            $error_message .= "adv sequence_id,";
        }

        if( !empty($_POST['sequence_name']) && isset($_POST['sequence_name'])  ){
            $sequence_name = $_POST['sequence_name'];    
        }else{ 
            $input_check = false; 
            $error_message .= "sequence_name,";
        }

        if( isset($_POST['tightening_repeat']) && $_POST['tightening_repeat']>0 && $_POST['tightening_repeat'] <= 99  ){
            $tightening_repeat = $_POST['tightening_repeat'];    
        }else{ 
            $input_check = false; 
            $error_message .= "tightening_repeat,";
        }

        if( isset($_POST['ng_stop']) && $_POST['ng_stop']>=0 ){
            $ng_stop = $_POST['ng_stop'];    
        }else{ 
            $input_check = false; 
            $error_message .= "ng_stop,";
        }

        if( isset($_POST['ok_seq_option'] ) && $_POST['ok_seq_option']>=0 ){
            $ok_seq_option = $_POST['ok_seq_option'];    
        }else{ 
            $input_check = false; 
            $error_message .= "ok_seq_option,";
        }

        if( isset($_POST['ok_seq_stop_option']) && $_POST['ok_seq_stop_option']>=0  ){
            $ok_seq_stop_option = $_POST['ok_seq_stop_option'];    
        }else{ 
            $input_check = false; 
            $error_message .= "ok_seq_stop_option,";
        }

        if( !empty($_POST['timeout']) && isset($_POST['timeout']) && $_POST['timeout'] >= 0.1 && $_POST['timeout'] <= 60 ){
            $timeout = $_POST['timeout'];    
        }else{ 
            $input_check = false; 
            $error_message .= "timeout,";
        }

        if($input_check){
            $seq_data = [
                'job_id' => $job_id,
                'sequence_id' => $sequence_id,
                'sequence_name' => $sequence_name,
                'tightening_repeat' => $tightening_repeat,
                'ng_stop' => $ng_stop,
                'ok_seq_option' => $ok_seq_option,
                'ok_seq_stop_option' => $ok_seq_stop_option,
                'timeout' => $timeout
            ];

            $validate_result['result'] = false;

            if( !$validate_result['result'] ){
                //將資料寫入DB
                $res = $this->sequenceModel->create_Seq($seq_data);
                $data = [
                    'result' => 'success',
                    'error_message' => $error_message
                ];

                if($res){// copy DB
                    $copy_result =  $this->copyDB_to_RamdiskDB();
                    if($copy_result){
                        $this->logMessage('edit sequence job:'. $seq_data['job_id'].',seq:'.$seq_data['sequence_id'].' copyDB success');
                    }else{
                        $this->logMessage('edit sequence job:'.$seq_data['job_id'].',seq:'.$seq_data['sequence_id'].' copyDB fail');
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
                'result' => $res . $error_message
            ];
        }

        echo json_encode($data);
    }

    //get job by id
    public function get_seq_by_id(){
        $input_check = true;
        //因job id是由系統指派，在create job時，抓取最前面的job id 帶入
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

        if($input_check){
            $sequence_data = $this->sequenceModel->get_seq_by_id($job_id,$seq_id);    
        }

        echo json_encode($sequence_data);
    }

    // enable disable seq
    public function enable_disable_seq()
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
        if( isset($_POST['status'])  ){
            $status = $_POST['status'];
        }else{ 
            $input_check = false; 
            $error_message .= "status,";
        }

        if($status == 'false'){
            $status = 0;
        }else{
            $status = 1;
        }

        $res = $this->sequenceModel->enable_disable_seq($job_id,$seq_id,$status);
        if($res){// copy DB
            $copy_result =  $this->copyDB_to_RamdiskDB();
            if($copy_result){
                $this->logMessage('enable/disable sequence job:'. $job_id.',seq:'.$seq_id.',status:'.$status.' copyDB success');
            }else{
                $this->logMessage('enable/disable sequence job:'. $job_id.',seq:'.$seq_id.',status:'.$status.' copyDB fail');
            }
        }

        $data = [
                'result' => $res,
                'error_message' => $error_message
            ];

        echo json_encode($data);

    }

    //swap sequence sort
    public function swap_seq()
    {
        $error_message = '';
        if( !empty($_POST['job_id']) && isset($_POST['job_id'])  ){
            $job_id = $_POST['job_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "job_id,";
        }
        if( !empty($_POST['seq_id1']) && isset($_POST['seq_id1'])  ){
            $seq_id1 = $_POST['seq_id1'];
        }else{ 
            $input_check = false; 
            $error_message .= "seq_id1,";
        }
        if( !empty($_POST['seq_id2']) && isset($_POST['seq_id2'])  ){
            $seq_id2 = $_POST['seq_id2'];
        }else{ 
            $input_check = false; 
            $error_message .= "seq_id2,";
        }


        $flag = $this->sequenceModel->swap_seq($job_id,$seq_id1,$seq_id2);

        if($flag){// copy DB
            $copy_result =  $this->copyDB_to_RamdiskDB();
            if($copy_result){
                $this->logMessage('swap sequence job:'. $job_id.',seq_id1:'.$seq_id1.',seq_id2:'.$seq_id2.' copyDB success');
            }else{
                $this->logMessage('swap sequence job:'. $job_id.',seq_id1:'.$seq_id1.',seq_id2:'.$seq_id2.' copyDB fail');
            }
        }

        $data = [
                'result' => $flag,
                'error_message' => $error_message
            ];

        echo json_encode($data);
    }

    //copy sequence
    public function copy_seq()
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

        if( !empty($_POST['from_seq_id']) && isset($_POST['from_seq_id'])  ){
            $from_seq_id = $_POST['from_seq_id'];    
        }else{ 
            $input_check = false; 
            $error_message .= "from_seq_id,";
        }

        if( !empty($_POST['to_seq_id']) && isset($_POST['to_seq_id'])  ){
            $to_seq_id = $_POST['to_seq_id'];
        }else{ 
            $input_check = false; 
            $error_message .= "to_seq_id,";
        }

        if( !empty($_POST['to_seq_name']) && isset($_POST['to_seq_name'])  ){
            $to_seq_name = $_POST['to_seq_name'];    
        }else{ 
            $input_check = false; 
            $error_message .= "to_seq_name,";
        }

        if($input_check){

            //copy sequecne table
            $reslut = $this->sequenceModel->copy_sequence_by_sequence_id($from_job_id,$from_seq_id,$to_seq_id,$to_seq_name);
            //copy normalsetp table
            if($from_job_id > 100 ){
                $reslut = $this->sequenceModel->copy_advancedstep_by_sequence_id($from_job_id,$from_seq_id,$to_seq_id,$to_seq_name);
            }else{
                // $reslut = $this->jobModel->copy_normalstep_by_job_id($from_job_id,$to_job_id,$dupli_flag);
                $reslut = $this->sequenceModel->copy_normalstep_by_sequence_id($from_job_id,$from_seq_id,$to_seq_id,$to_seq_name);
            }

            if($reslut){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('copy sequence job:'. $from_job_id.',from_seq_id:'.$from_seq_id.',to_seq_id:'.$to_seq_id.' copyDB success');
                }else{
                    $this->logMessage('copy sequence job:'. $from_job_id.',from_seq_id:'.$from_seq_id.',to_seq_id:'.$to_seq_id.' copyDB fail');
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
    public function delete_seq_by_id()
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

        if($input_check){
            //delete sequecne table
            $seq_data = $this->sequenceModel->delete_sequence_by_job_seq_id($job_id,$seq_id);
            //delete normalsetp table
            if($job_id>100){
                $seq_data = $this->sequenceModel->delete_advancedstep_by_job_seq_id($job_id,$seq_id);
            }else{
                $seq_data = $this->sequenceModel->delete_normalstep_by_job_seq_id($job_id,$seq_id);
            }

            if($seq_data){// copy DB
                $copy_result =  $this->copyDB_to_RamdiskDB();
                if($copy_result){
                    $this->logMessage('delete sequence job:'. $job_id.',seq_id:'.$seq_id.' copyDB success');
                }else{
                    $this->logMessage('delete sequence job:'. $job_id.',seq_id:'.$seq_id.' copyDB fail');
                }
            }
            
        }

        echo json_encode($seq_data);
    }


    
}

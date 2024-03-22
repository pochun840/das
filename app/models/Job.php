<?php

class Job{
    private $db;//condb control box
    private $db_dev;//devdb tool
    private $dbh;
    private $tool_max_rpm;
    private $tool_min_rpm;

    // 在建構子將 Database 物件實例化
    public function __construct()
    {
        $this->db = new Database;
        $this->db = $this->db->getDb();

        $this->db_dev = new Database;
        $this->db_dev = $this->db_dev->getDb_dev();

        $this->dbh = new Database;

        $tool_rpm = $this->dbh->get_tool_rpm();
        $this->tool_max_rpm = $tool_rpm['tool_maxrpm'];
        $this->tool_min_rpm = $tool_rpm['tool_minrpm'];

    }

    // 取得所有Job
    public function getJobs($job_type)
    {
        if($job_type == 'advanced'){
            $sql = "SELECT job.*,count(job.job_id) as total_seq  FROM  `job` LEFT JOIN sequence on job.job_id = sequence.job_id 
                    WHERE job.job_id > 100
                    GROUP by job.job_id";
            $statement = $this->db->prepare($sql);
            $statement->execute();
        }
        if($job_type == 'normal'){
            $sql = "SELECT job.*,count(job.job_id) as total_seq  FROM  `job` LEFT JOIN sequence on job.job_id = sequence.job_id 
                    WHERE job.job_id < 100
                    GROUP by job.job_id";
            $statement = $this->db->prepare($sql);
            $statement->execute();
        }

        return $statement->fetchall();
    }

    //取得job id，依job_type判斷
    public function get_head_job_id($job_type){

        //normal job   的job_id是 1~100
        //advanced job 的job_id是 101~170

        if($job_type == 'advanced'){
            //advanced job
            $query  = "SELECT job_id + 1 AS missing_id
                    FROM job
                    WHERE (job_id + 1) NOT IN (SELECT job_id FROM job)
                    AND (job_id + 1) >= 101
                    AND (job_id + 1) <= 170";
        }else{
            //normal job
            $query  = "SELECT job_id + 1 AS missing_id
                    FROM job
                    WHERE (job_id + 1) NOT IN (SELECT job_id FROM job)
                    AND (job_id + 1) <= 100;";
        }

        $results = $this->db->query($query);

        return $results->fetch();
    }

    //create and update jobs
    public function create_Job($data)
    {
        //check job_id exist 
        $sql = "SELECT COUNT(*) as count FROM  `job` WHERE job_id = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$data['job_id']]);
        $results = $statement->fetch();

        if($results['count'] > 0){//表示job_id已存在，用update
            $sql = "UPDATE `job` SET job_name=?,ok_job=?,ok_job_stop=?,reverse_force=?,reverse_rpm=?,reverse_direction=?,reverse_cnt_mode=?,reverse_threshold_torque=?,torque_unit=? WHERE job_id = ? ";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$data['job_name'],$data['ok_job_option'],$data['ok_job_stop_option'],$data['unfasten_force'],$data['unfasten_RPM'],$data['unfasten_direction_option'],$data['reverse_cnt_mode'],$data['reverse_threshold_torque'],$data['torque_unit'],$data['job_id']]);
        }else{//表示job_id不存在，用insert
            $sql = "INSERT INTO `job` ('job_id','job_name','ok_job','ok_job_stop','reverse_force','reverse_rpm','reverse_direction','reverse_cnt_mode','reverse_threshold_torque','torque_unit','rev_acc_mode','rev_acc_type','rev_th_ang','job_to') VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$data['job_id'],$data['job_name'],$data['ok_job_option'],$data['ok_job_stop_option'],$data['unfasten_force'],$data['unfasten_RPM'],$data['unfasten_direction_option'],$data['reverse_cnt_mode'],$data['reverse_threshold_torque'],$data['torque_unit'],0,0,0,0 ]);

            //要再加入seq & normalstep
            $this->add_default_seq($data['job_id']);

            if ($data['job_id'] > 100) {
                $this->add_default_advancedstep($data['job_id']);
            }else{
                $this->add_default_normalstep($data['job_id']);    
            }
            
        }

        return $results;
    }

    //update jobs
    public function update_Job($data)
    {
        $results = $this->db->query('SELECT * FROM job');

        return $results->fetchall();
    }
    //delete jobs
    public function delete_Job($job_id)
    {
        $results = $this->db->query('SELECT * FROM job');

        return $results->fetchall();
    }

    //驗證job id是否重複
    public function job_id_repeat($job_id)
    {
        $sql = "SELECT count(*) as count FROM job WHERE job_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);
        $rows = $statement->fetch();

        if ($rows['count'] > 0) {
            return true; // job_id已存在
        }else{
            return false; // job_id不存在
        }
    }

    //get tool max,min rpm
    public function get_tool_rpm()
    {
        $sql = "SELECT tool_maxrpm,tool_minrpm FROM tool_info";
        $statement = $this->db_dev->prepare($sql);
        $results = $statement->execute();
        $rows = $statement->fetch();

        return $rows;
    }

    //get tool max,min torque
    public function get_tool_torque()
    {
        $sql = "SELECT tool_maxtorque,tool_mintorque FROM tool_info";
        $statement = $this->db_dev->prepare($sql);
        $results = $statement->execute();
        $rows = $statement->fetch();

        return $rows;
    }

    //get job by id
    public function get_job_by_id($job_id){

        $sql= "SELECT * FROM job WHERE job_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);
        $rows = $statement->fetch();

        return $rows;
    }

    //delete job by id
    public function delete_job_by_id($job_id){

        $sql= "DELETE FROM job WHERE job_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

    //delete sequence by id
    public function delete_sequence_by_job_id($job_id){

        $sql= "DELETE FROM sequence WHERE job_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

    //delete normalstep by id
    public function delete_normalstep_by_job_id($job_id){

        $sql= "DELETE FROM normalstep WHERE job_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

    //delete normalstep by id
    public function delete_input_by_job_id($job_id){

        $sql= "DELETE FROM input WHERE input_jobid = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

    //delete normalstep by id
    public function delete_output_by_job_id($job_id){

        $sql= "DELETE FROM output WHERE output_jobid = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

    //delete normalstep by id
    public function delete_barcode_by_job_id($job_id){

        $sql= "DELETE FROM barcode WHERE barcode_selected_job = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

    //delete advancedstep by id
    public function delete_advancedstep_by_job_id($job_id){

        $sql= "DELETE FROM advancedstep WHERE job_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

    //copy job
    public function copy_job_by_id($from_job_id,$to_job_id,$to_job_name,$dupli_flag){
        // 判斷job_id是否存在，若存在就先把舊的刪除
        // $dupli_flag true:表示job_id已存在 false:表示job_id不存在
        if($dupli_flag){
            $this->delete_job_by_id($to_job_id);
        }
            $sql= "INSERT INTO job ( job_id,job_name,ok_job,ok_job_stop,reverse_force,reverse_rpm,reverse_direction,reverse_cnt_mode,reverse_threshold_torque,torque_unit,rev_acc_mode,rev_acc_type,rev_th_ang,job_to )
                SELECT  ?,?,ok_job,ok_job_stop,reverse_force,reverse_rpm,reverse_direction,reverse_cnt_mode,reverse_threshold_torque,torque_unit,rev_acc_mode,rev_acc_type,rev_th_ang,job_to 
                FROM    job
                WHERE job_id = ? ";
            $statement = $this->db->prepare($sql);
            return $results = $statement->execute([$to_job_id,$to_job_name,$from_job_id]);
        
        
    }

    //copy sequence by job id
    public function copy_sequence_by_job_id($from_job_id,$to_job_id,$dupli_flag){
        // 判斷job_id是否存在，若存在就先把舊的刪除
        // $dupli_flag true:表示job_id已存在 false:表示job_id不存在
        if($dupli_flag){
            $this->delete_sequence_by_job_id($to_job_id);
        }
        $sql= "INSERT INTO sequence ( sequence_enable,job_id,sequence_id,sequence_name,tightening_repeat,ng_stop,ok_sequence,ok_sequence_stop,sequence_mintime,sequence_maxtime,sc_inter_time )
                SELECT  sequence_enable,?,sequence_id,sequence_name,tightening_repeat,ng_stop,ok_sequence,ok_sequence_stop,sequence_mintime,sequence_maxtime,sc_inter_time
                FROM    sequence
                WHERE job_id = ? ";
        $statement = $this->db->prepare($sql);
        return $results = $statement->execute([$to_job_id,$from_job_id]);
    }

    //copy normalstep by job id
    public function copy_normalstep_by_job_id($from_job_id,$to_job_id,$dupli_flag){
        // 判斷job_id是否存在，若存在就先把舊的刪除
        // $dupli_flag true:表示job_id已存在 false:表示job_id不存在
        if($dupli_flag){
            $this->delete_normalstep_by_job_id($to_job_id);
        }
        $sql= "INSERT INTO normalstep ( job_id,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_hightorque,step_lowtorque,step_threshold_mode,step_threshold_torque,step_threshold_angle,step_monitoringangle,step_highangle,step_lowangle,step_downshift_enable,step_downshift_torque,step_downshift_speed,torque_unit,step_prr,step_prr_rpm,step_prr_angle,step_downshift_mode,step_downshift_angle,step_extra_mode,step_extra_dir,step_extra_ang,step_msg )
                SELECT  ?,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_hightorque,step_lowtorque,step_threshold_mode,step_threshold_torque,step_threshold_angle,step_monitoringangle,step_highangle,step_lowangle,step_downshift_enable,step_downshift_torque,step_downshift_speed,torque_unit,step_prr,step_prr_rpm,step_prr_angle,step_downshift_mode,step_downshift_angle,step_extra_mode,step_extra_dir,step_extra_ang,step_msg 
                FROM    normalstep
                WHERE job_id = ? ";
        $statement = $this->db->prepare($sql);
        return $results = $statement->execute([$to_job_id,$from_job_id]);
    }

    //copy advancedstep by job_id
    public function copy_advancedstep_by_job_id($from_job_id,$to_job_id,$dupli_flag){
        // 判斷job_id是否存在，若存在就先把舊的刪除
        // $dupli_flag true:表示job_id已存在 false:表示job_id不存在
        if($dupli_flag){
            $this->delete_advancedstep_by_job_id($to_job_id);
        }
        $sql= "INSERT INTO advancedstep ( job_id,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_delayttime,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_monitoringmode,step_torwin_target,step_torquewindow,step_angwin_target,step_anglewindow,step_hightorque,step_lowtorque,step_monitoringangle,step_highangle,step_lowangle,torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg )
                SELECT  ?,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_delayttime,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_monitoringmode,step_torwin_target,step_torquewindow,step_angwin_target,step_anglewindow,step_hightorque,step_lowtorque,step_monitoringangle,step_highangle,step_lowangle,torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg 
                FROM    advancedstep
                WHERE job_id = ?";
        $statement = $this->db->prepare($sql);
        return $results = $statement->execute([$to_job_id,$from_job_id]);
    }

    public function add_default_seq($job_id) {
        $default_data = [
            'sequence_enable' => 1,
            'job_id' => $job_id,
            'sequence_id' => 1,
            'sequence_name' => 'SEQ-1',
            'tightening_repeat' => 1,
            'ng_stop' => 0,
            'ok_sequence' => 1,
            'ok_sequence_stop' => 0,
            'sequence_mintime' => 0,
            'sequence_maxtime' => 20,
            'sc_inter_time' => 0,
        ];

        $sql = "INSERT INTO `sequence` (sequence_enable,job_id,sequence_id,sequence_name,tightening_repeat,ng_stop,ok_sequence,ok_sequence_stop,sequence_mintime,sequence_maxtime,sc_inter_time) VALUES (:sequence_enable,:job_id,:sequence_id,:sequence_name,:tightening_repeat,:ng_stop,:ok_sequence,:ok_sequence_stop,:sequence_mintime,:sequence_maxtime,:sc_inter_time); ";

        $statement = $this->db->prepare($sql);
        $results = $statement->execute($default_data);
    }

    public function add_default_normalstep($job_id)
    {
        $data['sequence_name'] = 'SEQ-1';
        $data['step_name'] = '******';
        $data['step_targettype'] = 2;
        $data['step_targetangle'] = 1800;
        $data['step_targettorque'] = 0.5;
        $data['step_tooldirection'] = 0;
        $data['step_rpm'] = $this->tool_min_rpm;
        $data['step_offsetdirection'] = 0;
        $data['step_torque_jointoffset'] = 0;
        $data['step_hightorque'] = 0.6;
        $data['step_lowtorque'] = 0;
        $data['step_threshold_mode'] = 0;
        $data['step_threshold_torque'] = 0;
        $data['step_threshold_angle'] = 0;
        $data['step_monitoringangle'] = 0;
        $data['step_highangle'] = 30600;
        $data['step_lowangle'] = 0;
        $data['step_downshift_enable'] = 0;
        $data['step_downshift_torque'] = 0;
        $data['step_downshift_speed'] = 20;
        $data['torque_unit'] = 1;
        $data['step_prr'] = 0;
        $data['step_prr_rpm'] = 200;
        $data['step_prr_angle'] = 1800;
        $data['step_downshift_mode'] = 0;
        $data['step_downshift_angle'] = 0;
        $data['step_extra_mode'] = 0;
        $data['step_extra_dir'] = 0;
        $data['step_extra_ang'] = 0;
        $data['step_msg'] = '';


        $default_data = [
            'job_id' => $job_id,
            'sequence_id' => 1,
            'sequence_name' => $data['sequence_name'],
            'step_id' => '1',
            'step_name' => $data['step_name'],
            'step_targettype' => $data['step_targettype'],
            'step_targetangle' => $data['step_targetangle'],
            'step_targettorque' => $data['step_targettorque'],
            'step_tooldirection' => $data['step_tooldirection'],
            'step_rpm' => $data['step_rpm'],
            'step_offsetdirection' => $data['step_offsetdirection'],
            'step_torque_jointoffset' => $data['step_torque_jointoffset'],
            'step_hightorque' => $data['step_hightorque'],
            'step_lowtorque' => $data['step_lowtorque'],
            'step_threshold_mode' => $data['step_threshold_mode'],
            'step_threshold_torque' => $data['step_threshold_torque'],
            'step_threshold_angle' => $data['step_threshold_angle'],
            'step_monitoringangle' => $data['step_monitoringangle'],
            'step_highangle' => $data['step_highangle'],
            'step_lowangle' => $data['step_lowangle'],
            'step_downshift_enable' => $data['step_downshift_enable'],
            'step_downshift_torque' => $data['step_downshift_torque'],
            'step_downshift_speed' => $data['step_downshift_speed'],
            'torque_unit' => $data['torque_unit'],
            'step_prr' => $data['step_prr'],
            'step_prr_rpm' => $data['step_prr_rpm'],
            'step_prr_angle' => $data['step_prr_angle'],
            'step_downshift_mode' => $data['step_downshift_mode'],
            'step_downshift_angle' => $data['step_downshift_angle'],
            'step_extra_mode' => $data['step_extra_mode'],
            'step_extra_dir' => $data['step_extra_dir'],
            'step_extra_ang' => $data['step_extra_ang'],
            'step_msg' => $data['step_msg'],
        ];

        $sql = "INSERT INTO `normalstep` (job_id,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_hightorque,step_lowtorque,step_threshold_mode,step_threshold_torque,step_threshold_angle,step_monitoringangle,step_highangle,step_lowangle,step_downshift_enable,step_downshift_torque,step_downshift_speed,torque_unit,step_prr,step_prr_rpm,step_prr_angle,step_downshift_mode,step_downshift_angle,step_extra_mode,step_extra_dir,step_extra_ang,step_msg) VALUES ( :job_id,:sequence_id,:sequence_name,:step_id,:step_name,:step_targettype,:step_targetangle,:step_targettorque,:step_tooldirection,:step_rpm,:step_offsetdirection,:step_torque_jointoffset,:step_hightorque,:step_lowtorque,:step_threshold_mode,:step_threshold_torque,:step_threshold_angle,:step_monitoringangle,:step_highangle,:step_lowangle,:step_downshift_enable,:step_downshift_torque,:step_downshift_speed,:torque_unit,:step_prr,:step_prr_rpm,:step_prr_angle,:step_downshift_mode,:step_downshift_angle,:step_extra_mode,:step_extra_dir,:step_extra_ang,:step_msg); ";

        $statement = $this->db->prepare($sql);
        $results = $statement->execute($default_data);
    }

    //create advancedstep
    public function add_default_advancedstep($job_id){

            //default值
            $default_data = [
                'job_id'=> $job_id,
                'sequence_id'=> 1,
                'sequence_name'=> 'SEQ-1',
                'step_id'=> 1,
                'step_name'=> 'STEP-1',
                'step_targettype'=> 2,
                'step_targetangle'=> 1800,
                'step_targettorque'=> 0.5,
                'step_delayttime'=> 0.5,
                'step_tooldirection'=> 0,
                'step_rpm'=> $this->tool_min_rpm,
                'step_offsetdirection'=> 0,
                'step_torque_jointoffset'=> 0, 
                'step_monitoringmode'=> 1,
                'step_torwin_target'=> 0.5,
                'step_torquewindow'=> 0.05,
                'step_angwin_target'=> 1800,
                'step_anglewindow'=> 360,
                'step_hightorque'=> 0.6,
                'step_lowtorque'=> 0,
                'step_monitoringangle'=> 0,
                'step_highangle'=> 30600,
                'step_lowangle'=> 0,
                'torque_unit'=> 1,
                'step_angle_mode'=> 0,
                'step_slope'=> 2000,
                'step_pnf_set'=> 0,
                'step_tor_hold'=> 0,
                'step_msg'=> '',
            ];

            $sql = "INSERT INTO `advancedstep` (job_id,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_delayttime,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_monitoringmode,step_torwin_target,step_torquewindow,step_angwin_target,step_anglewindow,step_hightorque,step_lowtorque,step_monitoringangle,step_highangle,step_lowangle,torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg ) VALUES ( :job_id,:sequence_id,:sequence_name,:step_id,:step_name,:step_targettype,:step_targetangle,:step_targettorque,:step_delayttime,:step_tooldirection,:step_rpm,:step_offsetdirection,:step_torque_jointoffset,:step_monitoringmode,:step_torwin_target,:step_torquewindow,:step_angwin_target,:step_anglewindow,:step_hightorque,:step_lowtorque,:step_monitoringangle,:step_highangle,:step_lowangle,:torque_unit,:step_angle_mode,:step_slope,:step_pnf_set,:step_tor_hold,:step_msg); ";

            $statement = $this->db->prepare($sql);
            $results = $statement->execute($default_data);

    }

}

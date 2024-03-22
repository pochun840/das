<?php

class Advancedstep{
    private $db;//condb control box
    private $db_dev;//devdb tool
    private $dbh;
    private $tool_max_rpm;

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
    }


    public function getAdvancedstep_by_job_seq_id($job_id,$seq_id){
        $sql = "SELECT * FROM advancedstep WHERE job_id = ? AND sequence_id = ? order by step_id  ";
        $statement = $this->db->prepare($sql);
        $statement->execute([$job_id,$seq_id]);

        return $statement->fetchall(PDO::FETCH_ASSOC);
    }

    public function getAdvancedstep_by_job_seq_step_id($job_id,$seq_id,$step_id){
        $sql = "SELECT * FROM advancedstep WHERE job_id = ? AND sequence_id = ? AND step_id = ?  ";
        $statement = $this->db->prepare($sql);
        $statement->execute([$job_id,$seq_id,$step_id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function edit_step($data)
    {
        //檢查是否存在
        $sql = "SELECT COUNT(*) as count FROM advancedstep WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$data['job_id'],$data['sequence_id'],$data['step_id']]);
        $check_result = $statement->fetch();
        if($check_result['count'] > 0){
            $sql = "UPDATE `advancedstep` SET 
                    step_anglewindow = :step_anglewindow,
                    step_angwin_target = :step_angwin_target,
                    step_delayttime = :step_delayttime,
                    step_highangle = :step_highangle,
                    step_hightorque = :step_hightorque,
                    step_lowangle = :step_lowangle,
                    step_lowtorque = :step_lowtorque,
                    step_monitoringangle = :step_monitoringangle,
                    step_monitoringmode = :step_monitoringmode,
                    step_name = :step_name,
                    step_offsetdirection = :step_offsetdirection,
                    step_rpm = :step_rpm,
                    step_targetangle = :step_targetangle,
                    step_targettorque = :step_targettorque,
                    step_targettype = :step_targettype,
                    step_tooldirection = :step_tooldirection,
                    step_torque_jointoffset = :step_torque_jointoffset,
                    step_torquewindow = :step_torquewindow,
                    step_torwin_target = :step_torwin_target,
                    torque_unit = :torque_unit,
                    step_angle_mode = :step_angle_mode,
                    step_slope = :step_slope,
                    step_pnf_set = :step_pnf_set,
                    step_tor_hold = :step_tor_hold,
                    step_msg = :step_msg 
                WHERE job_id = :job_id AND sequence_id = :sequence_id AND sequence_name = :sequence_name AND step_id = :step_id";

        }else{
            $sql = "INSERT INTO `advancedstep` (job_id, sequence_id, sequence_name, step_anglewindow, step_angwin_target, step_delayttime, step_highangle, step_hightorque, step_id, step_lowangle, step_lowtorque, step_monitoringangle, step_monitoringmode, step_name, step_offsetdirection, step_rpm, step_targetangle, step_targettorque, step_targettype, step_tooldirection, step_torque_jointoffset, step_torquewindow, step_torwin_target, torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg) 
            VALUES (:job_id, :sequence_id, :sequence_name, :step_anglewindow, :step_angwin_target, :step_delayttime, :step_highangle, :step_hightorque, :step_id, :step_lowangle, :step_lowtorque, :step_monitoringangle, :step_monitoringmode, :step_name, :step_offsetdirection, :step_rpm, :step_targetangle, :step_targettorque, :step_targettype, :step_tooldirection, :step_torque_jointoffset, :step_torquewindow, :step_torwin_target, :torque_unit, :step_angle_mode, :step_slope,:step_pnf_set,:step_tor_hold,:step_msg)";
        }
        //存在就update
        //不存在就insert

        $data2 = [
            'job_id' => $data['job_id'],
            'sequence_id' => $data['sequence_id'],
            'sequence_name' => $data['sequence_name'],
            'step_anglewindow' => $data['step_anglewindow'],
            'step_angwin_target' => $data['step_angwin_target'],
            'step_delayttime' => $data['step_delayttime'],
            'step_highangle' => $data['step_highangle'],
            'step_hightorque' => $data['step_hightorque'],
            'step_id' => $data['step_id'],
            'step_lowangle' => $data['step_lowangle'],
            'step_lowtorque' => $data['step_lowtorque'],
            'step_monitoringangle' => $data['step_monitoringangle'],
            'step_monitoringmode' => $data['step_monitoringmode'],
            'step_name' => $data['step_name'],
            'step_offsetdirection' => $data['step_offsetdirection'],
            'step_rpm' => $data['step_rpm'],
            'step_targetangle' => $data['step_targetangle'],
            'step_targettorque' => $data['step_targettorque'],
            'step_targettype' => $data['step_targettype'],
            'step_tooldirection' => $data['step_tooldirection'],
            'step_torque_jointoffset' => $data['step_torque_jointoffset'],
            'step_torquewindow' => $data['step_torquewindow'],
            'step_torwin_target' => $data['step_torwin_target'],
            'torque_unit' => $data['torque_unit'],
            'step_angle_mode' => $data['step_anglemode'],
            'step_slope' => $data['step_slope'],
            'step_pnf_set'=> $data['step_pnf'],
            'step_tor_hold'=> 0,
            'step_msg'=> ''
        ];

        $statement = $this->db->prepare($sql);
        $results = $statement->execute($data2);
        // echo($sql);
        // var_dump($results);
        // var_dump($statement->errorInfo());

        return $results;
    }


    //swap sequence
    public function swap_advancedstep($job_id,$seq_id,$step_id1,$step_id2){

        //把temp seq_id 設定為 777
        //先將seq_id 1 改為 777
        //再將seq_id 2 改為 seq_id 1
        //再將seq_id 777 改為 seq_id 2
        //加入normal step change

        //swap advancedstep step
        $sql = "UPDATE `advancedstep` SET step_id = ? WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
        $statement = $this->db->prepare($sql);
        $result1 = $statement->execute([777,$job_id,$seq_id,$step_id1]);

        $sql = "UPDATE `advancedstep` SET step_id = ? WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
        $statement = $this->db->prepare($sql);
        $result2 = $statement->execute([$step_id1,$job_id,$seq_id,$step_id2]);

        $sql = "UPDATE `advancedstep` SET step_id = ? WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
        $statement = $this->db->prepare($sql);
        $result3 = $statement->execute([$step_id2,$job_id,$seq_id,777]);

        if($result1 && $result2 && $result3){
            return true;
        }else{
            return false;
        }
    }

    //取得step id
    public function get_head_step_id($job_id,$seq_id){

        $query = "SELECT step_id + 1 AS missing_id
                  FROM advancedstep
                  WHERE (step_id + 1) NOT IN (SELECT step_id FROM advancedstep where job_id = '".$job_id."' AND sequence_id = '".$seq_id."' ) order by  missing_id limit 1";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetch();
    }

    public function copy_step_by_step_id($job_id,$seq_id,$from_step_id,$to_step_id,$to_step_name){
        $sql= "INSERT INTO advancedstep (job_id,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_delayttime,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_monitoringmode,step_torwin_target,step_torquewindow,step_angwin_target,step_anglewindow,step_hightorque,step_lowtorque,step_monitoringangle,step_highangle,step_lowangle,torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg) 
                SELECT  job_id,sequence_id,sequence_name,?,?,step_targettype,step_targetangle,step_targettorque,step_delayttime,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_monitoringmode,step_torwin_target,step_torquewindow,step_angwin_target,step_anglewindow,step_hightorque,step_lowtorque,step_monitoringangle,step_highangle,step_lowangle,torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg
                FROM    advancedstep
                WHERE job_id = ? AND sequence_id = ? AND step_id = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$to_step_id,$to_step_name,$job_id,$seq_id,$from_step_id]);
        return $results;
    }

    //delete advancedstep by id
    public function delete_advancedstep_by_id($job_id,$seq_id,$step_id){

        $sql= "DELETE FROM advancedstep WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$seq_id,$step_id]);

        //更新seq_id
        $sql2= "UPDATE advancedstep SET step_id = step_id - 1 WHERE job_id = ? AND sequence_id = ? AND step_id > ?;";
        $statement2 = $this->db->prepare($sql2);
        $results2 = $statement2->execute([$job_id,$seq_id,$step_id]);

        return $results;
    }


    // ---------------------------------


}

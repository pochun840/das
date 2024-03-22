<?php

class Sequence{
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
    public function getSequences_by_job_id($job_id)
    {
        if($job_id > 100){
            $sql = "SELECT seq.*,ns.step_targettype,count(ns.sequence_id) as total_step FROM sequence as seq
                LEFT JOIN advancedstep as ns
                ON seq.sequence_id = ns.sequence_id AND seq.job_id = ns.job_id
                WHERE seq.job_id = '".$job_id."' group by seq.job_id,seq.sequence_id  ";
        }else{
            $sql = "SELECT seq.*,ns.step_targettype FROM sequence as seq
                LEFT JOIN normalstep as ns
                ON seq.sequence_id = ns.sequence_id AND seq.job_id = ns.job_id
                WHERE seq.job_id = '".$job_id."' order by sequence_id  ";
        }

        
        $statement = $this->db->prepare($sql);
        $statement->execute();

        return $statement->fetchall();
    }

    //取得job id，依job_type判斷
    public function get_head_seq_id($job_id){

        $query = "SELECT sequence_id + 1 AS missing_id
                  FROM sequence
                  WHERE (sequence_id + 1) NOT IN (SELECT sequence_id FROM sequence where job_id = '".$job_id."') order by  missing_id limit 1";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetch();
    }

    //create and update seq
    public function create_Seq($data)
    {
        //check job_id exist 
        $sql = "SELECT COUNT(*) as count FROM  `sequence` WHERE job_id = ? and sequence_id = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$data['job_id'],$data['sequence_id']]);
        $results = $statement->fetch();

        $data['sequence_enable'] = 1;//預設開啟
        $data['sequence_mintime'] = 0;//預設是0

        if($results['count'] > 0){//表示job_id已存在，用update
            $sql = "UPDATE `sequence` SET 'sequence_name'=?,'tightening_repeat'=?,'ng_stop'=?,'ok_sequence'=?,'ok_sequence_stop'=?,'sequence_maxtime'=? WHERE job_id = ? AND sequence_id =? ";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$data['sequence_name'],$data['tightening_repeat'],$data['ng_stop'],$data['ok_seq_option'],$data['ok_seq_stop_option'],$data['timeout'],$data['job_id'],$data['sequence_id']]);

            if($statement){//更新normalstep裡的seq_name
                $this->create_normalstep_by_seq($data['job_id'],$data['sequence_id'],$data['sequence_name']);
            }


        }else{//表示job_id & seq_id不存在，用insert
            $sql = "INSERT INTO `sequence` ('sequence_enable','job_id','sequence_id','sequence_name','tightening_repeat','ng_stop','ok_sequence','ok_sequence_stop','sequence_mintime','sequence_maxtime','sc_inter_time') VALUES ('".$data['sequence_enable']."','".$data['job_id']."',".$data['sequence_id'].",'".$data['sequence_name']."',".$data['tightening_repeat'].",".$data['ng_stop'].",".$data['ok_seq_option'].",".$data['ok_seq_stop_option'].",".$data['sequence_mintime'].",".$data['timeout'].",0); ";

            $statement = $this->db->prepare($sql);
            $results = $statement->execute();

            if($data['job_id'] > 100){//建立advancedstep
                $this->create_advancedstep_by_seq($data['job_id'],$data['sequence_id'],$data['sequence_name']);
            }else{//建立normalstep
                $this->create_normalstep_by_seq($data['job_id'],$data['sequence_id'],$data['sequence_name']);
            }
            
        }

        return $results;
    }

    //get seq by job_id and seq_id
    public function get_seq_by_id($job_id,$sequence_id){

        $sql= "SELECT * FROM sequence WHERE job_id = ? AND sequence_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$sequence_id]);
        $rows = $statement->fetch();

        return $rows;
    }

    //create normalstep
    public function create_normalstep_by_seq($job_id,$sequence_id,$sequence_name){
        //check normalstep_id exist 
        $sql = "SELECT COUNT(*) as count FROM  `normalstep` WHERE job_id = ? and sequence_id = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$sequence_id]);
        $results = $statement->fetch();

        if($results['count'] > 0){//表示normalstep_id已存在，用update

            if($job_id>100){
                $sql = "UPDATE `advancedstep` SET sequence_name=?  WHERE job_id = ? AND sequence_id = ? ";
                $statement = $this->db->prepare($sql);
                $results = $statement->execute([$sequence_name,$job_id,$sequence_id]);    
            }else{
                $sql = "UPDATE `normalstep` SET sequence_name=?  WHERE job_id = ? AND sequence_id = ? AND step_id = 1";
                $statement = $this->db->prepare($sql);
                $results = $statement->execute([$sequence_name,$job_id,$sequence_id]);    
            }
            
        }else{//表示job_id不存在，用insert

            //default值
            $data['sequence_name'] = $sequence_name;
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
                'sequence_id' => $sequence_id,
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

    }

    //create advancedstep
    public function create_advancedstep_by_seq($job_id,$sequence_id,$sequence_name){
        //check normalstep_id exist 
        $sql = "SELECT COUNT(*) as count FROM  `advancedstep` WHERE job_id = ? and sequence_id = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$sequence_id]);
        $results = $statement->fetch();

        if($results['count'] > 0){//表示normalstep_id已存在，用update
            $sql = "UPDATE `advancedstep` SET sequence_name=?  WHERE job_id = ? AND sequence_id = ? AND step_id = 1";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$sequence_name,$job_id,$sequence_id]);
        }else{//表示job_id不存在，用insert

            //default值
            $default_data = [
                'job_id'=> $job_id,
                'sequence_id'=> $sequence_id,
                'sequence_name'=> $sequence_name,
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

    //enable or disable sequence
    public function enable_disable_seq($job_id,$sequence_id,$status)   
    {
        $sql = "UPDATE `sequence` SET 'sequence_enable'= ? WHERE job_id = ? AND sequence_id =? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$status,$job_id,$sequence_id]);
        return $results;
    }

    //swap sequence
    public function swap_seq($job_id,$seq_id1,$seq_id2){

        //把temp seq_id 設定為 777
        //先將seq_id 1 改為 777
        //再將seq_id 2 給為 seq_id 1
        //再將seq_id 777 給為 seq_id 2
        //加入normal step change

        // 創建一個臨時變數來保存 id=1 的值
        $sql = "SELECT * FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':job_id', $job_id);
        $statement->bindValue(':sequence_id', $seq_id1);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $tempValues = $row;

        // // 將 id=1 的值更新為 id=2 的值
        $sql = "UPDATE sequence SET sequence_enable = (SELECT sequence_enable FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2), 
                                    sequence_name = (SELECT sequence_name FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2),
                                    tightening_repeat = (SELECT tightening_repeat FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2),
                                    ng_stop = (SELECT ng_stop FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2),
                                    ok_sequence = (SELECT ok_sequence FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2),
                                    ok_sequence_stop = (SELECT ok_sequence_stop FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2),
                                    sequence_mintime = (SELECT sequence_mintime FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2),
                                    sequence_maxtime = (SELECT sequence_maxtime FROM sequence WHERE job_id = :job_id AND sequence_id = :sequence_id_2)
                                WHERE job_id = :job_id AND sequence_id = :sequence_id_1";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':job_id', $job_id);
        $statement->bindValue(':sequence_id_1', $seq_id1);
        $statement->bindValue(':sequence_id_2', $seq_id2);
        $statement->execute();

        // // 將 id=2 的值更新為臨時變數中的值
        $sql = "UPDATE sequence SET sequence_enable = :sequence_enable, 
                                    sequence_name = :sequence_name,
                                    tightening_repeat = :tightening_repeat,
                                    ng_stop = :ng_stop,
                                    ok_sequence = :ok_sequence,
                                    ok_sequence_stop = :ok_sequence_stop,
                                    sequence_mintime = :sequence_mintime,
                                    sequence_maxtime = :sequence_maxtime
                                WHERE job_id = :job_id AND sequence_id = :sequence_id_2";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':job_id', $job_id);
        $statement->bindValue(':sequence_id_2', $seq_id2);
        $statement->bindValue(':sequence_enable', $tempValues['sequence_enable']);
        $statement->bindValue(':sequence_name', $tempValues['sequence_name']);
        $statement->bindValue(':tightening_repeat', $tempValues['tightening_repeat']);
        $statement->bindValue(':ng_stop', $tempValues['ng_stop']);
        $statement->bindValue(':ok_sequence', $tempValues['ok_sequence']);
        $statement->bindValue(':ok_sequence_stop', $tempValues['ok_sequence_stop']);
        $statement->bindValue(':sequence_mintime', $tempValues['sequence_mintime']);
        $statement->bindValue(':sequence_maxtime', $tempValues['sequence_maxtime']);
        $statement->execute();
     

        if($job_id < 100){
            //swap normal step
            $sql = "UPDATE `normalstep` SET sequence_id = ? WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
            $statement = $this->db->prepare($sql);
            $result1 = $statement->execute([777,$job_id,$seq_id1,1]);

            $sql = "UPDATE `normalstep` SET sequence_id = ? WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
            $statement = $this->db->prepare($sql);
            $result2 = $statement->execute([$seq_id1,$job_id,$seq_id2,1]);

            $sql = "UPDATE `normalstep` SET sequence_id = ? WHERE job_id = ? AND sequence_id = ? AND step_id = ?";
            $statement = $this->db->prepare($sql);
            $result3 = $statement->execute([$seq_id2,$job_id,777,1]);
        }else{
             //swap advancedstep step
            $sql = "UPDATE `advancedstep` SET sequence_id = ? WHERE job_id = ? AND sequence_id = ? ";
            $statement = $this->db->prepare($sql);
            $result1 = $statement->execute([777,$job_id,$seq_id1]);

            $sql = "UPDATE `advancedstep` SET sequence_id = ? WHERE job_id = ? AND sequence_id = ? ";
            $statement = $this->db->prepare($sql);
            $result2 = $statement->execute([$seq_id1,$job_id,$seq_id2]);

            $sql = "UPDATE `advancedstep` SET sequence_id = ? WHERE job_id = ? AND sequence_id = ? ";
            $statement = $this->db->prepare($sql);
            $result3 = $statement->execute([$seq_id2,$job_id,777]);
        }

        // var_dump($result1);
        // var_dump($result2);
        // var_dump($result3);

        if($result1 && $result2 && $result3){
            return true;
        }else{
            return false;
        }
    }

    public function copy_sequence_by_sequence_id($job_id,$from_sequence_id,$to_sequence_id,$to_sequence_name){
        $sql= "INSERT INTO sequence ( sequence_enable,job_id,sequence_id,sequence_name,tightening_repeat,ng_stop,ok_sequence,ok_sequence_stop,sequence_mintime,sequence_maxtime,sc_inter_time )
                SELECT  sequence_enable,job_id,?,?,tightening_repeat,ng_stop,ok_sequence,ok_sequence_stop,sequence_mintime,sequence_maxtime,sc_inter_time
                FROM    sequence
                WHERE sequence_id = ? AND job_id = ? ";
        $statement = $this->db->prepare($sql);
        return $results = $statement->execute([$to_sequence_id,$to_sequence_name,$from_sequence_id,$job_id]);
    }

    //copy normalstep by sequence id
    public function copy_normalstep_by_sequence_id($from_job_id,$from_sequence_id,$to_sequence_id,$to_sequence_name){
        $sql= "INSERT INTO normalstep ( job_id,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_hightorque,step_lowtorque,step_threshold_mode,step_threshold_torque,step_threshold_angle,step_monitoringangle,step_highangle,step_lowangle,step_downshift_enable,step_downshift_torque,step_downshift_speed,torque_unit,step_prr,step_prr_rpm,step_prr_angle,step_downshift_mode,step_downshift_angle,step_extra_mode,step_extra_dir,step_extra_ang,step_msg )
                SELECT  job_id,?,?,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_hightorque,step_lowtorque,step_threshold_mode,step_threshold_torque,step_threshold_angle,step_monitoringangle,step_highangle,step_lowangle,step_downshift_enable,step_downshift_torque,step_downshift_speed,torque_unit,step_prr,step_prr_rpm,step_prr_angle,step_downshift_mode,step_downshift_angle,step_extra_mode,step_extra_dir,step_extra_ang,step_msg 
                FROM    normalstep
                WHERE job_id = ? AND sequence_id = ? ";
        $statement = $this->db->prepare($sql);
        return $results = $statement->execute([$to_sequence_id,$to_sequence_name,$from_job_id,$from_sequence_id]);
    }

    //copy advancedstep by sequence id
    public function copy_advancedstep_by_sequence_id($from_job_id,$from_sequence_id,$to_sequence_id,$to_sequence_name){
        $sql= "INSERT INTO advancedstep ( job_id,sequence_id,sequence_name,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_delayttime,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_monitoringmode,step_torwin_target,step_torquewindow,step_angwin_target,step_anglewindow,step_hightorque,step_lowtorque,step_monitoringangle,step_highangle,step_lowangle,torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg )
                SELECT  job_id,?,?,step_id,step_name,step_targettype,step_targetangle,step_targettorque,step_delayttime,step_tooldirection,step_rpm,step_offsetdirection,step_torque_jointoffset,step_monitoringmode,step_torwin_target,step_torquewindow,step_angwin_target,step_anglewindow,step_hightorque,step_lowtorque,step_monitoringangle,step_highangle,step_lowangle,torque_unit,step_angle_mode,step_slope,step_pnf_set,step_tor_hold,step_msg 
                FROM    advancedstep
                WHERE job_id = ? AND sequence_id = ? ";
        $statement = $this->db->prepare($sql);
        return $results = $statement->execute([$to_sequence_id,$to_sequence_name,$from_job_id,$from_sequence_id]);
    }

     //delete sequence by id
    public function delete_sequence_by_job_seq_id($job_id,$seq_id){

        $sql= "DELETE FROM sequence WHERE job_id = ? AND sequence_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$seq_id]);

        //更新seq_id
        $sql2= "UPDATE sequence SET sequence_id = sequence_id - 1 WHERE job_id = ? AND sequence_id > ?;";
        $statement2 = $this->db->prepare($sql2);
        $results2 = $statement2->execute([$job_id,$seq_id]);

        return $results;
    }

    //delete normalstep by id
    public function delete_normalstep_by_job_seq_id($job_id,$seq_id){

        $sql= "DELETE FROM normalstep WHERE job_id = ? AND sequence_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$seq_id]);

        //更新seq_id
        $sql2= "UPDATE normalstep SET sequence_id = sequence_id - 1 WHERE job_id = ? AND sequence_id > ?;";
        $statement2 = $this->db->prepare($sql2);
        $results2 = $statement2->execute([$job_id,$seq_id]);

        return $results;
    }

    //delete advancedstep by id
    public function delete_advancedstep_by_job_seq_id($job_id,$seq_id){

        $sql= "DELETE FROM advancedstep WHERE job_id = ? AND sequence_id = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$seq_id]);

        //更新seq_id
        $sql2= "UPDATE advancedstep SET sequence_id = sequence_id - 1 WHERE job_id = ? AND sequence_id > ?;";
        $statement2 = $this->db->prepare($sql2);
        $results2 = $statement2->execute([$job_id,$seq_id]);

        return $results;
    }


}

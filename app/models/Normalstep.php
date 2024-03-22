<?php

class Normalstep{
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


    public function getNormalstep_by_job_seq_id($job_id,$seq_id){
        $sql = "SELECT * FROM normalstep WHERE job_id = ? AND sequence_id = ?  ";
        $statement = $this->db->prepare($sql);
        $statement->execute([$job_id,$seq_id]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function edit_step($data)
    {

        if($data['target_type'] == 'torque'){
            $data['target_type'] = 2;
            $data2 = [
                'job_id' => $data['job_id'],
                'sequence_id' => $data['sequence_id'],
                'target_type' => $data['target_type'],
                'Target_Angle' => $data['Target_Angle'],
                'Target_Torque' => $data['Target_Torque'],
                'Run_Down_Speed' => $data['Run_Down_Speed'],
                'Joint_OffSet' => $data['Joint_OffSet'],
                'Joint_OffSet_Option' => $data['Joint_OffSet_Option'],
                'Hi_Torque' => $data['Hi_Torque'],
                'Low_Torque' => $data['Low_Torque'],
                'threshold_torque' => $data['threshold_torque'],
                'Monitoring_Angle' => $data['Monitoring_Angle'],
                'High_Angle' => $data['High_Angle'],
                'Low_Angle' => $data['Low_Angle'],
                'Downshift_Enable' => $data['Downshift_Enable'],
                'Downshift_Torque' => $data['Downshift_Torque'],
                'Downshift_Speed' => $data['Downshift_Speed'],
                'Pre_Run_Unfasten' => $data['Pre_Run_Unfasten'],
                'Pre_Run_RPM' => $data['Pre_Run_RPM'],
                'Pre_Run_Angle' => $data['Pre_Run_Angle'],
                'torque_unit' => $data['torque_unit'],
                'Threshold_Type' => $data['Threshold_Type'],
                'Threshold_Angle' => $data['Threshold_Angle'],
            ];
            $sql = "UPDATE `normalstep` SET step_targettype = :target_type, step_targetangle = :Target_Angle, step_targettorque = :Target_Torque, step_rpm = :Run_Down_Speed,  step_torque_jointoffset = :Joint_OffSet,  step_offsetdirection = :Joint_OffSet_Option, step_hightorque = :Hi_Torque, step_lowtorque = :Low_Torque, step_threshold_torque = :threshold_torque,  step_monitoringangle = :Monitoring_Angle, step_highangle = :High_Angle, step_lowangle = :Low_Angle, step_downshift_enable = :Downshift_Enable, step_downshift_torque = :Downshift_Torque, step_downshift_speed = :Downshift_Speed, step_prr = :Pre_Run_Unfasten, step_prr_rpm = :Pre_Run_RPM, step_prr_angle = :Pre_Run_Angle, torque_unit = :torque_unit, step_threshold_mode = :Threshold_Type, step_threshold_angle = :Threshold_Angle  
            WHERE job_id = :job_id AND sequence_id = :sequence_id AND step_id = 1";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute($data2);

            return $results;
        }

        if($data['target_type'] == 'angle'){
            $data['target_type'] = 1;
            $data2 = [
                'job_id' => $data['job_id'],
                'sequence_id' => $data['sequence_id'],
                'target_type' => $data['target_type'],
                'Target_Angle' => $data['Target_Angle'],
                'Run_Down_Speed' => $data['Run_Down_Speed'],
                'Hi_Torque' => $data['Hi_Torque'],
                'Low_Torque' => $data['Low_Torque'],
                'threshold_torque' => $data['threshold_torque'],
                'High_Angle' => $data['High_Angle'],
                'Low_Angle' => $data['Low_Angle'],
                'Downshift_Enable' => $data['Downshift_Enable'],
                'Downshift_Torque' => $data['Downshift_Torque'],
                'Downshift_Speed' => $data['Downshift_Speed'],
                'Pre_Run_Unfasten' => $data['Pre_Run_Unfasten'],
                'Pre_Run_RPM' => $data['Pre_Run_RPM'],
                'Pre_Run_Angle' => $data['Pre_Run_Angle'],
                'torque_unit' => $data['torque_unit'],
                'Threshold_Type' => $data['Threshold_Type'],
                'Threshold_Angle' => $data['Threshold_Angle'],
            ];
            $sql = "UPDATE `normalstep` SET step_targettype = :target_type, step_targetangle = :Target_Angle, step_rpm = :Run_Down_Speed, step_hightorque = :Hi_Torque, step_lowtorque = :Low_Torque, step_threshold_torque = :threshold_torque,  step_highangle = :High_Angle, step_lowangle = :Low_Angle, step_downshift_enable = :Downshift_Enable, step_downshift_torque = :Downshift_Torque, step_downshift_speed = :Downshift_Speed, step_prr = :Pre_Run_Unfasten, step_prr_rpm = :Pre_Run_RPM, step_prr_angle = :Pre_Run_Angle, torque_unit = :torque_unit, step_threshold_mode = :Threshold_Type, step_threshold_angle = :Threshold_Angle 
            WHERE job_id = :job_id AND sequence_id = :sequence_id AND step_id = 1";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute($data2);

            return $results;
        }
        
    }


    // ---------------------------------


}
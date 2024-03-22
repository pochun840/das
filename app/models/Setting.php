<?php

class Setting{
    private $db;//condb control box
    private $db_dev;//devdb tool
    private $db_data;//devdb tool
    private $db_das;//devdb tool
    private $dbh;

    // 在建構子將 Database 物件實例化
    public function __construct()
    {
        $this->db = new Database;
        $this->db = $this->db->getDb();

        $this->db_dev = new Database;
        $this->db_dev = $this->db_dev->getDb_dev();

        $this->db_data = new Database;
        $this->db_data = $this->db_data->getDb_data();

        $this->db_das = new Database;
        $this->db_das = $this->db_das->getDb_das();

        $this->dbh = new Database;

    }

    public function GetControllerInfo()
    {
        $sql = "SELECT * FROM device ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function GetDeviceInfo()
    {
        $sql = "SELECT * FROM device_info ";
        $statement = $this->db_dev->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function GetToolInfo()
    {
        $sql = "SELECT * FROM tool_info ";
        $statement = $this->db_dev->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    public function GetOperator_priviledge()
    {
        $sql = "SELECT operator_priviledge FROM operator ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['operator_priviledge'];
    }

    public function GetAllJobs()
    {
        $sql = "SELECT * FROM job ORDER BY job_id";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $row;
    }

    public function GetAllSequences()
    {
        $sql = "SELECT * FROM sequence ORDER BY job_id,sequence_id";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $row;
    }

    public function GetAllSteps()
    {
        $sql = "SELECT job_id,sequence_id,step_id,step_name FROM normalstep WHERE 1 
                union 
                SELECT job_id,sequence_id,step_id,step_name FROM advancedstep WHERE 1 ORDER BY job_id,sequence_id,step_id ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $row;
    }


    public function Edit_Login_Password($new_password)
    {
        $sql = "UPDATE `operator` SET operator_adminpwd = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$new_password]);
        // $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $results;
    }

    public function Edit_Priviledge($value)
    {   
        if($value >= 65472 && $value <= 65535){
            $sql = "UPDATE `operator` SET operator_priviledge = ? ";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$value]);
        }else{
            $results = false;
        }
        // $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $results;
    }

    public function Controller_Setting($data)
    {
        $sql = "UPDATE `device` SET device_id =?, device_name=?, device_torque_unit=?, device_language=?, device_batch_mode=?, device_buzzer_mode=?,device_memory=?, device_diskfullwarning=?, device_torque_filter=?, device_datalog_frequency=?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([ $data['control_id'],$data['control_name'],$data['torque_unit'],$data['select_language'],$data['batch_mode_option'],$data['buzzer_mode_option'],$data['blackout_recovery_option'],$data['Diskfull_Warning'],$data['Torque_Filter'],$data['sample_rate'] ] );

        return $results;
    }

    public function Get_Controller_DB_version()
    {
        // code...
        $Controller_db_con = new PDO('sqlite:/var/www/html/database/tcscon.db'); //測試機
        $sql = "SELECT * FROM `device` ";
        $statement = $Controller_db_con->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['tcscondb_version'];
    }

    public function Get_Controller_Device_version()
    {
        // code...
        $Controller_db_con = new PDO('sqlite:/var/www/html/database/tcsdev.db'); //測試機
        $sql = "SELECT * FROM `device_info` ";
        $statement = $Controller_db_con->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['device_version'];
    }

    public function GetAllBarcodes()
    {
        $sql = "SELECT barcode.*,job.job_name FROM barcode left join `job` on barcode_selected_job = job_id order by barcode_selected_job";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $rows = $statement->fetchall(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function Update_Barcode($barcode_name,$barcode_from,$barcode_count,$barcode_mode,$job_id,$Seq_Select)
    {
        if( $this->check_barcode_conflict($job_id) ){ //已存在，用update

            $sql = "UPDATE `barcode` 
                    SET barcode = :barcode,
                        barcode_mask_from = :barcode_mask_from,
                        barcode_mask_count = :barcode_mask_count,
                        barcode_enable = :barcode_enable,
                        barcode_selected_seq = :barcode_selected_seq
                    WHERE barcode_selected_job = :barcode_selected_job ";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':barcode', $barcode_name);
            $statement->bindValue(':barcode_mask_from', $barcode_from);
            $statement->bindValue(':barcode_mask_count', $barcode_count);
            $statement->bindValue(':barcode_enable', $barcode_mode);
            $statement->bindValue(':barcode_selected_seq', $Seq_Select);
            $statement->bindValue(':barcode_selected_job', $job_id);
            $results = $statement->execute();


        }else{ //不存在，用insert

            $sql = "INSERT INTO `barcode` ('barcode','barcode_mask_from','barcode_mask_count','barcode_selected_job','barcode_enable','barcode_selected_seq' )
                    VALUES (:barcode,:barcode_mask_from,:barcode_mask_count,:barcode_selected_job,:barcode_enable,:barcode_selected_seq)";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':barcode', $barcode_name);
            $statement->bindValue(':barcode_mask_from', $barcode_from);
            $statement->bindValue(':barcode_mask_count', $barcode_count);
            $statement->bindValue(':barcode_enable', $barcode_mode);
            $statement->bindValue(':barcode_selected_seq', $Seq_Select);
            $statement->bindValue(':barcode_selected_job', $job_id);
            $results = $statement->execute();

        }

        return $results;
    }

    public function check_barcode_conflict($job_id)
    {
        $sql = "SELECT count(*) as count FROM barcode WHERE barcode_selected_job = :barcode_selected_job";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':barcode_selected_job', $job_id);
        $results = $statement->execute();
        $rows = $statement->fetch();

        if ($rows['count'] > 0) {
            return true; // job event已存在
        }else{
            return false; // job event不存在
        }
    }

    //get all job
    public function get_job_list()
    {
        $sql = "SELECT * FROM job ORDER BY job_id";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $rows = $statement->fetchall(PDO::FETCH_ASSOC);

        return $rows;
    }

    //get all job seq
    public function get_seq_list($job_id)
    {
        $sql = "SELECT job_id,sequence_id,sequence_name FROM sequence WHERE job_id = :job_id AND sequence_enable = 1 order by sequence_id";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':job_id', $job_id);
        $results = $statement->execute();
        $rows = $statement->fetchall(PDO::FETCH_ASSOC);

        return $rows;
    }

    //get job barcdoe
    public function get_job_barcode($job_id)
    {
        $sql = "SELECT * FROM barcode WHERE barcode_selected_job = :job_id ";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':job_id', $job_id);
        $results = $statement->execute();
        $rows = $statement->fetchall(PDO::FETCH_ASSOC);

        return $rows;
    }

    //delete job barcdoe
    public function delete_job_barcode($job_id)
    {
        $sql = "DELETE FROM barcode WHERE barcode_selected_job = :job_id ";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':job_id', $job_id);
        $results = $statement->execute();

        return $results;
    }

    //get update information
    public function get_update_info()
    {
        //1.tcscondb_version from tcscon.db device table
        //2.device_version from tcsdev.db device_info table
        //3.tcsdevdb_version from tcsdev.db device_info table
        $results = array();

        // $controller_info = $this->GetControllerInfo();//666 Get_Controller_DB_version
        // $device_info = $this->GetDeviceInfo();
        
        // $results['tcscondb_version'] = $controller_info['tcscondb_version'];
        // $results['device_version'] = $device_info['device_version'];
        // $results['tcsdevdb_version'] = $device_info['tcsdevdb_version'];

        //判斷控制器本身 而非idas複製出來的db
        $controller_db_version = $this->Get_Controller_DB_version();//666 Get_Controller_DB_version
        $device_version = $this->Get_Controller_Device_version();

        $results['tcscondb_version'] = trim($controller_db_version);
        $results['device_version'] = trim($device_version);

        return $results;
    }

    public function update_idas_vesrion($new_version)
    {

        $exist = $this->check_das_config('idas_version');

        if($exist){
            $sql = "UPDATE `config` 
                    SET config_value = :new_version
                    WHERE config_name = 'idas_version' ";
        }else{
            $sql = "INSERT INTO `config` ('config_name','config_value' )
                    VALUES ('idas_version',:new_version )";
        }

        $statement = $this->db_das->prepare($sql);
        $statement->bindValue(':new_version', $new_version);
        $results = $statement->execute();

        return $results;
    }

    public function update_idas_match_gtcs_app_version($new_version)
    {

        $exist = $this->check_das_config('match_gtcs_app_version');

        if($exist){
            $sql = "UPDATE `config` 
                    SET config_value = :new_version
                    WHERE config_name = 'match_gtcs_app_version' ";
        }else{
            $sql = "INSERT INTO `config` ('config_name','config_value' )
                    VALUES ('match_gtcs_app_version',:new_version )";
        }

        $statement = $this->db_das->prepare($sql);
        $statement->bindValue(':new_version', $new_version);
        $results = $statement->execute();

        return $results;
    }

    public function check_das_config($config_name)
    {
        $sql = "SELECT count(*) as count FROM `config` WHERE config_name = :config_name";
        $statement = $this->db_das->prepare($sql);
        $statement->bindValue(':config_name', $config_name);
        $results = $statement->execute();
        $rows = $statement->fetch();

        if ($rows['count'] > 0) {
            return true; // job event已存在
        }else{
            return false; // job event不存在
        }
    }

    public function Get_System_Toq_Unit()
    {
        $sql = "SELECT device_torque_unit FROM device";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['device_torque_unit'];
    }

}

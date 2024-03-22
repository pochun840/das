<?php

class Output{
    private $db;//condb control box
    private $db_dev;//devdb tool
    private $db_data;//devdb tool
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

        $this->dbh = new Database;

    }

    //get_input_by_job_id
    public function get_output_by_job_id($job_id)
    {   
        $sql = "SELECT * FROM output WHERE output_jobid = ? ORDER BY output_event";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);
        $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $row;
    }

    public function check_job_output_conflict($job_id,$event_id)
    {
        $sql = "SELECT count(*) as count FROM output WHERE output_jobid = ? AND output_event = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$event_id]);
        $rows = $statement->fetch();

        if ($rows['count'] > 0) {
            return true; // job event已存在
        }else{
            return false; // job event不存在
        }
    }

    public function create_output($job_id,$event_id,$output_pin,$option,$time)
    {    
        if( $this->check_job_output_conflict($job_id,$event_id) ){ //已存在，用update
            $sql = "UPDATE `output` SET output_pin = ?, wave = ?, wave_on = ? WHERE output_jobid = ? AND output_event = ?";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$output_pin,$option,$time,$job_id,$event_id]);
        }else{ //不存在，用insert
            $sql = "INSERT INTO `output` ('output_jobid','output_pin','output_event','wave','wave_on','wave_off','output_seqid') VALUES (?,?,?,?,?,?,?) ";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$job_id,$output_pin,$event_id,$option,$time,0,1]);
        }

        return $results;
    }

    public function copy_output_by_id($from_job_id,$to_job_id){
        // 判斷job_id是否存在，若存在就先把舊的刪除
        // $dupli_flag true:表示job_id已存在 false:表示job_id不存在
        if(true){//先刪除再複製
            $this->delete_output_by_id($to_job_id);
        }
        $sql= "INSERT INTO output ( output_jobid,output_pin,output_event,wave,wave_on,wave_off )
                SELECT  ?,output_pin,output_event,wave,wave_on,wave_off 
                FROM    output
                WHERE output_jobid = ? ";
        $statement = $this->db->prepare($sql);

        return $results = $statement->execute([$to_job_id,$from_job_id]);
    }

    //delete output by job_id
    public function delete_output_by_id($job_id){

        $sql= "DELETE FROM output WHERE output_jobid = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }
    //delete output by job_id and event_id
    public function delete_output_event_by_id($job_id,$event_id){

        $sql= "DELETE FROM output WHERE output_jobid = ? AND output_event = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$event_id]);

        return $results;
    }

    //set input_alljob
    public function set_output_alljob($job_id){

        $sql= "UPDATE device SET device_output_alljob = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }


}

<?php

class Input{
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
    public function get_input_by_job_id($job_id)
    {   
        $sql = "SELECT * FROM input WHERE input_jobid = ? ORDER BY CASE WHEN input_event >= 200 THEN 0 ELSE 1 END, input_event";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);
        $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $row;
    }

    //get device_input_alljob
    public function get_input_alljob()
    {   
        $sql = "SELECT * FROM device ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row;
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

    public function check_job_event_conflict($job_id,$event_id)
    {
        $sql = "SELECT count(*) as count FROM input WHERE input_jobid = ? AND input_event = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$event_id]);
        $rows = $statement->fetch();

        if ($rows['count'] > 0) {
            return true; // job event已存在
        }else{
            return false; // job event不存在
        }
    }

    public function create_input($job_id,$event_id,$input_pin,$option,$gateconfirm)
    {
        $pin = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '6' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
        ];

        if($option == 'on'){
            $pin[$input_pin] = 1;
        }else{
            $pin[$input_pin] = 2;
        }
        
        if( $this->check_job_event_conflict($job_id,$event_id) ){ //已存在，用update
            $sql = "UPDATE `input` SET input_pin2 = ?, input_pin3 = ?, input_pin4 = ?, input_pin5 = ?, input_pin6 = ?, input_pin7 = ?, input_pin8 = ?, input_pin9 = ?, input_pin10 = ?, input_gateconfirm = ? WHERE input_jobid = ? AND input_event = ?";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$pin[2],$pin[3],$pin[4],$pin[5],$pin[6],$pin[7],$pin[8],$pin[9],$pin[10],$gateconfirm,$job_id,$event_id]);
        }else{ //不存在，用insert
             $sql = "INSERT INTO `input` ('input_jobid','input_event','input_pin1','input_pin2','input_pin3','input_pin4','input_pin5','input_pin6','input_pin7','input_pin8','input_pin9','input_pin10','input_gateconfirm','input_pagemode','input_seqid') VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
            $statement = $this->db->prepare($sql);
            $results = $statement->execute([$job_id,$event_id,$pin[1],$pin[2],$pin[3],$pin[4],$pin[5],$pin[6],$pin[7],$pin[8],$pin[9],$pin[10],$gateconfirm,0,-1]);
        }

        return $results;
    }

    public function copy_input_by_id($from_job_id,$to_job_id){
        // 判斷job_id是否存在，若存在就先把舊的刪除
        // $dupli_flag true:表示job_id已存在 false:表示job_id不存在
        if(true){//先刪除再複製
            $this->delete_input_by_id($to_job_id);
        }
        $sql= "INSERT INTO input ( input_jobid,input_event,input_pin1,input_pin2,input_pin3,input_pin4,input_pin5,input_pin6,input_pin7,input_pin8,input_pin9,input_pin10,input_gateconfirm,input_pagemode )
                SELECT  ?,input_event,input_pin1,input_pin2,input_pin3,input_pin4,input_pin5,input_pin6,input_pin7,input_pin8,input_pin9,input_pin10,input_gateconfirm,input_pagemode
                FROM    input
                WHERE input_jobid = ? ";
        $statement = $this->db->prepare($sql);

        return $results = $statement->execute([$to_job_id,$from_job_id]);
    }

    //delete input by job_id
    public function delete_input_by_id($job_id){

        $sql= "DELETE FROM input WHERE input_jobid = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }
    //delete input by job_id and event_id
    public function delete_input_event_by_id($job_id,$event_id){

        $sql= "DELETE FROM input WHERE input_jobid = ? AND input_event = ?";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id,$event_id]);

        return $results;
    }

    //set input_alljob
    public function set_input_alljob($job_id){

        $sql= "UPDATE device SET device_input_alljob = ? ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute([$job_id]);

        return $results;
    }

}

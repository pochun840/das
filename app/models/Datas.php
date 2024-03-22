<?php
class Datas{
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

    public function getData($type)
    {
        $sql = "SELECT * FROM data ORDER BY data_time DESC LIMIT 100 ";
        if($type == 'OK'){
            $sql = "SELECT * FROM ( SELECT * FROM data WHERE fasten_status = 4 or fasten_status = 5 or fasten_status = 6 ORDER BY data_time DESC LIMIT 100 ) AS recent_data ORDER BY data_time DESC;";
        }
        if($type == 'NOK'){
            $sql = "SELECT * FROM ( SELECT * FROM data WHERE fasten_status = 7 or fasten_status = 8 ORDER BY data_time DESC LIMIT 100 ) AS recent_data ORDER BY data_time DESC;";
        }
        
        $statement = $this->db_data->prepare($sql);
        if($statement != false){
            $results = $statement->execute();
            $row = $statement->fetchall(PDO::FETCH_ASSOC);

            return $row;
        }else{
            return array();
        }
    }

    public function get_range_data($start_date,$end_date)
    {
        $sql = "SELECT * FROM data 
                WHERE data_time BETWEEN '".$start_date."' AND '".$end_date."'
                ORDER BY data_time LIMIT 100";
        
        $statement = $this->db_data->prepare($sql);
        if($statement != false){
            $results = $statement->execute();
            $row = $statement->fetchall(PDO::FETCH_ASSOC);

            return $row;
        }else{
            return array();
        }
    }

    public function get_range_data_year($start_date,$end_date,$year)
    {
        
        $data_db_name = "data".$year.".db";
        // 透過 PHP_OS_FAMILY 判斷，目前執行的系統，決定要採用的DB路徑
        if( PHP_OS_FAMILY == 'Linux'){
            //加入 if isset
            if(file_exists('/var/www/html/database/'.$data_db_name)){
                $db_data = new PDO('sqlite:/var/www/html/database/'.$data_db_name); //測試機
            }else{
                return array();
            }
        }else{
            //加入 if isset
            if( file_exists('../'.$data_db_name) ){
                $db_data = new PDO('sqlite:../'.$data_db_name); //local
            }else{
                return array();
            }
        }
        $db_data->exec('set names utf-8'); 

        $sql = "SELECT * FROM data 
                WHERE data_time BETWEEN '".$start_date."' AND '".$end_date."'
                ORDER BY data_time LIMIT 10000";
        
        $statement = $db_data->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetchall(PDO::FETCH_ASSOC);

        return $row;
    }

    public function get_range_data_count($start_date,$end_date,$year)
    {
        $data_db_name = "data".$year.".db";
        // 透過 PHP_OS_FAMILY 判斷，目前執行的系統，決定要採用的DB路徑
         if( PHP_OS_FAMILY == 'Linux'){
            if(file_exists('/var/www/html/database/'.$data_db_name)){
                $db_data = new PDO('sqlite:/var/www/html/database/'.$data_db_name); //測試機
            }else{
                return false;
            }
        }else{
            if( file_exists('../'.$data_db_name) ){
                $db_data = new PDO('sqlite:../'.$data_db_name); //local   
            }else{
                return false;
            }
        }
        $db_data->exec('set names utf-8'); 

        $sql = "SELECT count(*) as count FROM data 
                WHERE data_time BETWEEN '".$start_date."' AND '".$end_date."'
                ";
        
        $statement = $db_data->prepare($sql);
        // var_dump($statement);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['count'];
    }


}
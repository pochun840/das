<?php

class Dashboard{
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

    //驗證job id是否重複
    public function get_last_data()
    {
        $sql = "SELECT * FROM data ORDER BY system_sn DESC LIMIT 1";
        $statement = $this->db_data->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //get tool max,min rpm
    public function get_tool_info()
    {
        $sql = "SELECT *,
                   CASE tool_minrpm 
                       WHEN '20' 
                           THEN '60' 
                       ELSE '60' 
                   END tool_minrpm 
                FROM tool_info";
        $statement = $this->db_dev->prepare($sql);
        $results = $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);

        return $rows;
    }

    //return datalog csv for graph
    public function get_device_datalog_frequency()
    {
        $sql = "SELECT device_datalog_frequency  FROM device ";
        $statement = $this->db->prepare($sql);
        $results = $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row['device_datalog_frequency'];
       
    }

    //get tool max,min rpm
    public function get_tool_info_unit_convert()
    {
        $sql = "SELECT * FROM tool_info";
        $statement = $this->db_dev->prepare($sql);
        $results = $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);

        $sql2 = "SELECT device_torque_unit FROM device";
        $statement2 = $this->db->prepare($sql2);
        $results2 = $statement2->execute();
        $rows2 = $statement2->fetch(PDO::FETCH_ASSOC);

        // device_torque_unit
        // 0: 公斤米
        // 1: 牛頓米 起子預設是牛頓米
        // 2: 公斤公分
        // 3: 英鎊英寸

        //使用時機 1. output 輸出給前端時，要依據目前系統的扭力單位設定，顯示對應的扭力數值
        //使用時機 2. input 寫入資料庫時，要依據目前系統的扭力單位設定，將數值轉換為牛頓米寫到資料庫中


        return $rows;
    }





}

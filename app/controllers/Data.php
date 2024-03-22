<?php

class Data extends Controller
{
    // 在建構子中將 Post 物件（Model）實例化
    public function __construct()
    {
        $this->DataModel = $this->model('Datas');
    }

    // 取得所有Jobs
    public function index(){

        $isMobile = $this->isMobileCheck();
        $Data_ALL = $this->DataModel->getData('ALL');
        $Data_OK = $this->DataModel->getData('OK');
        $Data_NOK = $this->DataModel->getData('NOK');
        $device_info = $this->Device_Info();

        $data = [
            'isMobile' => $isMobile,
            'Data_ALL' => $Data_ALL,
            'Data_OK' => $Data_OK,
            'Data_NOK' => $Data_NOK,
            'device_info' => $device_info,
        ];
        
        $this->view('data/index', $data);

    }


    public function exportData()
    {
        $input_check = true;
        if( !empty($_POST['start_date']) && isset($_POST['start_date'])  ){
            $start_date = $_POST['start_date'];
        }else{ 
            $input_check = false; 
        }
        if( !empty($_POST['end_date']) && isset($_POST['end_date'])  ){
            $end_date = $_POST['end_date'];
        }else{ 
            $input_check = false; 
        }

        if($input_check){
            $total_count = 0;
            $start_date = str_replace('-', "", $start_date);
            $end_date = str_replace('-', "", $end_date);
            $start_year = substr($start_date,0,4);
            $end_year = substr($end_date,0,4);
            $dataset = array();

            //計算筆數
            for ($i=$start_year; $i <=$end_year ; $i++) { 
                $total_count += $this->DataModel->get_range_data_count($start_date,$end_date,$i);
            }
            //超過XXX筆跳出，預設 10000
            if($total_count < 10000){
                for ($i=$start_year; $i <=$end_year ; $i++) { 
                    $temp_dataset = $this->DataModel->get_range_data_year($start_date,$end_date,$i);
                    $dataset = array_merge($dataset,$temp_dataset);
                }
            }else{
                // header('Content-Type: text/csv');
                // header('Content-Disposition: attachment; filename=1231.csv');
                echo 'false';
            }

        }

        //建立table header
        $header = array();
        if(isset($dataset[0])){
            foreach ($dataset[0] as $key => $value) {
                array_push($header,$key);            
            }
        }

        // 设置 CSV 文件名
        $filename = 'export_data.csv';

        // 设置 CSV 文件的 HTTP 头信息
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);

        // 创建输出流
        $output = fopen('php://output', 'w');

        // 写入 CSV 头部
        fputcsv($output, $header);

        $sn = 1;
        foreach ($dataset as $key => $value) {
            // code...
            $value['system_sn'] = $sn; //調整sn
            $value['torque_unit'] = $this->unit_type($value['torque_unit']);
            $value['fasten_status'] = $this->f_status($value['fasten_status']);
            fputcsv($output, $value);
            $sn++;
        }

        // 关闭输出流
        fclose($output);
        exit;

    }


    public function f_status($value=0)
    {
        //fasten_status
        $text['fasten_status_0'] = 'INIT';
        $text['fasten_status_1'] = 'READY';
        $text['fasten_status_2'] = 'RUNNING';
        $text['fasten_status_3'] = 'REVERSE';
        $text['fasten_status_4'] = 'OK';
        $text['fasten_status_5'] = 'OK_SEQ';
        $text['fasten_status_6'] = 'OK_JOB';
        $text['fasten_status_7'] = 'NG';
        $text['fasten_status_8'] = 'NS';
        $text['fasten_status_9'] = 'SETTING';
        $text['fasten_status_10'] = 'EOC';
        $text['fasten_status_11'] = 'C1';
        $text['fasten_status_12'] = 'C1_ERR';
        $text['fasten_status_13'] = 'C2';
        $text['fasten_status_14'] = 'C2_ERR';
        $text['fasten_status_15'] = 'C4';
        $text['fasten_status_16'] = 'C4_ERR';
        $text['fasten_status_17'] = 'C5';
        $text['fasten_status_18'] = 'C5_ERR';
        $text['fasten_status_19'] = 'BS';

        return $text['fasten_status_'.$value];
    }

    public function unit_type($value=0)
    {
        //unit_status_0
        $text['unit_status_0'] = 'Kgf-m';
        $text['unit_status_1'] = 'N-m';
        $text['unit_status_2'] = 'Kgf-cm';
        $text['unit_status_3'] = 'In-lbs';

        return $text['unit_status_'.$value];
    }
    
}
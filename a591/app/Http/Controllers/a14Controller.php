<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class a14Controller extends Controller
{
    public $cookie = 'urlColor=agent%2FAccountServlet%3Frate%3D5%26bool%3D5; unknown=B8D3ECBC75D770254FCFF5FCADBC2414; JSESSIONID=36854D12758735AC6FFD99739074A3C9; route=803e9b55e31ec8a75d8187adf133bde4';

    public function a14()
    {
        set_time_limit(300);
        $rate = 5;  //類別
        $bool = 0;
        $pageNo = 32;    //頁數0開始
        $pageSize = 1000;   //單次會員數

        //使用excel
        $t3 = 0;
        $fp = fopen('file.csv', 'a+');
        fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF)); //解決excel寫入亂碼
        for ($i=1; $i <= 10 ; $i++) { 
            $t1 = microtime(true);
            //用curl
            $htmlData = $this->curlMemberData($rate, $bool, $pageNo+$i, $pageSize);
            //處理回傳的HTML
            $arrMemberData = $this->MemberData($fp, $htmlData);
            $id = $arrMemberData['id'];
            unset($arrMemberData['id']);
            foreach ($arrMemberData as $key => $value) {
                fputcsv($fp, $value); //excel寫入會員資料
            }
            if (count($id) < $pageSize) {  //檢查是否最後一頁，不足每頁搜尋筆數跳出
                break;
            }
            //暂停 10 秒
            // sleep(1);
            $t2 = microtime(true);
            $t3 += round($t2-$t1,3);
            echo '耗时'.round($t2-$t1,3).'秒'.$t3.'</br>';
        }
        //關閉excel
        fclose($fp);
        exit;

        //使用excel
        $fp = fopen('file.csv', 'a+');
        $fgetcsv = fgetcsv();
        $i = 0;
        $amount = 3;    //每次查詢會員錢包人數
        do {
            sleep(1);
            $arrayOut = array_slice($arrMemberData['id'], $i*$amount, 3);
            $arrMoneyAll = $this->getAmount2($arrayOut);
            //放入陣列
            foreach ($arrMoneyAll as $id => $value) {
                $arrMemberData[$id][] = $value;
            }
            $i++;
        } while ($i < $pageSize/$amount);
        //關閉excel
        fclose($fp);

        // foreach ($arrMemberData['id'] as $key => $id) {
        //     //請求詳細餘額
        //     $getAmount = $this->getAmount($id);
        //     $arrMemberData[$id][] = $getAmount; //單一會員所有餘額, getAmount
        //     //請求詳細會員資料
        //     $getMemberDataAll = $this->getMemberDataAll($id);
        //     //處理回傳的HTML
        //     $arrMemberDataAll = $this->MemberDataAll($getMemberDataAll);
        //     $arrMemberData[$id][] = $arrMemberDataAll; //單一會員會員詳細資料, MemberDataAll
        // }
        
        //寫入筆記本
        // $jsonMemberData = json_encode($arrMemberData, JSON_UNESCAPED_UNICODE);
        // file_put_contents("data" . date("YmdHis") . ".txt", $jsonMemberData);
        // dd($arrMemberData);
        exit;

        //用抓的
        // $getMemberData = $this->getMemberData($rate, $bool, $pageNo, $pageSize);
        // $htmlData = $getMemberData->getBody()->getContents();
        
        return view('index');
    }
    
    /**\
    * 匯出Excel檔案 速度慢
    * @param $fileName 匯出的檔名
    * @param $headArr 資料頭
    * @param $data 匯出資料
    */
    function getExcel($fileName,$headArr,$data){
        //設定PHP最大單執行緒的獨立記憶體使用量
        ini_set('memory_limit','1024M');
        //程式超時設定設為不限時
        ini_set('max_execution_time ','0');
    
        //匯入PHPExcel類庫，因為PHPExcel沒有用名稱空間，所以使用vendor匯入
        vendor("PHPExcel.PHPExcel.IOFactory");
        vendor("Excel.PHPExcel");
        vendor("Excel.PHPExcel.Writer.Excel5");
        vendor("Excel.PHPExcel.IOFactory.php");
    
        //對資料進行檢驗
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }
        //檢查檔名
        if(empty($fileName)){
            exit;
        }
        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";
        //建立PHPExcel物件
        $objPHPExcel = new \PHPExcel();
    
        //設定表頭
        $key = ord("A");
        foreach($headArr as $hkey => $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
            unset($headArr[$hkey]);
        }
        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach($data as $key => $rows){ //行寫入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列寫入
                $j = chr($span);
                //設定匯出單元格格式為文字，避免身份證號的資料被Excel改寫
                $objActSheet->setCellValueExplicit($j.$column, $value);
                $span++;
                unset($rows[$keyName]);
            }
            $column++;
            unset($data[$key]);
        }
        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重新命名錶
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //設定活動單指數到第一個表,所以Excel開啟這是第一個表
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        ob_start();
        header('Content-Type: application/vnd.ms-excel');//定義輸出的檔案型別為excel檔案
        header("Content-Disposition: attachment;filename=\"$fileName\"");//定義輸出的檔名
        header('Cache-Control: max-age=0');//強制每次請求直接傳送給源伺服器，而不經過本地快取版本的校驗。
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output'); //檔案通過瀏覽器下載
        exit;
    }
    
    public function MemberDataAll($htmlData){
        
        $domData = new \DOMDocument();
        @$domData->loadHTML($htmlData);
        $dataTable = $domData->getElementsByTagName("tbody")->item(1);  //取第一個tbody
        $dataTableTrs = $dataTable->getElementsByTagName("tr"); //取所有tr
        $dataTable2 = $domData->getElementsByTagName("tbody")->item(2);  //取第二個tbody
        $dataTable2Trs = $dataTable2->getElementsByTagName("tr"); //取所有tr
        $arrMemberData = [];
        $arrMemberData[] = $dataTableTrs->item(0)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //真实姓名
        $arrMemberData[] = $dataTableTrs->item(1)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //微信昵称
        $arrMemberData[] = $dataTableTrs->item(2)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //中文昵称
        $arrMemberData[] = $dataTableTrs->item(3)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //英文昵称
        $arrMemberData[] = $dataTableTrs->item(4)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //生日
        $arrMemberData[] = $dataTableTrs->item(5)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //国家
        $arrMemberData[] = $dataTableTrs->item(6)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //身份证号
        $arrMemberData[] = $dataTableTrs->item(7)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //护照号码
        $arrMemberData[] = $dataTableTrs->item(8)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //手机
        $arrMemberData[] = $dataTableTrs->item(9)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //微信
        $arrMemberData[] = $dataTableTrs->item(10)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //QQ
        $arrMemberData[] = $dataTableTrs->item(11)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //E-mail
        $bankCard = array();
        for ($i=0; $i < $dataTableTrs->item(12)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value') ; $i++) {   //卡的數量
            $bankCard[$i][] = $dataTable2Trs->item(1)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(1)->getAttribute('value');  //取款银行
            $bankCard[$i][] = $dataTable2Trs->item(1)->getElementsByTagName("td")->item(1)->getElementsByTagName("select")->item(0)->getAttribute('initval');  //开户行省
            $bankCard[$i][] = $dataTable2Trs->item(1)->getElementsByTagName("td")->item(2)->getElementsByTagName("select")->item(0)->getAttribute('initval');  //开户行市
            $bankCard[$i][] = $dataTable2Trs->item(1)->getElementsByTagName("td")->item(3)->getElementsByTagName("input")->item(0)->getAttribute('value');  //其他市县
            $bankCard[$i][] = $dataTable2Trs->item(1)->getElementsByTagName("td")->item(4)->getElementsByTagName("input")->item(0)->getAttribute('value');  //开户行
            $bankCard[$i][] = $dataTable2Trs->item(1)->getElementsByTagName("td")->item(5)->getElementsByTagName("input")->item(0)->getAttribute('value');  //取款账号
            $bankCard[$i][] = $dataTable2Trs->item(1)->getElementsByTagName("td")->item(6)->getElementsByTagName("input")->item(0)->getAttribute('value');  //默认银行卡
        }
        $arrMemberData[] = $bankCard;  //银行卡
        $arrMemberData[] = $dataTableTrs->item(13)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //支付宝
        $arrMemberData[] = $dataTableTrs->item(14)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //取款密码
        $arrMemberData[] = $dataTableTrs->item(15)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //登录密码
        $arrMemberData[] = $dataTableTrs->item(16)->getElementsByTagName("td")->item(0)->getElementsByTagName("textarea")->item(0)->nodeValue;  //备注
        $arrMemberData[] = $dataTableTrs->item(17)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');  //动态口令(操作人)
        return $arrMemberData;
    }

    public function asynchronousCurl($url,$params) {
        $ch = curl_init();
        $headers = array("Content-type: application/json;charset='utf-8'",
            "Accept: application/json",
            "Cache-Control: no-cache","Pragma: no-cache");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);//设置提交的字符串
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    //设置头信息
        curl_setopt($ch, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1 );    //获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //不进行ssl验证
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        //设置超时时间为1秒,超过1秒则关闭连接
        curl_setopt($ch,CURLOPT_TIMEOUT,1);
        //curl_setopt($ch, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
        //curl_setopt($ch, CURLOPT_TIMEOUT_MS, 200); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
        curl_setopt($ch, CURLOPT_HEADER, 0); // 设置是否显示返回头信息  1返回 0不返回
        curl_setopt($ch, CURLOPT_NOBODY, 0); //不想在输出中包含body部分，设置这个选项为一个非零值
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    public function getMemberDataAll($id){
        $curl = curl_init();
        //用proxy
        $proxy = "10.0.0.48:8001";
        curl_setopt($curl, CURLOPT_PROXY, $proxy);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://arxntfea14.sharksu.com/agent/AccountServlet?doQueryMessageInfo=queryMessageInfo&rate=5&bool=5&id=' . $id . '&banktype=0&pageLog=/agent/AccountServlet?rate=5&bool=5',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
              'Cookie:' . $this->cookie,
              'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36'
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
        return $response;

    }

    public function getAmount2($id){

        $mh = curl_multi_init();
        $ch1arr = array();
        foreach ($id as $key => $value) {
            // 初始化异步多请求
            $ch1 = curl_init('https://arxntfea14.sharksu.com/agent/getAccountMoney?account6=' . $value . '&apiKey=all&useApi=1');
            //用proxy
            $proxy = "10.0.0.48:8001";
            curl_setopt($ch1, CURLOPT_PROXY, $proxy);
            curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
                'Cookie:' . $this->cookie,
                'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36'
            ));
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
            // 添加前面的每个handle
            curl_multi_add_handle($mh, $ch1);
            $ch1arr[$value] = $ch1;
        }

        // 执行请求
        $active = null;
        do {
            $status = curl_multi_exec($mh, $active);
        }while($status === CURLM_CALL_MULTI_PERFORM);
        while ($active && $status == CURLM_OK){
            if(curl_multi_select($mh) === -1){
                usleep(1000);
            }
            do {
                $status = curl_multi_exec($mh, $active);
            }while ($status === CURLM_CALL_MULTI_PERFORM);
        }
        
        // 如果需要返回结果
        foreach ($ch1arr as $key => $value) {
            $res[$key] = json_decode(curl_multi_getcontent($value), true);
        }
        
        // 移除handle
        curl_multi_remove_handle($mh, $ch1);
        
        // 关闭
        curl_multi_close($mh);

        return $res;
    }

    public function getAmount($id){
        $curl = curl_init();
        //用proxy
        $proxy = "10.0.0.48:8001";
        curl_setopt($curl, CURLOPT_PROXY, $proxy);

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://arxntfea14.sharksu.com/agent/getAccountMoney?account6=' . $id . '&apiKey=all&useApi=1',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Cookie:' . $this->cookie,
            'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true);
    }
    
    public function MemberData($fp, $htmlData){
        
        $domData = new \DOMDocument();
        @$domData->loadHTML($htmlData);
        //將陣列 title 寫入excel
        // $arrTitle = array();
        // foreach ($domData->getElementsByTagName("thead")->item(0)->getElementsByTagName("tr")->item(0)->getElementsByTagName("th") as $value) {
        //     $arrTitle[] = $value->nodeValue;
        // }
        // array_pop($arrTitle);   //刪除陣列第一個
        // array_shift($arrTitle); //刪除陣列最後一個
        // fputcsv($fp, $arrTitle);  //寫入title
        $dataTable = $domData->getElementsByTagName("tbody")->item(0);  //取第一個tbody
        $dataTableTrs = $dataTable->getElementsByTagName("tr"); //取所有tr
        $arrMemberData = array();
        foreach ($dataTableTrs as $key => $value) { //所有tr分開
            $tds = $value->getElementsByTagName("td");
            // print_r($tds);
            if($tds->length == 107){    //會員td元素共有107個
                // $i1 = date('H:i:s');
                // $t1 = microtime(true);
                // echo 't1'.round($t1,6).'秒</br>';
                $id = ($tds->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value'));
                $arrMemberData['id'][] = $id; //代號, id
                $arrMemberData[$id][] = $id; //代號, id
                $arrMemberData[$id][] = trim($tds->item(2)->nodeValue); //用户名, name
                $arrMemberData[$id][] = $tds->item(3)->nodeValue; //中文昵称名, nickName
                $arrMemberData[$id][] = $tds->item(4)->nodeValue; //真实姓名, trueName
                $arrMemberData[$id][] = $tds->item(5)->nodeValue; //代理, acting
                $arrMemberData[$id][] = $tds->item(6)->nodeValue; //总代, totalGeneration
                $arrMemberData[$id][] = $tds->item(7)->nodeValue; //股东, shareholders
                $arrMemberData[$id][] = $tds->item(8)->nodeValue; //大股东, majorShareholder
                $arrMemberData[$id][] = $tds->item(9)->getElementsByTagName("td")->item(0)->nodeValue;    //账户余额, accountBalance
                $arrMemberData[$id][] = trim($tds->item(97)->nodeValue);    //推广会员, promotionMember
                $arrMemberData[$id][] = trim($tds->item(98)->nodeValue);    //账号, account
                $arrMemberData[$id][] = trim($tds->item(99)->nodeValue);    //投注, betting
                $arrMemberData[$id][] = trim($tds->item(100)->nodeValue);   //资金状态, fundStatus
                $arrMemberData[$id][] = $tds->item(101)->nodeValue;   //审核, audit
                $arrMemberData[$id][] = $tds->item(102)->nodeValue;   //注册时间, registrationTime
                $arrMemberData[$id][] = $tds->item(103)->nodeValue;   //最近登录时间, lastLoginTime
                $arrMemberData[$id][] = $tds->item(104)->nodeValue;   //登录异常次数, numberOfAbnormalLogins
                $arrMemberData[$id][] = trim($tds->item(105)->nodeValue);   //登录, logOn
                // $t2 = microtime(true);
                // echo 't2'.round($t2,6).'秒</br></br>';
                // echo '耗时'.round($t2-$t1,5).'秒'.'</br>';
            }
        }
        return $arrMemberData;
    }
    
    public function getMemberData($rate, $bool, $pageNo, $pageSize){
        $client = new Client();

        //捞资料
        $response = $client->request('POST', 'https://arxntfea14.sharksu.com/agent/AccountServlet', [
            'headers' => [
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'zh-TW,zh-CN;q=0.9,zh;q=0.8,en-US;q=0.7,en;q=0.6,und;q=0.5,ja;q=0.4',
                'Cache-Control' => 'max-age=0',
                'Connection' => 'keep-alive',
                'Content-Length' => '219',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Cookie' => $this->cookie,
                'Host' => 'arxntfea14.sharksu.com',
                'Origin' => 'https://arxntfea14.sharksu.com',
                'Referer' => 'https://arxntfea14.sharksu.com/agent/AccountServlet',
                'sec-ch-ua' => '"Chromium";v="92", " Not A;Brand";v="99", "Google Chrome";v="92"',
                'sec-ch-ua-mobile' => '?0',
                'Sec-Fetch-Dest' => 'frame',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-User' => '?1',
                'Upgrade-Insecure-Requests' => '1',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36',
            ],
            'form_params' => [
                'order' => 'create_time',
                'type' => '1',
                'id' => '',
                'rate' => '5',
                // 'bool' => '5',
                'status' => '',
                // 'pageNo' => '1',
                // 'pageSize' => '20',
                'accountIds' => '',
                'startTime' => '',
                'endTime' => '',
                'memberType' => '0',
                'promotionStatus' => '',
                'moneyStatus' => '2',
                'betStatus' => '-1',
                'errorNum' => '8',
                'multiplekey' => '1',
                'queryType' => '1',
                'accounts' => '',
                // 'pageSize' => '20',
            ],
            'query' => [
                'rate' => $rate,
                'bool' => $bool,
                'pageNo' => $pageNo,
                'pageSize' => $pageSize,
            ]
        ]);
        
        return $response;
    }

    public function curlMemberData($rate, $bool, $pageNo, $pageSize){
        $curl = curl_init();
        //用proxy
        $proxy = "10.0.0.48:8001";
        curl_setopt($curl, CURLOPT_PROXY, $proxy);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://arxntfea14.sharksu.com/agent/AccountServlet?rate=' . $rate . '&bool=' . $bool . '&pageNo=' . $pageNo . '&pageSize=' . $pageSize,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Accept:  text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'Accept-Encoding:  gzip, deflate, br',
                'Accept-Language:  zh-TW,zh-CN;q=0.9,zh;q=0.8,en-US;q=0.7,en;q=0.6,und;q=0.5,ja;q=0.4',
                'Connection:  keep-alive',
                'Cookie:  ' . $this->cookie,
                'Host:  arxntfea14.sharksu.com',
                'Referer:  https://arxntfea14.sharksu.com/agent/agent',
                'sec-ch-ua:  "Chromium";v="92", " Not A;Brand";v="99", "Google Chrome";v="92"',
                'sec-ch-ua-mobile:  ?0',
                'Sec-Fetch-Dest:  frame',
                'Sec-Fetch-Mode:  navigate',
                'Sec-Fetch-Site:  same-origin',
                'Sec-Fetch-User:  ?1',
                'Upgrade-Insecure-Requests:  1',
                'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

}

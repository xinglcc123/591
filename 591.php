<?php
/*curl guzzle(PHP HTTP 请求套件) 兩個版本
位置 分類 名稱 租金 商品照(含內頁圖) 存進 DB
laravel專案 會員系統+產品架
後臺可以針對抓下來的這些資料做編輯
只有管理員可以進後台 會員只能登入前台
前台要能顯示那些資料 分頁 搜尋 都要有
產品架是兩層
分類+商品 圖片也要跟商品做關聯 統一使用restful api格式
資料抓一次性 手動下玩指令存DB
*/

new curl591Controller();

class curl591Controller
{
	function __construct() {
        $this->domData = new \DOMDocument();
		$this->curl591();
    }
	public function curl591()
	{
		echo $this->curlGet();
	}
	public function curlGet()
	{
		$curl = curl_init();

		$i = 0;
		$t3 = 0;
		do {
			$t1 = microtime(true);
			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://rent.591.com.tw/?kind=0&region=1&rentprice=0&pattern=0&area=0,0&shType=list',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'cache-control:  no-store, no-cache, must-revalidate',
				'cache-control:  no-cache, private',
				'content-encoding:  gzip',
				'content-type:  text/html; charset=UTF-8',
				'date:  Mon, 23 Aug 2021 06:55:31 GMT',
				'expires:  Thu, 19 Nov 1981 08:52:00 GMT',
				'pragma:  no-cache',
				'server:  openresty',
				'set-cookie:  new_rent_list_kind_test=0; expires=Mon, 30-Aug-2021 06:55:31 GMT; Max-Age=604800; path=/; domain=.591.com.tw',
				'set-cookie:  591_new_session=eyJpdiI6InQ0a3grT1RZWnBLbm5XYk5hYVpIdmc9PSIsInZhbHVlIjoiMEJBYWdvQ01RWXhUS0RXYVUyTEh0bkx3aHJyczNXNExSbGFjM2t1b2xsM0NyaTJLTGZrT01sbHhJVU8rdVRORFlpMGdybUJPOU9KWmszd0dHQlpocnc9PSIsIm1hYyI6IjYwOGRkNjIzZWNhY2QwMGYyOTI1NjY3NjliYjZhYjU2NDkzYTU5YjZhMDg0NDQ4MzFmYTkyYWQ3OWZjZTFhODMifQ%3D%3D; expires=Mon, 23-Aug-2021 08:55:31 GMT; Max-Age=7200; path=/; HttpOnly',
				'vary:  Accept-Encoding',
				'vary:  Accept-Encoding',
				'via:  1.1 2787299048b9e6595220467d6c4ce280.cloudfront.net (CloudFront)',
				'x-amz-cf-id:  nMgEtJvK4wX8syc7k-ygTEt1nDb7LJqoFFGNDngcuCWP3lHLdwsbiw==',
				'x-amz-cf-pop:  HKG60-C1',
				'x-cache:  Miss from cloudfront',
				'Cookie: PHPSESSID=jb2d1pt5buflu1g3ftpl6bbcq6; urlJumpIp=1; urlJumpIpByTxt=%E5%8F%B0%E5%8C%97%E5%B8%82; new_rent_list_kind_test=1; 591_new_session=eyJpdiI6IjRUaHl0ZGlDU0lBdXU5YktHcE1LOGc9PSIsInZhbHVlIjoiM3IwalRUMSt5ZldReWxDWFd2RHBaaVB2UzRaWU5KSXhmS1JtcVFuNUFKZTM3K1k0MTF5NG4xNW5NT1dIZGJONHp5Rk9Lc0FCbTFUd3BvVWRNd0lCaFE9PSIsIm1hYyI6ImUxMjdiZjcwNWE4MGVkYjE0Y2FiMzAxYWZmZWRkNDE3MjU5NDY4OTFhODZjMjUyY2Y3NjExM2YyZDQ4MjkxZGIifQ%3D%3D'
			),
			));
			$response = curl_exec($curl);
			@$this->domData->loadHTML($response);
			$size = $this->domData->getElementById("content")->getElementsByTagName("ul");
			echo count($size);
			$t2 = microtime(true);
			$t3 += round($t2 - $t1, 3);
			echo '頁數' . count($size) . '筆數' . count($size) . '耗時' . round($t2 - $t1, 3) . '秒，總耗時' . $t3 . PHP_EOL . '</br>';
		} while (count($size) == 30);

		curl_close($curl);
	}
}
class a14Controller
{
	public $cookie = 'urlColor=agent%2FAccountServlet%3Frate%3D5%26bool%3D5; unknown=B8D3ECBC75D770254FCFF5FCADBC2414; JSESSIONID=BC2F0DC366A7CD76F2AD370ABDB3EF41; route=bb65f59e2f8b004600b895e3f24d1be3';
	public $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36';
	public $domData;
	public function a14()
	{
		$this->domData = new \DOMDocument();
		$rate = 5;	//抓取類別
		$pageNo = 1;	//起始頁數1開始
		$pageSize = 55;	//每頁抓取會員數
		$moneySize = 10;	//每次查詢會員錢包人數
		$muchSize = 10;	//多線程數量

		//使用excel
		fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF)); //解決excel寫入亂碼
		
		if (true) {
			$t3 = 0;
			$tt3 = 0;
			$i = 0;
		}
		do {
			$t1 = microtime(true);
			//用curl
			$htmlData = $this->curlMemberData($rate, $pageNo + $i, $pageSize);
			//處理回傳的HTML
			$arrMemberData = $this->MemberData($htmlData);
			$arrId = $arrMemberData['id'];
			unset($arrMemberData['id']);
			//查詢會員餘額&會員詳細資料
			$i2 = 0;
			$i2count = count($arrId) / $moneySize;
			do {
				$tt1 = microtime(true);
				$quantityQuery = array_slice($arrId, $i2 * $moneySize, $moneySize);	//陣列, 每次起始位置, 每次查詢數量
				$arrMoneyAll = $this->getAmount2($quantityQuery, $muchSize);	//查詢會員餘額
				// $getMemberDataAll = $this->getMemberDataAll($quantityQuery);	//查詢會員詳細資料
				//放入會員陣列
				foreach ($quantityQuery as $value) {
					// $arrMemberData[$value] = array_merge($arrMemberData[$value], $arrMoneyAll[$value], $getMemberDataAll[$value]);	//寫入會員資料陣列
					// $arrMemberData[$value] = array_merge($arrMemberData[$value], $arrMoneyAll[$value]);	//寫入會員資料陣列
					// $arrMemberData[$value] = array_merge($arrMemberData[$value], $getMemberDataAll[$value]);	//寫入會員資料陣列
				}
				$tt2 = microtime(true);
				$tt3 += round($tt2 - $tt1, 3);
				echo '會員餘額' . $pageNo + $i2 . '筆數' . count($quantityQuery) . '耗時' . round($tt2 - $tt1, 3) . '秒，總耗時' . $tt3 . PHP_EOL . '</br>';
				$i2++;
				// } while (false);
			} while ($i2 < $i2count);	//檢查是否最後一組查詢
			//excel寫入會員資料
			foreach ($arrMemberData as $value) {
				// echo var_dump($arrMemberData) . PHP_EOL . '</br>';
				// exit;
				fputcsv($fp, $value);
			}
			$t2 = microtime(true);
			$t3 += round($t2 - $t1, 3);
			echo '會員' . $pageNo + $i . '筆數' . count($arrMemberData) . '耗時' . round($t2 - $t1, 3) . '秒，總耗時' . $t3 . PHP_EOL . '</br>';
			$i++;
		} while (false);
		// } while (count($arrMemberData) == $pageSize);	//檢查是否最後一頁

		exit;

		//用抓的
		// $getMemberData = $this->getMemberData($rate, $pageNo, $pageSize);
		// $htmlData = $getMemberData->getBody()->getContents();

		return view('index');
	}

	/*抓取會員詳細資料
    * $id 抓取的會員資料陣列
    */
	public function getMemberDataAll($id)
	{
		$curl = curl_init();
		//用proxy
		$proxy = "10.0.0.48:8001";
		curl_setopt($curl, CURLOPT_PROXY, $proxy);

		foreach ($id as $value) {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://arxntfea14.sharksu.com/agent/AccountServlet?doQueryMessageInfo=queryMessageInfo&rate=5&bool=5&id=' . $value . '&banktype=0&pageLog=/agent/AccountServlet?rate=5&bool=5',
				// CURLOPT_URL => 'https://arxntfea14.sharksu.com/agent/AccountServlet?doQueryMessageInfo=queryMessageInfo&rate=5&bool=5&id=11000286&banktype=0&pageLog=/agent/AccountServlet?rate=5&bool=5',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
					'Cookie:' . $this->cookie,
					'User-Agent:  ' . $this->userAgent
				),
			));

			$response = curl_exec($curl);
			$arrMemberDataAll[$value] = $this->MemberDataAll($response);
		}

		curl_close($curl);
		return $arrMemberDataAll;
	}

	/*整理會員詳細資料HTML資料轉為陣列
    * $htmlData 抓取的HTML資料
    */
	public function MemberDataAll($htmlData)
	{
		@$this->domData->loadHTML($htmlData);
		$dataTableTrs = $this->domData->getElementsByTagName("tbody")->item(1)->getElementsByTagName("tr"); //取所有會員詳細資料tr
		$dataTable2Trs = $this->domData->getElementsByTagName("tbody")->item(2)->getElementsByTagName("tr"); //取所有銀行tr
		$arrMemberData = [];
		$arrMemberData[] = $dataTableTrs->item(0)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//真实姓名
		$arrMemberData[] = $dataTableTrs->item(1)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//微信昵称
		$arrMemberData[] = $dataTableTrs->item(2)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//中文昵称
		$arrMemberData[] = $dataTableTrs->item(3)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//英文昵称
		$arrMemberData[] = $dataTableTrs->item(4)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//生日
		$arrMemberData[] = $dataTableTrs->item(5)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//国家
		$arrMemberData[] = $dataTableTrs->item(6)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//身份证号
		$arrMemberData[] = $dataTableTrs->item(7)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//护照号码
		$arrMemberData[] = $dataTableTrs->item(8)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//手机
		$arrMemberData[] = $dataTableTrs->item(9)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//微信
		$arrMemberData[] = $dataTableTrs->item(10)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//QQ
		$arrMemberData[] = $dataTableTrs->item(11)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//E-mail
		// $bankCard = array();
		// for ($i = 0; $i < $dataTableTrs->item(12)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value'); $i++) {   //卡的數量
		// 	$bankCard[$i][] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(1)->getAttribute('value');  //取款银行
		// 	$bankCard[$i][] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(1)->getElementsByTagName("select")->item(0)->getAttribute('initval');  //开户行省
		// 	$bankCard[$i][] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(2)->getElementsByTagName("select")->item(0)->getAttribute('initval');  //开户行市
		// 	$bankCard[$i][] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(3)->getElementsByTagName("input")->item(0)->getAttribute('value');  //其他市县
		// 	$bankCard[$i][] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(4)->getElementsByTagName("input")->item(0)->getAttribute('value');  //开户行
		// 	$bankCard[$i][] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(5)->getElementsByTagName("input")->item(0)->getAttribute('value');  //取款账号
		// 	$bankCard[$i][] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(6)->getElementsByTagName("input")->item(0)->getAttribute('value');  //默认银行卡
		// }
		// $arrMemberData[] = $bankCard;  //银行卡
		$arrMemberData[] = $dataTableTrs->item(13)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//支付宝
		$arrMemberData[] = $dataTableTrs->item(14)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//取款密码
		$arrMemberData[] = $dataTableTrs->item(15)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//登录密码
		$arrMemberData[] = $dataTableTrs->item(16)->getElementsByTagName("td")->item(0)->getElementsByTagName("textarea")->item(0)->nodeValue;	//备注
		$arrMemberData[] = $dataTableTrs->item(17)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//动态口令(操作人)

		$cardQuantity = $dataTableTrs->item(12)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value');	//卡的數量
		$arrMemberData[] = $cardQuantity;	//卡的數量
		for ($i = 1; $i <= $cardQuantity; $i++) {
			$arrMemberData[] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(0)->getElementsByTagName("input")->item(1)->getAttribute('value');	//取款银行
			$arrMemberData[] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(1)->getElementsByTagName("select")->item(0)->getAttribute('initval');	//开户行省
			$arrMemberData[] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(2)->getElementsByTagName("select")->item(0)->getAttribute('initval');	//开户行市
			$arrMemberData[] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(3)->getElementsByTagName("input")->item(0)->getAttribute('value');	//其他市县
			$arrMemberData[] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(4)->getElementsByTagName("input")->item(0)->getAttribute('value');	//开户行
			$arrMemberData[] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(5)->getElementsByTagName("input")->item(0)->getAttribute('value');	//取款账号
			$arrMemberData[] = $dataTable2Trs->item($i)->getElementsByTagName("td")->item(6)->getElementsByTagName("input")->item(0)->getAttribute('value');	//默认银行卡
		}
		// echo json_encode($arrMemberData) . PHP_EOL . '</br>';
		// exit;
		return $arrMemberData;
	}

	/*抓取會員所有餘額明細
    * $id 抓取的會員資料陣列
    */
	public function getAmount($id)
	{
		$curl = curl_init();
		//用proxy
		$proxy = "10.0.0.48:8001";
		curl_setopt($curl, CURLOPT_PROXY, $proxy);

		$arrMoneyAll = array();
		foreach ($id as $value) {
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://arxntfea14.sharksu.com/agent/getAccountMoney?account6=' . $value . '&apiKey=all&useApi=1',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_HTTPHEADER => array(
					'Cookie:' . $this->cookie,
					'User-Agent:  ' . $this->userAgent
				),
			));

			$response = json_decode(curl_exec($curl), true);
			// echo $value;
			// echo json_encode($response);
			// exit;
			//整理回傳值
			//陣列18
			$arrMoneyAll[$value][] = $response['success'];	//资金状态
			$arrMoneyAll[$value][] = $response['totalMoney'];	//总余额
			//陣列20
			$arrMoneyAll[$value][] = $response['money'];	//现金余额
			$arrMoneyAll[$value][] = $response['apiMoney']['cp'];	//传统彩票余额
			$arrMoneyAll[$value][] = $response['apiMoney']['bb'];	//BB余额
			$arrMoneyAll[$value][] = $response['apiMoney']['ag'];	//AG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['ibc'];	//沙巴体育余
			//陣列25
			$arrMoneyAll[$value][] = $response['apiMoney']['pt'];	//PT余额
			$arrMoneyAll[$value][] = $response['apiMoney']['mwg'];	//MWG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['lebo'];	//LEBO余额
			$arrMoneyAll[$value][] = $response['apiMoney']['ds'];	//DS余额
			$arrMoneyAll[$value][] = $response['apiMoney']['ab'];	//AB余额
			//陣列30
			$arrMoneyAll[$value][] = $response['apiMoney']['pp'];	//PP余额
			$arrMoneyAll[$value][] = $response['apiMoney']['cmd'];	//CMD余额
			$arrMoneyAll[$value][] = $response['apiMoney']['vg'];	//VG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['cq9'];	//CQ9余额
			$arrMoneyAll[$value][] = $response['apiMoney']['bc'];	//OG体育余额-
			//陣列35
			$arrMoneyAll[$value][] = $response['apiMoney']['bg'];	//BG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['jdb'];	//JDB余额
			$arrMoneyAll[$value][] = $response['apiMoney']['fg'];	//FG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['ky'];	//KY余额
			$arrMoneyAll[$value][] = $response['apiMoney']['sc'];	//性感百家乐余额
			//陣列40
			$arrMoneyAll[$value][] = $response['apiMoney']['bsp'];	//BSP余额
			$arrMoneyAll[$value][] = $response['apiMoney']['ebet'];	//EBET余额
			$arrMoneyAll[$value][] = $response['apiMoney']['sg'];	//SG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['pg'];	//PG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['mgp'];	//新MG余额
			//陣列45
			$arrMoneyAll[$value][] = $response['apiMoney']['th'];	//TY余额
			$arrMoneyAll[$value][] = $response['apiMoney']['ogp'];	//新OG余额
			$arrMoneyAll[$value][] = $response['apiMoney']['tn'];	//天能余额
		}

		curl_close($curl);
		// print_r($arrMoneyAll);
		// echo json_encode($arrMoneyAll);
		// exit;
		return $arrMoneyAll;
	}

	/*抓取會員所有餘額明細
    * $id 抓取的會員資料陣列
    */
	public function getAmount2($id, $muchSize)
	{

		$mh = curl_multi_init();
		$ch1arr = array();
		// 初始化异步多请求
		$mh = curl_multi_init();
		// foreach ($id as $value) {
		// 	// 初始化异步多请求
		// 	$ch1 = curl_init('https://arxntfea14.sharksu.com/agent/getAccountMoney?account6=' . $value . '&apiKey=all&useApi=1');
		// 	//用proxy
		// 	$proxy = "10.0.0.48:8001";
		// 	curl_setopt($ch1, CURLOPT_PROXY, $proxy);
		// 	curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
		// 		'Cookie:' . $this->cookie,
		// 		'User-Agent:  ' . $this->userAgent
		// 	));
		// 	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
		// 	// 添加前面的每个handle
		// 	curl_multi_add_handle($mh, $ch1);
		// 	$ch1arr[$value] = $ch1;
		// }
		$size = count($id) / 2;
		for ($i = 0; $i < $size; $i++) {
			$quantityQuery = array_slice($id, $i * 2, 2);	//陣列, 每次起始位置, 每次查詢數量
			echo json_encode($ch1arr) . PHP_EOL . '</br>';
			// 同样先初始化curl
			$ch1 = curl_init('https://arxntfea14.sharksu.com/agent/getAccountMoney?account6=' . $quantityQuery[0] . '&apiKey=all&useApi=1');
			$ch2 = curl_init('https://arxntfea14.sharksu.com/agent/getAccountMoney?account6=' . $quantityQuery[1] . '&apiKey=all&useApi=1');
			//用proxy
			$proxy1 = "10.0.0.48:8001";
			$proxy2 = "10.0.0.48:8002";
			curl_setopt($ch1, CURLOPT_PROXY, $proxy1);
			curl_setopt($ch2, CURLOPT_PROXY, $proxy2);
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
				'Cookie:' . $this->cookie,
				'User-Agent:  ' . $this->userAgent
			));
			curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
				'Cookie:' . $this->cookie,
				'User-Agent:  ' . $this->userAgent
			));
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
			// 添加前面的每个handle
			curl_multi_add_handle($mh, $ch1);
			curl_multi_add_handle($mh, $ch2);
			$ch1arr[$quantityQuery[0]] = $ch1;
			$ch1arr[$quantityQuery[1]] = $ch2;
		}
		// echo json_encode($ch1arr);
		// exit;

		// 执行请求
		$active = null;
		do {
			$status = curl_multi_exec($mh, $active);
		} while ($status === CURLM_CALL_MULTI_PERFORM);
		while ($active && $status == CURLM_OK) {
			if (curl_multi_select($mh) === -1) {
				usleep(1000);
			}
			do {
				$status = curl_multi_exec($mh, $active);
			} while ($status === CURLM_CALL_MULTI_PERFORM);
		}

		// 如果需要返回结果
		foreach ($ch1arr as $key => $value) {
			$res[$key] = json_decode(curl_multi_getcontent($value), true);
		}

		// 移除handle
		curl_multi_remove_handle($mh, $ch1);

		// 关闭
		curl_multi_close($mh);

		//整理回傳值
		$arrMoneyAll = array();
		//整理回傳值
		foreach ($res as $key => $value) {
			//陣列18
			$arrMoneyAll[$key][] = $value['success'];	//资金状态
			$arrMoneyAll[$key][] = $value['totalMoney'];	//总余额
			//陣列20
			$arrMoneyAll[$key][] = $value['money'];	//现金余额
			$arrMoneyAll[$key][] = $value['apiMoney']['cp'];	//传统彩票余额
			$arrMoneyAll[$key][] = $value['apiMoney']['bb'];	//BB余额
			$arrMoneyAll[$key][] = $value['apiMoney']['ag'];	//AG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['ibc'];	//沙巴体育余
			//陣列25
			$arrMoneyAll[$key][] = $value['apiMoney']['pt'];	//PT余额
			$arrMoneyAll[$key][] = $value['apiMoney']['mwg'];	//MWG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['lebo'];	//LEBO余额
			$arrMoneyAll[$key][] = $value['apiMoney']['ds'];	//DS余额
			$arrMoneyAll[$key][] = $value['apiMoney']['ab'];	//AB余额
			//陣列30
			$arrMoneyAll[$key][] = $value['apiMoney']['pp'];	//PP余额
			$arrMoneyAll[$key][] = $value['apiMoney']['cmd'];	//CMD余额
			$arrMoneyAll[$key][] = $value['apiMoney']['vg'];	//VG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['cq9'];	//CQ9余额
			$arrMoneyAll[$key][] = $value['apiMoney']['bc'];	//OG体育余额-
			//陣列35
			$arrMoneyAll[$key][] = $value['apiMoney']['bg'];	//BG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['jdb'];	//JDB余额
			$arrMoneyAll[$key][] = $value['apiMoney']['fg'];	//FG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['ky'];	//KY余额
			$arrMoneyAll[$key][] = $value['apiMoney']['sc'];	//性感百家乐余额
			//陣列40
			$arrMoneyAll[$key][] = $value['apiMoney']['bsp'];	//BSP余额
			$arrMoneyAll[$key][] = $value['apiMoney']['ebet'];	//EBET余额
			$arrMoneyAll[$key][] = $value['apiMoney']['sg'];	//SG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['pg'];	//PG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['mgp'];	//新MG余额
			//陣列45
			$arrMoneyAll[$key][] = $value['apiMoney']['th'];	//TY余额
			$arrMoneyAll[$key][] = $value['apiMoney']['ogp'];	//新OG余额
			$arrMoneyAll[$key][] = $value['apiMoney']['tn'];	//天能余额
		}
		// echo json_encode($arrMoneyAll);
		// exit;
		return $arrMoneyAll;
	}

	/**
	 * 匯入Excel資料表格
	 * @param  string  $fp2       打開的excel檔
	 * @param  int     $line      讀取幾行，預設全部讀取
	 * @param  int     $offset    從第幾行開始讀，預設從第一行讀取
	 * @return bool|array
	 */
	public function importCsv($fp2, $line, $offset)
	{
		//set_time_limit(0);//防止超時
		//ini_set("memory_limit", "512M");//防止記憶體溢位

		// $handle = fopen($fileName, 'r');
		if (!$fp2) {
			return  '檔案開啟失敗';
		}

		$i = 0;
		$j = 0;
		$arr = [];
		while ($data = fgetcsv($fp2)) {
			//小於偏移量則不讀取,但$i仍然需要自增
			if ($i < $offset && $offset) {
				$i++;
				continue;
			}
			//大於讀取行數則退出
			if ($i > $line && $line) {
				break;
			}


			foreach ($data as $key => $value) {
				$content = ($value); //轉化編碼

				$arr[$j][] = $content;
			}
			$i++;
			$j++;
		}
		// print_r($arr);
		// fclose($handle);
		return $arr;
	}

	/**
	 * 匯出Excel檔案 速度慢
	 * @param $fileName 匯出的檔名
	 * @param $headArr 資料頭
	 * @param $data 匯出資料
	 */
	public function getExcel($fileName, $headArr, $data)
	{
		//設定PHP最大單執行緒的獨立記憶體使用量
		ini_set('memory_limit', '1024M');
		//程式超時設定設為不限時
		ini_set('max_execution_time ', '0');

		//匯入PHPExcel類庫，因為PHPExcel沒有用名稱空間，所以使用vendor匯入
		vendor("PHPExcel.PHPExcel.IOFactory");
		vendor("Excel.PHPExcel");
		vendor("Excel.PHPExcel.Writer.Excel5");
		vendor("Excel.PHPExcel.IOFactory.php");

		//對資料進行檢驗
		if (empty($data) || !is_array($data)) {
			die("data must be a array");
		}
		//檢查檔名
		if (empty($fileName)) {
			exit;
		}
		$date = date("Y_m_d", time());
		$fileName .= "_{$date}.xls";
		//建立PHPExcel物件
		$objPHPExcel = new \PHPExcel();

		//設定表頭
		$key = ord("A");
		foreach ($headArr as $hkey => $v) {
			$colum = chr($key);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
			$key += 1;
			unset($headArr[$hkey]);
		}
		$column = 2;
		$objActSheet = $objPHPExcel->getActiveSheet();
		foreach ($data as $key => $rows) { //行寫入
			$span = ord("A");
			foreach ($rows as $keyName => $value) { // 列寫入
				$j = chr($span);
				//設定匯出單元格格式為文字，避免身份證號的資料被Excel改寫
				$objActSheet->setCellValueExplicit($j . $column, $value);
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
		header('Content-Type: application/vnd.ms-excel'); //定義輸出的檔案型別為excel檔案
		header("Content-Disposition: attachment;filename=\"$fileName\""); //定義輸出的檔名
		header('Cache-Control: max-age=0'); //強制每次請求直接傳送給源伺服器，而不經過本地快取版本的校驗。
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output'); //檔案通過瀏覽器下載
		exit;
	}

	/*整理會員資料HTML資料轉為陣列
    * $htmlData 抓取的HTML資料
    */
	public function MemberData($htmlData)
	{
		// $domData = new \DOMDocument();
		@$this->domData->loadHTML($htmlData);
		$arrMemberData = array();
		$trs = $this->domData->getElementsByTagName("tr");
		$size = count($trs) - 1;
		for ($i = 1; $i < $size; $i += 5) {	//會員資料在5*n+1的位置
			$tds = $trs->item($i)->getElementsByTagName("td");	//取所有tr
			$id = ($tds->item(0)->getElementsByTagName("input")->item(0)->getAttribute('value'));
			$arrMemberData['id'][] = $id;	//代號, id, 搜尋會員詳細資料&詳細餘額
			//陣列0
			$arrMemberData[$id][] = $id;	//代號, id
			$arrMemberData[$id][] = trim($tds->item(2)->nodeValue);	//用户名, name
			$arrMemberData[$id][] = $tds->item(3)->nodeValue;	//中文昵称名, nickName
			$arrMemberData[$id][] = $tds->item(4)->nodeValue;	//真实姓名, trueName
			$arrMemberData[$id][] = $tds->item(5)->nodeValue;	//代理, acting
			//陣列5
			$arrMemberData[$id][] = $tds->item(6)->nodeValue;	//总代, totalGeneration
			$arrMemberData[$id][] = $tds->item(7)->nodeValue;	//股东, shareholders
			$arrMemberData[$id][] = $tds->item(8)->nodeValue;	//大股东, majorShareholder
			$arrMemberData[$id][] = $tds->item(9)->getElementsByTagName("td")->item(0)->nodeValue;	//账户余额, accountBalance
			$arrMemberData[$id][] = trim($tds->item(97)->nodeValue);	//推广会员, promotionMember
			//陣列10
			$arrMemberData[$id][] = trim($tds->item(98)->nodeValue);	//账号, account
			$arrMemberData[$id][] = trim($tds->item(99)->nodeValue);	//投注, betting
			$arrMemberData[$id][] = trim($tds->item(100)->nodeValue);	//资金状态, fundStatus
			$arrMemberData[$id][] = $tds->item(101)->nodeValue;	//审核, audit
			$arrMemberData[$id][] = $tds->item(102)->nodeValue;	//注册时间, registrationTime
			//陣列15
			$arrMemberData[$id][] = $tds->item(103)->nodeValue;	//最近登录时间, lastLoginTime
			$arrMemberData[$id][] = $tds->item(104)->nodeValue;	//登录异常次数, numberOfAbnormalLogins
			$arrMemberData[$id][] = trim($tds->item(105)->nodeValue);	//登录, logOn
		}
		return $arrMemberData;
	}

	/*curl抓取會員資料，回傳HTML資料
    * $rate 抓取類別
    * $pageNo 起始頁數1開始
    * $pageSize 每次抓取會員數
    */
	public function curlMemberData($rate, $pageNo, $pageSize)
	{
		$curl = curl_init();
		//用proxy
		$proxy = "10.0.0.48:8001";
		curl_setopt($curl, CURLOPT_PROXY, $proxy);

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://arxntfea14.sharksu.com/agent/AccountServlet?rate=' . $rate . '&pageNo=' . $pageNo . '&pageSize=' . $pageSize,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => array(
				'Cookie:  ' . $this->cookie,
				'User-Agent:  ' . $this->userAgent
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	/*抓取會員資料，回傳HTML資料
    * $rate 抓取類別
    * $pageNo 起始頁數1開始
    * $pageSize 每次抓取會員數
    */
	public function getMemberData($rate, $pageNo, $pageSize)
	{
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
				'User-Agent' => $this->userAgent,
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

	public function sql()
	{

		//SQL
		// $con = mysqli_connect('127.0.0.1', 'root', '', 'a14');

		// // Check connection
		// if (mysqli_connect_errno())
		// {
		// echo "Failed to connect to MySQL: " . mysqli_connect_error();
		// }

		// $sql="SELECT * FROM tmp_a14_account";

		// var_dump($sql);

		// exit();

		// if ($result=mysqli_query($con,$sql))
		// {
		// // Seek to row number 15
		// mysqli_data_seek($result,14);

		// // Fetch row
		// $row=mysqli_fetch_row($result);

		// printf ("Lastname: %s Age: %s\n", $row[0], $row[1]);

		// // Free result set
		// mysqli_free_result($result);
		// }

		// mysqli_close($con);

		// exit;
	}
}

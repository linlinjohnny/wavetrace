<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;


class MyLibrary {

	public function __construct() {
		$this->CI = &get_instance();
	}

	public function refreshSession($user=array()) {
		unset($user['password']);
		unset($user['ip']);
		unset($user['createTime']);
		unset($user['loginTime']);
		unset($user['updateTime']);

		$this->CI->session->set_userdata('user', $user);
		$this->CI->user = $this->CI->session->userdata('user');
	}

	public function authUrl($url) {
		$url = str_replace("+", "%2B", $url);

		$auth = md5(($url . $this->CI->input->cookie('ci_session', TRUE)));

		$this->CI->session->set_userdata($auth, TRUE);


		return "{$url}&auth={$auth}";
	}

	public function isAuthUrl() {
		$currentUrl = current_full_url();

		$temp = explode('&auth=', $currentUrl);

		$auth = md5(($temp[0] . $this->CI->input->cookie('ci_session', TRUE)));

		if ( $this->CI->session->userdata($auth) && ($auth == $this->CI->input->get('auth', TRUE)) ) {
			return TRUE;
		}


		return FALSE;
	}

	public function serviceReturn($status, $msg='', $data=array()) {
		$statusStr = ( $status ) ? 'true' : 'false';

		$result = array('status' => $statusStr, 'msg' => $msg, 'data' => $data);

		return json_encode($result);
	}

	private $sysconfigs = array();
	public function getAllSysconfigs() {
		if ( $this->sysconfigs ) {
			return $this->sysconfigs;
		}

        $query = $this->CI->db->query("SELECT * FROM sysconfig");
        $query = $query->result_array();

        $result = array();
        foreach ( $query as $q ) {
            $result[ $q['name'] ] = $q;
        }
        $this->sysconfigs = $result;


        return $this->sysconfigs;
    }

    public function updateSysconfig($name, $param) {
        $this->CI->db->update('sysconfig', $param, array('name' => $name)); // table, param, where
    }

	public function isPC() {
		$iphone        = strstr($_SERVER['HTTP_USER_AGENT'], "iPhone");
		$ipad          = strstr($_SERVER['HTTP_USER_AGENT'], "iPad");
		$android       = strstr($_SERVER['HTTP_USER_AGENT'], "Android");
		$windows_phone = strstr($_SERVER['HTTP_USER_AGENT'], "Windows Phone");
		$black_berry   = strstr($_SERVER['HTTP_USER_AGENT'], "BlackBerry");

		$isPC = ( $iphone || $ipad || $android || $windows_phone || $black_berry ) ? FALSE : TRUE;


		return $isPC;
	}

	public function filelog($text) {
		$caller = array_shift(debug_backtrace());

		$info = "file: {$caller['file']} line: {$caller['line']}";

		if (is_array($text) || is_object($text)) $text = print_r($text, TRUE);
        $fp = fopen( "log.txt", "a");
        fwrite($fp, "[{$info}] " . date("Y-m-d H:i:s") . ":\n {$text}\n");
        fclose($fp);
    }

	public function print_var($data, $title="") {
		$caller = array_shift(debug_backtrace());

		$info = "file: {$caller['file']} line: {$caller['line']} ";

        echo <<<DIV
		<div style='text-align:left; margin:10px; border:1px solid #f00; padding:5px; background:#ffc; z-index:99999; position:relative;'>
			<i>{$info}</i><BR /><b>$title</b>
DIV;
            echo "<pre>";
                print_r($data);
            echo "</pre>";
        echo "</div>";
    }

	public function htmlChars($str, $flag=ENT_QUOTES) {
		return htmlspecialchars($str, $flag);
	}

	/**
		$sqlParam = array(
			'query' => array(
				'sql'   => "SELECT * FROM product WHERE complete=? AND publish=? ORDER BY id DESC",
				'param' => array($this->myconstant->get('COMPLETE'), $this->myconstant->get('PUBLISH'))
			),
			'page'  => 1,
			'size'  => 8
		);

		return array('totalPage', 'currPage', 'totalRows', 'items').
	**/
	public function getByPage($param) {
		$page   = (isset($param["page"])) ? $param['page'] : 1;
        $size   = (isset($param['size'])) ? $param['size'] : 20;

        $sql = trim($param['query']["sql"]);

        $records = $this->CI->db->query($sql, $param['query']['param']);
		$records = $records->result_array();
		$totalRows = count($records);
		$totalPage = ceil($totalRows / $param['size']);

        $start = ($page - 1) * $size;
        $limit = ($size != 'all') ? "LIMIT {$start}, {$size}" : "";

        $sql = $sql . " {$limit}";
	    $records = $this->CI->db->query($sql, $param['query']['param']);
		$records = $records->result_array();


		$result = array();
	    $result['currPage'] = $page; // current page num
	    $result['totalRows'] = $totalRows;
	    $result['totalPage'] = $totalPage;
	    $result['items'] = array();
		foreach ( $records as $item ) {
			if ( $item['id'] ) {
				$result['items'][ $item['id'] ] = $item;
			} else {
				$result['items'][] = $item;
			}
		}


        return $result;
	}

	public function getPager($config) {
		$this->CI->load->library('pagination');


		$default = array(
			'base_url' 			=> '',
			'total_rows' 		=> 0,
			'per_page' 			=> 20,
			'page_query_string' => TRUE,
			'use_page_numbers'  => TRUE,
			'first_link' 		=> FALSE,
			'last_link'		 	=> FALSE,
			'num_links'		 	=> 4,
			'num_tag_open' 	 	=> "<span class='num'>",
			'num_tag_close'	 	=> "</span>",
			'cur_tag_open'	 	=> "<span class='curr'>",
			'cur_tag_close'	 	=> "</span>",
			'prev_tag_open'	 	=> "<span class='prev'>",
			'prev_tag_close'	=> "</span>",
			'next_tag_open'	 	=> "<span class='next'>",
			'next_tag_close'	=> "</span>"
		);
		$config = array_merge($default, $config);

		$this->CI->pagination->initialize($config);


		return $this->CI->pagination->create_links();
	}

	public function isAdmin() {
		return ( $this->CI->user['account'] == 'admin@admin.com' ) ? TRUE : FALSE;
	}

	public function filterParamString($str) {
		$str = str_replace("'", '', $str);
		$str = str_replace('"', '', $str);

		return $str;
	}

	public function sendEmail($to, $subject, $message) {
		if ( !$to || !$subject || !$message ) {
			return;
		}

		$message .= $this->CI->lang->line('emailFooter');

		require_once('PHPMailer/class.phpmailer.php');

		$mail = new PHPMailer();
		$mail->CharSet = "UTF-8";
		$mail->IsSMTP();
		$mail->SMTPAuth = TRUE;

		$mail->Username  = "info@recluse-official.com";
		$mail->Password  = "recluse2016";
		$mail->FromName  = $this->CI->lang->line('webName');

		$mail->From = $mail->Username;
		$mail->AddAddress($to, $to);
		$mail->AddReplyTo($mail->Username, $mail->FromName);
		$mail->WordWrap = 76;

		$mail->IsHTML(TRUE);
		$mail->Subject = $subject;
		$webLogo = "<div><img style='margin-bottom:15px; width:170px; height:17px;' src='{$this->CI->baseUrl}assets/imgs/email_logo.png' /></div>";
		$mail->Body = $webLogo . $message;

		if( !$mail->Send() ) {
			$this->filelog("Send email error:" . $mail->ErrorInfo);
		}


		$param = array( 'to' => $to,
						'subject' => $subject,
						'message' => $message,
						'createTime' => date("Y-m-d H:i:s") );
		$this->CI->db->insert( "email_record", $param );
	}

	public function reorderSN($table, $sqlCmd='', $sqlParam=array()) {
		$where = ( !$sqlCmd ) ? '' : "WHERE {$sqlCmd}";

		$sql = <<<SQL
            UPDATE {$table} as F,
            (SELECT id, (@rownum := @rownum + 10) as rownum
                FROM {$table}, (SELECT @rownum :=0) as R
                {$where} ORDER BY sn ASC) as T
            SET F.sn = T.rownum
            WHERE F.id=T.id
SQL;
		$this->CI->db->query($sql, $sqlParam);
	}

	/**
		return a array('status' => 'true', 'msg' => '')
	**/
	public function uploadImage($filePath, $fileName, $originFileName) {
		if ( !$filePath || !$fileName || !$originFileName ) {
			return array('status' => FALSE, 'msg' => 'no param');
		}

		$lastChar = substr($filePath, -1);
		if ( $lastChar != '/' ) {
			$filePath = $filePath . '/';
		}

		$this->mkdir(FCPATH . $filePath);

		$result = array();

		$fileKeys = array_keys($_FILES);
		$key = $fileKeys[0];
		$pathInfo = pathinfo($_FILES[$key]['name']);
		$msg = "";
		if( !empty($_FILES[$key]['error']) ) {
			switch( $_FILES[$key]['error'] ) {
				case '1':
					$msg = $this->lang->line('imageSizeExced'); // exced php.ini
				break;

				case '2':
					$msg = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;

				case '3':
					$msg = 'The uploaded file was only partially uploaded';
				break;

				case '4':
					$msg = 'No file was uploaded.';
				break;

				case '6':
					$msg = 'Missing a temporary folder';
				break;

				case '7':
					$msg = 'Failed to write file to disk';
				break;

				case '8':
					$msg = 'File upload stopped by extension';
				break;

				case '999':
				default:
					$msg = 'No error code avaiable';
				break;
			}

			return array('status' => FALSE, 'msg' => $msg);
		}

		if ( empty($_FILES[$key]['tmp_name']) || $_FILES[$key]['tmp_name'] == 'none' ) {
			$msg = 'No file was uploaded..';

			return array('status' => FALSE, 'msg' => $msg);
		}

		$filesize = @filesize($_FILES[$key]['tmp_name']);
		$filetype = $_FILES[$key]['type'];
		if ( !preg_match("/image\\/(gif|png|jpg|jpeg|bmp)/", $filetype) ) {
			return array('status' => FALSE, 'msg' => $this->CI->lang->line('imageTypeLimit'));
		}
		if ( $filesize > MAX_UPLOAD_SIZE ) {
			return array('status' => FALSE, 'msg' => $this->CI->lang->line('imageSizeExced'));
		}


		$path = FCPATH . $filePath;
		$finalPath = "{$path}{$fileName}.png";

		@unlink("{$path}{$originFileName}.png");

		move_uploaded_file($_FILES[$key]['tmp_name'], $finalPath);
		@unlink($_FILES[$key]); // delete temp file


		$msg = "{$_FILES[$key]['name']}, {$filesize}";


		return array('status' => TRUE, 'msg' => $msg);
	}

	public function deleteImage($filePath, $fileName) {
		$lastChar = substr($filePath, -1);
		if ( $lastChar != '/' ) {
			$filePath = $filePath . '/';
		}

		$realPath = FCPATH . $filePath;

		@unlink("{$realPath}{$fileName}.png");
		@unlink("{$realPath}{$fileName}_s.png");
		@unlink("{$realPath}{$fileName}_m.png");
		@unlink("{$realPath}{$fileName}_l.png");
	}

	public function resizeImage($src, $dest, $maxWidth=128, $maxHeight=128, $quality=100, $bgcolor="#ffffff") {
		if ( !file_exists($src) ) {
			return FALSE;
		}
        if ( !$dest ) {
        	return FALSE;
        }


        $src  = preg_replace("/\\.\.\/|\.\//", "", $src);
        $dest = preg_replace("/\\.\.\/|\.\//", "", $dest);


		$imagickObj = new Imagick($src);
		$imagickObj->setGravity(imagick::GRAVITY_CENTER);
		$imagickObj->setImageBackgroundColor('#000');
		$imagickObj->setCompressionQuality($quality);
		$imagickObj->thumbnailImage(intval($maxWidth), intval($maxHeight), TRUE, TRUE);

		$imagickObj->writeImage($dest);
    }

	public function nf_to_wf($str, $type) {
		$nft = array(
			"(", ")", "[", "]", "{", "}", ".", ",", ";", ":",
			"-", "?", "!", "@", "#", "$", "%", "&", "|", "\\",
			"/", "+", "=", "*", "~", "`", "'", "\"", "<", ">",
			"^", "_",
			"0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j",
			"k", "l", "m", "n", "o", "p", "q", "r", "s", "t",
			"u", "v", "w", "x", "y", "z",
			"A", "B", "C", "D", "E", "F", "G", "H", "I", "J",
			"K", "L", "M", "N", "O", "P", "Q", "R", "S", "T",
			"U", "V", "W", "X", "Y", "Z",
			" "
		);

		$wft = array(
			"（", "）", "〔", "〕", "｛", "｝", "﹒", "，", "；", "：",
			"－", "？", "！", "＠", "＃", "＄", "％", "＆", "｜", "＼",
			"／", "＋", "＝", "＊", "～", "、", "、", "＂", "＜", "＞",
			"︿", "＿",
			"０", "１", "２", "３", "４", "５", "６", "７", "８", "９",
			"ａ", "ｂ", "ｃ", "ｄ", "ｅ", "ｆ", "ｇ", "ｈ", "ｉ", "ｊ",
			"ｋ", "ｌ", "ｍ", "ｎ", "ｏ", "ｐ", "ｑ", "ｒ", "ｓ", "ｔ",
			"ｕ", "ｖ", "ｗ", "ｘ", "ｙ", "ｚ",
			"Ａ", "Ｂ", "Ｃ", "Ｄ", "Ｅ", "Ｆ", "Ｇ", "Ｈ", "Ｉ", "Ｊ",
			"Ｋ", "Ｌ", "Ｍ", "Ｎ", "Ｏ", "Ｐ", "Ｑ", "Ｒ", "Ｓ", "Ｔ",
			"Ｕ", "Ｖ", "Ｗ", "Ｘ", "Ｙ", "Ｚ",
			"　"
		);

		$strtmp = '';
		if ( $type == 1 ) {
			$strtmp = str_replace($nft, $wft, $str); // turn full
		} else {
			$strtmp = str_replace($wft, $nft, $str); // turn part
		}


		return $strtmp;
	}

	public function timeDiff($lastTime, $firstTime) {
        $firstTime  = strtotime($firstTime);

        $lastTime   = strtotime($lastTime);
        $timeDiff   = $lastTime - $firstTime;

        return $timeDiff;
    }

	public function timeSpan($date) {
		$date  = str_replace("-", "/", $date);
		$limit = $this->timeDiff(date('Y/m/d H:i:s'), $date);

		if ($limit < 60)						return "{$limit} " . $this->CI->lang->line('secondBefore');
		if ($limit >= 60	&& $limit < 3600)	return floor($limit/60) . " " . $this->CI->lang->line('minuteBefore');
		if ($limit >= 3600	&& $limit < 86400)	return floor($limit/3600) . " " . $this->CI->lang->line('hourBefore');
		if ($limit >= 86400	&& $limit < 604800) return  floor($limit/86400) . " " . $this->CI->lang->line('dayBefore');

		return $this->dateFormat($date);
	}

    public function dateFormat($date, $format='Y-m-d') {
		return ( strtotime($date)==0 ) ? '' : date_format(date_create($date), $format);
	}

	public function mkdir($path)	{
		if (!is_dir($path)) @mkdir($path, 0777, TRUE);
	}

	public function deleteDir($path){
		if ( !$path || !is_dir($path) ) {
			return;
		}


	    if ( substr($path, (strlen($path) - 1), 1) != '/' ) {
	        $path .= '/';
	    }
	    $files = glob($path . '*', GLOB_MARK);
	    foreach ( $files as $file ) {
	        if ( is_dir($file) ) {
	            $this->deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($path);
	}

	public function checkAccount($account) {
		return preg_match("/^[a-zA-Z0-9][a-zA-Z0-9.\@\_\-]+$/", $account);
	}

    public function checkEmail($email='') {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function checkTimeFormat($time) {
    	return preg_match('/([0-9]*-[0-9]*-[0-9]*)/', $time);
    }

    public function checkYoutube($url) {
    	$headers = get_headers("https://www.youtube.com/oembed?format=json&url={$url}");

    	return ( $headers[0] == "HTTP/1.0 404 Not Found" ) ? FALSE : TRUE;
    }

	public function reDirect($url) {
		if (!$url) exit;

		if (!headers_sent()) {
			header('Content-Type:text/html; charset=utf-8');
			header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: no-cache');
			header("Location: {$url}");
		} else {
			echo <<<JS
			<script type="text/javascript">
				window.location.href='{$url}';
			</script>
			<noscript>
				<meta http-equiv="refresh" content="0;url='{$url}'" />
			</noscript>
JS;
		}

		exit(0);
	}

	public static function request($url, $post=array(), $param=array()){
		$ch = @ curl_init($url);

		$default = array(
			CURLOPT_SSL_VERIFYPEER  => 0,
			CURLOPT_SSL_VERIFYHOST  => 0,
			CURLOPT_FOLLOWLOCATION	=> 1,
			CURLOPT_RETURNTRANSFER	=> 1,
			CURLOPT_TIMEOUT			=> 15
		);

		if (count($post)>0) {
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		}

		$param += $default;
		foreach ($param as $idx=>$val) @ curl_setopt($ch, $idx, $val);

		return @ curl_exec($ch);
	}


	public function paypal($items=array(), $config=array()){

        require_once(FCPATH."application/libraries/paypal/autoload.php");

        $payer = new Payer();
		$payer->setPaymentMethod("paypal");
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AeAz_bdQPPViXsaiKC_Rt3ayH6h5_hJDydndqji8-dXF2KEY-RMyHjgagS322oQwd0sw-X7c7k2bPw3r',     // ClientID
                'EPe2DW2Pp94b8iLh8Q6kMVscK9i-JKIPaqqe486hwwEvRvTjWZzrJrgfsJGcoOEFGfWMPHsnW_wQqK3d'      // ClientSecret
            )
        );

        $apiContext->setConfig(array('mode' => 'sandbox'));

        $itemsObj = array();

        foreach ($items as $k => $v) {
            $tempItem = new Item();
            $tempItem->setName($v['name'])
            ->setCurrency('USD')
            ->setQuantity($v['quantity'])
            ->setSku($v['code']) // Similar to `item_number` in Classic API
            ->setPrice($v['price']);

            $itemsObj[] = $tempItem;
        }

        $tempItem = new Item();
        $tempItem->setName('discount')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku('discount') // Similar to `item_number` in Classic API
            ->setPrice("-{$config['discountPrice']}.00");
        $itemsObj[] = $tempItem;

        $tempItemShipping = new Item();
        $tempItemShipping->setName('shipping')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku('shipping') // Similar to `item_number` in Classic API
            ->setPrice($config['shippingPrice']);
        $itemsObj[] = $tempItemShipping;

        $itemList = new ItemList();
        $itemList->setItems($itemsObj);




        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($config['total']);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $baseUrl = $this->CI->baseUrl;
        $redirectUrls = new RedirectUrls();

        $successUrl = $this->authUrl("{$this->CI->baseUrl}shop/orderCheckout?order_no=".$config['tradeNo'].'&type=success');
        $redirectUrls->setReturnUrl($successUrl)
            ->setCancelUrl($baseUrl);

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $request = clone $payment;

        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {

$this->print_var($ex->getMessage());
        }


        $approvalUrl = $payment->getApprovalLink();

        header("Location:{$approvalUrl}");
    }

}

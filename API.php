<?php 

class Pay_API {
	private $session,$token;
	const API = 'https://api.nowpayments.io/v1/';
	function __construct(string $token) {
		if(empty($token)) {
			throw new Exception('API key is not specified');
		} else {
			$this->token = $token;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		$this->session = $ch;
	}
	private function data($method, $endpoint, $data = []) {
		$ch = $this->session;
		switch ($method) {
			case 'GET':
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-API-KEY: '.$this->token]);
				if(!empty($data)) {
					if(is_array($data)) {
						$parameters = http_build_query($data);
						curl_setopt($ch, CURLOPT_URL, self::API.$endpoint.'?'.$parameters);
					} else {
						if($endpoint == 'payment') curl_setopt($ch,CURLOPT_URL, self::API.$endpoint.'/'.$data);
					}} else {
					curl_setopt($ch, CURLOPT_URL, self::API_BASE.$endpoint);
				}
				break;
			case 'POST':
				$data = json_encode($data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-API-KEY: '.$this->token, 'Content-Type: application/json']);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_URL, self::API.$endpoint);
				break;
			default:
				break;
		}
		$response = curl_exec($ch);
		return $response;
	}
	public function status() {
		return $this->data('GET', 'status');
	}
	public function getCurrencies() {
		return $this->data('GET', 'currencies');
	}
	public function getEstimatePrice(array $params) {
		return $this->data('GET', 'estimate', $params);
	}
	public function createPayment(array $params) {
		return $this->data('POST', 'payment', $params);
	}
	public function lolPayment(array $params) {
		return $this->data('POST', 'lol_payment', $params);
        }
	public function getPaymentStatus(int $paymentID) {
		return $this->data('GET', 'payment', $paymentID);
	}
	public function getMinimumPaymentAmount(array $params) {
		return $this->data('GET', 'min-amount', $params);
	}
	public function getListPayments(array $params = []) {
		return $this->data('GET', 'payment', $params);
	}
	public function createInvoice(array $params) {
		return $this->data('POST', 'invoice', $params);
	}
	function __destruct() {
		curl_close($this->session);
	}
}

 ?>

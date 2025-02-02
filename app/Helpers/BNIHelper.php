<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Library Access BNI API_V3.0.3
 */
class BniHelper {

	private $url;
    private $secret_key;
    private $client_id;
    private $TIME_DIFF_LIMIT;

	function __construct()
	{
		// $this->url = "http://103.109.210.37/api/v1/localva";//env('BNI_URL');
		// $this->url = "https://apibeta.bni-ecollection.com/";
		$this->secret_key = env('BNI_SECRET_KEY');
		$this->client_id = env('BNI_CLIENT_ID');
		$this->TIME_DIFF_LIMIT = 480;
	}

	public function encrypt(array $json_data) {
		return $this->doubleEncrypt(strrev(time()) . '.' . json_encode($json_data));
	}

	public function decrypt($hased_string) {
		$parsed_string = $this->doubleDecrypt($hased_string);
		list($timestamp, $data) = array_pad(explode('.', $parsed_string, 2), 2, null);
		if ($this->tsDiff(strrev($timestamp)) === true) {
			return json_decode($data, true);
		}
		return null;
	}

	private function tsDiff($ts) {
		return abs($ts - time()) <= $this->TIME_DIFF_LIMIT;
	}

	private function doubleEncrypt($string) {
		$result = '';
		$result = $this->enc($string, $this->client_id);
		$result = $this->enc($result, $this->secret_key);
		return strtr(rtrim(base64_encode($result), '='), '+/', '-_');
	}

	private function enc($string, $key) {
		$result = '';
		$strls = strlen($string);
		$strlk = strlen($key);
		for($i = 0; $i < $strls; $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % $strlk) - 1, 1);
			$char = chr((ord($char) + ord($keychar)) % 128);
			$result .= $char;
		}
		return $result;
	}

	private function doubleDecrypt($string) {
		$result = base64_decode(strtr(str_pad($string, ceil(strlen($string) / 4) * 4, '=', STR_PAD_RIGHT), '-_', '+/'));
		$result = $this->dec($result, $this->client_id);
		$result = $this->dec($result, $this->secret_key);
		return $result;
	}

	private function dec($string, $key) {
		$result = '';
		$strls = strlen($string);
		$strlk = strlen($key);
		for($i = 0; $i < $strls; $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % $strlk) - 1, 1);
			$char = chr(((ord($char) - ord($keychar)) + 256) % 128);
			$result .= $char;
		}
		return $result;
	}

	function getContent($raw) {
    if ($raw['type'] == 'createbilling') {
        DB::table('va')->insert([
            'trx_id' => $raw['trx_id'],
            'trx_amount' => $raw['trx_amount'],
            'datetime_expired' => $raw['datetime_expired'],
            'virtual_account' => $raw['virtual_account'],
            // Serialize array to JSON string
            'detail_tagihan' => isset($raw['detail_tagihan']) ? json_encode($raw['detail_tagihan']) : null,
        ]);
    }

    // Serialize detail_tagihan before encryption
    if (isset($raw['detail_tagihan']) && is_array($raw['detail_tagihan'])) {
        $raw['detail_tagihan'] = json_encode($raw['detail_tagihan']);
    }

    $raw['client_id'] = $this->client_id;
    $hashed_string = $this->encrypt($raw);

    $post = json_encode([
        'client_id' => $this->client_id,
        'data' => $hashed_string,
    ]);
		$header[] = 'Content-Type: application/json';
		$header[] = "Accept-Encoding: gzip, deflate";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

		curl_setopt($ch, CURLOPT_USERAGENT, "sit_loc");

		if ($post)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$rs = curl_exec($ch);

		if(empty($rs)){
			var_dump($rs, curl_error($ch));
			curl_close($ch);
			return false;
		}
		curl_close($ch);
		return $rs;
	}

	public function createVA($nik)
    {
        // Data untuk request API
        $data = [
            'nik' => $nik,
            'amount' => 100000,  // Misalnya jumlah tagihan, sesuaikan dengan kebutuhan Anda
            // Anda bisa menambahkan parameter lain yang diperlukan oleh API BNI
        ];

        try {
            // Encrypt data sebelum dikirim ke API
            $encryptedData = $this->encrypt($data);

            // Kirim request untuk membuat virtual account
            $response = $this->getContent($encryptedData);

            // Parse hasil respons
            $responseData = $this->decrypt($response);

            if ($responseData && isset($responseData['virtual_account'])) {
                return $responseData['virtual_account']; // Ambil nomor VA dari response
            }

            // Jika gagal atau tidak ada VA, kembalikan null
            return null;
        } catch (Exception $e) {
            // Tangani exception jika terjadi kesalahan
            return null;
        }
    }

	public static function create()
	{
		return self::$url;
	}

}
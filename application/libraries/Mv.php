<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Mv{
  public function __construct()
  {

  }
  public function sendMessage($IdUser = null,$chat = null){
    $url = 'https://api.telegram.org/'.TELETOKEN.'/sendMessage?chat_id='.$IdUser.'&text='.urlencode($chat).'&parse_mode=html';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "".$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
  }
	function nama_saya(){
    $this->db->get('data_log_users')->result();
		echo "Nama saya adalah malasngoding !";
	}

	function nama_kamu($nama){
		echo "Nama kamu adalah ". $nama ." !";
	}
}

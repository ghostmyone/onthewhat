<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        // if ($this->ion_auth) {
        //   if (!$this->ion_auth->logged_in())
        // 	{
        // 		redirect('dashboard/login', 'refresh');
        // 	}
        // }
        if (!AVAIL) {
            if ($this->ion_auth->is_admin()) {
            } else {
                show_error('SEDANG DALAM PERBAIKAN. | ');
            }
        }
    }

    public function index()
    {
        if ($this->ion_auth->logged_in()) {
          $user_groups = $this->ion_auth->get_users_groups($this->ion_auth->user()->row()->id)->row()->name;
        }else {
          $user_groups = 'members';
        }
        $dataHarga = $this->db->where(['GroupName' => $user_groups,'Status' => 1])->get('data_harga')->result();
        $WebsiteSetting = $this->db->get('data_setting')->row();
        $game = isset($_GET['pro']) ? $_GET['pro'] : '';


        if ($game == '') {
            show_error('No direct script access allowed | ');
        } else {
            $game = urldecode($game);
            $dataDb = $this->db->where('ProductName',$game)->get('data_product')->row();
            if ($dataDb) {
              $gameName = $dataDb->ProductName;
              $gameCode = $dataDb->ProductCode;
              $gamePic = $dataDb->ProductImage;
              $gameId = $dataDb->ProductTutor;

              if ($dataDb->ProductType == 0) {
                $gameCekId = '';
              }else {
                if ($gameName == 'MOBILE LEGEND') {
                  $gameCekId = 'https://mvstore.id/api/mlcek';
                }elseif ($gameName == 'PLN') {
                  $gameCekId = 'https://mvstore.id/api/plncek';
                }elseif ($gameName == 'Higgs Domino') {
                  $gameCekId = 'https://mvstore.id/api/hdcek';
                }elseif ($gameName == 'FREE FIRE') {
                  $gameCekId = 'https://mvstore.id/api/ffcek';
                }else {
                  $gameCekId = '';
                }

              }
            }else {
              show_error('No direct script access allowed | ');
            }
            if ($dataDb->ProductType == 0) {
              $itemDb = $this->db->where(['ProductCode' => $gameCode,'ItemStatus' => 1])->get('data_item')->result();
              $x = 0;
              $dataJson = [];
              foreach ($itemDb as $i => $value) {
                $feeMv = 0;
                if ($dataHarga) {
                  foreach ($dataHarga as $dhm) {
                      if ($value->ItemPrice >= $dhm->Price && $value->ItemPrice <= $dhm->Price2) {
                        $feeMv = $dhm->MarkUp;
                      }else if($feeMv == 0) {
                        $feeMv = 1.01;
                      }
                  }
                }else {
                  $feeMv = 1.01;
                }
                $dataJson[$x] = (object)[
                  'newprice' => ceil($value->ItemPrice * $feeMv),
                  'brand' =>$gameName,
                  'product_name' => $value->ItemName,
                  'sku_code' => $value->ItemSku,
                  'buyer_product_status' => true,
                  'seller_product_status' => true,
                ];
                // $dataJson['newprice'] = ceil($value->ItemPrice * $feeMv);
                // $dataJson['brand'][$x] = $gameName;
                // $dataJson[$x]['buyer_product_status'] = 'true';
                // $dataJson[$x]['seller_product_status'] = true;
                $x++;
              }
            }else {


                $x = 0;
                $curl = curl_init();
                $sign = md5(USERNAME_DIGI.KEY_GIDI.'pricelist');
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.digiflazz.com/v1/price-list',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'
                {
                  "cmd" : "prepaid",
                  "username": "'.USERNAME_DIGI.'",
                  "sign": "'.$sign.'"
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: text/plain'
                  ),
                ));

                $response = json_decode(curl_exec($curl));
                $dataJson = $response->data;
                usort($dataJson, function ($a, $b) {
                    return $a->price < $b->price ? -1 : 1 ;
                });
                curl_close($curl);
                foreach ($dataJson as $k => $value) {
                  $feeMv = 0;
                  if ($dataHarga) {
                    foreach ($dataHarga as $dhm) {
                        if ($value->price >= $dhm->Price && $value->price <= $dhm->Price2) {
                          $feeMv = $dhm->MarkUp;
                        }else if($feeMv == 0) {
                          $feeMv = 1.01;
                        }
                    }
                  }else {
                    $feeMv = 1.01;
                  }
                  $dataJson[$k]->newprice = ceil($value->price * $feeMv);
                  $dataJson[$k]->sku_code = $value->buyer_sku_code;
                }

            }

            // print_r($dataJson);
            // exit();
            $data = [
            'title' => $WebsiteSetting->SiteName.' | '.$gameName,
            'data' => $dataJson,
            'gameName' => $gameName,
            'gameCode' => $gameCode,
            'gamePic' => $gamePic,
            'gameId' => $gameId,
            'gameCekId' => $gameCekId,
            ];
            if ($gameCode != 'ML') {
              $this->load->view('front/GameViews', $data);
            }else {
              $this->load->view('front/MobileLegendsViews', $data);
            }

        }
    }
    public function getPayment(){
      $chanelPembayaran = $this->chanelPembayaran();
      $c = 0;
      foreach ($chanelPembayaran->data as $r) {
        $data['data'][$c]['code'] = $r->code;
        $data['data'][$c]['image'] = $r->icon_url;
        $data['data'][$c]['price'] = 0;
        $c++;
      }
      $data['data'][$c]['code'] = 'BALANCE';
      $data['data'][$c]['price'] = 0;
      echo json_encode($data);
    }
    public function webhooks($d){
      if ($d == 1) {
        echo USERNAME_DIGI.KEY_GIDI.'pricelist <br>';
      }elseif ($d == 2) {
        $itemId = $this->input->post('itemId');
        $userId = $this->input->post('userId');
        if ($itemId == null) {
          echo "ERROR";
        }else {
          $refid = $this->generateid();
          $prosessC =  $this->prosess($itemId, $userId, $refid);
          print_r($prosessC);
        }
      }elseif ($d == 3) {
        $refid = $this->generateid();
        echo $refid;
      }elseif ($d ==4) {
        $refid = $this->ceksaldo();
        echo $refid;
      }elseif ($d ==5) {
        $url = urlencode('Higgs Domino');
        echo $url.'<br>';
        echo urldecode($url).'<br>';
      }elseif ($d ==6) {
        print_r(getallheaders());
      }
      else {
        echo "ERROR";
      }
    }
    public function ceksaldo()
    {
        $curl = curl_init();
        $sign = md5(USERNAME_DIGI.KEY_GIDI.'depo');
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.digiflazz.com/v1/cek-saldo',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'
      {
          "cmd": "deposit",
          "username": "'.USERNAME_DIGI.'",
          "sign": "'.$sign.'"
      }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: text/plain'
        ),
      ));

        $response = json_decode(curl_exec($curl));
        $dataJson = $response->data;
        return $dataJson->deposit;
    }
    public function generateid(){
      $rand1 = mt_rand(1,100);
      $rand2 = mt_rand(1000,9999);
      $refid = date("md").$rand1.date("hsi").$rand2.$rand1;
      return $refid;
    }
    public function prosess($buyerSku, $customer_no, $refid)
    {
        $curl = curl_init();
        $sign = md5(USERNAME_DIGI.KEY_GIDI.$refid);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.digiflazz.com/v1/transaction',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'
        {
            "username": "'.USERNAME_DIGI.'",
            "buyer_sku_code": "'.$buyerSku.'",
            "customer_no": "'.$customer_no.'",
            "ref_id": "'.$refid.'",
            "testing": false,
            "sign": "'.$sign.'"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: text/plain'
          ),
        ));
        $response = json_decode(curl_exec($curl));
        $dataJson = $response->data;
        return $dataJson;
    }
    public function chanelPembayaran(){
    $apiKey = API_KEY;
    $payload = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_FRESH_CONNECT     => true,
    CURLOPT_URL               => "https://tripay.co.id/api/merchant/payment-channel?".http_build_query($payload),
    CURLOPT_RETURNTRANSFER    => true,
    CURLOPT_HEADER            => false,
    CURLOPT_HTTPHEADER        => array(
      "Authorization: Bearer ".$apiKey
    ),
    CURLOPT_FAILONERROR       => false
    ));
    $response = curl_exec($curl);
    $response = json_decode($response);
    $err = curl_error($curl);
    curl_close($curl);
    return $response;
  }


}

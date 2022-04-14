<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Listharga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
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
      $sign = md5(USERNAME_DIGI.KEY_GIDI.'pricelist');
      $curl = curl_init();
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
        curl_close($curl);
        foreach ($dataJson as $k => $value) {
          $feeMvM = 0;
          $dataHargaMembers = $this->db->where(['GroupName' => 'members','Status' => 1])->get('data_harga')->result();
          if ($dataHargaMembers) {
            foreach ($dataHargaMembers as $dhm) {
                if ($value->price >= $dhm->Price && $value->price <= $dhm->Price2) {
                  $feeMvM = $dhm->MarkUp;
                }else if($feeMvM == 0) {
                  $feeMvM = 1.01;
                }
            }
          }else {
            $feeMvM = 1.01;
          }
          $dataJson[$k]->price_member = ceil($value->price * $feeMvM);
          //----------------------------------------------------------
          $feeMvR = 0;
          $dataHargaResseler = $this->db->where(['GroupName' => 'resseler','Status' => 1])->get('data_harga')->result();
          if ($dataHargaResseler) {
            foreach ($dataHargaResseler as $dhm) {
                if ($value->price >= $dhm->Price && $value->price <= $dhm->Price2) {
                  $feeMvR = $dhm->MarkUp;
                }else if($feeMvR == 0) {
                  $feeMvR = 1.01;
                }
            }
          }else {
            $feeMvR = 1.01;
          }
          $dataJson[$k]->price_seller = ceil($value->price * $feeMvR);
          //----------------------------------------------------------
          $feeMvV = 0;
          $dataHargaVip = $this->db->where(['GroupName' => 'VIP','Status' => 1])->get('data_harga')->result();
          if ($dataHargaVip) {
            foreach ($dataHargaVip as $dhm) {
                if ($value->price >= $dhm->Price && $value->price <= $dhm->Price2) {
                  $feeMvV = $dhm->MarkUp;
                }else if($feeMvV == 0) {
                  $feeMvV = 1.01;
                }
            }
          }else {
            $feeMvV = 1.01;
          }
          $dataJson[$k]->price_vip = ceil($value->price * $feeMvV);
            // if ($value->price > 90000) {
            //     $dataJson[$k]->price_member = ceil($value->price * $WebsiteSetting->Member2);
            //     $dataJson[$k]->price_seller = ceil($value->price * $WebsiteSetting->Resseler2);
            //     $dataJson[$k]->price_vip = ceil($value->price * $WebsiteSetting->Api);
            // } else {
            //     $dataJson[$k]->price_member = ceil($value->price * $WebsiteSetting->Member1);
            //     $dataJson[$k]->price_seller = ceil($value->price * $WebsiteSetting->Resseler2);
            //     $dataJson[$k]->price_vip = ceil($value->price * $WebsiteSetting->Api);
            // }

            //echo $value->product_name."string <br>";
        }
        usort($dataJson, function ($a, $b) {
            return $a->price < $b->price ? -1 : 1 ;
        });
        // foreach ($dataJson as $d) {
        //   echo $d->product_name.' | '.$d->price.' | '.$d->newprice.'<br>';
        // }
        //print_r($dataJson);
        $data = [
            'title' => $WebsiteSetting->SiteName.'| List Harga',
            'data'=> $dataJson,
            'dataCat' => $this->getcat(),
            // 'dataHd' => $this->getqty(),
        ];
        $this->load->view('front/ListHargaViews', $data);
    }

    public function getcat()
    {
      $sign = md5(USERNAME_DIGI.KEY_GIDI.'pricelist');
      $WebsiteSetting = $this->db->get('data_setting')->row();
        $curl = curl_init();
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
        curl_close($curl);
        foreach ($dataJson as $k => $value) {
            if ($value->buyer_product_status == 1) {
                $result1[$value->brand][] = $value;
            }
            //echo $value->product_name."string <br>";
        }
        foreach ($result1 as $key => $value) {
            $finalcat[] = $key;
        }
        return $finalcat;
    }

}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Deposit extends CI_Controller
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
        $WebsiteSetting = $this->db->get('data_setting')->row();
        if (!$this->ion_auth->logged_in()) {
            redirect('/');
        }
        $data = [
            'title' => $WebsiteSetting->SiteName.' | DEPOSIT',
        ];
        $this->load->view('front/DepositViews', $data);
    }
    public function history()
    {
        $WebsiteSetting = $this->db->get('data_setting')->row();
        $this->session->set_flashdata('message', 'You must be an administrator to view this page.');
        redirect('/', 'refresh');
        if (!$this->ion_auth->logged_in()) {
            redirect('/');
        }

        $User = $this->ion_auth->user()->row();

        if (!$this->ion_auth->is_admin()) {
            $this->db->order_by('Id', 'DESC');
            $dataDb = $this->db->where('UserId', $User->id)->get('data_deposit')->result();
        } else {
            $this->db->order_by('Id', 'DESC');
            $dataDb = $this->db->get('data_deposit')->result();
        }
        //print_r($dataDb);
        $data = [
            'title' => $WebsiteSetting->SiteName.' | HISTORY',
      'data'=> $dataDb
        ];
        $this->load->view('front/DepositHistoryViews', $data);
    }
    public function pro()
    {
        $price = $this->input->post('price');
        $payment = $this->input->post('payment');
        $mode = $this->input->post('mode');
        $dataRow = $this->db->where('Tanggal', date('Y-m-d'))->get('data_deposit')->num_rows() + 1;
        $AdminFee = 1100;
        $refid = REF.date("md").date("hsi").$dataRow;

        $n = str_replace("Rp. ", "", $price);
        $n = str_replace(".", "", $n);
        $n = str_replace(".", "", $n);
        if ($n < 0) {
          exit();
        }
        if ($mode == 'otomatis') {
          $finalPrice = $n + $AdminFee;
          $cekPayment = $this->chanelCalculator($payment,$finalPrice);
          if ($cekPayment) {
          }else {
            exit();
          }
          $privateKey = PRIVATE_KEY;
          $apiKey = API_KEY;
          $merchantCode = MERCHANT_CODE;
          $merchantRef = $refid;
          $signature = hash_hmac('sha256', $merchantCode.$merchantRef.$finalPrice, $privateKey);
          if ($payment == 'OVO') {
            $data = [
              'method'            => $payment,
              'merchant_ref'      => $merchantRef,
              'amount'            => $finalPrice,
              'customer_name'     => $this->ion_auth->user()->row()->first_name,
              'customer_email'    => ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row()->email : 'guest@mvstore.id',
              'customer_phone'    => '081111111',
              'order_items'       => [
                [
                  'sku'       => 'DEPOSIT'.$dataRow,
                  'name'      => 'Deposit '.$finalPrice,
                  'price'     => $finalPrice,
                  'quantity'  => 1
                ]
              ],
              'callback_url'      => base_url('callback'),
              'return_url'        => base_url('redirect'),
              'expired_time'      => (time()+(24*60*60)), // 24 jam
              'signature'         => hash_hmac('sha256', $merchantCode.$merchantRef.$finalPrice, $privateKey)
            ];
          }else {
            $data = [
              'method'            => $payment,
              'merchant_ref'      => $merchantRef,
              'amount'            => $finalPrice,
              'customer_name'     => $this->ion_auth->user()->row()->first_name,
              'customer_email'    => ($this->ion_auth->logged_in()) ? $this->ion_auth->user()->row()->email : 'guest@mvstore.id',
              'customer_phone'    => ADMINPHONE,
              'order_items'       => [
                [
                  'sku'       => 'DEPOSIT'.$dataRow,
                  'name'      => 'Deposit '.$finalPrice,
                  'price'     => $finalPrice,
                  'quantity'  => 1
                ]
              ],
              'callback_url'      => base_url('callback'),
              'return_url'        => base_url('redirect'),
              'expired_time'      => (time()+(24*60*60)), // 24 jam
              'signature'         => hash_hmac('sha256', $merchantCode.$merchantRef.$finalPrice, $privateKey)
            ];
          }
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => URL_TRANSAKSI,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
              "Authorization: Bearer ".$apiKey
            ),
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($data)
          ));
          $response = curl_exec($curl);
          $err = curl_error($curl);
          curl_close($curl);
          $newResponse = json_decode($response);
          $inpuData = [
            'UserId' => $this->ion_auth->user()->row()->id,
            'PaymentMetod' => $payment,
            'InvoiceId' => $refid,
            'UniqAmount' => $finalPrice,
            'Balance' => $n,
            'Tanggal' => date('Y-m-d'),
            'Status' => 0,
          ];
          $insert = $this->db->insert('data_deposit', $inpuData);
          if ($insert) {
            $dataRespone = [
              'Respone' => $newResponse,
              'Invoice' => $refid,
              'Payment' => $payment,
              'Price' => $price,
              'Mode' => $mode,
              'AdminFee' => $AdminFee,
              'Total' => $finalPrice,
              'UserId' => $this->ion_auth->user()->row()->id,
            ];
            echo json_encode($dataRespone);
          }

        }else {
          $total = $n + $AdminFee + $dataRow;
          $dataRespone = [
            'Invoice' => $refid,
            'Payment' => $payment,
            'Price' => $price,
            'Mode' => $mode,
            'AdminFee' => $AdminFee,
            'Total' => $total,
            'UserId' => $this->ion_auth->user()->row()->id,
          ];
          $inpuData = [
            'UserId' => $this->ion_auth->user()->row()->id,
            'PaymentMetod' => $payment,
            'InvoiceId' => $refid,
            'UniqAmount' => $total,
            'Balance' => $n,
            'Tanggal' => date('Y-m-d'),
            'Status' => 0,
          ];
          $this->db->insert('data_deposit', $inpuData);
          if ($payment === 'BCA') {
              $dataRespone['Detail'] = '<p> Rekening : <b class="bg-warning text-dark">6155349640</b> A/N Septian zulfikar f. </p>';
          } elseif ($payment === 'MANDIRI') {
              $dataRespone['Detail'] = '<p> Rekening : <b class="bg-warning text-dark">1410018519637</b> A/N Septian zulfikar f. </p>';
          }

          $this->load->library('phpmailer_lib');
          $mail = $this->phpmailer_lib->load();
          $mail->isSMTP();
          $mail->Host     = SMTPHOST;
          $mail->SMTPAuth = true;
          $mail->Username = SMTPUSER;
          $mail->Password = SMTPPASS;
          $mail->SMTPSecure = SMTPCRYPTO;
          $mail->Port     = 465;
          $mail->setFrom(SMTPUSER, SITE_NAME);
          $mail->addAddress(EMAIL_ADMIN);
          $mail->Subject = 'You Have New Deposit | '.$inpuData['InvoiceId'].'  | '.SITE_NAME;
          $mail->isHTML(true);
          $mail->Body = $this->load->view('email/EmailDeposit', $inpuData, true);
          $mail->send();
          echo json_encode($dataRespone);
        }

    }
    public function getdata()
    {
      $price = $this->input->post('price');
      $dataRow = $this->db->where('Tanggal', date('Y-m-d'))->get('data_deposit')->num_rows() + 1;
      $AdminFee = 1100;
      // if ($priceInput != $price) {
      //   $dataRespone = [
      //     'status' => 'FAILED',
      //     'message' => 'Ban',
      //     'priceInput' => $priceInput,
      //     'price' => $price
      //   ];
      //   echo json_encode($dataRespone);
      //   exit();
      // }
      $chanelPembayaran = $this->chanelPembayaran();
      $group = 'resseler';
      $c = 0;
      foreach ($chanelPembayaran->data as $r) {
        $data['data'][$c]['code'] = $r->code;
        $data['data'][$c]['image'] = $r->icon_url;
        $data['data'][$c]['mode'] = 'otomatis';
        $data['data'][$c]['price'] = $this->chanelCalculator($r->code,$price)->total_fee->customer + $price;
        $c++;
      }
      // $data['data'][$c]['code'] = 'BCA';
      // $data['data'][$c]['mode'] = 'manual';
      // $data['data'][$c]['image'] = 'https://tripay.co.id/images/payment-channel/ytBKvaleGy1605201833.png';
      // $data['data'][$c]['price'] = $price + $dataRow + $AdminFee;
      // $c++;
      // $data['data'][$c]['code'] = 'MANDIRI';
      // $data['data'][$c]['mode'] = 'manual';
      // $data['data'][$c]['image'] = 'https://tripay.co.id/images/payment-channel/T9Z012UE331583531536.png';
      // $data['data'][$c]['price'] = $price + $dataRow + $AdminFee;
      // $c++;

      echo json_encode($data);
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
    public function chanelCalculator($code = null,$value = null){
      $apiKey = API_KEY;
      $payload = [
        'code'	=> $code,
        'amount'	=> $value
      ];
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_FRESH_CONNECT     => true,
        CURLOPT_URL               => "https://tripay.co.id/api/merchant/fee-calculator?".http_build_query($payload),
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
      return $response->data[0];
    }
}

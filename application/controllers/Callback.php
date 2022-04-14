<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Callback extends CI_Controller
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
  }
  public function index()
  {
    $WebsiteSetting = $this->db->get('data_setting')->row();
    $config = [
      'mailtype'  => MAILTYPE,
      'charset'   => 'utf-8',
      'protocol'  => 'mail',
      'smtp_host' => SMTPHOST,
      'smtp_user' => SMTPUSER,  // Email gmail
      'smtp_pass'   => SMTPPASS,  // Password gmail
      'smtp_crypto' => SMTPCRYPTO,
      'smtp_port'   => SMTPPORT,
      'crlf'    => "\r\n",
      'newline' => "\r\n"
    ];
    $privateKey = PRIVATE_KEY;
    // ambil data json callback notifikasi
    $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';
    $json = file_get_contents("php://input");
    $signature = hash_hmac('sha256', $json, $privateKey);
    if ($callbackSignature !== $signature) {
      exit("Invalid Signature"); // signature tidak valid, hentikan proses
    }
    $data = json_decode($json);
    $event = $_SERVER['HTTP_X_CALLBACK_EVENT'];
    $dataTest = 'PAID';
    $inputData['TanggalUpdate'] = date('Y-m-d H:i:s');
    if ($event == 'payment_status') {
      $merchantRef = $data->merchant_ref;
      $cek = $this->db->where('InvoiceId', $merchantRef)->get('data_order')->row();
      if ($cek) {
        if ($cek->StatusOrder == 1 || $cek->StatusOrder == 5) {
          echo json_encode(['success' => true]);
        } else {
          if ($data->status == 'PAID') {
            $dataInputUntung = [
              'Status' => 1,
            ];
            $this->db->where('InvoiceId', $merchantRef)->update('data_untung', $dataInputUntung);
            $inputData['StatusOrder'] = 1;
            $this->db->where('InvoiceId', $merchantRef);
            $update = $this->db->update('data_order', $inputData);
            $dataPro = $this->db->where('ProductCode', $cek->Game)->get('data_product')->row();
            if ($dataPro->ProductType == 0) {
              $inputData['StatusOrder'] = 1;
              $update = $this->db->where('InvoiceId', $merchantRef)->update('data_order', $inputData);
            } else {
              $prosessC =  $this->prosessMv($cek->ItemId, $cek->Note, $cek->InvoiceId);
              if ($prosessC->rc == 00) {
                $inputData['StatusOrder'] = 5;
                $inputData['Ket'] = $prosessC->sn;
                $inputData['TanggalUpdate'] = date('Y-m-d H:i');
                $this->db->where('InvoiceId', $merchantRef);
                $update = $this->db->update('data_order', $inputData);
                $dataDb = $this->db->where('InvoiceId', $merchantRef)->get('data_order')->row();
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
                $mail->addAddress($dataDb->Email);
                $mail->Subject = 'TRANSAKSI SUKSES | ' . $dataDb->InvoiceId . ' | ' . $WebsiteSetting->SiteName;
                $mail->isHTML(true);
                $mail->Body = $this->load->view('email/EmailTransaksiUser', $dataDb, TRUE);
                $mail->send();
              } elseif ($prosessC->rc == 03) {
                $inputData['StatusOrder'] = 6;
                $inputData['Ket'] = $prosessC->sn;
                $inputData['TanggalUpdate'] = date('Y-m-d H:i');
                $this->db->where('InvoiceId', $merchantRef)->update('data_order', $inputData);
              } else {
                $inputData['StatusOrder'] = 4;
                $inputData['Ket'] = $prosessC->sn;
                $inputData['TanggalUpdate'] = date('Y-m-d H:i');
                $this->db->where('InvoiceId', $merchantRef)->update('data_order', $inputData);
              }
            }
          } elseif ($data->status == 'EXPIRED') {
            $inputData['StatusOrder'] = 2;
            $this->db->where('InvoiceId', $merchantRef);
            $update = $this->db->update('data_order', $inputData);
          } elseif ($data->status == 'FAILED') {
            $inputData['StatusOrder'] = 3;
            $this->db->where('InvoiceId', $merchantRef);
            $update = $this->db->update('data_order', $inputData);
          }
          echo json_encode(['success' => true]);
        }
      } else {
        $cek2 = $this->db->where('InvoiceId', $merchantRef)->get('data_deposit')->row();
        if ($cek2) {
          if ($cek2->Status == 1 || $cek2->Status == 2) {
            echo json_encode(['success' => true]);
          } else {
            $dataUser = $this->db->where('id', $cek2->UserId)->get('users')->row();
            if ($data->status == 'PAID') {
              $updateUser = [
                'Balance' => $dataUser->Balance + $cek2->Balance,
              ];
              $this->db->where('id', $cek2->UserId)->update('users', $updateUser);
              $updateDataDepo = [
                'Status' => 1
              ];
              $this->email->initialize($config);
              $this->email->from(SMTPUSER, SITE_NAME);
              $this->email->to($dataUser->email);
              $this->email->subject('DEPOSIT SUKSES | ' . SITE_NAME);
              $message = $this->load->view('email/EmailDepositSukses', $cek2, true);
              $this->email->message($message);
            } elseif ($data->status == 'EXPIRED') {
              $updateDataDepo = [
                'Status' => 2
              ];
            } elseif ($data->status == 'FAILED') {
              $updateDataDepo = [
                'Status' => 3
              ];
            }
            $this->db->where('Id', $cek2->Id)->update('data_deposit', $updateDataDepo);
            echo json_encode(['success' => true]);
          }
        } else {
          echo json_encode(['success' => false]);
        }
      }
    }
  }
  private function prosessMv($buyerSku, $customer_no, $refid)
  {
    $curl = curl_init();
    $sign = md5(USERNAME_DIGI . KEY_GIDI . $refid);
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.digiflazz.com/v1/transaction',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '
      {
          "username": "' . USERNAME_DIGI . '",
          "buyer_sku_code": "' . $buyerSku . '",
          "customer_no": "' . $customer_no . '",
          "ref_id": "' . $refid . '",
          "testing": false,
          "sign": "' . $sign . '"
      }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: text/plain'
      ),
    ));
    $response = json_decode(curl_exec($curl));
    $dataJson = $response->data;
    return $dataJson;
  }
}

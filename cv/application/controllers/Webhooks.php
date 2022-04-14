<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Webhooks extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }

    public function index()
    {
      $WebsiteSetting = $this->db->get('data_setting')->row();
      $privateKey = PRIVATEDIGI;
      $callbackSignature = isset($_SERVER['HTTP_X_HUB_SIGNATURE']) ? $_SERVER['HTTP_X_HUB_SIGNATURE'] : '';
      $json = file_get_contents("php://input");
      $signature = hash_hmac('sha1', $json, $privateKey);
      $signatureNew = 'sha1='.$signature;
        if ($callbackSignature == $signatureNew) {
            $data = json_decode($json);
            $data = $data->data;
            $merchantRef = $data->ref_id;
            $cek = $this->db->where('InvoiceId', $merchantRef)->get('data_order')->row();
            if ($cek) {
                if ($cek->StatusOrder == 5) {
                    echo json_encode(['success' => true]);
                }elseif ($cek->StatusOrder == 4) {
                    echo json_encode(['success' => true]);
                } else {
                    if ($cek) {
                        if ($data->rc == 00) {
                            $inputData['StatusOrder'] = 5;
                            $inputData['Ket'] = $data->sn;
                            $inputData['TanggalUpdate'] = date('Y-m-d H:i');
                            $this->db->where('InvoiceId', $merchantRef)->update('data_order', $inputData);
                              $dataDb = $this->db->where('InvoiceId',$merchantRef)->get('data_order')->row();
                              $this->load->library('phpmailer_lib');
                              $mail = $this->phpmailer_lib->load();
                              $mail->isSMTP();
                              $mail->Host     = SMTPHOST;
                              $mail->SMTPAuth = true;
                              $mail->Username = SMTPUSER;
                              $mail->Password = SMTPPASS;
                              $mail->SMTPSecure = SMTPCRYPTO;
                              $mail->Port     = SMTPPORT;
                              $mail->setFrom(SMTPUSER, SITE_NAME);
                              $mail->addAddress($dataDb->Email);
                              $mail->Subject = 'TRANSAKSI SUKSES | '.$dataDb->InvoiceId.' | '.$WebsiteSetting->SiteName;
                              $mail->isHTML(true);
                              $mail->Body = $this->load->view('email/EmailTransaksiUser',$dataDb,TRUE);
                              $mail->send();
                            echo json_encode(['Transaksi Sukses' => true]);
                        } elseif ($data->rc == 03) {
                            $inputData['StatusOrder'] = 6;
                            $inputData['Ket'] = $data->sn;
                            $inputData['TanggalUpdate'] = date('Y-m-d H:i');
                            $this->db->where('InvoiceId', $merchantRef);
                            $this->db->update('data_order', $inputData);
                            echo json_encode(['Transaksi pending' => true]);
                        } else {
                            $inputData['StatusOrder'] = 4;
                            $inputData['Ket'] = $data->sn;
                            $inputData['TanggalUpdate'] = date('Y-m-d H:i');
                            $dataDb = $this->db->where('InvoiceId',$merchantRef)->get('data_order')->row();
                            $this->db->where('InvoiceId', $merchantRef);
                            $this->db->update('data_order', $inputData);
                            //PENGEMBALIAN SALDO JIKA USER TRANSAKSI MENGGUNAKAN LOGIN AKUN
                            if ($cek->UserId != 0) {
                                $user = $this->db->where('id', $cek->UserId)->get('users')->row();
                                $inputUser['Balance'] = $user->Balance + $cek->Amount;
                                $this->db->where('id', $cek->UserId)->update('users', $inputUser);
                            }
                            $this->load->library('phpmailer_lib');
                            $mail = $this->phpmailer_lib->load();
                            $mail->isSMTP();
                            $mail->Host     = SMTPHOST;
                            $mail->SMTPAuth = true;
                            $mail->Username = SMTPUSER;
                            $mail->Password = SMTPPASS;
                            $mail->SMTPSecure = SMTPCRYPTO;
                            $mail->Port     = SMTPPORT;
                            $mail->setFrom(SMTPUSER, SITE_NAME);
                            $mail->addAddress(EMAIL_ADMIN);
                            $mail->Subject = 'TRANSAKSI GAGAL | '.$dataDb->InvoiceId.' | '.$WebsiteSetting->SiteName;
                            $mail->isHTML(true);
                            $mail->Body = $this->load->view('email/EmailTransaksiUser',$dataDb,TRUE);
                            $mail->send();
                            echo json_encode(['Transaksi gagal' => true]);
                        }

                    } else {
                        echo "GAGAL";
                    }
                }
            } else {
                echo json_encode(['failed' => true]);
            }
        } else {
            echo json_encode(['Invalid signature' => true]);
        }
    }





}

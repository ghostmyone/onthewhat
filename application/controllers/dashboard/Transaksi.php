<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['ion_auth', 'form_validation']);
        $this->load->helper(['url', 'language']);
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        if ($this->ion_auth) {
            if (!$this->ion_auth->logged_in()) {
                redirect('dashboard/login', 'refresh');
            } else {
                if (!$this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
                    // redirect them to the home page because they must be an administrator to view this
                    // show_error('You must be an administrator to view this page.');
                    $this->session->set_flashdata('message', 'You must be an administrator to view this page.');
                    redirect('/', 'refresh');
                }
            }
        }
    }

    public function index()
    {
        $totalPembelian = 0;
        $pembelianHariIni = 0;
        $totalDeposit = 0;
        $totalUsers = $this->db->where('active', 1)->get('users')->num_rows();
        $transaksiSukses = 0;
        if (!$this->ion_auth->is_admin()) {
            $dataDb = $this->db->where('UserId', $User->id)->get('data_order')->result();
            $dataDepo = $this->db->where('UserId', $User->id)->get('data_deposit')->result();
        } else {
            $dataDb = $this->db->get('data_order')->result();
            $dataDepo = $this->db->get('data_deposit')->result();
        }
        foreach ($dataDb as $d) {
            if ($d->StatusOrder == 5) {
                $transaksiSukses += 1;
                $totalPembelian += $d->Amount;
                if ($d->TanggalOrder == date('Y-m-d')) {
                    $pembelianHariIni += $d->Amount;
                }
            }
        }
        foreach ($dataDepo as $d) {
            if ($d->Status == 1) {
                $totalDeposit += $d->Balance;
            }
        }
        $data = [
              'title' => 'Riwayat Transaksi',
        'dataOrder' => $dataDb,
        'totalPembelian' => $totalPembelian,
        'pembelianHariIni' => $pembelianHariIni,
        'totalDeposit' => $totalDeposit,
        'totalUsers' => $totalUsers,
        'transaksiSukses' => $transaksiSukses,
        ];
        $this->load->view('dashboard/transaksi/TransaksiViews', $data);
    }

    public function pro($Id){
      $Id = $Id;
      $dataDb = $this->db->where('Id',$Id)->get('data_order')->row();
      if ($dataDb->StatusOrder != 6 and $dataDb->StatusOrder != 1) {
        $this->session->set_flashdata('message', 'Data tidak bisa dirubah lagi.');
        redirect('dashboard/transaksi');
      }
      $data = [
        'title' => 'Riwayat Transaksi',
        'data' => $dataDb,
        'page' => 'edit'
      ];
      $this->load->view('dashboard/transaksi/TransaksiProViews', $data);
    }
    public function prosubmit(){
      $WebsiteSetting = $this->db->get('data_setting')->row();
      $EmailSend = $this->input->post('EmailSend');
      $Id = $this->input->post('Id');
      $Ket = $this->input->post('Ket');
      $StatusOrder = $this->input->post('StatusOrder');
      $dataInput = [
        'Ket' =>  $Ket,
        'StatusOrder' => $StatusOrder,
      ];
      if ($this->db->where('Id',$Id)->update('data_order',$dataInput)) {
        if ($EmailSend != '') {
          if ($StatusOrder == 5) {
            $StatusMessage = 'SUKSES';
          }elseif ($StatusOrder == 4) {
            $StatusMessage = 'GAGAL';
          }elseif ($StatusOrder == 6) {
            $StatusMessage = 'SENG DI PROSESS';
          }
          $dataDb = $this->db->where('Id',$Id)->get('data_order')->row();
          $this->load->library('phpmailer_lib');
          $mail = $this->phpmailer_lib->load();
          $mail->isSMTP();
          $mail->Host     = SMTPHOST;
          $mail->SMTPAuth = true;
          $mail->Username = SMTPUSER;
          $mail->Password = SMTPPASS;
          $mail->SMTPSecure = 'ssl';
          $mail->Port     = 465;
          $mail->setFrom(SMTPUSER, SITE_NAME);
          $mail->addAddress($EmailSend);
          $mail->Subject = 'TRANSAKSI '.$StatusMessage.' | '.$dataDb->InvoiceId.' | '.$WebsiteSetting->SiteName;
          $mail->isHTML(true);
          $mail->Body = $this->load->view('email/EmailTransaksiUser',$dataDb,TRUE);
          $mail->send();
        }
        $this->session->set_flashdata('message', 'Data berhasil diubah.');
        redirect('dashboard/transaksi');
      }else {
        $this->session->set_flashdata('message', 'Data gagal diubah.');
        redirect('dashboard/transaksi/prosubmit/'.$Id.'');
      }

    }
    public function force($id){
      $updateData = [
        'StatusOrder' => 5
      ];
      if ($this->db->where('Id', $id)->update('data_order', $updateData)) {
        $this->session->set_flashdata('message', 'Data berhasil dirubah.');
        redirect('dashboard/transaksi/');
      }else {
        $this->session->set_flashdata('message', 'Data tidak berhasil dirubah.');
        redirect('dashboard/transaksi/');
      }
    }
}

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
        'title' => 'Riwayat Deposit',
        'dataOrder' => $dataDb,
        'dataDepo' => $dataDepo,
        'totalPembelian' => $totalPembelian,
        'pembelianHariIni' => $pembelianHariIni,
        'totalDeposit' => $totalDeposit,
        'totalUsers' => $totalUsers,
        'transaksiSukses' => $transaksiSukses,
        ];
        $this->load->view('dashboard/DepositViews', $data);
    }
    public function mv()
    {
        $inv = $this->input->get('inv');
        $dataDepo = $this->db->where('InvoiceId', $inv)->get('data_deposit')->row();
        if ($dataDepo->Status == 1) {
            show_error('SUDAH PROSES. | '.SITE_NAME);
            exit();
        }
        $dataUser = $this->db->where('id', $dataDepo->UserId)->get('users')->row();
        $dataBalance = [
          'Balance' => $dataUser->Balance + $dataDepo->Balance,
        ];
        $dataStatus = [
          'Status' => 1,
        ];
        $updateBalance = $this->db->where('id', $dataDepo->UserId)->update('users', $dataBalance);
        if ($updateBalance) {
            $this->db->where('InvoiceId', $inv)->update('data_deposit', $dataStatus);
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
            $mail->addAddress($dataUser->email);
            $mail->Subject = 'DEPOSIT SUKSES | '.SITE_NAME;
            $mail->isHTML(true);
            $mail->Body = $this->load->view('email/EmailDepositSukses', $dataDepo, true);
            if ($mail->send()) {
            } else {
                show_error($this->email->print_debugger());
            }
            $this->session->set_flashdata('message', 'Deposit berhasil di prosess.');
            redirect("dashboard/deposit", 'refresh'); //we should display a confirmation page here instead of the login page
        } else {
            $this->session->set_flashdata('message', 'Deposit sudah di prosess.');
            redirect("dashboard/deposit", 'refresh');
        }

        //echo "SUKSES";
    }
}

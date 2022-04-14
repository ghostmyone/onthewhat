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
        if (!AVAIL) {
            if ($this->ion_auth->is_admin()) {
            } else {
                show_error('SEDANG DALAM PERBAIKAN. | ');
            }
        }
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('/');
        }
        $WebsiteSetting = $this->db->get('data_setting')->row();
        $User = $this->ion_auth->user()->row();
        $this->db->order_by('Id', 'DESC');
        $totalPembelian = 0;
        $pembelianHariIni = 0;
        $totalDeposit = 0;
        if (!$this->ion_auth->is_admin()) {
            $dataDb = $this->db->where('UserId', $User->id)->get('data_order')->result();
            $dataDepo = $this->db->where('UserId', $User->id)->get('data_deposit')->result();
        } else {
            $dataDb = $this->db->get('data_order')->result();
            $dataDepo = $this->db->get('data_deposit')->result();
        }
        foreach ($dataDb as $d) {
            if ($d->StatusOrder == 5) {
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
            'title' => $WebsiteSetting->SiteName.' | HISTORY',
            'data'=> $dataDb,
            'totalPembelian' => $totalPembelian,
            'pembelianHariIni' => $pembelianHariIni,
            'totalDeposit' => $totalDeposit,
            'dataDepo' => $dataDepo
              ];
        $this->load->view('front/TransaksiHistory', $data);
    }

}

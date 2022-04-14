<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
        //deposit
        $depositPending = $this->db->where('Status', 0)->get('data_deposit')->num_rows();
        $depositSukses = $this->db->where('Status', 1)->get('data_deposit')->num_rows();
        $depositExpired = $this->db->where('Status', 2)->get('data_deposit')->num_rows();
        $depositFailed = $this->db->where('Status', 3)->get('data_deposit')->num_rows();
        //order
        $orderPending = $this->db->where('StatusOrder', 6)->get('data_order')->num_rows();
        $orderSukses = $this->db->where('StatusOrder', 5)->get('data_order')->num_rows();
        $orderExpired = $this->db->where('StatusOrder', 2)->get('data_order')->num_rows();
        $orderFailed = $this->db->where('StatusOrder', 3)->get('data_order')->num_rows();
        ///Keuntungan
        $keuntungantoday = $this->db->where(['Tanggal'=>date('Y-m-d'),'Status' => 1])->get('data_untung')->result();
        $totalkeuntungan = $this->db->where('Status',1)->get('data_untung')->result();
        $keuntungantodaynum = 0;
        //================================
        foreach ($keuntungantoday as $d) {
          $keuntungantodaynum += $d->Untung;
        }
        $totalkeuntungannum = 0;
        foreach ($totalkeuntungan as $d) {
          $totalkeuntungannum += $d->Untung;
        }

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
        'title' => 'Home',
        'totalPembelian' => $totalPembelian,
        'pembelianHariIni' => $pembelianHariIni,
        'totalDeposit' => $totalDeposit,
        'totalUsers' => $totalUsers,
        'transaksiSukses' => $transaksiSukses,
        'depositPending' => $depositPending,
        'depositSukses' => $depositSukses,
        'depositExpired' => $depositExpired,
        'depositFailed' => $depositFailed,
        'orderPending' => $orderPending,
        'orderSukses' => $orderSukses,
        'orderExpired' => $orderExpired,
        'orderFailed' => $orderFailed,
        'profileapi' => $this->ceksaldo(),
        'keuntungantoday' => $keuntungantodaynum,
        'totalkeuntungan' => $totalkeuntungannum,
        ];
        $this->load->view('dashboard/HomeViews', $data);
    }

    public function ceksaldo(){

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
}

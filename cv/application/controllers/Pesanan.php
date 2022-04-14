<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
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
      $data = [
        'title' => $WebsiteSetting->SiteName.' | Lacak Pesanan'
      ];
      $this->load->view('front/PesananViews', $data);
    }
    public function getdata(){
      $invoiceid = $this->input->post('invoiceid');
      if ($invoiceid != null) {
        $dataDb = $this->db->where('InvoiceId',$invoiceid)->get('data_order')->row();
        if ($dataDb) {
            $d = $dataDb;
            if ($d->StatusOrder == 0) {
              $order = '<div class="bg-primary text-center rounded" style="widht:100%;">
                            <p>Belum dibayar</p>
                          </div>';
              } elseif ($d->StatusOrder == 1) {
              $order = '<div class="bg-success text-center rounded" style="widht:100%;">
                            <p>Sudah Dibayar</p>
                          </div>';
              } elseif ($d->StatusOrder == 2) {
              $order = '<div class="bg-warning text-center rounded" style="widht:100%;">
                            <p>Expired</p>
                          </div>';
              } elseif ($d->StatusOrder == 3) {
              $order = '<div class="bg-danger text-center rounded" style="widht:100%;">
                            <p>Gagal</p>
                          </div>';
              } elseif ($d->StatusOrder == 4) {
              $order = '<div class="bg-danger text-center rounded" style="widht:100%;">
                            <p>Gagal By Server</p>
                          </div>';
              } elseif ($d->StatusOrder == 5) {
              $order = '<div class="bg-success text-center rounded" style="widht:100%;">
                            <p>Success</p>
                          </div>';
              } elseif ($d->StatusOrder == 6) {
              $order = '<div class="bg-warning text-center rounded" style="widht:100%;">
                            <p>Pending</p>
                          </div>';
              }
          $data = [
            'data' => $dataDb,
            'dataStatus' => $order,
            'InvoiceId' => $invoiceid,
            'status' => true
          ];
          echo json_encode($data);
        }else {
          $data = [
            'status' => false
          ];
          echo json_encode($data);
        }
      } else {
        $data = [
          'status' => false
        ];
        echo json_encode($data);
      }

    }

}

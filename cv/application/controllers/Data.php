<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
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
        $dataProduct = $this->db->where('ProductCode','DATA')->get('data_product');
        $data = [
            'title' => $WebsiteSetting->SiteName.' | Data All Operator',
            'dataProduct' => $dataProduct->row(),
        ];
        $this->load->view('front/DataViews', $data);
    }



}

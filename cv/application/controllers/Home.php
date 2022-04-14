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
        // if ($this->ion_auth) {
        //   if (!$this->ion_auth->logged_in())
        // 	{
        // 		redirect('dashboard/login', 'refresh');
        // 	}
        // }
        if (!AVAIL) {
            if ($this->ion_auth->is_admin()) {
            } else {
                show_error('SEDANG DALAM PERBAIKAN. | ');
            }
        }
    }

    public function index()
    {
        $dataSlide = $this->db->where('StatusSlide', 1)->get('data_slide')->result();
        $dataProduct = $this->db->where('ProductStatus',1)->get('data_product')->result();
        $this->db->group_by('ProductCat');
        $dataCat = $this->db->where('ProductStatus',1)->get('data_product')->result();
        $WebsiteSetting = $this->db->get('data_setting')->row();
        $data = [
            'title' => $WebsiteSetting->SiteName,
            'dataSlide' => $dataSlide,
            'dataProduct' => $dataProduct,
            'dataCat' => $dataCat,
        ];
        $this->load->view('front/Index', $data);
    }
    public function mv($game)
    {
        echo $game;
    }
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
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
        $dataDb = $this->db->get('data_setting')->row();
        $data = [
        'title' => 'Website Setting',
        'data' => $dataDb
        ];
        $this->load->view('dashboard/SettingViews', $data);
    }
    public function update(){
      $newData = [
        'SiteName' => $this->input->post('SiteName'),
        'BonusRegist' => $this->input->post('BonusRegist'),
        'Resseler1' => $this->input->post('Resseler1'),
        'Member1' => $this->input->post('Member1'),
        'Resseler2' => $this->input->post('Resseler2'),
        'Member2' => $this->input->post('Member2'),
        'Api' => $this->input->post('Api'),
      ];
      $this->db->where('Id',1)->update('data_setting',$newData);
      $this->session->set_flashdata('message', 'Data berhasil di ubah.');
      redirect('dashboard/setting');
    }

}

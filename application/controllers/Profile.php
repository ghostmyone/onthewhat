<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
          if (!$this->ion_auth->logged_in())
        	{
        		redirect('dashboard/login', 'refresh');
        	}
        }
        if (!AVAIL) {
            if ($this->ion_auth->is_admin()) {
            } else {
                show_error('SEDANG DALAM PERBAIKAN. | '.SITE_NAME);
            }
        }
    }

    public function index()
    {
      $users = $this->ion_auth->user()->row();
      $WebsiteSetting = $this->db->get('data_setting')->row();
      $data = [
          'title' => $WebsiteSetting->SiteName.' | Profile',
          'data' => $users
      ];
      $this->load->view('front/ProfileViews', $data);
    }
    public function update(){
      $id = $this->input->post('id');
      $first_name = $this->input->post('fname');
      $last_name = $this->input->post('lname');
      $companyname = $this->input->post('companyname');
      $phone = $this->input->post('phone');
      $password1 = $this->input->post('password1');
      $password2 = $this->input->post('password2');

      if ($this->ion_auth->user()->row()->id == $id) {
        $data = [
					'first_name' => $first_name,
					'last_name' => $last_name,
					'company' => $companyname,
					'phone' => $phone,
				];
        if ($password1) {
          if ($password1 == $password2) {
            $data['password'] = $password1;
          }else {
            $this->session->set_flashdata('message', 'Password yang dimasukan tidak sama.');
            redirect('profile');
          }
        }
        if ($this->ion_auth->update($id, $data))
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('profile');

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('profile');

				}
      }else {
        $this->session->set_flashdata('message', 'Failed');
        redirect('profile');
      }

    }






}

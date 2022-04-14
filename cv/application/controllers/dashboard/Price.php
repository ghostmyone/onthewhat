<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Price extends CI_Controller
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
        $dataDb = $this->db->get('data_harga')->result();
        $data = [
        'title' => 'List Harga',
        'data' => $dataDb
        ];
        $this->load->view('dashboard/price/PriceViews', $data);
    }
    public function create()
    {
        $data = [
                    'title' => 'Create Harga',
                    'page' => 'add'
                    ];
        $this->load->view('dashboard/price/PriceFormViews', $data);
    }

    public function submit()
    {
        $Price = $this->input->post('Price');
        $Price2 = $this->input->post('Price2');
        $MarkUp = $this->input->post('MarkUp');
        $GroupName = $this->input->post('GroupName');
        $Status = $this->input->post('Status');
        $this->form_validation->set_rules('Price', 'Price', 'required');
        $this->form_validation->set_rules('Price2', 'Price2', 'required');
        $this->form_validation->set_rules('MarkUp', 'MarkUp', 'required');
        $this->form_validation->set_rules('Status', 'Status', 'required');
        if ($this->form_validation->run()) {
          $inputData = [
            'Price' => $Price,
            'Price2' => $Price2,
            'MarkUp' => $MarkUp,
            'GroupName' => $GroupName,
            'Status' => $Status,
          ];
            if ($this->db->insert('data_harga', $inputData)) {
                $this->session->set_flashdata('message', 'Data berhasil ditambahkan.');
                redirect('dashboard/price');
            } else {
                $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
                redirect('dashboard/price/create');
            }
        } else {
            $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
            redirect('dashboard/price/create');
        }
    }
    public function active($id)
    {
        $dataDb = $this->db->where('Id', $id)->get('data_harga')->row();
        if ($dataDb->ProductStatus == 1) {
            $inputData = [
              'Status' => 0
            ];
            $this->db->where('Id', $id)->update('data_harga', $inputData);
            $this->session->set_flashdata('message', 'Data di non aktifkan.');
            redirect('dashboard/price/');
        } else {
            $inputData = [
            'Status' => 1
          ];
            $this->db->where('Id', $id)->update('data_harga', $inputData);
            $this->session->set_flashdata('message', 'Data di aktifkan.');
            redirect('dashboard/price/');
        }
    }
    public function edit($id)
    {
        $dataDb = $this->db->where('Id', $id)->get('data_harga')->row();
        //  print_r(explode("/", $dataDb->FotoSlide));

        $data = [
                    'title' => 'Edit Harga',
                    'page' => 'edit',
                    'data' => $dataDb
                    ];
        $this->load->view('dashboard/price/PriceFormViews', $data);
    }
    public function update()
    {
        $Id = $this->input->post('Id');
        $Price = $this->input->post('Price');
        $Price2 = $this->input->post('Price2');
        $MarkUp = $this->input->post('MarkUp');
        $GroupName = $this->input->post('GroupName');
        $Status = $this->input->post('Status');
        $this->form_validation->set_rules('Price', 'Price', 'required');
        $this->form_validation->set_rules('Price2', 'Price2', 'required');
        $this->form_validation->set_rules('MarkUp', 'MarkUp', 'required');
        $this->form_validation->set_rules('Status', 'Status', 'required');
        if ($this->form_validation->run()) {
          $inputData = [
            'Price' => $Price,
            'Price2' => $Price2,
            'MarkUp' => $MarkUp,
            'GroupName' => $GroupName,
            'Status' => $Status,
          ];
          if ($this->db->where('Id',$Id)->update('data_harga', $inputData)) {
              $this->session->set_flashdata('message', 'Data berhasil diubah.');
              redirect('dashboard/price');
          } else {
              $this->session->set_flashdata('message', 'Data gagal diubah.');
              redirect('dashboard/price/edit/'.$Id.'');
          }
        } else {
            $this->session->set_flashdata('message', 'Data gagal diubah.');
            redirect('dashboard/price/edit/'.$Id.'');
        }
      }
}

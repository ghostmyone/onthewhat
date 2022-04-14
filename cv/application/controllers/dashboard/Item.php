<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
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
        $dataDb = $this->db->get('data_item')->result();
        $data = [
        'title' => 'List Item',
        'data' => $dataDb
        ];
        $this->load->view('dashboard/item/ItemViews', $data);
    }
    public function create()
    {
        $data = [
                    'title' => 'Add Item',
                    'page' => 'add'
                    ];
        $this->load->view('dashboard/item/ItemFormViews', $data);
    }

    public function submit()
    {
        $ItemName = $this->input->post('ItemName');
        $ItemSku = $this->input->post('ItemSku');
        $ItemPrice = $this->input->post('ItemPrice');
        $ProductCode = $this->input->post('ProductCode');
        $ItemStatus = $this->input->post('Status');
        $this->form_validation->set_rules('ItemName', 'ItemName', 'required');
        $this->form_validation->set_rules('ItemSku', 'ItemSku', 'required');
        $this->form_validation->set_rules('ItemPrice', 'ItemPrice', 'required');
        $this->form_validation->set_rules('ProductCode', 'ProductCode', 'required');
        $this->form_validation->set_rules('Status', 'Status', 'required');
        if ($this->form_validation->run()) {
            $inputData = [
              'ItemName' => $ItemName,
              'ItemSku' => $ItemSku,
              'ItemPrice' => $ItemPrice,
              'ProductCode' => $ProductCode,
              'ItemStatus' => $ItemStatus,
            ];
            if ($this->db->insert('data_item', $inputData)) {
                $this->session->set_flashdata('message', 'Data berhasil ditambahkan.');
                redirect('dashboard/item');
            } else {
                $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
                redirect('dashboard/item/create');
            }
        } else {
            $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
            redirect('dashboard/item/create');
        }
    }
    public function active($id)
    {
      $dataDb = $this->db->where('Id', $id)->get('data_item')->row();
      if ($dataDb->ProductStatus == 1) {
          $inputData = [
            'ItemStatus' => 0
          ];
          $this->db->where('Id', $id)->update('data_item', $inputData);
          $this->session->set_flashdata('message', 'Data di non aktifkan.');
          redirect('dashboard/product/');
      } else {
          $inputData = [
          'ItemStatus' => 1
        ];
          $this->db->where('Id', $id)->update('data_item', $inputData);
          $this->session->set_flashdata('message', 'Data di aktifkan.');
          redirect('dashboard/product/');
      }
    }
    public function edit($id)
    {
        $dataDb = $this->db->where('Id', $id)->get('data_item')->row();
        //  print_r(explode("/", $dataDb->FotoSlide));

        $data = [
                    'title' => 'Edit Item',
                    'page' => 'edit',
                    'data' => $dataDb
                    ];
        $this->load->view('dashboard/item/ItemFormViews', $data);
    }
    public function update()
    {
        $Id = $this->input->post('Id');
        $ItemName = $this->input->post('ItemName');
        $ItemSku = $this->input->post('ItemSku');
        $ItemPrice = $this->input->post('ItemPrice');
        $ProductCode = $this->input->post('ProductCode');
        $ItemStatus = $this->input->post('Status');
        $this->form_validation->set_rules('ItemName', 'ItemName', 'required');
        $this->form_validation->set_rules('ItemSku', 'ItemSku', 'required');
        $this->form_validation->set_rules('ItemPrice', 'ItemPrice', 'required');
        $this->form_validation->set_rules('ProductCode', 'ProductCode', 'required');
        $this->form_validation->set_rules('Status', 'Status', 'required');
        if ($this->form_validation->run()) {
          $inputData = [
            'ItemName' => $ItemName,
            'ItemSku' => $ItemSku,
            'ItemPrice' => $ItemPrice,
            'ProductCode' => $ProductCode,
            'ItemStatus' => $ItemStatus,
          ];
          if ($this->db->where('Id',$Id)->update('data_item', $inputData)) {
              $this->session->set_flashdata('message', 'Data berhasil diubah.');
              redirect('dashboard/item');
          } else {
              $this->session->set_flashdata('message', 'Data gagal diubah.');
              redirect('dashboard/product/edit/'.$Id.'');
          }
        } else {
            $this->session->set_flashdata('message', 'Data gagal diubah.');
            redirect('dashboard/product/edit/'.$Id.'');
        }
      }
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Slide extends CI_Controller
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
        $dataDb = $this->db->get('data_slide')->result();
        $data = [
        'title' => 'List Slide',
        'data' => $dataDb
        ];
        $this->load->view('dashboard/slide/SlideViews', $data);
    }
    public function create()
    {
        $data = [
                    'title' => 'Tambah Slide',
                    'page' => 'add'
                    ];
        $this->load->view('dashboard/slide/SlideFormViews', $data);
    }

    public function submit()
    {
        $NameSlide = $this->input->post('NameSlide');
        $DescSlide = $this->input->post('DescSlide');
        $StatusSlide = $this->input->post('StatusSlide');
        $this->form_validation->set_rules('NameSlide', 'NameSlide', 'required');
        $this->form_validation->set_rules('DescSlide', 'DescSlide', 'required');
        if ($this->form_validation->run()) {
            $config['upload_path']          = './assets/upload/home/slide';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $config['max_size']             = 10240;
            $config['encrypt_name']           = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('imageslide')) {
                $FotoSlide = base_url('assets/upload/home/slide/').$this->upload->data('file_name');
                $inputData = [
                  'NameSlide' => $NameSlide,
                  'DescSlide' => $DescSlide,
                  'FotoSlide' => $FotoSlide,
                  'StatusSlide' => $StatusSlide
                ];
                if ($this->db->insert('data_slide', $inputData)) {
                    $this->session->set_flashdata('message', 'Data berhasil ditambahkan.');
                    redirect('dashboard/slide');
                } else {
                    $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
                    redirect('dashboard/slide/create');
                }
            } else {
                $this->session->set_flashdata('message', $this->upload->display_errors());
                redirect('dashboard/slide/create');
            }
        } else {
            $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
            redirect('dashboard/slide/create');
        }
    }
    public function active($id)
    {
        $dataDb = $this->db->where('Id', $id)->get('data_slide')->row();
        if ($dataDb->StatusSlide == 1) {
            $inputData = [
              'StatusSlide' => 0
            ];
            $this->db->where('Id', $id)->update('data_slide', $inputData);
            $this->session->set_flashdata('message', 'Data di non aktifkan.');
            redirect('dashboard/slide/');
        } else {
            $inputData = [
            'StatusSlide' => 1
          ];
            $this->db->where('Id', $id)->update('data_slide', $inputData);
            $this->session->set_flashdata('message', 'Data di aktifkan.');
            redirect('dashboard/slide/');
        }
    }
    public function edit($id)
    {
        $dataDb = $this->db->where('Id', $id)->get('data_slide')->row();
        //  print_r(explode("/", $dataDb->FotoSlide));

        $imageName = explode("/", $dataDb->FotoSlide);
        $b64image = base64_encode(file_get_contents('assets/upload/home/slide/'.$imageName[7]));
        $newB64 = 'data:image/png;base64,'.$b64image;
        $data = [
                    'title' => 'Edit Slide',
                    'page' => 'edit',
                    'foto' => $newB64,
                    'data' => $dataDb
                    ];
        $this->load->view('dashboard/slide/SlideFormViews', $data);
    }
    public function update()
    {
        $NameSlide = $this->input->post('NameSlide');
        $Id = $this->input->post('Id');
        $DescSlide = $this->input->post('DescSlide');
        $StatusSlide = $this->input->post('StatusSlide');
        $this->form_validation->set_rules('NameSlide', 'NameSlide', 'required');
        $this->form_validation->set_rules('DescSlide', 'DescSlide', 'required');
        if ($this->form_validation->run()) {
            $config['upload_path']          = './assets/upload/home/slide';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $config['max_size']             = 10240;
            $config['encrypt_name']           = true;
            $this->load->library('upload', $config);
            if ($_FILES['imageslide']['name'] != null) {
                $this->upload->do_upload('imageslide');
                $FotoSlide = base_url('assets/upload/home/slide/').$this->upload->data('file_name');
                $inputData = [
                  'NameSlide' => $NameSlide,
                  'DescSlide' => $DescSlide,
                  'FotoSlide' => $FotoSlide,
                  'StatusSlide' => $StatusSlide
                ];
            } else {
                $inputData = [
                  'NameSlide' => $NameSlide,
                  'DescSlide' => $DescSlide,
                  'StatusSlide' => $StatusSlide
                ];
            }
            if ($this->db->where('Id', $Id)->update('data_slide', $inputData)) {
                $this->session->set_flashdata('message', 'Data berhasil diubah.');
                redirect('dashboard/slide');
            } else {
                $this->session->set_flashdata('message', 'Data gagal diubah.');
                redirect('dashboard/slide/edit/'.$Id.'');
            }
        } else {
            $this->session->set_flashdata('message', 'Data gagal diubah.');
            redirect('dashboard/slide/edit/'.$Id.'');
        }
    }
}

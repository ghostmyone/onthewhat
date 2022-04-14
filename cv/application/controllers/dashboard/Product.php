<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
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
        $dataDb = $this->db->get('data_product')->result();
        $data = [
        'title' => 'List Product',
        'data' => $dataDb
        ];
        $this->load->view('dashboard/product/ProductViews', $data);
    }
    // public function api()
    // {
    //     $WebsiteSetting = $this->db->get('data_setting')->row();
    //     $curl = curl_init();
    //     $postData = [
    //       'apiKey' => APIMV,
    //     ];
    //     curl_setopt_array($curl, array(
    //       CURLOPT_URL => "https://mvstore.id/api/getproduct",
    //       CURLOPT_RETURNTRANSFER => true,
    //       CURLOPT_ENCODING => "",
    //       CURLOPT_MAXREDIRS => 10,
    //       CURLOPT_TIMEOUT => 30,
    //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //       CURLOPT_CUSTOMREQUEST => "POST",
    //       CURLOPT_POSTFIELDS => $postData,
    //       CURLOPT_HTTPHEADER => array(
    //         "cache-control: no-cache",
    //         "content-type: multipart/form-data;",
    //       ),
    //     ));
    //
    //     $responseData = json_decode(curl_exec($curl));
    //     if (!$responseData->status) {
    //       echo "FAILED";
    //       exit();
    //     };
    //     $response = json_decode(curl_exec($curl));
    //     $dataJson = $response->data;
    //     curl_close($curl);
    //     $data = [
    //     'title' => 'List Product',
    //     'data' => $dataJson
    //     ];
    //     $this->load->view('dashboard/product/ProductApiViews', $data);
    // }
    public function create()
    {
        $data = [
                    'title' => 'Add Product',
                    'page' => 'add'
                    ];
        $this->load->view('dashboard/product/ProductFormViews', $data);
    }

    public function submit()
    {
        $ProductName = $this->input->post('ProductName');
        $ProductCode = $this->input->post('ProductCode');
        $ProductTutor = $this->input->post('ProductTutor');
        $ProductLink = $this->input->post('ProductLink');
        $Status = $this->input->post('Status');
        $ProductType = $this->input->post('ProductType');
        $ProductCat = $this->input->post('ProductCat');
        $this->form_validation->set_rules('ProductName', 'ProductName', 'required');
        $this->form_validation->set_rules('ProductCode', 'ProductCode', 'required');
        $this->form_validation->set_rules('ProductTutor', 'ProductTutor', 'required');
        $this->form_validation->set_rules('ProductLink', 'ProductLink', 'required');
        $this->form_validation->set_rules('ProductCat', 'ProductCat', 'required');
        if ($this->form_validation->run()) {
            $config['upload_path']          = './assets/upload/home/product';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $config['max_size']             = 10240;
            $config['encrypt_name']           = true;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('ImageUpload')) {
                $ImageUpload = base_url('assets/upload/home/product/').$this->upload->data('file_name');
                $inputData = [
                  'ProductName' => $ProductName,
                  'ProductCode' => $ProductCode,
                  'ProductTutor' => $ProductTutor,
                  'ProductLink' => $ProductLink,
                  'ProductImage' => $ImageUpload,
                  'ProductStatus' => $Status,
                  'ProductType' => $ProductType,
                  'ProductCat' => $ProductCat,
                ];
                if ($this->db->insert('data_product', $inputData)) {
                    $this->session->set_flashdata('message', 'Data berhasil ditambahkan.');
                    redirect('dashboard/product');
                } else {
                    $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
                    redirect('dashboard/product/create');
                }
            } else {
                $this->session->set_flashdata('message', $this->upload->display_errors());
                redirect('dashboard/product/create');
            }
        } else {
            $this->session->set_flashdata('message', 'Data gagal ditambahkan.');
            redirect('dashboard/product/create');
        }
    }
    public function active($id)
    {
        $dataDb = $this->db->where('Id', $id)->get('data_product')->row();
        if ($dataDb->ProductStatus == 1) {
            $inputData = [
              'ProductStatus' => 0
            ];
            $this->db->where('Id', $id)->update('data_product', $inputData);
            $this->session->set_flashdata('message', 'Data di non aktifkan.');
            redirect('dashboard/product/');
        } else {
            $inputData = [
            'ProductStatus' => 1
          ];
            $this->db->where('Id', $id)->update('data_product', $inputData);
            $this->session->set_flashdata('message', 'Data di aktifkan.');
            redirect('dashboard/product/');
        }
    }
    public function edit($id)
    {
        $dataDb = $this->db->where('Id', $id)->get('data_product')->row();
        //  print_r(explode("/", $dataDb->FotoSlide));

        $imageName = explode("/", $dataDb->ProductImage);
        $b64image = base64_encode(file_get_contents($dataDb->ProductImage));
        $newB64 = 'data:image/png;base64,'.$b64image;
        $data = [
                    'title' => 'Edit Slide',
                    'page' => 'edit',
                    'foto' => $newB64,
                    'data' => $dataDb
                    ];
        $this->load->view('dashboard/product/ProductFormViews', $data);
    }
    public function update()
    {
        $Id = $this->input->post('Id');
        $ProductName = $this->input->post('ProductName');
        $ProductCode = $this->input->post('ProductCode');
        $ProductTutor = $this->input->post('ProductTutor');
        $ProductLink = $this->input->post('ProductLink');
        $Status = $this->input->post('Status');
        $ProductType = $this->input->post('ProductType');
        $ProductCat = $this->input->post('ProductCat');
        $this->form_validation->set_rules('ProductName', 'ProductName', 'required');
        $this->form_validation->set_rules('ProductCode', 'ProductCode', 'required');
        $this->form_validation->set_rules('ProductTutor', 'ProductTutor', 'required');
        $this->form_validation->set_rules('ProductLink', 'ProductLink', 'required');
        $this->form_validation->set_rules('ProductCat', 'ProductCat', 'required');
        if ($this->form_validation->run()) {
            $config['upload_path']          = './assets/upload/home/product';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $config['max_size']             = 10240;
            $config['encrypt_name']           = true;
            $this->load->library('upload', $config);
            if ($_FILES['ImageUpload']['name'] != null) {
                $this->upload->do_upload('ImageUpload');
                $ImageUpload = base_url('assets/upload/home/product/').$this->upload->data('file_name');
                $inputData = [
                  'ProductName' => $ProductName,
                  'ProductCode' => $ProductCode,
                  'ProductTutor' => $ProductTutor,
                  'ProductLink' => $ProductLink,
                  'ProductImage' => $ImageUpload,
                  'ProductStatus' => $Status,
                  'ProductType' => $ProductType,
                  'ProductCat' => $ProductCat,
                ];
            } else {
              $inputData = [
                'ProductName' => $ProductName,
                'ProductCode' => $ProductCode,
                'ProductTutor' => $ProductTutor,
                'ProductLink' => $ProductLink,
                'ProductStatus' => $Status,
                'ProductType' => $ProductType,
                'ProductCat' => $ProductCat,
              ];
            }
            if ($this->db->where('Id', $Id)->update('data_product', $inputData)) {
                $this->session->set_flashdata('message', 'Data berhasil diubah.');
                redirect('dashboard/product');
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

<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Register_creator extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->helper(array('form', 'url'));

        // $this->load->library('upload');

    }

    public function index()

    {

         if ($this->session->userdata('logged_in')){
        redirect('Welcome');
        } else {

        $this->load->view('v_register_creator');
        }
    }



    public function reg_crea()

    {





        $this->load->model('register_model');

        $id = $this->input->post('nim');

        $nama = $this->input->post('nama');

        $username = $this->input->post('username');

        $password = $this->input->post('password');

        $repass = $this->input->post('repass');

        $foto = "assets/user/$username.jpg";

        $tanggal = $this->input->post('tanggal');

        $email = $this->input->post('email');



        $users_exist = $this->register_model->user_exist_creator($id);







        if ($password != $repass) {

            $this->session->set_flashdata('err_message', 'Password doesnt match');

            redirect('register');

        } elseif (count($users_exist) >= 1) {

            $this->session->set_flashdata('err_message', 'username already exist');

            redirect('register');

        } else {

            $config['upload_path']          = './assets/user';

            $config['allowed_types']        = 'gif|jpg|png';

            $config['file_name']            = $username;

            $config['overwrite']            = TRUE;

            //  $config['max_size']             = 100;

            //   $config['max_width']            = 1024;

            //   $config['max_height']           = 768;



            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            $this->upload->do_upload('userfile');

            //  if (!$this->upload->do_upload('userfile')) {

            //  $this->session->set_flashdata('err_message', 'Please Try Again');

            //   redirect('register');

            // } else {

            //  $data = array('upload_data' => $this->upload->data());

            $this->register_model->set_creator($id, $nama, $username, $password, $foto, $tanggal, $email);

            redirect('login');

            // }



            //upload file



            //end upload file



        }

    }

}


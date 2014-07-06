<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class indeks extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('html', 'url', 'form', 'captcha'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<div id="form_error">', '</div>');
        $this->load->database();
        $this->load->model(array('user_model'));
    }

    public function index() {
        $d['content'] = 'guest/home.php';
        $this->load->view('templateuser',$d);
    }

    public function admin() {
        if ($this->session->userdata('level_user') == 1) {
            $d['content'] = 'admin/home.php';
            $this->load->view('template',$d);
        } else {
            $this->index();
        }
    }
    
    

}

?>

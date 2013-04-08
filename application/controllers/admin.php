<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function index(){
		$data['message'] = $this->input->get('message');
		if($this->session->userdata('admin')){
			//load the main page
			$this->load->view('admin/admin_main', $data);
		}
		else{
			redirect('/admin/login?message='.urlencode($data['message']));
		}
	}

	function login(){
		if($this->session->userdata('admin')){
			redirect('/admin');
		}
		else{
			$data['message'] = $this->input->get('message');
			$this->load->view('admin/admin_login', $data);
		}
	}

	function log_admin(){
		if($this->session->userdata('admin')){
			redirect('/admin');
		}
		elseif($this->input->post('submit')){
			//log the admin if the credentials match
			$result = $this->madmin->login();
			$message = ($result===TRUE)?'Logged in successfully':$result;
			redirect('/admin?message='.urlencode($message));
		}
		else{
			redirect('/admin/login');
		}
	}

	function log_out(){
		$this->session->sess_destroy();
		$message = 'You have been logged out';
		redirect('/admin/login?message='.urlencode($message));
	}
}

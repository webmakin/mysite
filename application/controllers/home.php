<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		//get common data
		$data =  $this->mhome->get_common_data();
		$data['title'] = 'Home';
		$data['motto'] = $this->mhome->get_motto();
		$data['slideshow'] =  $this->mhome->get_slideshow();
		$data['recent'] = $this->mhome->get_recent();
		$this->load->view('home_page', $data);
	}
	
	function get($link){
		//get common data
		if($link==='home'){
			redirect('/home');
		}
		elseif($link==='blog'){
			//redirect to tumblr blog
			redirect('http://webmakin.tumblr.com/');
		}
		elseif($link=='contact'){
			redirect('/home/contact');
		}
		else{
			$data =  $this->mhome->get_common_data();
			$data['title'] = $this->mhome->get_title($link); 
			$data['the_data'] =  $this->mhome->get_data($link); 
			$this->load->view('get_main_page', $data);
		}
	}
	
	//func to get page for the id  passed
	function page($id){
		if($id==0){
			//redirect to learning section
			redirect('/learning');
		}
		else{
			$data =  $this->mhome->get_common_data();
			$data['title'] = $this->mhome->get_page_title($id); 
			$data['the_data'] =  $this->mhome->get_page_data($id); 
			$data['similar'] =  $this->mhome->get_similar_pages($id); 
			$this->load->view('get_page', $data);
		}
	}
	
	//func for contact page
	function contact(){
		$data =  $this->mhome->get_common_data();
		$data['title'] = 'Contact us'; 
		$data['address'] =  $this->mhome->get_address();
		$data['phone'] =  $this->mhome->get_phone();
		$data['email'] = $this->mhome->get_email();
		$data['notification'] =  $this->input->get('notification');
		$data['message'] = $this->input->get('message');
		$this->load->view('contact_page', $data);
	}
	
	//func to send the contact page data by email
	function save(){
		if($this->input->post('submit')){
			$result = $this->mhome->send_contact_data();
			if($result === TRUE){
				$message = 'Thank you contacting us. We will revert soon.';
				$not = 'success';
			}
			else{
				$message = $result;
				$not = 'error';
			}
			redirect('/home/contact?message='.urlencode($message).'&notification='.urlencode($not));
		}
		else{
			redirect('/home');
		}
	}

}

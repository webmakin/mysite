<?php

class Mhome extends CI_Model{
	//func to get the common data across pages 
	function get_common_data(){
		$query = $this->db->get('logo_motto_copyright');
		$array = $query->row_array();
		$result['logo'] = $array['logo'];
		$query = $this->db->get('main_nav');
		$nav = $query->result_array();
		foreach($nav as $key=>$value){
			if($this->mhome->has_sub($value['id'], 'sub')){
				$nav[$key]['subs'] = $this->mhome->has_sub($value['id'], 'sub', 'get');
				foreach($nav[$key]['subs'] as $newk => $newv){
					if($this->mhome->has_sub($newv['id'], 'super_sub')){
						$nav[$key][$newk]['super_subs'] = $this->mhome->has_sub($newv['id'], 'super_sub', 'get');
					}	
				}
									
			}
		}
		$result['nav'] = $nav;
		$result['copyright'] = $array['copyright']; 
		return $result;
	}
	
	//check if subnaviagtion or supersub exists
	function has_sub($id, $what, $get=NULL){
		if($what==='sub'){
			$check_id = 'main_nav_id';
			$table = 'sub_nav';
		}	
		else{
			$check_id = 'sub_nav_id';
			$table = 'super_sub_nav';
		}
		$this->db->where($check_id, $id);
		$query = $this->db->get($table);
		if(($query->num_rows()>0)&&(!is_null($get))){
			return $query->result_array();	
		}
		elseif($query->num_rows()>0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	//func to get the motto
	function get_motto(){
		$query = $this->db->get('logo_motto_copyright');
		$array = $query->row_array();
		return $array['motto'];
	}	
	
	//func to get_slideshow
	function get_slideshow(){
		$query = $this->db->get('slideshow');
		return $query->result_array();
	}
	
	//func to get 6 of the recent portfolio items
	function get_recent(){
		$this->db->limit(6);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('portfolio');
		return $query->result_array();
	}
	
	//func to get data for the link passed
	function get_data($link){
		//get the main nav id
		$nav_id = $this->mhome->get_main_nav_id($link);
		if($link === 'portfolio'){
			$query = $this->db->get('portfolio');	
		}
		else{
			$this->db->where('main_nav_id', $nav_id);
			$query = $this->db->get('pages');		
		}		
		return $query->result_array();
	}
	
	//func to get title for the link passed
	function get_title($link){
		$this->db->where('link', $link);
		$query = $this->db->get('main_nav');
		$array = $query->row_array();
		return $array['title'];
	}
	
	//func to return thge main nav id for the link passed
	function get_main_nav_id($link){
		$this->db->where('link', $link);
		$query = $this->db->get('main_nav');
		$array = $query->row_array();
		return $array['id'];
	}
	
	//func to get_page_title for the id passed
	function get_page_title($id){
		$this->db->where('id', $id);
		$query = $this->db->get('pages');
		$array = $query->row_array();
		return $array['title'];
	}
	
	//func to get_page_data for the id passed
	function get_page_data($id){
		$this->db->where('id', $id);
		$query = $this->db->get('pages'); 
		return $query->row_array();
	}
	
	//func to get_similar_pages
	function get_similar_pages($id){
		$this->db->where('page_id', $id);
		$query = $this->db->get('sub_nav');
		if($query->num_rows()>0){
			//get the remaining subs
			$this->db->where('page_id !=', $id);
			$query = $this->db->get('sub_nav');
		}
		else{
			//check the super sub
			$this->db->where('page_id', $id);
			$query = $this->db->get('super_sub_nav');
			if($query->num_rows()>0){
				$array = $query->row_array();
				$this->db->where('sub_nav_id', $array['sub_nav_id']);
				$this->db->where('page_id !=', $id);
				$query = $this->db->get('super_sub_nav');
			}
		}
		$array = $query->result_array();
		foreach($array as $key=>$value){
			$array[$key]['thumbnail'] = $this->mhome->get_thumbnail($value['page_id']);
		}
		return $array;
	}
	
	//func to get thumbnail for the page id passed
	function get_thumbnail($id){
		$this->db->where('id', $id);
		$query = $this->db->get('pages');
		$array = $query->row_array();
		return $array['thumbnail'];
	}
	
	//func to get_address
	function get_address(){
		$this->db->select('address');
		$query = $this->db->get('contact');
		$array = $query->result_array();
		foreach($array as $key=>$value){
			if(!empty($value['address'])){
				$return[$key] = $value['address'];
			}
		}
		return $return;
	}
	
	//func to get_phone
	function get_phone(){
		$this->db->select('phone');
		$query = $this->db->get('contact');
		$array = $query->result_array();
		foreach($array as $key=>$value){
			if(!empty($value['phone'])){
				$return[$key] = $value['phone'];
			}
		}
		return $return;
	}
	
	//func to get_email
	function get_email(){
		$this->db->select('email');
		$query = $this->db->get('contact');
		$array = $query->result_array();
		foreach($array as $key=>$value){
			if(!empty($value['email'])){
				$return[$key] = $value['email'];
			}
		}
		return $return;
	}
	
	//func to send_contact_data
	function send_contact_data(){
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'required|xss_clean');
		if($this->form_validation->run()===FALSE){
			return validation_errors();
		}
		else{
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$message = $this->input->post('message');
			//send email
			$this->email->from($email, $name);
			$this->email->to('webmakin@gmail.com');
			$this->email->subject('Contact form on webmak.in');
			$this->email->message($message);
			$this->email->send();	
			$this->email->clear();	
			$this->email->from('webmakin@gmail.com', 'Mohammed Asif');
			$this->email->to($email);
			$this->email->subject('Thank you for contacting.');
			$message = "Hello,".$name."\n".
						"We have received the form with your message. We will get in touch with you shortly."."\n\n".
						"If you have received this email by mistake or you have not filled any form on the site http://webmak.in"."\n".
						"Please send a blank reply and discard this email."."\n".
						"Thank you,"."\n".
						"Asif,"."\n".
						"Webmak.in";
			$this->email->message($message);
			$this->email->send();	
			return TRUE;
		}
	}
}
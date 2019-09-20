<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		$this->load->view('user');
	}
        public function login()
	{
            
		$this->load->view('login', ['addcss' =>'login.css']);
	}
        public function register()
	{
		$this->load->view('register');
	}
}

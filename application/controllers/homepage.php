<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->kindling->content('title_appendage', 'CodeIgniter Boilerplate with Kindling!');

		$this->kindling->css('h1 { font-family: Arial; }');

		$this->kindling->meta('author', 'Kevin Wood-Friend');
	}

	public function index()
	{
		$this->kindling->content('title', 'Welcome to the Homepage');

		$this->kindling->content('primary', $this->load->view('homepage', NULL, TRUE));

		$this->kindling->render();
	}

}


# EOF
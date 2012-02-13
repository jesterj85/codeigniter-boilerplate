<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$kin =& $this->kindling;

		$kin->content('title_appendage', 'CodeIgniter Boilerplate with Kindling!');
		$kin->css('h1 { font-family: Arial; }');
	}

	public function index()
	{
		$kin =& $this->kindling;

		$kin->content('title', 'Welcome to the Homepage');

		$kin->content('primary', $this->load->view('homepage', NULL, TRUE));

		$kin->render();
	}

}

# EOF
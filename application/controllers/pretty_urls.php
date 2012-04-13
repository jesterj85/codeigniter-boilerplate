<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pretty_urls extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->kindling->content('title_appendage', 'CodeIgniter Boilerplate with Kindling!');

		$this->kindling->css('h1 { font-family: Arial; }');

		$this->kindling->meta('author', 'Kevin Wood-Friend');
	}

	public function index()
	{
		$this->kindling->content('title', 'Pretty URLs :o)');

		$this->kindling->content('primary', $this->load->view('pretty_urls', NULL, TRUE));

		$this->kindling->render();
	}

	public function this_works()
	{
		$this->kindling->content('title', 'Pretty URLs :o)');

		$this->kindling->content('primary', $this->load->view('pretty_urls', NULL, TRUE));

		$this->kindling->render();
	}

}


# EOF
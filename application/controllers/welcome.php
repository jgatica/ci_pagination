<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("display_errors", "2");
ERROR_REPORTING(E_ALL);
class Welcome extends CI_Controller 
{
	public function __construct()
	{
		parent:: __construct();
		$this->load->model('search_model');
		$this->load->library('pagination');
	}


	public function index()
	{
		$this->load->view('welcome_message');
	}
	
	public function example1()
	{
		$this->session->unset_userdata('searchterm');
		$config['base_url'] = base_url() . 'welcome/example1';
		$config['total_rows'] = $this->search_model->record_count();
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$choice = $config['total_rows']/$config['per_page'];
		$config['num_links'] = round($choice);		
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;

		$data['results'] = $this->search_model->fetch_countries($config['per_page'],$page);
		$data['links'] = $this->pagination->create_links();
		$this->load->view('example1',$data);
	}
	
	public function search()
	{
		$searchterm = $this->search_model->searchterm_handler($this->input->get_post('searchterm', TRUE));
		$limit = ($this->uri->segment(3) > 0)?$this->uri->segment(3):0;
		
		$config['base_url'] = base_url() . 'welcome/search';
		$config['total_rows'] = $this->search_model->search_record_count($searchterm);
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$choice = $config['total_rows']/$config['per_page'];
		$config['num_links'] = round($choice);		
		$this->pagination->initialize($config);
		
		$data['results'] = $this->search_model->search($searchterm,$limit);
		$data['links'] = $this->pagination->create_links();
		$data['searchterm'] = $searchterm;
		$this->load->view('search',$data);
		
	}
	
	public function example()
	{
		$searchterm = $this->input->get_post('searchterm', TRUE);
		$limit = ($this->uri->segment(3) > 0)?$this->uri->segment(3):0;
		
		$config['base_url'] = base_url() . 'welcome/search';
		$config['total_rows'] = $this->search_model->search_record_count($searchterm);
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$choice = $config['total_rows']/$config['per_page'];
		$config['num_links'] = round($choice);		
		$this->pagination->initialize($config);
		
		$data['results'] = $this->search_model->search($searchterm,$limit);
		$data['links'] = $this->pagination->create_links();
		$data['searchterm'] = $searchterm;
		$this->load->view('search',$data);
		
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
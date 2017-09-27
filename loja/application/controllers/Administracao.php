<?php defined('BASEPATH') OR exit('No direct  script  access  allowed');
  class Administracao extends CI_Controller{
  		public $categorias;
		public function __construct(){
			parent::__construct();	
			$this->load->model('categorias_model','modelcategorias');
			$this->categorias = $this->modelcategorias->listar_categorias();	
		}  
		public function index(){
		$this->load->helper('text');
		$data_header['categorias'] = $this->categorias;
		$this->load->view('html-header',$data_header);
		$this->load->view('Adm/headerAdm');
		$this->load->view('Adm/administracao');
		$this->load->view('footer');
		$this->load->view('html-footer');		
		}
		
		public function categorias(){
			$this->load->helper('text');
			$data_header['categorias'] = $this->categorias;
			$this->load->view('html-header',$data_header);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/categorias',$data_header);
			$this->load->view('footer');
			$this->load->view('html-footer');	
		}
	}
<?php defined('BASEPATH') OR exit('No direct  script  access  allowed');
  class FreteAdm extends CI_Controller{
  		public $categorias;
		public function __construct(){
			parent::__construct();	
			$this->load->model('fretes_model','modelfretes');
			$this->fretes = $this->modelfretes->listar_fretes();
		}
		
		public function index(){
			$data_header['fretes'] = $this->fretes;
			$this->load->view('html-header',$data_header);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/fretes',$data_header);
			$this->load->view('footer');
			$this->load->view('html-footer');
		}
		
		public function editFrete($id){
			$this->load->helper('text');
			$data_frete['frete'] = $this->modelfretes->detalhes_fretes($id);
			$this->load->view('html-header',$data_frete);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/editFrete',$data_frete);
			$this->load->view('footer');
			$this->load->view('html-footer');	
		}
		
		public function alterarFrete(){			
			$dados['peso_de'] = $this->input->post('txt_peso_de');
			$dados['peso_ate'] = $this->input->post('txt_peso_ate');
			$dados['preco'] = $this->input->post('txt_preco');
			$dados['adicional_kg'] = $this->input->post('txt_adicional_kg');
			$dados['uf'] = $this->input->post('txt_uf');
			$this->db->where('id',$this->input->post('txt_id'));
			if($this->db->update("tb_transporte_preco",$dados)){
				echo '
					<html> <body>
					<script>
						alert("Alterações efetuadas");
						window.location = ("'.base_url().'FreteAdm");
					</script>
					</body> </html>';	
			}
			
		}
		
		public function excFrete($id){
			$this->db->where('id',$id);
			if($this->db->delete('tb_transporte_preco')){
				echo '
					<html> <body>
					<script>
						alert("Frete excluido");
						window.location = ("'.base_url().'FreteAdm");
					</script>
					</body> </html>';				
			}
		}
		
		public function novoFrete(){
			$data_header['fretes'] = $this->fretes;
			$this->load->view('html-header',$data_header);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/addFrete');
			$this->load->view('footer');
			$this->load->view('html-footer');
		}
		public function inserirFrete(){
			$dados['peso_de'] = $this->input->post('txt_peso_de');
			$dados['peso_ate'] = $this->input->post('txt_peso_ate');
			$dados['preco'] = $this->input->post('txt_preco');
			$dados['adicional_kg'] = $this->input->post('txt_adicional_kg');
			$dados['uf'] = $this->input->post('txt_uf');
			$this->db->where('id',$this->input->post('txt_id'));
			if($this->db->insert("tb_transporte_preco",$dados)){
				echo '<html> <body>				
					<script>
						alert("Frete Adicionado");
						window.location = ("'.base_url().'FreteAdm");
					</script>
					</body> </html>';	
			}
		}
			
	}
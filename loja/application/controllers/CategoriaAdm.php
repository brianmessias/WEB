<?php defined('BASEPATH') OR exit('No direct  script  access  allowed');
  class CategoriaAdm extends CI_Controller{
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
			$this->load->view('Adm/categorias',$data_header);
			$this->load->view('footer');
			$this->load->view('html-footer');	
		}
		
		public function editCategoria($id){
			$this->load->helper('text');
			$data_header['categorias'] = $this->categorias;
			$data_categoria['categoria'] = $this->modelcategorias->detalhes_categorias($id);
			$this->load->view('html-header',$data_header);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/editCategoria',$data_categoria);
			$this->load->view('footer');
			$this->load->view('html-footer');
		}
		
		public function excCategoria($id){
			$this->db->where('categoria',$id);
			$categoria = $this->db->get("produtos_categoria")->result();
			if(count($categoria) ==0){
				$this->db->where('id',$id);
				if(!$this->db->delete('categorias')) {
					echo "Não foi possível deletar os dados.";
				}else{
					redirect("categoriaAdm");
				}	
			}else {
				echo '
					<html> <body>
					<script>
						alert("Não foi possível excluir categoria. Há um produto vinculado");
						window.location = ("'.base_url().'categoriaAdm");
					</script>
					</body> </html>';			
			}
			
		}	
		
		public function alterarCategoria(){
			$data['titulo'] = $this->input->post('txt_titulo');
			$data['descricao'] = $this->input->post('txt_descricao');
			$this->db->where('id',$this->input->post('id'));
			if(!$this->db->update('categorias',$data)){
				echo "Não foi possível alterar os dados";
			}
			redirect("categoriaAdm");
		}
		
		public function novaCategoria(){
			$this->load->helper('text');
			$data_header['categorias'] = $this->categorias;
			$this->load->view('html-header',$data_header);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/novaCategoria');
			$this->load->view('footer');
			$this->load->view('html-footer');
		}
		
		public function incluirCategoria(){
			$data['titulo'] = $this->input->post('txt_titulo');
			$data['descricao'] = $this->input->post('txt_descricao');
			if(!$this->db->insert('categorias',$data)){
				echo '
					<html> <body>
					<script>
						alert("Erro ao incluir nova categoria. Tente novamente");
						window.location = ("'.base_url().'categoriaAdm");
					</script>
					</body> </html>';				
			}else{
				redirect("categoriaAdm");			
			}
		}
	}
<?php defined('BASEPATH') OR exit('No direct  script  access  allowed');
  class ProdutoAdm extends CI_Controller{
  		public $categorias;
		public function __construct(){
			parent::__construct();	
			$this->load->model('produtos_model','modelprodutos');
			$this->produtos = $this->modelprodutos->listar_produtos();
			$this->load->model('categorias_model','modelcategorias');
			$this->categorias = $this->modelcategorias->listar_categorias();
		}
		
		public function index(){
			$this->load->helper('text');
			$data_header['produtos'] = $this->produtos;
			$this->load->view('html-header',$data_header);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/produtos',$data_header);
			$this->load->view('footer');
			$this->load->view('html-footer');
		}
		public function editProduto($id){
			$this->load->helper('text');
			$data_header['produtos'] = $this->produtos;
			$data_produto['produto'] = $this->modelprodutos->detalhes_produto($id);
			$data_produto['categoriasT'] = $this->modelprodutos->listar_produtos_categoria($id);
			$data_produto['categorias'] = $this->categorias;
			$this->load->view('html-header',$data_header);
			$this->load->view('Adm/headerAdm');
			$this->load->view('Adm/editProduto',$data_produto);
			$this->load->view('footer');
			$this->load->view('html-footer');
		}
		public function alterarProduto(){
			$categorias['categorias'] = $this->input->post('categorias');
			$this->db->where('produto',$this->input->post('txt_id'));
			$this->db->delete("produtos_categoria");
			$dadosC['produto'] = $this->input->post('txt_id');
			foreach($categorias['categorias'] as $dado){
				$dadosC['categoria'] = $dado;
				$this->db->insert('produtos_categoria',$dadosC);								
			}
			$dados['codigo'] = $this->input->post('txt_codigo');
			$dados['titulo'] = $this->input->post('txt_titulo');
			$dados['descricao'] = $this->input->post('txt_descricao');		
			$dados['preco'] = $this->input->post('txt_preco');
			$dados['largura_caixa_mm'] = $this->input->post('txt_largura');
			$dados['altura_caixa_mm'] = $this->input->post('txt_altura');
			$dados['comprimento_caixa_mm'] = $this->input->post('txt_comprimento');
			$dados['peso_gramas'] = $this->input->post('txt_peso');
			$dados['ativo'] = $this->input->post('txt_ativo');
			$this->db->where('id',$this->input->post('txt_id'));
			if($this->db->update('produtos',$dados)){
				echo '
					<html> <body>
					<script>
						alert("Alterações efetuadas");
						window.location = ("'.base_url().'ProdutoAdm");
					</script>
					</body> </html>';		
			}else{
				echo '
					<html> <body>
					<script>
						alert("Erro ao efetuar as alterações. Tente Novamente");
						window.location = ("'.base_url().'ProdutoAdm");
					</script>
					</body> </html>';
			}			
			
	}
	public function excProduto($id){
				$this->db->where("produto", $id);
				$this->db->delete("produtos_categoria");
				$this->db->where("id",$id);
				if($this->db->delete("produtos")){
					echo '
					<html> <body>
					<script>
						alert("Produto deletado");
						window.location = ("'.base_url().'ProdutoAdm");
					</script>
					</body> </html>';			
				}
	}
	
	public function novoProduto(){
		$this->load->helper('text');
		$data_header['produtos'] = $this->produtos;
		$data_produto['categorias'] = $this->categorias;
		$this->load->view('html-header',$data_header);
		$this->load->view('Adm/headerAdm');
		$this->load->view('Adm/addProduto',$data_produto);
		$this->load->view('footer');
		$this->load->view('html-footer');
	}
	
	public function inserirProduto(){
			$dados['codigo'] = $this->input->post('txt_codigo');
			$dados['titulo'] = $this->input->post('txt_titulo');
			$dados['descricao'] = $this->input->post('txt_descricao');		
			$dados['preco'] = $this->input->post('txt_preco');
			$dados['largura_caixa_mm'] = $this->input->post('txt_largura');
			$dados['altura_caixa_mm'] = $this->input->post('txt_altura');
			$dados['comprimento_caixa_mm'] = $this->input->post('txt_comprimento');
			$dados['peso_gramas'] = $this->input->post('txt_peso');
			$dados['ativo'] = $this->input->post('txt_ativo');
			$this->db->where('id',$this->input->post('txt_id'));			
				
			if($this->db->insert('produtos',$dados)){
			
					$categorias['categorias'] = $this->input->post('categorias');
					$this->db->where("codigo", $dados['codigo']);	
					$id = $this->db->get('produtos')->result();
					foreach($categorias['categorias'] as $categoria){
						$dadosC["produto"] = $id[0]->id;
						$dadosC['categoria'] = $categoria;
						$this->db->insert("produtos_categoria",$dadosC);
					}
						echo '
								<html> <body>
									<script>
										alert("Produto Adicionado");
										window.location = ("'.base_url().'ProdutoAdm");
									</script>
								</body> </html>';			
				
					
			}
	}
}
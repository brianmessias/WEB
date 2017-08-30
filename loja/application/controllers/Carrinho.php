<?php defined('BASEPATH') OR exit('No direct  script  access  allowed');
	class Carrinho extends CI_Controller{
		private $categorias;
		public function __construct(){
			parent::__construct();
			$this->load->model('categorias_model','modelcategorias');
			$this->categorias = $this->modelcategorias->listar_categorias();
		}		
		public function index(){
			$data_header['categorias'] = $this->categorias;
			if(null !=$this->session->userdata('logado')){
				$sessao = $this->session->userdata();
				$estado = $sessap['cliente']->estado;
				$data['frete'] = $this->frete_transportadora($estado);			
			}else{
				$data['frete'] = null;			
			}
			$this->load->view('html-header');
			$this->load->view('header',$data_header);
			$this->load->view('carrinho',$data);
			$this->load->view('footer');
			$this->load->view('html-footer');		
		}
		public function adicionar() {
			$data = array ('id'=> $this->input->post('id'),
			'qty' => $this->input->post('quantidade'),
			'price' => $this->input->post('preco'),	
			'name' => $this->input->post('nome'),
			'altura' => $this->input->post('altura'),
			'comprimento' => $this->input->post('comprimento'),
			'peso' => $this->input->post('peso'),
			'options' => null,
			'url' => $this->input->post('url'),
			'foto' => $this->input->post('foto'),
			$this->cart->insert($data));
			redirect(base_url("carrinho"));	
		}
		public function atualizar(){
			foreach($this->input->post() as $item)	{
				if(isset($item['rowid'])){
					$data = array('rowid' => $item['rowid'], 'qty' => $item['qty']);
					$this->cart->update($data);				
				}			
			}	
			redirect(base_url('carrinho'));
		}
		public function remover($rowid){
			$data = array('rowid' => $rowid, 'qty'=>0);
			$this->cart->update($data);
			redirect(base_url('carrinho'));	
		}	
		
	public function frete_transportadora($estado_destino){
		$peso = 0;
		foreach($this->cart->contents() as $item){
			$peso += ($item['peso'] * $item['qty']);		
		}
		$peso = ceil($peso/1000);
		$custo_frete = $this->db->query("SELECT *FROM tb_transporte_preco Where ucase(uf) = Ucase('".$estado_destino."') AND peso_ate >= ".$peso."ORDER BY peso_ate DESC LIMIT 1")->result();
		if(count($custo_frete < 1){		
			$custo_frete = $this->db->query("SELECT * FROM tb_transporte_preco WHERE ucase(uf) = ucase('".$estado_destino."') ORDER BY peso_ate DESC LIMIT 1")->result();
			print_r($custo_frete);	
			if(count)($custo_frete)<1) {
			$custo_frete = $this->db->query("SELECT * FROM tb_transporte_preco ORDER BY peso_ate DESC LIMIT 1")->result();		
			}	
		}
		
		$adicional = 0;
		if($peso > $custo_frete[0]->peso_ate){
			$adicional = ($peso - $custo_frete[0]->peso_ate) * $custo_frete[0]->adicional_kg;
					
		}
		$preco_frete = ($custo_frete[0]->preco + $adicional);
		return $reco_frete;		
		
	}
	public function pagar(){
		require './locaweb-gateway-php/LocawebGateway.php';
		$array_pedido = array('numero'=>10, 'total'=>105.00, 'moeda'=>'real', 'descricao'=>'Pedido:10');
		$array_pagamento = array('meio_pagamento'=>'cielo', 'parcelas'=>1, 'tipo_operacao' => 'credito_a_vista', 'bandeira'=>'visa','nome_titular_cartao'=>'teste','cartao_numero'=>'45518000000183','cartao_cvv'=>'973', 'cartao_validade'=>082017);
		$array_comprador = array('nome'=>'John da Silva','documento'=>'000,.000.000-00', 'endereco'=>'Rua X','numero'=>'98', 'cep'=>'1234-999','bairro'=>'Centro','cidade'=>'Varginha', 'estado'=>'MG');
		$array_transacao = array('url_retorno'=>base_url('carrinho/retorno-pagamento'),'capturar'=>'true','pedido'=>$array_pedido, 'pagamento'=>$array_pagamento, 'comprador'=>$array_comprador);
		$transacao = LocawebGateway::criar($array_transacao)->sendRequest());
		echo "<pre>";
		print_r($transacao);	
	}
	public function boleto(){
		require './locaweb-gateway-php/LocawebGateway.php';
		$array_pedido = array('numero'=>13, 'total'=>100.00, 'moeda'=>'real', 'descricao'=>'Pedido:13');
		$array_pagamento = array('meio_pagamento'=>'boleto_itau','data_vencimento'=>date('dmY'));
		$array_comprador = array('nome'=>'John da Silva','documento'=>'000,.000.000-00', 'endereco'=>'Rua X','numero'=>'98', 'cep'=>'1234-999','bairro'=>'Centro','cidade'=>'Varginha', 'estado'=>'MG');
		$array_transacao = array('url_retorno'=>base_url('carrinho/retorno-pagamento'), 'capturar'=>'true', 'pedido'=>$array_pedido, 'pagamento'=>$array_pagamento, 'comprador' => $array_comprador);
		$transacao = LocawebGateway::criar($array_transacao)->sendRequest();
		echo "<pre>";
		print_r($transacao);	
	}
	public function form_pagamento(){
		$data_header['categorias'] = $this->categorias;
		if(null != $this->session->userdata('logado')){
			$sessap = $this->session->userdata();
			$estado = $sessao['cliente']->estado;
			$data['frete'] = $this->frete_transportadora($estado);		
		}else{
			$data['frete'] = null;		
		}
		$this->load->view('html-header');
		$this->load->view('header', $data_header);
		$this->load->view('carrinho-formulario-pagamento',$data);
		$this->load->view('footer');
		$this->load->view('html-footer');	
	}		
}
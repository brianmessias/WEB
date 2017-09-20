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
		if(count($custo_frete < 1)){		
			$custo_frete = $this->db->query("SELECT * FROM tb_transporte_preco WHERE ucase(uf) = ucase('".$estado_destino."') ORDER BY peso_ate DESC LIMIT 1")->result();
			print_r($custo_frete);	
			if(count($custo_frete)<1) {
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
		$array_pagamento = array('meio_pagamento'=>'cielo', 'parcelas'=>1, 'tipo_operacao' => 'credito_a_vista', 'bandeira'=>'visa','nome_titular_cartao'=>'teste','cartao_numero'=>'45518000000183','cartao_cvv'=>'973', 'cartao_validade'=>'082017');
		$array_comprador = array('nome'=>'John da Silva','documento'=>'000,.000.000-00', 'endereco'=>'Rua X','numero'=>'98', 'cep'=>'1234-999','bairro'=>'Centro','cidade'=>'Varginha', 'estado'=>'MG');
		$array_transacao = array('url_retorno'=>base_url('carrinho/retorno-pagamento'),'capturar'=>'true','pedido'=>$array_pedido, 'pagamento'=>$array_pagamento, 'comprador'=>$array_comprador);
		$transacao = LocawebGateway::criar($array_transacao)->sendRequest();
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
	public function finalizar_compra(){
		if(null != $this->session->userdata('logado')){
			$sessao = $this->session->userdaa();
			$frete = $this->frete->transportadora($sessao['cliente']->estado);
			if($this->input->post('tipo_pagamento') == 'cartao'){
				$this->db->trans_start();
				$dados['cliente'] = $sessao['cliente']->id;
				$dados['produtos'] = $this->cart->total();
				$dados['frete'] = (double)str_replace(",",".",$frete);
				$dados['status'] = 0;
				$dados['comentarios'] = "Novo pedido inserido no sistema.";
				$this->db->insert('pedidos',$dados);
				$pedido = $this->db->insert_id();
				foreach($this->cart->contents() as $item){
					$dados_item['pedido'] = $pedido;
					$dados_item['item'] = $item['id'];
					$dados_item['quantidade'] = $item['qty'];
					$dados_item['preco'] = $item['price'];
					$this->db->insert('itens_pedidos',$dados_item);				
				}
				$total_a_cobrar = (double)($this->cart->total()) + (double)(str_replace(",",".",$frete));
				if($this->input->post('parcelamento') == 1){
					$operacao = 'credito_a_vista';				
				}else{
					$operacao = 'parcelamento_loja';				
				}
				require_once('./locaweb-gateway-php/LocawebGateway.php');
				$array_pedido = array('numero'=>$pedido,'total'=>$total_a_cobrar, 'moeda'=>'real','descricao'=>'Pedido: ', $pedido);
				$array_pagamento = array(
					'meio_pagamento'=>'cielo',
					'tipo_operacao'=>$operacao,
					'bandeira'=>$this->input->post('bandeira'),
					'nome_titular_cartao' => $this->input->post('carta_nome'), 
					'cartao_numero'=>$this->input->post('cartao_numero'),
					'cartao_cvv'=>$this->input->post('cartao_cvv'),
					'cartao_validade'=>str_replace("/","",$this->input->post('cartao_validade'))
				);
				$array_comprador = array(
					'nome'=>$sessao['cliente']->nome,
					'documento'=>$sessao['cliente']->cpf,
					'endereco'=>$sessao['cliente']->rua,
					'numero'=>$sessa['cliente']->numero,
					'cep'=>$sessao['cliente']->cep,
					'bairro'=>$sessao['cliente']->bairro,
					'cidade'=>$sessao['cliente']->cidade				
				);
				$array_transacao = array(
					'url_retorn'=>base_url('carrinho/finalizar_compra'),
					'capturar'=>'true',
					'pedido'=>$array_pedido,
					'pagamento'=>$array_pagamento,
					'comprador'=>$array_comprador
				);	  
				$transacao = LocawebGateway::criar($array_transacao)->sendRequest();
				if(!$transacao->transacao->erro){
					$this->db->trans_commit();
					$this->cart->destroy();
					//ENVIO DO E-MAIL DE CONFIRMAÇÃO
					$dados_email['pedido'] = $array_pedido;
					$dados_email['comprador'] = $array_comprador;
					$dados_email['transacao'] = $transacao;
					$this->enviar_confirmacao($dados_email,$sessao['cliente']->email);				
				}else{
					$this->db->trans->rollback();
				}
				$dados_retorno['transacao'] = $transacao;
				$dados_header['categorias'] = $this->categorias;
				$this->load->view('html-header');
				$this->load->view('header', $data_header);
				$this->load->view('retorno_cartao',$data_retorno);
				$this->load->view('footer');
				$this->load->view('html-footer');
				$this->db->trans_complete();						
			}else if($this->input->post('tipo_pagamento') == 'boleto'){
				// LOGICA PARA PAGAMENTO COM BOLETO
				$this->db->trans_start();
				$dados['cliente'] = $sessao['cliente']->id;
				$dados['produtos'] = $this->cart->total();
				$dados['frete'] = (double)str_replace(",",".",$frete);
				$dados['status'] = 0;
				$dados['comentários'] = "Novo pedido inserido no sistema.";
				$this->db->insert('pedidos',$dados);
				$pedido=$this->db->insert_id();
				foreach($this->cart->contents() as $item){
					$dados_item['pedido'] = $pedido;
					$dados_item['item'] = $item['id'];
					$dados_item['quantidade'] = $item['qty'];
					$dados_item['preco'] = $item['price'];
					$this->db->insert('itens_pedidos',$dados_item);				
				}
				$total_a_cobrar = (double)($this->cart->total()) + (double)(str_replace(",",".",$frete));
				require_once('./locaweb-gateway-php/LocawebGateway.php');
				$array_pedido = array('numero'=>$pedido,'total'=>$total_a_cobrar,'moeda'=>'real', 'descricao'=>'Pedido: '.$pedido);
				$vencimento_boleto = date('dmY', strtotime('+1 week'));
				//estabelecendo uma semana de prazo para o vencimento do boleto
				$array_pagamento = array('meio_pagamento'=>'bleto_itau','data_vencimento'=>$vencimento_boleto);
				$array_comprador = array(
					'nome'=>$sessao['cliente']->nome,
					'documento'=>$sessao['cliente']->cpf,
					'endereco'=>$sessao['cliente']->rua,
					'numero'=>$sessao['cliente']->numero,
					'cep'=>$sessao['cliente']->cep,
					'bairro'=>$sessao['cliente']->bairro,
					'cidade'=>$sessao['cliente']->cidade,
					'estado'=>$sessao['cliente']->estado				
					);
				$array_transacao = array(
					'url_retorno'=>base_url('carrinho/finalizar_compra'),
					'capturar'=>'true',
					'pedido'=>$array_pedido,
					'pagamento'=>$array_pagamento,
					'comprador'=>$array_comprador				
					);
				$transacao = LocawebGateway::criar($array_transacao)->sendRequest();
				if(!$transacao->transacao->erro){
					$this->db->trans_commit();
					$this->cart->destroy();
					//ENVIO DE E-MAIL DE CONFIRMAÇÃO
					$dados_email['pedido'] = $array_pedido;	
					$dados_email['comprador'] = $array_comprador;
					$dados_email['transacao'] = $transacao;	
					$this->enviar_confirmacao($dados_email,$sessao['cliente']->email);		
				}else{
					$this->db->trans_rollback();				
				}
				$dados_retorno['transacao'] = $transacao;
				$dados_header['categorias'] = $this->categorias;
				$this->load->view('html-header');
				$this->load->view('header', $data_header);
				$this->load->view('retorno_boleto',$data_retorno);
				$this->load->view('footer');
				$this->load->view('html-footer');
				$this->db->trans_complete();
			}else{
				redirect(base_url('pagar-e-finalizar-compra'));			
			}		
		}else{
			redirect(base_url('login'));		
		}	
	}
	public function enviar_confirmacao($dados,$para){
			$this->load->library('email');
			$this->email->from("loja@terceirao.cefetmg.br","Lojã do Terceirão");
			$this->email->to($para);
			$this->email->subject('Lojão do Terceirão - Pedido: '.$dados['pedido']['numero']);
			$this->email->message($this->load->view('emails/novo_pedido',$dados,TRUE));
			if($this->emial->send()){
				return "email enviado";			
			}else{
				return $this->email->print_debugger();			
			}
	}		
}
<?php defined('BASEPATH') OR exit('No direct  script  access  allowed');
  class Produtos_model extends CI_Model{
	  public function __construct() {
			parent::__construct();	  
	  }
	  public function detalhes_produto($id){
		$this->db->where('id',$id);
		return $this->db->get('produtos')->result();	  
	  }
	  public function destaques_home($quantos = 3){
	  	$this->db->limit($quantos);
	  	$this->db->order_by('id','random');
	  	return $this->db->get('produtos')->result();
	  }
	  public function busca($buscar){
		$this->db->like('titulo',$buscar);
		$this->db->or_ike('descricao',$buscar);
		return $this->db->get('produtos')->result();			  
	  }
	  
	   public function listar_produtos(){
      $this->db->order_by('titulo','ASC');
      return $this->db->get('produtos')->result();
    }
    
    	public function listar_produtos_categoria($id){
		$this->db->select('*');
		$this->db->from('categorias');
		$this->db->join('produtos_categoria','produtos_categoria.categoria = categorias.id AND produtos_categoria.produto = '.$id);
		$dados['categorias'] = $this->db->get()->result();
		return $dados;    
    }
  }
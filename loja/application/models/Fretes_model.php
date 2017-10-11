<?php defined('BASEPATH') OR exit('No direct  script  access  allowed');
  class Fretes_model extends CI_Model{
	  public function __construct() {
			parent::__construct();	  
	  }
	  public function listar_fretes(){
	  	$this->db->order_by('id','ASC');
      return $this->db->get('tb_transporte_preco')->result();
	  }
	  
	  public function detalhes_fretes($id){
	  	$this->db->where('id',$id);
		return $this->db->get('tb_transporte_preco')->result();	
	  }
	}
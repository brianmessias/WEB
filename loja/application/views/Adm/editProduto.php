<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
				<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Editar Produto</h1>
				</div>
					<?php 
						echo form_open(base_url("ProdutoAdm/alterarProduto")) .
							  form_hidden("txt_id",$produto[0]->id) .
							  form_label("Código: ","txt_codigo") . "<br>" .
							  form_input("txt_codigo", $produto[0]->codigo) . "<br>" .
							  form_label("Titulo: ","txt_titulo") . "<br>" .
							  form_input("txt_titulo", $produto[0]->titulo) . "<br>" .
							  form_label("Descrição: ","txt_descricao") . "<br>" .
							  form_textarea("txt_descricao", $produto[0]->descricao) .	"<br>" .
							  form_label('Categorias: ', 'txt_categoria') . "<br>";
							  
							 
							 
							  foreach($categoriasT['categorias'] as $categoriaT){	
							  		 $d = array(
       								  'name'          => 'categorias[]',
      								  'value'         => $categoriaT->id,
      								  'checked'       => TRUE,
										);						  
									echo  form_checkbox($d) . $categoriaT->titulo . "<br>";
									
							  }
							  foreach($categorias as $categoria){
							  		$count = 1;
							  			foreach($categoriasT['categorias'] as $categoriaT){
											if($categoria->titulo == $categoriaT->titulo){
												$count = 0;
											}							  			
							  			}	
							  			if($count == 1){						  	
											$d = array(
       								  'name'          => 'categorias[]',
      								  'value'         => $categoria->id,
      								  'checked'       => FALSE	,
										);						  
										echo  form_checkbox($d) . $categoria->titulo . "<br>";				
										}																			  
							  }							  							  
							  echo 
							  form_label("Preço: ","txt_preco") . "<br>" .
							  form_input("txt_preco", $produto[0]->preco) . "<br>" .
							  form_label("Largura da caixa em mm: ","txt_largura") . "<br>" .
							  form_input("txt_largura", $produto[0]->largura_caixa_mm) . "<br>" .
							  form_label("Altura da caixa em mm: ","txt_altura") . "<br>" .
							  form_input("txt_altura", $produto[0]->altura_caixa_mm) . "<br>" .		
							  form_label("Comprimento da caixa em mm: ","txt_comprimento") . "<br>" .
							  form_input("txt_comprimento", $produto[0]->comprimento_caixa_mm) . "<br>" .
							  form_label("Peso da caixa em gramas: ","txt_peso") . "<br>" .
							  form_input("txt_peso", $produto[0]->peso_gramas) . "<br>" .
							  form_label("Ativo/Inativo (1/0): ","txt_ativo") . "<br>" .
							  form_input("txt_ativo", $produto[0]->ativo) . "<br>" .			  
							  
							  form_submit("btn-enviar", "Salvar Alterações") .								  
							  form_close();					
					?>
				
			</div>
		</div>
</div>
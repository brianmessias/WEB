<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
				<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Adicionar Produto</h1>
				</div>
					<?php 
						echo form_open(base_url("ProdutoAdm/inserirProduto")) .
							  form_hidden("txt_id") .
							  form_label("Código: ","txt_codigo") . "<br>" .
							  form_input("txt_codigo") . "<br>" .
							  form_label("Titulo: ","txt_titulo") . "<br>" .
							  form_input("txt_titulo") . "<br>" .
							  form_label("Descrição: ","txt_descricao") . "<br>" .
							  form_textarea("txt_descricao") .	"<br>" .
							  form_label('Categorias: ', 'txt_categoria') . "<br>";
							  
							  foreach($categorias as $categoria){		  	
										$d = array(
       								 		'name'          => 'categorias[]',
      								  		'value'         => $categoria->id,
      								  		'checked'       => FALSE	,
										);						  
										echo  form_checkbox($d) . $categoria->titulo . "<br>";				
							}																			  
							 						  							  
							  echo 
							  form_label("Preço: ","txt_preco") . "<br>" .
							  form_input("txt_preco") . "<br>" .
							  form_label("Largura da caixa em mm: ","txt_largura") . "<br>" .
							  form_input("txt_largura") . "<br>" .
							  form_label("Altura da caixa em mm: ","txt_altura") . "<br>" .
							  form_input("txt_altura") . "<br>" .		
							  form_label("Comprimento da caixa em mm: ","txt_comprimento") . "<br>" .
							  form_input("txt_comprimento") . "<br>" .
							  form_label("Peso da caixa em gramas: ","txt_peso") . "<br>" .
							  form_input("txt_peso") . "<br>" .
							  form_label("Ativo/Inativo (1/0): ","txt_ativo") . "<br>" .
							  form_input("txt_ativo") . "<br>" .			  
							  
							  form_submit("btn-enviar", "Salvar Alterações") .								  
							  form_close();					
					?>
				
			</div>
		</div>
</div>
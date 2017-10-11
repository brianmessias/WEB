<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
				<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Editar Frete</h1>
				</div>
					<?php 
						echo form_open(base_url("FreteAdm/alterarFrete")) .
							  form_hidden("txt_id",$frete[0]->id) .
							  form_label("Peso de: ","txt_peso_de") . "<br>" .
							  form_input("txt_peso_de", $frete[0]->peso_de) . "<br>" .
							  form_label("Peso até: ","txt_peso_ate") . "<br>" .
							  form_input("txt_peso_ate", $frete[0]->peso_ate) . "<br>" .
							  form_label("Preço: ","txt_preco") . "<br>" .
							  form_input("txt_preco", $frete[0]->preco) .	"<br>" .
							  
							  form_label("Kg Adicional: ","txt_adicional_kg") . "<br>" .
							  form_input("txt_adicional_kg", $frete[0]->adicional_kg) . "<br>" .
							  form_label("UF: ","txt_uf") . "<br>" .
							  form_input("txt_uf", $frete[0]->uf) . "<br>" .							  	  
							  
							  form_submit("btn-enviar", "Salvar Alterações") .								  
							  form_close();					
					?>
				
			</div>
		</div>
</div>
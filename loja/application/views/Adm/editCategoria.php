<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
			<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Editar Categoria</h1>
				</div>
				<table>
					<table>
						<tr>
							<td width='50%'><b>Título<b></td>
							<td width='50%'><b>Descrição<b></td>
						</tr>			
							<?php 
								echo form_open(base_url("categoriaAdm/alterarCategoria")) .
										 "<tr><td>" . form_input('txt_titulo',$categoria[0]->titulo) . "</td>" .
										 					form_hidden('id',$categoria[0]->id) .
										 "<td>" . form_textarea('txt_descricao',$categoria[0]->descricao) . "<td><tr>" . 
										 "<tr><td>" . form_submit("btn-enviar", "Salvar Alterações") . "</td></tr>";
										 								
							?>					
				</table>
			</div>
		</div>
</div>
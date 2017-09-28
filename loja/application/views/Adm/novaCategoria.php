<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
			<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Nova Categoria</h1>
				</div>
				<table>
					<table>
						<tr>
							<td width='50%'><b>Título<b></td>
							<td width='50%'><b>Descrição<b></td>
						</tr>			
							<?php 
								echo form_open(base_url("administracao/incluirCategoria")) .
										 "<tr><td>" . form_input('txt_titulo') . "</td>" .								
										 "<td>" . form_textarea('txt_descricao') . "<td><tr>" . 
										 "<tr><td>" . form_submit("btn-enviar", "Incluir Nova Categoria") . "</td></tr>";
										 								
							?>					
				</table>
			</div>
		</div>
</div>
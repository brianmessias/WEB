	<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
				<div class="alinhado-centro borda-base espaco-vertical">
					<h3>Categorias</h3>
				</div>
				<table>
					<tr>
						<td width='25%'>Título</td>
						<td width='50%'>Descrição</td>
						<td width='25%'colspan="2">Operações</td>	
					</tr>
				<?php 	
					foreach ($categorias as $categoria){						
						echo "<tr><td>" . $categoria->titulo .
								"</td><td>" . $categoria->descricao. 
								"<td>" . anchor(base_url("#"), "Editar ",array('class' => 'btn btn-warning')) .	anchor(base_url("#"), "Excluir", array('class' => 'btn btn-danger')) . "</td></tr>";
			
					}	
				?>
				</table>
			</div>
		</div>
	</div>
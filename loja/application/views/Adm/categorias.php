	<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
				<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Categorias</h1>
				</div>
				<table>
					<tr>
						<td width='25%'><b>Título<b></td>
						<td width='50%'><b>Descrição<b></td>
						<td width='25%'colspan="2"><b>Operações</b></td>	
					</tr>
				<?php 	
					foreach ($categorias as $categoria){						
						echo "<tr>" .
									"<td>" . $categoria->titulo . "</td>" .
									"<td>" . $categoria->descricao. "</td>" .
									"<td>" . anchor(base_url("categoriaAdm/editCategoria/" . $categoria->id), "Editar ",array('class' => 'btn btn-warning')) .	
												anchor(base_url("categoriaAdm/excCategoria/" . $categoria->id), "Excluir", array('class' => 'btn btn-danger')) . "</td>" .
								"</tr>";
			
					}
					echo "<tr>
						<td width='25%' colsan = '2'><b><b></td>
						<td width='25%'><b></b></td>	
					</tr>";	
					
					echo "<tr><td></td><td>" .
						
					
						"<td>" . anchor(base_url("categoriaAdm/novaCategoria"), "Novo Item", array('class' => 'btn btn-primary')) . "</td></tr>" ;
					
				?>							
				</table>
				
			</div>
		</div>
	</div>
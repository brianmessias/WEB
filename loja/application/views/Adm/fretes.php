	<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
				<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Fretes</h1>
				</div>
				<table>
					<tr>
						<td width='10%'><b>Peso de<b></td>
						<td width='10%'><b>Peso até<b></td>
						<td width='10%'><b>Preço<b></td>
						<td width='10%'><b>Kg adicional<b></td>
						<td width='10%'><b>UF<b></td>
						<td width='50%'colspan="2"><b>Operações</b></td>	
					</tr>
				<?php 	
					foreach ($fretes as $frete){						
						echo "<tr>" .
									"<td>" . $frete->peso_de . "</td>" .
									"<td>" . $frete->peso_ate . "</td>" .
									"<td>" . $frete->preco . "</td>" .
									"<td>" . $frete->adicional_kg . "</td>" .
									"<td>" . $frete->uf . "</td>" .
									"<td>" . anchor(base_url("freteAdm/editFrete/" . $frete->id), "Editar ",array('class' => 'btn btn-warning')) .	
												anchor(base_url("freteAdm/excFrete/" . $frete->id), "Excluir", array('class' => 'btn btn-danger')) . "</td>" .
								"</tr><hr>";
			
					}
					echo "<tr>
						<td width='25%' colsan = '2'><b><b></td>
						<td width='25%'><b></b></td>	
					</tr>";	
					
					echo "<tr><td></td><td>" .
						
					
						"<td>" . anchor(base_url("FreteAdm/novoFrete"), "Novo Item", array('class' => 'btn btn-primary')) . "</td></tr>" ;
					
				?>							
				</table>
				
			</div>
		</div>
	</div>
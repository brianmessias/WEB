	<div id="homebody">			
		<div class="row-fluid">		
			<div class="table table-bordred table-striped">
				<div class="alinhado-centro borda-base espaco-vertical">
					<h1>Produtos</h1>
				</div>
				<table>
					<tr>
						<td width='5%'><b>Código<b></td>
						<td width='20%'><b>Título<b></td>
						<td width='30%'><b>Descrição<b></td>
						<td width='5%'><b>Preço<b></td>
						<td width='50%'colspan="2"><b>Operações</b></td>	
					</tr>
				<?php 	
					foreach ($produtos as $produto){						
						echo "<tr>" .
									"<td>" . $produto->codigo . "</td>" .
									"<td>" . $produto->titulo. "</td>" .
									"<td>" . $produto->descricao. "</td>" .
									"<td>" . $produto->preco. "</td>" .
									"<td>" . anchor(base_url("produtoAdm/editProduto/" . $produto->id), "Editar ",array('class' => 'btn btn-warning')) .	
												anchor(base_url("produtoAdm/excProduto/" . $produto->id), "Excluir", array('class' => 'btn btn-danger')) . "</td>" .
								"</tr><hr>";
			
					}
					echo "<tr>
						<td width='25%' colsan = '2'><b><b></td>
						<td width='25%'><b></b></td>	
					</tr>";	
					
					echo "<tr><td></td><td>" .
						
					
						"<td>" . anchor(base_url("ProdutoAdm/novoProduto"), "Novo Item", array('class' => 'btn btn-primary')) . "</td></tr>" ;
					
				?>							
				</table>
				
			</div>
		</div>
	</div>
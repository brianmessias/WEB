<div id="homebody">
  <div class="alinhado-centro borda-base espaco-vertical">
    <h3>Seja Bem-Vindo à area administrativa</h3>
    <p>Aqui você poderá Incluir, Alterar ou Excluir registros nas tabelas de categorias, produtos ou frete.
    </p>
    
  </div>
  <div class="row-fluid">
  	 <table style="width:100%">
    <tr>
    		<th><?php echo anchor(base_url("categoriaAdm"),"Cadastro de categorias", array("class" => "btn btn-mediun btn-primary"));?></th>
    		<th><?php echo anchor(base_url("produtoAdm"),"Cadastros de produtos", array("class" => "btn btn-mediun btn-primary"));?></th>
	 		<th><?php echo anchor(base_url("freteAdm"),"Tabela de fretes", array("class" => "btn btn-mediun btn-primary"));?></th>
	 </tr> 
	 </table>
  </div>
</div>

<?php
	$titulo = "Clientes";
	require_once ("controller/controllerLogin.php");
	require_once("classes/autoload.php");
	require_once("includes/header.php");

?>
<div class="container_pai">
	<div class="container_left">
		<form class="formulario_busca" method="post" action="">
			<label>Buscar por nome</label>
			<input type="text" name="clienteN" placeholder="Nome">
			<input type="text" name="clienteS" placeholder="Sobrenome">
			<input type="submit" name="buscar" value="Buscar"class="botao">
			<?php 
				if(isset($_POST['buscar'])):
			?>
				<input type="submit" name="voltar" value="Voltar" class="botao">
			<?php
				endif;
			?>
			<?php 
				if(isset($_POST['voltar'])){
					$select = new Crud();
					$result = $select->selectDB("*", "clientes", "order by nome", array());
				}
			?>

		</form>
	</div>
	<div class="container_right">
		<table class="Admin_class" cellspacing="0">
			<th colspan="4">Clientes</th>
			<tr id="tr_itens">
				<td>Nome</td>
				<td>Sobrenome</td>
				<td>Email</td>
				<td>Opções</td>
			</tr>
			
			<?php
				if (isset($_POST['buscar'])) {
					
					$select = new Crud();
					$result = $select->selectDB("id, nome, email, sobrenome", "clientes", "where nome = ? || sobrenome = ? order by nome", array($_POST['clienteN'], $_POST['clienteS']));
					$rsultBusca = $result->rowCount();
					if($rsultBusca == 0 ):?>
						<th id="nRegistro" colspan="4">Nenhum registro encontrado!!!</th>
					<?php
					endif;				
					while ($Fetch = $result->fetch(PDO::FETCH_ASSOC)) {//Arrumar a parte de deletar o admin e os clientes
					?>
					<tr>
						<td><?php echo $Fetch['nome']?></td>
						<td><?php echo $Fetch['sobrenome']?></td>
						<td><?php echo $Fetch['email']?></td>
						<td>
							<a href="<?php echo "visualizarCliente.php?id={$Fetch['id']}";?>"><img class="img_op" src="_imagens/abrir.png" alt="Visualizar"></a>
							<a href="<?php echo "cadastroCliente.php?id={$Fetch['id']}";?>"><img class="img_op" src="_imagens/edit.png" alt="Editar"></a>
							<a href="<?php echo "controller/controllerDeleteCliente.php?id={$Fetch['id']}";?>"><img class="img_op" src="_imagens/delete.png" alt="Deletar"></a>
						</td>
					</tr>
					<?php
					}
				}
				else{
					$select = new Crud();
					// Refazer a parte de visualização de cliente, precisa do cliente_id para que possa fazer os cálculos de gastos e exibir as informações. 
					//$info = $select->selectDB("*", "clientes", "join locacao on clientes.id = locacao.id_cliente join veiculo on locacao.id_veiculo = veiculo.id order by nome", array());
					//while ($teste = $info->fetch(PDO::FETCH_ASSOC)) {
						
					//}
					$result = $select->selectDB("*", "clientes", "order by nome", array());
					while ($Fetch = $result->fetch(PDO::FETCH_ASSOC)) :
					?>
					<tr>
						<td><?php echo $Fetch['nome']?></td>
						<td><?php echo $Fetch['sobrenome']?></td>
						<td><?php echo $Fetch['email']?></td>
						<td>
							<a href="<?php echo "visualizarCliente.php?id={$Fetch['id']}";?>"><img class="img_op" src="_imagens/abrir.png" alt="Visualizar"></a>
							<a href="<?php echo "cadastroCliente.php?id={$Fetch['id']}";?>"><img class="img_op" src="_imagens/edit.png" alt="Editar"></a>
							<a href="<?php echo "controller/controllerDeleteCliente.php?id={$Fetch['id']}";?>"><img class="img_op" src="_imagens/delete.png" alt="Deletar"></a>										
						</td>
					</tr>	
				<?php 
					endwhile;
				}
			?>
		</table>
	</div>
</div>




<?php
	require_once("includes/footer.php");
?>
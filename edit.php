<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

if (isset($_GET['clientId']) && is_numeric($_GET['clientId'])) {
	$sql_select_customer_infos = $bdd->prepare('SELECT customer_name,vol_factu FROM customer_billing WHERE customer_id = :customer_id');
	$sql_select_customer_infos->bindValue('customer_id', $_GET['clientId'], PDO::PARAM_STR);
	try {
		$sql_select_customer_infos->execute();
		}
	catch (PDOException $e) {
		echo 'Error : ' . $e->getMessage();
	}
	$customer_infos=$sql_select_customer_infos->fetch();
	$sql_select_customer_infos->closeCursor();
	
	printf("<p><h1>Edit %s's Volume</h1></p>", $customer_infos[customer_name]);
	?>
	<p>
	<form method="post" class="form-inline">
		<div class="form-group">
			<label for="data_vol">New Volume</label> : 
	<?php printf("	<input type=\"number\" class=\"form-control\" id=\"data_vol\" name=\"data_vol\" placeholder=\"%s\" /> GBytes", $customer_infos[vol_factu] / 1073741824); ?>
		</div>
		<button type="submit" class="btn btn-primary">Update !</button>
	</form>
	</p>
	
	<?php
	if (is_numeric($_POST['data_vol'])) {
		$data_vol_bytes = $_POST['data_vol'] * 1073741824;
		
		$sql_update_data_vol_bytes = $bdd->prepare('UPDATE customer_billing SET vol_factu = :data_vol_bytes WHERE customer_id = :customer_id');
		$sql_update_data_vol_bytes->bindValue('customer_id', $_GET['clientId'], PDO::PARAM_STR);
		$sql_update_data_vol_bytes->bindValue('data_vol_bytes', $data_vol_bytes, PDO::PARAM_STR);
		try {
			$sql_update_data_vol_bytes->execute();
		}
		catch (PDOException $e) {
			echo 'Error : ' . $e->getMessage();
		}

		printf("<h3><p class=\"bg-success\">Customer %s modified with %d GBytes</p></h3>",htmlspecialchars($customer_infos[customer_name]), $data_vol_bytes / 1073741824);
		$sql_update_data_vol_bytes->closeCursor();
	}
}
?>

</body>

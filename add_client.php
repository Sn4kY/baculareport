<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

?>
<p><h1>Add new customer to database</h1></p>
<p>
<form method="post" class="form-inline">
	<div class="form-group">
		<label for="Name">Customer name</label>
		<input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Real Name" />
	</div>
	<div class="form-group">
		<label for="data_vol">Volume</label> (GBytes)
		<input type="number" class="form-control" id="data_vol" name="data_vol" placeholder="10" />
	</div>
	<div class="checkbox">
		<label>
			<input type="checkbox" name="bill_new" checked="checked" /> FULL JobBytes billing system
		</label>
	</div>
	<button type="submit" class="btn btn-primary">Add new customer</button>
</form>
</p>

<?php
if (isset($_POST['customer_name']) && isset($_POST['data_vol'])) {
if (is_numeric($_POST['data_vol'])) {
	$customer_name = $_POST['customer_name'];
	$data_vol_bytes = $_POST['data_vol'] * 1073741824;
	if(isset($_POST['bill_new'])) $bill_new = "true";
	else $bill_new = "false";
	
	$sql_customer_new_add = $bdd->prepare('
INSERT INTO customer_billing
(customer_id, customer_name, vol_factu, full_billing)
VALUES (NULL, :customer_name, :data_vol_bytes, :bill_new);');

	$sql_customer_new_add->bindValue('customer_name', $customer_name, PDO::PARAM_STR);
	$sql_customer_new_add->bindValue('data_vol_bytes', $data_vol_bytes, PDO::PARAM_STR);
	$sql_customer_new_add->bindValue('bill_new', $bill_new, PDO::PARAM_STR);
	try {
		$sql_customer_new_add->execute();
	}
	catch (PDOException $e) {
		echo 'Error : ' . $e->getMessage();
	}
	$sql_customer_new_add->closeCursor();
	$sql_customer_new_add_check = $bdd->prepare('SELECT customer_id FROM customer_billing WHERE customer_name = :customer_name');
	$sql_customer_new_add_check->bindValue('customer_name', $customer_name, PDO::PARAM_STR);
	try {
		$sql_customer_new_add_check->execute();
	}
	catch (PDOException $e) {
		echo 'Error : ' . $e->getMessage();
	}
	if ($customer_new_add_check=$sql_customer_new_add_check->fetch()) {
		printf("<h3><p class=\"bg-success\">Customer %s successfully added with id %d</p></h3>",htmlspecialchars($customer_name), $customer_new_add_check[0]);
	}
	else echo "<p class=\"bg-warning\"><h3>Error</h3></p>";
	$sql_customer_new_add_check->closeCursor();

}}
?>

</body>

<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

?>
<p><h1>Add new client to database</h1></p>
<p>
<form method="post" class="form-inline">
	<div class="form-group">
		<label for="Name">Client name</label>
		<input type="text" class="form-control" id="client_name" name="client_name" placeholder="example" />
	</div>
	<div class="form-group">
		<label for="data_vol">Volume</label> (GBytes)
		<input type="number" class="form-control" id="data_vol" name="data_vol" placeholder="50" />
	</div>
	<div class="checkbox">
		<label>
			<input type="checkbox" name="bill_new" checked="checked" /> New billing system
		</label>
	</div>
	<button type="submit" class="btn btn-primary">Add new client</button>
</form>
</p>

<?php
if (isset($_POST['client_name']) && isset($_POST['data_vol'])) {
if (is_numeric($_POST['data_vol'])) {
	$client_name = htmlspecialchars($_POST['client_name']);
	$data_vol_bytes = htmlspecialchars($_POST['data_vol']) * 1073741824;
	if(isset($_POST['bill_new'])) $bill_new = "true";
	else $bill_new = "false";
	
	$sql_client_new_add = $bdd->prepare('
INSERT INTO grp_factu
(id_grp, name, vol_factu, factu_new)
VALUES (NULL, :client_name, :data_vol_bytes, :bill_new);');

	$sql_client_new_add->execute(array('client_name' => $client_name, 'data_vol_bytes' => $data_vol_bytes, 'bill_new' => $bill_new));
	$sql_client_new_add->closeCursor();
	$sql_client_new_add_check = $bdd->prepare('SELECT id_grp FROM grp_factu WHERE name = :client_name');
	$sql_client_new_add_check->execute(array('client_name' => $client_name));
	if ($client_new_add_check=$sql_client_new_add_check->fetch()) {
		printf("<h3><p class=\"bg-success\">Client %s successfully added with id %d</p></h3>",$client_name, $client_new_add_check[0]);
	}
	else echo "<p class=\"bg-warning\"><h3>Error</h3></p>";
	$sql_client_new_add_check->closeCursor();

}}

?>

</body>

<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

?>
<p><h1>Associate server with client</h1></p>
<?php
if (isset($_POST['server_id']) && isset($_POST['client_id'])) {
$server_id=htmlspecialchars($_POST['server_id']);
$client_id=htmlspecialchars($_POST['client_id']);
if (is_numeric($server_id) && is_numeric($client_id)) {
#	echo "server_id : ".$_POST['server_id']." ; client_id : ".$_POST['client_id'];
	$sql_find_srv_name = $bdd->prepare('SELECT Name FROM Job WHERE ClientId = :server_id GROUP BY Name;');
	$sql_find_srv_name->execute(array('server_id' => $server_id));
	$srv_name=$sql_find_srv_name->fetch();
	$sql_find_srv_name->closeCursor();
	$sql_assoc_srv_client = $bdd->prepare('
INSERT INTO grp_cli_assoc
(id_client, id_grp, name)
VALUES (:server_id, :client_id, :server_name);');
	if ($assoc_srv_client=$sql_assoc_srv_client->execute(array('server_id' => $server_id, 'client_id' => $client_id, 'server_name' => $srv_name['Name']))) {
		printf("<h3><p class=\"bg-success\">Server %s successfully associated</p></h3>", $srv_name['Name']);
	}
	else echo "<p class=\"bg-warning\"><h3>Error</h3></p>";
	$sql_assoc_srv_client->closeCursor();

}}

?>
<p>
<form method="post" class="form-inline">
<?php
$query_find_srv_noassoc='
SELECT ClientId, Job.Name FROM Job
LEFT JOIN grp_cli_assoc grp ON grp.id_client=Job.ClientId
WHERE grp.id_client IS NULL
GROUP BY ClientId
ORDER BY Job.Name
';
$query_list_client='SELECT id_grp, name FROM grp_factu ORDER BY name;';

$bdd_find_srv_noassoc = $bdd->query($query_find_srv_noassoc);
if ( $bdd_find_srv_noassoc->rowCount() != 0 ) {
	echo "<div class=\"form-group\">";
	echo "<label for=\"server_name\">Server name : </label>";
	echo "<select name=\"server_id\">";
	$bdd_list_client = $bdd->query($query_list_client);
	while ($srv_noassoc = $bdd_find_srv_noassoc->fetch()) {
		printf ("<option value=\"%d\">%s</option>",$srv_noassoc['ClientId'], $srv_noassoc['Name']);
	}
	echo "</select>";
	echo "<label for=\"client_name\">Assoc. with Client : </label>";
	echo "<select name=\"client_id\">";
	while ($list_client = $bdd_list_client->fetch()) {
		printf ("<option value=\"%d\">%s</option>",$list_client['id_grp'], $list_client['name']);
	}
	?>
	</select>
	</div>
	<button type="submit" class="btn btn-primary">Associate !</button>
	<?php
}
else echo "<h3><p class=\"bg-warning\">No Servers to associate with Client</p></h3>";

?>
</p>
</form>
</body>

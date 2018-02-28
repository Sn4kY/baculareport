<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

?>
<p><h1>Associate server with customer</h1></p>
<?php
if (isset($_POST['server_id']) && isset($_POST['client_id']) && isset($_POST['storage_id']) && isset($_POST['day_full'])) {
$server_id=htmlspecialchars($_POST['server_id']);
$client_id=htmlspecialchars($_POST['client_id']);
$storage_id=htmlspecialchars($_POST['storage_id']);
$day_full=htmlspecialchars($_POST['day_full']);
if (is_numeric($server_id) && is_numeric($client_id) && is_numeric($storage_id) && is_numeric($day_full)) {
#	echo "server_id : ".$_POST['server_id']." ; client_id : ".$_POST['client_id'];
	$sql_find_srv_name = $bdd->prepare('SELECT Name FROM Job WHERE ClientId = :server_id AND Type="B" AND Level="F" GROUP BY Name;');
	$sql_find_srv_name->execute(array('server_id' => $server_id));
	$srv_name=$sql_find_srv_name->fetch();
	$sql_find_srv_name->closeCursor();
	$sql_assoc_srv_client = $bdd->prepare('
INSERT INTO client_customer_assoc
(id_client, customer_id, name, storage_id, day_full)
VALUES (:server_id, :client_id, :server_name, :storage_id, :day_full);');
	if ($assoc_srv_client=$sql_assoc_srv_client->execute(array('server_id' => $server_id, 'client_id' => $client_id, 'server_name' => $srv_name['Name'], 'storage_id' => $storage_id, 'day_full' => $day_full))) {
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
LEFT JOIN client_customer_assoc grp ON grp.id_client=Job.ClientId
WHERE grp.id_client IS NULL
AND Type="B"
AND Level="F"
GROUP BY ClientId
ORDER BY Job.Name
';
$query_list_client='SELECT customer_id, customer_name FROM customer_billing ORDER BY customer_name;';

$query_list_storage='SELECT storage_id, storage_name FROM storage WHERE enabled="1" ORDER BY storage_name';

$bdd_find_srv_noassoc = $bdd->query($query_find_srv_noassoc);
if ( $bdd_find_srv_noassoc->rowCount() != 0 ) {
	echo "<div class=\"form-group\">";
	echo "<div>";
	echo "<label for=\"server_name\">Server name :&nbsp;</label>";
	echo "<select name=\"server_id\">";
	echo"<option>SELECT</option>";
	$bdd_list_client = $bdd->query($query_list_client);
	while ($srv_noassoc = $bdd_find_srv_noassoc->fetch()) {
		printf ("<option value=\"%d\">%s</option>",$srv_noassoc['ClientId'], $srv_noassoc['Name']);
	}
	echo "</select>";
	echo " <label for=\"customer_name\">Assoc. with Customer :&nbsp;</label>";
	echo "<select name=\"client_id\">";
	echo"<option>SELECT</option>";
	while ($list_client = $bdd_list_client->fetch()) {
		printf ("<option value=\"%d\">%s</option>",$list_client['customer_id'], $list_client['customer_name']);
	}
	echo "</select>";
	echo "</div>";
	echo "<div> Filer : ";
	$bdd_list_storage = $bdd->query($query_list_storage);
	while ($list_storage = $bdd_list_storage->fetch()) {
		//printf ("<option value=\"%d\">%s</option>",$list_storage['storage_id'], $list_storage['storage_name']);
		echo sprintf ('<input type="radio" id="%1$d" name="storage_id" value="%1$d"><label for="%1$d">%2$s</label>&nbsp;', $list_storage['storage_id'], $list_storage['storage_name']);
	}
	?>
	</div>
	<div>Day of the Full Job : 
	<input type="radio" id="1" name="day_full" value="1"><label for="1">Monday</label>
	<input type="radio" id="2" name="day_full" value="2"><label for="2">Tuesday</label>
	<input type="radio" id="3" name="day_full" value="3"><label for="3">Wednesday</label>
	<input type="radio" id="4" name="day_full" value="4"><label for="4">Thursday</label>
	<input type="radio" id="5" name="day_full" value="5"><label for="5">Friday</label>
	<input type="radio" id="6" name="day_full" value="6"><label for="6">Saturday</label>
	<input type="radio" id="7" name="day_full" value="7"><label for="7">Sunday</label>
	</div>
	<button type="submit" class="btn btn-primary">Associate !</button>
	<?php
}
else echo "<h3><p class=\"bg-warning\">No Servers to associate with Client</p></h3>";

?>
</p>
</form>
</body>

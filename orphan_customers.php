<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

?>
<h1>Customer without any associated client (server)</h1>
<table class="table table-striped table-bordered table-hover table-condensed">
<!--    <caption><div>Detail du rapport</div></caption>-->
 	<tr class="info"><th>Client Name</th><th>Delete ?</th></tr>
<?php
// Customer Infos
$result = $bdd->prepare('SELECT customer_billing.customer_id, customer_billing.customer_name
FROM customer_billing 
LEFT OUTER JOIN client_customer_assoc on client_customer_assoc.customer_id = customer_billing.customer_id
WHERE client_customer_assoc.customer_id IS NULL;');

$result->execute();
while ($row = $result->fetch()) {
	$customerName = $row['customer_name'];
	$customerId = $row['customer_id'];
	printf("<tr><td>%s</td>", $customerName);
	printf("<td><a href=\"orphan_customers.php?delete=true&customerId=%s\"><img src=\"res/delete.png\" alt=\"edit\" /></a></td></tr>",$customerId);
	}
	echo "</tr>";
$result->closeCursor();
?>
</table>

<?php
//Unlinking client<=>customer
if (isset($_GET['delete']) && isset($_GET['customerId'])) {
	if ($_GET['delete'] == true) {
		#$clientId = sprintf("%d",$_GET['clientId']);
		$SQLunlink = $bdd->prepare('
			DELETE FROM customer_billing WHERE customer_id=?
		');

		$SQLunlink->execute(array($_GET['customerId']));
	}
}
?>
</body>
</html>

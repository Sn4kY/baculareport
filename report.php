<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

?>
<h1>Backup Reporting</h1>
<table class="table table-striped table-bordered table-hover table-condensed">
<?php #    <caption><div>Reporting de backup</div></caption> ?>
 	<tr class="info"><th><a href="report.php">Name</a></th><th><a href="report.php?order=total">Total</a></th><th><a href="report.php?order=factu">Factur&eacute;</a></th><th><a href="report.php?order=depassement">Depassement</a></th></tr>
<?php
$query='
SELECT billing.customer_name, SUM(Job.JobBytes) AS Bytes, billing.vol_factu, billing.customer_id, sum(Job.JobBytes)-billing.vol_factu AS Depassement
FROM Job
INNER JOIN client_customer_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN customer_billing billing ON billing.customer_id=grp.customer_id
WHERE full_billing = "false"
AND Job.Type = "B"
GROUP BY billing.customer_name
';
// Requete pour le nouveau mode de facturation
$query_full_billing='SELECT customer_name, SUM(MaxFull) AS Bytes, vol_factu, customer_id, SUM(MaxFull)-vol_factu AS Depassement
FROM (
SELECT billing.customer_name, MAX(Job.JobBytes) AS MaxFull, billing.vol_factu, billing.customer_id
FROM Job
INNER JOIN client_customer_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN customer_billing billing ON billing.customer_id=grp.customer_id
WHERE full_billing = "true" AND Level = "F"
AND Job.Type = "B"
GROUP BY grp.name) AS Full_Max
GROUP BY customer_name
';
if (isset($_GET['order'])) {
	if ($_GET['order']=="depassement") {
		$query = $query . "ORDER BY Depassement DESC";
		$query_full_billing = $query_full_billing . "ORDER BY Depassement DESC";
	}
	if ($_GET['order']=="total") {
		$query = $query . "ORDER BY Bytes DESC";
		$query_full_billing = $query_full_billing . "ORDER BY Bytes DESC";
	}
	if ($_GET['order']=="factu") {
		$query = $query . "ORDER BY vol_factu DESC";
		$query_full_billing = $query_full_billing . "ORDER BY vol_factu DESC";
	}
}

$i=0; //increment du nombre de clients // couleur du tabeau (oldstyle)
$TotalJobBytes = 0;
$TotalVolFactu = 0;
$nbr_depassements=0;
$TotalDepassement = 0;

$result = $bdd->query($query);
while ($row = $result->fetch()) {
	$i++;
	printf("<tr><td><a href=details.php?clientId=%s>%s</a></td>", $row[3], $row[0]);
	$JobBytes=$row[1];
	$JobHBytes=FileSizeConvert($JobBytes);
	$VolFactu=$row[2];
	$VolHFactu=FileSizeConvert($VolFactu);
	$Depassement = $row[4];
	$Depassement = $row[4];
	$TotalJobBytes = $TotalJobBytes + $JobBytes;
	$TotalVolFactu = $TotalVolFactu + $VolFactu;
	printf("<td>%s</td>",$JobHBytes);
	printf("<td>%s</td>",$VolHFactu);
	if ($Depassement > 0) {
		$DepasPercent= round(($Depassement / $VolFactu) * 100,2);
		$HDepassement=FileSizeConvert($Depassement);
		printf("<td>%s <img src=fouet.gif /> soit %s&#37; de d&eacute;passement</td>",$HDepassement,$DepasPercent);
		$nbr_depassements++;
		$TotalDepassement = $TotalDepassement + $Depassement;
	} else {
		printf("<td></td>");
	}
	echo "</tr>";
}

$result->closeCursor();
?>
<tr class="info"><th colspan=4><a name="New">Max FULL JobBytes</a></th></tr>
<?php
$result = $bdd->query($query_full_billing);
while ($row = $result->fetch()) {
	$i++;
#	printf("<tr class=\"d".($i & 1)."\"><td><a href=details.php?clientId=%s>%s</a></td>", $row[3], $row[0]);
	printf("<tr><td><a href=details.php?clientId=%s>%s</a></td>", $row[3], $row[0]);
	$JobBytes=$row[1];
	$JobHBytes=FileSizeConvert($JobBytes);
	$VolFactu=$row[2];
	$VolHFactu=FileSizeConvert($VolFactu);
#	$Depassement=$VolFactu - $JobBytes;
	$Depassement = $row[4];
	$TotalJobBytes=$TotalJobBytes + $JobBytes * 7;
	$TotalVolFactu = $TotalVolFactu + $VolFactu * 7;
	printf("<td>%s</td>",$JobHBytes);
	printf("<td>%s</td>",$VolHFactu);
	if ($Depassement > 0) {
		$DepasPercent= round(($Depassement / $VolFactu) * 100,2);
		$HDepassement=FileSizeConvert($Depassement);
		printf("<td>%s <img src=fouet.gif /> soit %s&#37; de d&eacute;passement</td>",$HDepassement,$DepasPercent);
		$nbr_depassements++;
		$TotalDepassement = $TotalDepassement + $Depassement * 7;
	} else {
		printf("<td></td>");
	}
	echo "</tr>";
}
$result->closeCursor();
?>
<tr class="danger"><td>TOTAL</td><td><?php echo FileSizeConvert($TotalJobBytes); ?></td><td><?php echo FileSizeConvert($TotalVolFactu); ?></td><td><?php echo FileSizeConvert($TotalDepassement); ?></td></tr>
</table>
<p>Les totaux du nouveau mode de factu sont x7 pour approximer la r&eacute;alit&eacute;.</p>
<address>
Nombre de clients : <?php echo $i; ?><br />
Nombre de d&eacute;passements : <?php echo $nbr_depassements; ?>... t'as encore du taff !!!</address>
</body>
</html>

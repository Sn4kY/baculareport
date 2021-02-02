<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

?>
<h1>Details</h1>
<table class="table table-striped table-bordered table-hover table-condensed">
<!--    <caption><div>Detail du rapport</div></caption>-->
 	<tr class="info"><th>Client Name</th><th>Total biggest Full</th><th>Total Full + Diff</th><th>Factur&eacute;</th><th>Depassement</th></tr>
<?php
$i=0; //increment pour la couleur du tableau
$clientId = sprintf("%d",$_GET['clientId']);
// Customer Infos
$result = $bdd->prepare('
SELECT customer_name, SUM(BytesTotal) AS TotalFullDiff, vol_factu, SUM(MaxFull) AS TotalMaxFull, full_billing
FROM (
SELECT factu.customer_name, MAX(Job.JobBytes) AS MaxFull, factu.vol_factu, SUM(Job.JobBytes) AS BytesTotal, full_billing
FROM Job
INNER JOIN client_customer_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN customer_billing factu ON factu.customer_id=grp.customer_id
WHERE factu.customer_id=?
AND Job.Type = "B"
GROUP BY grp.name) AS Full_Max
GROUP BY customer_name;');

/*$result = $bdd->prepare('
SELECT factu.name, sum(Job.JobBytes) AS Bytes, factu.vol_factu
FROM Job
INNER JOIN client_customer_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN customer_billing factu ON factu.customer_id=grp.customer_id
WHERE factu.customer_id=?');
*/

$result->execute(array($clientId));
	while ($row = $result->fetch()) {
		$i++;
		$clientName = $row['customer_name'];
		printf("<tr><td>%s</td>", $clientName);
		$JobBytes=$row['TotalFullDiff'];
		$JobHBytes=FileSizeConvert($JobBytes);
		$VolFactu=$row['vol_factu'];
		$VolHFactu=FileSizeConvert($VolFactu);
		if ($row['full_billing'] == "true") $Depassement = $row['TotalMaxFull'] - $VolFactu;
		else $Depassement = $JobBytes - $VolFactu;
		printf("<td>%s</td>",FileSizeConvert($row['TotalMaxFull']));
		printf("<td>%s</td>",$JobHBytes);
		printf("<td>%s <a href=\"edit.php?clientId=%s\"><img src=\"res/edit.png\" alt=\"edit\" /></a></td>",$VolHFactu, $clientId);
		if ($Depassement > 0) {
			$HDepassement=FileSizeConvert($Depassement);
			printf("<td>%s <img src=res/fouet.gif /></td>",$HDepassement);
		} else {
			printf("<td></td>");
		}
		echo "</tr>";
	}

	$result->closeCursor();
?>
</table>

<?php
//Unlinking client<=>customer
if (isset($_GET['unlink']) && isset($_GET['serverId']) && isset($_GET['clientId'])) {
	if ($_GET['unlink'] == true) {
		$SQLunlink = $bdd->prepare('
			DELETE FROM client_customer_assoc WHERE id_client=? AND customer_id=?
		');

		$SQLunlink->execute(array($_GET['serverId'],$_GET['clientId']));
	}
}
?>

<p></p>
<table class="table table-striped table-bordered table-hover table-condensed">
	<caption>Details du client <?php echo $clientName; ?></caption>
	<tr class="warning"><th>Serveur</th><th>Filer</th><th>Plus gros Full</th><th>Total Full+Diff</th><th>Action</th></tr>
<?php
$result = $bdd->prepare('
SELECT grp.name, MAX(Job.JobBytes) AS BigFull, sum(Job.JobBytes) TotalFull, grp.id_client, sto_assoc.storage_name
FROM Job
INNER JOIN client_customer_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN customer_billing factu ON factu.customer_id=grp.customer_id
INNER JOIN storage sto_assoc ON sto_assoc.storage_id=grp.storage_id
WHERE factu.customer_id=?
AND Job.Type = "B"
GROUP BY grp.name;');

$result->execute(array($clientId));
while ($row = $result->fetch()) {
	$i++;
	printf("<tr><td><a href=\"details.php?clientId=%s&serverId=%s\">%s</a></td>", $clientId , $row[3] , $row[0]);
	printf("<td>%s</td>",$row[4]);
	printf("<td>%s</td>",FileSizeConvert($row[1]));
	printf("<td>%s</td>",FileSizeConvert($row[2]));
	printf("<td><a href=\"details.php?clientId=%s&serverId=%s&unlink=true\"><img src=\"res/unlink.png\" alt=\"unlink\" /></a></td>", $clientId , $row[3]);
	echo "</tr>";
}
$result->closeCursor();
echo "</table>";

//Per server details
if (isset($_GET['serverId']) && !isset($_GET['unlink'])) {
?>
<table class="table table-striped table-bordered table-hover table-condensed">
	<tr class="success"><th>JobId</th><th>Level</th><th>SchedTime</th><th>StartTime</th><th>EndTime</th><th>Duration</th><th>Nombre de fichier</th><th>Volume backup&eacute;</th><th>Job Status</th></tr>
<?php
	$SQLserverDetail = $bdd->prepare('
		SELECT JobId,Job,Job.Name AS Name,Level,SchedTime, StartTime, JobFiles, JobBytes, JobStatus, RealEndTime
		FROM Job
		INNER JOIN client_customer_assoc grp ON grp.id_client = Job.ClientId
		WHERE grp.customer_id=?
		AND Job.Type = "B"
		AND id_client=?
	');

	$SQLserverDetail->execute(array($clientId, $_GET['serverId']));
	while ($serverDetail = $SQLserverDetail->fetch()) {
		
		$ServerName=$serverDetail['Name'];

		// Time spent calculation for job duration
		$startdate = new DateTime($serverDetail['StartTime']);
		$enddate = new DateTime($serverDetail['RealEndTime']);
		$duration = date_diff($startdate,$enddate);

		if ($serverDetail['JobStatus'] == "f") { echo "<tr class=\"danger\">"; }
		else if ($serverDetail['JobStatus'] == "A") { echo "<tr class=\"danger\">"; }
		else if ($serverDetail['JobStatus'] == "E") { echo "<tr class=\"danger\">"; }
		else if ($serverDetail['Level'] == "F") { echo "<tr class=\"info\">"; }
		else echo "<tr>";
		printf("<td>%s</td>", $serverDetail['JobId']);
#		printf("<td>%s</td>", $serverDetail['Job']);
#		printf("<td>%s</td>", $serverDetail['Name']);
		printf("<td>%s</td>", ConvertBaculaBackupLevel($serverDetail['Level']));
		printf("<td>%s</td>", $serverDetail['SchedTime']);
		printf("<td>%s</td>", $serverDetail['StartTime']);
		printf("<td>%s</td>", $serverDetail['RealEndTime']);
		if ($duration->format('%a') >= 1) { echo "<td>" . (($duration->format('%a') * 24) + $duration->format('%H')) . ":" . $duration->format('%I:%S') . "</td>";} else  echo "<td>" . $duration->format('%H:%I:%S') . "</td>";
		printf("<td>%s</td>", $serverDetail['JobFiles']);
		printf("<td>%s</td>", FileSizeConvert($serverDetail['JobBytes']));
		printf("<td>%s</td>", ConvertBaculaJobStatus($serverDetail['JobStatus']));
		echo "</tr>";

	}
	

}
?>
</table>
<?php
// Block used to print backupplan in a textarea
// displayed only if serverId is set
if (isset($_GET['serverId']) && !isset($_GET['unlink'])) {
printf("<p><div>BackupPlan</div></p>");
	$SQLBackupPlan = $bdd->prepare('
		SELECT backupplan
		FROM client_customer_assoc
		WHERE name=?
	');
	$SQLBackupPlan->execute(array($ServerName));
	while ($serverBackupPlan = $SQLBackupPlan->fetch())
	{	
		printf("<pre>%s</pre>", $serverBackupPlan['backupplan']);
	}
}
?>
</body>
</html>

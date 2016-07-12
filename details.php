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
$result = $bdd->prepare('
SELECT name, SUM(BytesTotal) AS TotalFullDiff, vol_factu, SUM(MaxFull) AS TotalMaxFull, factu_new
FROM (
SELECT factu.name, MAX(Job.JobBytes) AS MaxFull, factu.vol_factu, SUM(Job.JobBytes) AS BytesTotal, factu_new
FROM Job
INNER JOIN grp_cli_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN grp_factu factu ON factu.id_grp=grp.id_grp
WHERE factu.id_grp=?
AND Job.Type = "B"
GROUP BY grp.name) AS Full_Max
GROUP BY name;');

/*$result = $bdd->prepare('
SELECT factu.name, sum(Job.JobBytes) AS Bytes, factu.vol_factu
FROM Job
INNER JOIN grp_cli_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN grp_factu factu ON factu.id_grp=grp.id_grp
WHERE factu.id_grp=?');
*/

$result->execute(array($clientId));
	while ($row = $result->fetch()) {
		$i++;
		$clientName = $row['name'];
		printf("<tr><td>%s</td>", $clientName);
		$JobBytes=$row['TotalFullDiff'];
		$JobHBytes=FileSizeConvert($JobBytes);
		$VolFactu=$row['vol_factu'];
		$VolHFactu=FileSizeConvert($VolFactu);
		if ($row['factu_new'] == "true") $Depassement = $row['TotalMaxFull'] - $VolFactu;
		else $Depassement = $JobBytes - $VolFactu;
		printf("<td>%s</td>",FileSizeConvert($row['TotalMaxFull']));
		printf("<td>%s</td>",$JobHBytes);
		printf("<td>%s</td>",$VolHFactu);
		if ($Depassement > 0) {
			$HDepassement=FileSizeConvert($Depassement);
			printf("<td>%s <img src=fouet.gif /></td>",$HDepassement);
		} else {
			printf("<td></td>");
		}
		echo "</tr>";
	}

	$result->closeCursor();
?>
</table>
<p></p>
<table class="table table-striped table-bordered table-hover table-condensed">
	<caption>Details du client <?php echo $clientName; ?></caption>
	<tr class="warning"><th>Serveur</th><th>Plus gros Full</th><th>Total Full+Diff</th></tr>
<?php
$result = $bdd->prepare('
SELECT grp.name, MAX(Job.JobBytes) AS BigFull, sum(Job.JobBytes) TotalFull, grp.id_client
FROM Job
INNER JOIN grp_cli_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN grp_factu factu ON factu.id_grp=grp.id_grp
WHERE factu.id_grp=?
AND Job.Type = "B"
GROUP BY grp.name;');

$result->execute(array($clientId));
while ($row = $result->fetch()) {
	$i++;
	printf("<tr><td><a href=\"details.php?clientId=%s&serverId=%s\">%s</a></td>", $clientId , $row[3] , $row[0]);
	printf("<td>%s</td>",FileSizeConvert($row[1]));
	printf("<td>%s</td>",FileSizeConvert($row[2]));
	echo "</tr>";
}
$result->closeCursor();
echo "</table>";

//Per server details
if (isset($_GET['serverId'])) {
?>
<table class="table table-striped table-bordered table-hover table-condensed">
	<tr class="success"><th>JobId</th><th>Level</th><th>SchedTime</th><th>StartTime</th><th>Nombre de fichier</th><th>Volume backup&eacute;</th><th>Job Status</th></tr>
<?php
	$SQLserverDetail = $bdd->prepare('
		SELECT JobId,Job,Job.Name AS Name,Level,SchedTime, StartTime, JobFiles, JobBytes, JobStatus
		FROM Job
		INNER JOIN grp_cli_assoc grp ON grp.id_client = Job.ClientId
		WHERE grp.id_grp=?
		AND Job.Type = "B"
		AND id_client=?
	');

	$SQLserverDetail->execute(array($clientId, $_GET['serverId']));
	while ($serverDetail = $SQLserverDetail->fetch()) {

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
		printf("<td>%s</td>", $serverDetail['JobFiles']);
		printf("<td>%s</td>", FileSizeConvert($serverDetail['JobBytes']));
		printf("<td>%s</td>", ConvertBaculaJobStatus($serverDetail['JobStatus']));
		echo "</tr>";
	}
	

}
?>
</table>
</body>
</html>

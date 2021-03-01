<?php require_once("header.php"); ?>
<body>
<?php

require_once("includes.php");
require_once("navbar.php");

$query_list_storage='SELECT storage_id, storage_name FROM storage WHERE enabled="1" ORDER BY storage_name';

// Filer details ordered by size
$query_list_jobs_per_storage = $bdd->prepare('
SELECT grp.name AS client_name, MAX(Job.JobBytes) AS BigFull, sum(Job.JobBytes) TotalFull
FROM Job
INNER JOIN client_customer_assoc grp ON grp.id_client = Job.ClientId
INNER JOIN customer_billing factu ON factu.customer_id=grp.customer_id
INNER JOIN storage sto_assoc ON sto_assoc.storage_id=grp.storage_id
WHERE sto_assoc.storage_id=?
AND Job.Type = "B"
GROUP BY grp.name
ORDER BY TotalFull DESC;
');
?>
<h1>Order backup size by filer</h1>
<table class="table table-striped table-bordered table-hover table-condensed">
<!--    <caption><div>Detail du rapport</div></caption>-->
<ul>
<?php
$bdd_list_storage_link = $bdd->query($query_list_storage);
while ($list_storage = $bdd_list_storage_link->fetch()) {
	printf("<li class=\"info\"><a href=\"order_by_filer.php#%s\">%s</a></li>", $list_storage['storage_id'], $list_storage['storage_name']);
}
?>
</ul>
 	<tr class="info"><th>Client Name</th><th>Total biggest Full</th><th>Total Full + Diff</th>

<?php
$i=0; //increment pour la couleur du tableau

$bdd_list_storage = $bdd->query($query_list_storage);

while ($list_storage = $bdd_list_storage->fetch()) {
	printf("<tr class=\"info\"><th colspan=4><a name=\"%s\">%s</a></th></tr>", $list_storage['storage_id'], $list_storage['storage_name']);
	$query_list_jobs_per_storage->execute(array($list_storage['storage_id']));
	while ($jobs_per_storage = $query_list_jobs_per_storage->fetch()){
		$i++;
		printf("<tr><td>%s</td>", $jobs_per_storage['client_name']);
		printf("<td>%s</td>",FileSizeConvert($jobs_per_storage['BigFull']));
		printf("<td>%s</td></tr>",FileSizeConvert($jobs_per_storage['TotalFull']));
	}
	$query_list_jobs_per_storage->closeCursor();
}
?>
</table>


</body>
</html>

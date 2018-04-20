
<?php
/*
   include ("../../../inc/includes.php");
   include ("../inc/metrics/oracleprocessor.php");


   global $CFG_GLPI;
   global $DB;

   Html::header(__('Software Asset Management', 'software asset management'), $_SERVER['PHP_SELF'], "tools", "report");
*/
echo "    !!!!!!    WILL BE A CONSOLIDATED VIEW INCLUDING ALL ENTITIES   !!!!!!    ";


/*
   $nbRequiredLicencesOracleProcessor = PluginSamMetricOracleProcessor::compute();

   echo "Required number of licences for oracle processor metric: " . $nbRequiredLicencesOracleProcessor . "<br />";
   
*/
/*
	$query = "SELECT A.name AS Software,A.id AS Software_id, J.name as Editor, B.completename AS License, B.id AS 				License_id, K.name AS Metric, SUM(E.nbcores*G.corefactor) AS RequiredLicenses, B.number AS 							PurchasedLicenses, B.number-(SUM(E.nbcores*G.corefactor)) AS Delta 
				FROM glpi_softwares A 
				INNER JOIN glpi_softwarelicenses B ON A.id=B.softwares_id 
				INNER JOIN glpi_computers_softwarelicenses C ON B.id=C.softwarelicenses_id 
				INNER JOIN glpi_computers D ON C.computers_id=D.id 
				INNER JOIN glpi_items_deviceprocessors E ON D.id=E.items_id 
				INNER JOIN glpi_deviceprocessors F ON E.deviceprocessors_id=F.id 
				INNER JOIN glpi_plugin_sam_corefactors G ON F.plugin_sam_corefactors_id=G.id 
				INNER JOIN glpi_manufacturers J ON A.manufacturers_id=J.id 
				INNER JOIN glpi_plugin_sam_metrics K ON B.plugin_sam_metrics_id=K.id
				INNER JOIN glpi_entities L ON B.entities_id=L.id AND D.entities_id=L.id
				#WHERE K.name='Oracle processor'
				GROUP BY A.name,B.completename,K.name,L.name
				ORDER BY delta";


	$result=$DB->queryOrDie($query, $DB->error());

	$software_link = $CFG_GLPI['root_doc'] . "/front/software.form.php?id=";
	$licence_link = $CFG_GLPI['root_doc'] . "/front/softwarelicense.form.php?id=";

	//table head
	echo "<table class=\"tab_cadrehov\" border=0>"."<tbody>"."<tr class=\"tab_bg_2\">"."<th>"."Software"."</th>"."<th>"."Editor"."</th>"."<th>"."License"."</th>"."<th>"."Metric"."</th>"."<th>"."RequiredLicenses"."</th>"."<th>"."PurchasedLicenses"."</th>"."<th>"."Delta"."</th>"."</tr>";

	//table body
	while ($row = $result->fetch_assoc()) {   
        echo "<tr>"."<td>"."<a href=\"" . $software_link.$row["Software_id"]."\">".$row["Software"]."</a>"."</td>"."</td>"."<td>".$row["Editor"]."</td>"."<td>"."<a href=\"".$licence_link.$row["License_id"]."\">".$row["License"]."</a>"."</td>"."<td>".$row["Metric"]."</td>"."<td>".$row["RequiredLicenses"]."</td>"."<td>".$row["PurchasedLicenses"]."</td>"."<td>".$row["Delta"]."</td>"."</tr>";
    }

	echo "</tbody></div>";

    Html::footer();

*/
?>
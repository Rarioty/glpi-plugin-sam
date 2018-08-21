
<?php
   include ("../../../inc/includes.php");
   include ("../inc/metrics/oracleprocessor.php");


   global $CFG_GLPI;
   global $DB;

   Html::header(__('Software Asset Management', 'software asset management'), $_SERVER['PHP_SELF'], "tools", "report");

/*
   $nbRequiredLicencesOracleProcessor = PluginSamMetricOracleProcessor::compute();

   echo "Required number of licences for oracle processor metric: " . $nbRequiredLicencesOracleProcessor . "<br />";
   
*/

	$query = "SELECT 
				A.name AS Software,
				A.id AS Software_id,
				IF(Z.computers_id IS NULL, D.id, Z.computers_id) AS Computer_id,
				J.name AS Editor,
                K.name AS Metric,
                Y.completename AS License,
                X.number AS PurchasedLicenses,
				SUM(E.RequiredLicenses) AS RequiredLicenses,
				X.number - SUM(E.RequiredLicenses) AS Delta
			FROM glpi_softwares A
            INNER JOIN glpi_softwareversions B ON A.id=B.softwares_id
            INNER JOIN glpi_computers_softwareversions C ON B.id=C.softwareversions_id
		    INNER JOIN glpi_computers D ON C.computers_id=D.id
			INNER JOIN glpi_softwarelicenses Y ON A.id=Y.softwares_id
            LEFT JOIN glpi_softwarelicenses X ON A.id=X.softwares_id
            INNER JOIN (
            #
            	SELECT IF(Z.computers_id IS NULL, D.id, Z.computers_id) AS computers_id, D.name
					FROM glpi_softwares A
					INNER JOIN glpi_softwareversions B ON A.id=B.softwares_id
					INNER JOIN glpi_computers_softwareversions C ON B.id=C.softwareversions_id
					INNER JOIN glpi_computers D ON C.computers_id=D.id
				    LEFT JOIN glpi_computervirtualmachines Z ON D.name=Z.name
				    INNER JOIN glpi_softwarelicenses Y ON A.id=Y.softwares_id
                    GROUP BY computers_id
            ) Z ON D.name=Z.name
		    INNER JOIN glpi_manufacturers J ON A.manufacturers_id=J.id
		    LEFT JOIN glpi_plugin_sam_metrics K ON X.plugin_sam_metrics_id=K.id
		    INNER JOIN (
		    # required licenses for each machine
		    	SELECT computers.id, computers.name, B.computers_id, SUM(processor.nbcores * G.corefactor) AS RequiredLicenses
					FROM `glpi_computers` computers
				    LEFT JOIN glpi_computervirtualmachines B ON computers.name=B.name
				    INNER JOIN glpi_items_deviceprocessors processor ON computers.id=processor.items_id
					INNER JOIN glpi_deviceprocessors F ON processor.deviceprocessors_id=F.id
					INNER JOIN glpi_plugin_sam_corefactors G ON F.plugin_sam_corefactors_id=G.id
		    		GROUP BY computers.name
		    		ORDER BY `B`.`computers_id` DESC
		    	) E ON IF(Z.computers_id IS NULL, D.id, Z.computers_id)=E.id
		    GROUP BY A.id
		    ORDER BY Delta";

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
?>
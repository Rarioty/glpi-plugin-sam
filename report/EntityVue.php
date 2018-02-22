<?php
   include ("../../../inc/includes.php");
   include ("../inc/metrics/oracleprocessor.php");

   Html::header(__('Software Asset Management', 'software asset management'), $_SERVER['PHP_SELF'], "tools", "report");

   $nbRequiredLicencesOracleProcessor = PluginSamMetricOracleProcessor::compute();

   echo "Required number of licences for oracle processor metric: " . $nbRequiredLicencesOracleProcessor . "<br />";
   Html::footer();
?>
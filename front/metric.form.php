<?php
   include ('../../../inc/includes.php');

   Html::header(__('Metric'), $_SERVER['PHP_SELF'], "management", "pluginsammetric", __('metric'));

   $example = new PluginSamMetric();
   $example->display($_GET);

   Html::footer();
?>
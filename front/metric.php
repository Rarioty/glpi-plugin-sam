<?php
   include ('../../../inc/includes.php');

   Html::header(__('Metric'), $_SERVER['PHP_SELF'], "management", "pluginsammetric", __('Metric'));

   Search::show('PluginSamMetric');

   Html::footer();
?>
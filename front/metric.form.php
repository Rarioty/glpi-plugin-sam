<?php
   include ('../../../inc/includes.php');

   Html::header(__('Metric', 'sam'), $_SERVER['PHP_SELF'], "management", "pluginsammetric", __('metric', 'sam'));

   $example = new PluginSamMetric();
   $example->display($_GET);

   Html::footer();
?>
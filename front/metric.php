<?php
   include ('../../../inc/includes.php');

   Html::header(__('Metric', 'sam'), $_SERVER['PHP_SELF'], "management", "pluginsammetric", __('Metric', 'sam'));

   Search::show('PluginSamMetric');

   Html::footer();
?>
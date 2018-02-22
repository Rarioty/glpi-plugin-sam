<?php
   class PluginSamMetricOracleProcessor extends PluginSamMetric {
      public static $search = array(
         'nbcores' => array(
            'table' => 'glpi_deviceprocessors',
            'column' => 'nbcores_default',
            'filter' => array('id')
         ),
         'corefactors' => array(
            'table' => 'glpi_plugin_sam_corefactors',
            'column' => 'corefactor',
            'filter' => array('name')
         )
      );

      public static function compute() {
         $result = 0;

         $fields = PluginSamMetric::getFields(PluginSamMetricOracleProcessor::$search, array(
            'nbcores' => array(
               'id' => 1
            ),
            'corefactors' => array(
               'name' => 'Sun and Fujitsu UltraSPARC T1 1.4 GHz'
            )
         ));

         if ($fields === null)
            return -1;

         if (is_string($fields))
         {
            echo "ERROR: no field named " . $fields . ' in $params !';
            return -1;
         }

         $result = $fields['nbcores'] * $fields['corefactors'];

         return $result;
      }
    }
?>
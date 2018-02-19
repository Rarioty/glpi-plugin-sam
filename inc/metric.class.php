<?php
   class PluginSamMetric extends CommonDBTM {
      static function getTypeName($nb = 0) {
         return __('Metric');
      }

      static function canCreate() {
         return true;
      }

      static function canView() {
         return true;
      }

      static function getMenuName() {
         return __('Metric');
      }

      function showForm($ID, $options = array()) {
         global $CFG_GLPI;

         $this->initForm($ID, $options);
         $this->showFormHeader($options);

         echo "<tr class='tab_bg_1'>";

         echo "<td>" . __('ID') . "</td>";
         echo "<td>";
         echo $ID;
         echo "</td>";

         $this->showFormButtons($options);

         return true;
      }
   }
?>
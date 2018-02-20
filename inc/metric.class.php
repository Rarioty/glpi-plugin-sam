<?php
   class PluginSamMetric extends CommonDBTM {
      static function getTypeName($nb = 0) {
         return __('Metrics', 'sam');
      }

      static function canCreate() {
         return false;
      }

      static function canView() {
         return false;
      }

      static function getMenuName() {
         return __('Metrics', 'sam');
      }
   }
?>
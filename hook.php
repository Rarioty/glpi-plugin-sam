<?php
   /**
    * Install hook
    *
    * @return boolean
    */
   function plugin_sam_install() {
      // Html::header(__('Setup', 'sam'), filter_input(INPUT_SERVER, "PHP_SELF"), "config", "plugins");
      
      require_once (GLPI_ROOT . "/plugins/sam/install/install.php");

      return pluginSAMInstall(PLUGIN_SAM_VERSION);
   }

   /**
    * Uninstall hook
    *
    * @return boolean
    */
   function plugin_sam_uninstall() {
      global $DB;

      if (TableExists('glpi_plugin_sam_metrics')){
         $query = 'DROP TABLE glpi_plugin_sam_metrics';
         $res = $DB->queryOrDie($query, $DB->error());
      }

      if (TableExists('glpi_plugin_sam_corefactors')){
         $query = 'DROP TABLE glpi_plugin_sam_corefactors';
         $req = $DB->queryOrDie($query, $DB->error());
      }

      if (TableExists('glpi_plugin_sam_pvus')){
         $query = 'DROP TABLE glpi_plugin_sam_pvus';
         $req = $DB->queryOrDie($query, $DB->error());
      }

      if (TableExists('glpi_deviceprocessors')){
         $query = 'ALTER TABLE glpi_deviceprocessors DROP plugin_sam_corefactors_id, DROP plugin_sam_pvus_id';
         $req = $DB->queryOrDie($query, $DB->error());
      }

      if (TableExists('glpi_softwarelicenses')){
         $query = 'ALTER TABLE glpi_softwarelicenses DROP plugin_sam_metrics_id';
         $req = $DB->queryOrDie($query, $DB->error());
      }
      
      return true;
   }
?>
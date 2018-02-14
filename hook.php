<?php
   /**
    * Install hook
    *
    * @return boolean
    */
   function plugin_sam_install() {
      Html::header(__('Setup'), filter_input(INPUT_SERVER, "PHP_SELF"), "config", "plugins");
      
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

      if (TableExists('glpi_deviceprocessors')){
         $query = 'ALTER TABLE glpi_deviceprocessors DROP corefactor, DROP pvu';
         $res = $DB->queryOrDie($query, $DB->error());
      }

      return true;
   }
?>
<?php
   /**
    * This function manage the installation of the plugin.
    *
    * @global object $DB
    * @param string $version
    */
   function pluginSAMInstall($version) {
      global $DB;

      ini_set("memory_limit", "-1");
      ini_set("max_execution_time", "0");

      $migration = new Migration($version);

      $migration->displayMessage(__("Installation of plugin SAM"));

      /* Check existence of tables */
      $migration->displayMessage(__("Getting existence of glpi_deviceprocessors"));

      $tableDeviceProcessorsExist = TableExists('glpi_deviceprocessors');
      if (!$tableDeviceProcessorsExist){
         return false;
      }

      /* Clean database */
      $migration->displayMessage(__("Clean data from old installation of the plugin"));

      $migration->displayMessage(__("Dropping corefactor and pvu columns"));

      $query = "SELECT * FROM information_schema.columns WHERE table_schema = 'glpi' AND TABLE_NAME = 'glpi_deviceprocessors' AND column_name IN ( 'corefactor' )";
      $res = $DB->queryOrDie($query, $DB->error());
      if ($res->num_rows > 0){
         $query = "ALTER TABLE glpi_deviceprocessors DROP corefactor";
         $DB->queryOrDie($query, $DB->error());
      }

      $query = "SELECT * FROM information_schema.columns WHERE table_schema = 'glpi' AND TABLE_NAME = 'glpi_deviceprocessors' AND column_name IN ( 'pvu' )";
      $res = $DB->queryOrDie($query, $DB->error());
      if ($res->num_rows > 0){
         $query = "ALTER TABLE glpi_deviceprocessors DROP pvu";
         $DB->queryOrDie($query, $DB->error());
      }

      /* Create tables */
      $migration->displayMessage(__("Creation tables in database"));

      $migration->displayMessage(__("Creating glpi_plugin_sam_oracle_corefactors table"));

      if (!TableExists("glpi_plugin_sam_oracle_corefactors")){
         $query = "CREATE TABLE glpi_plugin_sam_oracle_corefactors (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `description` TEXT NOT NULL, `corefactor` FLOAT(11) NOT NULL)";
         $res = $DB->queryOrDie($query, $DB->error());
      }

      $migration->displayMessage(__("Creating glpi_plugin_sam_metrics table"));

      if (!TableExists("glpi_plugin_sam_metrics")){
         $query = "CREATE TABLE glpi_plugin_sam_metrics (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(255) NOT NULL, `classname` VARCHAR(255) NOT NULL)";
         $res = $DB->queryOrDie($query, $DB->error());
      }

      /* Modifying tables */
      $migration->displayMessage(__("Modifying existing tables in database"));


      $migration->displayMessage(__("Modifying glpi_deviceprocessors"));

      if (TableExists('glpi_deviceprocessors')){
         $query = 'ALTER TABLE glpi_deviceprocessors ADD (corefactor float(11), pvu integer(11))';
         $res = $DB->queryOrDie($query, $DB->error());
      }

      return true;
   }
?>
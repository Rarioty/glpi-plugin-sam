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

      $migration->displayMessage("Installation of plugin SAM");

      sleep(1);

      /* Check existence of tables */
      $migration->displayMessage("Getting existence of tables");

      $tableDeviceProcessorsExist = TableExists('glpi_deviceprocessors');
      if (!$tableDeviceProcessorsExist){
         return false;
      }

      /* Clean database */
      $migration->displayMessage("Clean data from old installation of the plugin");

      $query = "SELECT * FROM information_schema.columns WHERE table_schema = 'MY_DATABASE' AND column_name IN ( 'corefactor' )";
      $res = $DB->queryOrDie($query, $DB->error());
      if ($res->num_rows > 0){
         $query = "ALTER TABLE glpi_deviceprocessors DROP corefactor";
         $DB->queryOrDie($query, $DB->error());
      }

      $query = "SELECT * FROM information_schema.columns WHERE table_schema = 'MY_DATABASE' AND column_name IN ( 'pvu' )";
      $res = $DB->queryOrDie($query, $DB->error());
      if ($res->num_rows > 0){
         $query = "ALTER TABLE glpi_deviceprocessors DROP pvu";
         $DB->queryOrDie($query, $DB->error());
      }

      /* Create tables */
      $migration->displayMessage("Creation tables in database");

      if (!TableExists("glpi_plugin_sam_oracle_corefactors")){
         $query = "CREATE TABLE glpi_plugin_sam_oracle_corefactors (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `desc` TEXT NOT NULL, `corefactor` FLOAT(11) NOT NULL)";
         $res = $DB->queryOrDie($query, $DB->error());
      }

      sleep(1);

      if (!TableExists("glpi_plugin_sam_ibm_pvu")){
         $query = "CREATE TABLE glpi_plugin_sam_ibm_pvu (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `desc` TEXT NOT NULL, `pvu` INT(11) NOT NULL)";
         $res = $DB->queryOrDie($query, $DB->error());
      }

      sleep(1);

      /* Modifying tables */
      $migration->displayMessage("Modifying existing tables in database");

      sleep(1);

      if (TableExists('glpi_deviceprocessors')){
         $query = 'ALTER TABLE glpi_deviceprocessors ADD (corefactor float(11), pvu integer(11))';
         $res = $DB->queryOrDie($query, $DB->error());
      }

      return true;
   }
?>
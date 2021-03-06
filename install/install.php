<?php
   /**
    * This function manage the installation of the plugin.
    *
    * @global object $DB
    * @param string $version
    */
   function pluginSAMInstall($version) {
      global $CFG_GLPI;
      global $DB;

      ini_set("memory_limit", "-1");
      ini_set("max_execution_time", "0");

      $migration = new Migration($version);

      $migration->displayMessage(__('Installation of plugin SAM', 'sam'));

      /* -------- Checking existence of tables -------- */
      $migration->displayMessage(__('Getting existence of glpi_deviceprocessors', 'sam'));

      $tableDeviceProcessorsExist = TableExists('glpi_deviceprocessors');
      if (!$tableDeviceProcessorsExist){
         return false;
      }
      $tableSoftwareLicensesExist = TableExists('glpi_softwarelicenses');
      if (!$tableSoftwareLicensesExist){
         return false;
      }

      /* -------- Cleaning database -------- */
      $migration->displayMessage(__('Clean data from old installation of the plugin', 'sam'));

      /* NOT YET IMPLEMENTED
      $query = "SELECT * FROM information_schema.columns WHERE table_schema = 'glpi' AND TABLE_NAME = 'glpi_deviceprocessors' AND column_name IN ( 'plugin_sam_pvu_id' )";
      $res = $DB->queryOrDie($query, $DB->error());
      if ($res->num_rows > 0){
         $query = "ALTER TABLE glpi_deviceprocessors DROP plugin_sam_pvu_id";
         $DB->queryOrDie($query, $DB->error());
      }
      */

      $migration->displayMessage(__('Dropping corefactor column', 'sam'));
      $query = "SELECT * FROM information_schema.columns WHERE table_schema = 'glpi' AND TABLE_NAME = 'glpi_deviceprocessors' AND column_name IN ( 'plugin_sam_corefactors_id' )";
      $res = $DB->queryOrDie($query, $DB->error());
      if ($res->num_rows > 0){
         $query = "ALTER TABLE glpi_deviceprocessors DROP plugin_sam_corefactors_id";
         $DB->queryOrDie($query, $DB->error());
      }

      /* -------- Creating tables -------- */
      $migration->displayMessage(__('Creating tables in database', 'sam'));

      $migration->displayMessage(__('Creating glpi_plugin_sam_corefactors table', 'sam'));

      if (!TableExists("glpi_plugin_sam_corefactors")){
         $query = "CREATE TABLE glpi_plugin_sam_corefactors (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` TEXT NOT NULL, `corefactor` FLOAT(11) NOT NULL)";
         $res = $DB->queryOrDie($query, $DB->error());
      }
      /* NOT YET IMPLEMENTED
      $migration->displayMessage(__('Creating glpi_plugin_sam_pvus table', 'sam'));
     
      if (!TableExists("glpi_plugin_sam_pvus")){
         $query = "CREATE TABLE glpi_plugin_sam_pvus (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` TEXT NOT NULL, `pvu` INT(11) NOT NULL)";
         $res = $DB->queryOrDie($query, $DB->error());
      }      
      */
      $migration->displayMessage(__('Creating glpi_plugin_sam_metrics table', 'sam'));

      if (TableExists("glpi_plugin_sam_metrics")){
         $query = "DROP TABLE glpi_plugin_sam_metrics";
         $res = $DB->queryOrDie($query, $DB->error());
      }

      $query = "CREATE TABLE glpi_plugin_sam_metrics (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(255) NOT NULL, `classname` VARCHAR(255) NOT NULL)";
      $res = $DB->queryOrDie($query, $DB->error());

      /* -------- Modifying tables -------- */
      $migration->displayMessage(__('Modifying existing tables in database', 'sam'));

      $migration->displayMessage(__('Modifying glpi_deviceprocessors', 'sam'));

      if ($tableDeviceProcessorsExist){
         $query= "ALTER TABLE glpi_deviceprocessors ADD plugin_sam_corefactors_id INT(11) NOT NULL/*, ADD plugin_sam_pvus_id INT(11) NOT NULL*/";
         $res = $DB->queryOrDie($query, $DB->error());
      }

      $migration->displayMessage(__('Modifying glpi_softwarelicenses', 'sam'));

      if ($tableSoftwareLicensesExist){
         $query = "ALTER TABLE glpi_softwarelicenses ADD plugin_sam_metrics_id INT(11) NOT NULL";
         $res = $DB->queryOrDie($query, $DB->error());
      }

      /* -------- Populating tables --------*/

      $migration->displayMessage(__('Populating tables', 'sam'));

      $query = "INSERT INTO glpi_plugin_sam_metrics(name, classname) VALUES('Oracle processor', 'PluginSamMetricOracleProcessor'), ('Oracle nup', 'coucou')";
      $res = $DB->queryOrDie($query, $DB->error());

      $migration->displayMessage(__('Populating glpi_plugin_sam_corefactors table', 'sam'));

      /* -------- Importing CSV files --------*/

      /* Importing corefactors */
      $path = GLPI_ROOT . "/plugins/sam/files/oracle_corefactors.csv";
      $file = fopen($path, 'r');
      while (!feof($file)){
         $line = addslashes(fgets($file));
         $tab = explode(';',$line);
         if (sizeof($tab) !== 2)
            continue;
         $sql = "INSERT INTO glpi_plugin_sam_corefactors VALUES('','".$tab[0]."', '".$tab[1]."')";
         $res = $DB->queryOrDie($sql, $DB->error());
      }
      fclose($file);

      /* Importing entities */
      
      $path = GLPI_ROOT . "/plugins/sam/files/entities.csv";
      $file = fopen($path, 'r');
      while (!feof($file)){
         $line = addslashes(fgets($file));
         $tab = explode(';',$line);
        /*
         if (sizeof($tab) !== 66)
            continue;
         $presql = "ALTER TABLE glpi_entities MODIFY id INTEGER NOT NULL AUTO_INCREMENT;";
         $res = $DB->queryOrDie($presql, $DB->error());  
         */   
         if (sizeof($tab) !== 66)
            continue;    
         $sql = "INSERT INTO glpi_entities(id,name,entities_id,completename,comment, level, sons_cache, ancestors_cache) VALUES('".$tab[0]."','".$tab[1]."','".$tab[2]."','".$tab[3]."','".$tab[4]."','".$tab[5]."','".$tab[6]."','".$tab[7]."')";
         $res = $DB->queryOrDie($sql, $DB->error());
      }

      fclose($file);
      
           
      return true;
   }
?>
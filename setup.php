<?php
   define('PLUGIN_SAM_VERSION', '1.0.0');

   require_once (GLPI_ROOT . "/plugins/sam/inc/SoftwareAssetManagementHooks.class.php");

   /**
    * Init the hooks of the plugins - Needed
    *
    * @return void
    */
   function plugin_init_sam(){
      global $PLUGIN_HOOKS;

      $PLUGIN_HOOKS['csrf_compliant']['sam'] = true;
      $PLUGIN_HOOKS['pre_item_form']['sam'] = ['SoftwareAssetManagementHooks', 'pre_item_form'];

      $PLUGIN_HOOKS['reports']['sam'] = SoftwareAssetManagementHooks::get_reports();
      $PLUGIN_HOOKS['menu_toadd']['sam'] = SoftwareAssetManagementHooks::get_new_menus();
   }

   /**
    * Check configuration process for plugin : need to return true if succeeded
    * Can display a message only if failure and $verbose is true
    *
    * @param boolean $verbose Enable verbosity. Default to false
    *
    * @return boolean
    */
   function plugin_sam_check_config($verbose = false){
      return true;
   }

   /**
    * Check prerequisites before install : may print errors or add to message after redirect
    *
    * @return boolean
    */
   function plugin_sam_check_prerequisites(){
      return true;
   }

   /**
    * Get the name and the version of the plugin - Needed
    *
    * @return array
    */
   function plugin_version_sam(){
      return [
         'name'         => 'Software Asset Management',
         'version'      => PLUGIN_SAM_VERSION,
         'author'       => 'Orange S.A.',
         'license'      => 'GLPv3',
         'requirements' => [
            'glpi' => [
               'min' => '9.2'
            ]
         ]
      ];
   }
?>
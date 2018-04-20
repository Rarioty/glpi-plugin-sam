<?php
	namespace SAMPlugin;

   class SoftwareLicense{
      public static function getAdditionalFields(){
         return [
            [
               'name'  => 'plugin_sam_corefactors_id',
               'label' => __('Core factor', 'sam'),
               'type'  => 'dropdownValue'
            ]/* NOT YET IMPLEMENTED,
            [
               'name'  => 'plugin_sam_pvus_id',
               'label' => __('Processor Value Unit', 'sam'),
               'type'  => 'dropdownValue'
            ]
            */
         ];
      }
   }
?>
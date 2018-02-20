<?php
   namespace SAMPlugin;

   class DeviceProcessor{
      public static function getAdditionalFields(){
         return [
            [
               'name'  => 'plugin_sam_corefactors_id',
               'label' => __('Core factor'),
               'type'  => 'dropdownValue'
            ],
            [
               'name'  => 'plugin_sam_pvus_id',
               'label' => __('Processor Value Unit'),
               'type'  => 'dropdownValue'
            ]
         ];
      }
   }
?>
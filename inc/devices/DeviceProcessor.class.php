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
               'name'  => 'pvu',
               'label' => __('Processor Value Unit'),
               'type'  => 'integer',
               'options' => [
                  'max' => '200'
               ]
            ]
         ];
      }
   }
?>
<?php
   namespace SAMPlugin;

   class DeviceProcessor{
      public static function getAdditionalFields(){
         return [
            [
               'name'  => 'corefactor',
               'label' => __('Core factor'),
               'type'  => 'text'
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
<?php
   class SAMHooks{
      public static function pre_item_form($params){
         if (isset($params['options']['itemtype'])){
            $deviceType = $params['options']['itemtype'];
            $filename = dirname(__FILE__) . "/devices/" . $deviceType . ".class.php";

            if (realpath($filename)){
               require_once ($filename);

               $class = "\\SAMPlugin\\" . $deviceType;

               if (class_exists($class)){
                  $fields = $class::getAdditionalFields();

                  $params['item']->setAdditionalFields($fields);
               }
            }
         }
      }
   }
?>
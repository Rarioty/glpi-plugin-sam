<?php
   class PluginSamMetric extends CommonDBTM {
      /* from CommonDBTM functions */ 
      static function getTypeName($nb = 0) {
         return __('Metrics', 'sam');
      }

      static function canCreate() {
         return false;
      }

      static function canView() {
         return false;
      }

      static function getMenuName() {
         return __('Metrics', 'sam');
      }

      public static function getFields($search, $params = []) {
         global $DB;

         $fields = array();

         foreach($search as $key => $searchItem)
         {
            /**
             * searchItem:
             *    - table: table dans laquelle chercher la donnée
             *    - column: Donnée à récupérer
             *    - filter: Filtre à appliquer
             */

            $sql = "SELECT " . $searchItem['column'] . " FROM " . $searchItem['table'];

            if (isset($searchItem['filter']) && count($searchItem['filter']) != 0)
            {
               $sql .= " WHERE ";
               foreach($searchItem['filter'] as $filter)
               {
                  if (!isset($params[$key]) || !isset($params[$key][$filter]))
                     return $filter;

                  $sql .= $filter . "='" . $params[$key][$filter] . "' AND ";
               }
               $sql = substr($sql, 0, strrpos($sql, " AND "));
            }
            
            $res = $DB->queryOrDie($sql, $DB->error());

            if ($res->num_rows !== 1)
               return null;

            $res = $res->fetch_row();

            $fields[$key] = $res[0];
         }

         return $fields;
      }

   }
?>
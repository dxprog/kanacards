<?php

namespace DxCMS {

    class Core {
    
        public static function init($appNamespace) {
            
            // Open up a connection to the database
            if (defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS') && defined('DB_NAME')) {
                Lib\Db::Connect('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
            }
            
            // Parse the incoming URL request
            Lib\Url::parseUrlRequest();
        
        }
        
        public static function raiseError() {
        
        }
        
    }

}
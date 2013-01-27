<?php

namespace Kanacards\Controller {
    
    use \Kanacards\Model;
    use stdClass;
    
    class User implements \DxCMS\Lib\Controller {
        
        /**
         * Default method for GET requests
         */
        public static function getDefault($request) {
            
            $retVal = new stdClass;
            
            switch ($request->method) {
                case 'default':
                default:
                    
                    if (isset($request->facebook)) {
                        $retVal->template = 'login';
                        $retVal->loginUrl = $request->facebook->getLoginUrl();
                    }
                    
                    break;
            }
            
            return $retVal;
            
        }
        
        /**
         * Default method for POST requests
         */
        public static function postDefault($request) {
        
        }
        
        /**
         * Default method for PUT requests
         */
        public static function putDefault($request) {
        
        }
        
        /**
         * Default method for DELETE requests
         */
        public static function deleteDefault($request) {
        
        }
        
        public static function getFbLogin($request) {
            
            
            
        }
        
    }

}
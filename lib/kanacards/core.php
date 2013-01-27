<?php

namespace Kanacards {

    use \DxCMS\Lib;
    use \Facebook;
    use stdClass;

    class Core implements \DxCMS\Lib\Controller {
        
        /**
         * Default method for GET requests
         */
        public static function getDefault($request) {
            
            $retVal = null;
            
            // Set up the user's session if one hasn't been created
            if (!isset($_SESSION['user'])) {
                $facebook = new \Facebook\Facebook([ 'appId' => FB_APP, 'secret' => FB_SECRET ]);
                if ($facebook) {
                    
                    $userId = $facebook->getUser();
                    
                    if (0 === $userId) {
                        $request->facebook = $facebook;
                        return Controller\User::getDefault($request);
                    } else {
                    
                        // Verify the user, creating one if it doesn't exist
                        $user = $facebook->api('me/');
                        $user = Model\User::verifyFacebookUser($user, true);
                        $_SESSION['user'] = $user;
                        session_write_close();
                        return Controller\Cards::getDefault($request);
                    }
                    
                }
            } else {
                return Controller\Cards::getDefault($request);
            }
            
            
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
    
    }

}
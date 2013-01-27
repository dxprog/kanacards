<?php

namespace Kanacards\Model {
    
    use \DxCMS\Lib;
    
    class User extends \DxCMS\Lib\Dal {
    
        /**
         * Database column to object property mapping
         */
        protected $_dbMap = [
            'id' => 'user_id',
            'userName' => 'user_username',
            'firstName' => 'user_firstname',
            'lastName' => 'user_lastname'
        ];
    
        /**
         * Database table
         */
        protected $_dbTable = 'users';
        
        /**
         * Property that represents the primary key in the database
         */
        protected $_dbPrimaryKey = 'id';
        
        /**
         * Facebook ID of the user
         */
        public $id;
        
        /**
         * User's screen name
         */
        protected $userName;
        
        /**
         * User's first name
         */
        protected $firstName;
        
        /**
         * User's last name
         */
        protected $lastName;
        
        /**
         * Verifies that a Facebook user is in the database. If not, the record can be created
         * @param $user object Facebook user object
         * @param $create bool Whether to create the user record if it doesn't already exist
         * @return mixed User object if the record exists/is created, null if nothing
         */
        public static function verifyFacebookUser($fbUser, $create) {
        
            $retVal = null;
        
            if (is_array($fbUser) && isset($fbUser['id'])) {
            
                $user = new User($fbUser['id']);
                if ((int) $user->id === (int) $fbUser['id']) {
                    $retVal = $user;
                } else {
                    
                    $user->id = (int) $fbUser['id'];
                    $user->userName = $fbUser['username'];
                    $user->firstName = $fbUser['first_name'];
                    $user->lastName = $fbUser['last_name'];
                    
                    if ($user->sync(true)) {
                        $retVal = $user;
                    }
                    
                }
            
            }
            
            return $retVal;
        
        }
    
    }

}
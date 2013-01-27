<?php

namespace Kanacards\Model {
    
    use \DxCMS\Lib;
    
    class Card extends \DxCMS\Lib\Dal {
    
        /**
         * Database column to object property mapping
         */
        protected $_dbMap = [
            'id' => 'card_id',
            'word' => 'card_word',
            'translation' => 'card_translation',
            'userId' => 'user_id',
            'languageId' => 'language_id',
            'dateCreated' => 'card_created'
        ];
    
        /**
         * Database table
         */
        protected $_dbTable = 'cards';
        
        /**
         * Property that represents the primary key in the database
         */
        protected $_dbPrimaryKey = 'id';
        
        /**
         * ID of the card
         */
        public $id = 0;
        
        /**
         * Foreign language word
         */
        public $word;
        
        /**
         * English translated meaning of the word
         */
        public $translation;
        
        /**
         * ID of user that created the card
         */
        public $userId;
        
        /**
         * Language ID
         */
        public $languageId;
        
        /**
         * The date this card was added
         */
        public $dateCreated;
        
        /**
         * Returns the cards that the user has completed the fewest number of times
         */
        public static function getLeastUsedCards($userId, $max = 20) {
        
        }
        
        /**
         * Returns the cards that the user has gotten wrong the most number of times
         */
        public static function getTroubleCards($userId, $max = 20) {
        
        }
        
        /**
         * Returns the latest cards added
         */
        public static function getNewestCards($max = 20) {
        
        }
    
    }

}
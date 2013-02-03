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
            
            $retVal = [];
            $query = 'SELECT c.*, '
                   . 'SUM(a.answer_correct) / COUNT(1) AS correct '
                   . 'FROM answers a INNER JOIN cards c '
                   . 'ON c.card_id = a.card_id WHERE '
                   . 'a.user_id = :userId GROUP BY a.card_id '
                   . 'ORDER BY correct ASC LIMIT ' . $max;
                   
            $result = \DxCMS\Lib\Db::query($query, [ ':userId' => $userId ]);
            
            while ($row = \DxCMS\Lib\Db::fetch($result)) {
                $retVal[] = new Card($row);
            }
            return $retVal;
        }
        
        /**
         * Returns the latest cards added
         */
        public static function getNewestCards($max = 20) {
            
            
            
        }
        
        /**
         * Returns a random set of cards
         */
        public static function getRandomCards($max = 20) {
            
            $retVal = [];
            $result = \DxCMS\Lib\Db::query('SELECT * FROM cards ORDER BY RAND() LIMIT ' . $max);
            while ($row = \DxCMS\Lib\Db::fetch($result)) {
                $retVal[] = new Card($row);
            }
            return $retVal;
            
        }
    
    }

}
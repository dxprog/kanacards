<?php

namespace Kanacards\Controller {

    use Exception;
    use stdClass;

    class Cards implements \DxCMS\Lib\Controller {
    
        /**
         * Default method for GET requests
         */
        public static function getDefault($request) {
            header('Location: /cards/menu/');
            exit;
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
        
        /**
         * Gets cards by varying criteria
         */
        public static function getDrill($request) {
            
            $retVal = null;
            
            switch ($request->queryString->type) {
                case 'random':
                    $retVal = \Kanacards\Model\Card::getRandomCards();
                    break;
            }
        
            return $retVal;
        
        }
        
        /**
         * Saves a user's answer to the database
         */
        public static function postAnswer($request) {
            
            if (isset($_SESSION['user'])) {
            
                $cardId = \DxCMS\Lib\Url::getInt('cardId', null, $_POST);
                $correct = \DxCMS\Lib\Url::getBool('correct', $_POST);
                echo $cardId;
                if ($cardId) {
                
                    \DxCMS\Lib\Db::query('INSERT INTO answers VALUES (:userId, :cardId, :correct, :date)', [
                        ':userId' => $_SESSION['user']->id,
                        ':cardId' => $cardId,
                        ':correct' => $correct,
                        ':date' => time()
                    ]);
                
                }
            
            }
            
        }
        
        /**
         * Displays the main application. Javascript handles the display from here on out
         */
        public static function getMenu($request) {
            $retVal = new stdClass;
            $retVal->template = 'main';
            return $retVal;
        }
        
        /**
         * Creates a new card
         */
        public static function postCreate($request) {
            
            $retVal = null;
            
            // User must be logged in to create new cards
            if (isset($_SESSION['user'])) {
                
                $word = \DxCMS\Lib\Url::get('word', null, $_POST);
                $translation = \DxCMS\Lib\Url::get('translation', null, $_POST);
                $languageId = \DxCMS\Lib\Url::getInt('languageId', DEFAULT_LANGUAGE, $_POST);
                
                if ($word && $translation) {
                    $card = new \Kanacards\Model\Card();
                    $card->word = $word;
                    $card->translation = $translation;
                    $card->dateCreated = time();
                    $card->userId = $_SESSION['user']->id;
                    $card->languageId = $languageId;
                    $retVal = $card->sync();
                }
                
            } else {
                throw new Exception('You must be logged in to create cards');
            }
        
            return $retVal;
        
        }
    
    }

}
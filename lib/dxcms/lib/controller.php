<?php

namespace DxCMS\Lib {
    
    interface Controller {
    
        public static function getDefault($request);
        public static function postDefault($request);
        public static function putDefault($request);
        public static function deleteDefault($request);
    
    }
    
}
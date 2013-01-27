<?php

namespace DxCMS\Lib {

    use Exception;

    class Display {
        
        /**
         * Renders the object against the template file. Returns the results of the render
         * @param string $templateFile    Name of the template file in the view/ directory
         * @param object $object          Object to render against the template
         */
        public static function render($templateFile, $object, $cacheKey = null, $cacheDuration = 600) {
            
            $retVal = null;
            
            // If there is no extension on the template file, add .tpl
            $templateFile .= strpos($templateFile, '.') === false ? '.tpl' : '';
            
            // If a cache key was provided, attempt to load from that first
            if (null !== $cacheKey) {
                $retVal = Cache::Get($cacheKey);
            }
            
            if (!$retVal && is_readable(PATH_VIEW . $templateFile)) {
                $template = @file_get_contents(PATH_VIEW . $templateFile);
                
                if ($template) {
                    $mustache = new \Mustache_Engine();
                    $retVal = $mustache->render($template, $object);
                    
                    if ($retVal && $cacheKey) {
                        Cache::Set($cacheKey, $retVal, $cacheDuration);
                    }
                    
                } else {
                    throw new Exception('Template file "' . $templateFile . '" is empty');
                }
            } else {
                throw new Exception('Template file "' . $templateFile . '" is unreadble or non-existant');
            }
            
            return $retVal;
        
        }
    
    }

}
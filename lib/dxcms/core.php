<?php

namespace DxCMS {
    
    use Exception;
    use stdClass;
    
    class Core {
        
        public static $appName;
        
        public static function init($appNamespace) {
            
            self::$appName = $appNamespace;
            
            // Set the exception handler
            set_exception_handler('DxCMS\Core::catchError');
            
            // Set the default timezone
            date_default_timezone_set(DEFAULT_TIMEZONE);
            
            // Begin the user session
            session_start();
            
            // Open up a connection to the database
            if (defined('DB_HOST') && defined('DB_USER') && defined('DB_PASS') && defined('DB_NAME')) {
                Lib\Db::Connect('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
            }
            
            $out = null;
            
            // Parse the incoming URL request
            $request = Lib\Url::parseUrlRequest();
            if ('default' != $request->class) {
                
                // Ensure that the class exists in the application's controller
                $class = $appNamespace . '\\Controller\\' . $request->class;
                if (class_exists($class)) {
                    // Verify the method called exists in the controller
                    $method = $request->operation . $request->method;
                    if (method_exists($class, $method)) {
                        $out = call_user_func($class . '::' . $method, $request);
                    } else {
                        throw new Exception('Method "' . $method . '" does not exist in "' . $class . '"', 404);
                    }
                } else {
                    throw new Exception('Controller "' . $request->class . '" does not exist in "' . $appNamespace . '"', 404);
                }
                
            } else {
                
                // Call the application's handlers for this type of request
                $class = $appNamespace . '\\Core';
                $method = $request->operation . 'Default';
                if (class_exists($class) && method_exists($class, $method)) {
                    $out = call_user_func($class . '::' . $method, $request);
                } else {
                    throw new Exception('Application "' . $appNamespace . '" does not have a Core class or Core is malformed');
                }
            
            }
            
            // Render the output by the type specified
            $contentType = '';
            $render = '';
            switch ($request->output) {
                case 'json':
                    $contentType = 'text/javascript';
                    $render = json_encode($out);
                    break;
                case 'display':
                    $contentType = 'text/html; charset=utf-8';
                    $render = Lib\Display::render($out->template, $out);
                    break;
            }
            
            echo $render;
        
        }
        
        public static function catchError($e) {
            print_r($e);
        }
        
    }

}
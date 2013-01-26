<?php

namespace DxCMS\Lib {

    use Exception;
    use stdClass;

	class Url {
		
		/**
		 * Associative array of params from the url rewrite
		 */
		public static $params = array();
		
		/**
		 * Host path
		 */
		public static $hostPath;
		
		/**
		 * Get's the domain and folder that the script is currently running from
		 */
		public static function getHostPath() {
			$t = explode('/', $_SERVER['SCRIPT_NAME']);
			array_pop($t);
			self::$hostPath = implode('/', $t) . '/';
			return self::$hostPath;
		}
		
		/**
		 * Returns the URL as it should appear in the user's address bar
		 */
		public static function getRawUrl() {
			return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');
		}
		
        /**
         * Parses the URL to retrieve the page requested
         */
        public static function parseUrlRequest() {
        
            $retVal = new stdClass;
            
            $retVal->operation = $_SERVER['REQUEST_METHOD'];
            $retVal->class = 'default';
            $retVal->method = 'default';
            $retVal->output = 'display';
            
            /*
                URL structure:
                
                /controller/[method]/[.output][?query=string]
            */
            
            if (preg_match('@/([\w]+)/([\w]+/)?(\.[\w]{3,4})?(\?[^/]+)?@', $_SERVER['REQUEST_URI'], $match)) {
                $retVal->class = $match[1];
                $retVal->method = count($match) >= 3 && strlen($match[2]) > 0 ? str_replace('/' , '', $match[2]) : 'default';
                $retVal->output = count($match) >= 4 && strlen($match[3]) > 0 ? $match[3] : 'display';
                $retVal->queryString = count($match) == 5 ? $match[4] : null;
                
                // Break out the query string into key/value pairs
                if (null != $retVal->queryString) {
                    $retVal->queryString = substr($retVal->queryString, 1);
                    $params = explode('&', $retVal->queryString);
                    $retVal->queryString = new stdClass;
                    foreach ($params as $param) {
                        $kvp = explode('=', $param, 2);
                        if (count($kvp) == 1) {
                            $retVal->queryString->$kvp[0] = true;
                        } else {
                            $retVal->queryString->$kvp[0] = urldecode($kvp[1]);
                        }
                    }
                }
                
            }
            
            return $retVal;
        
        }
        
		/**
		 * Takes the URI and extracts parameters as specified in the rewrite file
		 */
		public static function rewrite($configFile) {
			
			$uri = current(explode('?', $_SERVER['REQUEST_URI']));
			$retVal = $uri === '/';
			
			if (!$retVal) {
			
				// Seperate out any actual GET parameters that may have been passed along and store appropriately
				if (strpos($uri, '?') !== false) {
					$uri = explode('?', $uri);
					$get = $uri[1];
					$_SERVER['QUERY_STRING'] = $get;
					$uri = $uri[0];
					$get = explode('&', $get);
					foreach ($get as $param) {
						$p = explode('=', $param);
						$_GET[$p[0]] = $p[1];
					}
				}
				
				$path = self::getHostPath();
				$uri = str_replace(substr($path, 0, strlen($path)  - 1), '', $uri);
				if ($uri{0} == '/') {
					$uri = substr($uri, 1);
				}
				
				$rewrites = json_decode(@file_get_contents($configFile));
				if ($rewrites) {
					
					$qs = null;
					foreach($rewrites as $rewrite) {
						$expr = '@' . $rewrite->rule . '@is';
						
						if (preg_match($expr, $uri)) {
							$qs = preg_replace($expr, $rewrite->replace, $uri);
						}
						
						if ($qs && isset($rewrite->redirect) && $rewrite->redirect === true) {
							header('Location: ' . $qs);
							exit();
						} else if ($qs) {
							
							$params = explode('&', $qs);
							foreach ($params as $param) {
								$temp = explode('=', $param);
								self::$params[$temp[0]] = $temp[1];
								$_GET[$temp[0]] = $temp[1];
							}
							
							$retVal = true;
							break;
							
						}
						
					}
					
				} else {
					throw new Exception('URL_REWRITE: Congig file empty or malformed');
				}
				
			}
			
			return $retVal;
			
		}
		
		/**
		 * Gets an item from POST and cleans magic quotes if necessary
		 */
		public static function Post($param, $isInt = false) {
			$retVal = null;
			if (isset($_POST[$param])) {
				$retVal = get_magic_quotes_gpc() > 0 ? stripslashes($_POST[$param]) : $_POST[$param];
			}
			
			if ($isInt && $retVal) {
				if (!is_numeric($retVal)) {
					$retVal = null;
				}
			}
			
			if ($retVal) {
				$retVal = trim($retVal);
			}
			
			return $retVal;
		}
		
		/**
		 * Gets the requested item off the query string if it exists
		 */
		public static function get($param, $default = false, $source = null) {
			$source = $source ?: $_GET;
			return isset($source[$param]) ? $source[$param] : $default;
		}
		
		/**
		 * Gets an int value off the query string. If the value exists but is NaN, returns null
		 */
		public static function getInt($param, $default = 0, $source = null) {
			$source = $source ?: $_GET;
			return isset($source[$param]) && is_numeric($source[$param]) ? intVal($source[$param]) : $default;
		}
		
		/**
		 * Gets a bool value off the query string
		 */
		public static function getBool($param, $source = null) {
			$source = $source ?: $_GET;
			return isset($source[$param]) && ($source[$param] === true || strtolower($source[$param]) === 'true') ? true : false;
		}
		
		

	}
	
}

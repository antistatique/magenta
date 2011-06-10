<?php

class asTools
{
   public static function debug($obj, $varname = 'var', $die = false)
   {
      echo '<pre>';
         echo "$varname = ";
         if(is_array($obj))
         {
            print_r($obj);
         }
         else
         {
            var_dump($obj);
         }
      echo '</pre>';
      if($die) die('DIE via asTools.');
   }
   
   public static function stripText($text)
   {
      $text = self::unspecializeText($text);
      $text = strtolower($text);

      // strip all non word chars
      $text = preg_replace('/\W/', ' ', $text);

      // replace all white space sections with a dash
      $text = preg_replace('/\ +/', '-', $text);

      // trim dashes
      $text = preg_replace('/\-$/', '', $text);
      $text = preg_replace('/^\-/', '', $text);

      return $text;
   }
   
   // replace special characters by something similar
   public static function unspecializeText($text)
   {
      $specials = array('&', 'á', 'Á', 'à', 'À', 'â', 'Â', 'å', 'Å', 'ã', 'Ã', 'ä', 'Ä', 'æ' , 'Æ' , 'ç', 'Ç', 'é', 'É', 'è', 'È', 'ê', 'Ê', 'ë', 'Ë', 'í', 'Í', 'ì', 'Ì', 'î', 'Î', 'ï', 'Ï', 'ñ', 'Ñ', 'ó', 'Ó', 'ò', 'Ò', 'ô', 'Ô', 'ø', 'Ø', 'õ', 'Õ', 'ö', 'Ö', 'ß' , 'ú', 'Ú', 'ù', 'Ù', 'û', 'Û', 'ü', 'Ü', 'ÿ', '´', '`');
      $save     = array('+', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'a', 'A', 'ae', 'AE', 'c', 'C', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'n', 'N', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'o', 'O', 'ss', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'y', '-', '-'); 
      return str_replace($specials, $save, $text);
   }
   
   
   public static function cutTextAfterWord($text, $width, $suffix = '...')
   {
      if(mb_strlen($text, 'UTF-8') <= $width)
      {
         return $text;
      }
      
      $wrap = wordwrap($text, $width, '|cut|');
      return substr($wrap, 0, strpos($wrap, '|cut|')).$suffix;
   }
   
   public static function cutText($text, $maxChars, $suffix = '...')
   {
      if(mb_strlen($text, 'UTF-8') <= $maxChars)
      {
         return $text;
      }
      
      return substr($text, 0, $maxChars).$suffix;
   }
   
   
   public static function clearSelectColumnsExceptAsColumns(&$criteria)
   {
      $asColumns = $criteria->getAsColumns();
      $criteria->clearSelectColumns();
      foreach($asColumns as $key => $val)
      {
         $criteria->addAsColumn($key, $val);
      }
   }
   
   /**
    * Serialize un tableau en string (element séparé par des virgules)
    *
    * @return String
    **/
   public static function serializeParamArray($array)
   {
      if(!is_array($array))
      {
         return $array;
      }
      
      if(count($array) <= 1)
      {
         return reset($array);
      }
      
      return implode('-', $array);
   }
   
   /**
    * Deserialize une chaine pour retrouver les donées tabulaire initiale.
    *
    * @return Array
    * @throw Exception if $string is not a string or an array
    */
   public static function deserializeParamArray($string)
   {
      if(!$string)
      {
         return ;
      }
      if(is_array($string))
      {
         return $string;
      }
      
      if(!is_string($string))
      {
         throw new Exception("param string is not a String!");
      }
      
      return explode('-', $string);
   }
   
   /**
    * Prevention on a uploaded filename
    *
    * @example './../secure/toto.jpg' return 'toto.jpg'
    * @example 'toto.php' return 'toto' (php extension removed, too dangerous)
    *
    * @param string $filename
    * @return string parsed filename
    */
   public static function secureFilename($filename)
   {
      $filename = trim(basename($filename));
      if('' == $filename || '.' == $filename)
      {
         return '';
      }
      
      return str_replace(array(DIRECTORY_SEPARATOR, '\\', '/', '..', '.php'), '', $filename);
   }
   
   /**
    * Add the protocol $protocol (default HTTP) to the URL if not already added
    *
    * @param $url the url to check
    * @param $protocol default = 'http'
    * @return the uri with the protocol added
    */
   public static function addProtocolToUrl($url, $protocol="http")
   {
      if(!$url || !is_string($url))
      {
         return $url;
      }
      
      $re = '`^(https?|ftp|'. preg_quote($protocol) .')://`';
      if(!preg_match($re, $url))
      {
         $url = $protocol.'://'.$url;
      }
      
      return $url;
   }
}
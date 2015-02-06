<?php 
namespace Acme\UploaderBundle\Lib;
 
class Globals
{
    protected static $uploadDir;
    
    public static function setUploadDir($dir)
    {
        self::$uploadDir = $dir;
    }
 
    public static function getUploadDir()
    {
        return self::$uploadDir;
    }
}
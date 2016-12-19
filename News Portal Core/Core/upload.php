<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 9/2/2016
 * Time: 12:56 PM
 */
class upload
{
    private static $_location, $_max_size, $_valid_ext = [];
    private static $_errors = [];
    private static $_upload_errors = [
        1 => "Larger than upload_max_filesize",
        2 => "Over limit size",
        3 => "Partial Upload",
        4 => "No file",
        6 => "No temporary directory",
        7 => "Can't write to disk",
        8 => "FILE upload stopped by extension"
    ];

    /** Initializes the configurations while uploading the images
     * @param array $configurations
     */
    public static function initialize($configurations = [])
    {
        self::$_location = $configurations['location'];
        self::$_max_size = $configurations['max_size'];
        self::$_valid_ext = explode('|', $configurations['valid_ext']);

    }

    /**Checks the upload extension, max size, tmp location etc for uploading the image
     * @param $uploadInfo
     * @return bool
     */
    public static function doUpload($uploadInfo)
    {
        $ext = strtolower(pathinfo($uploadInfo['name'], PATHINFO_EXTENSION));
        $name = md5(time().rand()) . ".{$ext}";

        if ($uploadInfo['error'] != 0) {
            //errors
            self::$_errors[] = self::$_upload_errors[$uploadInfo['error']];
            return false;

        } else {
            //no errors

            if ($uploadInfo['size'] > self::$_max_size) {
                self::$_errors[] = 'File Size Exceeds 5MB';
                return false;
            } elseif (!in_array($ext,self::$_valid_ext)) {
                self::$_errors[] = "Allowed types are ".implode(',',self::$_valid_ext);
                return false;
            }

            if (move_uploaded_file($uploadInfo['tmp_name'], self::$_location.$name)) {
                return $name;
            } else {
                return false;
            }

        }

    }


    /**Method to access the errors related while uploading the images
     * @return array
     */
    public static function getUploadErrors()
    {
        return self::$_errors;
    }


    /**Unlinks the files uploaded
     * @param $location
     * @return bool
     */
    public static function deleteFiles($location){
        return unlink($location);
    }



}





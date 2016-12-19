<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 9/5/2016
 * Time: 12:40 PM
 */
class pagination
{
    private static $_total_rows;
    public static $_limit,$_current_page;


    /**Initializes the limit total rows and current page
     * @param array $configuration
     * @return bool|int|string "Returns the Value for offset"
     */
    public static function initialize(array $configuration)
    {
        self::$_limit = $configuration['limit'];
        self::$_total_rows = $configuration['total_rows'];
        self::$_current_page = (int)!empty(Input::get('_p')) ? Input::get('_p') : 1;


        return $offset = (self::$_current_page - 1) * self::$_limit;
    }


    public static function createLinks()
    {
        $numOfPages = ceil(self::$_total_rows / self::$_limit);
        $output = "";

        $url = $_SERVER['REQUEST_URI'];
        $url = preg_replace('/&_p=./', '', $url);

        if ($numOfPages > 1) {

            $next = self::$_current_page + 1;
            $prev = self::$_current_page - 1;
            $output = "<ul class='pagination'>";
            if (self::$_current_page > 1) {
                $output .= "<li><a href='{$url}&_p={$prev}'>Prev</a></li>";
            }

            for ($i = 1; $i <= $numOfPages; $i++) {
                if (self::$_current_page == $i) {
                    $output .= "<li class='active'><span>{$i}</span></li>";
                } else {
                    $output .= "<li><a href='{$url}&_p={$i}'>{$i}</a></li>";
                }

            }

            if (self::$_current_page < $numOfPages) {
                $output .= "<li><a href='{$url}&_p={$next}'>Next</a></li>";
            }
            $output .= "</ul>";

        }
        return $output;

    }


}
<?php
    function print_arr($array){
    echo "<div style=\"background:#ffffff; color:#000000\">";
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    echo "</div>";
}
    function md25($str)
    {
        $str = md5($str);
        $str = md5(substr($str,2,7).$str);
        return $str;
    }
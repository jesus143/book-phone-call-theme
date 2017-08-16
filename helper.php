<?php
 if(!function_exists('print_r_pre')) {

     function print_r_pre($string)
     {
         print "<pre>";
         print_r($string);
         print "</pre>";
     }
 }
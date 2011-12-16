<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
    'always_recompile' => false, //Recompile the styles on each request
    'compress' => true, //Compres the css by removing whitespace
    'path'     => 'css/', // relative path to a writable folder to store compiled / compressed css
);
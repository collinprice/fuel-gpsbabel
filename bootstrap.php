<?php

Autoloader::add_core_namespace('GPSBabel');

Autoloader::add_classes(array(
    /**
     * GPSBabel classes.
     */
    'GPSBabel\\GPSBabel'                    => __DIR__.'/classes/gpsbabel.php',

    /**
     * GPSBabel exceptions.
     */
    'GPSBabel\\FileNotFoundException'    => __DIR__.'/classes/gpsbabel.php',
    'GPSBabel\\GPSBabelCommandNotFoundException'    => __DIR__.'/classes/gpsbabel.php',
    
));
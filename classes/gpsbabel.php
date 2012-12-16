<?php

namespace GPSBabel;

class FileNotFoundException extends \FuelException {}
class GPSBabelCommandNotFoundException extends \FuelException {}

class GPSBabel {

    protected static $_instance = false;
    protected static $_defaults;

    public static function forge(array $custom = array()) {

        $custom = ! is_array($custom) ? array() : $custom;
        static::$_defaults = \Arr::merge(static::$_defaults, $custom);

        if (!shell_exec(static::$_defaults['gpsbabel_command_path'] . ' -V')) {
            throw new GPSBabelCommandNotFoundException();
        } else {
            $_instance = true;
        }
    }

    /**
     * Init, config loading.
     */
    public static function _init()
    {
        \Config::load('gpsbabel', true);
        static::$_defaults = \Config::get('gpsbabel');
    }

    /**
     * Prevent instantiation
     */
    final private function __construct() {}

    public static function convert($input_filename) {

        if (! static::$_instance) {
            static::forge();
        }

        $input_file = static::$_defaults['input_directory'] . '/' . $input_filename;
        $dot_index = strrpos($input_filename, '.');

        if (! $dot_index || !file_exists($input_file)) {
            throw new FileNotFoundException();
        }

        $name = substr($input_filename, 0, $dot_index);
        $format = substr($input_filename, $dot_index+1);

        
        $temp_name = tempnam(static::$_defaults['output_directory'], 'temp_');
        if ($temp_name) {
            rename($temp_name, $temp_name . '.' . static::$_defaults['output_format']);
            $output_file = $temp_name . '.' . static::$_defaults['output_format'];
            chmod($output_file, 0644);

            $cmd = sprintf('%s -i %s -f %s -o %s -F %s', 
                static::$_defaults['gpsbabel_command_path'], 
                escapeshellcmd($format), escapeshellcmd($input_file),
                static::$_defaults['output_format'], escapeshellcmd($output_file));

            exec($cmd, $output, $return_var);

            if ($return_var === 0) {

                // Get filename
                $dot_index = strrpos($output_file, '/');
                return substr($output_file, $dot_index+1);
            } else {
                unlink($output_file);
                return false;
            }
        } else {
            return false;
        }
        
    }
}


# GPSBabel

A FuelPHP package that allows you to use the [GPSBabel](http://www.gpsbabel.org/) library to convert your gps files.

## Usage

	GPSBabel::convert('filename');

## Config

	'output_format' => 'gpx', // Default output file format
	'input_directory' => DOCROOT.'uploads', // Directory of input files
	'output_directory' => DOCROOT,'uploads', // Destination of output files
	'gps_command_path' => '/usr/local/bin/gpsbabel', // Full path to gpsbabel command

## Exceptions

	+ \FileNotFoundException, thrown when input file does not exist
	+ \GPSBabelCommandNotFoundException, thrown when GPSBabel is not installed on the machine or the wrong directory was specified

<?php

/**
 * Simple Filter (simple_filter.php) (c) by Jack Szwergold
 *
 * Simple Filter is licensed under a
 * Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.
 *
 * You should have received a copy of the license along with this
 * work. If not, see <http://creativecommons.org/licenses/by-nc-sa/4.0/>.
 *
 *  w: http://www.preworn.com
 *  e: me@preworn.com
 *
 * Created: 2014-07-04, js
 * Version: 2014-07-04, js: creation
 *          2014-07-05, js: development & cleanup
 *          2014-07-06, js: development & cleanup
 *
 */

// Set the filename.
// $filename = 'samples/snippet_clean.html';
$filename = 'samples/snippet_clean_mangled.html';
$filename = 'samples/snippet_source_mangled.html';

$string_raw = file_get_contents($filename);

// Set a character set array.
$charset_array = array();
$charset_array[] = 'ISO-8859-1';
$charset_array[] = 'ISO-8859-2';
$charset_array[] = 'ISO-8859-3';
$charset_array[] = 'ISO-8859-4';
$charset_array[] = 'ISO-8859-5';
$charset_array[] = 'ISO-8859-6';
$charset_array[] = 'ISO-8859-7';
$charset_array[] = 'ISO-8859-8';
$charset_array[] = 'ISO-8859-9';
$charset_array[] = 'ISO-8859-10';
$charset_array[] = 'ISO-8859-11';
$charset_array[] = 'ISO-8859-12';
$charset_array[] = 'ISO-8859-13';
$charset_array[] = 'ISO-8859-14';
$charset_array[] = 'ISO-8859-15';
$charset_array[] = 'ISO-8859-16';

// Get a character set array from PHP internal encodings.
// $charset_array = mb_list_encodings();

// Pick a random character set from the array.
$charset_rand = $charset_array[rand(0, count($charset_array) - 1)];
$charset = $charset_rand;
$charset = 'windows-1252';

header('Content-Type: text/html; charset=' . $charset);

echo '<pre>';

echo $charset;
echo '<br /><br />';

echo $string_raw;
echo '<br /><br />';

// echo 'Corrupted Original: '. '±€ÁÖºñ¿£“¯·’¿©';
// echo '<br /><br />';

echo '</pre>';

if (TRUE) {
  echo '<pre>';
  print_r(mb_list_encodings());
  echo '</pre>';
}

die();

?>
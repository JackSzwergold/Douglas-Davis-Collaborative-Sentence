<?php

/**
 * Index Controller (index.php) (c) by Jack Szwergold
 *
 * Index Controller is licensed under a
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
 *
 */

//**************************************************************************************//
// Require the basic configuration settings & functions.

require_once 'lib/characterDisplay.class.php';

//**************************************************************************************//
// Define stuff.

// Set the filename.
// $filename = 'samples/snippet_clean.html';
// $filename = 'samples/snippet_clean_mangled.html';
$filename = 'samples/snippet_source_mangled.html';

// Get the file contents.
$string_raw = file_get_contents($filename);

// Detect if a UTF-8 BOM is set & strip it to make the data clean.
$has_bom = false;
$bom = pack("CCC", 0xef, 0xbb, 0xbf);
if (0 == strncmp($string_raw, $bom, 3)) {
  $has_bom = true;
  $string_raw = substr($string_raw, 3);
}

// Set the character set.
$charset = 'UTF-8';

// Set the iconv settings.
$iconv_src = 'windows-1252';
$iconv_dest = 'UTF-8';

//**************************************************************************************//
// Init the "characterDisplay()" class.

$frontendDisplayClass = new characterDisplay($charset, $string_raw, $iconv_src, $iconv_dest);
$html = $frontendDisplayClass->renderContent();

//**************************************************************************************//
// Output the stuff.

// header('Content-Type: text/plain; charset=' . $charset);
header('Content-Type: text/html; charset=' . $charset);
echo $html;

?>
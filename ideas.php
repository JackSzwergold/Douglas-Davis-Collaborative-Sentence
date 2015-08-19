<?php

/**
 * Ideas (ideas.php) (c) by Jack Szwergold
 *
 * Ideas is licensed under a
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

//**************************************************************************************//
// Ideas.


// 234:180:145

header('Content-Type: text/html; charset=UTF-8');
// header('Content-Type: text/html; charset=windows-1252');

$val_dec = 44305;
$val_hex = 'eab491';
$val_hex = 'b1a4c1';

echo '<pre>';

echo 'UTF-16 Dec:	';
echo mb_convert_encoding('&#' . intval($val_dec) . ';', 'UTF-8', 'HTML-ENTITIES');
echo '<br /><br />';

echo 'UTF-8 Hex:	';
echo hex2bin($val_hex);
echo '<br /><br />';

echo 'Foo:	';
echo mb_convert_encoding(hex2bin($val_hex), 'UTF-8', 'Windows-1252');
// echo iconv ('Windows-1252', 'UTF-8', hex2bin($val_hex));
echo '<br /><br />';

echo '</pre>';

die();


if (false) {

mb_internal_encoding("UTF-8");
$string_raw = file_get_contents('snippet_good.html');

$string_raw = '↗';
$char = mb_substr($string_raw, 0, 1);

header('Content-Type: text/html; charset=UTF-8');

echo $char;
echo '<br /><br />';

echo 'Hex: ' . bin2hex($char);
echo '<br /><br />';

echo 'Ord: ' . base_convert(bin2hex($char), 16, 10);
echo '<br /><br />';

$html_entity = unicode_to_html_entity($char);

echo $html_entity;
echo '<br /><br />';

echo htmlentities($html_entity);
echo '<br /><br />';

echo bin2hex(mb_convert_encoding($char, 'UTF-16', 'UTF-8'));
echo '<br /><br />';

echo hexdec(bin2hex(mb_convert_encoding($char, 'UTF-16', 'UTF-8')));
echo '<br /><br />';

echo bin2hex(mb_convert_encoding($char, 'UTF-32', 'UTF-8'));
echo '<br /><br />';

echo hexdec(bin2hex(mb_convert_encoding($char, 'UTF-32', 'UTF-8')));
echo '<br /><br />';

function unicode_to_html_entity($char) {
  $ret = preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($m) {
    $char = current($m);
    $utf = iconv('UTF-8', 'UCS-4', $char);
    return sprintf("&#x%s;", ltrim(strtoupper(bin2hex($utf)), "0"));
  }, $char);
  return $ret;
} // unicode_to_html_entity

function utf8_to_rtf($utf8_text) {
  $utf8_patterns = array(
      "[\xC2-\xDF][\x80-\xBF]",
      "[\xE0-\xEF][\x80-\xBF]{2}",
      "[\xF0-\xF4][\x80-\xBF]{3}",
  );
  $new_str = $utf8_text;
  foreach($utf8_patterns as $pattern) {
    $new_str = preg_replace("/($pattern)/e",
      // "'\u'.hexdec(bin2hex(mb_convert_encoding('$1', 'UTF-16', 'UTF-8'))).'?'",
      "hexdec(bin2hex(mb_convert_encoding('$1', 'UTF-16', 'UTF-8')))",
        $new_str);
  }
  return $new_str;
}



$a = utf8_encode($char);
$b = unpack('C*', $a);

echo '<pre>';
print_r($b);
echo '</pre>';


die();

}

if (FALSE) {
  echo '<pre>';
  print_r(mb_list_encodings());
  echo '</pre>';
}


// Create the image
$im = imagecreatetruecolor(400, 30);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $white);

// The string with character sets
for($i = 0; $i < 25; $i++){
     $text .= chr($i);
}
//$text = implode('', range(a,z));
//$text .= implode('', range(0,z));

// Replace path by your own font path
$font = '/Library/Fonts/Arial.ttf';

// Add the text
imagettftext($im, 20, 0, 10, 20, $black, $font, $text);

// Set the content-type
header('Content-Type: image/png');

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im, 'foo.png');
imagedestroy($im);

die();


require_once('php_character_map_generator.php');

charmap("/Library/Fonts/Arial.ttf", 14, range(0, 255), "png|9");


die();

?>
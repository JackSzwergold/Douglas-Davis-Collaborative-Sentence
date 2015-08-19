<?php

/**
 * Character Display Class (characterDisplay.class.php) (c) by Jack Szwergold
 *
 * Character Display Class is licensed under a
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
// Here is where the magic happens!

class characterDisplay {

  private $charset = 'UTF-8';
  private $string_raw = '';
  private $iconv_src = 'UTF-8';
  private $iconv_dest = 'UTF-8';

  public function __construct($charset, $string_raw, $iconv_src, $iconv_dest) {

    $this->charset = $charset;
    $this->string_raw = $string_raw;
    $this->iconv_src = $iconv_src;
    $this->iconv_dest = $iconv_dest;

  } // __construct

  public function renderContent() {

    $ret = '<!DOCTYPE html>'
         . '<html>'
         . '<head>'
         . '<meta http-equiv="content-type" content="text/html; charset=' . $this->charset . '" />'
         . '<title>davis_collaborative_sentence</title>'
         . '<link rel="stylesheet" href="css/style.css" type="text/css" />'
         . '</head>'
         . '<body>'
         . $this->renderTable()
         . '</body>'
         . '</html>'
         ;

    return $ret;

  } // renderContent

  private function renderTable() {

    list($headers, $rows) = $this->renderTableRows();

    $ret = '<table>'
         . '<tr>'
         . '<th colspan="'. count($headers) . '" class="mono">'
         . $this->charset
         . '</th>'
         . '</tr>'
         . '<tr>' . implode('', $headers) . '</tr>'
         . implode('', $rows)
         . '</table>'
         ;

    return $ret;

  } // renderTable

  private function processTableRows($string_value) {

    $utf8_hex = $this->utf8_hex($string_value);
    $string_ord = $this->string_ord($utf8_hex);
    $utf8_bin = $this->utf8_bin($string_ord);
    $utf16_hex = $this->utf16_hex($string_value);
    $utf16_dec = $this->utf16_dec($string_value);

    $iconv = iconv($this->iconv_src, $this->iconv_dest, $string_value);

    $detected = mb_detect_encoding($string_value, "auto");

    $table_rows = array();
    $table_rows['ord'] = $string_ord;
    $table_rows['utf8_hex'] = $utf8_hex;
    $table_rows['utf8_bin'] = $utf8_bin;
    $table_rows['utf16_hex'] = $utf16_hex;
    $table_rows['utf16_dec'] = $utf16_dec;
    $table_rows['string'] = $string_value;
    $table_rows['iconv'] = $iconv;
    $table_rows['detected'] = $detected;

    $this->table_headers = array_keys($table_rows);

    // Set class coloring if the ASCII code is above 127.
    $class = ($string_ord > 127) ? 'highbit' : '';

    // Loop through the table rows.
    foreach ($table_rows as $table_row_key => $table_row_value) {
      $row_data .= '<td class="mono ' . $class . '">'
                 . $table_row_value
                 . '</td>'
                 ;
    }

    // Return the final table rows.
    return '<tr>' . $row_data . '</tr>';

  } // processTableRows

  private function renderTableRows() {

    // Split a multibyte string.
    $string_is_multibyte = true;
    $string_array = preg_split('/(?<!^)(?!$)/u', $this->string_raw);

    if (count($string_array) == 1) {
      $string_is_multibyte = false;
      $string_array = str_split($this->string_raw);
    }

    $rows = array();
    foreach ($string_array as $string_key => $string_value) {
      $rows[] = $this->processTableRows($string_value);
    }

    // Process the header values.
    $headers = array();
    foreach ($this->table_headers as $header) {
      $headers[] = '<th class="mono">'
                 . $header
                 . '</th>'
                 ;
    }

    // Set the final header row.
    $header_rows = array('<tr>' . implode('', $headers) . '</tr>');

    // Return the headers & rows.
    return array($headers, $rows);

  } // renderTableRows

  private function utf8_hex($string_value) {

    $ret = bin2hex($string_value);
    $ret = substr(chunk_split($ret, 2, ':'), 0, -1);

    return $ret;

  } // utf8_hex

  private function string_ord($utf8_hex) {

    $utf8_hex_array = explode(':', $utf8_hex);
    $string_ord_parts = array();
    foreach ($utf8_hex_array as $utf8_hex_array_value) {
      $string_ord_parts[] = hexdec($utf8_hex_array_value);
    }
    $ret = join(':', $string_ord_parts);

    return $ret;

  } // string_ord

  private function utf8_bin($string_ord) {

    $string_ord_array = explode(':', $string_ord);
    $utf8_bin_parts = array();
    foreach ($string_ord_array as $string_ord_array_value) {
      $utf8_bin_parts[] = str_pad(base_convert($string_ord_array_value, 10, 2), 8, 0, STR_PAD_LEFT);
    }
    $ret = join(':', $utf8_bin_parts);

    return $ret;

  } // utf8_bin

  private function utf16_hex($string_value) {

    $ret = bin2hex(mb_convert_encoding($string_value, 'UTF-16', 'UTF-8'));

    return $ret;

  } // utf16_hex

  private function utf16_dec($string_value) {

    $ret = hexdec(bin2hex(mb_convert_encoding($string_value, 'UTF-16', 'UTF-8')));

    return $ret;

  } // utf16_dec

  private function uniord($u) {
    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
    $k1 = ord(substr($k, 0, 1));
    $k2 = ord(substr($k, 1, 1));
    return $k2 * 256 + $k1;
  }

  private function unicode_to_html_entity($char) {
    $ret = preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($m) {
      $char = current($m);
      $utf = iconv('UTF-8', 'UCS-4', $char);
      return sprintf("&#x%s;", ltrim(strtoupper(bin2hex($utf)), "0"));
    }, $char);
    return $ret;
  } // unicode_to_html_entity

} // characterDisplay

?>
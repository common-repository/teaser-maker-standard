<?php

// ***************************************************************************
// WEBWIZ_CODE_LIBRARY / STRING_UTILS.PHP
// (C) 2010-2014 Peter Newman. All Rights Reserved.
// ***************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils ;

    // =======================================================================
    // OVERVIEW!
    // ---------
    // Some useful string utilities...
    // =======================================================================

// ===========================================================================
// starts_with()
// ===========================================================================

function starts_with( $haystack , $needle , $ignore_case = FALSE ) {

    if ( $ignore_case ) {
        return stripos( $haystack , $needle , 0 ) === 0 ;
                    //  Returns the position as an integer. If needle is
                    //  not found, strpos() will return boolean FALSE.
    }

    return strpos( $haystack , $needle , 0 ) === 0 ;

}

// ===========================================================================
// ends_with()
// ===========================================================================

function ends_with( $haystack , $needle , $ignore_case = FALSE ) {

    $expectedPosition = strlen( $haystack ) - strlen( $needle ) ;

    if ( $ignore_case ) {
        return strripos( $haystack , $needle, 0 ) === $expectedPosition ;
    }

    return strrpos( $haystack , $needle , 0 ) === $expectedPosition ;

}

// ===========================================================================
// contains()
// ===========================================================================

function contains( $haystack , $needle , $ignore_case = FALSE ) {

    if ( $ignore_case ) {
        return stripos( $haystack , $needle ) !== FALSE ;
                    //  Returns the position as an integer. If needle is
                    //  not found, strpos() will return boolean FALSE.
    }

    return strpos( $haystack , $needle ) !== FALSE ;
                //  Returns the position as an integer. If needle is
                //  not found, strpos() will return boolean FALSE.

}

/*
// ===========================================================================
// get_after()
// ===========================================================================

function after( $instr , $prefix , $strict = FALSE ) {

    //  Returns that part of $instr AFTER $prefix.

    return substr( $instr , strlen( $prefix ) ) ;

}

// ===========================================================================
// path_after()
// ===========================================================================

function path_after( $instr , $prefix , $strict = FALSE ) {

    //  Returns that part of $instr AFTER $prefix.

    function path_after( $instr , $prefix , $strict = FALSE ) {
    return trim_slashes( substr( $instr , strlen( $prefix ) ) ) ;

}

            trim_slashes( after( trim_slashes( ABSPATH ) , TESTPRESS_TEST_SITES_DIR ) )
*/

// ===========================================================================
// before()
// ===========================================================================

// ===========================================================================
// between()
// ===========================================================================


// ===========================================================================
// question_stripslashes()
// ===========================================================================

function question_stripslashes( $instr ) {
    if ( get_magic_quotes_gpc() ) {
        return stripslashes( $instr ) ;
    }
    return $instr ;
}

// ===========================================================================
// to_lines()
// ===========================================================================

function to_lines( $instr ) {

    // -----------------------------------------------------------------------

    if ( $instr === '' ) {
        return array() ;
    }

    // =======================================================================
    // Split the (non-empty) string into an array of lines...
    // =======================================================================

    // -----------------------------------------------------------------------
    // Note that the script can use any of the commmonly used line
    // terminators:-
    //      CRLF        Windows
    //      LF          Linux/Unix
    //      CR          Mac
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // array preg_split ( string $pattern , string $subject [, int $limit [, int $flags ]] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Split the given string by a regular expression.
    //
    // Returns an array containing substrings of subject split along
    // boundaries matched by pattern.
    // -----------------------------------------------------------------------

    $lines = preg_split(
                    '/\\n|\\r\\n|\\r/'      ,
                    $instr
                    ) ;

//pr( $lines , '$lines' ) ;

    // -----------------------------------------------------------------------
    // NOTE!
    // -----
    // Some testing as to how "preg_split()" works reveals:-
    //
    //      1.  $lines = preg_split( '' )
    //
    //              -->     $lines = array(
    //                                      [0] =>
    //                                      )
    //
    //      2.  $lines = preg_split( chr(32) )
    //
    //              -->     $lines = array(
    //                                      [0] =>
    //                                      )
    //
    //      3.  $lines = preg_split( "\n" )
    //
    //              -->     $lines = array(
    //                                      [0] =>
    //                                      [1] =>
    //                                      )
    //
    // Thus, it seems that at this point, $lines will always contain
    // at least one line (even if it's the empty string).
    // -----------------------------------------------------------------------

    return $lines ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// to_words()
// ===========================================================================

function to_words( $instr ) {

    return preg_split( '/\s+/' , trim( $instr ) ) ;
                // Returns an array containing substrings of subject split
                // along boundaries matched by pattern.

}

// ===========================================================================
// to_error_message()
// ===========================================================================

function to_error_message( $error_message , $prefix = '' , $suffix = '' ) {

    if ( is_string( $error_message ) ) {

        $error_message = trim( $error_message ) ;

        if ( $error_message !== '' ) {

            return <<<EOT
{$prefix}
<div style="background-color:#FFF0F0;border:1px solid #AA0000;color:#AA0000;padding:0.3em 1em">
    {$error_message}
</div>
{$suffix}
EOT;

        }

    }

    return '' ;

}

// ===========================================================================
// to_green_message()
// ===========================================================================

function to_green_message( $green_message , $prefix = '' , $suffix = '' ) {

    if ( is_string( $green_message ) ) {

        $green_message = trim( $green_message ) ;

        if ( $green_message !== '' ) {

            return <<<EOT
{$prefix}
<div style="background-color:#F0FFF0;border:1px solid #006600;color:#006600;padding:0.3em 1em">
    {$green_message}
</div>
{$suffix}
EOT;

        }

    }

    return '' ;

}

// ===========================================================================
// to_title()
// ===========================================================================

function to_title( $instr ) {

    // -----------------------------------------------------------------------
    // to_title( $instr )
    // - - - - - - - - -
    // Converts a string - assumed to be something like a file basename or
    // other variable name like string - into something that can be used
    // as a title.
    //
    // In particular:-
    //      o   Non-alphanumeric characters are converted to single spaces.
    //      o   Multiple white space characters are converted to a single
    //          space.
    //      o   Leading and trailing spaces are removed.
    //      o   Alpha characters are lowercased.  Except for the first such
    //          character in each word, which is UPPERCASED.
    //
    // So:-
    //      "hello-world"               ==>  "Hello World"
    //      "janis_joplin.pdf"          ==>  "Janis Joplin Pdf"
    //      "path/to/bruce_willis.mpg"  ==>  "Path To Bruce Willis Mpg"
    // -----------------------------------------------------------------------

    $instr = strtolower( $instr ) ;

    $j = strlen( $instr ) ;

    $title = '' ;

    $last_char = '' ;

    for ( $i=0 ; $i<$j ; $i++ ) {

        $char = $instr[$i] ;

        if ( ctype_alnum( $char ) ) {
            $title .= $char ;
            $last_char = $char ;

        } else {

            if ( $last_char !== chr(32) ) {
                $title .= chr(32) ;
                $last_char = chr(32) ;
            }

        }

    }

    return ucwords( trim( $title ) ) ;

}

// ===========================================================================
// to_camel_case()
// ===========================================================================

function to_camel_case( $instr ) {

    // -------------------------------------------------------------------------
    // to_camel_case( $instr )
    // - - - - - - - - - - - -
    // Returns a camel-cased version of the input string.
    //
    // Dies on error.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // mixed preg_replace ( mixed $pattern , mixed $replacement , mixed $subject [, int $limit = -1 [, int &$count ]] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Searches subject for matches to pattern and replaces them with
    // replacement.
    //
    //      pattern
    //          The pattern to search for. It can be either a string or an array
    //          with strings.
    //
    //          Several PCRE modifiers are also available, including the
    //          deprecated 'e' (PREG_REPLACE_EVAL), which is specific to this
    //          function.
    //
    //      replacement
    //          The string or an array with strings to replace. If this
    //          parameter is a string and the pattern parameter is an array, all
    //          patterns will be replaced by that string. If both pattern and
    //          replacement parameters are arrays, each pattern will be replaced
    //          by the replacement counterpart. If there are fewer elements in
    //          the replacement array than in the pattern array, any extra
    //          patterns will be replaced by an empty string.
    //
    //          replacement may contain references of the form \\n or (since PHP
    //          4.0.4) $n, with the latter form being the preferred one. Every
    //          such reference will be replaced by the text captured by the n'th
    //          parenthesized pattern. n can be from 0 to 99, and \\0 or $0
    //          refers to the text matched by the whole pattern. Opening
    //          parentheses are counted from left to right (starting from 1) to
    //          obtain the number of the capturing subpattern. To use backslash
    //          in replacement, it must be doubled ("\\\\" PHP string).
    //
    //          When working with a replacement pattern where a backreference is
    //          immediately followed by another number (i.e.: placing a literal
    //          number immediately after a matched pattern), you cannot use the
    //          familiar \\1 notation for your backreference. \\11, for example,
    //          would confuse preg_replace() since it does not know whether you
    //          want the \\1 backreference followed by a literal 1, or the \\11
    //          backreference followed by nothing. In this case the solution is
    //          to use \${1}1. This creates an isolated $1 backreference,
    //          leaving the 1 as a literal.
    //
    //          When using the deprecated e modifier, this function escapes some
    //          characters (namely ', ", \ and NULL) in the strings that replace
    //          the backreferences. This is done to ensure that no syntax errors
    //          arise from backreference usage with either single or double
    //          quotes (e.g. 'strlen(\'$1\')+strlen("$2")'). Make sure you are
    //          aware of PHP's string syntax to know exactly how the interpreted
    //          string will look.
    //
    //      subject
    //          The string or an array with strings to search and replace.
    //
    //          If subject is an array, then the search and replace is performed
    //          on every entry of subject, and the return value is an array as
    //          well.
    //
    //      limit
    //          The maximum possible replacements for each pattern in each
    //          subject string. Defaults to -1 (no limit).
    //
    //      count
    //          If specified, this variable will be filled with the number of
    //          replacements done.
    //
    // If matches are found, the new subject will be returned, otherwise subject
    // will be returned unchanged or NULL if an error occurred.
    //
    // preg_replace() returns an array if the subject parameter is an array, or
    // a string otherwise.
    //
    // (PHP 4, PHP 5)
    //
    // ERRORS/EXCEPTIONS
    //      An E_DEPRECATED level error is emitted when passing in the "\e"
    //      modifier.
    //
    // CHANGELOG
    //
    //      Version     Description
    //      -------     -------------------------------------------------
    //      5.5.0       The /e modifier is deprecated. Use
    //                  preg_replace_callback() instead. See the
    //                  PREG_REPLACE_EVAL documentation for additional
    //                  information about security risks.
    //
    //      5.1.0       Added the count parameter
    //
    //      4.0.4       Added the '$n' form for the replacement parameter
    //
    //      4.0.2       Added the limit parameter
    // -------------------------------------------------------------------------

    $instr = strtolower( $instr ) ;

    // -------------------------------------------------------------------------

    $pattern = '/[^a-z0-9]/' ;

    $replacement = chr(32) ;

    // ---------------------------------------------------------------------

    $instr = preg_replace(
                $pattern        ,
                $replacement    ,
                $instr
                ) ;

    // ---------------------------------------------------------------------

    if ( $instr === NULL ) {

        $msg = <<<EOT
PROBLEM:&nbsp; "preg_replace()" failure
Detected in:&nbsp; \\to_camel_case()
EOT;

        die( nl2br( $msg ) ) ;

    }

    // ---------------------------------------------------------------------

    $temp = explode( chr(32) , $instr ) ;

    // ---------------------------------------------------------------------

    $outstr = '' ;

    foreach ( $temp as $fragment_index => $fragment_text ) {
//      if ( $fragment_text === '' ) {
//          continue ;
//      }
        if ( $fragment_index > 0 ) {
            $fragment_text = ucfirst( $fragment_text ) ;
        }
        $outstr .= $fragment_text ;
    }

    // ---------------------------------------------------------------------

    return $outstr ;

    // ---------------------------------------------------------------------

}

// ===========================================================================
// ctype_regex()
// ===========================================================================

function ctype_regex( $value , $regex , $must_be_string = FALSE ) {

    // -----------------------------------------------------------------------
    // ctype_regex( $value , $regex , $must_be_string = FALSE )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $regex should be like a PCRE regex string (as fed to "pcre_match()",
    // for example).  Eg:-
    //      "/[a-z0-9]/"
    //      "/[^a-z0-9]/"
    //      etc, etc.
    //
    // Returns:-
    //      o   TRUE if the value matches both the $regex and the
    //          $must_be_string condition.
    //      o   FALSE if the DOESN'T match BOTH the $regex and the
    //          $must_be_string condition.
    //      o   TEXT-ONLY ERROR MESSAGE (STRING) on ERROR (eg; "preg_match()"
    //          failure due to invalid $regex).
    // -----------------------------------------------------------------------

    if (    $must_be_string === TRUE
            &&
            ! is_string( $value )
        ) {
        return FALSE ;
    }

    // -----------------------------------------------------------------------
    // int preg_match ( string $pattern , string $subject [, array &$matches [, int $flags [, int $offset ]]] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // preg_match() returns the number of times pattern matches.
    //
    // That will be either 0 times (no match) or 1 time because
    // preg_match() will stop searching after the first match.
    //
    // preg_match_all() on the contrary will continue until it
    // reaches the end of subject.
    //
    // preg_match() returns FALSE if an error occurred.
    // -----------------------------------------------------------------------

    $result = preg_match( $regex , $value ) ;

    // -----------------------------------------------------------------------

    if ( $result === FALSE ) {

        $__FUNCTION__ = __FUNCTION__ ;
        $__FILE__     = __FILE__     ;
        $__LINE__     = __LINE__     ;

        return <<<EOT
"preg_match()" failure detected in FUNCTION "{$__FUNCTION__}()" and FILE "{$__FILE__}" at LINE "{$__LINE__}". The regex supplied to this function ("{$regex}") is probably invalid.
EOT;

    }

    // -----------------------------------------------------------------------

    return ( $result === 1 ) ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// ctype_alphanumeric_underscore_dash()
// ===========================================================================

function ctype_alphanumeric_underscore_dash( $value ) {

    $regex = '/^[a-zA-Z0-9_-]+$/' ;

    $must_be_string = TRUE ;

    if ( ctype_regex( $value , $regex , $must_be_string ) === TRUE ) {
        return TRUE ;
    }

    return FALSE ;

}

// ===========================================================================
// ctype_alphanumeric_underscore()
// ===========================================================================

function ctype_alphanumeric_underscore( $value ) {

    $regex = '/^[a-zA-Z0-9_]+$/' ;

    $must_be_string = TRUE ;

    if ( ctype_regex( $value , $regex , $must_be_string ) === TRUE ) {
        return TRUE ;
    }

    return FALSE ;

}

// ===========================================================================
// ctype_alphanumeric_dash()
// ===========================================================================

function ctype_alphanumeric_dash( $value ) {

    $regex = '/^[a-zA-Z0-9-]+$/' ;

    $must_be_string = TRUE ;

    if ( ctype_regex( $value , $regex , $must_be_string ) === TRUE ) {
        return TRUE ;
    }

    return FALSE ;

}

// ===========================================================================
// ctype_varname()
// ===========================================================================

function ctype_varname( $value ) {

    $regex = '/^[a-zA-Z_][a-zA-Z0-9_]*$/' ;

    $must_be_string = TRUE ;

    if ( ctype_regex( $value , $regex , $must_be_string ) === TRUE ) {
        return TRUE ;
    }

    return FALSE ;

}

// =============================================================================
// ctype_ip()
// =============================================================================

/*
function ctype_ip( $value ) {

    //  NOT YET FINISHED !!!

    // -------------------------------------------------------------------------
    // mixed filter_var ( mixed $variable [, int $filter = FILTER_DEFAULT [, mixed $options ]] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    //
    //      variable
    //          Value to filter.
    //
    //      filter
    //          The ID of the filter to apply. The Types of filters manual page
    //          lists the available filters.
    //
    //      options
    //          Associative array of options or bitwise disjunction of flags. If
    //          filter accepts options, flags can be provided in "flags" field
    //          of array. For the "callback" filter, callable type should be
    //          passed. The callback must accept one argument, the value to be
    //          filtered, and return the value after filtering/sanitizing it.
    //
    //          // for filters that accept options, use this format
    //          $options = array(
    //              'options' => array(
    //                  'default' => 3, // value to return if the filter fails
    //                  // other options here
    //                  'min_range' => 0
    //              ),
    //              'flags' => FILTER_FLAG_ALLOW_OCTAL,
    //          );
    //          $var = filter_var('0755', FILTER_VALIDATE_INT, $options);
    //
    //          // for filter that only accept flags, you can pass them directly
    //          $var = filter_var('oops', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    //
    //          // for filter that only accept flags, you can also pass as an array
    //          $var = filter_var('oops', FILTER_VALIDATE_BOOLEAN,
    //                        array('flags' => FILTER_NULL_ON_FAILURE));
    //
    //          // callback validate filter
    //          function foo($value)
    //          {
    //              // Expected format: Surname, GivenNames
    //              if (strpos($value, ", ") === false) return false;
    //              list($surname, $givennames) = explode(", ", $value, 2);
    //              $empty = (empty($surname) || empty($givennames));
    //              $notstrings = (!is_string($surname) || !is_string($givennames));
    //              if ($empty || $notstrings) {
    //                  return false;
    //              } else {
    //                  return $value;
    //              }
    //          }
    //          $var = filter_var('Doe, Jane Sue', FILTER_CALLBACK, array('options' => 'foo'));
    //
    // Returns the filtered data, or FALSE if the filter fails.
    //
    // (PHP 5 >= 5.2.0)
    // -------------------------------------------------------------------------

    // -----------------------------------------------------------------------------------------------------
    // ID                   Name            Options     Flags                       Description
    // -------------------  --------------  ----------  --------------------------  ------------------------
    // FILTER_VALIDATE_IP   "validate_ip"   default     FILTER_FLAG_IPV4,           Validates value as IP
    //                                                  FILTER_FLAG_IPV6,           address, optionally only
    //                                                  FILTER_FLAG_NO_PRIV_RANGE,  IPv4 or IPv6 or not from
    //                                                  FILTER_FLAG_NO_RES_RANGE    private or reserved
    //                                                                              ranges.
    // -----------------------------------------------------------------------------------------------------

    if ( ! function_exists( 'filter_var' ) ) {

        $msg = <<<EOT
Can't "ctype_ip()": Function "filter_var" requires PHP >= 5.2.0
EOT;

        die( $msg ) ;

    }

    // -------------------------------------------------------------------------

    // See also:-

    //      inet_ntop
    //      long2ip
    //      ip2long

    // -------------------------------------------------------------------------

}
*/

// =============================================================================
// ctype_base64()
// =============================================================================

function ctype_base64( $value ) {

    // -------------------------------------------------------------------------
    //  NOTE!
    //  =====
    //  The special regular expression characters are:
    //      . \ + * ? [ ^ ] $ ( ) { } = ! < > | : -
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // Acc. to:-
    //      http://stackoverflow.com/questions/6102077/possible-characters-base64-url-safe-function
    //      http://en.wikipedia.org/wiki/Base64
    //
    // Base64 encoded strings contain the following characters:-
    //      o   a-z
    //      o   A-Z
    //      o   0-9
    //      o   +
    //      o   /
    //      o   =
    // -------------------------------------------------------------------------

    $regex = '/^[a-zA-Z0-9\+\/\=]*$/' ;

    $must_be_string = TRUE ;

    if ( ctype_regex( $value , $regex , $must_be_string ) === TRUE ) {
        return TRUE ;
    }

    return FALSE ;

    // -------------------------------------------------------------------------

}

// ===========================================================================
// hex_encode
// ===========================================================================

function hex_encode( $input_string ) {

    // -----------------------------------------------------------------------
    // hex_encode( $input_string )
    // - - - - - - - - - - - - - -
    // Hex encodes a PHP string.  For example:-
    //
    //      hex_encode( 'ABC123' )
    //          ==>  "414243313233"
    //
    //      hex_encode( 'The quick brown fox...' )
    //          ==>  "54686520717569636b2062726f776e20666f782e2e2e"
    //
    // NOTES!
    // ------
    // 1.   hex_encode() will handle all character/byte values, from ASCII 0
    //      to ASCII 255.  Ie:-
    //
    //          hex_encode( chr(0) . chr(1) . chr(2) . chr(253) . chr(254) . chr(255) )
    //              ==> "000102fdfeff" (= "00 01 02 fd fe ff")
    //
    //      In other words, hex_encode() will happily encode PHP strings that
    //      contain binary data.
    //
    // 2.   The encoded string contains only the chars:-
    //      o   "0" to "9", and;
    //      o   "a" to "f"
    //
    //      Thus, it may safely be:-
    //      o   Included in a URL query string,
    //      o   Inserted into a MySQL database query, and;
    //      o   Stored directly into a MySQL database (it contains only
    //          alphanumeric characters - so there's no need for any
    //          escaping, etc).
    //
    // 3.   To decode the encoded string, use hex_decode().
    //
    // 4.   From the PHP Manual, "Strings" section...
    //
    //          "A string is series of characters.  Before PHP 6, a character
    //          is the same as a byte.  That is, there are exactly 256
    //          different characters possible.  This also implies that PHP
    //          has no native support of Unicode.  See utf8_encode() and
    //          utf8_decode() for some basic Unicode functionality.
    //
    //          Note:   It is no problem for a string to become very large.
    //                  PHP imposes no boundary on the size of a string; the
    //                  only limit is the available memory of the computer
    //                  on which PHP is running."
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // string bin2hex ( string $str )
    // - - - - - - - - - - - - - - -
    // Returns an ASCII string containing the hexadecimal representation of
    // str.  The conversion is done byte-wise with the high-nibble first.
    //
    // Returns the hexadecimal representation of the given string.
    // -----------------------------------------------------------------------

    return bin2hex( $input_string ) ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// hex_decode
// ===========================================================================

function hex_decode( $input_string ) {

    // -----------------------------------------------------------------------
    // hex_decode( $input_string )
    // - - - - - - - - - - - - - -
    // Decodes a hex encoded PHP string.  For example:-
    //
    //      hex_decode( '414243313233' )
    //          ==>  "ABC123"
    //
    //      hex_decode( '54686520717569636b2062726f776e20666f782e2e2e' )
    //          ==>  "The quick brown fox..."
    //
    // NOTES!
    // ------
    // 1.   hex_decode() will handle all HEX values, from HEX "00" to
    //      HEX "ff" ("FF").  Ie:-
    //
    //          hex_decode( '000102fdfeff' )
    //              ==> chr(0) . chr(1) . chr(2) . chr(253) . chr(254) . chr(255)
    //
    //      In other words, hex_decode() will decode HEX strings that
    //      contain BINARY data.
    //
    // 2.   The "a" to "f" characters in the encoded string may be in either
    //      UPPER or lower case.
    //
    // 3.   hex_decode() is normally used to decode a string encoded by
    //      hex_encode().
    //
    // 4.   From the PHP Manual, "Strings" section...
    //
    //          "A string is series of characters.  Before PHP 6, a character
    //          is the same as a byte.  That is, there are exactly 256
    //          different characters possible.  This also implies that PHP
    //          has no native support of Unicode.  See utf8_encode() and
    //          utf8_decode() for some basic Unicode functionality.
    //
    //          Note:   It is no problem for a string to become very large.
    //                  PHP imposes no boundary on the size of a string; the
    //                  only limit is the available memory of the computer
    //                  on which PHP is running."
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // string pack ( string $format [, mixed $args [, mixed $... ]] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Pack given arguments into binary string according to format.
    //
    // The idea for this function was taken from Perl and all formatting
    // codes work the same as in Perl.  However, there are some formatting
    // codes that are missing such as Perl's "u" format code.
    //
    // Note that the distinction between signed and unsigned values only
    // affects the function unpack(), where as function pack() gives the
    // same result for signed and unsigned format codes.
    //
    // Also note that PHP internally stores integer values as signed values
    // of a machine-dependent size.  If you give it an unsigned integer
    // value too large to be stored that way it is converted to a float
    // which often yields an undesired result.
    //
    // Parameters
    //
    //      format
    //          The format string consists of format codes followed by an
    //          optional repeater argument.  The repeater argument can be
    //          either an integer value or * for repeating to the end of
    //          the input data.  For a, A, h, H the repeat count specifies
    //          how many characters of one data argument are taken, for @
    //          it is the absolute position where to put the next data,
    //          for everything else the repeat count specifies how many
    //          data arguments are consumed and packed into the resulting
    //          binary string.
    //
    //          Currently implemented formats are:
    //
    //          ----------------------------------------------------------------
    //          pack() format characters
    //          ----------------------------------------------------------------
    //          Code    Description
    //          ----    --------------------------------------------------------
    //          a       NUL-padded string
    //          A       SPACE-padded string
    //          h       Hex string, low nibble first
    //          H       Hex string, high nibble first
    //          c       signed char
    //          C       unsigned char
    //          s       signed short (always 16 bit, machine byte order)
    //          S       unsigned short (always 16 bit, machine byte order)
    //          n       unsigned short (always 16 bit, big endian byte order)
    //          v       unsigned short (always 16 bit, little endian byte order)
    //          i       signed integer (machine dependent size and byte order)
    //          I       unsigned integer (machine dependent size and byte order)
    //          l       signed long (always 32 bit, machine byte order)
    //          L       unsigned long (always 32 bit, machine byte order)
    //          N       unsigned long (always 32 bit, big endian byte order)
    //          V       unsigned long (always 32 bit, little endian byte order)
    //          f       float (machine dependent size and representation)
    //          d       double (machine dependent size and representation)
    //          x       NUL byte
    //          X       Back up one byte
    //          @       NUL-fill to absolute position
    //          ----------------------------------------------------------------
    //
    // -----------------------------------------------------------------------

    return pack( 'H*' , $input_string ) ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// join_paths()
// ===========================================================================

    // -----------------------------------------------------------------------
    // join_paths()
    // ------------
    // Join a bunch of file/directory names together, making sure that there
    // are no missing or double+ "/" slashes.
    //
    // Named after TCL's "join" function which brilliantly does the same
    // thing.  (But we can't use "join()"; it's an alias of "implode()".)
    //
    // Implementation from:-
    //      http://www.razzed.com/2009/01/14/top-5-most-useful-non-native-php-functions/
    //
    // (but renamed from "path()" to "join_paths()".
    //
    //      Number 3. path: Slash before - wait, after - oh forget it
    //
    //      Since one's job as developer is to avoid making mistakes, one of
    //      the most common mistakes I've made in writing code is the infamous
    //      trailing slash after directory names - or not. You can either
    //      write your code like one of the following lines:
    //
    //          $f = file_get_contents("$path/web-app.conf"); /* or */
    //          $f = file_get_contents($path . "web-app.conf");
    //
    //      - depending on whether $path is "/my/web/directory/conf/" or
    //      "/my/web/directory/conf". How many times have you found those
    //      phantom files just lingering above the directory where the files
    //      were destined to go?
    //
    //      It's happened to me enough to want to avoid the issue completely
    //      if possible. Is there a slash after this variable when its in the
    //      configuration file I loaded on that machine there? I don't know,
    //      nor do I care anymore.
    //
    //      Since engineers often use paths with trailing slashes (or without)
    //      in different contexts, I've completely bypassed the situation by
    //      adding a simple function path to my code repertoire which avoid
    //      this issue completely
    //
    //      You can write any path, and pass an array, an array and a string,
    //      or just a list of strings, and it will concatenate them together
    //      with one slash in between each component, except the last one.
    //
    //      Since manipulating files is, like, everything, this one is used
    //      all the time:
    //
    //          $file_extension = "csv";
    //          $f = file_get_contents(join_paths($site_root, "images/extension-icons", "$file_extension.gif"));
    //
    // -----------------------------------------------------------------------

/**
 * Create a file path and ensure only one slash appears between path entries
 * @param mixed path Variable list of path items, or array of path items to concatenate
 * @return string with a properly formatted path
 */

    function join_paths(/* dir, dir, file */) {
	    $mixed = func_get_args();
    	$r = array_shift($mixed);
	    if (is_array($r)) {
		    $r = call_user_func_array("join_paths", $r);
    	}
	    foreach ($mixed as $p) {
		    if (is_array($p)) {
			    $p = call_user_func("join_paths", $p);
    		}
	    	$r .= ((substr($r, -1) === "/" || substr($p, 0, 1) === "/")) ? $p : "/$p";
    	}
	    $r = str_replace("/./", "/", $r);
    	$r = preg_replace("|//+|", "/", $r);
	    return $r;
    }

// ===========================================================================
// get_ext()
// ===========================================================================

function get_ext( $filespec_or_url ) {

    // -----------------------------------------------------------------------
    // mixed pathinfo ( string $path [, int $options ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // pathinfo() returns an associative array containing information about
    // path.
    //
    // You can specify which elements are returned with optional parameter
    // options.  It composes from PATHINFO_DIRNAME, PATHINFO_BASENAME,
    // PATHINFO_EXTENSION and PATHINFO_FILENAME. It defaults to return all
    // elements.
    //
    // The following associative array elements are returned: dirname,
    // basename, extension (if any), and filename.
    //
    // If options is used, this function will return a string if not all
    // elements are requested.
    //
    // The PATHINFO_FILENAME constant was added in PHP 5.2.0
    // -----------------------------------------------------------------------

    return pathinfo( $filespec_or_url , PATHINFO_EXTENSION ) ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// get_filename()
// ===========================================================================

function get_filename( $filespec_or_url ) {

    // -----------------------------------------------------------------------
    // mixed pathinfo ( string $path [, int $options ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // pathinfo() returns an associative array containing information about
    // path.
    //
    // You can specify which elements are returned with optional parameter
    // options.  It composes from PATHINFO_DIRNAME, PATHINFO_BASENAME,
    // PATHINFO_EXTENSION and PATHINFO_FILENAME. It defaults to return all
    // elements.
    //
    // The following associative array elements are returned: dirname,
    // basename, extension (if any), and filename.
    //
    // If options is used, this function will return a string if not all
    // elements are requested.
    //
    // The PATHINFO_FILENAME constant was added in PHP 5.2.0
    // -----------------------------------------------------------------------

    return pathinfo( $filespec_or_url , PATHINFO_FILENAME ) ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// trim_slashes()
// ltrim_slashes()
// rtrim_slashes()
// ===========================================================================

function trim_slashes( $instr ) {
    //  Trims any leading and/or trailing forward or back slashes from the
    //  specified input string.
    //
    //  Be careful with this.
    //
    //  Although the convention is that path names shouldn't have leading
    //  or trailing slashes, the exception is absolute file/directory names
    //  like (eg):-
    //      /path/to/some/dir/
    //      /path/to/some/file.php
    //
    //  You actually need to RTRIM_slashes() these.
    return trim( $instr , '/\\' ) ;
}

function ltrim_slashes( $instr ) {
    //  Trims any leading and/or trailing forward or back slashes from the
    //  specified input string.
    return ltrim( $instr , '/\\' ) ;
}

function rtrim_slashes( $instr ) {
    //  Trims any leading and/or trailing forward or back slashes from the
    //  specified input string.
    return rtrim( $instr , '/\\' ) ;
}

// ===========================================================================
// to_forward_slashes()
// ===========================================================================

function to_forward_slashes( $instr ) {

    //  Converts any back slashes (Windows) in the input string (which is
    //  assumed to be a path name), to forward slashes (Linux).

    return str_replace( '\\' , '/' , $instr ) ;

}

// ===========================================================================
// fix_slashes()
// ===========================================================================

function fix_slashes( $instr ) {

    //  Same as "to_forward_slashes()" and "trim_slashes()".  Ie:-
    //
    //  Converts any back slashes (Windows) in the input string (which is
    //  assumed to be a path name), to forward slashes (Linux).
    //
    //  Trims any leading and/or trailing forward or back slashes from the
    //  specified input string.

    return to_forward_slashes( trim_slashes( $instr ) ) ;

}

// ===========================================================================
// in_tree()
// ===========================================================================

function in_tree( $candidate_root , $candidate_descendant , $ignore_case = TRUE , $strict = FALSE ) {

    //  Is $candidate_root in the directory tree rooted at $candidate_descendant ?

    //  If $strict is TRUE, then in addition:-
    //
    //      o   $haystack and $needdle must both be strings.
    //      o   $haystack must be a dir (and that dir must exist).
    //      o   $needle must be a dir or a file (and that dir/file must
    //          exist).

    if ( $strict ) {

        return starts_with( $candidate_descendant , $candidate_root , $ignore_case ) ;
            //  Not yet implemented.

    } else {

        return starts_with( $candidate_descendant , $candidate_root , $ignore_case ) ;

    }

}

// ===========================================================================
// CSV Reader/Writer
// ===========================================================================

// From: http://snippets.dzone.com/posts/show/3128

//+ Jonas Raoni Soares Silva
//@ http://jsfromhell.com

//  Example A:
//
//  //cell separator, row separator, value enclosure
//  $csv = new CSV(';', "\r\n", '"');
//
//  //parse the string content
//  $csv->setContent(file_get_contents('data.csv'));
//
//  //returns an array with the CSV data
//  print_r($csv->getArray());
//
//  Exemple B:
//
//  $csv = new CSV(';', "\r\n", '"');
//  //sets up the content through an array
//  $csv->setArray(
//      array(
//          array('col"una1', "colu\r\nna2"),
//          array('col;una3', 'coluna4')
//      )
//  );
//  //retorns string with the CSV representation
//  print $csv->getContent();

class CSV{
	var $cellDelimiter;
	var $valueEnclosure;
	var $rowDelimiter;

	function CSV($cellDelimiter, $rowDelimiter, $valueEnclosure){
		$this->cellDelimiter = $cellDelimiter;
		$this->valueEnclosure = $valueEnclosure;
		$this->rowDelimiter = $rowDelimiter;
		$this->o = array();
	}
	function getArray(){
		return $this->o;
	}
	function setArray($o){
		$this->o = $o;
	}
	function getContent(){
		if(!(($bl = strlen($b = $this->rowDelimiter)) && ($dl = strlen($d = $this->cellDelimiter)) && ($ql = strlen($q = $this->valueEnclosure))))
			return '';
		for($o = $this->o, $i = -1; ++$i < count($o);){
			for($e = 0, $j = -1; ++$j < count($o[$i]);)
				(($e = strpos($o[$i][$j], $q) !== false) || strpos($o[$i][$j], $b) !== false || strpos($o[$i][$j], $d) !== false)
				&& $o[$i][$j] = $q . ($e ? str_replace($q, $q . $q, $o[$i][$j]) : $o[$i][$j]) . $q;
			$o[$i] = implode($d, $o[$i]);
		}
		return implode($b, $o);
	}
	function setContent($s){
		$this->o = array();
		if(!strlen($s))
			return true;
		if(!(($bl = strlen($b = $this->rowDelimiter)) && ($dl = strlen($d = $this->cellDelimiter)) && ($ql = strlen($q = $this->valueEnclosure))))
			return false;
		for($o = array(array('')), $this->o = &$o, $e = $r = $c = 0, $i = -1, $l = strlen($s); ++$i < $l;){
			if(!$e && substr($s, $i, $bl) == $b){
				$o[++$r][$c = 0] = '';
				$i += $bl - 1;
			}
			elseif(substr($s, $i, $ql) == $q){
				$e ? (substr($s, $i + $ql, $ql) == $q ?
				$o[$r][$c] .= substr($s, $i += $ql, $ql) : $e = 0)
				: (strlen($o[$r][$c]) == 0 ? $e = 1 : $o[$r][$c] .= substr($s, $i, $ql));
				$i += $ql - 1;
			}
			elseif(!$e && substr($s, $i, $dl) == $d){
				$o[$r][++$c] = '';
				$i += $dl - 1;
			}
			else
				$o[$r][$c] .= $s[$i];
		}
		return true;
	}
}

// ===========================================================================
// load_serialised_array()
// ===========================================================================

function load_serialised_array( $filespec , $question_die_on_error = FALSE ) {

    // -----------------------------------------------------------------------
    // load_serialised_array( $filespec , $question_die_on_error = FALSE )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // If the file exists, and contains a PHP serialised array, returns
    // the array.
    //
    // If the file doesn't exist or contains no content, returns an
    // empty array.
    //
    // Otherwise, returns one of the following text-only error message
    // strings:-
    //      o   "file_get_contents()" failure loading serialised PHP array!
    //      o   Bad serialised PHP array file!
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    // -----------------------------------------------------------------------

    if ( ! is_file( $filespec ) ) {
        return array() ;
    }

    // -----------------------------------------------------------------------

    $content = file_get_contents( $filespec ) ;
                    //  The function returns the read data or FALSE on
                    //  failure.

    // -----------------------------------------------------------------------

    if ( $content === FALSE ) {
        $msg = '"file_get_contents()" failure loading serialised PHP array!' ;
        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }
        return $msg ;
    }

    // -----------------------------------------------------------------------

    $content = gzinflate( $content ) ;
                    //  The original uncompressed data or FALSE on error.
                    //
                    //  The function will return an error if the uncompressed
                    //  data is more than 32768 times the length of the
                    //  compressed input data or more than the optional
                    //  parameter length.

    // -----------------------------------------------------------------------

    if ( $content === FALSE ) {
        $msg = '"gzinflate()" failure loading serialised PHP array!' ;
        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }
        return $msg ;
    }

    // -----------------------------------------------------------------------

    $content = trim( $content ) ;

    // -----------------------------------------------------------------------

    if ( $content === '' ) {
        return array() ;
    }

    // -----------------------------------------------------------------------

    $array = unserialize( $content ) ;

    // -----------------------------------------------------------------------

    if ( ! is_array( $array ) ) {
        $msg = 'Bad serialised PHP array file!' ;
        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }
        return $msg ;
    }

    // -----------------------------------------------------------------------

    return $array ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// save_serialised_array()
// ===========================================================================

function save_serialised_array( $array , $filespec , $question_die_on_error = FALSE ) {

    // -----------------------------------------------------------------------
    // save_serialised_array( $array , $filespec , $question_die_on_error = FALSE )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Serialises the specified array, and saves the result to a file.
    //
    // Returns:-
    //      o   TRUE on success.
    //      o   Text-only error message string on failure.
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    // -----------------------------------------------------------------------

    if ( ! is_array( $array ) ) {
        $msg = '"save_serialised_array()" expects to save a PHP array!' ;
        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }
        return $msg ;
    }

    // -----------------------------------------------------------------------

    $serialised_data = serialize( $array ) ;

    // -----------------------------------------------------------------------

    $serialised_data = gzdeflate( $serialised_data , 9 ) ;
                            //  Returns the deflated string or FALSE if an
                            //  error occurred.

    // -----------------------------------------------------------------------

    if ( $serialised_data === FALSE ) {
        $msg = '"gzdeflate()" failure saving serialised PHP array!' ;
        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }
        return $msg ;
    }

    // -----------------------------------------------------------------------

    $bytes_written = file_put_contents( $filespec , $serialised_data ) ;
                        //  The function returns the number of bytes that were
                        //  written to the file, or FALSE on failure.

    // -----------------------------------------------------------------------

    if ( $bytes_written === FALSE ) {
        $msg = '"file_put_contents()" failure saving serialised PHP array!' ;
        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }
        return $msg ;
    }

    // -----------------------------------------------------------------------

    if ( $bytes_written !== strlen( $serialised_data ) ) {
        $msg = '"bytes written" mismatch saving serialised PHP array!' ;
        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }
        return $msg ;
    }

    // -----------------------------------------------------------------------

}

// ===========================================================================
// count_records_with_field()
// ===========================================================================

function count_records_with_field( $records , $field_name ) {

    // -----------------------------------------------------------------------
    // Returns the number of records that have the specified field name in
    // them.  Where $records is like:-
    //      $records = array(
    //          array(
    //              'name1'     =>  <value1>
    //              'name2'     =>  <value2>
    //              ...
    //              'nameN'     =>  <valueN>
    //              )
    //          ...
    //          )
    // -----------------------------------------------------------------------

    $count = 0 ;

    foreach ( $records as $this_record ) {
        if ( array_key_exists( $field_name , $this_record ) ) {
            $count++ ;
        }
    }

    return $count ;

}

// ===========================================================================
// index_on_indices()
// ===========================================================================

function index_on_indices( $list , $name ) {

    // -----------------------------------------------------------------------
    //  Indexes a list of records like:-
    //      array(
    //          <index1>    =>  array(
    //                              'name1-1'   =>  <value1-1>
    //                              'name1-2'   =>  <value1-2>
    //                              ...
    //                              'name1-N'   =>  <value1-N>
    //                              )
    //          <index2>    =>  array(
    //                              'name2-1'   =>  <value2-1>
    //                              'name2-2'   =>  <value2-2>
    //                              ...
    //                              'name2-N'   =>  <value2-N>
    //                              )
    //          ...
    //          )
    //
    //  to returns an indexed output list like:-
    //      array(
    //          <value1>  =>  <index1>
    //          <value2>  =>  <index2>
    //          )
    // -----------------------------------------------------------------------

    $out = array() ;

    foreach ( $list as $index => $record ) {
        $out[ $record[ $name ] ] = $index ;
    }

    return $out ;

}

// ===========================================================================
// index_on_full_record()
// ===========================================================================

function index_on_full_record( $list , $name ) {

    // -----------------------------------------------------------------------
    //  Indexes a list of records like:-
    //      array(
    //          array(
    //              'name1'     =>  <value1>
    //              'name2'     =>  <value2>
    //              ...
    //              'nameN'     =>  <valueN>
    //              )
    //          ...
    //          )
    //
    //  to returns an indexed output list like:-
    //      array(
    //          <value1>    =>  array(
    //                              'name1'     =>  <value1>
    //                              'name2'     =>  <value2>
    //                              ...
    //                              'nameN'     =>  <valueN>
    //                              )
    //          ...
    //          )
    // -----------------------------------------------------------------------

    $out = array() ;

    foreach ( $list as $record ) {
        $out[ $record[ $name ] ] = $record ;
    }

    return $out ;

}

// ===========================================================================
// encircle()
// ===========================================================================

function encircle( $in , $before = '"' , $after = NULL ) {

    if ( $after === NULL ) {
        $after = $before ;
    }

    if ( is_array( $in ) ) {

        $out = array() ;

        foreach ( $in as $key => $value ) {
            $out[ $key ] = $before . $value . $after ;
        }

        return $out ;

    } else {

        return $before . $in . $after ;

    }

}

// ===========================================================================
// expand_php()
// ===========================================================================

function expand_php( $in ) {

    // -----------------------------------------------------------------------
    //
    // Anything in:-
    //      [.. xxxxxxxxxxxx ..]
    //
    // is assumed to be PHP code, that we should evaluate.
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // Find the PHP to expand (if there is any)...
    // -----------------------------------------------------------------------

    $regex = '/\[\.\.\s+(.*)\s+\.\.\]/sU' ;

    // -----------------------------------------------------------------------

    $number_matches = preg_match_all(
                            $regex          ,
                            $in             ,
                            $matches        ,
                            PREG_SET_ORDER
                            ) ;
                            //  Returns the number of full pattern matches
                            //  (which might be zero), or FALSE if an error
                            //  occurred.

    // -----------------------------------------------------------------------

    if ( $number_matches === FALSE ) {

        $title = 'PROBLEM: "preg_match_all()" failure in "expand_php()"!' ;

        $file = __FILE__ ;

        $line = __LINE__ ;

        $text = <<<EOT
---REGEX------------------------------------------
    {$regex}

---TARGET STRING----------------------------------
    {$in}

---ERROR DETECTED AT FILE-------------------------
    {$file}

---LINE-------------------------------------------
    {$line}
EOT;

        fatal_error( $title , $text ) ;
            //  Doesn't return ;

    }

    // -----------------------------------------------------------------------

    if ( $number_matches < 1 ) {
        return $in ;
    }

    // -----------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $matches = array(
    //                      [0] => Array(
    //                                  [0] => [.. get_page_header_html() ..]
    //                                  [1] => get_page_header_html()
    //                                  )
    //                      [1] => Array(
    //                                  [0] => [.. get_tabbar_html ..]
    //                                  [1] => get_tabbar_html
    //                                  )
    //                      [2] => Array(
    //                                  [0] => [.. echo 'Hello World!' ..]
    //                                  [1] => echo 'Hello World!'
    //                                  )
    //                      )
    //
    // -----------------------------------------------------------------------

//pr( $matches ) ;

    // -----------------------------------------------------------------------
    // For each match, evaluate the PHP - and replace the match with PHP's
    // output...
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // mixed eval ( string $code_str )
    // - - - - - - - - - - - - - - - -
    // Evaluates the string given in code_str as PHP code. Among other things,
    // this can be useful for storing code in a database text field for later
    // execution.
    //
    // There are some factors to keep in mind when using eval(). Remember that
    // the string passed must be valid PHP code, including things like
    // terminating statements with a semicolon so the parser doesn't die on
    // the line after the eval(), and properly escaping things in code_str. To
    // mix HTML output and PHP code you can use a closing PHP tag to leave PHP
    // mode.
    //
    // Also remember that variables given values under eval() will retain
    // these values in the main script afterwards.
    //
    // Parameters
    //
    //      code_str
    //          The code string to be evaluated. code_str does not have to
    //          contain PHP Opening tags.
    //
    //          A return statement will immediately terminate the evaluation
    //          of the string.
    //
    // eval() returns NULL unless return is called in the evaluated code, in
    // which case the value passed to return is returned. If there is a parse
    // error in the evaluated code, eval() returns FALSE and execution of the
    // following code continues normally. It is not possible to catch a parse
    // error in eval() using set_error_handler().
    // -----------------------------------------------------------------------

    $out = $in ;

    // -----------------------------------------------------------------------

    $regex_function_name = '/^[a-zA-Z][a-zA-Z0-9_]*\(\)$/' ;

    // -----------------------------------------------------------------------

    foreach ( $matches as $this_match ) {

        // -------------------------------------------------------------------

        $text_to_replace = $this_match[0] ;
        $php_to_eval     = $this_match[1] ;

        // -------------------------------------------------------------------
        // Check for a function name:  Eg:-
        //
        //      [.. getcwd() ..]
        // -------------------------------------------------------------------

        $number_matches = preg_match(
                            $regex_function_name    ,
                            $php_to_eval
                            ) ;
                            //  preg_match() returns the number of times
                            //  pattern matches. That will be either 0 times
                            //  (no match) or 1 time because preg_match() will
                            //  stop searching after the first match.
                            //  preg_match_all() on the contrary will continue
                            //  until it reaches the end of subject.
                            //  preg_match() returns FALSE if an error
                            //  occurred.

        // -----------------------------------------------------------------------

        if ( $number_matches === FALSE ) {

            $title = 'PROBLEM: "preg_match()" failure checking for function name in "expand_php()"!' ;

            $file = __FILE__ ;

            $line = __LINE__ ;

            $text = <<<EOT
---REGEX------------------------------------------
    {$regex_function_name}

---TARGET STRING----------------------------------
    {$php_to_eval}

---ERROR DETECTED AT FILE-------------------------
    {$file}

---LINE-------------------------------------------
    {$line}
EOT;

            fatal_error( $title , $text ) ;
                //  Doesn't return ;

        }

        // -------------------------------------------------------------------

        if ( $number_matches === 1 ) {
            $php_to_eval = 'echo ' . $php_to_eval . ';';

        } elseif ( ! ends_with( $php_to_eval , ';' ) ) {
            $php_to_eval .= ';' ;

        }

        // -------------------------------------------------------------------

        ob_start() ;
            $result = eval( $php_to_eval ) ;
        $php_said = ob_get_clean() ;

        // -------------------------------------------------------------------

        if ( $result === FALSE ) {

            $title = 'OOPS!: There\'s an error in the PHP code parsed to "expand_php()"!' ;

            $file = __FILE__ ;

            $line = __LINE__ ;

            $php = htmlentities( $php_to_eval ) ;

            $text = <<<EOT
---THE PHP CODE-----------------------------------
    {$php_to_eval}

---EVAL SAID--------------------------------------
    {$php_said}

---ERROR DETECTED AT FILE-------------------------
    {$file}

---LINE-------------------------------------------
    {$line}
EOT;

            fatal_error( $title , $text ) ;
                //  Doesn't return ;

        }

        // -------------------------------------------------------------------

        if ( $result === NULL ) {
            $replace_me_with = $php_said ;

        } else {
            $replace_me_with = $php_said . '<br />' . $result ;

        }

        // -------------------------------------------------------------------

        $out = str_replace( $text_to_replace , $replace_me_with , $out ) ;

        // -------------------------------------------------------------------

    }

    // -----------------------------------------------------------------------

    return $out ;

    // -----------------------------------------------------------------------

}

    // =======================================================================
    // That's that!
    // =======================================================================


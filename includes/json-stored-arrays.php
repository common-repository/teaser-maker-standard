<?php

// *****************************************************************************
// JSON-STORED-ARRAYS.PHP
// (C) 2013 Peter Newman.  All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_jsonStoredArrays ;

// =============================================================================
// NOTE!
// -----
// Upgraded from:-
//      load-save-json.php
// On:-
//      1 December 2013
// -----------------------
// "load-save-json.php" had two routines:-
//      o   json_file_2_array(
//              $filespec                           ,
//              $question_die_on_error = FALSE
//              )
//      o   array_2_json_file(
//              $array                          ,
//              $filespec                       ,
//              $question_die_on_error = FALSE
//              )
//
// These assumed that the array being loaded/saved was a PHP NUMERIC array
// (of records).  And applied "array_values()" to the array both before saving
// and after loading - to ensure that the array was indexed sequentially
// starting from 0.
//
// Thus; ASSOCIATIVE arrays (of name=value pairs,) WEREN'T supported.
//
// ---
//
// This new version:-
//      json-stored-arrays.php
//
// suuports both NUMERIC and ASSOCIATIVE arrays.  The difference being that
// "array_values()" was applied to the NUMERIC arrays only.
// =============================================================================

// ===========================================================================
// load_numerically_indexed()
// ===========================================================================

function load_numerically_indexed(
    $filespec                           ,
    $question_die_on_error = FALSE
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_jsonStoredArrays\load_numerically_indexed(
    //      $filespec                           ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // If the file exists, loads it and converts it's content into a PHP
    // numerically indexed ARRAY.
    //
    // If the file doesn't exist or contains no content, returns an
    // empty array.
    //
    // Otherwise, returns an error message STRING.
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    //
    // NOTE!
    // -----
    // The JSON in the file must be something that "json_decode()" will
    // convert into a PHP ARRAY.
    //
    // This will be the case if the array was created and saved from PHP,
    // with either:-
    //      o   \greatKiwi_jsonStoredArrays\save_array(
    //      o   \greatKiwi_jsonStoredArrays\save_numeric_array(
    //
    // or:-
    //      o   Some PHP code that did something like:-
    //              $json = json_encode( $some_php_array ) ;
    //              file_put_contents( $filespec , $json ) ;
    //
    // But if the JSON file was created some other way, the onus is on
    // whowever created it to make sure that PHP's "json_decode()" will
    // convert into a PHP numerically indexed ARRAY.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          (A possibly empty PHP numeric ARRAY)
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -----------------------------------------------------------------------

    // =======================================================================
    // LOAD the ARRAY from the JSON FILE...
    // =======================================================================

    $result = load(
                $filespec               ,
                $question_die_on_error
                ) ;

    // =======================================================================
    // Make sure the records are numerically indexed, starting from 0
    // (and in steps of 1).
    //
    // Because many of the PHP and Javascript routines that handle the
    // returned PHP array assume this to be the case - and will fail if
    // it isn't)...
    // =======================================================================

    if ( is_array( $result ) ) {
        $result = array_values( $result ) ;
    }

    // =======================================================================
    // RETURN the result...
    // =======================================================================

    return $result ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ===========================================================================
// load()
// ===========================================================================

function load(
    $filespec                           ,
    $question_die_on_error = FALSE
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_jsonStoredArrays\load(
    //      $filespec                           ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // If the file exists, loads it and converts it's content into a PHP
    // (numeric or associative) ARRAY.
    //
    // If the file doesn't exist or contains no content, returns an
    // empty array.
    //
    // Otherwise, returns an error message STRING.
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    //
    // NOTE!
    // -----
    // The JSON in the file must be something that "json_decode()" will
    // convert into a PHP ARRAY.
    //
    // This will be the case if the array was created and saved from PHP,
    // with either:-
    //      o   \greatKiwi_jsonStoredArrays\save(
    //      o   \greatKiwi_jsonStoredArrays\save_numerically_indexed(
    //
    // or:-
    //      o   Some PHP code that did something like:-
    //              $json = json_encode( $some_php_array ) ;
    //              file_put_contents( $filespec , $json ) ;
    //
    // But if the JSON file was created some other way, the onus is on
    // whowever created it to make sure that PHP's "json_decode()" will
    // convert into a PHP ARRAY.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          (A possibly empty PHP numeric or associative ARRAY)
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
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

        $msg = '"file_get_contents()" failure loading JSON data from file' ;

        $msg .= load_save_array_get_detected_in_on() ;

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

    $assoc = TRUE ;
        //  When TRUE, returned objects will be converted into associative
        //  arrays.

    // -----------------------------------------------------------------------

    $array = json_decode( $content , $assoc ) ;
                //  Returns the value encoded in json in appropriate PHP type.
                //  Values true, false and null (case-insensitive) are returned
                //  as TRUE, FALSE and NULL respectively. NULL is returned if
                //  the json cannot be decoded or if the encoded data is deeper
                //  than the recursion limit.

    // -----------------------------------------------------------------------

    if ( ! is_array( $array ) ) {

        $msg = 'Bad JSON data' ;

        $msg .= load_save_array_get_detected_in_on() ;

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
// save_numerically_indexed()
// ===========================================================================

function save_numerically_indexed(
    $array                          ,
    $filespec                       ,
    $question_die_on_error = FALSE
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_jsonStoredArrays\save_numerically_indexed(
    //      $array                          ,
    //      $filespec                       ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Encodes the specified NUMERICALLY INDEXED ARRAY as JSON, and saves
    // the result to the specified file.
    //
    // Returns:-
    //      o   TRUE on success.
    //      o   Error message STRING on failure.
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    // -----------------------------------------------------------------------

    // =======================================================================
    // Make sure the records are numerically indexed, starting from 0
    // (and in steps of 1).
    //
    // Because many of the PHP and Javascript routines that handle the
    // returned PHP array assume this to be the case - and will fail if
    // it isn't)...
    // =======================================================================

    if ( is_array( $array ) ) {
        $array = array_values( $array ) ;
    }

    // =======================================================================
    // Do the SAVE proper...
    // =======================================================================

    return save(
                $array                      ,
                $filespec                   ,
                $question_die_on_error
                ) ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// ===========================================================================
// save()
// ===========================================================================

function save(
    $array                          ,
    $filespec                       ,
    $question_die_on_error = FALSE
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_jsonStoredArrays\save(
    //      $array                          ,
    //      $filespec                       ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Encodes the specified ARRAY as JSON, and saves the result to the
    // specified file.
    //
    // Returns:-
    //      o   TRUE on success.
    //      o   Error message STRING on failure.
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    // -----------------------------------------------------------------------

    if ( ! is_array( $array ) ) {

        $msg = '"\greatKiwi_jsonStoredArrays\save()" expects to save a PHP array' ;

        $msg .= load_save_array_get_detected_in_on() ;

        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }

        return $msg ;

    }

    // -----------------------------------------------------------------------

    $json = json_encode( $array ) ;
                //  Returns a JSON encoded string on success or FALSE on
                //  failure.

    // -----------------------------------------------------------------------

    if ( ! is_string( $json ) ) {

        $msg = <<<EOT
Couldn't convert PHP array to JSON
EOT;

        $msg .= load_save_array_get_detected_in_on() ;

        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }

        return $msg ;

    }

    // -----------------------------------------------------------------------

    $bytes_written = file_put_contents( $filespec , $json ) ;
                        //  The function returns the number of bytes that were
                        //  written to the file, or FALSE on failure.

    // -----------------------------------------------------------------------

    if ( $bytes_written === FALSE ) {

        $msg = '"file_put_contents()" failure saving PHP array as JSON' ;

        $msg .= load_save_array_get_detected_in_on() ;

        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }

        return $msg ;

    }

    // -----------------------------------------------------------------------

    if ( $bytes_written !== strlen( $json ) ) {

        $msg = '"bytes written" failure saving PHP array as JSON' ;

        $msg .= load_save_array_get_detected_in_on() ;

        if ( $question_die_on_error ) {
            die( $msg ) ;   //  Doesn't return.
        }

        return $msg ;

    }

    // -----------------------------------------------------------------------

    return TRUE ;

    // -----------------------------------------------------------------------

}

// ===========================================================================
// load_save_array_get_detected_in_on()
// ===========================================================================

function load_save_array_get_detected_in_on() {

    // -----------------------------------------------------------------------

    if (    function_exists( '\greatKiwi_errorHandling\get_detailed_error_messages' )
            &&
            \greatKiwi_errorHandling\get_detailed_error_messages() === TRUE
        ) {

        // ------------------------------------------------------------------

        $file = __FILE__ ;
        $line = __LINE__ ;

        return <<<EOT
\nFILE: {$filespec}
Detected on line {$line} of {$file}
EOT;

        // ------------------------------------------------------------------

    } else {

        // ------------------------------------------------------------------

        return '' ;

        // ------------------------------------------------------------------

    }

    // -----------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================


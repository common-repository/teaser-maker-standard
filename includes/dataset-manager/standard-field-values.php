<?php

// *****************************************************************************
// DATASET-MANAGER / STANDARD-FIELD-VALUES.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// get_server_datetime_UTC()
// =============================================================================

function get_server_datetime_UTC() {
    return time() ;
}

// =============================================================================
// get_server_micro_datetime_UTC()
// =============================================================================

function get_server_micro_datetime_UTC() {

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // "Micro" dates/times are expressed as floats like (eg):-
    //
    //      12.34 = 12 seconds and 340 microseconds
    //
    // "micro" = 1 millionth
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // mixed microtime ([ bool $get_as_float = false ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // microtime() returns the current Unix timestamp with microseconds. This
    // function is only available on operating systems that support the
    // gettimeofday() system call.
    //
    //      get_as_float
    //          If used and set to TRUE, microtime() will return a float instead
    //          of a string, as described in the return values section below.
    //
    // By default, microtime() returns a string in the form "msec sec", where
    // sec is the number of seconds since the Unix epoch (0:00:00 January 1,1970
    // GMT), and msec measures microseconds that have elapsed since sec and is
    // also expressed in seconds.
    //
    // If get_as_float is set to TRUE, then microtime() returns a float, which
    // represents the current time in seconds since the Unix epoch accurate to
    // the nearest microsecond.
    //
    // (PHP 4, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.0.0       The get_as_float parameter was added.
    // -------------------------------------------------------------------------

    if ( function_exists( 'microtime' ) ) {
        list( $usec , $sec ) = explode( chr(32) , microtime() ) ;
        return (float) $usec + (float) $sec ;
            //  Getting the microtime() as float this way works in both
            //  PHP 4 and 5.

    } else {
        return (float) time() ;

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_unique_key()
// =============================================================================

/*
function get_unique_key( $record_indices_by_key ) {

    // -------------------------------------------------------------
    // NOTE!
    // =====
    // A Standard Dataset Manager "unique_id" AKA "unique_key" is
    // a 13-character alphanumeric (hex ?) string like (eg):-
    //
    //      "52cf9128b8ca9"
    //      "52cf9128b8ce3"
    //      "52cf9128b8d1c"
    //      "52cf9128b8d53"
    //      "52cf9128b8d8c"
    //
    // -------------------------------------------------------------

    // -------------------------------------------------------------------------
    // string uniqid ([ string $prefix = "" [, bool $more_entropy = false ]] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Gets a prefixed unique identifier based on the current time in
    // microseconds.
    //
    //      prefix
    //          Can be useful, for instance, if you generate identifiers
    //          simultaneously on several hosts that might happen to generate
    //          the identifier at the same microsecond.
    //
    //          With an empty prefix, the returned string will be 13 characters
    //          long. If more_entropy is TRUE, it will be 23 characters.
    //
    //      more_entropy
    //          If set to TRUE, uniqid() will add additional entropy (using the
    //          combined linear congruential generator) at the end of the return
    //          value, which increases the likelihood that the result will be
    //          unique.
    //
    // Returns the unique identifier, as a string.
    // -------------------------------------------------------------------------

    while ( TRUE ) {

        $uniqid = uniqid() ;

        if ( array_key_exists( $uniqid , $record_indices_by_key ) === FALSE ) {
            break ;
        }

    }

    // -------------------------------------------------------------

    return $uniqid ;

    // -------------------------------------------------------------

}
*/

// =============================================================================
// That's that!
// =============================================================================


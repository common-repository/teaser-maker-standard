<?php

// *****************************************************************************
// DATASET-MANAGER / RECORD-KEY-SUPPORT.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// get_unique_record_key_for_dataset()
// =============================================================================

function get_unique_record_key_for_dataset(
    $record_indices_by_key
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_unique_record_key_for_dataset(
    //      $record_indices_by_key
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              $record_key STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    while ( TRUE ) {

        $key = get_unique_record_key() ;

        if ( is_array( $key ) ) {
            return $key ;
        }

        if ( ! array_key_exists( $key , $record_indices_by_key ) ) {
            return $key ;
        }

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_unique_record_key()
// =============================================================================

function get_unique_record_key() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_unique_record_key()
    // - - - - - - - - - - - - - - - - -
    // The returned key is like (eg):-
    //
    //               1         2         3         4         5
    //      123456789012345678901234567890123456789012345678901
    //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
    //
    //               1         2         3         4         5         6
    //      12345678901234567890123456789012345678901234567890123456789012345
    //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
    //      ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^^^^ ^^^^^^^^^^
    //                  GUID PART                 MICROTIME PART   SEQUENTIAL
    //                                                             RECORD NO.
    //                                                             PART
    //
    // So it's 51 to 65 characters long.  And if PHP_INT_MAX (for the
    // "sequential record number" part), were to increase, it could be even
    // longer.
    //
    // =>   Make 50 to 80 or so characters, the limits for validity checking.
    //
    // RETURNS
    //      o   On SUCCESS
    //              $record_key STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // GUID Part...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // MSDN defines GUID as "a 128-bit integer (16 bytes) that can be used
    // across all computers and networks wherever a unique identifier is
    // required. Such an identifier has a very low probability of being
    // duplicated."
    //
    // GUID consists of alphanumeric characters only and is grouped in five
    // groups separated by hyphens as seen in this example:
    //      3f2504e0-4f89-11d3-9a0c-0305e82c3301
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // From:-
    //      http://www.php.net/manual/en/function.com-create-guid.php
    // -------------------------------------------------------------------------

    if ( function_exists( '\com_create_guid' ) === TRUE ) {
        $guid_part = strtolower( trim( com_create_guid() , '{}' ) ) ;

    } else {
        $guid_part = strtolower( sprintf(
                        '%04X%04X-%04X-%04X-%04X-%04X%04X%04X'  ,
                        mt_rand(     0 , 65535 )                ,
                        mt_rand(     0 , 65535 )                ,
                        mt_rand(     0 , 65535 )                ,
                        mt_rand( 16384 , 20479 )                ,
                        mt_rand( 32768 , 49151 )                ,
                        mt_rand(     0 , 65535 )                ,
                        mt_rand(     0 , 65535 )                ,
                        mt_rand(     0 , 65535 )
                        ) ) ;

    }

    // =========================================================================
    // MicroTime Part...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // By adding in the micro-time we guarantee a reasonable degree of
    // uniqueness.  Since microtime() is accurate to 1us (= 1 millionth of
    // a second).
    //
    // But it is (at least theoretically,) possible for this function:-
    //      get_unique_record_key()
    //
    // to be called more than once in a given 1us period (particularly on
    // very fast machines)
    //
    // ---
    //
    // Note that on a standard 2012 era desktop, the following code:-
    //
    //      while ( TRUE ) {
    //          $gtod = gettimeofday() ;
    //          echo '<br />' , $gtod['sec'] , ' &nbsp;&mdash;&nbsp; ' , $gtod['usec'];
    //      }
    //
    // generates (eg):=-
    //
    //      1400040711  --  999977
    //      1400040711  --  999981
    //      1400040711  --  999985
    //      1400040711  --  999988
    //      1400040711  --  999999
    //      1400040712  --  2
    //      1400040712  --  6
    //      1400040712  --  10
    //      1400040712  --  13
    //      1400040712  --  17
    //      1400040712  --  20
    //      ...         --
    //      1400040712  --  91
    //      1400040712  --  95
    //      1400040712  --  98
    //      1400040712  --  102
    //      1400040712  --  106
    //      ...         --
    //      1400040712  --  982
    //      1400040712  --  986
    //      1400040712  --  989
    //      1400040712  --  993
    //      1400040712  --  996
    //      1400040712  --  1000
    //      1400040712  --  1004
    //      1400040712  --  1007
    //      ...
    //
    // So in general (on standard desktops), two sequential calls to:-
    //      gettimeofday()
    //
    // will generate different micro-second precesion time values.
    //
    // But to guarantee that two sequential calls to:-
    //      get_unique_record_key()
    //
    // generate two different micro-second precision time values. we:-
    //
    //      o   Call "gettimeofday()" once, to get an initial value.
    //
    //      o   Then call "gettimeofday()" repetitively, until we get a
    //          different value.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // mixed gettimeofday ([ bool $return_float = false ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - -
    // This is an interface to gettimeofday(2). It returns an associative array
    // containing the data returned from the system call.
    //
    //      return_float
    //          When set to TRUE, a float instead of an array is returned.
    //
    // By default an array is returned. If return_float is set, then a float is
    // returned.
    //
    //      Array keys:
    //
    //      "sec"           - seconds since the Unix Epoch
    //      "usec"          - microseconds
    //      "minuteswest"   - minutes west of Greenwich
    //      "dsttime"       - type of dst correction
    //
    // (PHP 4, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.1.0       The return_float parameter was added.
    //
    // NOTE!
    // =====
    // The "microtime()" function has a note that says:-
    //      "This function is only available on operating systems that support
    //      the gettimeofday() system call."
    //
    // Does this note apply to the "gettimeofday()" function too ?
    // -------------------------------------------------------------------------

    if ( \function_exists( '\gettimeofday' ) ) {

        // ----------------------------------------------------------------------
        // Use the "gettimeofday()" function...
        // ----------------------------------------------------------------------

        $gtod = gettimeofday() ;
        $initial_microtime_part = $gtod['sec'] . '-' . $gtod['usec'] ;

        // ---------------------------------------------------------------------

        while ( TRUE ) {
            $gtod = gettimeofday() ;
            $microtime_part = $gtod['sec'] . '-' . $gtod['usec'] ;
            if ( $microtime_part !== $initial_microtime_part ) {
                break ;
            }
        }

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------
        // NO "gettimeofday()" function...
        // ---------------------------------------------------------------------

        $initial_time = time() ;

        // ---------------------------------------------------------------------

        while ( TRUE ) {
            $microtime_part = time() ;
            if ( $microtime_part !== $initial_time ) {
                break ;
            }
        }

        // ---------------------------------------------------------------------

        $microtime_part .= '-' . mt_rand( 0 , 999999 ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Sequential Record Number Part...
    // =========================================================================

    // -------------------------------------------------------------------------
    // get_option( $option, $default )
    // - - - - - - - - - - - - - - - -
    // A safe way of getting values for a named option from the options database
    // table. If the desired option does not exist, or no value is associated
    // with it, FALSE will be returned.
    //
    //      $option
    //          (string) (required) Name of the option to retrieve. A concise
    //          list of valid options is below, but a more complete one can be
    //          found at the Option Reference. Matches $option_name in
    //          register_setting() for custom options.
    //
    //          Default: None
    //
    //          Underscores separate words, lowercase only - this is going to be
    //          in a database.
    //
    //      $default
    //          (mixed) (optional) The default value to return if no value is
    //          returned (ie. the option is not in the database).
    //
    //          Default: false
    //
    // RETURN VALUES
    //      (mixed)
    //      Current value for the specified option. If the specified option does
    //      not exist, returns boolean FALSE.
    //
    // CHANGELOG
    //      Since 1.5.0
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // update_option( $option, $new_value )
    // - - - - - - - - - - - - - - - - - -
    // Use the function update_option() to update a named option/value pair to
    // the options database table. The $option (option name) value is escaped
    // with $wpdb->prepare before the INSERT statement but not the option value,
    // this value should always be properly sanitized.
    //
    // This function may be used in place of add_option, although it is not as
    // flexible. update_option will check to see if the option already exists.
    // If it does not, it will be added with add_option('option_name',
    // 'option_value'). Unless you need to specify the optional arguments of
    // add_option(), update_option() is a useful catch-all for both adding and
    // updating options.
    //
    // Note:    This function cannot be used to change whether an option is to
    //          be loaded (or not loaded) by wp_load_alloptions(). In that case,
    //          a delete_option() should be followed by use of the add_option()
    //          function.
    //
    //      $option
    //          (string) (required) Name of the option to update. Must not
    //          exceed 64 characters. A list of valid default options to update
    //          can be found at the Option Reference.
    //
    //          Default: None
    //
    //      $newvalue
    //          (mixed) (required) The NEW value for this option name. This
    //          value can be an integer, string, array, or object.
    //
    //          Default: None
    //
    // RETURN VALUE
    //      (boolean)
    //      True if option value has changed, false if not or if update failed.
    //
    // CHANGE LOG
    //      Since: 1.0.0
    // -------------------------------------------------------------------------

    $option_name = 'great_kiwi_dataset_manager_last_used_sequential_record_number' ;
                        //  61 characters (max. 64)

//echo '<br /><br />' , strlen( $option_name ) ;

    // -------------------------------------------------------------------------

    $last_used_sequential_record_number = \get_option( $option_name ) ;

//echo '<br />WAS: ' , $last_used_sequential_record_number ;

    // -------------------------------------------------------------------------

    if ( $last_used_sequential_record_number === FALSE ) {
        $last_used_sequential_record_number = 1 ;

    } else {
        if ( $last_used_sequential_record_number == PHP_INT_MAX ) {
            $last_used_sequential_record_number = 1 ;

        } else {
            $last_used_sequential_record_number++ ;

        }

    }

//if ( $last_used_sequential_record_number === 8 ) {
//    $last_used_sequential_record_number = PHP_INT_MAX - 2 ;
//}

//echo '<br />NOW: ' , $last_used_sequential_record_number ;

    // -------------------------------------------------------------------------

    $ok = \update_option( $option_name , $last_used_sequential_record_number ) ;

    // -------------------------------------------------------------------------

    if ( $ok !== TRUE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; "update_option()" failure updating "{$option_name}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    $sequential_part = (string) $last_used_sequential_record_number ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return <<<EOT
{$guid_part}-{$microtime_part}-{$sequential_part}
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// is_record_key()
// =============================================================================

function is_record_key(
    $candidate_record_key
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // is_record_key(
    //      $candidate_record_key
    //      )
    // - - - - - - - - - - - - - - - - -
    // Is the input string a record key like (eg):-
    //
    //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
    //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
    //      etc
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              FALSE
    // ---------------------------------------------------------------------------

//echo '<br /><br />' , $candidate_record_key ;

    // -------------------------------------------------------------------------

    if ( ! \is_string( $candidate_record_key ) ) {
        return FALSE ;
    }

    // -------------------------------------------------------------------------

    if (    strlen( $candidate_record_key ) === 13
            &&
            \ctype_alnum( $candidate_record_key )
        ) {
        return TRUE ;
            //  Old style record key created with "uniqid()"
    }

    // -------------------------------------------------------------------------
    // New style record keys (from May 2014), are like (eg):-
    //
    //               1         2         3         4         5
    //      123456789012345678901234567890123456789012345678901
    //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-0-1
    //
    //               1         2         3         4         5         6
    //      12345678901234567890123456789012345678901234567890123456789012345
    //      3f2504e0-4f89-11d3-9a0c-0305e82c3301-1400040711-999977-2147483647
    //      ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ^^^^^^^^^^^^^^^^^ ^^^^^^^^^^
    //                  GUID PART                 MICROTIME PART   SEQUENTIAL
    //                                                             RECORD NO.
    //                                                             PART
    //
    // So it's 51 to 65 characters long.  And if PHP_INT_MAX (for the
    // "sequential record number" part), were to increase, it could be even
    // longer.
    //
    // =>   Make 50 to 80 or so characters, the limits for validity checking.
    // -------------------------------------------------------------------------

    //  NOTE!   The special regular expression characters are:
    //              . \ + * ? [ ^ ] $ ( ) { } = ! < > | : -

    $pattern =
        '/^[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}-\d{10}-\d{1,6}-\d{1,10}$/'
        ;

    // -------------------------------------------------------------------------

    $number_matches = \preg_match(
                            $pattern                ,
                            $candidate_record_key
                            ) ;
                            //  preg_match() returns 1 if the pattern matches
                            //  given subject, 0 if it does not, or FALSE if an
                            //  error occurred.

    // -------------------------------------------------------------------------

    if ( $number_matches === FALSE ) {

        $ns = __NAMESPACE__ ;
        $fn = __FUNCTION__  ;

        $msg = <<<EOT
PROBLEM:&nbsp; "preg_match()" failure checking record key
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        die( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------

    if ( $number_matches === 1 ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    return FALSE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


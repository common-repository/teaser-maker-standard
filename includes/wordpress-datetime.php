<?php

// *****************************************************************************
// INCLUDES / WORDPRESS-DATETIME.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressDateTime ;

// =============================================================================
// get_current_site_time()
// =============================================================================

function get_current_site_time() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressDateTime\
    // get_current_site_time()
    // - - - - - - - - - - - -
    // Returns the current time with respect to the site's timezone, as a
    // Unix Timestamp (double/float value).  Eg:-
    //      1382230429
    //
    // NOTE that this time ISN'T UTC.  It's in the SITE's timezone, as defined
    // on the "Settings" -> "General Settings" page in the WordPress Admin.
    //
    // Call "get_sites_timezone()" to get that timezone.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          The current time with respect to the site's timezone, as a
    //          Unix Timestamp (double/float value).  Eg:-
    //              1382230429
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // current_time( $type , $gmt = 0 )
    // - - - - - - - - - - - - - - - -
    // Returns the blog's current local time in one of two formats, either
    // MySQL's timestamp data type format (i.e. YYYY-MM-DD HH:MM:SS) or the Unix
    // timestamp format (i.e. epoch).  The optional secondary parameter can be
    // used to retrieve GMT time instead of the blog's local time.
    //
    // The local time returned is based on the timezone set on the blog's
    // General Settings page, which is UTC by default.
    //
    // current_time( 'timestamp' ) should be used in lieu of time() to return
    // the blog's local time. In WordPress, PHP's time() will always return UTC
    // and is the same as calling current_time( 'timestamp', true ).
    //
    //      $type
    //          (string) (required) The time format to return. Possible values:
    //              mysql
    //              timestamp
    //
    //          Default: None
    //
    //      $gmt
    //          (integer) (optional) The time zone (GMT, local) of the returned
    //          time: Possible values:
    //              1
    //              0
    //
    //          Default: 0
    //
    // RETURNS
    // -------
    // If the first parameter is 'mysql', the function returns a date-time
    // string. If the first parameter is 'timestamp', the function returns a
    // double value equal to the number of seconds since Jan. 1, 1970. When
    // strict data typing is necessary, take note that the PHP time() function,
    // which current_time() replaces, returns an integer value, so consider
    // using (int) current_time( 'timestamp' ) instead.
    //
    // If the optional second parameter is 1, the value returned represents the
    // current GMT time. If 0 or no second parameter are set, the value returned
    // represents the local time for the timezone declared in the blog's
    // Timezone setting on the General Settings page.
    //
    // EXAMPLES
    // --------
    // echo "current_time( 'mysql' )
    //      returns local site time: " . current_time( 'mysql' ) . '<br />';
    //
    // echo "current_time( 'mysql', 1 )
    //      returns GMT: " . current_time( 'mysql', 1 ) . '<br />';
    //
    // echo "current_time( 'timestamp' )
    //      returns local site time: " . date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
    //
    // echo "current_time( 'timestamp', 1 )
    //      returns GMT: " . date( 'Y-m-d H:i:s', current_time( 'timestamp', 1 ) );
    // -------------------------------------------------------------------------

    $timestamp = current_time( 'timestamp', 0 ) ;

    // -------------------------------------------------------------------------

    if ( ! ctype_digit( (string) $timestamp ) ) {

        return <<<EOT
PROBLEM: Bad site timestamp
Detected in:  "get_current_site_time()"
EOT;

    }

    // -------------------------------------------------------------------------

    return $timestamp ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_sites_timezone()
// =============================================================================

function get_sites_timezone() {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressDateTime\
    // get_sites_timezone()
    // - - - - - - - - - -
    // Returns the site's timezone - as set on the "Settings" -> "General
    // Settings" page in the site's WordPress Admin.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          $site_timezone STRING.  Eg:-
    //              "Pacific/Auckland"
    //
    //      o   On FAILURE
    //          - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // get_option( $option , $default )
    // - - - - - - - - - - - - - - - -
    // A safe way of getting values for a named option from the options database
    // table.  If the desired option does not exist, or no value is associated
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
    //      (mixed) Current value for the specified option. If the specified
    //      option does not exist, returns boolean FALSE.
    // -------------------------------------------------------------------------

    $sites_timezone = get_option( 'timezone_string' ) ;

//pr( $sites_timezone , 'SITE\'S TIMEZONE' ) ;

    // -------------------------------------------------------------------------

    if ( $sites_timezone === FALSE ) {

        $msg = <<<EOT
PROBLEM: No "timezone_string"
Try setting the site's timezone on the "Settings" &raquo; "General" page in the
WordPress Admin.
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_string( $sites_timezone ) ) {

        $msg = <<<EOT
PROBLEM: Bad "timezone_string" (NOT a STRING)
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    $sites_timezone = trim( $sites_timezone ) ;

    // -------------------------------------------------------------------------

    if ( $sites_timezone === '' ) {

        //  --------------------------------------------------------------------
        //  NOTE!
        //  -----
        //  We come here if the user selects one of the "Manual Offsets" from
        //  the "Timezone" dropdown on the WordPress "General" >> "Settings"
        //  page.
        //  --------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM: Bad "timezone_string" (empty string)
Try setting the site's timezone on the "Settings" &raquo; "General" page in the
WordPress Admin.&nbsp; Though you MUST choose a CITY - and NOT one of the
"Manual Offsets" listed at the bottom of the "Timezones" selector on that page.
EOT;

        return array( $msg ) ;


        //  --------------------------------------------------------------------
        //  When a "Manual Offset" is selected (from the "Timezone" dropdown
        //  on the "General" >> "Settings" page of the WordPress Admin), then:-
        //
        //      1.  The WordPress:-
        //              "timezone_string"
        //
        //          option holds the empty string, and;
        //
        //      2.  The WordPress:-
        //              "gmt_offset"
        //
        //          option holds a STRING value like (eg):-
        //              o   "9"         >>  GMT + 9 hours
        //              o   "-8"        >>  GMT - 8 hours
        //              o   "6.5"       >>  GMT + 6.5 hours
        //              o   "-5.75"     >>  GMT - 5.75 hours
        //              o   etc.
        //
        //  In this case we return the $timezone string in the:-

        //  --------------------------------------------------------------------

//      $gmt_offset = get_option( 'gmt_offset' ) ;

//echo '<h2>' , $gmt_offset , ' --- ' , gettype( $gmt_offset ) . '</h2>' ;
//exit() ;

        //  --------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return $sites_timezone ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_pretty_datetime__for_timezone()
// =============================================================================

function get_pretty_datetime__for_timezone(
    $datetime_UTC                   ,
    $timezone = UTC                 ,
    $format = 'D j M Y H:i:s e'
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressDateTime\
    // get_pretty_datetime__for_timezone(
    //      $datetime_UTC                   ,
    //      $timezone = UTC                 ,
    //      $format = 'D j M Y H:i:s e'
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Converts the specified Unix Timestamp into a string like (eg):-
    //      "Mon 7 February 2013, 16:00 (4:00am)"
    //
    // $format is the date format string (as for the "date()" command).
    //
    // The string is returned in the LOCAL TIME (specified by $timezone).
    // -------------------------------------------------------------------------

    $datetime_obj = new \DateTime(
                        '@' . $datetime_UTC
                        ) ;
                        //  LOCALIZED NOTATIONS
                        //  ===================
                        //
                        //  DESCRIPTION     FORMAT           EXAMPLES
                        //  --------------  ---------------  -------------
                        //  Unix Timestamp  "@" "-"? [0-9]+  "@1215282385"
                        //  ----------------------------------------------
                        //
                        //  Note:
                        //  -----
                        //  The "Unix Timestamp" format sets the timezone to UTC.

    // -------------------------------------------------------------------------

    $datetime_obj->setTimezone(
        new \DateTimeZone( $timezone )
        ) ;

    // -------------------------------------------------------------------------

    return $datetime_obj->format( $format ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// wordpress_site_date()
// =============================================================================

function wordpress_site_date(
    $format         ,
    $time = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressDateTime\
    // wordpress_site_date(
    //      $format         ,
    //      $time = NULL
    //      )
    // - - - - - - - - - - -
    // Works like the PHP "date()" command (though it accepts NO $time
    // value).
    //
    // Instead, it gets the current time in the timezone specified on the
    // "Settings" -> "General Settings" page (in the site's WordPress Admin
    // section).
    //
    // NOTE!
    // =====
    // The PHP "date()" command uses the current time as understood by PHP.
    //
    // Which is in the timezone set in the server's PHP settings.  And which
    // timezone can easily be different from the timezone to which the
    // WordPress site is set.
    //
    // For example a server in (say) Berlin, would likely be set to the
    // "Europe/Berlin" timezone.  So using PHP's "date()" and "time()"
    // commands will give incorrect values for a WordPress site serving
    // content for NZ users (= "Pacific/Auckland" timezone).
    //
    // RETURNS
    //      o   On SUCCESS
    //              $formatted_date STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    if ( $time === NULL ) {
        $time = \time() ;
    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressDateTime\
    // get_sites_timezone()
    // - - - - - - - - - -
    // Returns the site's timezone - as set on the "Settings" -> "General
    // Settings" page in the site's WordPress Admin.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          $site_timezone STRING.  Eg:-
    //              "Pacific/Auckland"
    //
    //      o   On FAILURE
    //          - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    $timezone = get_sites_timezone() ;

    // -------------------------------------------------------------------------

    if ( is_array( $timezone ) ) {
        return $timezone ;
    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wordpressDateTime\
    // get_pretty_datetime__for_timezone(
    //      $datetime_UTC                   ,
    //      $timezone = UTC                 ,
    //      $format = 'D j M Y H:i:s e'
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Converts the specified Unix Timestamp into a string like (eg):-
    //      "Mon 7 February 2013, 16:00 (4:00am)"
    //
    // $format is the date format string (as for the "date()" command).
    //
    // The string is returned in the LOCAL TIME (specified by $timezone).
    // -------------------------------------------------------------------------

    return get_pretty_datetime__for_timezone(
                $time       ,
                $timezone   ,
                $format
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_month_full_name_in_english__by_number_1_to_12()
// =============================================================================

function get_month_full_name_in_english__by_number_1_to_12( $month_number ) {

    // -------------------------------------------------------------------------

    $month_names_by_number = array(
        1   =>  'January'       ,
        2   =>  'February'      ,
        3   =>  'March'         ,
        4   =>  'April'         ,
        5   =>  'May'           ,
        6   =>  'June'          ,
        7   =>  'July'          ,
        8   =>  'August'        ,
        9   =>  'September'     ,
        10  =>  'October'       ,
        11  =>  'November'      ,
        12  =>  'December'
        ) ;

    // -------------------------------------------------------------------------

    if ( array_key_exists( $month_number , $month_names_by_number ) ) {
        return $month_names_by_number[ $month_number ] ;
    }

    // -------------------------------------------------------------------------

    return $month_number ;

    // -------------------------------------------------------------------------

}

    // -------------------------------------------------------------------------
    // int mktime ([ int $hour = date("H") [, int $minute = date("i") [, int $second = date("s") [, int $month = date("n") [, int $day = date("j") [, int $year = date("Y") [, int $is_dst = -1 ]]]]]]] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the Unix timestamp corresponding to the arguments given. This
    // timestamp is a long integer containing the number of seconds between the
    // Unix Epoch (January 1 1970 00:00:00 GMT) and the time specified.
    //
    // Arguments may be left out in order from right to left; any arguments thus
    // omitted will be set to the current value according to the local date and
    // time.
    //
    //      hour
    //          The number of the hour relative to the start of the day
    //          determined by month, day and year. Negative values reference the
    //          hour before midnight of the day in question. Values greater than
    //          23 reference the appropriate hour in the following day(s).
    //
    //      minute
    //          The number of the minute relative to the start of the hour.
    //          Negative values reference the minute in the previous hour.
    //          Values greater than 59 reference the appropriate minute in the
    //          following hour(s).
    //
    //      second
    //          The number of seconds relative to the start of the minute.
    //          Negative values reference the second in the previous minute.
    //          Values greater than 59 reference the appropriate second in the
    //          following minute(s).
    //
    //      month
    //          The number of the month relative to the end of the previous
    //          year. Values 1 to 12 reference the normal calendar months of the
    //          year in question. Values less than 1 (including negative values)
    //          reference the months in the previous year in reverse order, so 0
    //          is December, -1 is November, etc. Values greater than 12
    //          reference the appropriate month in the following year(s).
    //
    //      day
    //          The number of the day relative to the end of the previous month.
    //          Values 1 to 28, 29, 30 or 31 (depending upon the month)
    //          reference the normal days in the relevant month. Values less
    //          than 1 (including negative values) reference the days in the
    //          previous month, so 0 is the last day of the previous month, -1
    //          is the day before that, etc. Values greater than the number of
    //          days in the relevant month reference the appropriate day in the
    //          following month(s).
    //
    //      year
    //          The number of the year, may be a two or four digit value, with
    //          values between 0-69 mapping to 2000-2069 and 70-100 to
    //          1970-2000. On systems where time_t is a 32bit signed integer, as
    //          most common today, the valid range for year is somewhere between
    //          1901 and 2038. However, before PHP 5.1.0 this range was limited
    //          from 1970 to 2038 on some systems (e.g. Windows).
    //
    //      is_dst
    //          This parameter can be set to 1 if the time is during daylight
    //          savings time (DST), 0 if it is not, or -1 (the default) if it is
    //          unknown whether the time is within daylight savings time or not.
    //          If it's unknown, PHP tries to figure it out itself. This can
    //          cause unexpected (but not incorrect) results. Some times are
    //          invalid if DST is enabled on the system PHP is running on or
    //          is_dst is set to 1. If DST is enabled in e.g. 2:00, all times
    //          between 2:00 and 3:00 are invalid and mktime() returns an
    //          undefined (usually negative) value. Some systems (e.g. Solaris
    //          8) enable DST at midnight so time 0:30 of the day when DST is
    //          enabled is evaluated as 23:30 of the previous day.
    //
    //          Note:   As of PHP 5.1.0, this parameter became deprecated. As a
    //                  result, the new timezone handling features should be
    //                  used instead.
    //
    // mktime() returns the Unix timestamp of the arguments given. If the
    // arguments are invalid, the function returns FALSE (before PHP 5.1 it
    // returned -1).
    //
    // ERRORS/EXCEPTIONS
    //      Every call to a date/time function will generate a E_NOTICE if the
    //      time zone is not valid, and/or a E_STRICT or E_WARNING message if
    //      using the system settings or the TZ environment variable. See also
    //      date_default_timezone_set()
    // -------------------------------------------------------------------------

// =============================================================================
// That's that!
// =============================================================================


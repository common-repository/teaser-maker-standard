<?php

// *****************************************************************************
// BASEPRESS / BASEPRESS-MYSQL.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql ;

// -----------------------------------------------------------------------------
// OVERVIEW
// ========
// Read/write a MySQL database - using the WordPress WPDB class.
// -----------------------------------------------------------------------------

// =============================================================================
// $GLOBALS['BASEPRESS']['MYSQL']['error_detail']
// =============================================================================

    $GLOBALS['BASEPRESS']['MYSQL']['error_level'] = 'user' ;
        //  Possibly overridden below...

    $GLOBALS['BASEPRESS']['MYSQL']['question_die_on_error'] = TRUE ;
        //  Possibly overridden below...

// =============================================================================
// set_error_handling()
// =============================================================================

function set_error_handling(
    $level                  ,
    $question_die_on_error
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\set_error_handling(
    //      $level                  ,
    //      $question_die_on_error
    //      )
    // - - - - - - - - - - - - - - - - - -
    // Sets:-
    //      $GLOBALS['BASEPRESS']['MYSQL']['error_level']
    //      $GLOBALS['BASEPRESS']['MYSQL']['question_die_on_error']
    //
    // to the specified values.
    //
    // $level must be one of:-
    //
    //      'none'          //  NO error messages at all
    //
    //      'user'          //  Simple generic error messages
    //                      //  suitable for front-end where you
    //                      //  want to keep any info. that might
    //                      //  assist hackers to a minimum.
    //
    //      'developer'     //  Detailed error messages (as much
    //                      //  info. as possible.
    //
    // $question_die_on_error must be TRUE or FALSE.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      TRUE
    //
    //      On FAILURE
    //      - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $allowed_error_levels = array(

        'none'              ,       //  NO error messages at all

        'user'              ,       //  Simple generic error messages
                                    //  suitable for front-end where you
                                    //  want to keep any info. that might
                                    //  assist hackers to a minimum.

        'developer'                 //  Detailed error messages (as much
                                    //  info. as possible.

        ) ;

    // -------------------------------------------------------------------------

    if ( ! in_array( $level , $allowed_error_levels , TRUE ) ) {

        return <<<EOT
PROBLEM: Bad BasePress MySQL error level
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_bool( $question_die_on_error ) ) {

        return <<<EOT
PROBLEM: Bad BasePress MySQL "question_die_on_error"
EOT;

    }

    // -------------------------------------------------------------------------

    $GLOBALS['BASEPRESS']['MYSQL']['error_level'] =
        $level
        ;

    $GLOBALS['BASEPRESS']['MYSQL']['question_die_on_error'] =
        $question_die_on_error
        ;

    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// Set the DEFAULT ERROR HANDLING...
// =============================================================================

    $level = 'user' ;

    $question_die_on_error = TRUE ;

    set_error_handling(
        $level                  ,
        $question_die_on_error
        ) ;

// =============================================================================
// handle_error()
// =============================================================================

function handle_error(
    $__FUNCTION__               ,
    $__LINE__                   ,
    $sql                        ,
    $user_message               ,
    $developer_message = NULL
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\handle_error(
    //      $__FUNCTION__               ,
    //      $__LINE__                   ,
    //      $sql                        ,
    //      $user_message               ,
    //      $developer_message = NULL
    //      )
    // - - - - - - - - - - - - - - - - -
    // Call like:-
    //
    //      $user_message = "xxx" ;
    //      $developer_message = "yyy" or NULL ;
    //      return handle_error(
    //                  __FUNCTION__        ,
    //                  __LINE__            ,
    //                  $sql                ,
    //                  $user_message       ,
    //                  $developer_message
    //                  ) ;
    //
    // Handles the error as specified by:-
    //      $GLOBALS['BASEPRESS']['MYSQL']['error_level']
    //      $GLOBALS['BASEPRESS']['MYSQL']['question_die_on_error']
    //
    // In other words:-
    //      o   May or may not issue or return an error message, and;
    //      o   May or may not return
    //
    // If $developer_message === NULL, then the $user_message is output
    // followed by:-
    //      o   MySQL error number
    //      o   MySQL error text
    //      o   $sql (the query that failed)
    //      o   PHP __FUNCTION__
    //      o   PHP __FILE__
    //      o   PHP __LINE__
    // -------------------------------------------------------------------------

    // =========================================================================
    // Create the ERROR MESSAGE...
    // =========================================================================

    $error_message = $user_message ;

    // -------------------------------------------------------------------------

    if ( $GLOBALS['BASEPRESS']['MYSQL']['error_level'] === 'none' ) {

        // ---------------------------------------------------------------------

        $error_message = '' ;

        // ---------------------------------------------------------------------

    } elseif ( $GLOBALS['BASEPRESS']['MYSQL']['error_level'] === 'developer' ) {

        // ---------------------------------------------------------------------

        global $wpdb ;

        // ---------------------------------------------------------------------

        $errno = mysql_errno( $wpdb->dbh ) ;
                    //  Returns the error number from the last MySQL function,
                    //  or 0 (zero) if no error occurred.

        $error_text = $wpdb->last_error ;
                    //  The error text of the last mysql error.

        $__FILE__ = __FILE__ ;

        // ---------------------------------------------------------------------

        $error_message = <<<EOT
{$error_message}

MySQL error# {$errno}: {$error_text}
  From SQL Query: {$sql}
Detected in FILE: {$__FILE__}
    and FUNCTION: {$__FUNCTION__}
 at or near LINE: {$__LINE__}
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DIE or RETURN the error message...
    // =========================================================================

    if ( $GLOBALS['BASEPRESS']['MYSQL']['question_die_on_error'] ) {
        die( '<pre>' . $error_message . '</pre>' ) ;
    }

    // -------------------------------------------------------------------------

    return $error_message ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// prepend_wordpress_table_name_prefix()
// =============================================================================

function prepend_wordpress_table_name_prefix(
    $table_name
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\prepend_wordpress_table_name_prefix()
    //      $table_name
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Prepends the WordPress table prefix to the supplied table name, and
    // returns the result.
    //
    // NOTE!
    // =====
    // From:-
    //      http://codex.wordpress.org/Creating_Tables_with_Plugins
    //
    //    "DATABASE TABLE PREFIX
    //    =====================
    //    In the wp-config.php file, a WordPress site owner can define a
    //    database table prefix. By default, the prefix is "wp_", but you'll
    //    need to check on the actual value and use it to define your database
    //    table name. This value is found in the $wpdb->prefix variable. (If
    //    you're developing for a version of WordPress older than 2.0, you'll
    //    need to use the $table_prefix global variable, which is deprecated in
    //    version 2.1)."
    //
    // -------------------------------------------------------------------------

    global $wpdb ;

    return $wpdb->prefix . $table_name ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_zero_or_more_records()
// =============================================================================

function get_zero_or_more_records(
    $sql
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\get_zero_or_more_records(
    //      $sql
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // NOTES!
    // ======
    // 1.   The INPUT $sql should NOT be escaped.
    //
    // 2.   MySQL Data Types AREN'T PRESERVED!
    //      ----------------------------------
    //      In other words, something stored in the DB as a MySQL INT, WON'T
    //      necessarily be returned as a PHP INT.  It comes back as a STRING.
    //
    //      I haven't checked FLOATs and TIMESTAMPS, etc.  But I assume that
    //      the same applies to them.
    //
    //      Why this happens I'm not sure.  But presumably, since we access
    //      the datavase with the WordPress Wpdb class - it's that class's
    //      fault.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      The 0+ records specified by the SQL string (as a PHP numeric
    //      array of records).  Eg:-
    //
    //          $records = array(
    //              0   =>  array(
    //                          'field_name_1'  =>  <field_value_1>     ,
    //                          'field_name_2'  =>  <field_value_2>     ,
    //                          ...                 ...
    //                          'field_name_N'  =>  <field_value_N>
    //                          )
    //              ...
    //              )
    //
    //      On FAILURE
    //      - - - - -
    //      An error message STRING.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // $wpdb->get_results( 'query' , output_type )
    // - - - - - - - - - - - - - - - - - - - - - -
    // Generic, mulitple row results can be pulled from the database with
    // get_results.  The function returns the entire query result as an
    // array, or NULL on no result.  Each element of this array corresponds
    // to one row of the query result and, like get_row, can be an object,
    // an associative array, or a numbered array.
    //
    //      query
    //          (string) The query you wish to run.  Setting this parameter
    //          to NULL will return the data from the cached results of the
    //          previous query.
    //
    //          NOTE!
    //          -----
    //          The INPUT $sql should NOT be escaped.
    //
    //      output_type
    //          One of four pre-defined constants.  Defaults to OBJECT.
    //          See SELECT a Row and its examples for more information.
    //
    //          OBJECT -    Result will be output as a numerically indexed
    //                      array of row objects.
    //
    //          OBJECT_K -  Result will be output as an associative array
    //                      of row objects, using first column's values
    //                      as keys (duplicates will be discarded).
    //
    //          ARRAY_A -   Result will be output as an numerically
    //                      indexed array of associative arrays, using
    //                      column names as keys.
    //
    //          ARRAY_N -   Result will be output as a numerically indexed
    //                      array of numerically indexed arrays.
    //
    // Since this function uses the '$wpdb->query()' function all the class
    // variables are properly set.  The results count for a 'SELECT' query
    // will be stored in $wpdb->num_rows.
    // -------------------------------------------------------------------------

    global $wpdb ;

    // -------------------------------------------------------------------------

    $result = $wpdb->get_results( $sql , ARRAY_A ) ;

//pr( $result ) ;

    // -------------------------------------------------------------------------

    if ( ! is_array( $result ) ) {

        return handle_error(
                        __FUNCTION__                ,
                        __LINE__                    ,
                        $sql                        ,
                        'Database READ failure'
                        ) ;

    }

    // -------------------------------------------------------------------------

    return $result ;

    // -------------------------------------------------------------------------
    // That's that!
    // -------------------------------------------------------------------------

}

// =============================================================================
// get_exactly_one_record()
// =============================================================================

function get_exactly_one_record(
    $sql
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\get_exactly_one_record(
    //      $sql
    //      )
    // - - - - - - - - - - - - - - - - - - - -
    // NOTES!
    // ======
    // 1.   The INPUT $sql should NOT be escaped.
    //
    // 2.   MySQL Data Types AREN'T PRESERVED!
    //      ----------------------------------
    //      In other words, something stored in the DB as a MySQL INT, WON'T
    //      necessarily be returned as a PHP INT.  It comes back as a STRING.
    //
    //      I haven't checked FLOATs and TIMESTAMPS, etc.  But I assume that
    //      the same applies to them.
    //
    //      Why this happens I'm not sure.  But presumably, since we access
    //      the datavase with the WordPress Wpdb class - it's that class's
    //      fault.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          The record specified by the SQL string (as a PHP
    //          associative ARRAY of NAME=VALUE pairs).
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    $records = get_zero_or_more_records( $sql ) ;

    // -------------------------------------------------------------------------

    if ( ! is_array( $records ) ) {
        return $records ;
    }

    // -------------------------------------------------------------------------

    if ( count( $records ) === 1 ) {
        return $records[0] ;
    }

    // -------------------------------------------------------------------------

    if ( count( $records ) < 1 ) {

        $msg = <<<EOT
PROBLEM: Requested database RECORD NOT FOUND
(when exactly ONE matching database record was expected)
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        $sql            ,
                        $msg
                        ) ;
    }

    // -------------------------------------------------------------------------

    $msg = <<<EOT
PROBLEM: MULTIPLE matching database records found
(when exactly ONE matching database record was expected)
EOT;

    return handle_error(
                    __FUNCTION__    ,
                    __LINE__        ,
                    $sql            ,
                    $msg
                    ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// add_record()
// =============================================================================

function add_record(
    $table_name         ,
    $raw_record_data
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\add_record(
    //      $table_name         ,
    //      $raw_record_data
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $raw_record_data should be like:-
    //
    //      $raw_record_data = array(
    //          'field_name_1'  =>  <field_value_1>     ,
    //          ...
    //          'field_name_N'  =>  <field_value_N>
    //          )
    //
    // In other words, $raw_record_data must be an associative ARRAY of
    //      field name  =>  field_value
    //
    // pairs.  Where:-
    //
    // 1.   At least ONE field must be specified.
    //
    // 2.   Field values can be any of the following PHP data types:-
    //          STRING
    //          INT
    //          FLOAT
    //          TRUE    (stored as 1 in the DB)
    //          FALSE   (stored as 0 in the DB)
    //          NULL    (stored as NULL in the DB)
    //
    //      PHP ARRAY and OBJECT type fields AREN'T allowed.
    //
    // 3.   You DON'T have to supply INT and FLOAT values as PHP
    //      INTs or FLOATS.  They can be supplied as PHP STRINGS
    //      (eg; from $_GET and/or $_POST).  And MySQL will
    //      automatically convert them (before storing them).
    //
    //      NOTE!
    //      -----
    //      Every value that "add_record()" supplies to MySQL will
    //      be supplied in STRING format.  So putting (eg):-
    //          $_GET['id']
    //
    //      into $raw_record_data like:-
    //          $raw_record_data['id'] = (int) $_GET['id']
    //
    //      is pointless.  Since "add_record()" will simply do:-
    //          (string) $raw_record_data['id']
    //
    //      to it before supplying it to MySQL.
    //
    // 4.   The field values MUST NOT be SQL escaped.  You MUST supply
    //      the RAW input data (even the raw $_GET and $_POST data
    //      entered by the user).  And "add_record()" will escape it
    //      for you.
    //
    // ---
    //
    // RETURNS either:-
    //      o   The new record's record ID (as PHP INT) on SUCCESS
    //      o   An error message STRING on FAILURE
    // -------------------------------------------------------------------------

    // =========================================================================
    // If there's NO record data, then there's NOTHING to do...
    // =========================================================================

    if ( ! is_array( $raw_record_data ) ) {

        $msg = <<<EOT
ADD RECORD failure ("raw_record_data" must be
an associative ARRAY of NAME=VALUE pairs).
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

    }

    // -------------------------------------------------------------------------

    if ( count( $raw_record_data ) < 1 ) {

        $msg = <<<EOT
ADD RECORD failure (record has NO FIELDS)
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

    }

    // -------------------------------------------------------------------------
    // $wpdb->insert( $table, $data, $format )
    // - - - - - - - - - - - - - - - - - - - -
    // PARAMETERS
    //
    //      table
    //          (string) The name of the table to insert data into.
    //
    //      data
    //          (array) Data to insert (in column => value pairs).  Both $data
    //          columns and $data values should be "raw" (neither should be
    //          SQL escaped).
    //
    //      format
    //          (array|string) (optional) An array of formats to be mapped to
    //          each of the value in $data. If string, that format will be used for all of the values in $data. If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.
    //
    //          Possible format values: %s as string; %d as decimal number;
    //          and %f as float.
    //
    // RETURNS
    //      int|false The number of rows inserted, or FALSE on error.
    //
    // EXAMPLE
    //      Insert two columns in a row, the first value being a string and
    //      the second a number:
    //
    //          $wpdb->insert(
    //                      'table',
    //                      array(
    //                          'column1' => 'value1',
    //                          'column2' => 123
    //                          ),
    //                      array(
    //                          '%s',
    //                          '%d'
    //                          )
    //                      ) ;
    //
    // -------------------------------------------------------------------------

    global $wpdb ;

    // -------------------------------------------------------------------------

    $table_name = $wpdb->escape( $table_name ) ;
                    //  Just being ultra-cautious

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // The $wpdb->insert() function expects you to tell it whether a given
    // field has a STRING or a NUMERIC value.
    //
    // But this is complicated and tedious - and something we'd like to
    // avoid.
    //
    // ---
    //
    // Fortunately, MySQL comes to our rescue here.  Because it allows you
    // (and in fact encourages you,) to put quotes around numeric values as
    // well as strings.  Ie, from:-
    //
    //      "Client Programming Security Guidelines"
    //      http://dev.mysql.com/doc/refman/5.6/en/secure-client-programming.html
    //
    // we have:-
    //
    //      "A common mistake is to protect only string data values.  Remember
    //      to check numeric data as well.  If an application generates a
    //      query such as:-
    //          SELECT * FROM table WHERE ID=234
    //
    //      when a user enters the value 234, the user can enter the value:-
    //          234 OR 1=1
    //
    //      to cause the application to generate the query:-
    //          SELECT * FROM table WHERE ID=234 OR 1=1
    //
    //      As a result, the server retrieves every row in the table.  This
    //      exposes every row and causes excessive server load.  The simplest
    //      way to protect from this type of attack is to use single quotation
    //      marks around the numeric constants:-
    //          SELECT * FROM table WHERE ID='234'
    //
    //      If the user enters extra information, it all becomes part of the
    //      string.  In a numeric context, MySQL automatically converts this
    //      string to a number and strips any trailing nonnumeric characters
    //      from it."
    // -------------------------------------------------------------------------

    // =========================================================================
    // Convert all data to strings - and generate the:-
    //      $wpdb->insert()
    //
    // required $formats array...
    // =========================================================================

    $formats = array() ;

    // -------------------------------------------------------------------------

    foreach ( $raw_record_data as $field_name => $field_value ) {

        // -------------------------------------------------------------------------
        // mysqlise_the_field_value(
        //      $table_name     ,
        //      $field_name     ,
        //      $field_value    ,
        //      $add_update
        //      )
        // - - - - - - - - - - - - -
        // Converts:-
        //      NULL  => 'NULL'
        //      TRUE  => '1'
        //      FALSE => '0'
        //      ...etc...
        //
        // RETURNS:-
        //      o   $mysqlised_field_value on SUCCESS
        //      o   array( $error_message_string ) on FALIURE
        // -------------------------------------------------------------------------

        $field_value = mysqlise_the_field_value(
                            $table_name     ,
                            $field_name     ,
                            $field_value    ,
                            'add'
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {

            return handle_error(
                            __FUNCTION__        ,
                            __LINE__            ,
                            ''                  ,
                            $field_value[0]
                            ) ;

        }

        // ---------------------------------------------------------------------

        $raw_record_data[ $field_name ] = $field_value ;

        // ---------------------------------------------------------------------

        $formats[] = '%s' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Perform the INSERT proper...
    // =========================================================================

    $number_rows_inserted = $wpdb->insert(
                                $table_name         ,
                                $raw_record_data    ,
                                $formats
                                ) ;

    // -------------------------------------------------------------------------

    if ( ! is_int( $number_rows_inserted ) ) {

        $msg = <<<EOT
Database INSERT failure
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

    }

    // -------------------------------------------------------------------------

    if ( $number_rows_inserted < 1 ) {

        $msg = <<<EOT
Database INSERT failure (couldn't ADD record)
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;
    }

    // =========================================================================
    // Get the new record's ID...
    // =========================================================================

    // -------------------------------------------------------------------------
    // $wpdb->insert_id
    // - - - - - - - -
    // After insert, the ID generated for the AUTO_INCREMENT column can be
    // accessed with:
    //      $wpdb->insert_id
    //
    // This function returns false if the row could not be inserted.
    // -------------------------------------------------------------------------

    $record_id = $wpdb->insert_id ;

    // -------------------------------------------------------------------------

    if ( $record_id === FALSE ) {

        $msg = <<<EOT
PROBLEM adding record to database (either the record
could NOT be added, or it's ID could not be fetched)
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

    }

    // =========================================================================
    // SUCCESS
    // =========================================================================

    return $record_id ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// update_exactly_one_record_by_id()
// =============================================================================

function update_exactly_one_record_by_id(
    $table_name         ,
    $raw_record_data    ,
    $record_id
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\update_exactly_one_record_by_id(
    //      $table_name         ,
    //      $raw_record_data    ,
    //      $record_id
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $raw_record_data should be like:-
    //
    //      $raw_record_data = array(
    //          'field_name_1'  =>  <field_value_1>     ,
    //          ...
    //          'field_name_N'  =>  <field_value_N>
    //          )
    //
    // In other words, $raw_record_data must be an associative ARRAY of
    //      field name  =>  field_value
    //
    // pairs.  Where:-
    //
    // 1.   At least ONE field must be specified.
    //
    // 2.   Field values can be any of the following PHP data types:-
    //          STRING
    //          INT
    //          FLOAT
    //          TRUE    (stored as 1 in the DB)
    //          FALSE   (stored as 0 in the DB)
    //          NULL    (stored as NULL in the DB)
    //
    //      PHP ARRAY and OBJECT type fields aren't allowed (and
    //      will cause an error-message return)
    //
    // 3.   You DON'T have to supply INT and FLOAT values as PHP
    //      INTs or FLOATS.  They can be supplied as PHP STRINGS
    //      (eg; from $_GET and/or $_POST).  And MySQL will
    //      automatically convert them (before storing them).
    //
    //      NOTE!
    //      -----
    //      Every value that "update_record()" supplies to MySQL will
    //      be supplied in STRING format.  So putting (eg):-
    //          $_GET['id']
    //
    //      into $raw_record_data like:-
    //          $raw_record_data['id'] = (int) $_GET['id']
    //
    //      is pointless.  Since "add_record()" will simply do:-
    //          (string) $raw_record_data['id']
    //
    //      to it before supplying it to MySQL.
    //
    // 4.   The field values MUST NOT be SQL escaped.  You MUST supply
    //      the RAW input data (even the raw $_GET and $_POST data
    //      entered by the user).  And "add_record()" will escape it
    //      for you.
    //
    // NOTE!
    // =====
    // $raw_record_data DOESN'T have to include ALL the fields in the record.
    // Only those whoose value you want to update (= set/change).
    //
    // ---
    //
    // $record_id should be a MySQL record id (1+).
    //
    // NOTE that the "id" field name is assumed to be "id" (lowercase).
    //
    // ---
    //
    // RETURNS either:-
    //      o   TRUE on SUCCESS
    //      o   An error message STRING on FAILURE
    // -------------------------------------------------------------------------

    return update_exactly_one_record(
                $table_name                     ,
                $raw_record_data                ,
                array( 'id' => $record_id )
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// update_exactly_one_record()
// =============================================================================

function update_exactly_one_record(
    $table_name         ,
    $raw_record_data    ,
    $where
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\update_exactly_one_record(
    //      $table_name         ,
    //      $raw_record_data    ,
    //      $where
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $raw_record_data should be like:-
    //
    //      $raw_record_data = array(
    //          'field_name_1'  =>  <field_value_1>     ,
    //          ...
    //          'field_name_N'  =>  <field_value_N>
    //          )
    //
    // In other words, $raw_record_data must be an associative ARRAY of
    //      field name  =>  field_value
    //
    // pairs.  Where:-
    //
    // 1.   At least ONE field must be specified.
    //
    // 2.   Field values can be any of the following PHP data types:-
    //          STRING
    //          INT
    //          FLOAT
    //          TRUE    (stored as 1 in the DB)
    //          FALSE   (stored as 0 in the DB)
    //          NULL    (stored as NULL in the DB)
    //
    //      PHP ARRAY and OBJECT type fields aren't allowed (and
    //      will cause an error-message return)
    //
    // 3.   You DON'T have to supply INT and FLOAT values as PHP
    //      INTs or FLOATS.  They can be supplied as PHP STRINGS
    //      (eg; from $_GET and/or $_POST).  And MySQL will
    //      automatically convert them (before storing them).
    //
    //      NOTE!
    //      -----
    //      Every value that "add_record()" supplies to MySQL will
    //      be supplied in STRING format.  So putting (eg):-
    //          $_GET['id']
    //
    //      into $raw_record_data like:-
    //          $raw_record_data['id'] = (int) $_GET['id']
    //
    //      is pointless.  Since "add_record()" will simply do:-
    //          (string) $raw_record_data['id']
    //
    //      to it before supplying it to MySQL.
    //
    // 4.   The field values MUST NOT be SQL escaped.  You MUST supply
    //      the RAW input data (even the raw $_GET and $_POST data
    //      entered by the user).  And "add_record()" will escape it
    //      for you.
    //
    // NOTE!
    // =====
    // $raw_record_data DOESN'T have to include ALL the fields in the record.
    // Only those whoose value you want to update (= set/change).
    //
    // ---
    //
    // $where is like (eg):-
    //
    //      $where = array(
    //                  'this'  =>  "xxx"
    //                  'that'  =>  Y
    //                  )
    //
    // Multiple where conditions are joined by AND.
    //
    // ---
    //
    // RETURNS either:-
    //      o   TRUE on SUCCESS
    //      o   An error message STRING on FAILURE
    // -------------------------------------------------------------------------

    $number_records_updated = update_records(
                                $table_name         ,
                                $raw_record_data    ,
                                $where
                                ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $number_records_updated ) ) {

        return handle_error(
                        __FUNCTION__                ,
                        __LINE__                    ,
                        ''                          ,
                        $number_records_updated
                        ) ;

    }

    // -------------------------------------------------------------------------

    if ( $number_records_updated === 1 ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    if ( $number_records_updated < 1 ) {

        $msg = <<<EOT
PROBLEM: Database record UPDATE FAILURE
---------------------------------------
We expected exactly ONE record to be updated.  But zero
records were actually updated.  Probably because either;
a) The record to be updated wasn't found, or;
b) The record's field data wasn't changed.
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;
    }

    // -------------------------------------------------------------------------

    $msg = <<<EOT
PROBLEM: MULTIPLE database records updated
------------------------------------------
We expected exactly ONE record to be updated.
But {$number_records_updated} were updated instead.
EOT;

    return handle_error(
                    __FUNCTION__    ,
                    __LINE__        ,
                    ''              ,
                    $msg
                    ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// update_records()
// =============================================================================

function update_records(
    $table_name         ,
    $raw_record_data    ,
    $where
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\update_records(
    //      $table_name         ,
    //      $raw_record_data    ,
    //      $where
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $raw_record_data should be like:-
    //
    //      $raw_record_data = array(
    //          'field_name_1'  =>  <field_value_1>     ,
    //          ...
    //          'field_name_N'  =>  <field_value_N>
    //          )
    //
    // In other words, $raw_record_data must be an associative ARRAY of
    //      field name  =>  field_value
    //
    // pairs.  Where:-
    //
    // 1.   At least ONE field must be specified.
    //
    // 2.   Field values can be any of the following PHP data types:-
    //          STRING
    //          INT
    //          FLOAT
    //          TRUE    (stored as 1 in the DB)
    //          FALSE   (stored as 0 in the DB)
    //          NULL    (stored as NULL in the DB)
    //
    //      PHP ARRAY and OBJECT type fields aren't allowed (and
    //      will cause an error-message return)
    //
    // 3.   You DON'T have to supply INT and FLOAT values as PHP
    //      INTs or FLOATS.  They can be supplied as PHP STRINGS
    //      (eg; from $_GET and/or $_POST).  And MySQL will
    //      automatically convert them (before storing them).
    //
    //      NOTE!
    //      -----
    //      Every value that "update_records()" supplies to MySQL will
    //      be supplied in STRING format.  So putting (eg):-
    //          $_GET['id']
    //
    //      into $raw_record_data like:-
    //          $raw_record_data['id'] = (int) $_GET['id']
    //
    //      is pointless.  Since "add_record()" will simply do:-
    //          (string) $raw_record_data['id']
    //
    //      to it before supplying it to MySQL.
    //
    // 4.   The field values MUST NOT be SQL escaped.  You MUST supply
    //      the RAW input data (even the raw $_GET and $_POST data
    //      entered by the user).  And "add_record()" will escape it
    //      for you.
    //
    // NOTE!
    // =====
    // $raw_record_data DOESN'T have to include ALL the fields in the record.
    // Only those whoose value you want to update (= set/change).
    //
    // ---
    //
    // $where is like (eg):-
    //
    //      $where = array(
    //                  'this'  =>  "xxx"
    //                  'that'  =>  Y
    //                  )
    //
    // Multiple where conditions are joined by AND.
    //
    // ---
    //
    // RETURNS either:-
    //      o   INT $number_records_updated on SUCCESS
    //      o   An error message STRING on FAILURE
    // -------------------------------------------------------------------------

    // =========================================================================
    // If there's NO record data, then there's NOTHING to do...
    // =========================================================================

    if ( ! is_array( $raw_record_data ) ) {

        $msg = <<<EOT
UPDATE RECORDS failure ("raw_record_data" must be
an associative ARRAY of NAME=VALUE pairs).
EOT;

        return handle_error(
                    __FUNCTION__    ,
                    __LINE__        ,
                    ''              ,
                    $msg
                    ) ;

    }

    // -------------------------------------------------------------------------

    if ( count( $raw_record_data ) < 1 ) {

        $msg = <<<EOT
UPDATE RECORDS failure (record has NO FIELDS)
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

    }

    // -------------------------------------------------------------------------
    // $wpdb->update(
    //      $table                  ,
    //      $data                   ,
    //      $where                  ,
    //      $data_format = null     ,
    //      $where_formats = null
    //      )
    // - - - - - - - - - - - - - - -
    // Update a row in the table.  Returns FALSE if errors, or the number of
    // rows affected if successful.
    //
    //      table
    //          (string) The name of the table to update.
    //
    //      data
    //          (array) Data to update (in column => value pairs).  Both $data
    //          columns and $data values should be "raw" (neither should be
    //          SQL escaped).
    //
    //      where
    //          (array) A named array of WHERE clauses (in column => value
    //          pairs).  Multiple clauses will be joined with ANDs.  Both
    //          $where columns and $where values should be "raw".
    //
    //      data_format
    //          (array|string) (optional) An array of formats to be mapped
    //          to each of the values in $data.  If string, that format will
    //          be used for all of the values in $data.
    //
    //      where_format
    //          (array|string) (optional) An array of formats to be mapped
    //          to each of the values in $where.  If string, that format
    //          will be used for all of the items in $where.
    //
    // Possible format values: %s as string; %d as decimal number and %f as
    // float.  If omitted, all values in $where will be treated as strings.
    //
    // This function returns the number of rows updated, or FALSE if there is
    // an error.
    //
    // EXAMPLE
    // - - - -
    // Update a row, where the ID is 1, the value in the first column is a
    // string and the value in the second column is a number:
    //
    //      $wpdb->update(
    //          'table',
    //          array(
    //              'column1' => 'value1',  // string
    //              'column2' => 'value2'   // integer (number)
    //          ),
    //          array( 'ID' => 1 ),
    //          array(
    //              '%s',   // value1
    //              '%d'    // value2
    //          ),
    //          array( '%d' )
    //          );
    //
    // Attention: %d can't deal with comma values - if you're not using full
    // numbers, use string/%s.
    // -------------------------------------------------------------------------

    global $wpdb ;

    // -------------------------------------------------------------------------

    $table_name = $wpdb->escape( $table_name ) ;
                    //  Just being ultra-cautious

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // The $wpdb->update() function expects you to tell it whether a given
    // field has a STRING or a NUMERIC value.
    //
    // But this is complicated and tedious - and something we'd like to
    // avoid.
    //
    // ---
    //
    // Fortunately, MySQL comes to our rescue here.  Because it allows you
    // (and in fact encourages you,) to put quotes around numeric values as
    // well as strings.  Ie, from:-
    //
    //      "Client Programming Security Guidelines"
    //      http://dev.mysql.com/doc/refman/5.6/en/secure-client-programming.html
    //
    // we have:-
    //
    //      "A common mistake is to protect only string data values.  Remember
    //      to check numeric data as well.  If an application generates a
    //      query such as:-
    //          SELECT * FROM table WHERE ID=234
    //
    //      when a user enters the value 234, the user can enter the value:-
    //          234 OR 1=1
    //
    //      to cause the application to generate the query:-
    //          SELECT * FROM table WHERE ID=234 OR 1=1
    //
    //      As a result, the server retrieves every row in the table.  This
    //      exposes every row and causes excessive server load.  The simplest
    //      way to protect from this type of attack is to use single quotation
    //      marks around the numeric constants:-
    //          SELECT * FROM table WHERE ID='234'
    //
    //      If the user enters extra information, it all becomes part of the
    //      string.  In a numeric context, MySQL automatically converts this
    //      string to a number and strips any trailing nonnumeric characters
    //      from it."
    // -------------------------------------------------------------------------

    // =========================================================================
    // Convert all data to strings - and generate the:-
    //      $wpdb->update()
    //
    // required $data_formats array...
    // =========================================================================

    $data_formats = array() ;

    // -------------------------------------------------------------------------

    foreach ( $raw_record_data as $field_name => $field_value ) {

        // -------------------------------------------------------------------------
        // mysqlise_the_field_value(
        //      $table_name     ,
        //      $field_name     ,
        //      $field_value    ,
        //      $add_update
        //      )
        // - - - - - - - - - - - - -
        // Converts:-
        //      NULL  => 'NULL'
        //      TRUE  => '1'
        //      FALSE => '0'
        //      ...etc...
        //
        // RETURNS:-
        //      o   $mysqlised_field_value on SUCCESS
        //      o   array( $error_message_string ) on FALIURE
        // -------------------------------------------------------------------------

        $field_value = mysqlise_the_field_value(
                            $table_name     ,
                            $field_name     ,
                            $field_value    ,
                            'update'
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {

            return handle_error(
                        __FUNCTION__        ,
                        __LINE__            ,
                        ''                  ,
                        $field_value[0]
                        ) ;

        }

        // ---------------------------------------------------------------------

        $raw_record_data[ $field_name ] = $field_value ;

        // ---------------------------------------------------------------------

        $data_formats[] = '%s' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Convert the:-
    //      $where
    // values to STRINGS.  And generate the:-
    //      $where_formats
    // array...
    // =========================================================================

    $where_formats = array() ;

    // -------------------------------------------------------------------------

    foreach ( $where as $field_name => $field_value ) {

        // -------------------------------------------------------------------------
        // mysqlise_the_field_value(
        //      $table_name     ,
        //      $field_name     ,
        //      $field_value    ,
        //      $add_update
        //      )
        // - - - - - - - - - - - - -
        // Converts:-
        //      NULL  => 'NULL'
        //      TRUE  => '1'
        //      FALSE => '0'
        //      ...etc...
        //
        // RETURNS:-
        //      o   $mysqlised_field_value on SUCCESS
        //      o   array( $error_message_string ) on FALIURE
        // -------------------------------------------------------------------------

        $field_value = mysqlise_the_field_value(
                            $table_name     ,
                            $field_name     ,
                            $field_value    ,
                            'update'
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $field_value ) ) {

            return handle_error(
                        __FUNCTION__        ,
                        __LINE__            ,
                        ''                  ,
                        $field_value[0]
                        ) ;

        }

        // ---------------------------------------------------------------------

        $where[ $field_name ] = $field_value ;

        // ---------------------------------------------------------------------

        $where_formats[] = '%s' ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Perform the UPDATE proper...
    // =========================================================================

    $number_records_updated = $wpdb->update(
                                    $table_name         ,
                                    $raw_record_data    ,
                                    $where              ,
                                    $data_formats       ,
                                    $where_formats
                                    ) ;

    // -------------------------------------------------------------------------

    if ( $number_records_updated === FALSE ) {

        $msg = <<<EOT
Database UPDATE failure
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

    }

    // =========================================================================
    // SUCCESS
    // =========================================================================

    return $number_records_updated ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// mysqlise_the_field_value()
// =============================================================================

function mysqlise_the_field_value(
    $table_name     ,
    $field_name     ,
    $field_value    ,
    $add_update
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\mysqlise_the_field_value(
    //      $table_name     ,
    //      $field_name     ,
    //      $field_value    ,
    //      $add_update
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Converts:-
    //      NULL  => 'NULL'
    //      TRUE  => '1'
    //      FALSE => '0'
    //      ...etc...
    //
    // RETURNS:-
    //      o   $mysqlised_field_value on SUCCESS
    //      o   array( $error_message_string ) on FALIURE
    // -------------------------------------------------------------------------

    if ( $field_value === NULL ) {

        return 'NULL' ;

    // -------------------------------------------------------------------------

    } elseif ( $field_value === TRUE ) {

        return '1' ;

    // -------------------------------------------------------------------------

    } elseif ( $field_value === FALSE ) {

        return '0' ;

    // -------------------------------------------------------------------------

    } elseif ( is_array( $field_value ) ) {

        // ---------------------------------------------------------------------

        $msg = <<<EOT
BAD FIELD VALUE (ARRAY type field values NOT allowed)
EOT;

        return array( $msg ) ;

    // -------------------------------------------------------------------------

    } elseif ( is_object( $field_value ) ) {

        // ---------------------------------------------------------------------

            $msg = <<<EOT
BAD FIELD VALUE (OBJECT type field values not allowed)
EOT;

        return array( $msg ) ;

    // -------------------------------------------------------------------------

    } elseif ( ! is_string( $field_value ) ) {

        return (string) $field_value ;

    }

    // -------------------------------------------------------------------------

    return $field_value ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// delete_records()
// =============================================================================

function delete_records(
    $table_name             ,
    $where                  ,
    $where_formats = NULL
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\delete_records(
    //      $table_name             ,
    //      $where                  ,
    //      $where_formats = NULL
    //      )
    // - - - - - - - - - - - - - - - -
    // Deletes the specified records.
    //
    //      $where
    //          An ARRAY if field NAME=VALUE pairs.  The resulting database
    //          query will delete the records where all the names EQUAL all
    //          the values.
    //
    //          Both the NAMEs and VALUEs must be "raw" (not yet SQL-escaped).
    //
    //          Multiple clauses will be joined with AND.
    //
    //      $where_formats
    //          (string/array) (optional) An array of formats to be mapped to
    //          each of the values in $where.
    //
    //          If a string, that format will be used for all of the items in
    //          $where.
    //
    //          A format is one of '%d' or '%s' (integer, string; see below for
    //          more information).
    //
    //          If omitted, all values in $where will be treated as strings
    //          unless otherwise specified in wpdb::$field_types.
    //
    //          Default: null
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      INT $number_records_deleted
    //
    //      On FAILURE
    //      - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // DELETE Rows
    // ===========
    // The delete function was added in WordPress 3.4.0, and can be used to
    // delete rows from a table. The usage is very similar to update and insert.
    // It returns the number of rows updated, or false on error.
    //
    // Usage
    //      $wpdb->delete( $table , $where , $where_formats = null ) ;
    //
    //      $table
    //          (string) (required) Table name.
    //
    //          Default: None
    //
    //      $where
    //          (array) (required) Table name. A named array of WHERE clauses
    //          (in column -> value pairs). Multiple clauses will be joined with
    //          ANDs. Both $where columns and $where values should be 'raw'.
    //
    //          Default: None
    //
    //      $where_formats
    //          (string/array) (optional) An array of formats to be mapped to
    //          each of the values in $where. If a string, that format will be
    //          used for all of the items in $where. A format is one of '%d',
    //          '%f', '%s' (integer, float, string; see below for more
    //          information). If omitted, all values in $where will be treated
    //          as strings unless otherwise specified in wpdb::$field_types.
    //
    //          Default: null
    //
    // EXAMPLES
    //
    //      Default usage.
    //          $wpdb->delete( 'table', array( 'ID' => 1 ) );
    //
    //      Using where formatting.
    //          $wpdb->delete( 'table', array( 'ID' => 1 ), array( '%d' ) );
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // bool method_exists ( mixed $object , string $method_name )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Checks if the class method exists in the given object.
    //
    //      object
    //          An object instance or a class name
    //
    //      method_name
    //          The method name
    //
    // Returns TRUE if the method given by method_name has been defined for the
    // given object, FALSE otherwise.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Processing is WordPress version dependent...
    // =========================================================================

    global $wpdb ;

    // -------------------------------------------------------------------------

    if ( method_exists( $wpdb , 'delete' ) ) {

        // ---------------------------------------------------------------------
        // WordPress 3.4+
        // ---------------------------------------------------------------------

        $number_rows_deleted = $wpdb->delete(
                                    $table_name     ,
                                    $where          ,
                                    $where_formats
                                    ) ;

        // ---------------------------------------------------------------------

        if ( $number_records_deleted === FALSE ) {

            $msg = <<<EOT
Database RECORD DELETION failure
EOT;

            return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

        }

        // ---------------------------------------------------------------------

        return $number_records_deleted ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Before WordPress 3.4
    // =========================================================================

    $where_str = '' ;
    $where_values = array() ;

    $comma = '' ;
    $index = 0 ;

    // -------------------------------------------------------------------------

    foreach ( $where as $name => $value ) {

        $type = $where_formats[ $index ] ;

        if ( $type === '%d' ) {
            $where_str .= $comma . $name . ' = ' . $type ;

        } elseif ( $type === '%s' ) {
            $where_str .= $comma . $name . ' = \'' . $type . '\'' ;

        } else {

            $msg = <<<EOT
Unrecognised/unsupported "where_format" type (only "%s" and "%d" are allowed)
EOT;

            return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

        }

        $where_values[] = $value ;

        $comma = ' AND ' ;

        $index++ ;

    }

    // -------------------------------------------------------------------------

    $sql = <<<EOT
DELETE FROM {$table_name} WHERE {$where_str}
EOT;

    // -------------------------------------------------------------------------

    $number_records_affected = $wpdb->query(
                                    $wpdb->prepare(
                                        $where_str      ,
                                        $where_values
                                        )
                                    ) ;
                                    //  The function returns an integer
                                    //  corresponding to the number of rows
                                    //  affected/selected. If there is a MySQL
                                    //  error, the function will return FALSE.

    // -------------------------------------------------------------------------

    if ( $number_records_deleted === FALSE ) {

        $msg = <<<EOT
Database RECORD DELETION failure
EOT;

        return handle_error(
                    __FUNCTION__    ,
                    __LINE__        ,
                    ''              ,
                    $msg
                    ) ;

    }

    // -------------------------------------------------------------------------

    return $number_records_deleted ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// delete_exactly_one_record()
// =============================================================================

function delete_exactly_one_record(
    $table_name             ,
    $where                  ,
    $where_formats = NULL
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\delete_exactly_one_record(
    //      $table_name             ,
    //      $where                  ,
    //      $where_formats = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - -
    // Deletes the specified record.
    //
    //      $where
    //          An ARRAY if field NAME=VALUE pairs.  The resulting database
    //          query will delete the records where all the names EQUAL all
    //          the values.
    //
    //          Both the NAMEs and VALUEs must be "raw" (not yet SQL-escaped).
    //
    //          Multiple clauses will be joined with AND.
    //
    //      $where_formats
    //          (string/array) (optional) An array of formats to be mapped to
    //          each of the values in $where.
    //
    //          If a string, that format will be used for all of the items in
    //          $where.
    //
    //          A format is one of '%d' or '%s' (integer, string; see below for
    //          more information).
    //
    //          If omitted, all values in $where will be treated as strings
    //          unless otherwise specified in wpdb::$field_types.
    //
    //          Default: null
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      TRUE
    //
    //      On FAILURE
    //      - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $number_records_deleted = delete_records(
                                    $table_name     ,
                                    $where          ,
                                    $where_formats
                                    ) ;
                                    // RETURNS
                                    //      On SUCCESS
                                    //      - - - - -
                                    //      INT $number_records_deleted
                                    //
                                    //      On FAILURE
                                    //      - - - - -
                                    //      $error_message STRING

    // -------------------------------------------------------------------------

    if ( is_string( $number_records_deleted ) ) {
        return $number_records_deleted ;
            //  "delete_records()" has already called "handle_error()"
    }

    // -------------------------------------------------------------------------

    if ( $number_records_deleted === 1 ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    if ( $number_records_deleted < 1 ) {

        $msg = <<<EOT
PROBLEM: Database RECORD DELETION failure
The requested record was either not found,
or couldn't be deleted (for some reason).
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        $sql            ,
                        $msg
                        ) ;
    }

    // -------------------------------------------------------------------------

    $msg = <<<EOT
PROBLEM: Database RECORD DELETION failure
We expected to delete just the ONE record.
But in fact {$number_records_deleted} records were deleted.
EOT;

    return handle_error(
                    __FUNCTION__    ,
                    __LINE__        ,
                    $sql            ,
                    $msg
                    ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// delete_exactly_one_record_by_id()
// =============================================================================

function delete_exactly_one_record_by_id(
    $table_name             ,
    $record_id              ,
    $id_field_name = 'id'
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\delete_exactly_one_record_by_id(
    //      $table_name             ,
    //      $record_id              ,
    //      $id_field_name = 'id'
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Deletes the specified record.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      TRUE
    //
    //      On FAILURE
    //      - - - - -
    //      $error_message STRING
    // -------------------------------------------------------------------------

    $where = array(
                $id_field_name  =>  $record_id
                ) ;

    // -------------------------------------------------------------------------

    if ( is_int( $record_id ) ) {
        $where_formats = array( '%d' ) ;

    } else {
        $where_formats = array( '%s' ) ;

    }

    // -------------------------------------------------------------------------

    return delete_exactly_one_record(
                $table_name     ,
                $where          ,
                $where_formats
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// tabledef()
// =============================================================================

function tabledef(
    $table_name
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\tabledef(
    //      $table_name
    //      )
    // - - - - - - - - - - - - -
    // Returns the specified table's definition - in a format that can be
    // copied and pasted into a text file (for documentation purposes).
    //
    // Unless an error occurs, in which case an error message will be returned.
    //
    // Requires that the "pr_text()" function be available.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Get the table's field details (from MySQL)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \basepress_mysql\get_zero_or_more_records(
    //      $sql
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // NOTE!  The INPUT $sql should NOT be escaped.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      The 0+ records specified by the SQL string (as a PHP numeric
    //      array of records).  Eg:-
    //
    //          $records = array(
    //              0   =>  array(
    //                          'field_name_1'  =>  <field_value_1>     ,
    //                          'field_name_2'  =>  <field_value_2>     ,
    //                          ...                 ...
    //                          'field_name_N'  =>  <field_value_N>
    //                          )
    //              ...
    //              )
    //
    //      On FAILURE
    //      - - - - -
    //      An error message STRING.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // SHOW [FULL] COLUMNS {FROM | IN} tbl_name [{FROM | IN} db_name]
    //      [LIKE 'pattern' | WHERE expr]
    // -------------------------------------------------------------------------

    $sql = <<<EOT
SHOW FULL COLUMNS FROM {$table_name}
EOT;

    // -------------------------------------------------------------------------

    $tabledef = get_zero_or_more_records( $sql ) ;

    // -------------------------------------------------------------------------

    if ( ! is_array( $tabledef ) ) {

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $tabledef
                        ) ;

    }

//pr( $tabledef ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $tabledef = array(
    //
    //          [0] => Array(
    //                      [Field]         => option_id
    //                      [Type]          => bigint(20) unsigned
    //                      [Collation]     =>
    //                      [Null]          => NO
    //                      [Key]           => PRI
    //                      [Default]       =>
    //                      [Extra]         => auto_increment
    //                      [Privileges]    => select,insert,update,references
    //                      [Comment]       =>
    //                      )
    //
    //          [1] => Array(
    //                      [Field]         => option_name
    //                      [Type]          => varchar(64)
    //                      [Collation]     => utf8_general_ci
    //                      [Null]          => NO
    //                      [Key]           => UNI
    //                      [Default]       =>
    //                      [Extra]         =>
    //                      [Privileges]    => select,insert,update,references
    //                      [Comment]       =>
    //                      )
    //
    //          [2] => Array(
    //                      [Field]         => option_value
    //                      [Type]          => longtext
    //                      [Collation]     => utf8_general_ci
    //                      [Null]          => NO
    //                      [Key]           =>
    //                      [Default]       =>
    //                      [Extra]         =>
    //                      [Privileges]    => select,insert,update,references
    //                      [Comment]       =>
    //                      )
    //
    //          [3] => Array(
    //                      [Field]         => autoload
    //                      [Type]          => varchar(20)
    //                      [Collation]     => utf8_general_ci
    //                      [Null]          => NO
    //                      [Key]           =>
    //                      [Default]       => yes
    //                      [Extra]         =>
    //                      [Privileges]    => select,insert,update,references
    //                      [Comment]       =>
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Display the table's fields in a text table...
    // =========================================================================

    $fields_to_show = array() ;

    foreach ( $tabledef as $this_field ) {
        $fields_to_show[ $this_field['Field'] ] = $this_field['Type'] ;
    }

    // -------------------------------------------------------------------------

//    require_once( XXX_INCLUDES_DIR . '/webwiz_test_debug.php' ) ;

    // -------------------------------------------------------------------------

    if ( ! function_exists( 'pr_text' ) ) {

        $msg = <<<EOT
PROBLEM displaying table schema ("pr_text()" function not found)
EOT;

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $msg
                        ) ;

    }

    // -------------------------------------------------------------------------

    return '<pre>' . pr_text( $fields_to_show , $table_name ) . '</pre>' ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// table_exists()
// =============================================================================

function table_exists(
    $table_name
    ) {

    // -------------------------------------------------------------------------
    // \basepress_mysql\table_exists(
    //      $table_name
    //      )
    // - - - - - - - - - - - - - - -
    // RETURNS TRUE or FALSE, depending on whether the table exists or not.
    //
    // NOTE!
    // -----
    // $table_name is an ABSOLUTE table name - with the WordPress table
    // prefix prepended if necessary.
    //
    // Call:-
    //
    //      table_exists(
    //          prepend_wordpress_table_name_prefix( $table_name )
    //          )
    //
    // if you want to supply the table name WITHOUT the WordPress table prefix
    // (and have that prefix automatically prepended for you).
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \basepress_mysql\get_zero_or_more_records(
    //      $sql
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // NOTE!  The INPUT $sql should NOT be escaped.
    //
    // RETURNS
    //      On SUCCESS
    //      - - - - -
    //      The 0+ records specified by the SQL string (as a PHP numeric
    //      array of records).  Eg:-
    //
    //          $records = array(
    //              0   =>  array(
    //                          'field_name_1'  =>  <field_value_1>     ,
    //                          'field_name_2'  =>  <field_value_2>     ,
    //                          ...                 ...
    //                          'field_name_N'  =>  <field_value_N>
    //                          )
    //              ...
    //              )
    //
    //      On FAILURE
    //      - - - - -
    //      An error message STRING.
    // -------------------------------------------------------------------------

    $sql = <<<EOT
SHOW TABLES LIKE '{$table_name}'
EOT;

    // -------------------------------------------------------------------------

    $tables = get_zero_or_more_records( $sql ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $tables ) ) {

        return handle_error(
                        __FUNCTION__    ,
                        __LINE__        ,
                        ''              ,
                        $tables
                        ) ;

    }

    // -------------------------------------------------------------------------

    if ( count( $tables ) > 0 ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    return FALSE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// generic_query()
// =============================================================================

// -----------------------------------------------------------------------------
// NOTE!
// =====
// There is NO BasePress MySQL function to support generic queries.  Instead,
// you should manually craft the query concerned using:-
//
//      o   $wpdb->prepare() and;
//      o   $wpdb->query()
//
// See:-
//      http://codex.wordpress.org/Class_Reference/wpdb
//
// (and the relevent sections of that page copy/pasted below)...
// -----------------------------------------------------------------------------

    // -----------------------------------------------------------------------------
    // RUN ANY QUERY ON THE DATABASE
    // With or without SQL escaping)
    // =============================
    // The query function allows you to execute any SQL query on the WordPress
    // database. It is best to use a more specific function (see below), however,
    // for SELECT queries.
    //
    //      $wpdb->query('query') ;
    //
    //      query
    //          (string) The SQL query you wish to execute.
    //
    // The function returns an integer corresponding to the number of rows
    // affected/selected. If there is a MySQL error, the function will return
    // FALSE. (Note: since both 0 and FALSE can be returned, make sure you use
    // the correct comparison operator: equality == vs. identicality ===).
    //
    // Note:    As with all functions in this class that execute SQL queries,
    //          you must SQL escape all inputs (e.g.,
    //          esc_sql($user_entered_data_string) or $wpdb->prepare( 'query' ,
    //          value_parameter[, value_parameter ... ] );). See the section
    //          entitled Protect Queries Against SQL Injection Attacks below.
    //
    // EXAMPLES
    //
    //      o   Delete the 'gargle' meta key and value from Post 13. (We'll add
    //          the 'prepare' method to make sure we're not dealing with an
    //          illegal operation or any illegal characters):
    //
    //              $wpdb->query(
    //                  $wpdb->prepare(
    //                      "
    //                      DELETE FROM $wpdb->postmeta
    //                      WHERE post_id = %d
    //                      AND meta_key = %s
    //                      ",
    //                      13, 'gargle'
    //                      )
    //                  ) ;
    //
    //      o   Set the parent of Page 15 to Page 7.
    //          (NOTE! Uses NO SQL ESCAPING!)
    //
    //              $wpdb->query(
    //                  "
    //                  UPDATE $wpdb->posts
    //                  SET post_parent = 7
    //                  WHERE ID = 15
    //                  AND post_status = 'static'
    //                  "
    //                  ) ;
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // PROTECT QUERIES AGAINST SQL INJECTION ATTACKS
    // =============================================
    // For a more complete overview of SQL escaping in WordPress, see database
    // Data Validation. That Data Validation article is a must-read for all
    // WordPress code contributors and plugin authors.
    //
    // Briefly, though, all data in SQL queries must be SQL-escaped before the
    // SQL query is executed to prevent against SQL injection attacks. This can
    // be conveniently done with the prepare method, which supports both a
    // sprintf()-like and vsprintf()-like syntax.
    //
    // Please note: As of 3.5, wpdb::prepare() enforces a minimum of 2
    // arguments. [more info]
    //
    // ________________
    // $WPDB->PREPARE()
    //
    //      $sql = $wpdb->prepare( 'query' , value_parameter[, value_parameter ... ] ) ;
    //
    //      query
    //          (string) The SQL query you wish to execute, with placeholders
    //          (see below).
    //
    //      value_parameter
    //          (int|string|array) The value to substitute into the placeholder.
    //          Many values may be passed by simply passing more arguments in a
    //          sprintf()-like fashion. Alternatively the second argument can be
    //          an array containing the values as in PHP's vsprintf() function.
    //          Care must be taken not to allow direct user input to this
    //          parameter, which would enable array manipulation of any query
    //          with multiple placeholders. Values must not already be
    //          SQL-escaped.
    //
    // PLACEHOLDERS
    //
    // The query parameter for prepare accepts sprintf()-like placeholders. The
    // %s (string), %d (integer) and %f (float) formats are supported. (The %s
    // and %d placeholders have been available since the function was added to
    // core in Version 2.3, %f has only been available since Version 3.3.) Any
    // other % characters may cause parsing errors unless they are escaped. All
    // % characters inside SQL string literals, including LIKE wildcards, must
    // be double-% escaped as %%. All of %d, %f, and %s are to be left unquoted
    // in the query string. Note that the %d placeholder only accepts integers,
    // so you can't pass numbers that have comma values via %d. If you need
    // comma values, use %s instead.
    //
    // EXAMPLES
    //
    //      o   Add Meta key => value pair "Harriet's Adages" => "WordPress'
    //          database interface is like Sunday Morning: Easy." to Post 10.
    //
    //              $metakey    = "Harriet's Adages";
    //              $metavalue  = "WordPress' database interface is like Sunday Morning: Easy.";
    //
    //              $wpdb->query( $wpdb->prepare(
    //                  "
    //                      INSERT INTO $wpdb->postmeta
    //                      ( post_id, meta_key, meta_value )
    //                      VALUES ( %d, %s, %s )
    //                  ",
    //                      10,
    //                  $metakey,
    //                  $metavalue
    //              ) );
    //
    //      o   The same query using vsprintf()-like syntax.
    //
    //              $metakey = "Harriet's Adages";
    //              $metavalue = "WordPress' database interface is like Sunday Morning: Easy.";
    //
    //              $wpdb->query( $wpdb->prepare(
    //                  "
    //                      INSERT INTO $wpdb->postmeta
    //                      ( post_id, meta_key, meta_value )
    //                      VALUES ( %d, %s, %s )
    //                  ",
    //                      array(
    //                      10,
    //                      $metakey,
    //                      $metavalue
    //                  )
    //              ) );
    //
    //          Note that in this example we pack the values together in an
    //          array. This can be useful when we don't know the number of
    //          arguments we need to pass until runtime.
    //
    // Notice that you do not have to worry about quoting strings. Instead of
    // passing the variables directly into the SQL query, use a %s placeholder
    // for strings, a %d placedolder for integers, and a %f as a placeholder for
    // floats. You can pass as many values as you like, each as a new parameter
    // in the prepare() method.
    // -------------------------------------------------------------------------

// =============================================================================
// That's that!
// =============================================================================

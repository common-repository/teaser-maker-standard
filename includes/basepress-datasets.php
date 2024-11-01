<?php

// *****************************************************************************
// BASEPRESS / BASEPRESS_DATASETS.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressDatasets ;

// =============================================================================
// is_valid_handle_string()
// =============================================================================

function is_valid_handle_string(
    $name       ,
    $value
    ) {

    // -------------------------------------------------------------------------
    // RETURNS:-
    //      o   TRUE on SUCCESS
    //      o   $error_message STRING on FAILURE
    // -------------------------------------------------------------------------

    if (    ! is_string( $value )
            ||
            strlen( $value ) < 1
            ||
            strlen( $value ) > 255
            ||
            ctype_space( $value )
            ||
            ctype_cntrl( $value )
        ) {

        return <<<EOT
PROBLEM: Invalid BasePress dataset handle value!
"{$name}" must be a 1 to 256 character STRING
(that contains NO white-space or control characters)
EOT;

    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// is_valid_handle()
// =============================================================================

function is_valid_handle(
    $basepress_dataset_handle
    ) {

    // -------------------------------------------------------------------------
    // RETURNS:-
    //      o   TRUE on SUCCESS
    //      o   $error_message STRING on FAILURE
    // -------------------------------------------------------------------------

    if (    ! is_array( $basepress_dataset_handle )
            ||
            count( $basepress_dataset_handle ) !== 3
            ||
            ! array_key_exists( 'nice_name' , $basepress_dataset_handle )
            ||
            ! array_key_exists( 'unique_key' , $basepress_dataset_handle )
            ||
            ! array_key_exists( 'version' , $basepress_dataset_handle )
        ) {

        return <<<EOT
PROBLEM: Invalid BasePress dataset handle!
A BasePress dataset handle must be a 3 element ARRAY
with members; "nice_name", "unique_key" and "version".
EOT;

    }

    // --------------------------------------------------------------------

    foreach ( $basepress_dataset_handle as $name => $value ) {

        // ---------------------------------------------------------------------

        $result = is_valid_handle_string( $name , $value ) ;

        // ---------------------------------------------------------------------

        if ( $result !== TRUE ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_table_name()
// =============================================================================

function get_table_name() {

    return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\prepend_wordpress_table_name_prefix(
                'basepress_datasets'
                ) ;

}

// =============================================================================
// load()
// =============================================================================

function load(
    $basepress_dataset_handle
    ) {

    // -------------------------------------------------------------------------
    // \basepress_datasets\load(
    //      $basepress_dataset_handle
    //      )
    // - - - - - - - - - - - -
    // Returns the specified dataset (as a PHP array).  Unless an error occurs
    // while retrieving it (from the WordPress MySQL database), in which case
    // an error message string is returned.
    //
    // $basepress_dataset_handle is like (eg):-
    //
    //      $basepress_dataset_handle = array(
    //          'nice_name'     =>  "xxx"
    //          'unique_key'    =>  "xxx"
    //          'version'       =>  "xxx"
    //          ) ;
    //
    // Where:-
    //
    //      o   $nice_name
    //              is a max 255 character string that gives a friendly but
    //              hopefully still unique name to the dataset.  Usually,
    //              datasets will be owned by plugins or themes.  So the
    //              $nice_name will be that of the plugin or them.  But
    //              possibly with some extra words to identify the author
    //              (whether an individual or a business) - and anything else
    //              that might help to uniquely identify the dataset.
    //
    //              For example:-
    //                  "wordpress-post-search-and-replace-by-cocktail-systems"
    //
    //              The intention with this name, is to create something that
    //              no other dataset - created by another plugin or theme - is
    //              likely to duplicate.
    //
    //      o   $unique_key
    //              is a max 255 character string that gives a genuinely random
    //              and thereby almost certainly unique name to the dataset.
    //
    //              For example:-
    //                  "85adfc5b-f268-441a-8aa8-40913d816b49-48bfb6c4-d951"
    //
    //              In other words, it's something that the online password and
    //              GUID/UUID generators can easily generate for you.  To
    //              maximise the chances of uniqueness, you can easily string
    //              multiple such passwords/GUIDs together - up to the 255
    //              character limit.
    //
    //              The idea with the $unique_key is simply to decrease the
    //              chances that some other plugin or theme author will
    //              (accidentally) duplicate BOTH the $nice_name and the
    //              $unique_key that you selected.
    //
    //      o   $version
    //              is a max 255 character string that you can use to assign
    //              a version number to your dataset.  Obviously, as you
    //              release new/updated versions of your plugin or theme,
    //              while some might use exactly the same dataset as previous
    //              versions, others may not.
    //
    //              So $version allows you to differentiate between the
    //              different versions you might create.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY( $record_id , $data )
    //
    //          Where:-
    //          o   $record_id is either:-
    //              --  The record ID of the "basepress_datasets" table
    //                  record (that holds the requested dataset's data), or;
    //
    //              --  NULL if either the "basePress_datasets" table - or the
    //                  specified dataset record - doesn't exist yet).
    //
    //          o   $data is a (possibly empty) PHP associative ARRAY of
    //              name=value pairs.
    //
    //      o   On FAILURE
    //          - - - - -
    //          An error message STRING.
    // -------------------------------------------------------------------------

    // =========================================================================
    // ERROR CHECKING
    // =========================================================================

    $result = is_valid_handle( $basepress_dataset_handle ) ;
                    // RETURNS:-
                    //      o   TRUE on SUCCESS
                    //      o   $error_message STRING on FAILURE

    // -------------------------------------------------------------------------

    if ( $result !== TRUE ) {
        return $result ;
    }

    // =========================================================================
    // Support Routines
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/basepress-mysql.php' ) ;

    // =========================================================================
    // Does the WordPress database contain a "basepress_datasets" table?
    //
    // If not, return the empty array (the table will be created if/when you
    // SAVE the dataset).
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists(
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

    $table_name = get_table_name() ;

    // -------------------------------------------------------------------------

    if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists( $table_name  ) ) {

        // ---------------------------------------------------------------------

        return array( NULL , array() ) ;        //  Table doesn't exist

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Retrieve the handle's record...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // Here we should have:-
    //
    //      $basepress_dataset_handle = array(
    //          'nice_name'     =>  "xxx"
    //          'unique_key'    =>  "xxx"
    //          'version'       =>  "xxx"
    //          ) ;
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The "basepress_datasets" record structure is:-
    //
    //      id              :   INT
    //
    //      nice_name       :   TINYTEXT (max. 256 character STRING)
    //
    //      unique_key      :   TINYTEXT (max. 256 character STRING)
    //
    //      version         :   TINYTEXT (max. 256 character STRING)
    //
    //      data            :   LONGTEXT (max. 2**32 = 4,294,967,296 character
    //                          STRING)
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records(
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

    $sql = <<<EOT
SELECT id , data
FROM {$table_name}
WHERE nice_name  = '{$basepress_dataset_handle['nice_name']}'
  AND unique_key = '{$basepress_dataset_handle['unique_key']}'
  AND version    = '{$basepress_dataset_handle['version']}'
EOT;

    // -------------------------------------------------------------------------

    $records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records( $sql ) ;

    // -------------------------------------------------------------------------

    if ( $records === FALSE ) {
        return $records ;
    }

    // -------------------------------------------------------------------------

    if ( count( $records ) < 1 ) {
        return array( NULL , array() ) ;        //  Record doesn't exist
    }

    // -------------------------------------------------------------------------

    $count = count( $records ) ;

    // -------------------------------------------------------------------------

    if ( count( $records ) > 1 ) {

        return <<<EOT
PROBLEM: Bad BasePress dataset!
The specified BasePress dataset handle appears to own {$count} dataset
records ???  (It should own zero or one such records.)
EOT;

    }

    // -------------------------------------------------------------------------

    $data = base64_decode( $records[0]['data'] ) ;
                //  Returns the original data or FALSE on failure.
                //  The returned data may be binary.

    // -------------------------------------------------------------------------

    if ( $data === FALSE ) {

        return <<<EOT
PROBLEM: Bad BasePress dataset data!
(couldn't base64 decode it)
EOT;

    }

    // -------------------------------------------------------------------------

    $data = unserialize( $data ) ;
                //   The converted value is returned, and can be a boolean,
                //  integer, float, string, array or object.
                //
                //  In case the passed string is not unserializeable, FALSE
                //  is returned and E_NOTICE is issued.

    // -------------------------------------------------------------------------

    if ( $data === FALSE ) {

        return <<<EOT
PROBLEM: Bad BasePress dataset data
(couldn't unserialise it)
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $data ) ) {

        return <<<EOT
PROBLEM: Bad BasePress dataset data
(not an ARRAY)
EOT;

    }

    // -------------------------------------------------------------------------

    return array(
                $records[0]['id']   ,
                $data
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// save()
// =============================================================================

function save(
    $basepress_dataset_handle   ,
    $data                       ,
    $record_id = NULL
    ) {

    // -------------------------------------------------------------------------
    // \basepress_datasets\save(
    //      $basepress_dataset_handle   ,
    //      $data                       ,
    //      $record_id = NULL
    //      )
    // - - - - - - - - - - - - - - - - -
    // Saves the supplied data to the specified dataset.
    //
    // ---
    //
    // $basepress_dataset_handle is like (eg):-
    //
    //      $basepress_dataset_handle = array(
    //          'nice_name'     =>  "xxx"
    //          'unique_key'    =>  "xxx"
    //          'version'       =>  "xxx"
    //          ) ;
    //
    // Where:-
    //
    //      o   $nice_name
    //              is a max 255 character string that gives a friendly but
    //              hopefully still unique name to the dataset.  Usually,
    //              datasets will be owned by plugins or themes.  So the
    //              $nice_name will be that of the plugin or them.  But
    //              possibly with some extra words to identify the author
    //              (whether an individual or a business) - and anything else
    //              that might help to uniquely identify the dataset.
    //
    //              For example:-
    //                  "wordpress-post-search-and-replace-by-cocktail-systems"
    //
    //              The intention with this name, is to create something that
    //              no other dataset - created by another plugin or theme - is
    //              likely to duplicate.
    //
    //      o   $unique_key
    //              is a max 255 character string that gives a genuinely random
    //              and thereby almost certainly unique name to the dataset.
    //
    //              For example:-
    //                  "85adfc5b-f268-441a-8aa8-40913d816b49-48bfb6c4-d951"
    //
    //              In other words, it's something that the online password and
    //              GUID/UUID generators can easily generate for you.  To
    //              maximise the chances of uniqueness, you can easily string
    //              multiple such passwords/GUIDs together - up to the 255
    //              character limit.
    //
    //              The idea with the $unique_key is simply to decrease the
    //              chances that some other plugin or theme author will
    //              (accidentally) duplicate BOTH the $nice_name and the
    //              $unique_key that you selected.
    //
    //      o   $version
    //              is a max 255 character string that you can use to assign
    //              a version number to your dataset.  Obviously, as you
    //              release new/updated versions of your plugin or theme,
    //              while some might use exactly the same dataset as previous
    //              versions, others may not.
    //
    //              So $version allows you to differentiate between the
    //              different versions you might create.
    //
    // ---
    //
    // $record_id can be either:-
    //
    //      o   The record ID retrieved when the dataset was originally loaded
    //          (by "\basepress_datasets\load()"), or;
    //
    //      o   NULL if either the dataset's record (and possibly the
    //          "basepress_datasets" table too,) doesn't exist.  Or the
    //          record may exist - but it's record ID isn't known.
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          INT The saved dataset's $record_id.  (Which is returned in
    //          case either the dataset didn't exist (before it was saved). Or
    //          it did exist, but it's record ID was unknown.)
    //
    //      o   On FAILURE
    //          - - - - -
    //          An error message STRING.
    // -------------------------------------------------------------------------

    // =========================================================================
    // ERROR CHECKING (1)
    // =========================================================================

    // -------------------------------------------------------------------------
    // $basepress_dataset_handle
    // -------------------------------------------------------------------------

    $result = is_valid_handle( $basepress_dataset_handle ) ;
                    // RETURNS:-
                    //      o   TRUE on SUCCESS
                    //      o   $error_message STRING on FAILURE

    // -------------------------------------------------------------------------

    if ( $result !== TRUE ) {
        return $result ;
    }

    // -------------------------------------------------------------------------
    // $record_id
    // -------------------------------------------------------------------------

    if ( $record_id !== NULL ) {

        // ---------------------------------------------------------------------

        $bad_record_id_msg = <<<EOT
PROBLEM saving BasePress dataset data
(The supplied record ID is invalid - must be NULL or 1+)
EOT;

        // ---------------------------------------------------------------------

        if ( is_int( $record_id ) ) {

            if ( $record_id < 1 ) {
                return $bad_record_id_msg ;
            }

        } elseif ( is_string( $record_id ) ) {

            $record_id = trim( $record_id ) ;

            if (    ! ctype_digit( $record_id )
                    ||
                    $record_id < 1
                    ||
                    $record_id > PHP_INT_MAX
                ) {
                return $bad_record_id_msg ;
            }

            $record_id = (int) $record_id ;
                //  Make sure that any integers 1+ in STRING format are
                //  converted to (and returned as,) INT.

        } else {
            return $bad_record_id_msg ;

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // $data
    // -------------------------------------------------------------------------

    if ( ! is_array( $data ) ) {

        return <<<EOT
PROBLEM saving BasePress dataset data
(The data to save ISN'T an ARRAY)
EOT;

    }

    // =========================================================================
    // Support Stuff...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/basepress-mysql.php' ) ;

    // -------------------------------------------------------------------------

    $table_name = get_table_name() ;

    // =========================================================================
    // Now we have to decide whether we're ADDING or UPDATING the dataset
    // record.  This of course depends on whether or not the dataset (record)
    // already/currently exists...
    // =========================================================================

    $question_database_table_just_added = FALSE ;

    // =========================================================================
    // If the "basepress_datasets" table DOESN'T exist yet, then CREATE it...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists(
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

    if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists( $table_name  ) ) {

        // =====================================================================
        // CREATE "BASEPRESS_DATASETS" TABLE
        // =====================================================================

        $sql = <<<EOT
CREATE TABLE {$table_name}
(   id                          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    created_server_time         INT UNSIGNED NULL ,
    last_modified_server_time   INT UNSIGNED NULL ,
    nice_name                   TINYTEXT NULL ,
    unique_key                  TINYTEXT NULL ,
    version                     TINYTEXT NULL ,
    data                        LONGTEXT NULL
)
EOT;

        // ---------------------------------------------------------------------

        global $wpdb ;

        // ---------------------------------------------------------------------

        $number_records_affected = $wpdb->query( $sql ) ;
                                        //  The function returns an integer
                                        //  corresponding to the number of rows
                                        //  affected/selected.  If there is a
                                        //  MySQL error, the function will
                                        //  return FALSE.

        // ---------------------------------------------------------------------

        if ( $number_records_affected === FALSE ) {

            return <<<EOT
PROBLEM: Couldn't create BasePress "datasets" table (#1)
EOT;

        }

        // ---------------------------------------------------------------------
        // On SUCCESS:-
        //      $wpdb->query()
        //
        // seems to return TRUE (ie; it returns the boolean value "1").
        // ---------------------------------------------------------------------

//pr( $number_records_affected ) ;
//echo "\n" , gettype( $number_records_affected ) , "\n" ;

        // ---------------------------------------------------------------------

        if (    gettype( $number_records_affected ) !== 'boolean'
                ||
                $number_records_affected != 1
            ) {

            return <<<EOT
PROBLEM: Couldn't create BasePress "datasets" table (#2)
EOT;

        }

        // ---------------------------------------------------------------------

        $question_database_table_just_added = TRUE ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\table_exists( $table_name  ) ) {

        return <<<EOT
PROBLEM: Couldn't create BasePress "datasets" table
EOT;

    }

    // =========================================================================
    // Check to see if the dataset record (currently) exists...
    //
    // NOTE!
    // =====
    // A 1+ $record_id suggests that the dataset existed when we previously
    // loaded it.  But this doesn't mean that it still exists now.  It may
    // have since been deleted.  And/or a 1+ $record_id may have been supplied
    // to this routine by mistake...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records(
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

    $question_dataset_exists = FALSE ;

    // -------------------------------------------------------------------------

    if ( $question_database_table_just_added === TRUE ) {

        // ---------------------------------------------------------------------

        $records = array() ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $sql = <<<EOT
SELECT id
FROM {$table_name}
WHERE nice_name  = '{$basepress_dataset_handle['nice_name']}'
  AND unique_key = '{$basepress_dataset_handle['unique_key']}'
  AND version    = '{$basepress_dataset_handle['version']}'
EOT;

        // ---------------------------------------------------------------------

        $records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records( $sql ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $records ) ) {
            return $records ;
        }

        // ---------------------------------------------------------------------

        $count = count( $records ) ;

        // ---------------------------------------------------------------------

        if ( $count === 1 ) {

            $question_dataset_exists = TRUE ;

        } elseif ( $count > 1 ) {

            return <<<EOT
PROBLEM saving BasePress dataset!
The specified BasePress dataset handle appears to own {$count} dataset
records ???  (It should own zero or one such records.)
EOT;

        }

        // ---------------------------------------------------------------------
        // Comvert the record's 'id' field to an INT.
        //
        // See Note 2 for:-
        //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\get_zero_or_more_records()
        //
        // for the reason why.
        // ---------------------------------------------------------------------

        if ( $count > 0 ) {
            $records[0]['id'] = (int) $records[0]['id'] ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Check that the $record_id supplied to this routine matches the record ID
    // obtained when deciding whether or not the dataset exists...
    // =========================================================================

    if ( ! is_null( $record_id ) ) {

        // ---------------------------------------------------------------------
        // Presumably (though not necessarily):-
        //      \basepress_datasets\load()
        //
        // was previously called - and successfully loaded the dataset.
        // ---------------------------------------------------------------------

        if ( $question_dataset_exists ) {

            // -----------------------------------------------------------------

            if ( $records[0]['id'] !== $record_id ) {

                return <<<EOT
PROBLEM saving BasePress dataset!
The previously loaded dataset record
is DIFFERENT from the current dataset
record ???
EOT;

            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            return <<<EOT
PROBLEM saving BasePress dataset!
The previously loaded dataset record
seems to have been DELETED ???
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SERIALISE and BASE 64 ENCODE the data...
    // =========================================================================

    $data = serialize( $data ) ;
                //  Returns a string containing a byte-stream representation
                //  of value that can be stored anywhere.
                //
                //  Note that this is a binary string which may include null
                //  bytes, and needs to be stored and handled as such.  For
                //  example, serialize() output should generally be stored in
                //  a BLOB field in a database, rather than a CHAR or TEXT
                //  field.

    // -------------------------------------------------------------------------

    $data = base64_encode( $data ) ;
                //  The encoded data, as a string or FALSE on failure.

    // -------------------------------------------------------------------------

    if ( $data === FALSE ) {

        return <<<EOT
PROBLEM saving BasePress dataset!
(couldn't base64 encode the data)
EOT;

    }

    // =========================================================================
    // INSERT or UPDATE the DATA...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The "basepress_datasets" record structure is:-
    //
    //      id              :   INT
    //
    //      nice_name       :   TINYTEXT (max. 256 character STRING)
    //
    //      unique_key      :   TINYTEXT (max. 256 character STRING)
    //
    //      version         :   TINYTEXT (max. 256 character STRING)
    //
    //      data            :   LONGTEXT (max. 2**32 = 4,294,967,296 character
    //                          STRING)
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\update_exactly_one_record_by_id(
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
    // 3.   You DON'T have to supply INI and FLOAT values as PHP
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

    if ( $question_dataset_exists ) {

        // ---------------------------------------------------------------------
        // UPDATE Existing Record
        // ---------------------------------------------------------------------

        $raw_record_data = array(
            'last_modified_server_time' =>  time()      ,
            'data'                      =>  $data
            ) ;

        // ---------------------------------------------------------------------

        $ok = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\update_exactly_one_record_by_id(
                    $table_name         ,
                    $raw_record_data    ,
                    $records[0]['id']
                    ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $ok ) ) {
            return $ok ;
        }

        // ---------------------------------------------------------------------

        return $records[0]['id'] ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\add_record(
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
    // 3.   You DON'T have to supply INI and FLOAT values as PHP
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

    $raw_record_data = array(
        'created_server_time'           =>  time()                                      ,
        'last_modified_server_time'     =>  NULL                                        ,
        'nice_name'                     =>  $basepress_dataset_handle['nice_name']      ,
        'unique_key'                    =>  $basepress_dataset_handle['unique_key']     ,
        'version'                       =>  $basepress_dataset_handle['version']        ,
        'data'                          =>  $data
        ) ;

    // -------------------------------------------------------------------------

    return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressMysql\add_record(
                $table_name         ,
                $raw_record_data
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


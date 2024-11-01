<?php

// *****************************************************************************
// BASEPRESS-DATASETS-BROWSER.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_basePress_datasetsBrowser ;

// =============================================================================
// main_page()
// =============================================================================

function main_page() {

    // -------------------------------------------------------------------------
    // main_page()
    // - - - - - -
    // View and edit the BasePress datasets...
    //
    // Echos the page content.
    //
    // Returns nothing.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Support Routines...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/basepress-mysql.php' ) ;

    require_once( dirname( __FILE__ ) . '/basepress-datasets.php' ) ;

    // =========================================================================
    // Submission Handling...
    // =========================================================================

    $post_error = '' ;

    // -------------------------------------------------------------------------

    while ( count( $_POST ) > 0 ) {

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $_POST = Array(
        //                  [id]     => 1
        //                  [submit] => View
        //                  )
        //
        //      $_POST = Array(
        //                  [id]     => 1
        //                  [submit] => Delete Record
        //                  )
        //
        //      $_POST = Array(
        //                  [id]     => 1
        //                  [submit] => Clear Data
        //                  )
        //
        // ---------------------------------------------------------------------

//pr( $_POST ) ;

        // ---------------------------------------------------------------------

        if (    count( $_POST ) !== 2
                ||
                ! isset( $_POST['id'] )
                ||
                ! isset( $_POST['submit'] )
            ) {
            $post_error = <<<EOT
PROBLEM: Bad form submission (invalid POST parameters)
EOT;
            break ;
        }

        // ---------------------------------------------------------------------

        if (    trim( $_POST['id'] ) === ''
                ||
                ! ctype_digit( $_POST['id'] )
            ) {
            $post_error = <<<EOT
PROBLEM: Bad form submission (invalid record ID)
EOT;
            break ;
        }

        // ---------------------------------------------------------------------

        if ( $_POST['submit'] === 'View' ) {

            // =================================================================
            // VIEW
            // =================================================================

            return view_record() ;

            // -----------------------------------------------------------------

        } elseif ( $_POST['submit'] === 'Delete Record' ) {

            // =================================================================
            // DELETE RECORD
            // =================================================================

            //  NOT YET TESTED

//          $result = delete_record() ;
//
//          // -----------------------------------------------------------------
//
//          if ( is_string( $result ) ) {
//              $post_error = $result ;
//          }

            $post_error = <<<EOT
<big><b>Sorry, "Delete Record" is currently disabled</b></big>
EOT;

            // -----------------------------------------------------------------

            break ;

            // -----------------------------------------------------------------

        } elseif ( $_POST['submit'] === 'Clear Data' ) {

            // =================================================================
            // CLEAR DATA
            // =================================================================

            $result = clear_records_data() ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                $post_error = $result ;
            }

            // -----------------------------------------------------------------

            break ;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // ERROR
        // =====================================================================

        $post_error = <<<EOT
PROBLEM: Bad form submission (unrecognised/unsupported action)
EOT;

        break ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( $post_error !== '' ) {

        $post_error = <<<EOT
<p style="color:#AA0000">{$post_error}</p>
EOT;

    }

    // =========================================================================
    // Get the MAIN PAGE CONTENT...
    // =========================================================================

    $main_page_content = get_main_page_content() ;

    // =========================================================================
    // Display the PAGE...
    // =========================================================================

    echo <<<EOT
<h2>BasePress - Datasets Browser</h2>

{$post_error}

{$main_page_content}

<br />
<br />
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_main_page_content()
// =============================================================================

function get_main_page_content() {

    // =========================================================================
    // GET the "basepress_datasets" TABLE NAME...
    // =========================================================================

    $table_name = \basepress_datasets\get_table_name() ;

    // =========================================================================
    // Anything to list ?
    // =========================================================================

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

    if ( ! \basepress_mysql\table_exists( $table_name  ) ) {

        return <<<EOT
<p>Sorry, but NO BasePress Datasets have been defined<br /> (the
"basepress_datasets" table doesn't exist)</p>
EOT;

    }

    // =========================================================================
    // Load the "basepress_datasets" table records...
    // =========================================================================

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

    $sql = <<<EOT
SELECT * FROM {$table_name}
EOT;

    // -------------------------------------------------------------------------

    $datasets = \basepress_mysql\get_zero_or_more_records(
                    $sql
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $datasets ) ) {

        $datasets = nl2br( $datasets ) ;

        return <<<EOT
<p>{$datasets}</p>
EOT;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $datasets = Array(
    //
    //          [0] => Array(
    //
    //                      [id]                        => 1
    //                      [created_server_time]       => 1382998606
    //                      [last_modified_server_time] => 1382998635
    //                      [nice_name]                 => wooDeals_byFernTec
    //                      [unique_key]                => bbde559b-61f2-43c1-b82b-d34a4dbe3aea-9051a970-4002-11e3-aa6e-0800200c9a66-4eeed26e-5e0b-448c-8d35-498f6e79ebb4-df0ac708-fcca-41be-91d7-55db704b5fa5
    //                      [version]                   => 0.1
    //                      [data]                      => YToxOntzOjIyOiJxdWVzdGlvbl91c2VfY3VzdG9tX3VpIjtiOjE7fQ==
    //                      )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//ob_start() ;
//    pr( $datasets ) ;
//return ob_get_clean() ;

    // =========================================================================
    // List the datasets...
    // =========================================================================

    $data_rows = '' ;

    // -------------------------------------------------------------------------

    foreach ( $datasets as $this_dataset ) {

        // ---------------------------------------------------------------------

        $created = date( 'D j M Y, G:i' , $this_dataset['created_server_time'] ) ;

        // ---------------------------------------------------------------------

        $last_modified = date( 'D j M Y, G:i' , $this_dataset['last_modified_server_time'] ) ;

        // ---------------------------------------------------------------------

        $data = $this_dataset['data'] ;

        $number_data_characters = number_format( strlen( $data ) ) ;

        if ( strlen( $data ) > 32 ) {
            $data = substr( $data , 0 , 32 ) . '&hellip;' ;
        }

        $data .= <<<EOT
<div>({$number_data_characters} characters)</div>
EOT;

        // ---------------------------------------------------------------------

        $action = <<<EOT
<form
    name="basepress_datasets_view_record"
    method="post"
    action=""
    ><input type="hidden"
            name="id"
            value="{$this_dataset['id']}"
    /><input
            type="submit"
            name="submit"
            value="View"
            /></form>
<form
    name="basepress_datasets_delete_record"
    method="post"
    action=""
    onsubmit="return basepress_datasets_browser_question_delete_record( '{$this_dataset['id']}' )"
    ><input type="hidden"
            name="id"
            value="{$this_dataset['id']}"
    /><input
            type="submit"
            name="submit"
            value="Delete Record"
    /></form>
<form
    name="basepress_datasets_clear_data"
    method="post"
    action=""
    onsubmit="return basepress_datasets_browser_question_clear_data( '{$this_dataset['id']}' )"
    ><input type="hidden"
            name="id"
            value="{$this_dataset['id']}"
    /><input
            type="submit"
            name="submit"
            value="Clear Data"
    /></form>
EOT;

        // ---------------------------------------------------------------------

        $data_rows .= <<<EOT
<tr id="dataset_record_id_{$this_dataset['id']}">
    <td>{$this_dataset['id']}</td>
    <td>{$created}</td>
    <td>{$last_modified}</td>
    <td>{$this_dataset['nice_name']}</td>
    <td>{$data}</td>
    <td>{$action}</td>
    <td>{$this_dataset['unique_key']}</td>
    <td>{$this_dataset['version']}</td>
</tr>
EOT;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return <<<EOT
<table
    border="1"
    cellpadding="4"
    cellspacing="0"
    >
    <tr>
        <th>ID</th>
        <th>Created</th>
        <th>Last Modified</th>
        <th>Nice Name</th>
        <th>Data</th>
        <th>Action</th>
        <th>Unique Key</th>
        <th>Version</th>
    </tr>
    {$data_rows}
</table>

<script type="text/javascript">

    function basepress_datasets_browser_question_delete_record( record_id ) {
        var tr_el = document.getElementById( 'dataset_record_id_' + record_id ) ;
        var old_bg = tr_el.style.backgroundColor ;
        tr_el.style.backgroundColor = '#FFFF80' ;
        var yesno = confirm( 'DELETE the highlit record?\\n\\nARE YOU SURE?' ) ;
        tr_el.style.backgroundColor = old_bg ;
        if ( yesno ) {
            return true ;
        }
        return false ;
    }

    function basepress_datasets_browser_question_clear_data( record_id ) {
        var tr_el = document.getElementById( 'dataset_record_id_' + record_id ) ;
        var old_bg = tr_el.style.backgroundColor ;
        tr_el.style.backgroundColor = '#FFFF80' ;
        var yesno = confirm( 'CLEAR the highlit record\\'s DATA?\\n(Replace it with an EMPTY ARRAY?)\\n\\nARE YOU SURE?' ) ;
        tr_el.style.backgroundColor = old_bg ;
        if ( yesno ) {
            return true ;
        }
        return false ;
    }

</script>
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// view_record()
// =============================================================================

function view_record() {

    // -------------------------------------------------------------------------
    // view_record()
    // - - - - - -
    // Displays the single basepress_datasets record specified by:-
    //      $_POST['id']
    //
    // NOTE!
    // -----
    // On entry we know that $_POST['id'] is a string of 1 or more digits.
    // Though whether a "basepress_datasets" record with that record ID exists,
    // we haven't checked yet.
    //
    // Echos the page content.
    //
    // Returns nothing.
    // -------------------------------------------------------------------------

    // =========================================================================
    // GET the "basepress_datasets" TABLE NAME...
    // =========================================================================

    $table_name = \basepress_datasets\get_table_name() ;

    // =========================================================================
    // GET the RECORD from the DATABASE...
    // =========================================================================

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

    $sql = <<<EOT
SELECT * FROM {$table_name} WHERE id={$_POST['id']}
EOT;

    // -------------------------------------------------------------------------

    $record = \basepress_mysql\get_exactly_one_record(
                    $sql
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $record ) ) {

        $record = nl2br( $record ) ;

        return <<<EOT
<p>{$record}</p>
EOT;

    }

    // =========================================================================
    // DISPLAY the RECORD...
    // =========================================================================

    $created = date( 'D j M Y, G:i' , $record['created_server_time'] ) ;

    // -------------------------------------------------------------------------

    $last_modified = date( 'D j M Y, G:i' , $record['last_modified_server_time'] ) ;

    // -------------------------------------------------------------------------

    $data = $record['data'] ;

    // -------------------------------------------------------------------------

    $data = base64_decode( $data ) ;
                //  Returns the original data or FALSE on failure.
                //  The returned data may be binary.

    // -------------------------------------------------------------------------

    if ( $data === FALSE ) {

        // ---------------------------------------------------------------------

        $data = <<<EOT
<p style="color:#AA0000">PROBLEM: Bad BasePress dataset data (couldn't base64 decode it)</p>
<pre>{$record['data']}</pre>
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $base64_decoded_data = $data ;

        // ---------------------------------------------------------------------

        $data = unserialize( $data ) ;
                    //   The converted value is returned, and can be a boolean,
                    //  integer, float, string, array or object.
                    //
                    //  In case the passed string is not unserializeable, FALSE
                    //  is returned and E_NOTICE is issued.

        // ---------------------------------------------------------------------

        if ( $data === FALSE ) {

            // -----------------------------------------------------------------

            $data = <<<EOT
<p style="color:#AA0000">PROBLEM: Bad BasePress dataset data (couldn't unserialise it)</p>
<pre>{$base64_decoded_data}</pre>
EOT;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            if ( ! is_array( $data ) ) {

                $data = <<<EOT
<p style="color:#AA0000">PROBLEM: Bad BasePress dataset data (not an ARRAY)</p>
<pre>{$data}</pre>
EOT;

            } else {

                ob_start() ;
                    \wooDeals_byFernTec\pr( $data ) ;
                $data = ob_get_clean() ;

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $spacer_row = <<<EOT
<tr><td colspan="2" style="height:6px"></td></tr>
EOT;

    // -------------------------------------------------------------------------

    echo <<<EOT
<h3>BasePress - Datasets Browser</h3>

<h2>View Record</h2>

<p><big><b><a
    href=""
    style="text-decoration:none; padding:0.1em 1em; background-color:#F0F0F0"
    >Back</a></b></big></p>

<p><table
    border="0"
    cellpadding="0"
    cellspacing="0"
    >

    <tr style="background-color:#F0F8FF">
        <td align="right"><b>ID</b></td>
        <td style="padding-left:1em">{$record['id']}</td>
    </tr>

        {$spacer_row}

    <tr>
        <td align="right"><b>Created</b></td>
        <td style="padding-left:1em">{$created}</td>
    </tr>

        {$spacer_row}

    <tr style="background-color:#F0F8FF">
        <td align="right"><b>Last Modified</b></td>
        <td style="padding-left:1em">{$last_modified}</td>
    </tr>

        {$spacer_row}

    <tr>
        <td align="right"><b>Nice Name</b></td>
        <td style="padding-left:1em"><big><b style="color:#21759B">{$record['nice_name']}</b></big></td>
    </tr>

        {$spacer_row}

    <tr style="background-color:#F0F8FF">
        <td align="right"><b>Unique Key</b></td>
        <td style="padding-left:1em">{$record['unique_key']}</td>
    </tr>

        {$spacer_row}

    <tr>
        <td align="right"><b>Version</b></td>
        <td style="padding-left:1em">{$record['version']}</td>
    </tr>

        {$spacer_row}

    <tr style="background-color:#F0F8FF; padding:5px 0">
        <td align="right" valign="top"><p><b>Data</b></p></td>
        <td style="padding-left:1em">{$data}</td>
    </tr>

</table></p>

<br />
<br />
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// delete_record()
// =============================================================================

function delete_record() {

    // -------------------------------------------------------------------------
    // delete_record()
    // - - - - - - - -
    // Displays the single basepress_datasets record specified by:-
    //      $_POST['id']
    //
    // NOTE!
    // -----
    // On entry we know that $_POST['id'] is a string of 1 or more digits.
    // Though whether a "basepress_datasets" record with that record ID exists,
    // we haven't checked yet.
    //
    // Echos the page content.
    //
    // RETURNS:-
    //      o   TRUE
    //              --> Record deleted OK
    //              --> Display main page...
    //      o   $error_message STRING
    //              --> Record deletion failure
    //              --> Display main page with error message...
    // -------------------------------------------------------------------------

    // =========================================================================
    // GET the "basepress_datasets" TABLE NAME...
    // =========================================================================

    $table_name = \basepress_datasets\get_table_name() ;

    // =========================================================================
    // DELETE the record...
    // =========================================================================

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

    $where = array(
                'id'    =>  $_POST['id']
                ) ;

    // -------------------------------------------------------------------------

    $where_formats = '%d' ;

    // -------------------------------------------------------------------------

    $result = \basepress_mysql\delete_exactly_one_record(
                    $table_name         ,
                    $where              ,
                    $where_formats
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return nl2br( $result ) ;
    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// clear_records_data()
// =============================================================================

function clear_records_data() {

    // -------------------------------------------------------------------------
    // clear_records_data()
    // - - - - - - - - - -
    // Clears the "data" field of the basepress_datasets table record specified
    // by:-
    //      $_POST['id']
    //
    // NOTE!
    // -----
    // On entry we know that $_POST['id'] is a string of 1 or more digits.
    // Though whether a "basepress_datasets" record with that record ID exists,
    // we haven't checked yet.
    //
    // Echos the page content.
    //
    // RETURNS:-
    //      o   TRUE
    //              --> Data cleared OK
    //              --> Display main page...
    //      o   $error_message STRING
    //              --> Data clearance failure
    //              --> Display main page with error message...
    // -------------------------------------------------------------------------

    // =========================================================================
    // GET the "basepress_datasets" TABLE NAME...
    // =========================================================================

    $table_name = \basepress_datasets\get_table_name() ;

    // =========================================================================
    // GET the RECORD from the DATABASE...
    // =========================================================================

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

    $sql = <<<EOT
SELECT * FROM {$table_name} WHERE id={$_POST['id']}
EOT;

    // -------------------------------------------------------------------------

    $record = \basepress_mysql\get_exactly_one_record(
                    $sql
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $record ) ) {

        $record = nl2br( $record ) ;

        return <<<EOT
<p>{$record}</p>
EOT;

    }

    // =========================================================================
    // CLEAR the data...
    // =========================================================================

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

    $basepress_dataset_handle = array(
        'nice_name'     =>  $record['nice_name']        ,
        'unique_key'    =>  $record['unique_key']       ,
        'version'       =>  $record['version']
        ) ;

    // -------------------------------------------------------------------------

    $data = array() ;

    // -------------------------------------------------------------------------

    $record_id = $record['id'] ;

    // -------------------------------------------------------------------------

    $result = \basepress_datasets\save(
                    $basepress_dataset_handle   ,
                    $data                       ,
                    $record_id
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return nl2br( $result ) ;
    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


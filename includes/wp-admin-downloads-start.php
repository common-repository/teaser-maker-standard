<?php

// *****************************************************************************
// INCLUDES / WP-ADMIN-DOWNLOADS-START.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpAdminDownloads ;

    // -------------------------------------------------------------------------
    // OVERVIEW
    // ========
    // The usual way to download something from PHP is with code like (eg;)
    //
    //      $file = '/path/to/.../some-file-to-download.ext' ;
    //
    //      header('Content-Description: File Transfer');
    //      header('Content-Type: application/octet-stream');
    //      header('Content-Disposition: attachment; filename='.basename($file));
    //      header('Expires: 0');
    //      header('Cache-Control: must-revalidate');
    //      header('Pragma: public');
    //      header('Content-Length: ' . filesize($file));
    //      ob_clean();
    //      flush();
    //      readfile($file);
    //      exit;
    //
    // Or:-
    //
    //      $output = 'Hello World' ;
    //
    //      $destination_file_basename = 'hello-world.txt' ;
    //
    //      header('Content-Description: File Transfer');
    //      header('Content-Type: application/octet-stream');
    //      header('Content-Disposition: attachment; filename='.$destination_file_basename);
    //      header('Expires: 0');
    //      header('Cache-Control: must-revalidate');
    //      header('Pragma: public');
    //      header('Content-Length: ' . strlen( $output ) ) ;
    //      ob_clean();
    //      flush();
    //      echo $output ;
    //      exit;
    //
    // But this frequently doesn't work in WordPress Admin pages - with URLs
    // like:-
    //      http://www.example.com/wp-admin/admin.php?page=whatever
    //
    // for example.
    //
    // Because by the time your script containing the above download code
    // has run, WordPress has already started displaying the Admin page.
    //
    // Thus, the downloaded content just gets dumped to the screen verbatim.
    //
    // And if PHP error reporting is enabled, you'll see messages like (eg):-
    //
    //      Warning: Cannot modify header information - headers already sent by
    //      (output started at
    //      /home/.../wp-admin/includes/template.php:1812)
    //      in
    //      /home/.../wp-content/plugins/teaser-maker-pro-v0.1.80/app-defs/teaser-maker.app/plugin.stuff/scripts/export-category.php
    //      on line 1025
    //
    // So what we have to do is CREATE and DELIVER the file in TWO separate
    // STAGES, as follows:-
    //
    //      1.  First we CREATE the output to be downloaded - and store it
    //          as user meta data in the logged-in user's meta data table.
    //
    //          So even if the thing to be downloaded is a FILE - we still
    //          have to write it to the user's meta data table.
    //
    //          NOTE that this second stage code runs AFTER the WordPress
    //          admin page headers have been sent.
    //
    //      2.  Then we redirect to the second stage.  (So the second stage
    //          is in fact a new WordPress admin page.)
    //
    //      3.  The second stage then retrieves the saved output from the
    //          user's meta sata table - and sends it to the user using
    //          the PHP download code above.
    //
    //          This works because the DELIVERY code runs in the "admin_init"
    //          hook.  Which hook runs AFTER WprdPress has been loaded - and
    //          the user validated - but BEFORE the admin page headers are
    //          sent.
    //
    //          Once the output has been sent, we then exit() the DELIVERY
    //          stage admin page.  (So the user doesn't really see the
    //          DELIVERY stage admin page.  They only see the "Open or Save"
    //          download box popped up by the browser.)
    // -------------------------------------------------------------------------

// =============================================================================
// start_string_to_file_download()
// =============================================================================

function start_string_to_file_download(
    $string_to_download                             ,
    $output_file_basename                           ,
    $download_screen_title                          ,
    $download_sub_header                            ,
    $return_screen_name                             ,
    $return_screen_url                              ,
    $content_type = 'application/octet-stream'
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpAdminDownloads\
    // start_string_to_file_download(
    //      $string_to_download                             ,
    //      $output_file_basename                           ,
    //      $download_screen_title                          ,
    //      $download_sub_header                            ,
    //      $return_screen_name                             ,
    //      $return_screen_url                              ,
    //      $content_type = 'application/octet-stream'      //  (*)
    //      )
    // - - - - - - - - - - - - - - -
    // Saves the specified string to the currently logged in user's meta
    // data.  Then redirects to the download routine proper.
    //
    // (*) Defaults to binary downloads.
    //
    // RETURNS
    //      o   On SUCCESS
    //              Doesn't return (redirects to the download routine proper)
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // ERROR CHECKING (#1)
    // =========================================================================

    // -------------------------------------------------------------------------
    // $string_to_download
    // -------------------------------------------------------------------------

    if ( ! is_string( $string_to_download ) ) {

        return <<<EOT
PROBLEM: Bad "string_to_download" (not a string)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( trim( $string_to_download ) === '' ) {

        return <<<EOT
Oops! Nothing to download !!!
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // $output_file_basename
    // -------------------------------------------------------------------------

    if (    ! is_string( $output_file_basename )
            ||
            trim( $output_file_basename ) === ''
        ) {

        return <<<EOT
PROBLEM: Bad "output_file_basename" (non-blank string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // $content_type
    // -------------------------------------------------------------------------

    if (    ! is_string( $content_type )
            ||
            trim( $content_type ) === ''
        ) {

        return <<<EOT
PROBLEM: Bad "content_type" (non-blank string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // This function should be called from the WordPress Admin section - for
    // LOGGED-IN USERS ONLY...
    // =========================================================================

    // -------------------------------------------------------------------------
    // is_user_logged_in()
    // - - - - - - - - - -
    // This Conditional Tag checks if the current visitor is logged in. This is
    // a boolean function, meaning it returns either TRUE or FALSE.'
    //
    // This function does not accept any parameters.
    //
    // RETURN VALUES
    //      (boolean)
    //          True if user is logged in, false if not logged in.
    //
    // CHANGE LOG
    //      Since: 2.0.0
    // -------------------------------------------------------------------------

    if ( ! \is_user_logged_in() ) {

        return <<<EOT
Sorry, but this content can only be downloaded by logged in users
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // The USER MUST HAVE THE FOLLOWING CAPABILITIES:-
    //      o   edit_pages
    //      o   edit_posts
    //
    // Because if they don't have these, then it semms unlikely that they
    // should be in the WordPress back-end exporting (and importing) teasers.
    // =========================================================================

    // -------------------------------------------------------------------------
    // current_user_can( $capability, $args )
    // - - - - - - - - - - - - - - - - - - -
    // Whether the current user has a certain capability. See: Roles and
    // Capabilities.
    //
    //      $capability
    //          (string) (required) A capability. This is case-sensitive, and
    //          should be all lowercase.
    //          Default: None
    //
    //      $args
    //          (mixed) (optional) Any additional arguments that may be needed,
    //          such as a post ID. Some capability checks (like 'edit_post' or
    //          'delete_page') require this be provided.
    //          Default: None
    //
    // RETURNS
    //      (boolean)
    //          true if the current user has the capability.
    //          false if the current user does not have the capability.
    //
    //      Caution: current_user_can returns true even for a non existing or a
    //      junk post id
    //
    // CAPABILITIES PARAMETERS
    //
    // Here is a list of current $capability strings (keep in mind plugins may
    // adjust the capabilities array).
    //
    //      activate_plugins (boolean)
    //      add_users (boolean)
    //      create_users (boolean)
    //      delete_others_pages (boolean)
    //      delete_others_posts (boolean)
    //      delete_pages (boolean)
    //      delete_plugins (boolean)
    //      delete_posts (boolean)
    //      delete_private_pages (boolean)
    //      delete_private_posts (boolean)
    //      delete_published_pages (boolean)
    //      delete_published_posts (boolean)
    //      delete_themes (boolean)
    //      delete_users (boolean)
    //      edit_dashboard (boolean)
    //      edit_others_pages (boolean)
    //      edit_others_posts (boolean)
    //      edit_pages (boolean)
    //      edit_plugins (boolean)
    //      edit_posts (boolean)
    //      edit_private_pages (boolean)
    //      edit_private_posts (boolean)
    //      edit_published_pages (boolean)
    //      edit_published_posts (boolean)
    //      edit_themes (boolean)
    //      edit_theme_options (boolean)
    //      import (boolean)
    //      install_plugins (boolean)
    //      install_themes (boolean)
    //      list_users (boolean)
    //      manage_categories (boolean)
    //      manage_links (boolean)
    //      manage_options (boolean)
    //      moderate_comments (boolean)
    //      promote_users (boolean)
    //      publish_pages (boolean)
    //      publish_posts (boolean)
    //      read (boolean)
    //      read_private_pages (boolean)
    //      read_private_posts (boolean)
    //      remove_users (boolean)
    //      switch_themes (boolean)
    //      unfiltered_html (boolean)
    //      unfiltered_upload (boolean)
    //      update_core (boolean)
    //      update_plugins (boolean)
    //      update_themes (boolean)
    //      upload_files (boolean)
    //      level_10 (boolean) - deprecated
    //      level_9 (boolean) - deprecated
    //      level_8 (boolean) - deprecated
    //      level_7 (boolean) - deprecated
    //      level_6 (boolean) - deprecated
    //      level_5 (boolean) - deprecated
    //      level_4 (boolean) - deprecated
    //      level_3 (boolean) - deprecated
    //      level_2 (boolean) - deprecated
    //      level_1 (boolean) - deprecated
    //      level_0 (boolean) - deprecated
    //
    // NOTES
    //      Do not pass a role name to current_user_can(), as this is not
    //      guaranteed to work correctly (see #22624). Instead, you may wish to
    //      try the check user role function put together by AppThemes.
    //
    // CHANGELOG
    //      Since: 2.0.0
    // -------------------------------------------------------------------------

    if (    ! \current_user_can( 'edit_pages' )
            ||
            ! \current_user_can( 'edit_posts' )
        ) {

        return <<<EOT
Sorry, but this content can only be downloaded by logged in users with "edit_pages" and "edit_posts" capabilities
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // Get a USER DOWNLOAD KEY...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpAdminDownloads\
    // get_user_download_key()
    // - - - - - - - - - - - -
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

    $user_download_key = get_user_download_key() ;

    // -------------------------------------------------------------------------

    if ( is_array( $user_download_key ) ) {
        return $user_download_key[0] ;
    }

    // =========================================================================
    // Get a CHERCKSUM for the string to download (so that we can detect
    // any corruption that might arise during the admin download procedure)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // int crc32 ( string $str )
    // - - - - - - - - - - - - -
    // Generates the cyclic redundancy checksum polynomial of 32-bit lengths of
    // the str. This is usually used to validate the integrity of data being
    // transmitted.
    //
    // WARNING
    //
    // Because PHP's integer type is signed many crc32 checksums will result in
    // negative integers on 32bit platforms. On 64bit installations all crc32()
    // results will be positive integers though.
    //
    // So you need to use the "%u" formatter of sprintf() or printf() to get the
    // string representation of the unsigned crc32() checksum in decimal format.
    //
    // For a hexadecimal representation of the checksum you can either use the
    // "%x" formatter of sprintf() or printf() or the dechex() conversion
    // functions, both of these also take care of converting the crc32() result
    // to an unsigned integer.
    //
    // Having 64bit installations also return negative integers for higher
    // result values was considered but would break the hexadecimal conversion
    // as negatives would get an extra 0xFFFFFFFF######## offset then. As
    // hexadecimal representation seems to be the most common use case we
    // decided to not break this even if it breaks direct decimal comparisons in
    // about 50% of the cases when moving from 32 to 64bits.
    //
    // In retrospect having the function return an integer maybe wasn't the best
    // idea and returning a hex string representation right away (as e.g. md5()
    // does) might have been a better plan to begin with.
    //
    // For a more portable solution you may also consider the generic hash().
    // hash("crc32b", $str) will return the same string as dechex(crc32($str)).
    //
    //      str
    //          The data.
    //
    // RETURN VALUES
    //      Returns the crc32 checksum of str as an integer.
    //
    // (PHP 4 >= 4.0.1, PHP 5)
    // -------------------------------------------------------------------------

    $crc32 = \dechex( \crc32( $string_to_download ) ) ;

    // -------------------------------------------------------------------------
    // string md5 ( string $str [, bool $raw_output = false ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Calculates the MD5 hash of str using the » RSA Data Security, Inc. MD5
    // Message-Digest Algorithm, and returns that hash.
    //
    //      str
    //          The string.
    //
    //      raw_output
    //          If the optional raw_output is set to TRUE, then the md5 digest
    //          is instead returned in raw binary format with a length of 16.
    //
    // RETURN VALUES
    //      Returns the hash as a 32-character hexadecimal number.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    $md5 = \md5( $string_to_download ) ;

    // -------------------------------------------------------------------------
    // string sha1 ( string $str [, bool $raw_output = false ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Calculates the sha1 hash of str using the » US Secure Hash Algorithm 1.
    //
    //      str
    //          The input string.
    //
    //      raw_output
    //          If the optional raw_output is set to TRUE, then the sha1 digest
    //          is instead returned in raw binary format with a length of 20,
    //          otherwise the returned value is a 40-character hexadecimal
    //          number.
    //
    // RETURN VALUES
    //      Returns the sha1 hash as a string.
    //
    // (PHP 4 >= 4.3.0, PHP 5)
    //
    // CHANGELOG
    //      Version Description
    //      5.0.0   The raw_output parameter was added.
    // -------------------------------------------------------------------------

    $sha1 = \sha1( $string_to_download ) ;

    // -------------------------------------------------------------------------

    $checksum = $crc32 . '-' . $md5 . '-' . $sha1 . '-' . \strlen( $string_to_download ) ;

    // =========================================================================
    // Get the CURRENT USER'S DETAILS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // get_currentuserinfo()
    // - - - - - - - - - - -
    // Retrieves the information pertaining to the currently logged in user, and
    // places it in the global variable $current_user. Properties map directly
    // to the wp_users table in the database (see Database Description).
    //
    // Also places the individual attributes into the following separate global
    // variables:
    //
    //      $user_login
    //
    //      $user_ID        (Equal $current_user->ID, not
    //                      $current_user->user_ID)
    //
    //      $user_email
    //
    //      $user_url       (User's website, as entered in the user's Profile)
    //
    //      $user_pass      (The phpass hash of the user password - useful for
    //                      comparing input at a password prompt with the actual
    //                      user password.)
    //
    //      $display_name   (User's name, displayed according to the 'How to
    //                      display name' User option)
    //
    //      $user_identity  (User's name, displayed according to the 'How to
    //                      display name' User option (since 3.0))
    //
    // DEFAULT USAGE
    //      The call to get_currentuserinfo() places the current user's info
    //      into $current_user, where it can be retrieved using member
    //      variables.
    //
    //          global $current_user ;
    //          get_currentuserinfo() ;
    //
    //          echo 'Username: ' . $current_user->user_login . "\n";
    //          echo 'User email: ' . $current_user->user_email . "\n";
    //          echo 'User first name: ' . $current_user->user_firstname . "\n";
    //          echo 'User last name: ' . $current_user->user_lastname . "\n";
    //          echo 'User display name: ' . $current_user->display_name . "\n";
    //          echo 'User ID: ' . $current_user->ID . "\n";
    // -------------------------------------------------------------------------

    global $current_user ;

    \get_currentuserinfo() ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $current_user , '$current_user' ) ;

    // =========================================================================
    // GET the "ADMIN DOWNLOADS" USER META DATA KEYS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpAdminDownloads\
    // get_meta_keys()
    // - - - - - - - -
    // RETURNS
    //      $meta_keys = ARRAY(
    //          'string_to_download'    =>  "xxx"   ,
    //          'output_file_basename'  =>  "xxx"   ,
    //          'content_type'          =>  "xxx"   ,
    //          'user_download_key'     =>  "xxx"   ,
    //          'number_chunks'         =>  N       ,
    //          'checksum'              =>  "xxx"
    //          )
    // -------------------------------------------------------------------------

    $meta_keys = get_meta_keys() ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $meta_keys ) ;

    // =========================================================================
    // Save the DOWNLOAD DETAILS in the CURRENT USER'S META DATA TABLE...
    // =========================================================================

    // -------------------------------------------------------------------------
    // update_user_meta( $user_id, $meta_key, $meta_value, $prev_value )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Update user meta field based on user ID.
    //
    // Use the $prev_value parameter to differentiate between meta fields with
    // the same key and user ID.
    //
    // If the meta field for the user does not exist, it will be added.
    //
    //      $user_id
    //          (integer) (required) User ID.
    //          Default: None
    //
    //      $meta_key
    //          (string) (required) The meta_key in the wp_usermeta table for
    //          the meta_value to be updated.
    //          Default: None
    //
    //      $meta_value
    //          (mixed) (required) The new desired value of the meta_key, which
    //          must be different from the existing value. Arrays and objects
    //          will be automatically serialized. Note that using objects may
    //          cause this bug to popup.
    //          Default: None
    //
    //      $prev_value
    //          (mixed) (optional) Previous value to check before removing.
    //          Default: ''
    //
    // RETURN VALUES
    //      (int/boolean)
    //          Row ID on successful update, false on failure.
    //
    // EXAMPLES
    //
    // Below is an example showing how to update a user's Website profile field
    //
    //      $user_id = 1;
    //      $website = 'http://wordpress.org';
    //      update_user_meta($user_id, 'user_url', $website);
    //
    // Below is an example showing how to check for errors:
    //
    //      $user_id = 1;
    //      $new_value = 'some new value';
    //
    //      // will return false if the previous value is the same as $new_value
    //      update_user_meta( $user_id, 'some_meta_key', $new_value );
    //
    //      // so check and make sure the stored value matches $new_value
    //      if ( get_user_meta($user_id,  'some_meta_key', true ) != $new_value )
    //          wp_die('An error occurred');
    //
    // CHANGES IN BEHAVIOR FROM THE NOW DEPRECATED UPDATE_USERMETA:
    //      update_user_meta does not delete the meta if the new value is empty.
    //      The actions are different.
    //
    // CHANGE LOG
    //      Since: 3.0.0
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // get_user_meta($user_id, $key, $single)
    // - - - - - - - - - - - - - - - - - - -
    // Retrieve a single meta field or all fields of user_meta data for the
    // given user. Uses get_metadata(). This function replaces the deprecated
    // get_usermeta() function.
    //
    //      $user_id
    //          (integer) (required) The ID of the user whose data should be
    //          retrieved.
    //          Default: None
    //
    //      $key
    //          (string) (optional) The meta_key in the wp_usermeta table for
    //          the meta_value to be returned. If left empty, will return all
    //          user_meta fields for the given user.
    //          Default: (empty string)
    //
    //      $single
    //          (boolean) (optional) If true return value of meta data field, if
    //          false return an array. This parameter has no effect if $key is
    //          left blank.
    //          Default: false
    //
    // RETURN VALUES
    //      (mixed) Will be an Array if $key is not specified or if $single is
    //      false. Will be value of meta_value field if $single is true.
    //
    //      NOTE
    //      If the meta value does not exist and $single is true the function
    //      will return an empty string. If $single is false an empty array is
    //      returned.
    //
    // EXAMPLES
    //
    // This example returns and then displays the last name for user id 9.
    //
    //      $user_id = 9;
    //      $key = 'last_name';
    //      $single = true;
    //      $user_last = get_user_meta( $user_id, $key, $single );
    //
    // This example demonstrates leaving the $key argument blank, in order to
    // retrieve all meta data for the given user (in this example, user_id = 9):
    //
    //      $all_meta_for_user = get_user_meta( 9 );
    //
    //      Generates:-
    //
    //          $all_meta_for_user = Array(
    //              [first_name]    => Array( [0] => Tom      )
    //              [last_name]     => Array( [0] => Auger    )
    //              [nickname]      => Array( [0] => tomauger )
    //              [description]   => etc....
    //              )
    //
    // Note: in order to access the data in this example, you need to
    // dereference the array that is returned for each key, like so:
    //
    //      $last_name = $all_meta_for_user['last_name'][0];
    //
    // To avoid this, you may want to run a simple array_map() on the results of
    // get_user_meta() in order to take only the first index of each result
    // (this emulating what the $single argument does when $key is provided:
    //
    //      $all_meta_for_user =
    //          array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_id ) );
    //
    //      Generates:-
    //
    //          $all_meta_for_user = Array(
    //              [first_name]    => Tom
    //              [last_name]     => Auger
    //              [nickname]      => tomauger
    //              [description]   => etc....
    //              )
    //
    // CHANGE LOG
    //      Since: 3.0
    // -------------------------------------------------------------------------

    $single = TRUE ;
        //  For "get_user_meta()"...

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // Acc. to:-
    //      http://codex.wordpress.org/Database_Description#Table:_wp_usermeta
    //
    // the wp_usermeta table is:-
    //
    //      Field       Type                    Null    Key     Default         Extra
    //      umeta_id    bigint(20) unsigned             PRI     NULL            auto_increment
    //      user_id     bigint(20) unsigned     '0'             FK->wp_users.ID
    //      meta_key    varchar(255)            Yes     IND     NULL
    //      meta_value  longtext                Yes     IND     NULL
    //
    // Where "longtext" is 4Gb.  So:-
    //
    //      o   "meta_key"   = max. 255 chars
    //      o   "meta_value" = max. 4 Gb
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE - "MAX_ALLOWED_PACKET"
    // ===========================
    // MySQL has a variable called "max_allowed_packet".  Described here:-
    //      http://dev.mysql.com/doc/refman/5.5/en/packet-too-large.html
    //
    // The default is 1MB - though it can be set up to 1Gb.
    //
    // But many ISPs leave it at the default 1MB for WordPress installations.
    // Because that's all that's needed in most cases.
    //
    // ---
    //
    // So if our string to download is larger than 1MB - then we'll almost
    // certainly not be able to save it in the user meta table.  Because
    // WordPress will generate an:-
    //      WordPress database error: [Got a packet bigger than 'max_allowed_packet' bytes]
    //
    // error.
    //
    // ---
    //
    // To fix this, we save such strings in 1MB chunks.                                                                                            //
    //
    // ---
    //
    // But what's a MB?  From:-
    //      http://en.wikipedia.org/wiki/Megabyte
    //
    // there seem to be 3 common definitions:-
    //      o   1 MB = 1000000 bytes (= 10002 B = 106 B) is the definition
    //          recommended by the International System of Units (SI) and the
    //          International Electrotechnical Commission IEC.[2] This
    //          definition is used in networking contexts and most storage
    //          media, particularly hard drives, flash-based storage,[3] and
    //          DVDs, and is also consistent with the other uses of the SI
    //          prefix in computing, such as CPU clock speeds or measures of
    //          performance. The Mac OS X 10.6 file manager is a notable example
    //          of this usage in software. Since Snow Leopard, file sizes are
    //          reported in decimal units.[4]
    //
    //      o   1 MB = 1048576 bytes (= 10242 B = 220 B) is the definition used
    //          by Microsoft Windows in reference to computer memory, such as
    //          RAM. This definition is synonymous with the unambiguous binary
    //          prefix mebibyte.
    //
    //      o   1 MB = 1024000 bytes (= 1000�1024) B is the definition used to
    //          describe the formatted capacity of the 1.44 MB 3.5inch HD floppy
    //          disk, which actually has a capacity of 1474560bytes.
    //
    // We'll assume 1,000,000 bytes to be safe - and to give some overhead for
    // those parts of the MySql query wrapped around the string value being
    // read/written.
    // -------------------------------------------------------------------------

    $one_mb = 1000000 ;

    // -------------------------------------------------------------------------
    // stringToDownload
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // array str_split ( string $string [, int $split_length = 1 ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Converts a string to an array.
    //
    //      string
    //          The input string.
    //
    //      split_length
    //          Maximum length of the chunk.
    //
    // RETURN VALUES
    //      If the optional split_length parameter is specified, the returned
    //      array will be broken down into chunks with each being split_length
    //      in length, otherwise each chunk will be one character in length.
    //
    //      FALSE is returned if split_length is less than 1. If the
    //      split_length length exceeds the length of string, the entire string
    //      is returned as the first (and only) array element.
    //
    // (PHP 5)
    // -------------------------------------------------------------------------

//echo '<h1>' , strlen( $string_to_download ) , '</h1>' ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $string_to_download , '$string_to_download' ) ;

    // -------------------------------------------------------------------------

    $string_to_download = \str_split( $string_to_download , $one_mb ) ;

    // -------------------------------------------------------------------------

    if ( $string_to_download === FALSE ) {

        return <<<EOT
PROBLEM:&nbsp; "str_split()" failure chunking string to download
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    $number_chunks = 0 ;

    // -------------------------------------------------------------------------

    foreach ( $string_to_download as $chunk_index => $this_chunk ) {

        // ---------------------------------------------------------------------

        $chunk_number = $chunk_index + 1 ;

        // ---------------------------------------------------------------------

        $chunk_key = $meta_keys['string_to_download'] . '_' . $chunk_number ;

        // ---------------------------------------------------------------------

        $result = \update_user_meta( $current_user->ID , $chunk_key , $this_chunk ) ;
                    //  Returns row ID on successful update, FALSE on failure.

        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $result , '$result' ) ;

        // ---------------------------------------------------------------------


//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr(
//    \get_user_meta( $current_user->ID , $meta_keys['string_to_download'] , $single )    ,
//    'get_user_meta("string_to_download")'
//    ) ;

        // ---------------------------------------------------------------------

        if ( \get_user_meta( $current_user->ID , $chunk_key , $single ) !== $this_chunk ) {

            return <<<EOT
PROBLEM:&nbsp; "update_user_meta()" or "get_user_meta()" failure saving chunk# {$chunk_number} of "string_to_download"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $number_chunks++ ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // outputFileBasename
    // -------------------------------------------------------------------------

    $result = \update_user_meta( $current_user->ID , $meta_keys['output_file_basename'] , $output_file_basename ) ;
                    //  Returns row ID on successful update, FALSE on failure.

    // -------------------------------------------------------------------------

    if ( \get_user_meta( $current_user->ID , $meta_keys['output_file_basename'] , $single ) !== $output_file_basename ) {

        return <<<EOT
PROBLEM:&nbsp; "update_user_meta()" or "get_user_meta()" failure saving "output_file_basename"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // contentType
    // -------------------------------------------------------------------------

    $result = \update_user_meta( $current_user->ID , $meta_keys['content_type'] , $content_type ) ;
                    //  Returns row ID on successful update, FALSE on failure.

    // -------------------------------------------------------------------------

    if ( \get_user_meta( $current_user->ID , $meta_keys['content_type'] , $single ) !== $content_type ) {

        return <<<EOT
PROBLEM:&nbsp; "update_user_meta()" or "get_user_meta()" failure saving "content_type"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // userDownloadKey
    // -------------------------------------------------------------------------

    $result = \update_user_meta( $current_user->ID , $meta_keys['user_download_key'] , $user_download_key ) ;
                    //  Returns row ID on successful update, FALSE on failure.

    // -------------------------------------------------------------------------

    if ( \get_user_meta( $current_user->ID , $meta_keys['user_download_key'] , $single ) !== $user_download_key ) {

        return <<<EOT
PROBLEM:&nbsp; "update_user_meta()" or "get_user_meta()" failure saving "user_download_key"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // numberChunks
    // -------------------------------------------------------------------------

    $result = \update_user_meta( $current_user->ID , $meta_keys['number_chunks'] , $number_chunks ) ;
                    //  Returns row ID on successful update, FALSE on failure.

    // -------------------------------------------------------------------------

    if ( \get_user_meta( $current_user->ID , $meta_keys['number_chunks'] , $single ) != $number_chunks ) {

        return <<<EOT
PROBLEM:&nbsp; "update_user_meta()" or "get_user_meta()" failure saving "number_chunks"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // checksum
    // -------------------------------------------------------------------------

    $result = \update_user_meta( $current_user->ID , $meta_keys['checksum'] , $checksum ) ;
                    //  Returns row ID on successful update, FALSE on failure.

    // -------------------------------------------------------------------------

    if ( \get_user_meta( $current_user->ID , $meta_keys['checksum'] , $single ) !== $checksum ) {

        return <<<EOT
PROBLEM:&nbsp; "update_user_meta()" or "get_user_meta()" failure saving "checksum"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // Send a POST request to the page we've come from.
    //
    // This will trigger the page to reload - which will in turn run the
    // download DELIVERY routine - when the "admin_init" action hook is run
    // on page startup.
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // On the assumption that you can't use the WP back-end without Javascript,
    // we'll assume that Javascript is enabled (in the user's browser), and
    // send a self submitting FORM...
    //
    // However, if JS isn't enabled, the user will just see a "Submit"
    // button, and a message to press it (to download the content they
    // requested).
    // -------------------------------------------------------------------------

    $form_id = 'great_kiwi_wordpress_admin_download_form' ;

    // -------------------------------------------------------------------------

    echo <<<EOT
<br />
<br />
<h2>{$download_screen_title}</h2>
{$download_sub_header}
<br />
<form   id="{$form_id}"
        method="post"
        action=""
        ><input
            type="hidden"
            name="great_kiwi_wordpress_admin_download_request"
            value="{$user_download_key}"
            />

        <div    id="{$form_id}_nojs_content"
                style="margin-left:2em; padding:1em; color:#AA0000; border:1px solid #AA0000; display:inline-block">

            <p>Sorry, but Javascript doesn't seem to be enabled in your
            browser.</p>

            <p><b>So please press <input
                type="submit"
                value="Submit"
                />,
            to DOWNLOAD the content you requested</b>...</p>

        </div>

</form>
<br />
<p>Once you've saved or cancelled the download...<div
    style="padding-left:2em">...<a
        href="{$return_screen_url}"
        style="text-decoration:none"
        ><b>click here to return to the "{$return_screen_name}"
        screen</b></a>...</div></p>
<br />
<br />
<script type="text/javascript">
    document.getElementById( '{$form_id}_nojs_content' ).style.display = 'none' ;
    document.getElementById( '{$form_id}' ).submit() ;
</script>
EOT;

    // -------------------------------------------------------------------------

    exit() ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


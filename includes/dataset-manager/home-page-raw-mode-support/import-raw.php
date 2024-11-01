<?php

// *****************************************************************************
// DATASET-MANAGER / HOME-PAGE-RAW-MODE-SUPPORT / IMPORT-RAW.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// import_raw()
// =============================================================================

function import_raw(
    $caller_app_slash_plugins_global_namespace      ,
    $home_page_title                                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end                             ,
    $display_options    = array()                   ,
    $submission_options = array()
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // import_raw(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $home_page_title                                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end                             ,
    //      $display_options    = array()                   ,
    //      $submission_options = array()
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Dumps the dataset records array to a PHP file.
    //
    // $all_application_dataset_definitions should be like (eg):-
    //
    //      $all_application_dataset_definitions = Array(
    //
    //          [projects] => Array(    //  <== "dataset_slug"
    //              [dataset_slug]              => projects
    //              [dataset_name_singular]     => project
    //              [dataset_name_plural]       => projects
    //              [dataset_title_singular]    => Project
    //              [dataset_title_plural]      => Projects
    //              [basepress_dataset_handle]  => array(...)
    //              )
    //
    //          ...
    //
    //          )
    //
    // RETURNS:-
    //      Nothing
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //                                                                                   t
    //      $_GET = Array(
    //                  [page]          => pluginPlant
    //                  [action]        => import-raw
    //                  [application]   => picture-docs
    //                  [dataset_slug]  => rolls
    //                  )
    //
    //      $_POST = Array()
    //
    //      $_COOKIE = Array(
    //
    //          [wordpress_f40f69ed56e8e6a6c6223ff4c2279982]
    //              => petern|1400758142|7679ba8958c853cf2fe3243ea03e301b
    //
    //          [wp-settings-time-1]
    //              => 1379907093
    //
    //          [wp-settings-1]
    //              => mfold=t&hidetb=1&editor=html&libraryContent=browse
    //
    //          [wc_session_cookie_f40f69ed56e8e6a6c6223ff4c2279982]
    //              => JD918LnI61IBqQR1Bn5TarmM7x2XMaN4||1400718284||1400714684||ec631f061aaf293d0e1cfb7992c31b97
    //
    //          [woocommerce_items_in_cart]
    //              => 1
    //
    //          [woocommerce_cart_hash]
    //              => 4d95884548c812cb09eb38fb6acc4a43
    //
    //          [wordpress_test_cookie]
    //              => WP Cookie check
    //
    //          [wordpress_logged_in_f40f69ed56e8e6a6c6223ff4c2279982]
    //              => petern|1400758142|8ef3504ec7d73aaf7c0621c3d9d0d55e
    //
    //          [jobmkr_vid]
    //              => p7N2f4J1p9L1m1C6m3K4q0D7c2K7k2C6w6B5f3W5x9O8v2E8v2X3l6I2i0P2j3U2
    //
    //          [sm_vid]
    //              => h2K1m1I1x0E8m2F9a1N1o5M1x4R0m9F9h3G2u7N4n7V0v7I4x2G2a0B2v9H0h4A0
    //
    //          [__utma]
    //              => 111872281.1800673468.1360307281.1360359420.1360369890.4
    //
    //          [PHPSESSID]
    //              => nnq2rpof51ma0nq930hqbp5k94
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $_GET , '$_GET' ) ;
//pr( $_POST , '$_POST' ) ;
//pr( $_FILES , '$_FILES' ) ;
//pr( $_COOKIE , '$_COOKIE' ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $display_options = Array()
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $display_options , '$display_options' ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $all_application_dataset_definitions = Array(
    //
    //          [projects] => Array(
    //
    //              [dataset_slug]              => projects
    //              [dataset_name_singular]     => project
    //              [dataset_name_plural]       => projects
    //              [dataset_title_singular]    => Project
    //              [dataset_title_plural]      => Projects
    //              [basepress_dataset_handle]  => Array(
    //                  [nice_name] => protoPress_byFernTec_projects
    //                  [unique_key] => d2562b23-3c20-4368-92c4-2b6cd3fa722b-4d1e2f6c-bfd7-4d6d-a151-7710ac09802d-55672840-63d3-11e3-949a-0800200c9a66-627c9d30-63d3-11e3-949a-0800200c9a66
    //                  [version] => 0.1
    //                  )
    //
    //              [zebra_form] => Array(
    //
    //                  [form_specs] => Array(
    //                      [name]                  => add_edit_project
    //                      [method]                => POST
    //                      [action]                =>
    //                      [attributes]            => Array()
    //                      [clientside_validation] => 1
    //                      )
    //
    //                  [field_specs] => Array(
    //
    //                      [title] => Array(
    //                                      [type]               => text
    //                                      [label]              => Project Title
    //                                      [type_specific_args] => Array(
    //                                                                  [id]         =>
    //                                                                  [default]    =>
    //                                                                  [attributes] => Array()
    //                                                                  )
    //                                      )
    //
    //                      [notes_slash_comments] => Array(
    //                                      [type]               => textarea
    //                                      [label]              => Project Notes/Comments
    //                                      [type_specific_args] => Array(
    //                                                                  [id]         =>
    //                                                                  [default]    =>
    //                                                                  [attributes] => Array()
    //                                                                  )
    //                                      )
    //
    //                      [save_me] => Array(
    //                                      [type]               => submit
    //                                      [label]              => Submit
    //                                      [type_specific_args] => Array(
    //                                                                  [id]         =>
    //                                                                  [default]    =>
    //                                                                  [attributes] => Array()
    //                                                                  )
    //                                      )
    //
    //                      )
    //
    //
    //                  'focus_field_slug'  =>  'title'
    //
    //                  )
    //
    //              )
    //
    // -------------------------------------------------------------------------

//pr( $all_application_dataset_definitions ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------

    require_once( $caller_apps_includes_dir . '/string-utils.php' ) ;

    // =========================================================================
    // ERROR CHECKING (1)
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page]          => pluginPlant
    //                  [action]        => import-raw
    //                  [application]   => picture-docs
    //                  [dataset_slug]  => rolls
    //                  )
    //
    //      $_POST = Array()
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // $_POST ?
    // -------------------------------------------------------------------------

    if ( count( $_POST ) > 0 ) {
        return ;        //  Display blank screen (to potential hackers)
    }

    // -------------------------------------------------------------------------
    // $_GET ?
    // -------------------------------------------------------------------------

    if ( count( $_GET ) !== 4 ) {
        return ;        //  Display blank screen (to potential hackers)
    }

    // -------------------------------------------------------------------------
    // page ?
    // action ?
    // application ?
    // dataset_slug ?
    // -------------------------------------------------------------------------

    if (    ! array_key_exists( 'page' , $_GET )
            &&
            ! array_key_exists( 'action' , $_GET )
            &&
            ! array_key_exists( 'application' , $_GET )
            &&
            ! array_key_exists( 'dataset_slug' , $_GET )
        ) {
        return ;        //  Display blank screen (to potential hackers)
    }

    // -------------------------------------------------------------------------
    // page ?
    // -------------------------------------------------------------------------

    if ( $_GET['page'] !== 'pluginPlant' ) {
        return ;        //  Display blank screen (to potential hackers)
    }

    // -------------------------------------------------------------------------
    // action ?
    // -------------------------------------------------------------------------

    if ( $_GET['action'] !== 'import-raw' ) {
        return ;        //  Display blank screen (to potential hackers)
    }

    // -------------------------------------------------------------------------
    // application ?
    // -------------------------------------------------------------------------

    if (    ! is_string( $_GET['application'] )
            ||
            trim( $_GET['application'] ) === ''
            ||
            strlen( $_GET['application'] ) > 64
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash(
                    $_GET['application']
                    )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "application"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // dataset_slug ?
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // is_dataset_slug(
    //      $candidate_dataset_slug                         ,
    //      $all_application_dataset_definitions = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Is:-
    //      $candidate_dataset_slug
    //
    // a 1 to 64 character alphanumeric underscore string?
    //
    // ---
    //
    // And if:-
    //      $all_application_dataset_definitions
    //
    // is an ARRAY, we also check if:-
    //      $candidate_dataset_slug
    //
    // is a key of that array.
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = is_dataset_slug(
                    $_GET['dataset_slug']                   ,
                    $all_application_dataset_definitions
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        echo nl2br( $result ) ;
        return ;
    }


//  // =========================================================================
//  // Get the specified dataset's DATASET MANAGER DATASET DEFINITION...
//  // =========================================================================
//
//  $selected_datasets_dmdd = $all_application_dataset_definitions[ $dataset_slug ] ;
//                                  //  dmdd = Dataset Manager Dataset Definition
//
//  // =========================================================================
//  // Get the ERROR PAGE TITLE and DATASET TITLE (for use in error messages)...
//  // =========================================================================
//
//  $error_page_title = 'Import Raw Dataset' ;
//
//  // -------------------------------------------------------------------------
//
//  if (    isset( $selected_datasets_dmdd['dataset_title_plural'] )
//          &&
//          is_string( $selected_datasets_dmdd['dataset_title_plural'] )
//          &&
//          trim( $selected_datasets_dmdd['dataset_title_plural'] ) !== ''
//      ) {
//      $dataset_title = $selected_datasets_dmdd['dataset_title_plural'] ;
//
//  } else {
//      $dataset_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
//                              $dataset_slug
//                              ) ;
//
//  }
//
//  // =========================================================================
//  // LOAD the DATASET RECORDS (from array storage)...
//  // =========================================================================
//
//  require_once( $caller_apps_includes_dir . '/array-storage.php' ) ;
//
//  // -------------------------------------------------------------------------
//  // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
//  //      $dataset_name                       ,
//  //      $question_die_on_error = FALSE
//  //      )
//  // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
//  // Loads and returns the specified PHP numerically indexed array.
//  //
//  // RETURNS
//  //      o   On SUCCESS
//  //          - - - - -
//  //          ARRAY $array
//  //          A possibly empty PHP numerically indexed ARRAY.
//  //
//  //      o   On FAILURE
//  //          - - - - -
//  //          $error_message STRING
//  // -------------------------------------------------------------------------
//
//  $question_die_on_error = FALSE ;
//
//  $dataset_records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
//                          $dataset_slug               ,
//                          $question_die_on_error
//                          ) ;
//
//  // -------------------------------------------------------------------------
//
//  if ( is_string( $dataset_records ) ) {
//
//      return standard_dataset_manager_error(
//                  $error_page_title           ,
//                  $dataset_records            ,
//                  $caller_apps_includes_dir   ,
//                  $question_front_end
//                  ) ;
//
//  }
//
//  // =========================================================================
//  // GET the APPLICATION SLUG and TITLE...
//  // =========================================================================
//
//  if (    array_key_exists( 'application' , $_GET )
//          &&
//          trim( $_GET['application'] ) !== ''
//      ) {
//
//      // ---------------------------------------------------------------------
//
//      $application_slug = '' ;
//
//      $last_char_was_dash = FALSE ;
//
//      $j = strlen( $_GET['application'] ) ;
//
//      for ( $i=0 ; $i<$j ; $i++ ) {
//
//          $char = $_GET['application'][$i] ;
//
//          if ( ctype_alnum( $char ) ) {
//
//              $application_slug .= $char ;
//              $last_char_was_dash = FALSE ;
//
//          } else {
//
//              if ( $last_char_was_dash === FALSE ) {
//                  $application_slug .= '-' ;
//                  $last_char_was_dash = TRUE ;
//              }
//
//          }
//
//      }
//
//      $application_slug = trim( $application_slug , '-' ) ;
//
//      // ---------------------------------------------------------------------
//
//      $raw_application_title =
//          \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
//              $_GET['application']
//              ) ;
//
//          $application_title = <<<EOT
//  <span style="font-size:75%; line-height:150%; font-weight:normal">{$raw_application_title}</span><br />
//  EOT;
//
//      // ---------------------------------------------------------------------
//
//  } else {
//
//      // ---------------------------------------------------------------------
//
//      $application_slug = '' ;
//
//      $raw_application_title = '' ;
//
//      $application_title = '' ;
//
//      // ---------------------------------------------------------------------
//
//  }
//
//  // -------------------------------------------------------------------------
//
//  if ( trim( $application_slug ) === '' ) {
//      $application_slug = 'unknown-application' ;
//  }
//
//  // -------------------------------------------------------------------------
//
//  if ( trim( $raw_application_title ) === '' ) {
//      $raw_application_title = 'Unknown' ;
//  }
//
//  // =========================================================================
//  // CREATE the EXPORT FILE BASENAME...
//  // =========================================================================
//
//  $export_file_basename = '' ;
//
//  // -------------------------------------------------------------------------
//
//  if ( $application_slug !== '' ) {
//      $export_file_basename .= $application_slug . '-' ;
//  }
//
//  // -------------------------------------------------------------------------
//
//  $export_file_basename .= str_replace( '_' , '-' , $dataset_slug ) ;
//
//  // -------------------------------------------------------------------------
//
//  $export_date_time_for_basename = \gmdate( 'j\-M\-Y\-\a\t\-H\-i\-s\-\g\m\t' ) ;
//
//  $export_date_time_for_file     = \gmdate( 'j\ M\ Y\ \a\t\ H\:i\:s\ \G\M\T' ) ;
//
//  // -------------------------------------------------------------------------
//
//  $export_file_basename .=
//      '-exported-' .
//      $export_date_time_for_basename .
//      '.php'
//      ;
//
//  // -------------------------------------------------------------------------
//
//  $export_file_basename = strtolower( $export_file_basename ) ;
//      //  Lowercase the first letter of the month name...
//
//  // =========================================================================
//  // CREATE the EXPORT (PHP) FILE CONTENT...
//  // =========================================================================
//
//  $return_as_string = TRUE ;
//
//  $dumped_array = \var_export( $dataset_records , $return_as_string ) ;
//
//  // -------------------------------------------------------------------------
//
//  $question = '?' ;
//
//  // -------------------------------------------------------------------------
//
//      $file_content = <<<EOT
//  <{$question}php
//
//  // *****************************************************************************
//  // APPLICATION/PLUGIN:  {$raw_application_title}
//  //            DATASET:  {$dataset_title}
//  // DATE/TIME EXPORTED:  {$export_date_time_for_file}
//  //    EXPORT FILENAME:  {$export_file_basename}
//  // *****************************************************************************
//
//      \$export_import_array = {$dumped_array} ;
//
//  // =============================================================================
//  // That's that!
//  // =============================================================================\n\n
//  EOT;
//
//  // -------------------------------------------------------------------------
//
//  //echo '<pre>' , $file_content , '</pre>' ;
//
//  // =========================================================================
//  // POP up the DOWNLOAD box...
//  // =========================================================================
//
//  //  header( 'Content-Type: application/octet-stream' ) ;    //  Binary downloads
//
//  header( 'Content-Description: File Transfer' ) ;
//  header( 'Content-Type: text/plain' ) ;
//  header( 'Content-Disposition: attachment; filename=' . $export_file_basename ) ;
//  header( 'Expires: 0' ) ;
//  header( 'Cache-Control: must-revalidate' ) ;
//  header( 'Pragma: public' ) ;
//  header( 'Content-Length: ' . strlen( $file_content ) ) ;
//
//  // -------------------------------------------------------------------------
//
//  ob_clean();
//  flush();
//
//  // -------------------------------------------------------------------------
//
//  echo $file_content ;
//
//  exit;

    // =========================================================================
    // Handle FORM SUBMISSION...
    // =========================================================================

    if ( count( $_FILES ) > 0 ) {

//      handle_form_submission(
//          $core_plugapp_dirs
//          ) ;

        handle_form_submission(
            $caller_app_slash_plugins_global_namespace      ,
            $home_page_title                                ,
            $caller_apps_includes_dir                       ,
            $all_application_dataset_definitions            ,
            $dataset_slug                                   ,
            $question_front_end
            ) ;

        return ;

    }

    // =========================================================================
    // DISPLAY the "Select Raw Dataset to Import" FORM...
    // =========================================================================

    $cancel_href = stripslashes( $_SERVER['HTTP_REFERER'] ) ;

    // -------------------------------------------------------------------------

    echo <<<EOT
<div style="padding:1em 3em">

    <h2>Import Raw Dataset</h2>

    <p><b>Please select the raw dataset file you want to import.</b>&nbsp;
    Then press "Submit".</p>

    <p><i>NOTE!&nbsp; The file to import should be a PHP file that holds the
    dataset records to be imported (in a PHP array).&nbsp; A previously exported
    (and then possibly edited), raw dataset file, for example.</i></p>

    <form
        method="post"
        action=""
        name="select_raw_dataset_file_to_import"
        enctype="multipart/form-data"
        style="background-color:#F0F8FF; padding:1em"
        >

        <b>Please select the Raw Dataset PHP file to import</b>:<br />

        <input
            type="file"
            name="raw_dataset_file_to_import"
            />

        <div style="background-color:#0066CC; height:5px; margin:2em 0"></div>

        <input
            type="submit"
            value="Submit"
            />

        <input
            type="button"
            value="Cancel"
            onclick="location.href='{$cancel_href}'"
            style="margin-left:3em"
            />

    </form>

</div>

<br />
<br />
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// handle_form_submission()
// =============================================================================

function handle_form_submission(
    $caller_app_slash_plugins_global_namespace      ,
    $home_page_title                                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // handle_form_submission(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $home_page_title                                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - -
    // Handles the:-
    //      "select_raw_dataset_file_to_import"
    // form submission.
    //
    // Echos any success or error output that results.
    //
    // RETURNS
    //      Nothing
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page]          => pluginPlant
    //                  [action]        => import-raw
    //                  [application]   => picture-docs
    //                  [dataset_slug]  => rolls
    //                  )
    //
    //      $_POST = array()
    //
    //      $_FILES = array(
    //          [raw_dataset_file_to_import] => Array(
    //              [name]      =>  picture-docs-rolls-exported-21-may-2014-at-00-51-01-gmt.php
    //              [type]      =>  application/x-php
    //              [tmp_name]  =>  /tmp/phpH00vFq
    //              [error]     =>  0
    //              [size]      =>  1642
    //              )
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_GET , '$_GET' ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_POST , '$_POST' ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_FILES , '$_FILES' ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // ERROR CHECKING (1)
    // =========================================================================

    // -------------------------------------------------------------------------
    // $_FILES ?
    // -------------------------------------------------------------------------

    if ( count( $_FILES ) < 1 ) {

        $msg = <<<EOT
<br />
<br />
Please select the Raw Dataset file to upload...
<br />
<br />
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( count( $_FILES ) > 1 ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Too many files
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // raw_dataset_file_to_import ?
    // -------------------------------------------------------------------------

    $file_field_name = 'raw_dataset_file_to_import' ;

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $file_field_name , $_FILES ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "{$file_field_name}"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $_FILES[ $file_field_name ] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "{$file_field_name}" (array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // size ?
    // tmp_name ?
    //
    // NOTE!
    // =====
    // If no file is selected for upload in your form, PHP will return
    // $_FILES['userfile']['size'] as 0, and $_FILES['userfile']['tmp_name'] as
    // none.
    // -------------------------------------------------------------------------

    if (    $_FILES[ $file_field_name ]['size'] === 0
            ||
            $_FILES[ $file_field_name ]['tmp_name'] === ''
        ) {

        $msg = <<<EOT
<br />
<br />
Please select the Raw Dataset file to upload...
<br />
<br />
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------
    // error ?
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // =====
    // The "error" codes are:-
    //
    //      UPLOAD_ERR_OK
    //          Value: 0; There is no error, the file uploaded with success.
    //
    //      UPLOAD_ERR_INI_SIZE
    //          Value: 1; The uploaded file exceeds the upload_max_filesize
    //          directive in php.ini.
    //
    //      UPLOAD_ERR_FORM_SIZE
    //          Value: 2; The uploaded file exceeds the MAX_FILE_SIZE directive
    //          that was specified in the HTML form.
    //
    //      UPLOAD_ERR_PARTIAL
    //          Value: 3; The uploaded file was only partially uploaded.
    //
    //      UPLOAD_ERR_NO_FILE
    //          Value: 4; No file was uploaded.
    //
    //      UPLOAD_ERR_NO_TMP_DIR
    //          Value: 6; Missing a temporary folder. Introduced in PHP 4.3.10
    //          and PHP 5.0.3.
    //
    //      UPLOAD_ERR_CANT_WRITE
    //          Value: 7; Failed to write file to disk. Introduced in PHP 5.1.0.
    //
    //      UPLOAD_ERR_EXTENSION
    //          Value: 8; A PHP extension stopped the file upload. PHP does not
    //          provide a way to ascertain which extension caused the file
    //          upload to stop; examining the list of loaded extensions with
    //          phpinfo() may help. Introduced in PHP 5.2.0.
    //
    // Note:  These became PHP constants in PHP 4.3.0.
    // -------------------------------------------------------------------------

    if ( $_FILES[ $file_field_name ]['error'] !== 0 ) {

        $msg = <<<EOT
PROBLEM:&nbsp; File upload failure
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // Get the PHP temporary (uploads) dir and upload filespec...
    // =========================================================================

    $php_temp_filespec = $_FILES[ $file_field_name ]['tmp_name'] ;

    // -------------------------------------------------------------------------

    if ( $php_temp_filespec === '' ) {

        $msg = <<<EOT
Sorry, but we can't find the uploaded file
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // LOAD the FILE CONTENT...
    // =========================================================================

//  $uploaded_file_content = file_get_contents( $php_temp_filespec ) ;
//                              //  The function returns the read data or FALSE
//                              //  on failure.
//
//  // -------------------------------------------------------------------------
//
//  if ( $uploaded_file_content === FALSE ) {
//
//          $msg = <<<EOT
//  PROBLEM:&nbsp; File read failure
//  Detected in:&nbsp; \\{$ns}\\{$fn}()
//  EOT;
//
//      echo nl2br( $msg ) ;
//
//      return ;
//
//  }

    // =========================================================================
    // CHECK the FILE CONTENT...
    // =========================================================================

    //  TODO !!!

    // -------------------------------------------------------------------------
    //  Should be some PHP code like:-
    //
    //      $export_import_array = array(
    //          ... 0 or more records of the selected dataset...
    //          )
    //
    //  And NO other PHP code of any sort (except perhaps comments).
    //
    //  Also, we should check that (in all records):-
    //
    //      o   The dataset field SLUGS, and;
    //
    //      o   The dataset field VALUES
    //
    //   are valid for the dataset concerned.
    // -------------------------------------------------------------------------

    // =========================================================================
    // LOAD the FILE...
    // =========================================================================

    require_once( $php_temp_filespec ) ;

    // =========================================================================
    // $export_import_application ?
    // =========================================================================

    if ( ! isset( $export_import_application ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No \$export_import_application
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $export_import_application )
            ||
            trim( $export_import_application ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad \$export_import_array (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( $export_import_application !== $_GET['application'] ) {

        $msg = <<<EOT
PROBLEM:&nbsp; <b>Bad application</b> (the application the dataset being imported belongs to ("{$export_import_application}") isn't the currently selected application ("{$_GET['application']}"))
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // $export_import_dataset_slug ?
    // =========================================================================

    if ( ! isset( $export_import_dataset_slug ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No \$export_import_dataset_slug
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $export_import_dataset_slug )
            ||
            trim( $export_import_dataset_slug ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad \$export_import_dataset_slug (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( $export_import_dataset_slug !== $_GET['dataset_slug'] ) {

        $msg = <<<EOT
PROBLEM:&nbsp; <b>Bad dataset slug</b> (the dataset slug being imported ("{$export_import_dataset_slug}") doesn't match the currently selected dataset slug ("{$_GET['dataset_slug']}"))
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // =========================================================================
    // $export_import_array ?
    // =========================================================================

    if ( ! isset( $export_import_array ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No \$export_import_array
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $export_import_array ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad \$export_import_array (array expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        echo nl2br( $msg ) ;

        return ;

    }

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $export_import_array ) ;

    // =========================================================================
    // SAVE the IMPORTED dataset...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Saves the specified numerically-indexed PHP array.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    $dataset_slug          = $export_import_dataset_slug ;
    $dataset_records       = $export_import_array ;
    $question_die_on_error = FALSE ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\save_numerically_indexed(
                    $dataset_slug               ,
                    $dataset_records            ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        echo nl2br( $result ) ;
        return ;
    }

    // =========================================================================
    // Display the "SUCCESS" screen...
    // =========================================================================

    // -------------------------------------------------------------------------
    // get_home_page_url(
    //      $caller_apps_includes_dir   ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              $home_page_url STRING
    //
    //      o   On FAILURE!
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    $question_front_end = FALSE ;

    // -------------------------------------------------------------------------

    $ok_href = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_home_page_url(
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $ok_href ) ) {
        echo nl2br( $ok_href[0] ) ;
        return ;
    }

    // -------------------------------------------------------------------------

    echo <<<EOT
<br />
<br />
Dataset imported OK<br />
<br />
<a  href="{$ok_href}"
    style="text-decoration:none"
    >OK</a><br />
<br />
<br />
EOT;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


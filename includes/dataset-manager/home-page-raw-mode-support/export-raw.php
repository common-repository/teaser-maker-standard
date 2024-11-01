<?php

// *****************************************************************************
// DATASET-MANAGER / HOME-PAGE-RAW-MODE-SUPPORT / EXPORT-RAW.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// export_raw()
// =============================================================================

function export_raw(
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
    // export_raw(
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
    //                  [action]        => export-raw
    //                  [application]   => picture-docs
    //                  [dataset_slug]  => documents
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
    //                  [action]        => export-raw
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

    if ( $_GET['action'] !== 'export-raw' ) {
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

    // =========================================================================
    // Get the specified dataset's DATASET MANAGER DATASET DEFINITION...
    // =========================================================================

    $selected_datasets_dmdd = $all_application_dataset_definitions[ $dataset_slug ] ;
                                    //  dmdd = Dataset Manager Dataset Definition

    // =========================================================================
    // Get the ERROR PAGE TITLE and DATASET TITLE (for use in error messages)...
    // =========================================================================

    $error_page_title = 'Export Raw Dataset' ;

    // -------------------------------------------------------------------------

    if (    isset( $selected_datasets_dmdd['dataset_title_plural'] )
            &&
            is_string( $selected_datasets_dmdd['dataset_title_plural'] )
            &&
            trim( $selected_datasets_dmdd['dataset_title_plural'] ) !== ''
        ) {
        $dataset_title = $selected_datasets_dmdd['dataset_title_plural'] ;

    } else {
        $dataset_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                                $dataset_slug
                                ) ;

    }

    // =========================================================================
    // LOAD the DATASET RECORDS (from array storage)...
    // =========================================================================

    require_once( $caller_apps_includes_dir . '/array-storage.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Loads and returns the specified PHP numerically indexed array.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          A possibly empty PHP numerically indexed ARRAY.
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $question_die_on_error = FALSE ;

    $dataset_records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
                            $dataset_slug               ,
                            $question_die_on_error
                            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $dataset_records ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $dataset_records            ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

    // =========================================================================
    // GET the APPLICATION SLUG and TITLE...
    // =========================================================================

    if (    array_key_exists( 'application' , $_GET )
            &&
            trim( $_GET['application'] ) !== ''
        ) {

        // ---------------------------------------------------------------------

        $application_slug = '' ;

        $last_char_was_dash = FALSE ;

        $j = strlen( $_GET['application'] ) ;

        for ( $i=0 ; $i<$j ; $i++ ) {

            $char = $_GET['application'][$i] ;

            if ( ctype_alnum( $char ) ) {

                $application_slug .= $char ;
                $last_char_was_dash = FALSE ;

            } else {

                if ( $last_char_was_dash === FALSE ) {
                    $application_slug .= '-' ;
                    $last_char_was_dash = TRUE ;
                }

            }

        }

        $application_slug = trim( $application_slug , '-' ) ;

        // ---------------------------------------------------------------------

        $raw_application_title =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                $_GET['application']
                ) ;

        $application_title = <<<EOT
<span style="font-size:75%; line-height:150%; font-weight:normal">{$raw_application_title}</span><br />
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $application_slug = '' ;

        $raw_application_title = '' ;

        $application_title = '' ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( trim( $application_slug ) === '' ) {
        $application_slug = 'unknown-application' ;
    }

    // -------------------------------------------------------------------------

    if ( trim( $raw_application_title ) === '' ) {
        $raw_application_title = 'Unknown' ;
    }

    // =========================================================================
    // CREATE the EXPORT FILE BASENAME...
    // =========================================================================

    $export_file_basename = '' ;

    // -------------------------------------------------------------------------

    if ( $application_slug !== '' ) {
        $export_file_basename .= $application_slug . '-application-' ;
    }

    // -------------------------------------------------------------------------

    $export_file_basename .=
        str_replace( '_' , '-' , $dataset_slug ) .
        '-dataset-'
        ;

    // -------------------------------------------------------------------------

    $export_date_time_for_basename = \gmdate( 'j\-M\-Y\-\a\t\-H\-i\-s\-\g\m\t' ) ;

    $export_date_time_for_file     = \gmdate( 'j\ M\ Y\ \a\t\ H\:i\:s\ \G\M\T' ) ;

    // -------------------------------------------------------------------------

    $export_file_basename .=
        'exported-' .
        $export_date_time_for_basename .
        '.php'
        ;

    // -------------------------------------------------------------------------

    $export_file_basename = strtolower( $export_file_basename ) ;
        //  Lowercase the first letter of the month name...

    // =========================================================================
    // CREATE the EXPORT (PHP) FILE CONTENT...
    // =========================================================================

//  ob_start() ;
//      \print_r( $dataset_records ) ;
//  $dumped_array = ob_get_clean() ;

    $return_as_string = TRUE ;

    $dumped_array = \var_export( $dataset_records , $return_as_string ) ;

    // -------------------------------------------------------------------------

    $question = '?' ;

    // -------------------------------------------------------------------------

    $file_content = <<<EOT
<{$question}php

// *****************************************************************************
// APPLICATION/PLUGIN:  {$raw_application_title}
//            DATASET:  {$dataset_title}
// DATE/TIME EXPORTED:  {$export_date_time_for_file}
//    EXPORT FILENAME:  {$export_file_basename}
// *****************************************************************************

    \$export_import_application = '{$_GET['application']}' ;

    \$export_import_dataset_slug = '{$_GET['dataset_slug']}' ;

    \$export_import_array = {$dumped_array} ;

// =============================================================================
// That's that!
// =============================================================================\n\n
EOT;

    // -------------------------------------------------------------------------

//echo '<pre>' , $file_content , '</pre>' ;

    // =========================================================================
    // POP up the DOWNLOAD box...
    // =========================================================================

//  header( 'Content-Type: application/octet-stream' ) ;    //  Binary downloads

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

    // -------------------------------------------------------------------------

    require_once( $caller_apps_includes_dir . '/wp-admin-downloads-start.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpAdminDownloads\
    // start_string_to_file_download(
    //      $string_to_download                             ,
    //      $output_file_basename                           ,
    //      $download_screen_title                          ,
    //      $download_sub_header                            ,
    //      $return_screen_name                             ,
    //      $return_screen_url                              ,
    //      $content_type = 'application/octet-stream'
    //      )
    // - - - - - - - - - - - - - - -
    // Saves the specified string to the currently logged in user's meta
    // data.  Then redirects to the download routine proper.
    //
    // RETURNS
    //      o   On SUCCESS
    //              Doesn't return (redirects to the download routine proper)
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
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

    $return_screen_url =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_home_page_url(
            $caller_apps_includes_dir       ,
            $question_front_end
            ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $return_screen_url ) ) {

        return standard_dataset_manager_error(
                    $error_page_title           ,
                    $return_screen_url[0]       ,
                    $caller_apps_includes_dir   ,
                    $question_front_end
                    ) ;

    }

    // -------------------------------------------------------------------------

    $download_screen_title = 'Export Raw Dataset' ;

    // -------------------------------------------------------------------------

    $download_sub_header = <<<EOT
<table border="0" cellpadding="3" cellspacing="0" style="padding-left:2em">
    <tr>
        <td align="right">Application:</td>
        <td>&nbsp;</td>
        <td>{$application_title}</td>
    </tr>
    <tr>
        <td align="right">Dataset:</td>
        <td>&nbsp;</td>
        <td><b>{$dataset_title}</b></td>
    </tr>
</table>
EOT;

    // -------------------------------------------------------------------------

    $return_screen_name = 'Home' ;

    // -------------------------------------------------------------------------

    $content_type = 'text/plain' ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpAdminDownloads\start_string_to_file_download(
                    $file_content           ,
                    $export_file_basename   ,
                    $download_screen_title  ,
                    $download_sub_header    ,
                    $return_screen_name     ,
                    $return_screen_url      ,
                    $content_type
                    ) ;

    // -------------------------------------------------------------------------

    return standard_dataset_manager_error(
                $error_page_title           ,
                $result                     ,
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


<?php

// *****************************************************************************
// DATASET-MANAGER / HOME-PAGE-RAW-MODE-SUPPORT / VIEW-RAW.PHP
// (C) 2013 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// view_raw()
// =============================================================================

function view_raw(
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
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\view_raw(
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
    // Outputs a screen that displays the raw dataset data.
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
    //                  [action]        => view-raw
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
    // Get the specified dataset's DATASET MANAGER DATASET DEFINITION...
    // =========================================================================

    $selected_datasets_dmdd = $all_application_dataset_definitions[ $dataset_slug ] ;
                                    //  dmdd = Dataset Manager Dataset Definition

    // =========================================================================
    // Get the ERROR PAGE TITLE and DATASET TITLE (for use in error messages)...
    // =========================================================================

    $error_page_title = 'View Raw Dataset' ;

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
    // DISPLAY the DATASET RECORDS...
    // =========================================================================

    if (    array_key_exists( 'application' , $_GET )
            &&
            trim( $_GET['application'] ) !== ''
        ) {

        $application_title =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title(
                $_GET['application']
                ) ;

        $application_title = <<<EOT
<span style="font-size:75%; line-height:150%; font-weight:normal">{$application_title}</span><br />
EOT;

    } else {

        $application_title = '' ;

    }

    // -------------------------------------------------------------------------


    $number_records = count( $dataset_records ) ;

    $s = 's' ;

    if ( $number_records < 1 ) {
        $number_records = 'no' ;

    } elseif ( $number_records === 1 ) {
        $s = '' ;

    }

    // -------------------------------------------------------------------------

    echo <<<EOT
<h2>View Raw Dataset</h2>
<h1 style="background-color:#E0F0FF; padding:0.5em; border:1px solid #0066CC; width:96%"
    >{$application_title}{$dataset_title} &nbsp; <span style="color:#333333; font-weight:normal">({$number_records} record{$s})</span></h1>
<p><a   href="{$_SERVER['HTTP_REFERER']}"
        style="text-decoration:none; font-size:133%; font-weight:bold"
        >back</a></p>
EOT;

    // -------------------------------------------------------------------------

    if ( count( $dataset_records ) < 1 ) {

        echo <<<EOT
<p>This dataset has <b>NO RECORDS</b>.</p>
EOT;

    } else {

        echo '<div style="background-color:#F0F0F0; padding:0.25em 1em; width:96%">' ;

        pr( $dataset_records ) ;

        echo '</div>' ;

    }

    // -------------------------------------------------------------------------

    echo <<<EOT
<p><a   href="{$_SERVER['HTTP_REFERER']}"
        style="text-decoration:none; font-size:133%; font-weight:bold"
        >back</a></p>
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


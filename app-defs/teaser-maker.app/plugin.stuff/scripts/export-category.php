<?php

// *****************************************************************************
// PICTURE-DOCS.APP / PLUGIN.STUFF / SCRIPTS / EXPORT-CATEGORY.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker ;

// =============================================================================
// export_category()
// =============================================================================

function export_category(
    $caller_app_slash_plugins_global_namespace      ,
    $dataset_manager_home_page_title                ,
    $caller_plugins_includes_dir                    ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teaserMaker\
    // export_category(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $dataset_manager_home_page_title                ,
    //      $caller_plugins_includes_dir                    ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end
    //      )
    // - - - - - - - - -
    // Exports the specified teaser category (and all the teasers it contains).
    //
    // RETURNS:
    //      $page_html STRING
    //
    // NOTES!
    // ======
    // 1.   This routine returns some HTML that's either:-
    //
    //      o   An error message string (if an error occurs), or;
    //
    //      o   Some Javascript that redirects to the required post
    //          editing page.
    //
    // 2.   The returned HTML is displayed as is.  So you should do "nl2br()"
    //      BEFORE returing it, if required.
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( func_get_args() ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $_GET = Array(
    //                  [page]          => pluginPlant
    //                  [action]        => custom
    //                  [action_slug]   => export-category
    //                  [application]   => teaser-maker
    //                  [dataset_slug]  => teaser_categories
    //                  [record_key]    => 536c54824da06
    //                  )
    //
    //      $_POST = Array()
    //
    //      $_COOKIE = Array(
    //
    //                      [wordpress_f40f69ed56e8e6a6c6223ff4c2279982]
    //                          => petern|1400029911|836a747b47a9be68e842580f27433e70
    //
    //                      [wp-settings-time-1]
    //                          => 1379907093
    //
    //                      [wp-settings-1]
    //                          => mfold=t&hidetb=1&editor=html&libraryContent=browse
    //
    //                      [wc_session_cookie_f40f69ed56e8e6a6c6223ff4c2279982]
    //                          => 3DSTnbONfRZdSzD3ry4bCivwfhqRUuWa||1400029901||1400026301||aaea05f2714ca21aadba1c193db77677
    //
    //                      [wordpress_test_cookie]
    //                          => WP Cookie check
    //
    //                      [wordpress_logged_in_f40f69ed56e8e6a6c6223ff4c2279982]
    //                          => petern|1400029911|a2fc88f43402fc0412b3c01cee15edc6
    //
    //                      [woocommerce_items_in_cart]
    //                          => 1
    //
    //                      [woocommerce_cart_hash]
    //                          => 4d95884548c812cb09eb38fb6acc4a43
    //
    //                      [jobmkr_vid]
    //                          => p7N2f4J1p9L1m1C6m3K4q0D7c2K7k2C6w6B5f3W5x9O8v2E8v2X3l6I2i0P2j3U2
    //
    //                      [sm_vid]
    //                          => h2K1m1I1x0E8m2F9a1N1o5M1x4R0m9F9h3G2u7N4n7V0v7I4x2G2a0B2v9H0h4A0
    //
    //                      [__utma]
    //                          => 111872281.1800673468.1360307281.1360359420.1360369890.4
    //
    //                      [PHPSESSID]
    //                          => qo1puoud7h89fjtkvg4pnm7483
    //
    //                      [ssd_full_screen]
    //                          => 1
    //
    //                      )
    //
    // In addition, WordPress is RUNNING.
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_GET    , '$_GET'    ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_POST   , '$_POST'   ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_COOKIE , '$_COOKIE' ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // ERROR CHECKING (1)
    // =========================================================================

    // -------------------------------------------------------------------------
    // page ?
    // -------------------------------------------------------------------------

    $wordpress_admin_page_query_variable_value =
        'teaserMakerStdV0x1x114'
        ;

    // -------------------------------------------------------------------------

    if (    ! array_key_exists( 'page' , $_GET )
            ||
            ! in_array( $_GET['page'] , array( 'pluginPlant' , $wordpress_admin_page_query_variable_value ) , TRUE )
        ) {
        return '' ;
    }

    // -------------------------------------------------------------------------
    // action ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'action' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "action"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( $_GET['action'] !== 'custom' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "action"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // action_slug ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'action_slug' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "action_slug"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( $_GET['action_slug'] !== 'export-category' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "action_slug"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // application ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'application' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "application"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( $_GET['application'] !== 'teaser-maker' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "application"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // dataset_slug ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'dataset_slug' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "dataset_slug"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( $_GET['dataset_slug'] !== 'teaser_categories' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // record_key ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'record_key' , $_GET ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "record_key"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // =========================================================================
    // Get the CORE PLUGAPP DIRS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\
    // get_core_plugapp_dirs(
    //      $path_in_plugin         ,
    //      $app_handle = NULL
    //      )
    // - - - - - - - - - - - - - - -
    // Returns the dirspecs of the main dirs used in a given app.  Ie:-
    //
    //      array(
    //          'plugin_root_dir'                   =>  "xxx"   ,
    //          'plugins_includes_dir'              =>  "xxx"   ,
    //          'plugins_app_defs_dir'              =>  "xxx"   ,
    //          'dataset_manager_includes_dir'      =>  "xxx"   ,   //  (1)
    //          'apps_dot_app_dir'                  =>  "xxx"   ,   //  (2)
    //          'apps_plugin_stuff_dir'             =>  "xxx"       //  (3)
    //          )
    //
    //      (1) This is where most of the "Dataset Manager" includes files
    //          are stored.
    //
    //      (2) If $app_handle === NULL, the returned $apps_dot_app_dir
    //          is NULL too.
    //
    //      (3) If $app_handle === NULL, the returned $apps_plugin_stuff_dir
    //          is NULL too.
    //
    // ---
    //
    // $path_in_plugin should be a file, directory or link path in the
    // plugin (or "app") from which this function is called.  Typically,
    // one uses __FILE__ for this purpose.  Eg:-
    //
    //      \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_single_app_defs_root_dir( __FILE__ ) ;
    //
    // ---
    //
    // $app_handle should be either:-
    //
    //      o   A single "app slug" - eg; "research-assistant" - as a
    //          STRING.  For which the returned dirspec might be (eg):-
    //
    //              /home/joe/.../plugins/some-plugin/app-defs/research-assistant.app
    //
    // Or:-
    //
    //      o   An array of (nested) app slugs.  Eg:-
    //
    //              array(
    //                  'some-app'          ,
    //                  'child-app'         ,
    //                  'grandchild-app'
    //                  [...]
    //                  )
    //
    //          For which the returned dirspec might be (eg):-
    //
    //              /home/joe/.../plugins/some-plugin/app-defs/some-app.app/child-app.app/grandchild-app.app
    //
    // Exits with an error message if the directory can't be returned (eg;
    // doesn't exist).
    //
    // NOTE!
    // -----
    // These "apps" and "datasets" (etc) are typically defined in a directory
    // tree structure like (eg):-
    //
    //      /plugins/this-plugin/
    //      +-- app-defs/
    //      |   +-- some-app.app/
    //      |   |   +-- child-app.app/
    //      |   |       +-- grandchild-app.app
    //      |   |           +-- etc...
    //      |   +-- another-app.app/
    //      |       +-- ...
    //      +-- includes/
    //      +-- js/
    //      +-- admin/
    //      +-- remote/
    //      +-- ...etc...
    //      +-- this-plugin.php
    //      +-- ...etc...
    //
    // -------------------------------------------------------------------------

    $path_in_plugin = __FILE__       ;
    $app_handle     = 'teaser-maker' ;

    // -------------------------------------------------------------------------

    $core_plugapp_dirs =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
            $path_in_plugin     ,
            $app_handle
            ) ;

    // =========================================================================
    // ERROR CHECKING (2)
    // =========================================================================

    // -------------------------------------------------------------------------
    // record_key ?
    // -------------------------------------------------------------------------

//  require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/record-key-support.php' ) ;

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

    if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_record_key(
            $_GET['record_key']
            )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "record_key"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // -------------------------------------------------------------------------
    // $dataset_slug ?
    // -------------------------------------------------------------------------

    if ( $dataset_slug !== 'teaser_categories' ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Unexpected "dataset_slug" variable ("teaser_categories" expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // =========================================================================
    // LOAD the application's DATASETS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // load_applications_datasets(
    //      $all_application_dataset_definitions    ,
    //      $core_plugapp_dirs                      ,
    //      &$loaded_datasets = array()
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Makes sure that (on return):-
    //      $loaded_datasets
    // contains the title, records, key field slug and record indices by key
    // of all the datasets defined in:-
    //      $all_application_dataset_definitions
    //
    // In other words:-
    //
    //      o   Those datasets already in both:-
    //              $all_application_dataset_definitions, and;
    //              $loaded_datasets
    //          are ignored (their existing data is left as is).
    //
    // But:-
    //
    //      o   Those datasets in:-
    //              $all_application_dataset_definitions
    //          but not yet in:-
    //              $loaded_datasets
    //          are added to:-
    //              $loaded_datasets
    //
    // NOTE!
    // =====
    // The input $loaded_datasets must be either:-
    //      o   The empty array, or;
    //      o   An array like:-
    //              $loaded_datasets = array(
    //                  '<this_dataset_slug>'   => array(
    //                      'title'                     =>  "xxx"           ,
    //                      'records'                   =>  array(...)      ,
    //                      'key_field_slug'            =>  "yyy"           ,
    //                      'record_indices_by_key'     =>  array(...)
    //                      )
    //                  ...
    //                  )
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $loaded_datasets = array() ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_applications_datasets(
                    $all_application_dataset_definitions    ,
                    $core_plugapp_dirs                      ,
                    $loaded_datasets
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return nl2br( $result ) ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $loaded_datasets = Array(
    //
    //          [teaser_categories] => Array(
    //
    //              [title]                 => Teaser Categories
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1401092315
    //                      [last_modified_server_datetime_UTC] => 1401156133
    //                      [key]                               => 5382f8db5d0c1
    //                      [parent_key]                        =>
    //                      [title]                             => Sample Teaser Page
    //                      [description]                       => PHA+QW4gZ...wPg0K
    //                      [description_format]                => none
    //                      [image_url]                         =>
    //                      [sequence_number]                   =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [53365e603cdab] => 0
    //                  [53365e77656c4] => 1
    //                  ...
    //                  [5382f8db5d0c1] => 7
    //                  )
    //
    //              )
    //
    //          [teaser_layouts] => Array(
    //
    //              [title]                 => Teaser Layouts
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1398761346
    //                      [last_modified_server_datetime_UTC] => 1398761376
    //                      [key]                               => 535f6782aa913
    //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
    //                      [slug]                              => p-and-h-tags-floated-image-copy-1
    //                      [container_html]                    => WyoqVEVB2Rpdj4=
    //                      [title_html]                        => PGRpdiBPC9kaXY+
    //                      [text_html]                         => PGRpdiBjRpdj4=
    //                      [image_html]                        => PGRpdiBkaXY+
    //                      [read_more_html]                    => PGRpdi9kaXY+
    //                      [date_html]                         => PGRpdiBj9kaXY+
    //                      [spacer_html]                       =>
    //                      [description]                       =>
    //                      [image_url]                         =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [535f6782aa913] => 0
    //                  )
    //
    //              )
    //
    //          [teaser_scripts] => Array(
    //
    //              [title]                 => Teaser Scripts
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1398761346
    //                      [last_modified_server_datetime_UTC] => 1398761456
    //                      [key]                               => 535f6782aa9a0
    //                      [layout_key]                        => 535f6782aa913
    //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
    //                      [slug]                              => p-and-h-tags-floated-image-copy-1-scripts
    //                      [container_js]                      =>
    //                      [title_js]                          =>
    //                      [text_js]                           =>
    //                      [image_js]                          =>
    //                      [read_more_js]                      =>
    //                      [date_js]                           =>
    //                      [spacer_js]                         =>
    //                      [description]                       =>
    //                      [image_url]                         =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [535f6782aa9a0] => 0
    //                  )
    //
    //              )
    //
    //          [teasers] => Array(
    //
    //              [title]                 => Teasers
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1396257849
    //                      [last_modified_server_datetime_UTC] => 1401092342
    //                      [key]                               => 53393439b8b82
    //                      [parent_key]                        => 5382f8db5d0c1
    //                      [original_url]                      => http://www.rookiemag.com/2014/02/postcards-from-wonderland/
    //                      [original_title]                    => Postcards From Wonderland
    //                      [original_clipped_text]             => TXkgY1c2UuLi4=
    //                      [text_format]                       => none
    //                      [original_media_url]                => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                      [sequence_number]                   => 10
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [53393439b8b82] => 0
    //                  ...
    //                  )
    //
    //              )
    //
    //          [teaser_settings] => Array(
    //
    //              [title]                 => Teaser Settings
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1397021148
    //                      [last_modified_server_datetime_UTC] => 1399513570
    //                      [key]                               => 5344d9dc6dfb1
    //                      [selected_layout_slug]              => custom
    //                      [custom_layout_key]                 => 535f6782aa913
    //                      [custom_style_key]                  => 535f6782aa95b
    //                      [custom_scripts_key]                => 535f6782aa9a0
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [5344d9dc6dfb1] => 0
    //                  )
    //
    //              )
    //
    //          [teaser_styles] => Array(
    //
    //              [title]                 => Teaser Styles
    //
    //              [records]               => Array(
    //                  [0] => Array(
    //                      [created_server_datetime_UTC]       => 1398761346
    //                      [last_modified_server_datetime_UTC] => 1398761433
    //                      [key]                               => 535f6782aa95b
    //                      [layout_key]                        => 535f6782aa913
    //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
    //                      [slug]                              => p-and-h-tags-floated-image-copy-1-styles
    //                      [container_css]                     => RElWLDsNCn0=
    //                      [title_css]                         => RElWLaWw0KfQ==
    //                      [text_css]                          => RElWLLjVlbTsNCn0=
    //                      [image_css]                         => RElWLw0KfQ==
    //                      [read_more_css]                     => RElWMDsNCn0=
    //                      [date_css]                          => RElWLDQp9
    //                      [spacer_css]                        =>
    //                      [description]                       =>
    //                      [image_url]                         =>
    //                      )
    //                  ...
    //                  )
    //
    //              [key_field_slug]        => key
    //
    //              [record_indices_by_key] => Array(
    //                  [535f6782aa95b] => 0
    //                  )
    //
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $loaded_datasets ) ;

    // =========================================================================
    // ERROR CHECKING (3)
    // =========================================================================

    if ( ! array_key_exists(
            $_GET['record_key']                                         ,
            $loaded_datasets['teaser_categories']['record_indices_by_key']
            )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "record_key" (no such teaser category)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // =========================================================================
    // EXTRACT the TEASER CATEGORY's records...
    // =========================================================================

    $records_to_export = array() ;

    // -------------------------------------------------------------------------
    // TEASER CATEGORY record...
    // -------------------------------------------------------------------------

    $requested_teaser_category_record =
        $loaded_datasets['teaser_categories']['records'][
            $loaded_datasets['teaser_categories']['record_indices_by_key'][
                $_GET['record_key']
                ]
            ] ;

    // -------------------------------------------------------------------------

    $records_to_export['teaser_categories'] = array(
        $requested_teaser_category_record
        ) ;

    // -------------------------------------------------------------------------
    // TEASER records...
    // -------------------------------------------------------------------------

    $records_to_export['teasers'] = array() ;

    // -------------------------------------------------------------------------

    foreach ( $loaded_datasets['teasers']['records'] as $this_teaser_record ) {

        // ---------------------------------------------------------------------

        if ( $this_teaser_record['parent_key'] === $_GET['record_key'] ) {
            $records_to_export['teasers'][] = $this_teaser_record ;
        }

        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $records_to_export ) ;

    // =========================================================================
    // ADD in the TEASER IMAGES...
    // =========================================================================

    // -------------------------------------------------------------------------
    // get_teaser_images(
    //      $core_plugapp_dirs                      ,
    //      $all_application_dataset_definitions    ,
    //      $question_front_end                     ,
    //      $records_to_export
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              $teaser_images ARRAY
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $teaser_images = get_teaser_images(
                        $core_plugapp_dirs                      ,
                        $all_application_dataset_definitions    ,
                        $question_front_end                     ,
                        $records_to_export
                        ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $teaser_images ) ) {
        return nl2br( $teaser_images ) ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_images = Array(
    //
    //          [0] => Array(
    //                      [url]       => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                      [copy_type] => by-reference
    //                      )
    //
    //          [1] => Array(
    //                      [url]       => http://static.rookiemag.com/2014/02/13912724721february2014background.jpg
    //                      [copy_type] => by-reference
    //                      )
    //
    //          [2] => Array(
    //                      [url]       => http://www.mermaidchapel.com/wp-content/uploads/2014/03/birthofvenus.jpg
    //                      [copy_type] => by-reference
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_images ) ;

    // =========================================================================
    // Get the EXPORT FILE'S BASENAME...
    // =========================================================================

    if (    array_key_exists( 'title' , $requested_teaser_category_record )
            &&
            is_string( $requested_teaser_category_record['title'] )
            &&
            trim( $requested_teaser_category_record['title'] ) !== ''
            &&
            strlen( $requested_teaser_category_record['title'] ) < 128
        ) {

        // ---------------------------------------------------------------------

        $dirty_teaser_category_title =
            strtolower(
                strip_tags(
                    trim( $requested_teaser_category_record['title'] )
                    )
                ) ;

        // ---------------------------------------------------------------------

        $j = strlen( $dirty_teaser_category_title ) ;

        $last_char_was_dash = FALSE ;

        $export_file_basename = '' ;

        // ---------------------------------------------------------------------

        for ( $i=0 ; $i<$j ; $i++ ) {

            $char = $dirty_teaser_category_title[ $i ] ;

            if ( ctype_alnum( $char ) ) {
                $export_file_basename .= $char ;
                $last_char_was_dash = FALSE ;

            } else {
                if ( $last_char_was_dash === FALSE ) {
                    $export_file_basename .= '-' ;
                    $last_char_was_dash = TRUE ;
                }

            }

        }

        // ---------------------------------------------------------------------

        $export_file_basename = trim( $export_file_basename , '-' ) ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $export_file_basename = '' ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( $export_file_basename === '' ) {

        $export_file_basename = 'unknown-teaser-category' ;

    }

    // -------------------------------------------------------------------------

    $export_file_basename .=
        '-exported-' .
        \gmdate( 'j\-M\-Y\-\a\t\-H\-i\-s\-\g\m\t' ) .
        '.dat'
        ;


    // -------------------------------------------------------------------------

    $export_file_basename = strtolower( $export_file_basename ) ;
        //  Lowercase the first letter of the month name...

    // =========================================================================
    // Construct the OUTPUT array...
    // =========================================================================

    $output = array(

                    'instance_data'             =>  array(
                                                        'export_file_basename'  =>  $export_file_basename   ,
                                                        'export_datetime_UTC'   =>  time()
                                                        )                   ,

                    'teaser_category_records'   =>  $records_to_export      ,

                    'teaser_images'             =>  $teaser_images

                    ) ;

    // =========================================================================
    // SERIALISE the OUTPUT...
    // =========================================================================

    // -------------------------------------------------------------------------
    // string serialize ( mixed $value )
    // - - - - - - - - - - - - - - - - -
    // Generates a storable representation of a value.
    //
    // This is useful for storing or passing PHP values around without losing
    // their type and structure.
    //
    // To make the serialized string into a PHP value again, use unserialize().
    //
    //      value
    //          The value to be serialized. serialize() handles all types,
    //          except the resource-type. You can even serialize() arrays that
    //          contain references to itself. Circular references inside the
    //          array/object you are serializing will also be stored. Any other
    //          reference will be lost.
    //
    //          When serializing objects, PHP will attempt to call the member
    //          function __sleep() prior to serialization. This is to allow the
    //          object to do any last minute clean-up, etc. prior to being
    //          serialized. Likewise, when the object is restored using
    //          unserialize() the __wakeup() member function is called.
    //
    //          Note:
    //
    //          Object's private members have the class name prepended to the
    //          member name; protected members have a '*' prepended to the
    //          member name. These prepended values have null bytes on either
    //          side.
    //
    // Returns a string containing a byte-stream representation of value that
    // can be stored anywhere.
    //
    // Note that this is a binary string which may include null bytes, and needs
    // to be stored and handled as such. For example, serialize() output should
    // generally be stored in a BLOB field in a database, rather than a CHAR or
    // TEXT field.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    $output = serialize( $output ) ;

    // =========================================================================
    // BASE64 ENCODE the output...
    // =========================================================================

    // -------------------------------------------------------------------------
    // string base64_encode ( string $data )
    // - - - - - - - - - - - - - - - - - - -
    // Encodes the given data with base64.
    //
    // This encoding is designed to make binary data survive transport through
    // transport layers that are not 8-bit clean, such as mail bodies.
    //
    // Base64-encoded data takes about 33% more space than the original data.
    //
    //      data
    //          The data to encode.
    //
    // RETURN VALUES
    // The encoded data, as a string or FALSE on failure.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    $output = base64_encode( $output ) ;

    // -------------------------------------------------------------------------

    if ( $output === FALSE ) {

        $msg = <<<EOT
PROBLEM:&nbsp; base64_encode()" failure creating export file
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // =========================================================================
    // START the DOWNLOAD
    // =========================================================================

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/wp-admin-downloads-start.php' ) ;

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

    require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/get-dataset-urls.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_manage_dataset_url(
    //      $caller_apps_includes_dir   ,
    //      $question_front_end         ,
    //      $dataset_slug = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the "manage-dataset" URL.
    //
    // If $dataset_slug is NULL, then we use:-
    //      $_GET['dataset_slug']
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          STRING $url
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    $return_screen_url =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_manage_dataset_url(
            $caller_plugins_includes_dir    ,
            $question_front_end             ,
            $dataset_slug
            ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $return_screen_url ) ) {
        return nl2br( $return_screen_url[0] ) ;
    }

    // -------------------------------------------------------------------------

    $download_screen_title = 'Download Teaser Category' ;

    // -------------------------------------------------------------------------

    $teaser_category_title =
        strip_tags(
            trim( $requested_teaser_category_record['title'] )
            ) ;

    // -------------------------------------------------------------------------

    if ( $teaser_category_title === '' ) {
        $download_sub_header = '' ;

    } else {
        $download_sub_header = <<<EOT
<p style="padding-left:2em">Teaser Category:&nbsp; <b>{$teaser_category_title}</b></p>
EOT;

    }

    // -------------------------------------------------------------------------

    $return_screen_name = 'Manage Teaser Categories' ;

    // -------------------------------------------------------------------------

    $content_type = 'application/octet-stream' ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_wpAdminDownloads\start_string_to_file_download(
                    $output                 ,
                    $export_file_basename   ,
                    $download_screen_title  ,
                    $download_sub_header    ,
                    $return_screen_name     ,
                    $return_screen_url      ,
                    $content_type
                    ) ;

    // -------------------------------------------------------------------------

    return nl2br( $result ) ;

    // =========================================================================
    // POP up the DOWNLOAD box...
    // =========================================================================

//  header( 'Content-Description: File Transfer' ) ;
//  header( 'Content-Type: application/octet-stream' ) ;
//  header( 'Content-Disposition: attachment; filename=' . $export_file_basename ) ;
//  header( 'Expires: 0' ) ;
//  header( 'Cache-Control: must-revalidate' ) ;
//  header( 'Pragma: public' ) ;
//  header( 'Content-Length: ' . strlen( $output ) ) ;
//
//  // -------------------------------------------------------------------------
//
//  ob_clean();
//  flush();
//
//  // -------------------------------------------------------------------------
//
//  echo $output ;
//
//  exit;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_teaser_images()
// =============================================================================

function get_teaser_images(
    $core_plugapp_dirs                      ,
    $all_application_dataset_definitions    ,
    $question_front_end                     ,
    $records_to_export
    ) {

    // -------------------------------------------------------------------------
    // get_teaser_images(
    //      $core_plugapp_dirs                      ,
    //      $all_application_dataset_definitions    ,
    //      $question_front_end                     ,
    //      $records_to_export
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              $teaser_images ARRAY
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $records_to_export = Array(
    //
    //          [teaser_categories] => Array(
    //              [0] => Array(
    //                  [created_server_datetime_UTC]       => 1401092315
    //                  [last_modified_server_datetime_UTC] => 1401156133
    //                  [key]                               => 5382f8db5d0c1
    //                  [parent_key]                        =>
    //                  [title]                             => Sample Teaser Page
    //                  [description]                       => PHA+QW9wPg0K
    //                  [description_format]                => none
    //                  [image_url]                         =>
    //                  [sequence_number]                   =>
    //                  )
    //              )
    //
    //          [teasers] => Array(
    //              [0] => Array(
    //                  [created_server_datetime_UTC]       => 1396257849
    //                  [last_modified_server_datetime_UTC] => 1401092342
    //                  [key]                               => 53393439b8b82
    //                  [parent_key]                        => 5382f8db5d0c1
    //                  [original_url]                      => http://www.rookiemag.com/2014/02/postcards-from-wonderland/
    //                  [original_title]                    => Postcards From Wonderland
    //                  [original_clipped_text]             => TXkgYBjbHViaG91c2UuLi4=
    //                  [text_format]                       => none
    //                  [original_media_url]                => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //                  [sequence_number]                   => 10
    //                  )
    //              ...
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $records_to_export ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    $teaser_images = array() ;

    // =========================================================================
    // LOOP over the TEASERS - and add each (unique) image to the TEASER IMAGES
    // array (adding the URLs only, at this stage)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // mixed pathinfo ( string $path [, int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // pathinfo() returns information about path: either an associative array or
    // a string, depending on options.
    //
    //      path
    //          The path to be parsed.
    //
    //      options
    //          If present, specifies a specific element to be returned; one of
    //          PATHINFO_DIRNAME, PATHINFO_BASENAME, PATHINFO_EXTENSION or
    //          PATHINFO_FILENAME.
    //
    //          If options is not specified, returns all available elements.
    //
    // If the options parameter is not passed, an associative array containing
    // the following elements is returned:
    //      o   dirname,
    //      o   basename,
    //      o   extension (if any), and;
    //      o   filename.
    //
    //      Note:   If the path has more than one extension, PATHINFO_EXTENSION
    //              returns only the last one and PATHINFO_FILENAME only strips
    //              the last one. (see first example below).
    //
    //      Note:   If the path does not have an extension, no extension element
    //              will be returned (see second example below).
    //
    // If options is present, returns a string containing the requested element.
    //
    // (PHP 4 >= 4.0.3, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.2.0       The PATHINFO_FILENAME constant was added.
    // -------------------------------------------------------------------------

    $teaser_image_urls_already_found = array() ;

    // -------------------------------------------------------------------------

    $allowed_extensions = array(
        'gif'       ,
        'png'       ,
        'jpeg'      ,
        'jpg'       ,
        'jpe'
        ) ;

    // -------------------------------------------------------------------------

    foreach ( $records_to_export['teasers'] as $this_teaser_record_index => $this_teaser_record ) {

        // ---------------------------------------------------------------------
        // Skip teasers with NO image...
        // ---------------------------------------------------------------------

        if (    ! array_key_exists( 'original_media_url' , $this_teaser_record )
                ||
                ! is_string( $this_teaser_record['original_media_url'] )
                ||
                trim( $this_teaser_record['original_media_url'] ) === ''
            ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // Skip images that have already been added to the teaser images
        // array...
        // ---------------------------------------------------------------------

        if ( in_array(
                $this_teaser_record['original_media_url']   ,
                $teaser_image_urls_already_found            ,
                TRUE
                )
            ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // Skip media that's NOT:-
        //      o   gif
        //      o   png
        //      o   jpeg,
        //      o   jpg
        //      o   jpe
        //
        // (at least as far as the extension is concerned)...
        // ---------------------------------------------------------------------

        $ext = \pathinfo( $this_teaser_record['original_media_url'] , PATHINFO_EXTENSION ) ;

        // ---------------------------------------------------------------------

        if ( ! in_array( \strtolower( $ext ) , $allowed_extensions , TRUE ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------
        // Append the image to the teaser images array...
        // ---------------------------------------------------------------------

        $teaser_images[] = array(
                                'url'   =>  $this_teaser_record['original_media_url']
                                ) ;

        // ---------------------------------------------------------------------
        // Repeat with the next teaser (if there is one)...
        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_images ) ;

    // =========================================================================
    // Get the SOURCE site's DOMAIN NAME...
    //
    // NOTE!
    // =====
    // The source site is the site the Teaser Category is being exported
    // FROM.
    // =========================================================================

    // -------------------------------------------------------------------------
    // get_site_url( $blog_id, $path, $scheme )
    // - - - - - - - - - - - - - - - - - - - -
    // The get_site_url() template tag retrieves the site url for a given site.
    //
    // Returns the 'siteurl' option with the appropriate protocol, 'https' if
    // is_ssl() and 'http' otherwise. If $scheme is 'http' or 'https', is_ssl()
    // is overridden.
    //
    //      $blog_id
    //          (integer) (optional) Blog ID.
    //          Default: current blog
    //
    //      $path
    //          (string) (optional) Path relative to the site url.
    //          Default: None
    //
    //      $scheme
    //          (string) (optional) Scheme to give the site url context.
    //          Currently 'http', 'https', 'login', 'login_post', 'admin' or
    //          'relative'.
    //          Default: null
    //
    // RETURNS
    //
    //      (string)
    //          Site url link with optional path appended.
    //
    // EXAMPLES
    //
    //      echo get_site_url() ;
    //
    //          Results in the full site URL being displayed.  Eg:-
    //              http://www.example.com
    //
    // CHANGELOG
    //      Since: 3.0
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // get_home_url( $blog_id, $path, $scheme )
    // - - - - - - - - - - - - - - - - - - - -
    // The get_home_url template tag retrieves the home url for a given site.
    //
    //  Returns the 'home' option with the appropriate protocol, 'https' if
    //  is_ssl() and 'http' otherwise. If scheme is 'http' or 'https', is_ssl()
    //  is overridden.
    //
    //      $blog_id
    //          (integer) (optional) Blog ID.
    //          Default: null (the current blog)
    //
    //      $path
    //          (string) (optional) Path relative to the home url.
    //          Default: None
    //
    //      $scheme
    //          (string) (optional) Scheme to give the home url context.
    //          Currently 'http', 'https' and 'relative'.
    //          Default: null
    //
    // RETURNS
    //
    //      (string) Home url link with optional path appended.
    //
    // CHANGELOG
    //      Since: 3.0.0
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // get_site_url() vs. get_home_url()
    //
    // See:-
    //      http://wordpress.stackexchange.com/questions/20294/whats-the-difference-between-home-url-and-site-url
    //
    // Eg:-
    //
    //      "The site_url() and home_url() functions are similar and can lead to
    //      confusion in how they work. The site_url() function retrieves the
    //      value as set in the wp_options table value for siteurl in your
    //      database. This is the URL to the WordPress core files. If your core
    //      files exist in a subdirectory /wordpress on your web server, the
    //      value would be http://example.com/wordpress. The home_url() function
    //      retrieves the value for home in the wp_options table. This is the
    //      address you want people to visit to view your WordPress web site. If
    //      your WordPress core files exist in /wordpress, but you want your web
    //      site URL to be http://example.com the home value should be
    //      http://example.com."
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // mixed parse_url ( string $url [, int $component = -1 ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // This function parses a URL and returns an associative array containing
    // any of the various components of the URL that are present.
    //
    // This function is not meant to validate the given URL, it only breaks it
    // up into the above listed parts. Partial URLs are also accepted,
    // parse_url() tries its best to parse them correctly.
    //
    //      url
    //          The URL to parse. Invalid characters are replaced by _.
    //
    //      component
    //          Specify one of PHP_URL_SCHEME, PHP_URL_HOST, PHP_URL_PORT,
    //          PHP_URL_USER, PHP_URL_PASS, PHP_URL_PATH, PHP_URL_QUERY or
    //          PHP_URL_FRAGMENT to retrieve just a specific URL component as a
    //          string (except when PHP_URL_PORT is given, in which case the
    //          return value will be an integer).
    //
    // On seriously malformed URLs, parse_url() may return FALSE.
    //
    // If the component parameter is omitted, an associative array is returned.
    // At least one element will be present within the array. Potential keys
    // within this array are:
    //
    //      scheme - e.g. http
    //      host
    //      port
    //      user
    //      pass
    //      path
    //      query - after the question mark ?
    //      fragment - after the hashmark #
    //
    // If the component parameter is specified, parse_url() returns a string (or
    // an integer, in the case of PHP_URL_PORT) instead of an array. If the
    // requested component doesn't exist within the given URL, NULL will be
    // returned.
    //
    // (PHP 4, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.4.7       Fixed host recognition when scheme is omitted and a leading component separator is present.
    //      5.3.3       Removed the E_WARNING that was emitted when URL parsing failed.
    //      5.1.2       Added the component parameter.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // site domain ?
    // -------------------------------------------------------------------------

    $site_url = \get_site_url() ;

    // -------------------------------------------------------------------------

    $site_domain = parse_url( $site_url , PHP_URL_HOST ) ;

    // -------------------------------------------------------------------------

    if (    ! is_string( $site_domain )
            ||
            trim( $site_domain ) === ''
        ) {

        return <<<EOT
PROBLEM:&nbsp; Can't find site's domain name
Site URL:&nbsp; {$site_url}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // home domain ?
    // -------------------------------------------------------------------------

    $home_url = \get_home_url() ;

    // -------------------------------------------------------------------------

    $home_domain = parse_url( $home_url , PHP_URL_HOST ) ;

    // -------------------------------------------------------------------------

    if (    ! is_string( $home_domain )
            ||
            trim( $home_domain ) === ''
        ) {

        return <<<EOT
PROBLEM:&nbsp; Can't find site's "home" domain name
Home URL:&nbsp; {$home_url}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------
    // source domain ?
    // -------------------------------------------------------------------------

    if ( $site_domain !== $home_domain ) {

        return <<<EOT
PROBLEM:&nbsp; Domain name mismatch ("get_site_url()" vs. "get_home_url()")
Site URL:&nbsp; {$site_url}
Home URL:&nbsp; {$home_url}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    $source_domain = $site_domain ;

    // =========================================================================
    // Support Routines...
    // =========================================================================

    // -------------------------------------------------------------------------
    // array getimagesize ( string $filename [, array &$imageinfo ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // The getimagesize() function will determine the size of any given image
    // file and return the dimensions along with the file type and a
    // height/width text string to be used inside a normal HTML IMG tag and the
    // correspondant HTTP content type.
    //
    // getimagesize() can also return some more information in imageinfo
    // parameter.
    //
    // Note:    Note that JPC and JP2 are capable of having components with
    //          different bit depths. In this case, the value for "bits" is the
    //          highest bit depth encountered. Also, JP2 files may contain
    //          multiple JPEG 2000 codestreams. In this case, getimagesize()
    //          returns the values for the first codestream it encounters in the
    //          root of the file.
    //
    // Note:    The information about icons are retrieved from the icon with the
    //          highest bitrate.
    //
    //      filename
    //          This parameter specifies the file you wish to retrieve
    //          information about. It can reference a local file or
    //          (configuration permitting) a remote file using one of the
    //          supported streams.
    //
    //      imageinfo
    //          This optional parameter allows you to extract some extended
    //          information from the image file. Currently, this will return the
    //          different JPG APP markers as an associative array. Some programs
    //          use these APP markers to embed text information in images. A
    //          very common one is to embed » IPTC information in the APP13
    //          marker. You can use the iptcparse() function to parse the binary
    //          APP13 marker into something readable.
    //
    // Returns an array with up to 7 elements. Not all image types will include
    // the channels and bits elements.
    //
    //      o   Index 0 and 1 contains respectively the width and the height of
    //          the image.
    //
    //          Note:   Some formats may contain no image or may contain
    //                  multiple images. In these cases, getimagesize() might
    //                  not be able to properly determine the image size.
    //                  getimagesize() will return zero for width and height in
    //                  these cases.
    //
    //      o   Index 2 is one of the IMAGETYPE_XXX constants indicating the
    //          type of the image.
    //
    //      o   Index 3 is a text string with the correct height="yyy"
    //          width="xxx" string that can be used directly in an IMG tag.
    //
    //      o   mime is the correspondant MIME type of the image. This
    //          information can be used to deliver images with the correct HTTP
    //          Content-type header
    //
    //      o   channels will be 3 for RGB pictures and 4 for CMYK pictures.
    //
    //      o   bits is the number of bits for each color.
    //
    // For some image types, the presence of channels and bits values can be a
    // bit confusing. As an example, GIF always uses 3 channels per pixel, but
    // the number of bits per pixel cannot be calculated for an animated GIF
    // with a global color table.
    //
    // On failure, FALSE is returned.
    //
    // ERRORS/EXCEPTIONS
    //      If accessing the filename image is impossible getimagesize() will
    //      generate an error of level E_WARNING. On read error, getimagesize()
    //      will generate an error of level E_NOTICE.
    //
    // (PHP 4, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.3.0       Added icon support.
    //      5.2.3       Read errors generated by this function downgraded to E_NOTICE from E_WARNING.
    //      4.3.2       Support for JPC, JP2, JPX, JB2, XBM, and WBMP became available.
    //      4.3.2       JPEG 2000 support was added for the imageinfo parameter.
    //      4.3.0       bits and channels are present for other image types, too.
    //      4.3.0       mime was added.
    //      4.3.0       Support for SWC and IFF was added.
    //      4.2.0       Support for TIFF was added.
    //      4.0.6       Support for BMP and PSD was added.
    //      4.0.5       URL support was added.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // string md5_file ( string $filename [, bool $raw_output = false ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Calculates the MD5 hash of the file specified by the filename parameter
    // using the » RSA Data Security, Inc. MD5 Message-Digest Algorithm, and
    // returns that hash. The hash is a 32-character hexadecimal number.
    //
    //      filename
    //          The filename
    //
    //      raw_output
    //          When TRUE, returns the digest in raw binary format with a length
    //          of 16.
    //
    // Returns a string on success, FALSE otherwise.
    //
    // (PHP 4 >= 4.2.0, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.1.0       Changed the function to use the streams API. It means
    //                  that you can use it with wrappers, like
    //                  md5_file('http://example.com/..')
    //      5.0.0       Added the raw_output parameter
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // string sha1_file ( string $filename [, bool $raw_output = false ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Calculates the sha1 hash of the file specified by filename using the »
    // US Secure Hash Algorithm 1, and returns that hash. The hash is a
    // 40-character hexadecimal number.
    //
    //      filename
    //          The filename of the file to hash.
    //
    //      raw_output
    //          When TRUE, returns the digest in raw binary format with a length
    //          of 20.
    //
    // Returns a string on success, FALSE otherwise.
    //
    // (PHP 4 >= 4.3.0, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      5.1.0       Changed the function to use the streams API. It means
    //                  that you can use it with wrappers, like
    //                  sha1_file('http://example.com/..')
    //      5.0.0       Added the raw_output parameter
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // int filesize ( string $filename )
    // - - - - - - - - - - - - - - - - -
    // Gets the size for the given file.
    //
    //      filename
    //          Path to the file.
    //
    // Returns the size of the file in bytes, or FALSE (and generates an error
    // of level E_WARNING) in case of an error.
    //
    // Note:    Because PHP's integer type is signed and many platforms use
    //          32bit integers, some filesystem functions may return unexpected
    //          results for files which are larger than 2GB.
    //
    // (PHP 4, PHP 5)
    //
    // ERRORS/EXCEPTIONS
    //      Upon failure, an E_WARNING is emitted.
    //
    // Notes:   The results of this function are cached. See clearstatcache()
    //          for more details.
    //
    // Tip: As of PHP 5.0.0, this function can also be used with some URL
    //      wrappers. Refer to Supported Protocols and Wrappers to determine
    //      which wrappers support stat() family of functionality.
    // -------------------------------------------------------------------------

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/path-utils.php' ) ;

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\
    // wp_url2path(
    //      $url
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   $pathspec on SUCCESS
    //      o   array( $error_message ) on FAILURE
    // -----------------------------------------------------------------------

    // =========================================================================
    // LOOP over the TEASER IMAGES that were found - to determine which should
    // be physically copied into the export file...
    // =========================================================================

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // The issue here is that a teaser image could be:-
    //
    //      o   In the source site's WordPress Media Library
    //              ==> physically copy it...
    //
    //      o   On the source site - but NOT in it's Media Library
    //              ==> physically copy it...
    //
    //      o   On some external site.
    //              ==> ***maybe*** physically copy it (see below)...
    //
    //      The above applies whether the source site is on localhost or the
    //      publicly accessible Web.
    //
    // If the image is on some EXTERNAL site (which external site may be a
    // local site on a LAN for example - or a publicly accessible site on the
    // Web), then:-
    //
    //      o   The image is on some local (not publicly accessible) site,
    //              ==> physically copy the image...
    //
    //      o   The image is on some publicly accessible Web site,
    //              ==> DON'T physically copy the image (the URL alone
    //                  is all that's required).
    //
    // -------------------------------------------------------------------------

    foreach ( $teaser_images as $this_teaser_image_index => $this_teaser_image_data ) {

        // ---------------------------------------------------------------------
        // Get the image's domain...
        // ---------------------------------------------------------------------

        $image_domain = parse_url( $this_teaser_image_data['url'] , PHP_URL_HOST ) ;

        // ---------------------------------------------------------------------

        if (    ! is_string( $image_domain )
                ||
                trim( $image_domain ) === ''
            ) {

            return <<<EOT
PROBLEM:&nbsp; Can't find image's domain name
Image URL:&nbsp; {$this_teaser_image_data['url']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // If the image is on the source domain, the copy it physically.
        //
        // Otherwise, copy it by reference...
        //
        // TODO !!!
        //      For images NOT on the source domain/site, check for images
        //      domains that are local (NOT publicly accessible).  These should
        //      be physically copied too.
        // ---------------------------------------------------------------------

        if ( $image_domain === $source_domain ) {
            $teaser_images[ $this_teaser_image_index ]['copy_type'] = 'physical' ;

        } else {
            $teaser_images[ $this_teaser_image_index ]['copy_type'] = 'by-reference' ;

        }

        // ---------------------------------------------------------------------
        // Repeat with the next teaser image (if there is one)...
        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_images ) ;

    // =========================================================================
    // LOOP over the TEASER IMAGES to be copied physically - and add the info
    // and binary image data for each one...
    // =========================================================================

    $allowed_imagetype_xxx = array(
        IMAGETYPE_GIF   ,
        IMAGETYPE_JPEG  ,
        IMAGETYPE_PNG
        ) ;

    // -------------------------------------------------------------------------

    foreach ( $teaser_images as $this_teaser_image_index => $this_teaser_image_data ) {

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_teaser_image_data ) ;

        // =====================================================================
        // Skip images that AREN'T to be copied physically...
        // =====================================================================

        if ( $this_teaser_image_data['copy_type'] !== 'physical' ) {
            continue ;
        }

        // =====================================================================
        // Convert the image URL into a pathspec...
        // =====================================================================

        // -----------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\
        // wp_url2path(
        //      $url
        //      )
        // - - - - - - - - - - - - - - - - -
        // RETURNS:-
        //      o   $pathspec on SUCCESS
        //      o   array( $error_message ) on FAILURE
        // -----------------------------------------------------------------------

        $image_pathspec =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pathUtils\wp_url2path(
                $this_teaser_image_data['url']
                ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $image_pathspec ) ) {
            return $image_pathspec[0] ;
        }

        // =====================================================================
        // Get the image properties...
        // =====================================================================

        $imagesize = \getimagesize( $image_pathspec ) ;

        // ---------------------------------------------------------------------

        if ( $imagesize === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "getimagesize()" failure analysing image
Image URL:&nbsp; {$this_teaser_image_data['url']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $imagesize = Array(
        //          [0]     =>  842
        //          [1]     =>  656
        //          [2]     =>  3
        //          [3]     =>  width="842" height="656"
        //          [bits]  =>  8
        //          [mime]  =>  image/png
        //          ) ;
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $imagesize ) ;

        // =====================================================================
        // Check the IMAGETYPE_XXX
        // =====================================================================

        // -------------------------------------------------------------------------
        // PHP's IMAGETYPE_XXX (and the corresponding Mime types, are:-
        //
        //      IMAGETYPE_GIF       image/gif
        //      IMAGETYPE_JPEG      image/jpeg
        //      IMAGETYPE_PNG       image/png
        //
        //      IMAGETYPE_SWF       application/x-shockwave-flash
        //      IMAGETYPE_PSD       image/psd
        //      IMAGETYPE_BMP       image/bmp
        //      IMAGETYPE_TIFF_II   (intel byte order)      image/tiff
        //      IMAGETYPE_TIFF_MM   (motorola byte order)   image/tiff
        //      IMAGETYPE_JPC       application/octet-stream
        //      IMAGETYPE_JP2       image/jp2
        //      IMAGETYPE_JPX       application/octet-stream
        //      IMAGETYPE_JB2       application/octet-stream
        //      IMAGETYPE_SWC       application/x-shockwave-flash
        //      IMAGETYPE_IFF       image/iff
        //      IMAGETYPE_WBMP      image/vnd.wap.wbmp
        //      IMAGETYPE_XBM       image/xbm
        //      IMAGETYPE_ICO       image/vnd.microsoft.icon
        //
        // -------------------------------------------------------------------------

        $imagetype_xxx = $imagesize[2] ;

        // ---------------------------------------------------------------------

        if ( ! in_array( $imagetype_xxx , $allowed_imagetype_xxx , TRUE ) ) {

            $safe_mime = \htmlentities( $imagesize['mime'] ) ;

            return <<<EOT
PROBLEM:&nbsp; Bad image type (only GIF, JPEG/JPG/JPE and PNG can be exported)
Image URL:&nbsp; {$this_teaser_image_data['url']}
Mime/Content Type:&nbsp; {$safe_mime}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // =====================================================================
        // Check that the IMAGETYPE_XXX matches the file's EXTENSION...
        // =====================================================================

        $ext = \pathinfo( $image_pathspec , PATHINFO_EXTENSION ) ;

        // ---------------------------------------------------------------------

        $ext = \strtoupper( $ext ) ;

        // ---------------------------------------------------------------------

        if ( $ext === 'GIF' ) {

            // -----------------------------------------------------------------

            if ( $imagetype_xxx !== IMAGETYPE_GIF ) {

                $safe_mime = \htmlentities( $imagesize['mime'] ) ;

                return <<<EOT
PROBLEM:&nbsp; Image type and extension mismatch (the file's content doesn't seem to be that of a GIF file)
Image URL:&nbsp; {$this_teaser_image_data['url']}
Mime/Content Type:&nbsp; {$safe_mime}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

        } elseif ( $ext === 'PNG' ) {

            // -----------------------------------------------------------------

            if ( $imagetype_xxx !== IMAGETYPE_PNG ) {

                $safe_mime = \htmlentities( $imagesize['mime'] ) ;

                return <<<EOT
PROBLEM:&nbsp; Image type and extension mismatch (the file's content doesn't seem to be that of a PNG file)
Image URL:&nbsp; {$this_teaser_image_data['url']}
Mime/Content Type:&nbsp; {$safe_mime}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

        } elseif ( in_array( $ext , array( 'JPEG' , 'JPG' , 'JPE' ) , TRUE ) ) {

            // -----------------------------------------------------------------

            if ( $imagetype_xxx !== IMAGETYPE_JPEG ) {

                $safe_mime = \htmlentities( $imagesize['mime'] ) ;

                return <<<EOT
PROBLEM:&nbsp; Image type and extension mismatch (the file's content doesn't seem to be that of a JPEG file)
Image URL:&nbsp; {$this_teaser_image_data['url']}
Mime/Content Type:&nbsp; {$safe_mime}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            }

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $safe_ext = \htmlentities( $ext ) ;

            return <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported image extension (only GIF, JPEG, JPG, JPE and PNG are supported)
Image URL:&nbsp; {$this_teaser_image_data['url']}
Extension:&nbsp; {$safe_ext}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Add the image properties into the teaser image data...
        // =====================================================================

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $imagesize = Array(
        //          [0]     =>  842
        //          [1]     =>  656
        //          [2]     =>  3
        //          [3]     =>  width="842" height="656"
        //          [bits]  =>  8
        //          [mime]  =>  image/png
        //          ) ;
        //
        // ---------------------------------------------------------------------

        $teaser_images[ $this_teaser_image_index ]['width']             = $imagesize[0]      ;
        $teaser_images[ $this_teaser_image_index ]['height']            = $imagesize[1]      ;
        $teaser_images[ $this_teaser_image_index ]['php_imagetype_xxx'] = $imagesize[2]      ;
        $teaser_images[ $this_teaser_image_index ]['mime_type']         = $imagesize['mime'] ;

        // =====================================================================
        // Calculate the MD5 checksum of the file content - and add it to
        // the image properties...
        // =====================================================================

        $md5 = \md5_file( $image_pathspec ) ;
                    // Returns a string on success, FALSE otherwise.

        // ---------------------------------------------------------------------

        if ( $md5 === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "md5_file()" failure getting image checksum
Image URL:&nbsp; {$this_teaser_image_data['url']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $teaser_images[ $this_teaser_image_index ]['md5'] = $md5 ;

        // =====================================================================
        // Calculate the SHA1 checksum of the file content - and add it to
        // the image properties...
        // =====================================================================

        $sha1 = \sha1_file( $image_pathspec ) ;

        // ---------------------------------------------------------------------

        if ( $sha1 === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "sha1_file()" failure getting image checksum
Image URL:&nbsp; {$this_teaser_image_data['url']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $teaser_images[ $this_teaser_image_index ]['sha1'] = $sha1 ;

        // =====================================================================
        // Get the FILE SIZE - and add it to the image data...
        // =====================================================================

        $filesize = @\filesize( $image_pathspec ) ;
                        // Returns the size of the file in bytes, or FALSE (and
                        // generates an error of level E_WARNING) in case of an
                        // error.

        // ---------------------------------------------------------------------

        if ( $filesize === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "filesize()" failure getting image file size
Image URL:&nbsp; {$this_teaser_image_data['url']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $teaser_images[ $this_teaser_image_index ]['filesize'] = $filesize ;

        // =====================================================================
        // LOAD the RAW IMAGE DATA - and save it to the teaser image...
        // =====================================================================

        $raw_image_data = \file_get_contents( $image_pathspec ) ;
                            //  The function returns the read data or FALSE on
                            //  failure.

        // ---------------------------------------------------------------------

        if ( $raw_image_data === FALSE ) {

            return <<<EOT
PROBLEM:&nbsp; "file_get_contents()" failure loading raw image data
Image URL:&nbsp; {$this_teaser_image_data['url']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( strlen( $raw_image_data ) !== $filesize ) {

            return <<<EOT
PROBLEM:&nbsp; Image binary data length and file size mismatch
Image URL:&nbsp; {$this_teaser_image_data['url']}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $teaser_images[ $this_teaser_image_index ]['binary_image_data'] = $raw_image_data ;

        // =====================================================================
        // Repeat with the next teaser image (if there is one)...
        // =====================================================================

    }


    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $teaser_images ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


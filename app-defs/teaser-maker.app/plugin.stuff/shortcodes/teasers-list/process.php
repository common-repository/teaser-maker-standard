<?php

// ***************************************************************************
// TEASER-MAKER.APP / PLUGIN.STUFF / SHORTCODES / TEASERS-LIST / PROCESS.PHP
// (For WordPress Front-End)
// (C) 2013 Peter Newman. All Rights Reserved
// ***************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_teasersList ;

// =============================================================================
// process()
// =============================================================================

function process(
    $atts                   ,
    $content                ,
    $tag                    ,
    $plugin_slug_dashed     ,
    $core_plugapp_dirs
    ) {

    // -------------------------------------------------------------------------
    // process(
    //      $atts                   ,
    //      $content                ,
    //      $tag                    ,
    //      $plugin_slug_dashed     ,
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - - - - -
    // Lists the teasers...
    //
    // Returns the content to be displayed where the:-
    //      [teaser-maker gadget="teasers-list" ...]
    //
    // (shortcode) is.
    //
    // ---
    //
    // $atts, $content are the standard WordPress shortcode handler parameters.
    //
    // Eg:-
    //      my_shortcode_handler( $atts , $content , $tag )
    //
    // Ie:-
    //      $atts    - an associative array of attributes, or an empty string if no attributes are given
    //      $content - the enclosed content (if the shortcode is used in its enclosing form)
    //      $tag     - the shortcode tag, useful for shared callback functions
    //
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $atts = Array(
    //                  [gadget]    => teasers-list
    //                  [category]  => "<category-key>"
    //                  )
    //
    //      $content = ''
    //
    //      $tag = 'teaser-maker' --or-- 'teaser_maker'
    //
    //      $plugin_slug_dashed = 'teaser-maker'
    //
    //      $core_plugapp_dirs = Array(
    //          [plugin_root_dir]              => /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1
    //          [plugins_includes_dir]         => /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/includes
    //          [plugins_app_defs_dir]         => /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/app-defs
    //          [dataset_manager_includes_dir] => /opt/lampp/htdocs/plugdev/wp-content/plugins/teaser-maker-v0.1/includes/dataset-manager
    //          [apps_dot_app_dir]             =>
    //          [apps_plugin_stuff_dir]        =>
    //          )
    //
    // -------------------------------------------------------------------------

//ob_start() ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( \func_get_args() ) ;
//return ob_get_clean() ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Support Routines...
    // =========================================================================

    require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/common.php' ) ;

    // =========================================================================
    // Get the plugin's VERSION NAME...
    // =========================================================================

    require_once( $core_plugapp_dirs['apps_plugin_stuff_dir'] . '/version-names.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\
    // get_version_name()
    // - - - - - - - - -
    // Returns the "short" version name/slug - for this version of the plugin.
    //
    // RETURNS
    //      $short_version_name STRING
    //      Eg:-
    //          o   "std"
    //          o   "std"
    //          o   "pro"
    // -------------------------------------------------------------------------

    $plugin_version_name =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\get_version_name()
        ;
        //      o   "std"
        //      o   "std"
        //      o   "pro"

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $plugin_version_name ) ;

    // =========================================================================
    // ERROR CHECKING (1)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have:-
    //
    //      =============
    //      "Std" Version
    //      =============
    //
    //          [teaser-maker gadget="teasers-list"]
    //
    //      =============
    //      "Pro" Version
    //      =============
    //
    //          [teaser-maker gadget="teasers-list"]
    //
    //          [teaser-maker gadget="teasers-list" category="xxx"]
    //
    //          [teaser-maker gadget="teasers-list" category="yyy"]
    //
    //          [teaser-maker gadget="teasers-list" category="xxx" level="yyy"]
    //
    // In the "Pro" version, "category" and "levels" are both OPTIONAL.
    //
    // In the "Std" version, they're IGNORED.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // get_topmost_teaser_category_key_and_levels( $atts )
    // - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $topmost_teaser_category_key STRING
    //                  $levels INT
    //                  )
    //
    //              NOTE!
    //              -----
    //              It HASN'T been checked that a teaser category with the
    //              specified:-
    //                  $topmost_teaser_category_key
    //              exists.
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = get_topmost_teaser_category_key_and_levels( $atts ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return nl2br( $result ) ;
    }

    // -------------------------------------------------------------------------

    list(
        $topmost_teaser_category_key    ,
        $levels
        ) = $result ;

    // =========================================================================
    // LOAD the plugin's "app_defs" directory tree (and the datasets and
    // views, etc, defined therein)...
    // =========================================================================

    require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/app-defs-support.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_app_defs_tree(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $caller_apps_includes_dir                       ,
    //      $question_front_end                             ,
    //      $tree_root_dir                                  ,
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Loads the application definitions in the specified directory tree.
    //
    // RETURNS:
    //      o   On SUCCESS!
    //          - - - - - -
    //          ARRAY(
    //              ARRAY $app_defs_directory_tree                          ,
    //              ARRAY $applications_dataset_and_view_definitions_etc
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $caller_app_slash_plugins_global_namespace = '' ;
    $caller_plugins_includes_dir               = $core_plugapp_dirs['plugins_includes_dir'] ;
    $question_front_end                        = TRUE ;
    $dataset_manager_dataset_defs_dir          = $core_plugapp_dirs['plugins_app_defs_dir'] ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\load_app_defs_tree(
                    $caller_app_slash_plugins_global_namespace      ,
                    $caller_plugins_includes_dir                    ,
                    $question_front_end                             ,
                    $dataset_manager_dataset_defs_dir               ,
                    $core_plugapp_dirs
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return nl2br( $result ) ;
    }

    // -------------------------------------------------------------------------

    list(
        $app_defs_directory_tree                          ,
        $applications_dataset_and_view_definitions_etc
        ) = $result ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $app_defs_directory_tree = Array(
    //
    //          [dirs] => Array(
    //
    //              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/_old_] => Array(
    //                  [dirs]  => Array()
    //                  [files] => Array(
    //                      [0] => projects.php
    //                      [1] => reference-url-resources.php
    //                      [2] => reference-urls.php
    //                      )
    //                  [other] => Array(
    //                      [0] => .
    //                      [1] => ..
    //                      )
    //                  )
    //
    //              [/opt/lampp/htdocs/plugdev/wp-content/plugins/research-assistant/app-defs/research-assistant.app] => Array(
    //                  [dirs]  => Array()
    //                  [files] => Array()
    //                  [other] => Array(
    //                      [0] => .
    //                      [1] => ..
    //                      )
    //                  )
    //
    //              )
    //
    //          [files] => Array(
    //              [0] => categories.bak
    //              [1] => categories.php
    //              [2] => categories.php-thp.html
    //              [3] => category-resources.bak
    //              [4] => category-resources.php
    //              [5] => projects.bak
    //              [6] => projects.php
    //              [7] => url-resources.bak
    //              [8] => url-resources.php
    //              [9] => urls.bak
    //              [10] => urls.php
    //              )
    //
    //          [other] => Array(
    //              [0] => .
    //              [1] => ..
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $app_defs_directory_tree ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $applications_dataset_and_view_definitions_etc = array(
    //
    //          [dirspec]               => /opt/lampp/htdocs.../app-defs
    //
    //          [app_path]              =>
    //
    //          [app_data]              => Array(
    //                                          [app_slug]  => dataset_manager_dataset_defs
    //                                          [app_title] => Dataset Manager Dataset Defs
    //                                          )
    //
    //          [sub_apps]              => Array(
    //
    //              [research-assistant] => Array(
    //
    //                  [dirspec]               => /opt/lampp/htdocs/.../research-assistant.app
    //
    //                  [app_path]              => research-assistant
    //
    //                  [app_data]              => Array(
    //                                                  [app_slug]              => research_assistant
    //                                                  [app_title]             => Research Assistant
    //                                                  [dataset_listing_order] => Array(
    //                                                      [0] => projects
    //                                                      [1] => categories
    //                                                      [2] => urls
    //                                                      )
    //
    //                  )
    //
    //                  [sub_apps]            => Array()
    //
    //                  [dataset_definitions] => Array(
    //
    //                      [categories] => Array(
    //                          [dataset_slug]                      => categories
    //                          [dataset_name_singular]             => category
    //                          [dataset_name_plural]               => categories
    //                          [dataset_title_singular]            => Category
    //                          [dataset_title_plural]              => Categories
    //                          [basepress_dataset_handle]          => Array(
    //                              [nice_name]     => researchAssistant_byFernTec_categories
    //                              [unique_key]    => 6934fccc-c552-46b0-8db5-87a02...f7adf54
    //                              [version]       => 0.1
    //                              )
    //                          [dataset_records_table]             => Array(...)
    //                          [zebra_form]                        => Array(...)
    //                          [array_storage_record_structure]    => Array(...)
    //                          [array_storage_key_field_slug]      => key
    //                          )
    //
    //                      [projects] => Array(
    //                          [dataset_slug]                      => projects
    //                          [dataset_name_singular]             => project
    //                          [dataset_name_plural]               => projects
    //                          [dataset_title_singular]            => Project
    //                          [dataset_title_plural]              => Projects
    //                          [basepress_dataset_handle]          => Array(
    //                              [nice_name]     => researchAssistant_byFernTec_projects
    //                              [unique_key]    => d2562b23-3c20-4368-92c4-2b...0c9a66
    //                              [version]       => 0.1
    //                              )
    //                          [dataset_records_table]             => Array(...)
    //                          [zebra_form]                        => Array(...)
    //                          [array_storage_record_structure]    => Array(...)
    //                          [array_storage_key_field_slug]      => key
    //                          )
    //
    //                      [urls] => Array(
    //                          [dataset_slug]                      => urls
    //                          [dataset_name_singular]             => url
    //                          [dataset_name_plural]               => urls
    //                          [dataset_title_singular]            => URL
    //                          [dataset_title_plural]              => URLs
    //                          [basepress_dataset_handle]          => Array(
    //                              [nice_name]     => researchAssistant_byFernTec_urls
    //                              [unique_key]    => 7d800cd3-8787-49ea-9058-68db...5097b13
    //                              [version]       => 0.1
    //                              )
    //                          [dataset_records_table]             => Array(...)
    //                          [zebra_form]                        => Array(...)
    //                          [array_storage_record_structure]    => Array(...)
    //                          [array_storage_key_field_slug]      => key
    //                          )
    //
    //                      )
    //
    //                  [views] => Array(
    //
    //                      [url_tree] => Array(
    //                          [view_slug] => url_tree
    //                          ...
    //                          )
    //
    //                      )
    //
    //                  )
    //              )
    //
    //          [dataset_definitions]   => Array()
    //
    //          [views]                 => Array()
    //
    //          )
    //
    // -------------------------------------------------------------------------

//pr( $applications_dataset_and_view_definitions_etc ) ;

    // =========================================================================
    // GET the ("Teaser Maker") application's DATASET DEFINITIONS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // get_application_dataset_definitions(
    //      $applications_dataset_and_view_definitions_etc   ,
    //      $target_app_path
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $target_app_path is a slash-separated list of nested application
    // slugs dashed.  Like (eg):-
    //
    //      o   "research-assistant"
    //      o   "research-assistant/some-sub-app"
    //      o   etc
    //
    // RETURNS
    //      o   ARRAY $all_application_dataset_definitions
    //          --> Target app. found - and has 1+ dataset definitions
    //
    //      o   $error_message STRING
    //          --> Error encountered; search abandoned
    //
    //      o   FALSE
    //          --> Target app. NOT found (after searching whole tree)
    // -------------------------------------------------------------------------

    $target_app_path = 'teaser-maker' ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_application_dataset_definitions(
                    $applications_dataset_and_view_definitions_etc   ,
                    $target_app_path
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $result ) ) {

        $all_application_dataset_definitions = $result ;

    } elseif ( is_string( $result ) ) {

        return nl2br( $result ) ;

    } else {

        $safe_target_app_path = htmlentities( $target_app_path ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported application ("{$safe_target_app_path}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // =========================================================================
    // LOAD and INITIALISE the ARRAY STORAGE...
    // =========================================================================

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/array-storage.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\init(
    //      $default_storage_method         ,
    //      $json_data_files_dir = NULL     ,
    //      $supported_datasets = array()
    //      )
    // - - - - - - - - - - - - - - - - -
    // You MUST call this function - to initialise the array starage system -
    // BEFORE calling any of the array storage functions proper.  Ie; before
    // calling:-
    //      o   load()
    //      o   load_numerically_indexed()
    //      o   save()
    //      o   save_numerically_indexed()
    //      o   (etc)
    //
    // $supported_datasets must be a (possibly empty) array like (eg):-
    //
    //      $supported_datasets = array(
    //          <dataset-slug>  =>  <array-storage-specs>
    //          ...
    //          )
    //
    // Eg:-
    //
    //      $supported_datasets = array(
    //
    //          'projects'    =>  array(
    //                                  'storage_method'            =>  NULL        ,
    //                                  'json_filespec'             =>  NULL        ,
    //                                  'basepress_dataset_handle'  =>  array(
    //                                      'nice_name'     =>  'protoPress_byFernTec_test'             ,
    //                                      'unique_key'    =>  'a6acf950-63d3-11e3-949a-0800200c9a66'  ,
    //                                      'version'       =>  '0.1'
    //                                      )
    //                                  )   ,
    //
    //          ...
    //
    //          )
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $default_storage_method = 'basepress-dataset' ;
    $json_data_files_dir    = NULL ;
    $supported_datasets     = array() ;

    // -------------------------------------------------------------------------

    foreach ( $all_application_dataset_definitions as $dataset_slug => $dataset_details ) {

        $supported_datasets[ $dataset_slug ] = array(
            'storage_method'            =>  NULL                                            ,
            'json_filespec'             =>  NULL                                            ,
            'basepress_dataset_handle'  =>  $dataset_details['basepress_dataset_handle']
            ) ;

    }

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\init(
                    $default_storage_method     ,
                    $json_data_files_dir        ,
                    $supported_datasets
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return nl2br( $result ) ;
    }

    // =========================================================================
    // LOAD the TEASERS (from ARRAY STORAGE)...
    // =========================================================================

//  require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/array-storage.php' ) ;

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

    $dataset_slug = 'teasers' ;

    $question_die_on_error = FALSE ;

    $teaser_records = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
                            $dataset_slug               ,
                            $question_die_on_error
                            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $teaser_records ) ) {
        return nl2br( $teaser_records ) ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_records = Array(
    //
    //          [0] => Array(
    //                      [created_server_datetime_UTC]       => 1393662310
    //                      [last_modified_server_datetime_UTC] => 1393663169
    //                      [key]                               => 53119966a9a2e
    //                      [original_url]                      => http://nz2.php.net/file_upload
    //                      [original_title]                    => Handling file uploads
    //                      [original_clipped_text]             => The official (multi-page) tutorial on the PHP site.
    //                      [text_format]                       => text/html
    //                      [original_media_url]                =>
    //                      [post_id]                           => 128
    //                      )
    //
    //          [1] => Array(
    //                      [created_server_datetime_UTC]       => 1393803299
    //                      [last_modified_server_datetime_UTC] => 1393803299
    //                      [key]                               => 5313c0239492c
    //                      [original_url]                      => http://www.rookiemag.com/2014/02/show-the-way/
    //                      [original_title]                    => Show the Way
    //                      [original_clipped_text]             => The images that were hiding in the background of this month's theme, Escape.
    //                      [text_format]                       => text/html
    //                      [original_media_url]                => http://static.rookiemag.com/2014/02/13912724721february2014background.jpg
    //                      [post_id]                           => 130
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // LOAD and INDEX the TEASER CATEGORY records (if they're needed)...
    // =========================================================================

    if ( $topmost_teaser_category_key !== '' ) {

        // ---------------------------------------------------------------------
        // LOAD...
        // ---------------------------------------------------------------------

        $dataset_slug = 'teaser_categories' ;

        $question_die_on_error = FALSE ;

        // ---------------------------------------------------------------------

        $teaser_category_records =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
                $dataset_slug               ,
                $question_die_on_error
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $teaser_category_records ) ) {
            return nl2br( $teaser_category_records ) ;
        }

        // ---------------------------------------------------------------------
        // INDEX...
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_record_indices_by_key(
        //      $dataset_title      ,
        //      $dataset_records    ,
        //      $key_field_slug
        //      )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // RETURNS:-
        //      o   (array) $record_indices_by_id on SUCCESS
        //      o   (string) $error_message on FAILURE
        // -------------------------------------------------------------------------

        $dataset_title   = 'Teaser Categories' ;
        $dataset_records = $teaser_category_records ;
        $key_field_slug  = 'key' ;

        // ---------------------------------------------------------------------

        $teaser_category_record_indices_by_key =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_record_indices_by_key(
                $dataset_title      ,
                $dataset_records    ,
                $key_field_slug
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $teaser_category_record_indices_by_key ) ) {
            return nl2br( $teaser_category_record_indices_by_key ) ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // CHECK the:-
    //      $topmost_teaser_category_key
    //
    // (if necessary)...
    // =========================================================================

    if (    $topmost_teaser_category_key !== ''
            &&
            ! array_key_exists(
                $topmost_teaser_category_key                ,
                $teaser_category_record_indices_by_key
                )
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "category" (not found)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // =========================================================================
    // Get the TOPMOST TEASER CATEGORY'S DESCRIPTION (if it has one)...
    // =========================================================================

    $topmost_teaser_category_description = '' ;

    // -------------------------------------------------------------------------

    if ( $topmost_teaser_category_key !== '' ) {

        // ---------------------------------------------------------------------

        $teaser_category_record =
            $teaser_category_records[
                $teaser_category_record_indices_by_key[
                    $topmost_teaser_category_key
                    ]
                ] ;

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $teaser_category_record = Array(
        //          [created_server_datetime_UTC]       => 1401092315
        //          [last_modified_server_datetime_UTC] => 1401092315
        //          [key]                               => 5382f8db5d0c1
        //          [parent_key]                        =>
        //          [title]                             => Sample Teaser Page
        //          [description]                       =>
        //          [description_format]                => none
        //          [image_url]                         =>
        //          [sequence_number]                   =>
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_category_record ) ;

        // -------------------------------------------------------------------------
        // get_teaser_category_description(
        //      $teaser_category_record_data    ,
        //      $core_plugapp_dirs
        //      )
        // - - - - - - - - - - - - - - - - - - -
        // RETURNS:-
        //      o   On SUCCESS!
        //              $html STRING
        //
        //      o   On FAILURE
        //              ARRAY( $error_message STRING )
        // -------------------------------------------------------------------------

        $topmost_teaser_category_description =
            get_teaser_category_description(
                $teaser_category_record     ,
                $core_plugapp_dirs
                ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $topmost_teaser_category_description ) ) {
            return nl2br( $topmost_teaser_category_description[0] ) ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Find the TEASER RECORDS TO BE LISTED...
    // =========================================================================

    $teasers_to_list = array() ;

    // -------------------------------------------------------------------------

    foreach ( $teaser_records as $teaser_record_index => $teaser_record_data ) {

        // ---------------------------------------------------------------------
        // List this record ?
        // ---------------------------------------------------------------------

        if (    $topmost_teaser_category_key === ''
                &&
                $teaser_record_data['parent_key'] === ''
            ) {

            // -----------------------------------------------------------------
            // "Std" Version (NO Teaser Categories)...
            // -----------------------------------------------------------------

            $teasers_to_list[] = $teaser_record_data ;

            // -----------------------------------------------------------------

        } elseif ( $teaser_record_data['parent_key'] === $topmost_teaser_category_key ) {

            // -----------------------------------------------------------------
            // "Pro Version (With Teaser Categories)...
            // -----------------------------------------------------------------

            $teasers_to_list[] = $teaser_record_data ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teasers_to_list ) ;

    // =========================================================================
    // Anything to do ?
    // =========================================================================

    if ( count ( $teasers_to_list ) < 1 ) {

        // ---------------------------------------------------------------------

        if ( $topmost_teaser_category_key === '' ) {

            // -----------------------------------------------------------------

            $msg = <<<EOT
Sorry, but there are <strong>NO TEASERS</strong> to list...
EOT;

            // -----------------------------------------------------------------

        } else {

            // -----------------------------------------------------------------

            $teaser_category_title =
                $teaser_category_records[
                    $teaser_category_record_indices_by_key[
                        $topmost_teaser_category_key
                        ]
                    ]['title'] ;

            // -----------------------------------------------------------------

            $msg = <<<EOT
Sorry, but &ldquo;<strong>{$teaser_category_title}</strong>&rdquo; is currently empty...
EOT;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        return <<<EOT
<p><i>{$msg}<br /><br />Please check back later...</i></p>
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SORT the RECORDS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // bool usort ( array &$array , callable $value_compare_func )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // This function will sort an array by its values using a user-supplied
    // comparison function. If the array you wish to sort needs to be sorted by
    // some non-trivial criteria, you should use this function.
    //
    // Note:    If two members compare as equal, their relative order in the
    //          sorted array is undefined.
    //
    // Note:    This function assigns new keys to the elements in array. It will
    //          remove any existing keys that may have been assigned, rather
    //          than just reordering the keys.
    //
    //      array
    //          The input array.
    //
    //      value_compare_func
    //          The comparison function must return an integer less than, equal
    //          to, or greater than zero if the first argument is considered to
    //          be respectively less than, equal to, or greater than the second.
    //          int callback ( mixed $a, mixed $b )
    //
    //          Caution:    Returning non-integer values from the comparison
    //                      function, such as float, will result in an internal
    //                      cast to integer of the callback's return value. So
    //                      values such as 0.99 and 0.1 will both be cast to an
    //                      integer value of 0, which will compare such values
    //                      as equal.
    //
    // Returns TRUE on success or FALSE on failure.
    //
    // (PHP 4, PHP 5)
    //
    // CHANGELOG
    //      Version     Description
    //      -------     ------------------------------------------------------
    //      4.1.0       A new sort algorithm was introduced. The
    //                  value_compare_func doesn't keep the original order for
    //                  elements comparing as equal.
    // ------------------------------------------------------------------------

    if ( count( $teasers_to_list ) > 1 ) {

        // ---------------------------------------------------------------------

        $ok = usort( $teasers_to_list , '\\' . __NAMESPACE__ . '\\teaser_comparison_function' ) ;

        // --------------------------------------------------------------------

        if ( $ok !== TRUE ) {

            $msg = <<<EOT
PROBLEM:&nbsp; "usort()" failure (sorting the teasers to list)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

            return nl2br( $msg ) ;

        }

        // --------------------------------------------------------------------

    }

    // =========================================================================
    // LOAD the STANDARD TEASER LAYOUTS...
    // =========================================================================

    require_once( $core_plugapp_dirs['apps_dot_app_dir'] . '/standard-teaser-layouts.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserLayouts\
    // get_standard_teaser_layouts()
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //
    //      array(
    //          'p_and_h_tags'      =>  <layout-styles-js-array;see-below>  ,
    //          'div_and_span_tags' =>  <layout-styles-js-array;see-below>
    //          )
    //
    //      Where:-
    //
    //          <layout-styles-js-array> = array(
    //              'container' =>  array(
    //                  'html'  =>  "xxx"   ,
    //                  'css'   =>  "xxx"   ,
    //                  'js'    =>  "xxx"
    //                  )   ,
    //              'title' =>  array(
    //                  'html'  =>  "xxx"   ,
    //                  'css'   =>  "xxx"   ,
    //                  'js'    =>  "xxx"
    //                  )   ,
    //              'text' =>  array(
    //                  'html'  =>  "xxx"   ,
    //                  'css'   =>  "xxx"   ,
    //                  'js'    =>  "xxx"
    //                  )   ,
    //              'image' =>  array(
    //                  'html'  =>  "xxx"   ,
    //                  'css'   =>  "xxx"   ,
    //                  'js'    =>  "xxx"
    //                  )   ,
    //              'read_more' =>  array(
    //                  'html'  =>  "xxx"   ,
    //                  'css'   =>  "xxx"   ,
    //                  'js'    =>  "xxx"
    //                  )   ,
    //              'date' =>  array(
    //                  'html'  =>  "xxx"   ,
    //                  'css'   =>  "xxx"   ,
    //                  'js'    =>  "xxx"
    //                  )
    //              )
    //
    // The returned HTML may contain the following tags:-
    //
    //      o   [**TEASER.TEMPLATE**QUESTION.SPACER**]
    //      o   [**TEASER.TEMPLATE**QUESTION.IMAGE**]
    //      o   [**TEASER.TEMPLATE**QUESTION.TITLE**]
    //      o   [**TEASER.TEMPLATE**QUESTION.TEXT**]
    //      o   [**TEASER.TEMPLATE**QUESTION.READ.MORE**]
    //
    //      o   [**TEASER.TEMPLATE**SPACER**]
    //      o   [**TEASER.TEMPLATE**IMAGE**]
    //      o   [**TEASER.TEMPLATE**TITLE**]
    //      o   [**TEASER.TEMPLATE**TEXT**]
    //      o   [**TEASER.TEMPLATE**READ.MORE**]
    //
    //      o   [**TEASER**SHORT.TARGET.URL**]
    //      o   [**TEASER**FULL.TARGET.URL**]
    //      o   [**TEASER**TITLE**]
    //      o   [**TEASER**TEXT**]
    //      o   [**TEASER**SHORT.IMAGE.URL**]
    //      o   [**TEASER**FULL.IMAGE.URL**]
    //      o   [**TEASER**DATE.CREATED**]
    //      o   [**TEASER**DATE.LAST_MODIFIED**]
    //      o   [**TEASER**DATE.CREATED**<date-format_string>**]
    //      o   [**TEASER**DATE.LAST_MODIFIED**<date-format_string>**]
    //
    // -------------------------------------------------------------------------

    $standard_teaser_layouts =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserLayouts\get_standard_teaser_layouts()
        ;

    // -------------------------------------------------------------------------

    if ( count( $standard_teaser_layouts ) < 1 ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "standard teaser layouts" are defined
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return nl2br( $msg ) ;

    }

    // =========================================================================
    // Determine the LAYOUT, STYLES and SCRIPTS to use...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (one of):-
    //      $plugin_version_name = "std"
    //      $plugin_version_name = "std"
    //      $plugin_version_name = "pro"
    // -------------------------------------------------------------------------

    if ( $plugin_version_name === 'std' ) {

        // =====================================================================
        // "STD" VERSION...
        // =====================================================================

        $selected_teaser_layout_slug = array_keys( $standard_teaser_layouts ) ;

        $selected_teaser_layout_slug = $selected_teaser_layout_slug[0] ;

        // ---------------------------------------------------------------------

        $selected_teaser_layout =
            $standard_teaser_layouts[ $selected_teaser_layout_slug ]['layout_details']
            ;

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // "MASTER" and "PRO" VERSIONS...
        // =====================================================================

//      require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/array-storage.php' ) ;

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

        $dataset_slug = 'teaser_settings' ;

        $question_die_on_error = FALSE ;

        $teaser_settings_records =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
                $dataset_slug               ,
                $question_die_on_error
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $teaser_settings_records ) ) {
            return nl2br( $teaser_settings_records ) ;
        }

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $teaser_settings_records = Array(
        //
        //          [0] => Array(
        //                      [created_server_datetime_UTC]       => 1397021148
        //                      [last_modified_server_datetime_UTC] => 1397034584
        //                      [key]                               => 5344d9dc6dfb1
        //                      [selected_layout_slug]              => p-and-h-tags-floating
        //                      [custom_layout_key]                 =>
        //                      [custom_style_key]                  =>
        //                      [custom_scripts_key]                =>
        //                      )
        //
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_settings_records ) ;

        // ---------------------------------------------------------------------

        if ( count( $teaser_settings_records ) < 1 ) {

            // =================================================================
            // NO "Teaser Settings" as yet.
            //
            // So use the (first) "Standard Teaser Layout)...
            // =================================================================

            $selected_teaser_layout_slug = array_keys( $standard_teaser_layouts ) ;

            $selected_teaser_layout_slug = $selected_teaser_layout_slug[0] ;

            // -----------------------------------------------------------------

            $selected_teaser_layout =
                $standard_teaser_layouts[ $selected_teaser_layout_slug ]['layout_details']
                ;

            // -----------------------------------------------------------------

        } else {

            // =================================================================
            // Use the STANDARD or CUSTOM layout specified in the Teaser
            // Settings...
            // =================================================================

            $selected_teaser_layout_slug = $teaser_settings_records[0]['selected_layout_slug'] ;

            // -----------------------------------------------------------------

            if ( $selected_teaser_layout_slug !== 'custom' ) {

                // =============================================================
                // BUILT-IN LAYOUT...
                // =============================================================

                if ( ! array_key_exists( $selected_teaser_layout_slug , $standard_teaser_layouts ) ) {

                    // ---------------------------------------------------------
                    // Specified standard teaser layout not found!
                    //
                    // ==> Use the first standard teaser layout...
                    // ---------------------------------------------------------

                    $selected_teaser_layout_slug = array_keys( $standard_teaser_layouts ) ;

                    $selected_teaser_layout_slug = $selected_teaser_layout_slug[0] ;

                    // ---------------------------------------------------------

                    $selected_teaser_layout =
                        $standard_teaser_layouts[ $selected_teaser_layout_slug ]['layout_details']
                        ;

                    // ---------------------------------------------------------

                } else {

                    // ---------------------------------------------------------

                    $selected_teaser_layout =
                        $standard_teaser_layouts[ $selected_teaser_layout_slug ]['layout_details']
                        ;

                    // ---------------------------------------------------------

                }

                // -------------------------------------------------------------

            } else {

                // =================================================================
                // CUSTOM LAYOUT...
                // =================================================================

                // -------------------------------------------------------------------------
                // get_custom_teaser_layout(
                //      $all_application_dataset_definitions    ,
                //      $teaser_settings
                //      )
                // - - - - - - - - - - - - - - - - - - - - - - -
                // RETURNS:-
                //      On SUCCESS!
                //          ARRAY $custom_teaser_layout
                //
                //      On FAILURE
                //          $error_message STRING
                // -------------------------------------------------------------------------

                $selected_teaser_layout = get_custom_teaser_layout(
                                                $all_application_dataset_definitions    ,
                                                $teaser_settings_records[0]
                                                ) ;

                // -------------------------------------------------------------

                if ( is_string( $selected_teaser_layout ) ) {
                    return nl2br( $selected_teaser_layout ) ;
                }

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_teaser_layout = Array(
    //
    //          [container] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  ""
    //              )
    //
    //          [title] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  ""
    //              )
    //
    //          [text] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  ""
    //              )
    //
    //          [image] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  ""
    //              )
    //
    //          [read_more] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  ""
    //              )
    //
    //          [date] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  ""
    //              )
    //
    //          [spacer] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  ""
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_teaser_layout_slug ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_teaser_layout ) ;

    // -------------------------------------------------------------------------

    $safe_selected_teaser_layout_slug = htmlentities( $selected_teaser_layout_slug ) ;
        //  For error messages...

    // =========================================================================
    // Init. the CSS PARSING...
    // =========================================================================

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/cssparser-2003-09-20/cssparser.php' ) ;

    // -------------------------------------------------------------------------

//$css = new cssparser();
//$css->ParseStr("b {font-weight: bold; color: #777777;} b.test{text-decoration: underline;}");
//echo $css->Get("b","color");     // returns #777777
//echo $css->Get("b.test","color");// returns #777777
//echo $css->Get(".test","color"); // returns an empty string

    $css = new \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_phpClasses_cssParser\cssparser() ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $css ) ;

//  $css->ParseStr("b {font-weight: bold; color: #777777;} b.test{text-decoration: underline;}");

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $css ) ;

//  $css_properties_by_selector = $css->css ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $css_properties_by_selector = Array(
    //
    //          [b] => Array(
    //                      [font-weight] => bold
    //                      [color]       => #777777
    //                      )
    //
    //          [b.test] => Array(
    //                          [text-decoration] => underline
    //                          )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $css_properties_by_selector ) ;

    // =========================================================================
    // Parse/convert the layout CSS into a:-
    //      css_properties_by_selector
    //
    // array...
    // =========================================================================

    $css_properties_by_template_slug_underscored_and_selector = array() ;

    // -------------------------------------------------------------------------

    foreach ( $selected_teaser_layout as $template_slug_underscored => $template_html_css_and_js ) {

        $css->ParseStr( $template_html_css_and_js['css'] ) ;

        $css_properties_by_template_slug_underscored_and_selector[
            $template_slug_underscored
            ] = $css->css ;

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //  $css_properties_by_template_slug_underscored_and_selector = Array(
    //
    //      [container] => Array(
    //          [div.teaser_teasermaker_std_v0x1_containerdiv a] => Array(
    //              [text-decoration] => none
    //              )
    //          )
    //
    //      [title]     => Array()
    //
    //      [text]      => Array()
    //
    //      [image]     => Array(
    //          [div.teaser_teasermaker_std_v0x1_imagediv img] => Array(
    //              [max-width]  => 600px
    //              [max-height] => 400px
    //              )
    //          )
    //
    //      [read_more] => Array(
    //          [div.teaser_teasermaker_std_v0x1_readmorediv td.read-more-title-td] => Array(
    //              [text-align]  => right
    //              [font-size]   => 150%
    //              [line-height] => 100%
    //              [font-weight] => bold
    //              [font-style]  => italic
    //              )
    //          [div.teaser_teasermaker_std_v0x1_readmorediv td.read-more-spacer-td] => Array(
    //              [padding] => 0 1em
    //              )
    //          [div.teaser_teasermaker_std_v0x1_readmorediv td.read-more-url-td] => Array(
    //              [font-size]   => 150%
    //              [line-height] => 100%
    //              )
    //          )
    //
    //      [date]      => Array()
    //
    //      )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Start collecting the output...
    // =========================================================================

    $out = '' ;

    // =========================================================================
    // Do the CATEGORY INTRO (if there is one)...
    // =========================================================================

    if ( $topmost_teaser_category_description !== '' ) {

        // ---------------------------------------------------------------------

        $out .= <<<EOT
<div style="margin:2em 0; padding:1em; font-size:115%; background-color:#F0F8FF; color:#000000">
    {$topmost_teaser_category_description}
</div>
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // List the records...
    // =========================================================================

    $image_extensions = array(
        'gif'       ,
        'png'       ,
        'jpeg'      ,
        'jpg'       ,
        'jpe'
        ) ;

    // -------------------------------------------------------------------------

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/string-utils.php' ) ;

    // -------------------------------------------------------------------------

    $basic_patterns_and_replacement_variable_names = array(
        '[**TEASER**SHORT.TARGET.URL**]'            =>  'teaser_short_target_url'       ,
        '[**TEASER**FULL.TARGET.URL**]'             =>  'teaser_full_target_url'        ,
        '[**TEASER**TITLE**]'                       =>  'teaser_title'                  ,
        '[**TEASER**TEXT**]'                        =>  'teaser_text'                   ,
        '[**TEASER**SHORT.IMAGE.URL**]'             =>  'teaser_short_image_url'        ,
        '[**TEASER**FULL.IMAGE.URL**]'              =>  'teaser_full_image_url'         ,
        '[**TEASER**DATE.CREATED**]'                =>  'teaser_date_created'           ,
        '[**TEASER**DATE.LAST_MODIFIED**]'          =>  'teaser_date_last_modified'
        ) ;

    // -------------------------------------------------------------------------

//      [**TEASER**SHORT.TARGET.URL**]
//      [**TEASER**FULL.TARGET.URL**]
//      [**TEASER**TITLE**]
//      [**TEASER**TEXT**]
//      [**TEASER**SHORT.IMAGE.URL**]
//      [**TEASER**FULL.IMAGE.URL**]
//      [**TEASER**DATE.CREATED**]
//      [**TEASER**DATE.LAST_MODIFIED**]

    // -------------------------------------------------------------------------

/*

<table border="1" cellpadding="3" cellspacing="0">
    <tr>
        <td align="right">[**TE&#65;SER**SHORT.TARGET.URL**]:  </td><td>[**TEASER**SHORT.TARGET.URL**]  </td>
    </tr>
    <tr>
        <td align="right">[**TE&#65;SER**FULL.TARGET.URL**]:   </td><td>[**TEASER**FULL.TARGET.URL**]   </td>
    </tr>
    <tr>
        <td align="right">[**TE&#65;SER**TITLE**]:             </td><td>[**TEASER**TITLE**]             </td>
    </tr>
    <tr>
        <td align="right">[**TE&#65;SER**TEXT**]:              </td><td>[**TEASER**TEXT**]              </td>
    </tr>
    <tr>
        <td align="right">[**TE&#65;SER**SHORT.IMAGE.URL**]:   </td><td>[**TEASER**SHORT.IMAGE.URL**]   </td>
    </tr>
    <tr>
        <td align="right">[**TE&#65;SER**FULL.IMAGE.URL**]:    </td><td>[**TEASER**FULL.IMAGE.URL**]    </td>
    </tr>
    <tr>
        <td align="right">[**TE&#65;SER**DATE.CREATED**]:      </td><td>[**TEASER**DATE.CREATED**]      </td>
    </tr>
    <tr>
        <td align="right">[**TE&#65;SER**DATE.LAST_MODIFIED**]:</td><td>[**TEASER**DATE.LAST_MODIFIED**]</td>
    </tr>
</table>

*/

    // -------------------------------------------------------------------------

    $template_patterns_and_replacement_variable_names = array(
        '[**TEASER.TEMPLATE**SPACER**]'             =>  'teaser_template_spacer'                ,
        '[**TEASER.TEMPLATE**IMAGE**]'              =>  'teaser_template_image'                 ,
        '[**TEASER.TEMPLATE**TITLE**]'              =>  'teaser_template_title'                 ,
        '[**TEASER.TEMPLATE**TEXT**]'               =>  'teaser_template_text'                  ,
        '[**TEASER.TEMPLATE**READ.MORE**]'          =>  'teaser_template_read_more'             ,
        '[**TEASER.TEMPLATE**DATE**]'               =>  'teaser_template_date'                  ,
        '[**TEASER.TEMPLATE**QUESTION.SPACER**]'    =>  'teaser_template_question_spacer'       ,
        '[**TEASER.TEMPLATE**QUESTION.IMAGE**]'     =>  'teaser_template_question_image'        ,
        '[**TEASER.TEMPLATE**QUESTION.TITLE**]'     =>  'teaser_template_question_title'        ,
        '[**TEASER.TEMPLATE**QUESTION.TEXT**]'      =>  'teaser_template_question_text'         ,
        '[**TEASER.TEMPLATE**QUESTION.READ.MORE**]' =>  'teaser_template_question_read_more'    ,
        '[**TEASER.TEMPLATE**QUESTION.DATE**]'      =>  'teaser_template_question_date'
        ) ;

    // -------------------------------------------------------------------------

//      [**TEASER.TEMPLATE**SPACER**]
//      [**TEASER.TEMPLATE**IMAGE**]
//      [**TEASER.TEMPLATE**TITLE**]
//      [**TEASER.TEMPLATE**TEXT**]
//      [**TEASER.TEMPLATE**READ.MORE**]
//      [**TEASER.TEMPLATE**DATE**]
//      [**TEASER.TEMPLATE**QUESTION.SPACER**]
//      [**TEASER.TEMPLATE**QUESTION.IMAGE**]
//      [**TEASER.TEMPLATE**QUESTION.TITLE**]
//      [**TEASER.TEMPLATE**QUESTION.TEXT**]
//      [**TEASER.TEMPLATE**QUESTION.READ.MORE**]
//      [**TEASER.TEMPLATE**QUESTION.DATE**]

    // -------------------------------------------------------------------------

//  $default_date_format_string = 'j M Y' ;     //  1 Mar 2014
    $default_date_format_string = 'j F Y' ;     //  1 March 2014

    // -------------------------------------------------------------------------

    foreach ( $teasers_to_list as $teaser_record_index => $teaser_record_data ) {

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $teaser_record_data = Array(
        //          [created_server_datetime_UTC]       => 1393662310
        //          [last_modified_server_datetime_UTC] => 1393663169
        //          [key]                               => 53119966a9a2e
        //          [original_url]                      => http://nz2.php.net/file_upload
        //          [original_title]                    => Handling file uploads
        //          [original_clipped_text]             => The official (multi-page) tutorial on the PHP site.
        //          [text_format]                       => text/html
        //          [original_media_url]                =>
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_record_data ) ;

        // =====================================================================
        // CREATE the "BASIC" REPLACEMENTS...
        // =====================================================================

        // ---------------------------------------------------------------------
        // [**TEASER**TARGET.URL**]
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // to_short_url( $input_url )
        // - - - - - - - - - - - - -
        // Strips any leading" "http://" from the supplied URL.
        //
        // Ie:-
        //      "http://www.example.com"  -->  "www.example.com"
        //      "www.example.com"         -->  "www.example.com"   (no change)
        //      "ftp://example.com"       -->  "ftp://example.com" (no change)
        //
        // RETURNS
        //      The fixed URL on success.
        //      The original URL on failure.
        // -------------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // to_full_url( $input_url )
        // - - - - - - - - - - - - -
        // Prepends a leading" "http://" to the supplied URL, if necessary.
        //
        // Ie:-
        //      "www.example.com"         -->  "http://www.example.com"
        //      "http://www.example.com"  -->  "http://www.example.com" (no change)
        //      "ftp://example.com"       -->  "ftp://example.com"      (no change)
        //
        // RETURNS
        //      The fixed URL on success.
        //      The original URL on failure.
        // -------------------------------------------------------------------------

        if (    is_string( $teaser_record_data['original_url'] )
                &&
                trim( $teaser_record_data['original_url'] ) !== ''
            ) {

            $teaser_target_url = trim( $teaser_record_data['original_url'] ) ;

            $teaser_short_target_url = to_short_url( $teaser_target_url ) ;

            $teaser_full_target_url  = to_full_url( $teaser_target_url ) ;

        } else {

            $teaser_short_target_url = '' ;

            $teaser_full_target_url = '' ;

        }

        // ---------------------------------------------------------------------
        // [**TEASER**TITLE**]
        // ---------------------------------------------------------------------

        if (    is_string( $teaser_record_data['original_title'] )
                &&
                trim( $teaser_record_data['original_title'] ) !== ''
            ) {
            $teaser_title = trim( $teaser_record_data['original_title'] ) ;

        } else {
            $teaser_title = '' ;

        }

        // ---------------------------------------------------------------------
        // [**TEASER**TEXT**]
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // get_teaser_text(
        //      $teaser_record_data     ,
        //      $core_plugapp_dirs
        //      )
        // - - - - - - - - - - - - - - -
        // RETURNS:-
        //      o   On SUCCESS!
        //              $html STRING
        //
        //      o   On FAILURE
        //              ARRAY( $error_message STRING )
        // -------------------------------------------------------------------------

        $teaser_text = get_teaser_text(
                            $teaser_record_data     ,
                            $core_plugapp_dirs
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $teaser_text ) ) {
            return nl2br( $teaser_text[0] ) ;
        }

        // ---------------------------------------------------------------------
        // [**TEASER**IMAGE.URL**]
        // ---------------------------------------------------------------------

        if (    is_string( $teaser_record_data['original_media_url'] )
                &&
                trim( $teaser_record_data['original_media_url'] ) !== ''
            ) {

            $ext = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\get_ext(
                        trim( $teaser_record_data['original_media_url'] )
                        ) ;

            if ( in_array( strtolower( $ext ) , $image_extensions , TRUE ) ) {

                $teaser_image_url = trim( $teaser_record_data['original_media_url'] ) ;

                $teaser_short_image_url = to_short_url( $teaser_image_url ) ;
                $teaser_full_image_url  = to_full_url( $teaser_image_url ) ;

            } else {

                $teaser_short_image_url = '' ;
                $teaser_full_image_url  = '' ;

            }

        } else {

            $teaser_short_image_url = '' ;
            $teaser_full_image_url  = '' ;

        }

        // ---------------------------------------------------------------------
        // [**TEASER**DATE.CREATED**]
        // ---------------------------------------------------------------------

        $teaser_date_created = date(
                                    $default_date_format_string     ,
                                    $teaser_record_data['created_server_datetime_UTC']
                                    ) ;

        // ---------------------------------------------------------------------
        // [**TEASER**DATE.LAST_MODIFIED**]
        // ---------------------------------------------------------------------

        $teaser_date_last_modified = date(
                                        $default_date_format_string     ,
                                        $teaser_record_data['last_modified_server_datetime_UTC']
                                        ) ;

        // =====================================================================
        // CREATE the "REGEX" REPLACEMENTS...
        // =====================================================================

        // ---------------------------------------------------------------------
        // [**TEASER**DATE.CREATED**<date-format_string>**]
        // ---------------------------------------------------------------------

        $teaser_formatted_date_created = '' ;

        // ---------------------------------------------------------------------
        // [**TEASER**DATE.LAST_MODIFIED**<date-format_string>**]
        // ---------------------------------------------------------------------

        $teaser_formatted_date_last_modified = '' ;

        // =====================================================================
        // MAKE THE "BASIC" REPLACEMENTS...
        // =====================================================================

        // ---------------------------------------------------------------------
        // In other words, make the following replacements:-
        //
        //      $basic_patterns_and_replacement_variable_names = array(
        //          '[**TEASER**SHORT.TARGET.URL**]'    =>  'teaser_short_target_url'       ,
        //          '[**TEASER**FULL.TARGET.URL**]'     =>  'teaser_full_target_url'        ,
        //          '[**TEASER**TITLE**]'               =>  'teaser_title'                  ,
        //          '[**TEASER**TEXT**]'                =>  'teaser_text'                   ,
        //          '[**TEASER**SHORT.IMAGE.URL**]'     =>  'teaser_short_image_url'        ,
        //          '[**TEASER**FULL.IMAGE.URL**]'      =>  'teaser_full_image_url'         ,
        //          '[**TEASER**DATE.CREATED**]'        =>  'teaser_date_created'           ,
        //          '[**TEASER**DATE.LAST_MODIFIED**]'  =>  'teaser_date_last_modified'
        //          )
        //
        // in:-
        //
        //      $selected_teaser_layout[ 'container' ]['html']
        //      $selected_teaser_layout[ 'title'     ]['html']
        //      $selected_teaser_layout[ 'text'      ]['html']
        //      $selected_teaser_layout[ 'image'     ]['html']
        //      $selected_teaser_layout[ 'read_more' ]['html']
        //      $selected_teaser_layout[ 'date'      ]['html']
        //      $selected_teaser_layout[ 'spacer'    ]['html']
        //
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // mixed str_replace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // This function returns a string or an array with all occurrences of search
        // in subject replaced with the given replace value.
        //
        // If you don't need fancy replacing rules (like regular expressions), you
        // should always use this function instead of preg_replace().
        //
        // If search and replace are arrays, then str_replace() takes a value from
        // each array and uses them to search and replace on subject. If replace has
        // fewer values than search, then an empty string is used for the rest of
        // replacement values. If search is an array and replace is a string, then
        // this replacement string is used for every value of search. The converse
        // would not make sense, though.
        //
        // If search or replace are arrays, their elements are processed first to
        // last.
        //
        //      search
        //          The value being searched for, otherwise known as the needle. An
        //          array may be used to designate multiple needles.
        //
        //      replace
        //          The replacement value that replaces found search values. An
        //          array may be used to designate multiple replacements.
        //
        //      subject
        //          The string or array being searched and replaced on, otherwise
        //          known as the haystack.
        //
        //          If subject is an array, then the search and replace is performed
        //          with every entry of subject, and the return value is an array as
        //          well.
        //
        //      count
        //          If passed, this will be set to the number of replacements
        //          performed.
        //
        // This function returns a string or an array with the replaced values.
        //
        // (PHP 4, PHP 5)
        //
        // CHANGELOG
        //      Version     Description
        //      -------     --------------------------------------------------------
        //      5.0.0       The count parameter was added.
        //
        //      4.3.3       The behaviour of this function changed. In older
        //                  versions a bug existed when using arrays as both search
        //                  and replace parameters which caused empty search indexes
        //                  to be skipped without advancing the internal pointer on
        //                  the replace array. This has been corrected in PHP 4.3.3,
        //                  any scripts which relied on this bug should remove empty
        //                  search values prior to calling this function in order to
        //                  mimic the original behavior.
        //
        //      4.0.5       Most parameters can now be an array.
        // -------------------------------------------------------------------------

        $replaced_html_by_template_slug = array() ;

        // ---------------------------------------------------------------------

        foreach ( $selected_teaser_layout as $template_slug_underscored => $template_html_css_and_js ) {

            // -----------------------------------------------------------------

            $replaced_html = $template_html_css_and_js['html'] ;

            // -----------------------------------------------------------------

            foreach ( $basic_patterns_and_replacement_variable_names as $this_pattern => $this_variable_name ) {

//echo '<br /><br />' , $this_variable_name , '<br />' , htmlentities( $$this_variable_name ) ;

                $replaced_html = str_replace(
                                        $this_pattern           ,
                                        $$this_variable_name    ,
                                        $replaced_html
                                        ) ;

            }

            // -----------------------------------------------------------------

            $replaced_html_by_template_slug[ $template_slug_underscored ] = $replaced_html ;

            // -----------------------------------------------------------------

        }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $replaced_html_by_template_slug ) ;

        // =====================================================================
        // GET the "TEMPLATES" (with all "BASIC" and "REGEX" replacements
        // made)...
        // =====================================================================

        $teaser_template_image      = $replaced_html_by_template_slug[ 'image'     ] ;
        $teaser_template_title      = $replaced_html_by_template_slug[ 'title'     ] ;
        $teaser_template_text       = $replaced_html_by_template_slug[ 'text'      ] ;
        $teaser_template_read_more  = $replaced_html_by_template_slug[ 'read_more' ] ;
        $teaser_template_date       = $replaced_html_by_template_slug[ 'date'      ] ;
        $teaser_template_spacer     = $replaced_html_by_template_slug[ 'spacer'    ] ;

//echo '<br />' , htmlentities( $teaser_template_image ) ;
//echo '<br />' , htmlentities( $teaser_template_title ) ;

        // ---------------------------------------------------------------------

        if ( $teaser_short_image_url === '' ) {
            $teaser_template_question_image = '' ;

        } else {
            $teaser_template_question_image = $teaser_template_image ;

        }

        // ---------------------------------------------------------------------

        if ( $teaser_title === '' ) {
            $teaser_template_question_title = '' ;

        } else {
            $teaser_template_question_title = $teaser_template_title ;

        }

        // ---------------------------------------------------------------------

        if ( $teaser_text === '' ) {
            $teaser_template_question_text = '' ;

        } else {
            $teaser_template_question_text = $teaser_template_text ;

        }

        // ---------------------------------------------------------------------

        if ( $teaser_short_target_url === '' ) {
            $teaser_template_question_read_more = '' ;

        } else {
            $teaser_template_question_read_more = $teaser_template_read_more ;

        }

        // ---------------------------------------------------------------------

        $teaser_template_question_date = $teaser_template_date ;

        // ---------------------------------------------------------------------

        if ( $teaser_record_index === 0 ) {
            $teaser_template_question_spacer = '' ;

        } else {
            $teaser_template_question_spacer = $teaser_template_spacer ;

        }

        // =====================================================================
        // MAKE the "CONTAINER" replacements...
        // =====================================================================

//      $template_patterns_and_replacement_variable_names = array(
//          '[**TEASER.TEMPLATE**SPACER**]'             =>  'teaser_template_spacer'                ,
//          '[**TEASER.TEMPLATE**IMAGE**]'              =>  'teaser_template_image'                 ,
//          '[**TEASER.TEMPLATE**TITLE**]'              =>  'teaser_template_title'                 ,
//          '[**TEASER.TEMPLATE**TEXT**]'               =>  'teaser_template_text'                  ,
//          '[**TEASER.TEMPLATE**READ.MORE**]'          =>  'teaser_template_read_more'             ,
//          '[**TEASER.TEMPLATE**DATE**]'               =>  'teaser_template_date'                  ,
//          '[**TEASER.TEMPLATE**QUESTION.SPACER**]'    =>  'teaser_template_question_spacer'       ,
//          '[**TEASER.TEMPLATE**QUESTION.IMAGE**]'     =>  'teaser_template_question_image'        ,
//          '[**TEASER.TEMPLATE**QUESTION.TITLE**]'     =>  'teaser_template_question_title'        ,
//          '[**TEASER.TEMPLATE**QUESTION.TEXT**]'      =>  'teaser_template_question_text'         ,
//          '[**TEASER.TEMPLATE**QUESTION.READ.MORE**]' =>  'teaser_template_question_read_more'    ,
//          '[**TEASER.TEMPLATE**QUESTION.DATE**]'      =>  'teaser_template_question_date
//          ) ;

        // ---------------------------------------------------------------------

        $teaser_template_container = $replaced_html_by_template_slug['container'] ;

        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $template_patterns_and_replacement_variable_names ) ;

        foreach ( $template_patterns_and_replacement_variable_names as $this_pattern => $this_variable_name ) {

//echo '<br /><br />' , $this_pattern , '<br />' , $this_variable_name , '<br />' , htmlentities( $$this_variable_name ) ;

            $teaser_template_container = str_replace(
                                            $this_pattern               ,
                                            $$this_variable_name        ,
                                            $teaser_template_container
                                            ) ;

        }

        // =====================================================================
        // =====================================================================

//      $out .= '<pre>' . htmlentities( $teaser_template_container ) . '</pre>' . $teaser_template_container ;

        $out .= $teaser_template_container ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Add the STYLE SETTING JAVASCRIPT...
    // =========================================================================

    $css_properties_by_template_slug_underscored_and_selector_json = json_encode(
        $css_properties_by_template_slug_underscored_and_selector
        ) ;

    // -------------------------------------------------------------------------

    $out .= <<<EOT
<script type="text/javascript">
    window.teaserMaker_std_v0x1x114_css_properties_by_template_slug_underscored_and_selector =
        {$css_properties_by_template_slug_underscored_and_selector_json} ;
    function teaserMaker_std_v0x1x114_set_teaser_css() {
        var properties_by_selector , selector , property_name_value_pairs ;
        for ( template_slug_underscored in window.teaserMaker_std_v0x1x114_css_properties_by_template_slug_underscored_and_selector ) {
            properties_by_selector = window.teaserMaker_std_v0x1x114_css_properties_by_template_slug_underscored_and_selector[ template_slug_underscored ] ;
            for ( selector in properties_by_selector ) {
                property_name_value_pairs = properties_by_selector[ selector ] ;
                jQuery( selector ).css( property_name_value_pairs ) ;
            }
        }
    }
    teaserMaker_std_v0x1x114_set_teaser_css() ;
</script>
EOT;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $out ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// teaser_comparison_function()
// =============================================================================

function teaser_comparison_function( $this_teaser , $that_teaser ) {

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $this_teaser = Array(
    //          [created_server_datetime_UTC]       => 1396257875
    //          [last_modified_server_datetime_UTC] => 1396257875
    //          [key]                               => 5339345386dca
    //          [parent_key]                        =>
    //          [original_url]                      => http://www.rookiemag.com/2014/02/show-the-way/
    //          [original_title]                    => Show the Way
    //          [original_clipped_text]             => vdfagdfgdf
    //          [text_format]                       => none
    //          [original_media_url]                => http://static.rookiemag.com/2014/02/13912724721february2014background.jpg
    //          [sequence_number]                   =>
    //          )
    //
    //      $that_teaser = Array(
    //          [created_server_datetime_UTC]       => 1396257849
    //          [last_modified_server_datetime_UTC] => 1396257849
    //          [key]                               => 53393439b8b82
    //          [parent_key]                        =>
    //          [original_url]                      => http://www.rookiemag.com/2014/02/postcards-from-wonderland/
    //          [original_title]                    => Postcards From Wonderland
    //          [original_clipped_text]             => Blah blah blah...
    //          [text_format]                       => none
    //          [original_media_url]                => http://static.rookiemag.com/2014/02/13927942057DbvL-700x466.jpeg
    //          [sequence_number]                   =>
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_teaser ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $that_teaser ) ;

    // -------------------------------------------------------------------------
    // int strnatcasecmp ( string $str1 , string $str2 )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // This function implements a comparison algorithm that orders alphanumeric
    // strings in the way a human being would. The behaviour of this function is
    // similar to strnatcmp(), except that the comparison is not case sensitive.
    // For more information see: Martin Pool's » Natural Order String
    // Comparison page.
    //
    //      str1
    //          The first string.
    //
    //      str2
    //          The second string.
    //
    // Similar to other string comparison functions, this one returns < 0 if
    // str1 is less than str2 > 0 if str1 is greater than str2, and 0 if they
    // are equal.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    if ( $this_teaser['sequence_number'] == $that_teaser['sequence_number'] ) {
        return strnatcasecmp( $this_teaser['original_title'] , $that_teaser['original_title'] ) ;
    }

    // -------------------------------------------------------------------------

    return strnatcasecmp( $this_teaser['sequence_number'] , $that_teaser['sequence_number'] ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_teaser_text()
// =============================================================================

function get_teaser_text(
    $teaser_record_data     ,
    $core_plugapp_dirs
    ) {

    // -------------------------------------------------------------------------
    // get_teaser_text(
    //      $teaser_record_data     ,
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   On SUCCESS!
    //              $html STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_record_data = Array(
    //          [created_server_datetime_UTC]       => 1393662310
    //          [last_modified_server_datetime_UTC] => 1393663169
    //          [key]                               => 53119966a9a2e
    //          [original_url]                      => http://nz2.php.net/file_upload
    //          [original_title]                    => Handling file uploads
    //          [original_clipped_text]             => The official (multi-page) tutorial on the PHP site.
    //          [text_format]                       => text/html
    //          [original_media_url]                =>
    //          [post_id]                           => 128
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_record_data ) ;

    // -------------------------------------------------------------------------
    // Init.
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------
    // original_clipped_text ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'original_clipped_text' , $teaser_record_data ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser record (no "original_clipped_text")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_string( $teaser_record_data['original_clipped_text'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "original_clipped_text" (in teaser record - string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------
    // text_format ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'text_format' , $teaser_record_data ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser record (no "text_format")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_string( $teaser_record_data['text_format'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "text_format" (in teaser record - string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------
    // OK !
    // -------------------------------------------------------------------------

    return formatted_text_to_html(
                $teaser_record_data['original_clipped_text']    ,
                $teaser_record_data['text_format']              ,
                $core_plugapp_dirs
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_teaser_category_description()
// =============================================================================

function get_teaser_category_description(
    $teaser_category_record_data    ,
    $core_plugapp_dirs
    ) {

    // -------------------------------------------------------------------------
    // get_teaser_category_description(
    //      $teaser_category_record_data    ,
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   On SUCCESS!
    //              $html STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    // ---------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_category_record_data = Array(
    //          [created_server_datetime_UTC]       => 1401092315
    //          [last_modified_server_datetime_UTC] => 1401092315
    //          [key]                               => 5382f8db5d0c1
    //          [parent_key]                        =>
    //          [title]                             => Sample Teaser Page
    //          [description]                       =>
    //          [description_format]                => none
    //          [image_url]                         =>
    //          [sequence_number]                   =>
    //          )
    //
    // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_record_data_data ) ;

    // -------------------------------------------------------------------------
    // Init.
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------
    // description ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'description' , $teaser_category_record_data ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser category record (no "description")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_string( $teaser_category_record_data['description'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "description" (in teaser category record - string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------
    // description_format ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'description_format' , $teaser_category_record_data ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad teaser category record (no "description_format")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! is_string( $teaser_category_record_data['description_format'] ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "description_format" (in teaser category record - string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

    }

    // -------------------------------------------------------------------------
    // OK !
    // -------------------------------------------------------------------------

    return formatted_text_to_html(
                $teaser_category_record_data['description']         ,
                $teaser_category_record_data['description_format']  ,
                $core_plugapp_dirs
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// formatted_text_to_html()
// =============================================================================

function formatted_text_to_html(
    $text_base64            ,
    $text_format            ,
    $core_plugapp_dirs
    ) {

    // -------------------------------------------------------------------------
    // formatted_text_to_html(
    //      $text_base64            ,
    //      $text_format            ,
    //      $core_plugapp_dirs
    //      )
    // - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   On SUCCESS!
    //              $html STRING
    //
    //      o   On FAILURE
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    $the_raw_text = base64_decode( trim( $text_base64 ) ) ;

    // -------------------------------------------------------------------------

    if ( $text_format === 'nl2br' ) {

        // =====================================================================
        // NL2BR
        // =====================================================================

        return nl2br( $the_raw_text ) ;

        // ---------------------------------------------------------------------

    } elseif ( $text_format === 'markdown' ) {

        // =====================================================================
        // MARKDOWN
        // =====================================================================

        require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/Michelf/MarkdownExtra.inc.php' ) ;

        // ---------------------------------------------------------------------

        return \Michelf\MarkdownExtra::defaultTransform( $the_raw_text ) ;

        // ---------------------------------------------------------------------

    } elseif ( $text_format === 'bbcode' ) {

        // =====================================================================
        // BBCODE
        // =====================================================================

        require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/nbbc-1.4.5/nbbc.php' ) ;

        // ---------------------------------------------------------------------

        $bbcode = new \BBCode ;

        return $bbcode->Parse( $the_raw_text ) ;

        // ---------------------------------------------------------------------

    } elseif ( $text_format !== 'none' ) {

        // ---------------------------------------------------------------------

        $ns = __NAMESPACE__ ;
        $fn = __FUNCTION__  ;

        $safe_text_format = \htmlentities( $text_format ) ;

        $msg = <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "text/html format" ("{$safe_text_format}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( nl2br( $msg ) ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // TEXT/HTML (DEFAULT)
    // =========================================================================

    return $the_raw_text ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_topmost_teaser_category_key_and_levels()
// =============================================================================

function get_topmost_teaser_category_key_and_levels( $atts ) {

    // -------------------------------------------------------------------------
    // get_topmost_teaser_category_key_and_levels( $atts )
    // - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $topmost_teaser_category_key STRING
    //                  $levels INT
    //                  )
    //
    //              NOTE!
    //              -----
    //              It HASN'T been checked that a teaser category with the
    //              specified:-
    //                  $topmost_teaser_category_key
    //              exists.
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have:-
    //
    //      =============
    //      "Std" Version
    //      =============
    //
    //          [teaser-maker gadget="teasers-list"]
    //
    //      =============
    //      "Pro" Version
    //      =============
    //
    //          [teaser-maker gadget="teasers-list"]
    //
    //          [teaser-maker gadget="teasers-list" category="xxx"]
    //
    //          [teaser-maker gadget="teasers-list" category="yyy"]
    //
    //          [teaser-maker gadget="teasers-list" category="xxx" level="yyy"]
    //
    // In the "Pro" version, "category" and "levels" are both OPTIONAL.
    //
    // In the "Std" version, they're IGNORED.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Set the DEFAULTS...
    // =========================================================================

    $topmost_teaser_category = '' ;
    $levels = 1 ;

    // =========================================================================
    // "Std" version ?
    // =========================================================================

    if (    function_exists( '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginSetup\\is_version_name' )
            &&
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginSetup\is_version_name( 'std' )
        ) {

        return array(
                    $topmost_teaser_category    ,
                    $levels
                    ) ;

    }

    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // "PRO" VERSION!
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    // =========================================================================
    // category ?
    // =========================================================================

    if ( array_key_exists( 'category' , $atts ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_string( $atts['category'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "category" (string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $atts['category'] === trim( $atts['category'] ) ;

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

        if (    $atts['category'] !== ''
                &&
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_record_key( $atts['category'] )
            ) {

            $safe_category = htmlentities( $atts['category'] ) ;

            return <<<EOT
PROBLEM:&nbsp; Bad "category" &nbsp;&laquo; <strong>{$safe_category}</strong> &raquo;&nbsp; (Standard Dataset Manager "unique key" expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $topmost_teaser_category = $atts['category'] ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // levels ?
    // =========================================================================

    if ( array_key_exists( 'levels' , $atts ) ) {

        // ---------------------------------------------------------------------

        if ( ! is_string( $atts['levels'] ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "levels" (string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $atts['levels'] === trim( $atts['levels'] ) ;

        // ---------------------------------------------------------------------

        $max_levels = 999 ;

        // ---------------------------------------------------------------------

        if ( $atts['levels'] === '' ) {
            $levels = 1 ;

        } elseif ( strtolower( $atts['levels'] ) === 'all' ) {
            $levels = $max_levels ;

        } elseif ( ctype_digit( $atts['levels'] ) ) {

            if ( $atts['levels'] == 0 ) {
                $levels = $max_levels ;

            } elseif ( $atts['levels'] > $max_levels ) {

                return <<<EOT
PROBLEM:&nbsp; Bad "levels" (must be max. {$max_levels})
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;
            }

            $levels = $atts['levels'] ;

        } else {

            return <<<EOT
PROBLEM:&nbsp; Bad "levels" ("all" or 0 (= all) or 1 to {$max_levels} expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;


        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return array(
                $topmost_teaser_category    ,
                $levels
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_custom_teaser_layout()
// =============================================================================

function get_custom_teaser_layout(
    $all_application_dataset_definitions    ,
    $teaser_settings
    ) {

    // -------------------------------------------------------------------------
    // get_custom_teaser_layout(
    //      $all_application_dataset_definitions    ,
    //      $teaser_settings
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      On SUCCESS!
    //          ARRAY $custom_teaser_layout
    //
    //      On FAILURE
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_settings = Array(
    //          [created_server_datetime_UTC]       => 1397021148
    //          [last_modified_server_datetime_UTC] => 1397034584
    //          [key]                               => 5344d9dc6dfb1
    //          [selected_layout_slug]              => custom
    //          [custom_layout_key]                 =>
    //          [custom_style_key]                  =>
    //          [custom_scripts_key]                =>
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_settings ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // ERROR CHECKING #1...
    //
    // Custom Layout is required !
    // =========================================================================

    if ( ! array_key_exists( 'custom_layout_key' , $teaser_settings ) ) {

        return <<<EOT
PROBLEM:&nbsp; No "custom_layout_key" (in Teaser Settings)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $teaser_settings['custom_layout_key'] )
            ||
            trim( $teaser_settings['custom_layout_key'] ) === ''
        ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "custom_layout_key" (in Teaser Settings - non-blank string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // LOAD and INDEX the "TEASER LAYOUTS"...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_title_records_key_field_slug_and_record_indices_by_key(
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              ARRAY(
    //                  $dataset_title                  STRING
    //                  $array_storage_key_field_slug   STRING
    //                  $dataset_records                ARRAY
    //                  $record_indices_by_key          ARRAY
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $dataset_slug = 'teaser_layouts' ;

    // -------------------------------------------------------------------------

    $result =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_title_records_key_field_slug_and_record_indices_by_key(
            $all_application_dataset_definitions    ,
            $dataset_slug
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $result ) ;

    list(
        $teaser_layouts_dataset_title                   ,
        $teaser_layout_records                          ,
        $teaser_layouts_array_storage_key_field_slug    ,
        $teaser_layouts_record_indices_by_key
        ) = $result ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $teaser_layout_records = Array(
    //
    //          [0] => Array(
    //                      [created_server_datetime_UTC]       => 1398761346
    //                      [last_modified_server_datetime_UTC] => 1398761376
    //                      [key]                               => 535f6782aa913
    //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
    //                      [slug]                              => p-and-h-tags-floated-image-copy-1
    //                      [container_html]                    => WyoqVEVBU0VS8L2Rpdj4=
    //                      [title_html]                        => PGRpdiBjbGFz9kaXY+
    //                      [text_html]                         => PGRpdiBjbGFzcRpdj4=
    //                      [image_html]                        => PGRpdiBjbGFzPC9kaXY+
    //                      [read_more_html]                    => PGRpdiBjbGFzC9kaXY+
    //                      [date_html]                         => PGRpdiBjbGFzc9kaXY+
    //                      [spacer_html]                       =>
    //                      [description]                       =>
    //                      [image_url]                         =>
    //                      )
    //
    //          ...
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_layout_records ) ;

    // =========================================================================
    // ERROR CHECKING #2...
    //
    // Custom Layout OK ?
    // =========================================================================

    if ( ! array_key_exists( $teaser_settings['custom_layout_key'] , $teaser_layouts_record_indices_by_key ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "custom_layout_key" (in Teaser Settings - there is no such custom layout)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // Init. the output variable...
    // =========================================================================

    $custom_teaser_layout_record =
        $teaser_layout_records[
            $teaser_layouts_record_indices_by_key[
                $teaser_settings['custom_layout_key']
                ]
            ] ;

    // -------------------------------------------------------------------------

    $custom_teaser_layout = array(

        'container' => array(
            'html'  =>  base64_decode( $custom_teaser_layout_record['container_html'] )     ,
            'css'   =>  ''                                                                  ,
            'js'    =>  ''
            )   ,

        'title' => array(
            'html'  =>  base64_decode( $custom_teaser_layout_record['title_html'] )         ,
            'css'   =>  ''                                                                  ,
            'js'    =>  ''
            )   ,

        'text' => array(
            'html'  =>  base64_decode( $custom_teaser_layout_record['text_html'] )          ,
            'css'   =>  ''                                                                  ,
            'js'    =>  ''
            )   ,

        'image' => array(
            'html'  =>  base64_decode( $custom_teaser_layout_record['image_html'] )         ,
            'css'   =>  ''                                                                  ,
            'js'    =>  ''
            )   ,

        'read_more' => array(
            'html'  =>  base64_decode( $custom_teaser_layout_record['read_more_html'] )     ,
            'css'   =>  ''                                                                  ,
            'js'    =>  ''
            )   ,

        'date' => array(
            'html'  =>  base64_decode( $custom_teaser_layout_record['date_html'] )          ,
            'css'   =>  ''                                                                  ,
            'js'    =>  ''
            )   ,

        'spacer' => array(
            'html'  =>  base64_decode( $custom_teaser_layout_record['spacer_html'] )        ,
            'css'   =>  ''                                                                  ,
            'js'    =>  ''
            )

        ) ;

    // =========================================================================
    // ADD in the "TEASER STYLES" (if there are any)...
    // =========================================================================

    if ( ! array_key_exists( 'custom_style_key' , $teaser_settings ) ) {

        return <<<EOT
PROBLEM:&nbsp; No "custom_style_key" (in Teaser Settings)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    is_string( $teaser_settings['custom_style_key'] )
            &&
            trim( $teaser_settings['custom_style_key'] ) !== ''
        ) {

        // =====================================================================
        // LOAD and INDEX the "TEASER STYLES"...
        // =====================================================================

        $dataset_slug = 'teaser_styles' ;

        // ---------------------------------------------------------------------

        $result =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_title_records_key_field_slug_and_record_indices_by_key(
                $all_application_dataset_definitions    ,
                $dataset_slug
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

        list(
            $teaser_styles_dataset_title                   ,
            $teaser_style_records                          ,
            $teaser_styles_array_storage_key_field_slug    ,
            $teaser_styles_record_indices_by_key
            ) = $result ;

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $teaser_style_records = Array(
        //
        //         [0] => Array(
        //                      [created_server_datetime_UTC]       => 1398761346
        //                      [last_modified_server_datetime_UTC] => 1398761433
        //                      [key]                               => 535f6782aa95b
        //                      [layout_key]                        => 535f6782aa913
        //                      [title]                             => "P and H Tags - Floated Image" - for "Iconic One"
        //                      [slug]                              => p-and-h-tags-floated-image-copy-1-styles
        //                      [container_css]                     => RElWLnBsdWdMDsNCn0=
        //                      [title_css]                         => RElWLnBs0KfQ==
        //                      [text_css]                          => RElWLnBsdWdowLjVlbTsNCn0=
        //                      [image_css]                         => RElWLnBs0KfQ==
        //                      [read_more_css]                     => RElWLsNCn0=
        //                      [date_css]                          => RElWLnBsdWdQ7DQp9
        //                      [spacer_css]                        =>
        //                      [description]                       =>
        //                      [image_url]                         =>
        //                      )
        //
        //          ...
        //
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_style_records ) ;

        // =====================================================================
        // ERROR CHECKING #2...
        //
        // Custom style OK ?
        // =====================================================================

        if ( ! array_key_exists( $teaser_settings['custom_style_key'] , $teaser_styles_record_indices_by_key ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "custom_style_key" (in Teaser Settings - there is no such custom style)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // =====================================================================
        // Add in the style...
        // =====================================================================

        $custom_teaser_style_record =
            $teaser_style_records[
                $teaser_styles_record_indices_by_key[
                    $teaser_settings['custom_style_key']
                    ]
                ] ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['container']['css'] =
            base64_decode( $custom_teaser_style_record['container_css'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['title']['css'] =
            base64_decode( $custom_teaser_style_record['title_css'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['text']['css'] =
            base64_decode( $custom_teaser_style_record['text_css'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['image']['css'] =
            base64_decode( $custom_teaser_style_record['image_css'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['read_more']['css'] =
            base64_decode( $custom_teaser_style_record['read_more_css'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['date']['css'] =
            base64_decode( $custom_teaser_style_record['date_css'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['spacer']['css'] =
            base64_decode( $custom_teaser_style_record['spacer_css'] )
            ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // ADD in the "TEASER SCRIPTS (if there are any)...
    // =========================================================================

    if ( ! array_key_exists( 'custom_scripts_key' , $teaser_settings ) ) {

        return <<<EOT
PROBLEM:&nbsp; No "custom_scripts_key" (in Teaser Settings)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    is_string( $teaser_settings['custom_scripts_key'] )
            &&
            trim( $teaser_settings['custom_scripts_key'] ) !== ''
        ) {

        // =====================================================================
        // LOAD and INDEX the "TEASER STYLES"...
        // =====================================================================

        $dataset_slug = 'teaser_scripts' ;

        // ---------------------------------------------------------------------

        $result =
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_title_records_key_field_slug_and_record_indices_by_key(
                $all_application_dataset_definitions    ,
                $dataset_slug
                ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

        list(
            $teaser_scripts_dataset_title                   ,
            $teaser_script_records                          ,
            $teaser_scripts_array_storage_key_field_slug    ,
            $teaser_scripts_record_indices_by_key
            ) = $result ;

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $teaser_script_records = Array(
        //
        //          [0] => Array(
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
        //          ...
        //
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $teaser_script_records ) ;

        // =====================================================================
        // ERROR CHECKING #2...
        //
        // Custom script OK ?
        // =====================================================================

        if ( ! array_key_exists( $teaser_settings['custom_scripts_key'] , $teaser_scripts_record_indices_by_key ) ) {

            return <<<EOT
PROBLEM:&nbsp; Bad "custom_scripts_key" (in Teaser Settings - there are no such custom scripts)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // =====================================================================
        // Add in the script...
        // =====================================================================

        $custom_teaser_script_record =
            $teaser_script_records[
                $teaser_scripts_record_indices_by_key[
                    $teaser_settings['custom_scripts_key']
                    ]
                ] ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['container']['js'] =
            base64_decode( $custom_teaser_script_record['container_js'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['title']['js'] =
            base64_decode( $custom_teaser_script_record['title_js'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['text']['js'] =
            base64_decode( $custom_teaser_script_record['text_js'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['image']['js'] =
            base64_decode( $custom_teaser_script_record['image_js'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['read_more']['js'] =
            base64_decode( $custom_teaser_script_record['read_more_js'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['date']['js'] =
            base64_decode( $custom_teaser_script_record['date_js'] )
            ;

        // ---------------------------------------------------------------------

        $custom_teaser_layout['spacer']['js'] =
            base64_decode( $custom_teaser_script_record['spacer_js'] )
            ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $custom_teaser_layout = Array(
    //
    //          [container] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  "xxx"
    //              )
    //
    //          [title] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  "xxx"
    //              )
    //
    //          [text] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  "xxx"
    //              )
    //
    //          [image] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  "xxx"
    //              )
    //
    //          [read_more] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  "xxx"
    //              )
    //
    //          [date] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  "xxx"
    //              )
    //
    //          [spacer] => Array(
    //              [html]  =>  "xxx"
    //              [css]   =>  "xxx"
    //              [js]    =>  "xxx"
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $custom_teaser_layout ) ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $custom_teaser_layout ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// to_short_url()
// =============================================================================

function to_short_url( $input_url ) {

    // -------------------------------------------------------------------------
    // to_short_url( $input_url )
    // - - - - - - - - - - - - -
    // Strips any leading" "http://" from the supplied URL.
    //
    // Ie:-
    //      "http://www.example.com"  -->  "www.example.com"
    //      "www.example.com"         -->  "www.example.com"   (no change)
    //      "ftp://example.com"       -->  "ftp://example.com" (no change)
    //
    // RETURNS
    //      The fixed URL on success.
    //      The original URL on failure.
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
    //      -------     -------------------------------------------------------
    //      5.4.7       Fixed host recognition when scheme is omitted and a
    //                  leading component separator is present.
    //      5.3.3       Removed the E_WARNING that was emitted when URL parsing
    //                  failed.
    //      5.1.2       Added the component parameter.
    // -------------------------------------------------------------------------

    $url_components = parse_url( $input_url ) ;

    // -------------------------------------------------------------------------

    if ( $url_components === FALSE ) {
        return $input_url ;
    }

    // -------------------------------------------------------------------------

    if (    array_key_exists( 'scheme' , $url_components )
            &&
            strtolower( $url_components['scheme'] ) === 'http'
        ) {

        $output_url = substr( $input_url , strlen( 'http' ) ) ;

        $output_url = ltrim( $output_url , ':' ) ;

        $output_url = ltrim( $output_url , '/' ) ;

        return $output_url ;

    }

    // -------------------------------------------------------------------------

    return $input_url ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// to_full_url()
// =============================================================================

function to_full_url( $input_url ) {

    // -------------------------------------------------------------------------
    // to_full_url( $input_url )
    // - - - - - - - - - - - - -
    // Prepends a leading" "http://" to the supplied URL, if necessary.
    //
    // Ie:-
    //      "www.example.com"         -->  "http://www.example.com"
    //      "http://www.example.com"  -->  "http://www.example.com" (no change)
    //      "ftp://example.com"       -->  "ftp://example.com"      (no change)
    //
    // RETURNS
    //      The fixed URL on success.
    //      The original URL on failure.
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
    //      -------     -------------------------------------------------------
    //      5.4.7       Fixed host recognition when scheme is omitted and a
    //                  leading component separator is present.
    //      5.3.3       Removed the E_WARNING that was emitted when URL parsing
    //                  failed.
    //      5.1.2       Added the component parameter.
    // -------------------------------------------------------------------------

    $url_components = parse_url( $input_url ) ;

    // -------------------------------------------------------------------------

    if ( $url_components === FALSE ) {
        return $input_url ;
    }

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'host' , $url_components ) ) {
        return $input_url ;
    }

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'scheme' , $url_components ) ) {
        return 'http://' . $input_url ;
    }

    // -------------------------------------------------------------------------

    return $input_url ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================


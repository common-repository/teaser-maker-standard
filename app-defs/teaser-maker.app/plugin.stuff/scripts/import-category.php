<?php

// *****************************************************************************
// TEASER-MAKER.APP / PLUGIN.STUFF / SCRIPTS / IMPORT-CATEGORY.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_datasetDef_teaserMaker ;

// =============================================================================
// import_category()
// =============================================================================

function import_category(
    $plugin_root_dirspec
    ) {

    // -------------------------------------------------------------------------
    // import_category()
    // - - - - - - - - -
    // Displays, and handles the submission of, the:-
    //      "Select Teaser Category Export File to Import"
    //
    // form.
    //
    // NOTE!
    // -----
    // On entry:-
    //      o   WordPress has been started.
    //      o   But NO Teasers or Plugin Workshop routines have been loaded.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      DISPLAY FORM
    //      ------------
    //
    //          $_GET = array()
    //
    //          $_POST = array()
    //
    //          $_FILES = array()
    //
    //      FORM SUBMITTED
    //      --------------
    //
    //          $_GET = array()
    //
    //          $_POST = array()
    //
    //          $_FILES = array(
    //              [teaser_category_to_import] => Array(
    //                  [name]      =>  teaser-maker-standard-user-manual-exported-12-May-2014-at-05-41-31.dat
    //                  [type]      =>  application/x-ns-proxy-autoconfig
    //                  [tmp_name]  =>  /tmp/phpL2ycfh
    //                  [error]     =>  0
    //                  [size]      =>  3340
    //                  )
    //              )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_GET , '$_GET' ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_POST , '$_POST' ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_FILES , '$_FILES' ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $_SERVER , '$_SERVER' ) ;

    // =========================================================================
    // Load the APPS API and TEST/DEBUG routines...
    // =========================================================================

    require_once( $plugin_root_dirspec . '/apps-api.php' ) ;

    require_once( $plugin_root_dirspec . '/test-debug.php' ) ;

    // =========================================================================
    // Get the CORE PLUGAPP DIRS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
    //      $path_in_plugin         ,
    //      $app_handle = NULL
    //      )
    // - - - - - - - - - - - - - - - - - -
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

    $path_in_plugin = __FILE__ ;

    $app_handle = 'teaser-maker' ;

    // -------------------------------------------------------------------------

    $core_plugapp_dirs =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
            $path_in_plugin     ,
            $app_handle
            ) ;

    // -------------------------------------------------------------------------
    // Here we should gave (eg):-
    //
    //      $core_plugapp_dirs = Array(
    //          [plugin_root_dir]              => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant
    //          [plugins_includes_dir]         => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/includes
    //          [plugins_app_defs_dir]         => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/app-defs
    //          [dataset_manager_includes_dir] => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/includes/dataset-manager
    //          [apps_dot_app_dir]             => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/app-defs/teaser-maker.app
    //          [apps_plugin_stuff_dir]        => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/app-defs/teaser-maker.app/plugin.stuff
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $core_plugapp_dirs ) ;

    // =========================================================================
    // Handle FORM SUBMISSION...
    // =========================================================================

    if ( count( $_FILES ) > 0 ) {

        require_once( dirname( __FILE__ ) . '/import-submission-handler.php' ) ;

        handle_form_submission(
            $core_plugapp_dirs
            ) ;

        return ;

    }

    // =========================================================================
    // DISPLAY the "Select Teaser Category Export File to Import" FORM...
    // =========================================================================

    require_once( $core_plugapp_dirs['plugins_includes_dir'] . '/string-utils.php' ) ;

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

//  $cancel_href = stripslashes( $_SERVER['HTTP_REFERER'] ) ;

    // -------------------------------------------------------------------------

    $caller_apps_includes_dir = $core_plugapp_dirs['dataset_manager_includes_dir'] ;
    $question_front_end       = FALSE ;
    $dataset_slug             = 'teaser_categories' ;

    // -------------------------------------------------------------------------

    $_GET['application'] = 'teaser-maker' ;

    // -------------------------------------------------------------------------

    $cancel_href =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_manage_dataset_url(
            $caller_apps_includes_dir   ,
            $question_front_end         ,
            $dataset_slug
            ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $cancel_href ) ) {
        echo '<br /><br />' , nl2br( $cancel_href[0] ) , '<br /><br />' ;
        return ;
    }

    // -------------------------------------------------------------------------

    echo <<<EOT
<div style="padding:1em 3em">

    <h2>Import Teaser Category</h2>

    <p><b>Please select the Teaser Category export file you want to import.</b>&nbsp;
    Then press "Submit".</p>

    <p><i>NOTE!&nbsp; The file to import should be one that was previously exported
    by this (Teaser Maker) plugin.</i></p>

    <form
        method="post"
        action=""
        name="select_teaser_category_export_file_to_import"
        enctype="multipart/form-data"
        style="background-color:#F0F8FF; padding:1em"
        >

        <b>Please select the Teaser Category export file to import</b>:<br />

        <input
            type="file"
            name="teaser_category_export_file_to_import"
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
// START WORDPRESS...
// =============================================================================

    $plugin_root_dirspec = dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) ;

    // -------------------------------------------------------------------------

    $wp_root_dir = dirname( dirname( dirname( $plugin_root_dirspec ) ) ) ;

    // -------------------------------------------------------------------------

    /**
     * Tells WordPress to load the WordPress theme and output it.
     *
     * @var bool
     */
    define( 'WP_USE_THEMES' , FALSE ) ;

    /** Loads the WordPress Environment and Template */
    require( $wp_root_dir . '/wp-blog-header.php' ) ;

// =============================================================================
// Run the Submission Handler...
// =============================================================================

    import_category( $plugin_root_dirspec ) ;

// =============================================================================
// That's that!
// =============================================================================


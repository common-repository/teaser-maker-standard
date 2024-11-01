<?php

// ***************************************************************************
// TEASER-MAKER.APP / PLUGIN.STUFF / SHORTCODES / LOADER.PHP
// (For WordPress Front-End)
// (C) 2014 Peter Newman. All Rights Reserved
// ***************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_shortcodes ;

    // -------------------------------------------------------------------------
    // WORDPRESS SHORTCODES API - OVERVIEW
    // ===================================
    // From:  http://codex.wordpress.org/Shortcode_API
    //
    // SYNOPSIS
    //
    //      // [bartag foo="foo-value"]
    //      function bartag_func( $atts ) {
    //
    //          extract( shortcode_atts( array(
    //              'foo' => 'something',
    //              'bar' => 'something else',
    //              ), $atts ) );
    //
    //          return "foo = {$foo}";
    //
    //      }
    //
    //      add_shortcode( 'bartag', 'bartag_func' );
    //
    // ---
    //
    // Shortcode attributes are entered like this:
    //      [myshortcode foo="bar" bar="bing"]
    //
    // These attributes will be converted into an associative array like the
    // following, passed to the handler function as its $atts parameter:
    //      array( 'foo' => 'bar', 'bar' => 'bing' )
    //
    // The array keys are the attribute names; array values are the
    // corresponding attribute values. In addition, the zeroeth entry
    // ($atts[0]) will hold the string that matched the shortcode regex, but
    // ONLY IF that is different from the callback name. See the discussion
    // of attributes, below.
    //
    // ---
    //
    // Any string returned (not echoed) by the shortcode handler will be
    // inserted into the post body in place of the shortcode itself.
    //
    // ---
    //
    // The parameters passed to the shortcode handler are:-
    //
    //      $atts    - an associative array of attributes, or an empty string if no attributes are given
    //      $content - the enclosed content (if the shortcode is used in its enclosing form)
    //      $tag     - the shortcode tag, useful for shared callback functions
    //
    // Eg:-
    //
    //      my_shortcode_handler( $atts , $content , $tag )
    //
    // -------------------------------------------------------------------------

// =============================================================================
// main_shortcode_handler()
// =============================================================================

function main_shortcode_handler( $atts , $content , $tag ) {

    // -------------------------------------------------------------------------
    // The syntax is:-
    //
    //      [teaser-maker gadget="<gadget-name>" ...]
    //      [teaser_maker gadget="<gadget-name>" ...]
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $atts = Array(
    //                  [gadget] => teasers-list
    //                  )
    //
    // -------------------------------------------------------------------------

//ob_start() ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $atts ) ;
//return ob_get_clean() ;

    // =========================================================================
    // ERROR CHECKING (1)...
    // =========================================================================

    $err_div_style = 'color:#AA0000; border:1px solid #000000; padding:0 0.33em' ;

    // -------------------------------------------------------------------------
    // $atts
    // -------------------------------------------------------------------------

    if ( ! is_array( $atts ) ) {
        $atts = array() ;
    }

    // -------------------------------------------------------------------------
    // gadget ?
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'gadget' , $atts ) ) {
        $atts['gadget'] = 'teasers-list' ;
    }

    // -------------------------------------------------------------------------

    $base_namespace_name =
        '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_'
        ;

    // -------------------------------------------------------------------------

    $allowed_gadgets = array(
        'teasers-list'      =>  array(
            'filespec'          =>  dirname( __FILE__ ) . '/teasers-list/process.php'   ,
            'function_name'     =>  $base_namespace_name . 'teasersList\\process'
            )
        ) ;

    // -------------------------------------------------------------------------

    if (    ! is_string( $atts['gadget'] )
            ||
            trim( $atts['gadget'] ) === NULL
            ||
            strlen( $atts['gadget'] ) > 32
        ) {

        return <<<EOT
<div style="{$err_div_style}">
SHORTCODE ERROR:&nbsp; <strong>Bad "gadget" parameter (1 to 32 character string expected)</strong><br />
For shortcode:&nbsp; {$tag}
</div>
EOT;

    }

    // -------------------------------------------------------------------------

    $safe_gadget_name = htmlentities( $atts['gadget'] ) ;

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $atts['gadget'] , $allowed_gadgets ) ) {

        return <<<EOT
<div style="{$err_div_style}">
SHORTCODE ERROR:&nbsp; <strong>Unrecognised/unsupported gadget ("{$safe_gadget_name}")</strong><br />
For shortcode:&nbsp; {$tag}
</div>
EOT;

    }

    // =========================================================================
    // Get the specified gadget's HTML...
    // =========================================================================

    $selected_gadget = $allowed_gadgets[ $atts['gadget'] ] ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_gadget = Array(
    //          [filespec]      => /opt/lampp/htdocs/plugdev/.../shortcodes/sign-up-form/sign-up-form.php
    //          [function_name] => \greatKiwi_byFernTec_basepressUsers_v0x1_signUpForm\sign_up_form
    //          )
    //
    // -------------------------------------------------------------------------

//ob_start() ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_gadget ) ;
//return ob_get_clean() ;

    // =========================================================================
    // ERROR CHECKING (2)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // filespec ?
    // -------------------------------------------------------------------------

    if (    ! array_key_exists( 'filespec' , $selected_gadget )
            ||
            ! is_string( $selected_gadget['filespec'] )
            ||
            trim( $selected_gadget['filespec'] ) === ''
            ||
            strlen( $selected_gadget['filespec'] ) > 512
        ) {

        return <<<EOT
<div style="{$err_div_style}">
SHORTCODE ERROR:&nbsp; <strong>No or bad gadget "filespec" (1 to 512 character string expected)</strong><br />
For shortcode:&nbsp; {$tag}<br />
And gadget:&nbsp; {$safe_gadget_name}
</div>
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_file( $selected_gadget['filespec'] ) ) {

        return <<<EOT
<div style="{$err_div_style}">
SHORTCODE ERROR:&nbsp; <strong>Bad gadget "filespec" (no such file)</strong><br />
For shortcode:&nbsp; {$tag}<br />
And gadget:&nbsp; {$safe_gadget_name}
</div>
EOT;

    }

    // -------------------------------------------------------------------------
    // function_name ?
    // -------------------------------------------------------------------------

    if (    ! array_key_exists( 'function_name' , $selected_gadget )
            ||
            ! is_string( $selected_gadget['function_name'] )
            ||
            trim( $selected_gadget['function_name'] ) === ''
            ||
            strlen( $selected_gadget['function_name'] ) > 512
        ) {

        return <<<EOT
<div style="{$err_div_style}">
SHORTCODE ERROR:&nbsp; <strong>No or bad gadget "function_name" (1 to 512 character string expected)</strong><br />
For shortcode:&nbsp; {$tag}<br />
And gadget:&nbsp; {$safe_gadget_name}
</div>
EOT;

    }

    // =========================================================================
    // LOAD the shortcode FILE...
    // =========================================================================

    require_once( $selected_gadget['filespec'] ) ;

    // =========================================================================
    // ERROR CHECKING (3)...
    // =========================================================================

    if ( ! function_exists( $selected_gadget['function_name'] ) ) {

        return <<<EOT
<div style="{$err_div_style}">
SHORTCODE ERROR:&nbsp; <strong>Bad gadget "function_name" (no such function)</strong><br />
For shortcode:&nbsp; {$tag}<br />
And gadget:&nbsp; {$safe_gadget_name}
</div>
EOT;

    }

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

    $plugin_slug_dashed = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_slug_dashed() ;

    $app_handle = $plugin_slug_dashed ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $app_handle ) ;

    // -------------------------------------------------------------------------

    $core_plugapp_dirs = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs(
                                $path_in_plugin     ,
                                $app_handle
                                ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $core_plugapp_dirs ) ;

    // =========================================================================
    // CALL the shortcode FUNCTION...
    // =========================================================================

    return $selected_gadget['function_name'](
                $atts                   ,
                $content                ,
                $tag                    ,
                $plugin_slug_dashed     ,
                $core_plugapp_dirs
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// Add the shortcode...
// =============================================================================

    add_shortcode(
        'teaser-maker'                                      ,
        '\\' . __NAMESPACE__ . '\\main_shortcode_handler'
        ) ;

    // -------------------------------------------------------------------------

    add_shortcode(
        'teaser_maker'                                      ,
        '\\' . __NAMESPACE__ . '\\main_shortcode_handler'
        ) ;

    // -------------------------------------------------------------------------

    add_shortcode(
        'teaser-maker-std'                              ,
        '\\' . __NAMESPACE__ . '\\main_shortcode_handler'
        ) ;

    // -------------------------------------------------------------------------

    add_shortcode(
        'teaser_maker_std'                              ,
        '\\' . __NAMESPACE__ . '\\main_shortcode_handler'
        ) ;

    // -------------------------------------------------------------------------

    add_shortcode(
        'teaser-maker-std-v0x1x114'           ,
        '\\' . __NAMESPACE__ . '\\main_shortcode_handler'
        ) ;

    // -------------------------------------------------------------------------

    add_shortcode(
        'teaser_maker_std_v0x1x114'           ,
        '\\' . __NAMESPACE__ . '\\main_shortcode_handler'
        ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $GLOBALS['shortcode_tags'] ) ;

// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------
// What follows is the code if you want the "gadget" to be the main
// Dataset Manager home screen...
// -----------------------------------------------------------------------------
// -----------------------------------------------------------------------------

/*
    // =========================================================================
    // GET the various DIRs used...
    // =========================================================================

//  $plugin_root_dir = dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ;
    $plugin_root_dir = $core_plugapp_dirs['plugin_root_dir'] ;

    // -------------------------------------------------------------------------

//  $plugin_includes_dir = $plugin_root_dir . '/includes' ;
    $plugin_includes_dir = $core_plugapp_dirs['plugins_includes_dir'] ;

    // -------------------------------------------------------------------------

//  $plugin_dataset_defs_dir = $plugin_root_dir . '/dataset-manager-dataset-defs' ;
    $plugin_dataset_defs_dir = $core_plugapp_dirs['plugins_app_defs_dir'] ;

    // =========================================================================
    // LOAD the STANDARD DATASET MANAGER...
    // =========================================================================

    require_once( $plugin_includes_dir . '/dataset-manager/home.php' ) ;

    // =========================================================================
    // CALL the STANDARD DATASET MANAGER...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\page_controller_wordpress_front_end(
    //      $dataset_manager_dataset_defs_dir               ,
    //      $caller_plugins_includes_dir                    ,
    //      $application_title                              ,
    //      $application_href                               ,
    //      $dataset_manager_home_page_title
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the currently selected Standard Dataset Manager page.
    //
    // The first time this routine is called, the currently selected Standard
    // Dataset Manager page will be the Standard Dataset Manager HOME page.
    //
    // But from the on, the currently selected Standard Dataset Manager page
    // may be one of the sub-pages selected from the home page, in order to
    // add, edit or delete records from whichever home page listed dataset was
    // selected for editing.
    //
    // NOTE!
    // =====
    // The returned page may be the page requested proper.  Or it may be just
    // the page header/footer, and an error message.
    //
    // RETURNS:
    //      $page_html STRING
    // -------------------------------------------------------------------------

    $caller_app_slash_plugins_global_namespace = 'researchAssistant_byFernTec' ;

    $dataset_manager_dataset_defs_dir = $plugin_dataset_defs_dir ;

    $caller_plugins_includes_dir = $plugin_includes_dir ;

//  $application_title = 'Research Assistant' ;
    $application_title = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugin_title() ;

    $application_href = '' ;

    $dataset_manager_home_page_title = 'Dataset Manager' ;

    // -------------------------------------------------------------------------

    return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\page_controller_wordpress_front_end(
                $caller_app_slash_plugins_global_namespace      ,
                $dataset_manager_dataset_defs_dir               ,
                $caller_plugins_includes_dir                    ,
                $application_title                              ,
                $application_href                               ,
                $dataset_manager_home_page_title
                ) ;
*/

// =============================================================================
// That's that!
// =============================================================================


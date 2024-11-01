<?php

// *****************************************************************************
// GREAT-KIWI / INCLUDES / DATASET-MANAGER / COMMON.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// CONSTANTS / GLOBAL Variables...
// =============================================================================

//  define( 'STANDARD_DATASET_MANAGER_FIELD_TYPE_CREATED_SERVER_DATETIME_UTC'       , 'created-server-datetime-utc'       ) ;
//  define( 'STANDARD_DATASET_MANAGER_FIELD_TYPE_LAST_MODIFIED_SERVER_DATETIME_UTC' , 'last-modified-server-datetime-utc' ) ;
//  define( 'STANDARD_DATASET_MANAGER_FIELD_TYPE_UNIQUE_KEY'                        , 'unique-key'                        ) ;

    // -------------------------------------------------------------------------

    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['calling_application_title'] = 'Home' ;

    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['calling_application_wordpress_admin_href'] = '' ;

// =============================================================================
// Support Routines...
// =============================================================================

    require_once( dirname( __FILE__ ) . '/record-key-support.php' ) ;

// =============================================================================
// get_zebra_controls_with_no_default_value()
// =============================================================================

function get_zebra_controls_with_no_default_value() {
    return array(
                'submit'        ,
                'button'
                ) ;
}

// =============================================================================
// pr()
// =============================================================================

    if ( ! function_exists( 'pr' ) ) {

        function pr( $value , $name = NULL ) {
            if ( $name === NULL ) {
                echo '<pre>' ;
            } else {
                echo '<h2>' , $name , '</h2><pre>' ;
            }
            print_r( $value ) ;
            echo '</pre>' ;
        }

    }

// =============================================================================
// get_home_page_url()
// =============================================================================

function get_home_page_url(
    $caller_apps_includes_dir       ,
    $question_front_end
    ) {

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

    if ( $question_front_end ) {

        // ---------------------------------------------------------------------

        require_once( $caller_apps_includes_dir . '/url-utils.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
        //      $query_changes = array()        ,
        //      $question_amp = FALSE           ,
        //      $question_die_on_error = FALSE
        //      ) ;
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Attempts to retrieve the current page URL from $_SERVER.
        //
        // If successful, returns the URL with the query part adjusted as
        // requested.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          -----------
        //          $query_adjusted_current_page_url STRING
        //
        //      o   On FAILURE!
        //          -----------
        //          If $question_die_on_error = TRUE
        //              Doesn't return
        //          If $question_die_on_error = FALSE
        //              array( $error_message STRING )
        // -------------------------------------------------------------------------

        $query_changes = array(
            'action'        =>  NULL        ,
            'dataset_slug'  =>  NULL        ,
            'record_key'    =>  NULL
            ) ;

        $question_amp          = FALSE ;
        $question_die_on_error = FALSE ;

        return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\get_query_adjusted_current_page_url(
                    $query_changes          ,
                    $question_amp           ,
                    $question_die_on_error
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

//      return $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['calling_application_wordpress_admin_href'] ;

        // ---------------------------------------------------------------------

        return rtrim( \admin_url() , '/' ) . <<<EOT
/admin.php?page={$_GET['page']}
EOT;
        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_page_header()
// =============================================================================

function get_page_header(
    $page_title                     ,
    $caller_apps_includes_dir       ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_page_header(
    //      $page_title                     ,
    //      $caller_apps_includes_dir       ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Returns the page header HTML - for the currently running plugin - and
    // with the specified title.
    //
    // Dies() on error.
    // -------------------------------------------------------------------------

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

    $href = get_home_page_url(
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $href ) ) {
        die( $href[0] ) ;
    }

    // -------------------------------------------------------------------------

    return <<<EOT
<h3><a  href="{$href}"
        style="text-decoration:none"
        >{$GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['calling_application_title']}</a> &raquo; {$page_title}</h3>
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_sub_page_header()
// =============================================================================

function get_sub_page_header(
    $page_title                 ,
    $page_title_href            ,
    $sub_page_title             ,
    $caller_apps_includes_dir   ,
    $question_front_end         ,
    $buttons_right = ''
    ) {

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

    $href = get_home_page_url(
                $caller_apps_includes_dir   ,
                $question_front_end
                ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $href ) ) {
        die( $href[0] ) ;
    }

    // -------------------------------------------------------------------------

    return <<<EOT
<h3><a  href="{$href}"
        style="text-decoration:none"
        >{$GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['calling_application_title']}</a> &raquo; <a
        href="{$page_title_href}"
        style="text-decoration:none"
        >{$page_title}</a></h3>
<div>
    <h2 style="display:inline-block">{$sub_page_title}</h2>{$buttons_right}
</div>
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_dataset_record_indices_by_key()
// =============================================================================

function get_dataset_record_indices_by_key(
    $dataset_title      ,
    $dataset_records    ,
    $key_field_slug
    ) {

//pr( func_get_args() ) ;

    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_record_indices_by_key(
    //      $dataset_title      ,
    //      $dataset_records    ,
    //      $key_field_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   (array) $record_indices_by_id on SUCCESS
    //      o   (string) $error_message on FAILURE
    // -------------------------------------------------------------------------

    $record_indices_by_key = array() ;

    // -------------------------------------------------------------------------

    foreach ( $dataset_records as $this_record_index => $this_record_data ) {

        // ---------------------------------------------------------------------

        if ( ! isset( $this_record_data[ $key_field_slug ] ) ) {

//          echo '<pre>' ; debug_print_backtrace() ; echo '</pre>' ;

            return <<<EOT
PROBLEM: Bad "{$dataset_title}" dataset record (it's "{$key_field_slug}" field is missing)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // -------------------------------------------------------------------------
        // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
        // is_record_key(
        //      $candidate_record_key
        //      )
        // - - - - - - - - - - - - - - - - -
        // RETURNS
        //      o   On SUCCESS
        //              TRUE
        //
        //      o   On FAILURE
        //              FALSE
        // -------------------------------------------------------------------------

        if ( ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\is_record_key(
                    $this_record_data[ $key_field_slug ]
                    )
            ) {

//          echo '<pre>' ; debug_print_backtrace() ; echo '</pre>' ;

            return <<<EOT
PROBLEM: Bad "{$dataset_title}" dataset record (it's "{$key_field_slug}" field contains an invalid value)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( array_key_exists( $this_record_data[ $key_field_slug ] , $record_indices_by_key ) ) {

//          echo '<pre>' ; debug_print_backtrace() ; echo '</pre>' ;

            return <<<EOT
PROBLEM: Bad "{$dataset_title}" dataset (two or more records have the same "{$key_field_slug}" field value)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $record_indices_by_key[ $this_record_data[ $key_field_slug ] ] = $this_record_index ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return $record_indices_by_key ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_dataset_key_field_slug()
// =============================================================================

function get_dataset_key_field_slug(
    $all_application_dataset_definitions    ,
    $dataset_slug
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_key_field_slug(
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the dataset's (array storage) key field slug.
    //
    // RETURNS
    //      o   $array_storage_key_field_slug STRING on SUCCESS
    //      o   array( $error_message STRING ) on FAILURE
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $dataset_slug , $all_application_dataset_definitions ) ) {

        $msg = <<<EOT
PROBLEM: Dataset "{$dataset_slug}" not found (in "all_application_dataset_definitions")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( ! isset( $all_application_dataset_definitions[ $dataset_slug ]['array_storage_key_field_slug'] ) ) {

        $msg = <<<EOT
PROBLEM: Key field for dataset "{$dataset_slug}" not found (in "all_application_dataset_definitions")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    $key_field_slug = $all_application_dataset_definitions[ $dataset_slug ]['array_storage_key_field_slug'] ;

    // -------------------------------------------------------------------------

    if (    ! is_string( $key_field_slug )
            ||
            trim( $key_field_slug ) === ''
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_varname( $key_field_slug )
            ||
            strlen( $key_field_slug ) > 64
        ) {

        $msg = <<<EOT
PROBLEM: Bad key field for dataset "{$dataset_slug}" (defined in "all_application_dataset_definitions" + "array_storage_key_field_slug" - a max. 64 character, variable name like string was expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    return $key_field_slug ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_dataset_key_field_slug_and_record_indices_by_key()
// =============================================================================

function get_dataset_key_field_slug_and_record_indices_by_key(
    $all_application_dataset_definitions    ,
    $dataset_slug                           ,
    $dataset_title                          ,
    $dataset_records
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_key_field_slug_and_record_indices_by_key(
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug                           ,
    //      $dataset_title                          ,
    //      $dataset_records
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   On SUCCESS
    //              ARRAY(
    //                  $key_field_slug        STRING
    //                  $record_indices_by_key ARRAY
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_key_field_slug(
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the dataset's (array storage) key field slug.
    //
    // RETURNS
    //      o   $array_storage_key_field_slug STRING on SUCCESS
    //      o   array( $error_message STRING ) on FAILURE
    // -------------------------------------------------------------------------

    $key_field_slug = get_dataset_key_field_slug(
                            $all_application_dataset_definitions    ,
                            $dataset_slug
                            ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $key_field_slug ) ) {
        return $key_field_slug[0] ;
    }

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_record_indices_by_key(
    //      $dataset_title      ,
    //      $dataset_records    ,
    //      $key_field_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   (array) $record_indices_by_id on SUCCESS
    //      o   (string) $error_message on FAILURE
    // -------------------------------------------------------------------------

    $record_indices_by_key = get_dataset_record_indices_by_key(
                                $dataset_title      ,
                                $dataset_records    ,
                                $key_field_slug
                                ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $record_indices_by_key ) ) {
        return $record_indices_by_key ;
    }

    // -------------------------------------------------------------------------

    return array(
        $key_field_slug         ,
        $record_indices_by_key
        ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_dataset_title()
// =============================================================================

function get_dataset_title(
    $selected_datasets_dmdd     ,
    $dataset_slug
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_title(
    //      $selected_datasets_dmdd     ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          $dataset_title STRING
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd = array(
    //          'dataset_slug'                      =>  'plugins'       ,
    //          'dataset_name_singular'             =>  'plugin'        ,
    //          'dataset_name_plural'               =>  'plugins'       ,
    //          'dataset_title_singular'            =>  'Plugin'        ,
    //          'dataset_title_plural'              =>  'Plugins'       ,
    //          'basepress_dataset_handle'          =>  array(...)      ,
    //          'dataset_records_table'             =>  array(...)      ,
    //          'zebra_form'                        =>  array(...)      ,
    //          'array_storage_record_structure'    =>  array(...)      ,
    //          'array_storage_key_field_slug'      =>  'key'           ,
    //          'custom_actions'                    =>  array(...)
    //          )
    //
    // -------------------------------------------------------------------------

    if ( ! array_key_exists( 'dataset_slug' , $selected_datasets_dmdd ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; No "dataset_slug" (in dataset definition)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $selected_datasets_dmdd['dataset_slug'] )
            ||
            trim( $selected_datasets_dmdd['dataset_slug'] ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug" (in dataset definition - non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $dataset_slug )
            ||
            trim( $dataset_slug ) === ''
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "dataset_slug" (non-empty string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if ( $selected_datasets_dmdd['dataset_slug'] !== $dataset_slug ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Dataset slug mismatch
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    array_key_exists( 'dataset_title_plural' , $selected_datasets_dmdd )
            &&
            is_string( $selected_datasets_dmdd['dataset_title_plural'] )
            &&
            trim( $selected_datasets_dmdd['dataset_title_plural'] ) !== ''
            &&
            strlen( $selected_datasets_dmdd['dataset_title_plural'] ) <= 128
        ) {

        // ---------------------------------------------------------------------

        return $selected_datasets_dmdd['dataset_title_plural'] ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\to_title( $dataset_slug ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_dataset_title_records_key_field_slug_and_record_indices_by_key()
// =============================================================================

function get_dataset_title_records_key_field_slug_and_record_indices_by_key(
    $all_application_dataset_definitions    ,
    $dataset_slug
    ) {

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
    //                  $dataset_records                ARRAY
    //                  $array_storage_key_field_slug   STRING
    //                  $record_indices_by_key          ARRAY
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Get the SELECTED DATASETS DMDD (Dataset Manager Dataset Definition)...
    // =========================================================================

    if ( ! array_key_exists( $dataset_slug , $all_application_dataset_definitions ) ) {

        return <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "dataset_slug" (not found in application's dataset definitions)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    $selected_datasets_dmdd = $all_application_dataset_definitions[ $dataset_slug ] ;

    // =========================================================================
    // GET the DATASET TITLE...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_title(
    //      $selected_datasets_dmdd     ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          $dataset_title STRING
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    $dataset_title = get_dataset_title(
                        $selected_datasets_dmdd     ,
                        $dataset_slug
                        ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $dataset_title ) ) {
        return $dataset_title[0] ;
    }

    // =========================================================================
    // Get the DATASET RECORDS...
    // =========================================================================

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

    // -------------------------------------------------------------------------

    $dataset_records =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\load_numerically_indexed(
            $dataset_slug               ,
            $question_die_on_error
            ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $dataset_records ) ) {
        return $dataset_records ;
    }

    // =========================================================================
    // Get the KEY FIELD SLUG and RECORD INDICES BY KEY...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_dataset_key_field_slug_and_record_indices_by_key(
    //      $all_application_dataset_definitions    ,
    //      $dataset_slug                           ,
    //      $dataset_title                          ,
    //      $dataset_records
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS:-
    //      o   On SUCCESS
    //              ARRAY(
    //                  $key_field_slug        STRING
    //                  $record_indices_by_key ARRAY
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_dataset_key_field_slug_and_record_indices_by_key(
            $all_application_dataset_definitions    ,
            $dataset_slug                           ,
            $dataset_title                          ,
            $dataset_records
            ) ;

    // ---------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // ---------------------------------------------------------------------

    list(
        $array_storage_key_field_slug   ,
        $record_indices_by_key
        ) = $result ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return array(
                $dataset_title                  ,
                $dataset_records                ,
                $array_storage_key_field_slug   ,
                $record_indices_by_key
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// get_add_edit_form_cancel_href_and_onclick()
// =============================================================================

function get_add_edit_form_cancel_href_and_onclick(
    $caller_app_slash_plugins_global_namespace      ,
    $question_front_end                             ,
    $dataset_slug
    ) {

//pr( $dataset_slug ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_add_edit_form_cancel_href_and_onclick(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $question_front_end                             ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // NOTE!
    // -----
    // $caller_app_slash_plugins_global_namespace is no longer used or needed.
    // The value supplied is IGNORED.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          array(
    //              $cancel_href STRING
    //              $onclick STRING
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    if ( $question_front_end ) {

        // ---------------------------------------------------------------------

/*
        $fn =   <<<EOT
\\{$caller_app_slash_plugins_global_namespace}\\get_caller_app_slash_plugins_includes_dir
EOT;

        // ---------------------------------------------------------------------

        require_once( $fn() . '/url-utils.php' ) ;
*/

        // ---------------------------------------------------------------------

        require_once(
            \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_plugins_includes_dir( __FILE__ ) .
            '/url-utils.php'
            ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
        //      $query_changes = array()        ,
        //      $question_amp = FALSE           ,
        //      $question_die_on_error = FALSE
        //      ) ;
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Attempts to retrieve the current page URL from $_SERVER.
        //
        // If successful, returns the URL with the query part adjusted as
        // requested.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          -----------
        //          $query_adjusted_current_page_url STRING
        //
        //      o   On FAILURE!
        //          -----------
        //          If $question_die_on_error = TRUE
        //              Doesn't return
        //          If $question_die_on_error = FALSE
        //              array( $error_message STRING )
        // -------------------------------------------------------------------------

        if (    isset( $_GET['return_to'] )
                &&
                $_GET['return_to'] === 'show-view'
                &&
                isset( $_GET['view_slug'] )
                &&
                trim( $_GET['view_slug'] ) !== ''
                &&
                strlen( $_GET['view_slug'] ) <= 64
                &&
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['view_slug'] )
            ) {

            $query_changes = array(
                                'action'        =>  $_GET['return_to']      ,
                                'view_slug'     =>  $_GET['view_slug']      ,
                                'dataset_slug'  =>  NULL                    ,
                                'record_key'    =>  NULL
                                ) ;

        } else {

            $query_changes = array(
                                'action'        =>  'manage-dataset'    ,
                                'dataset_slug'  =>  $dataset_slug       ,
                                'record_key'    =>  NULL
                                ) ;

        }

        $question_amp = FALSE ;

        $question_die_on_error = FALSE ;

        $cancel_href = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\get_query_adjusted_current_page_url(
                            $query_changes              ,
                            $question_amp               ,
                            $question_die_on_error
                            ) ;

        if ( is_array( $cancel_href ) ) {
            return $cancel_href[0] ;
        }

        $onclick = <<<EOT
window.parent.location.href="{$cancel_href}"
EOT;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        if (    isset( $_GET['application'] )
                &&
                trim( $_GET['application'] ) !== ''
                &&
                strlen( $_GET['application'] ) <= 64
                &&
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['application'] )
            ) {
            $application = '&application=' . $_GET['application'] ;

        } else {
            $application = '' ;

        }

        // ---------------------------------------------------------------------

        if (    isset( $_GET['return_to'] )
                &&
                $_GET['return_to'] === 'show-view'
                &&
                isset( $_GET['view_slug'] )
                &&
                trim( $_GET['view_slug'] ) !== ''
                &&
                strlen( $_GET['view_slug'] ) <= 64
                &&
                \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['view_slug'] )
            ) {

            $cancel_href = \admin_url() . <<<EOT
/admin.php?page={$_GET['page']}&action={$_GET['return_to']}{$application}&view_slug={$_GET['view_slug']}
EOT;

        } else {

            $cancel_href = \admin_url() . <<<EOT
/admin.php?page={$_GET['page']}&action=manage-dataset{$application}&dataset_slug={$dataset_slug}
EOT;

        }

        // ---------------------------------------------------------------------

        $onclick = <<<EOT
window.parent.location.href="{$cancel_href}"
EOT;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return array(
                $cancel_href    ,
                $onclick
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_cancel_button_onclick_attribute_value()
// =============================================================================

function get_cancel_button_onclick_attribute_value(
    $home_page_title                                            ,
    $caller_apps_includes_dir                                   ,
    $all_application_dataset_definitions                        ,
    $dataset_slug                                               ,
    $question_front_end                                         ,
    $display_options                                            ,
    $submission_options                                         ,
    $selected_datasets_dmdd                                     ,
    $dataset_title                                              ,
    $dataset_records                                            ,
    $record_indices_by_key                                      ,
    $question_adding                                            ,
    $form_slug_underscored                                      ,
    $array_storage_field_indices_to_base64_encode_pre_check     ,
    $zebra_form_field_number                                    ,
    $zebra_form_field_details                                   ,
    $the_record                                                 ,
    $the_records_index                                          ,
    $array_storage_field_slugs                                  ,
    $extra_args
    ) {

    // -------------------------------------------------------------------------
    // get_cancel_button_onclick_attribute_value(
    //      ...
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Returns the Javascript "onclick" event handler for the "Cancel" button
    // on the Zebra Form "Add Record" and "Edit Record" forms.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // <my_custom_get_attribute_value_function>(
    //      $home_page_title                                            ,
    //      $caller_apps_includes_dir                                   ,
    //      $all_application_dataset_definitions                        ,
    //      $dataset_slug                                               ,
    //      $question_front_end                                         ,
    //      $display_options                                            ,
    //      $submission_options                                         ,
    //      $selected_datasets_dmdd                                     ,
    //      $dataset_title                                              ,
    //      $dataset_records                                            ,
    //      $record_indices_by_key                                      ,
    //      $question_adding                                            ,
    //      $form_slug_underscored                                      ,
    //      $array_storage_field_indices_to_base64_encode_pre_check     ,
    //      $zebra_form_field_number                                    ,
    //      $zebra_form_field_details                                   ,
    //      $the_record                                                 ,
    //      $the_records_index                                          ,
    //      $array_storage_field_slugs                                  ,
    //      $extra_args
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // NOTE!
    // -----
    // $caller_app_slash_plugins_global_namespace is no longer used or needed.
    // The value supplied is IGNORED.
    //
    // RETURNS
    //      o   On SUCCESS!
    //              $attribute_value STRING
    //
    //      o   On FAILURE!
    //              ARRAY( $error_message STRING )
    // -------------------------------------------------------------------------

    // =========================================================================
    // SINGLE RECORD MODE ?
    //
    // If so, return to the PLUGIN HOME PAGE.
    // =========================================================================

    if (    array_key_exists( 'question_single_record_mode' , $selected_datasets_dmdd )
            &&
            $selected_datasets_dmdd['question_single_record_mode'] === TRUE
        ) {

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

        $cancel_href = get_home_page_url(
                            $caller_apps_includes_dir   ,
                            $question_front_end
                            ) ;

        // ---------------------------------------------------------------------

        if ( is_array( $cancel_href ) ) {
            return $cancel_href ;
        }

        // ---------------------------------------------------------------------

        return <<<EOT
window.parent.location.href="{$cancel_href}"
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Return to the MANAGE DATASET screen...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_add_edit_form_cancel_href_and_onclick(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $question_front_end                             ,
    //      $dataset_slug
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          array(
    //              $cancel_href STRING
    //              $onclick STRING
    //              )
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $caller_app_slash_plugins_global_namespace = NULL ;

    // -------------------------------------------------------------------------

    $result = get_add_edit_form_cancel_href_and_onclick(
                    $caller_app_slash_plugins_global_namespace      ,
                    $question_front_end                             ,
                    $dataset_slug
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return array( $result ) ;
    }

    // -------------------------------------------------------------------------

    list(
        $cancel_href    ,
        $onclick
        ) = $result ;

    // -------------------------------------------------------------------------

    return $onclick ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_add_dataset_record_button()
// =============================================================================

function get_add_dataset_record_button(
    $caller_apps_includes_dir       ,
    $question_front_end             ,
    $dataset_slug                   ,
    $record_type_title              ,
    $view_title = FALSE             ,
    $return_to = FALSE              ,
    $view_slug = FALSE
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_add_dataset_record_button(
    //      $caller_apps_includes_dir       ,
    //      $question_front_end             ,
    //      $dataset_slug                   ,
    //      $record_type_title              ,
    //      $view_title = FALSE             ,
    //      $return_to = FALSE              ,
    //      $view_slug = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          STRING $add_dataset_record_button_html
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          array( $error_message STRING )
    // -------------------------------------------------------------------------

    if ( $question_front_end ) {

        require_once( $caller_apps_includes_dir . '/url-utils.php' ) ;

        // -------------------------------------------------------------------------
        // \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
        //      $query_changes = array()        ,
        //      $question_amp = FALSE           ,
        //      $question_die_on_error = FALSE
        //      ) ;
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Attempts to retrieve the current page URL from $_SERVER.
        //
        // If successful, returns the URL with the query part adjusted as
        // requested.
        //
        // RETURNS
        //      o   On SUCCESS!
        //          -----------
        //          $query_adjusted_current_page_url STRING
        //
        //      o   On FAILURE!
        //          -----------
        //          If $question_die_on_error = TRUE
        //              Doesn't return
        //          If $question_die_on_error = FALSE
        //              array( $error_message STRING )
        // -------------------------------------------------------------------------

        $query_changes = array(
                            'action'        =>  'add-record'        ,
                            'dataset_slug'  =>  $dataset_slug
                            ) ;

        if ( is_string( $view_title ) ) {
            $query_changes['view_title'] = trim( $view_title ) ;

        } else {
            $query_changes['view_title'] = NULL ;

        }

        if ( is_string( $return_to ) ) {
            $query_changes['return_to'] = trim( $return_to ) ;

        } else {
            $query_changes['return_to'] = NULL ;

        }

        if ( is_string( $view_slug ) ) {
            $query_changes['view_slug'] = trim( $view_slug ) ;

        } else {
            $query_changes['view_slug'] = NULL ;

        }

        $question_amp = FALSE ;

        $question_die_on_error = FALSE ;

        $url = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_urlUtils\get_query_adjusted_current_page_url(
                    $query_changes              ,
                    $question_amp               ,
                    $question_die_on_error
                    ) ;

        if ( is_array( $url ) ) {
            return $url ;
        }

        $position_relative = '' ;

    } else {

        $url = \admin_url() . <<<EOT
admin.php?page={$_GET['page']}&action=add-record&application={$_GET['application']}&dataset_slug={$dataset_slug}
EOT;

        if ( is_string( $view_title ) ) {
            $url .= '&view_title=' . trim( $view_title ) ;
        }

        if ( is_string( $return_to ) ) {
            $url .= '&return_to=' . trim( $return_to ) ;
        }

        if ( is_string( $view_slug ) ) {
            $url .= '&view_slug=' . trim( $view_slug ) ;
        }

        $position_relative = ';position:relative; top:1em' ;

    }

    // -------------------------------------------------------------------------

    return <<<EOT
<div><a  href="{$url}"
    style="padding:3px 10px; background-color:#F1F1F1; font-size: 110%; font-weight:normal; text-decoration:none; text-align:left{$position_relative}"
    >Add&nbsp;{$record_type_title}</a></div>
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// validate_and_index_datasets_custom_actions()
// =============================================================================

function validate_and_index_datasets_custom_actions(
    $selected_datasets_dmdd     ,
    $dataset_title
    ) {

    // -------------------------------------------------------------------------
    // validate_and_index_datasets_custom_actions(
    //      $selected_datasets_dmdd     ,
    //      $dataset_title
    //      )
    // - - - - - - - - - - - - - - - - - - - - - -
    // Checks that the specified dataset's:-
    //      "custom_actions"
    //
    // parameter is present - and reasonably valid looking.
    //
    // $custom_actions should be (eg):-
    //
    //      $custom_actions = array(
    //
    //          array(
    //              'slug'      =>  'select-dirs-files'                     ,
    //              'args'      =>  array(
    //                                  'plugin_stuff_relative_filespec'    =>  'select-dirs-and-files.php'     ,
    //                                  'namespace_and_function_name'       =>  'select_dirs_and_files'
    //                                  )
    //              )
    //
    //          )
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          ARRAY $custom_action_indices_by_slug
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Check the OUTER ARRAY...
    // =========================================================================

    if ( ! isset( $selected_datasets_dmdd['custom_actions'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; No "dataset_records_table" + "custom_actions"
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( ! is_array( $selected_datasets_dmdd['custom_actions'] ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "dataset_records_table" + "custom_actions" (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // Check the INNER ARRAYS...
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $selected_datasets_dmdd['custom_actions'] = array(
    //
    //          array(
    //              'slug'      =>  'select-dirs-files'                     ,
    //              'args'      =>  array(
    //                                  'plugin_stuff_relative_filespec'    =>  'select-dirs-and-files.php'     ,
    //                                  'namespace_and_function_name'       =>  'select_dirs_and_files'
    //                                  )
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    $custom_action_indices_by_slug = array() ;

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['custom_actions'] as $custom_action_index => $custom_action_details ) {

        // ---------------------------------------------------------------------

        $custom_action_number = $custom_action_index + 1 ;

        // ---------------------------------------------------------------------

        if ( ! is_array( $custom_action_details ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad custom action# {$custom_action_number} (array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------
        // slug ?
        // ---------------------------------------------------------------------

        if ( ! isset( $custom_action_details['slug'] ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad custom action# {$custom_action_number} (no "slug")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if (    ! is_string( $custom_action_details['slug'] )
                ||
                trim( $custom_action_details['slug'] ) === ''
                ||
                strlen( $custom_action_details['slug'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $custom_action_details['slug'] )
            ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad custom action# {$custom_action_number} + "slug" (1 to 64 character "alphanumeric underscore dash" type string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        $custom_action_indices_by_slug[ $custom_action_details['slug'] ] = $custom_action_index ;

        // ---------------------------------------------------------------------
        // args ?
        // ---------------------------------------------------------------------

        if ( ! isset( $custom_action_details['args'] ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad custom action# {$custom_action_number} (no "args")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( ! is_array( $custom_action_details['args'] ) ) {

            return <<<EOT
PROBLEM Displaying Dataset Records:&nbsp; Bad custom action# {$custom_action_number} + "args" (possibly empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $custom_action_indices_by_slug ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// ===========================================================================
// ctype_unique_key()
// ===========================================================================

function ctype_unique_key( $value ) {

    if (    is_string( $value )
            &&
            strlen( $value ) === 13
            &&
            ctype_xdigit( $value )
            &&
            $value === strtolower( $value )
        ) {
        return TRUE ;
    }

    return FALSE ;

}

// =============================================================================
// get_pre_check_base64_encoded_array_storage_field_indices_by_slug()
// =============================================================================

function get_pre_check_base64_encoded_array_storage_field_indices_by_slug(
    $selected_datasets_dmdd
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // get_pre_check_base64_encoded_array_storage_field_indices_by_slug(
    //      $selected_datasets_dmdd
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      On SUCCESS!
    //          ARRAY $pre_check_base64_encoded_array_storage_field_indices_by_slug
    //
    //      On FAILURE
    //          $error_message string
    // -------------------------------------------------------------------------

    // =========================================================================
    // BASE64 ENCODING ?
    // =========================================================================

    // -------------------------------------------------------------------------
    // The Zebra Forms:-
    //      $zebra_form_obj->validate()
    //
    // routine does:-
    //      htmlentities()
    //
    // on the submitted fields (in $_POST).
    //
    // Which increases security - but makes it impossible to handle fields
    // containing HTML.
    //
    // To solve this, we allow fields to be Base64 encoded BEFORE:-
    //      $zebra_form_obj->validate()
    //
    // is called.  Which means that:-
    //
    //      1.  It's the raw submitted data - as typed in by the user - that's
    //          Base64 encoded and saved (as is).
    //
    //      2.  $zebra_form_obj->validate() is checking the Base64 encoded
    //          field value.  NOT the actual content entered/submitted
    //          by the user.
    //
    // Also of course, the field value must be Base64 decoded before it's
    // displayed.
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // Whether or not a particular ARRAY STORAGE field is to be Base64 encoded,
    // is determined by the "base64_encode" field of the array storage field
    // definitions.  Ie:-
    //
    //
    //      $selected_datasets_dmdd['array_storage_record_structure'] = array(
    //
    //          ...
    //
    //          array(
    //              'slug'          =>  'container_html'              ,
    //              'value_from'    =>  array(
    //                                      'method'    =>  'post'              ,
    //                                      'instance'  =>  'container_html'
    //                                      )   ,
    //              'constraints'   =>  array()     ,
    //              'base64_encode' =>  'pre-check'
    //              )   ,
    //
    //          ...
    //
    //          )
    //
    // If the "base64_encode" field is present - and set to (the string):-
    //      "pre-check"
    //
    // then the field value is base64 encoded BEFORE the call to:-
    //      $zebra_form_obj->validate()
    //
    // ---
    //
    // If the "base64_encode" field is present - and set to (the string):-
    //      "pre-save"
    //
    // then the field value is base64 encoded AFTER the call to:-
    //      $zebra_form_obj->validate()
    //
    // and BEFORE it's saved
    //
    // ---
    //
    // If the "base64_encode" field is present - and set to any of:-
    //      o   "" (the empty string)
    //      o   FALSE
    //      o   NULL
    //
    // then NO base64 encoding is applied.
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // Get the FIELDS to Base64 encode (pre-check)...
    // =========================================================================

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $selected_datasets_dmdd['array_storage_record_structure'] ) ;

    // -------------------------------------------------------------------------

    $pre_check_base64_encoded_array_storage_field_indices_by_slug = array() ;

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['array_storage_record_structure'] as $field_index => $field_data ) {

        // ---------------------------------------------------------------------

        if ( ! is_array( $field_data ) ) {
            continue ;
                //  Skip the:-
                //      'checked_defaulted_ok'  =>  TRUE/FALSE
                //  field.
        }

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( 'base64_encode' , $field_data ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        if ( $field_data['base64_encode'] === 'pre-check' ) {

            $pre_check_base64_encoded_array_storage_field_indices_by_slug[ $field_data['slug'] ] =
                $field_index
                ;

            continue ;

        }

        // ---------------------------------------------------------------------

        if (    $field_data['base64_encode'] === ''
                ||
                $field_data['base64_encode'] === FALSE
                ||
                $field_data['base64_encode'] === NULL
            ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        $field_number = $field_index + 1 ;

        $safe_field_slug = htmlentities( $field_data['slug'] ) ;

        return <<<EOT
PROBLEM:&nbsp; Bad "array_storage_record_structure" + field# {$field_number} ("{$safe_field_slug}") + "base64_encode" - ("pre_check", "", FALSE or NULL expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $pre_check_base64_encoded_array_storage_field_indices_by_slug ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// sort_records_by_field()
// =============================================================================

function sort_records_by_field(
    $dataset_records        ,
    $field_slug             ,
    $sort_method
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // sort_records_by_field(
    //      $dataset_records        ,
    //      $field_slug             ,
    //      $sort_method
    //      )
    // - - - - - - - - - - - - - - -
    // Sorts the given (numerically indexed) array of records by the specified
    // field.
    //
    // $sort_method must be one of:-
    //
    //      o   "numeric"
    //              The field values are assumed to be INT or FLOAT.  And are
    //              compared with "<" and ">".
    //
    //      o   "strcmp"
    //              Compare the field values as strings, case-sensitively.
    //              See "strcmp()"
    //
    //      o   "strcasecmp"
    //              Compare the field values as strings, case-INsensitively
    //              See "strcasecmp()"
    //
    //      o   "strcasecmp"
    //              Compare the field values as strings, case-sensitively - but
    //              using a "natural" sorting algorithm
    //              See "strnatcmp()"
    //
    //      o   "strnatcasecmp"
    //              Compare the field values as strings, case-INsensitively -
    //              but using a "natural" sorting algorithm
    //              See "strnatcasecmp()"
    //
    // RETURNS
    //      o   On SUCCESS
    //              The sorted (records) array.
    //              Note that the INPUT array is NOT changed.
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // -------------------------------------------------------------------------

    $array_to_sort = $dataset_records ;

    // -------------------------------------------------------------------------

    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug'] =
        $field_slug
        ;

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
    //
    //              int callback ( mixed $a, mixed $b )
    //
    //          Caution
    //
    //          Returning non-integer values from the comparison function, such
    //          as float, will result in an internal cast to integer of the
    //          callback's return value. So values such as 0.99 and 0.1 will
    //          both be cast to an integer value of 0, which will compare such
    //          values as equal.
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
    // -------------------------------------------------------------------------

    if ( $sort_method === 'numeric' ) {

        $ok = usort( $array_to_sort , $ns . '\\compare_records_by_field__numeric' ) ;

    } elseif ( $sort_method === 'strcmp' ) {

        $ok = usort( $array_to_sort , $ns . '\\compare_records_by_field__strcmp' ) ;

    } elseif ( $sort_method === 'strcasecmp' ) {

        $ok = usort( $array_to_sort , $ns . '\\compare_records_by_field__strcasecmp' ) ;

    } elseif ( $sort_method === 'strnatcmp' ) {

        $ok = usort( $array_to_sort , $ns . '\\compare_records_by_field__strnatcmp' ) ;

    } elseif ( $sort_method === 'strnatcasecmp' ) {

        $ok = usort( $array_to_sort , $ns . '\\compare_records_by_field__strnatcasecmp' ) ;

    } else {

        return <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "sort_method"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( $ok !== TRUE ) {

        return <<<EOT
PROBLEM:&nbsp; "usort()" failure
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    return $array_to_sort ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// compare_records_by_field__numeric()
// =============================================================================

function compare_records_by_field__numeric( $this_record , $that_record ) {

    //  Part of: "sort_records_by_field()"

    if (    $this_record[
                $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                ]
            <
            $that_record[
                $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                ]
        ) {
        return -1 ;

    } elseif (  $this_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                >
                $that_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
        ) {
        return 1 ;

    }

    return 0 ;

}

// =============================================================================
// compare_records_by_field__strcmp()
// =============================================================================

function compare_records_by_field__strcmp( $this_record , $that_record ) {

    //  Part of: "sort_records_by_field()"

    // -------------------------------------------------------------------------
    // int strcmp ( string $str1 , string $str2 )
    // - - - - - - - - - - - - - - - - - - - - -
    // Binary safe string comparison.  Note that this comparison is case
    // sensitive.
    //
    //      str1
    //          The first string.
    //
    //      str2
    //          The second string.
    //
    // Returns < 0 if str1 is less than str2; > 0 if str1 is greater than str2,
    // and 0 if they are equal.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    return strcmp(
                $this_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ,
                $that_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// compare_records_by_field__strcasecmp()
// =============================================================================

function compare_records_by_field__strcasecmp( $this_record , $that_record ) {

    //  Part of: "sort_records_by_field()"

    // -------------------------------------------------------------------------
    // int strcasecmp ( string $str1 , string $str2 )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // Binary safe case-insensitive string comparison.
    //
    //      str1
    //          The first string
    //
    //      str2
    //          The second string
    //
    // Returns < 0 if str1 is less than str2; > 0 if str1 is greater than str2,
    // and 0 if they are equal.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    return strcasecmp(
                $this_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ,
                $that_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// compare_records_by_field__strnatcmp()
// =============================================================================

function compare_records_by_field__strnatcmp( $this_record , $that_record ) {

    //  Part of: "sort_records_by_field()"

    // -------------------------------------------------------------------------
    // int strnatcmp ( string $str1 , string $str2 )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // This function implements a comparison algorithm that orders alphanumeric
    // strings in the way a human being would, this is described as a "natural
    // ordering". Note that this comparison is case sensitive.
    //
    //      str1
    //          The first string.
    //
    //      str2
    //          The second string.
    //
    // Similar to other string comparison functions, this one returns < 0 if
    // str1 is less than str2; > 0 if str1 is greater than str2, and 0 if they
    // are equal.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    return strnatcmp(
                $this_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ,
                $that_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// compare_records_by_field__strnatcasecmp()
// =============================================================================

function compare_records_by_field__strnatcasecmp( $this_record , $that_record ) {

    //  Part of: "sort_records_by_field()"

    // -------------------------------------------------------------------------
    // int strnatcasecmp ( string $str1 , string $str2 )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Case insensitive string comparisons using a "natural order" algorithm
    //
    // This function implements a comparison algorithm that orders alphanumeric
    // strings in the way a human being would.  The behaviour of this function
    // is similar to strnatcmp(), except that the comparison is not case
    // sensitive. For more information see: Martin Pool's » Natural Order
    // String Comparison page.
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

    return strnatcasecmp(
                $this_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ,
                $that_record[
                    $GLOBALS['GREAT_KIWI']['STANDARD_DATASET_MANAGER']['SORT_RECORDS_BY_FIELD']['field_slug']
                    ]
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// load_dataset_definitions_and_initialise_array_storage()
// =============================================================================

function load_dataset_definitions_and_initialise_array_storage(
    $core_plugapp_dirs                      ,
    $target_apps_apps_dir_relative_path     ,
    $question_front_end
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // load_dataset_definitions_and_initialise_array_storage(
    //      $core_plugapp_dirs                      ,
    //      $target_apps_apps_dir_relative_path     ,
    //      $question_front_end
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // $target_apps_apps_dir_relative_path is like (eg):-
    //      o   "teaser-maker"
    //      o   "basepress-users/reporting-module"
    //      o   etc.
    //
    // RETURNS
    //      o   On SUCCESS
    //              ARRAY(
    //                  $app_defs_directory_tree                        ,
    //                  $applications_dataset_and_view_definitions_etc  ,
    //                  $all_application_dataset_definitions
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should gave (eg):-
    //
    //      $core_plugapp_dirs = Array(
    //          [plugin_root_dir]               => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant
    //          [plugins_includes_dir]          => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/includes
    //          [plugins_app_defs_dir]          => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/app-defs
    //          [dataset_manager_includes_dir]  => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/includes/dataset-manager
    //          [apps_dot_app_dir]              => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/app-defs/picture-docs.app
    //          [apps_plugin_stuff_dir]         => /opt/lampp/htdocs/plugdev/wp-content/plugins/plugin-plant/app-defs/picture-docs.app/plugin.stuff
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $core_plugapp_dirs ) ;

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // =========================================================================
    // Support Routines...
    // =========================================================================

    require_once( $core_plugapp_dirs['dataset_manager_includes_dir'] . '/common.php' ) ;

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
        return $result ;
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
    // GET the application's DATASET DEFINITIONS...
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

    $target_app_path = $target_apps_apps_dir_relative_path ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_application_dataset_definitions(
                    $applications_dataset_and_view_definitions_etc   ,
                    $target_app_path
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_array( $result ) ) {

        $all_application_dataset_definitions = $result ;

    } elseif ( is_string( $result ) ) {

        return $result ;

    } else {

        $safe_target_app_path = htmlentities( $target_app_path ) ;

        return <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported application ("{$safe_target_app_path}")
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $all_application_dataset_definitions ) ;

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
        return $result ;
    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return array(
                $app_defs_directory_tree                        ,
                $applications_dataset_and_view_definitions_etc  ,
                $all_application_dataset_definitions
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// is_dataset_slug()
// =============================================================================

function is_dataset_slug(
    $candidate_dataset_slug                         ,
    $all_application_dataset_definitions = NULL
    ) {

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

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    if (    ! is_string( $candidate_dataset_slug )
            ||
            trim( $candidate_dataset_slug ) === ''
            ||
            strlen( $candidate_dataset_slug ) > 64
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore( $candidate_dataset_slug )
        ) {

        return <<<EOT
PROBLEM&nbsp; Bad "dataset_slug" (1 to 64 character alphanumeric underscore string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    is_array( $all_application_dataset_definitions )
            &&
            ! array_key_exists( $candidate_dataset_slug , $all_application_dataset_definitions )
        ) {

\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\debug_print_backtrace() ;

        return <<<EOT
PROBLEM:&nbsp; Unrecognised/unsupported "dataset_slug" ("{$candidate_dataset_slug}" - not found in application's dataset definitions)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// is_field_slug()
// =============================================================================

function is_field_slug(
    $candidate_field_slug
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // is_field_slug(
    //      $candidate_field_slug
    //      )
    // - - - - - - - - - - - - -
    // Is:-
    //      $candidate_field_slug
    //
    // a 1 to 64 character alphanumeric underscore string?
    //
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__  ;

    // -------------------------------------------------------------------------

    if (    ! is_string( $candidate_field_slug )
            ||
            trim( $candidate_field_slug ) === ''
            ||
            strlen( $candidate_field_slug ) > 64
            ||
            ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore( $candidate_field_slug )
        ) {

        return <<<EOT
PROBLEM&nbsp; Bad "field slug" (1 to 64 character alphanumeric underscore string expected)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// load_and_initialise_array_storage()
// =============================================================================

function load_and_initialise_array_storage(
    $all_application_dataset_definitions    ,
    $caller_apps_includes_dir
    ) {

    // -------------------------------------------------------------------------
    // load_and_initialise_array_storage(
    //      $all_application_dataset_definitions    ,
    //      $caller_apps_includes_dir
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    require_once( $caller_apps_includes_dir . '/array-storage.php' ) ;

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

    return \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage\init(
                $default_storage_method     ,
                $json_data_files_dir        ,
                $supported_datasets
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// load_applications_datasets()
// =============================================================================

function load_applications_datasets(
    $all_application_dataset_definitions    ,
    $core_plugapp_dirs                      ,
    &$loaded_datasets
    ) {

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
    //                  $dataset_records                ARRAY
    //                  $array_storage_key_field_slug   STRING
    //                  $record_indices_by_key          ARRAY
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    foreach ( $all_application_dataset_definitions as $dataset_slug => $dataset_definition ) {

        // ---------------------------------------------------------------------

        if ( array_key_exists( $dataset_slug , $loaded_datasets ) ) {
            continue ;
        }

        // ---------------------------------------------------------------------

        $result = get_dataset_title_records_key_field_slug_and_record_indices_by_key(
                        $all_application_dataset_definitions    ,
                        $dataset_slug
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

        list(
            $dataset_title                  ,
            $dataset_records                ,
            $array_storage_key_field_slug   ,
            $record_indices_by_key
            ) = $result ;

        // ---------------------------------------------------------------------

        $loaded_datasets[ $dataset_slug ] = array(
            'title'                     =>  $dataset_title                  ,
            'records'                   =>  $dataset_records                ,
            'key_field_slug'            =>  $array_storage_key_field_slug   ,
            'record_indices_by_key'     =>  $record_indices_by_key
            ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// orphaned_records_supported
// =============================================================================

function orphaned_records_supported(
    $app_handle = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // orphaned_records_supported(
    //      $app_handle = NULL
    //      )
    // - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE or FALSE - depending on whether or not we should
    //              support the handling of "orphaned records".  (In other
    //              words, should we:-
    //              -   Display the "show/hide orphaned records" button, and;
    //              -   Support the deleting of orphaned records,
    //              -   etc.)
    //
    //      o   On FAILURE
    //              $error_message STRING
    //
    // NOTE!
    // =====
    // 1.   Orphaned records are supported unless the plugin's
    //          $version_names
    //
    //      array (if the plugin has one), has:-
    //          'support_orphaned_records' = FALSE
    //
    //      See:-
    //          \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\
    //          get_all_version_names()
    //
    //      in the plugin's:-
    //          .../app-defs/xxx.app/plugin.stuff/version-names.php
    //
    //      file (for more info).
    //
    // 2.   Thus orphaned records ARE supported - unless you explicitly switch
    //      OFF that support in the plugin's "version-names.php" file.
    //
    // 3.   $app_handle defaults to:-
    //          $_GET['application']
    //      (if it exists).
    // -------------------------------------------------------------------------

    $path_in_plugin = __FILE__ ;

    // -------------------------------------------------------------------------

    if (    ! is_string( $app_handle )
            ||
            trim( $app_handle ) === ''
        ) {

        if (    array_key_exists( 'application' , $_GET )
                &&
                is_string( $_GET['application'] )
                &&
                trim( $_GET['application'] ) !== ''
            ) {

            $app_handle = $_GET['application'] ;

        } else {

            //  MAYBE we should return an error message ???

            return TRUE ;

        }

    }

    // -------------------------------------------------------------------------

    $core_plugapp_dirs =
        \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_appsAPI\get_core_plugapp_dirs_base(
            $path_in_plugin     ,
            $app_handle
            ) ;

    // -------------------------------------------------------------------------

    $filespec = $core_plugapp_dirs['apps_plugin_stuff_dir'] . '/version-names.php' ;

    // -------------------------------------------------------------------------

    if ( ! is_file( $filespec ) ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    require_once( $filespec ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\
    // get_all_version_names()
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns a (possibly empty) ARRAY giving details of the is plugin's
    // versions.  Only available in the plugin exporter (when exporting the
    // plugins).  NOT available in the exported plugin(s).
    //
    // The returned array is like (eg):-
    //
    //      $version_names = array(
    //
    //          'std'   =>  array(
    //                          'short_slug'                =>  'std'       ,
    //                          'long_slug'                 =>  'standard'  ,
    //                          'short_title'               =>  'Std'       ,
    //                          'long_title'                =>  'Standard'  ,
    //                          'support_orphaned_records'  =>  FALSE
    //                          )   ,
    //
    //          'pro'   =>  array(
    //                          'short_slug'                =>  'pro'       ,
    //                          'long_slug'                 =>  'pro'       ,
    //                          'short_title'               =>  'Pro'       ,
    //                          'long_title'                =>  'Pro'       ,
    //                          'support_orphaned_records'  =>  TRUE
    //                          )   ,
    //
    //          )
    //
    // -------------------------------------------------------------------------

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

    if (    ! function_exists( '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\\get_all_version_names' )
            ||
            ! function_exists( '\\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\\get_version_name' )
        ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    $version_names = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\get_all_version_names() ;

    $plugin_version_name = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\get_version_name() ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $version_names ) ;
//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $plugin_version_name ) ;

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $plugin_version_name , $version_names ) ) {
        return TRUE ;
    }

    // -------------------------------------------------------------------------

    $plugin_data = $version_names[ $plugin_version_name ] ;

    // -------------------------------------------------------------------------

    if (    array_key_exists( 'support_orphaned_records' , $plugin_data )
            &&
            $plugin_data['support_orphaned_records'] === FALSE
        ) {
        return FALSE ;
    }

    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================


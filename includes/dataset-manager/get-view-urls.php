<?php

// *****************************************************************************
// DATASET-MANAGER / GET-VIEW-URLS.PHP
// (C) 2014 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// get_show_view_url()
// =============================================================================

function get_show_view_url(
    $caller_apps_includes_dir   ,
    $question_front_end         ,
    $view_slug = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_show_view_url(
    //      $caller_apps_includes_dir   ,
    //      $question_front_end         ,
    //      $view_slug = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Returns the "show-view" URL.
    //
    // If $view_slug is NULL, then we use:-
    //      $_GET['view_slug']
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

    if ( $view_slug === NULL ) {

        // ---------------------------------------------------------------------

        if ( ! isset( $_GET['view_slug'] ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; No "view_slug"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_show_view_url()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        if ( trim( $_GET['view_slug'] ) === '' ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_slug" (blank/empty string)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_show_view_url()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        if (    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['view_slug'] )
                ||
                strlen( $_GET['view_slug'] ) > 64
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "view_slug" (1 to 64 character "alphanumeric unerscore dash" type string expected)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_show_view_url()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        $view_slug = $_GET['view_slug'] ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( isset( $_GET['application'] ) ) {

        // ---------------------------------------------------------------------

        if ( trim( $_GET['application'] ) === '' ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "application" (blank/empty string)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_show_view_url()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        if (    ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore_dash( $_GET['application'] )
                ||
                strlen( $_GET['application'] ) > 64
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "application" (1 to 64 character "alphanumeric unerscore dash" type string expected)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_show_view_url()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        $application = $_GET['application'] ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM:&nbsp; No "application"
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\\get_show_view_url()
EOT;

        return array( $msg ) ;

        // ---------------------------------------------------------------------

    }

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
                            'action'        =>  'show-view'         ,
                            'application'   =>  $application        ,
                            'view_slug'     =>  $view_slug
                            ) ;

        $question_amp = FALSE ;

        $question_die_on_error = FALSE ;

        return \greatKiwi_urlUtils\get_query_adjusted_current_page_url(
                    $query_changes              ,
                    $question_amp               ,
                    $question_die_on_error
                    ) ;

        // ---------------------------------------------------------------------

    } else {

        // ---------------------------------------------------------------------

        return <<<EOT
?page={$_GET['page']}&action=show-view&application={$application}&view_slug={$view_slug}
EOT;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================


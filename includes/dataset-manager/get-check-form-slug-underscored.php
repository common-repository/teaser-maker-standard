<?php

// *****************************************************************************
// DATASET-MANAGER / GET-CHECK-FORM-SLUG-UNDERSCORED.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// get_check_form_slug_underscored()
// =============================================================================

function get_check_form_slug_underscored(
    $caller_app_slash_plugins_global_namespace      ,
    $home_page_title                                ,
    $caller_apps_includes_dir                       ,
    $all_application_dataset_definitions            ,
    $dataset_slug                                   ,
    $question_front_end                             ,
    $display_options                                ,
    $submission_options                             ,
    $selected_datasets_dmdd                         ,
    $dataset_title
    ) {

    // -------------------------------------------------------------------------
    // get_check_form_slug_underscored(
    //      $caller_app_slash_plugins_global_namespace      ,
    //      $home_page_title                                ,
    //      $caller_apps_includes_dir                       ,
    //      $all_application_dataset_definitions            ,
    //      $dataset_slug                                   ,
    //      $question_front_end                             ,
    //      $display_options                                ,
    //      $submission_options                             ,
    //      $selected_datasets_dmdd                         ,
    //      $dataset_title
    //      ) {
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              $form_slug_underscored STRING
    //
    //      o   On FAILURE
    //              ARRAY $error_message STRING )
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $display_options = Array(
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $display_options ) ;

    // =========================================================================
    // Check "zebra_forms"...
    // =========================================================================

    if ( ! array_key_exists( 'zebra_forms' , $selected_datasets_dmdd ) ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad dataset definition (no "zebra_forms")
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_check_form_slug_underscored()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_array( $selected_datasets_dmdd['zebra_forms'] )
            ||
            count( $selected_datasets_dmdd['zebra_forms'] ) < 1
        ) {

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "zebra_forms" (non-empty array expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_check_form_slug_underscored()
EOT;

        return array( $msg ) ;

    }

    // -------------------------------------------------------------------------

    foreach ( $selected_datasets_dmdd['zebra_forms'] as $candidate_form_name_underscored => $candidate_form_definition ) {

        // ---------------------------------------------------------------------

        if (    ! is_string( $candidate_form_name_underscored )
                ||
                trim( $candidate_form_name_underscored ) === ''
                ||
                strlen( $candidate_form_name_underscored ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore( $candidate_form_name_underscored )
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "zebra_forms" + "form_slug_underscored" (1 to 64 character "alphanumeric underscore" type string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_check_form_slug_underscored()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        if ( ! is_array( $candidate_form_definition ) ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "zebra_forms" form definition (array expected)
For dataset:&nbsp; {$dataset_title}
And form:&nbsp; {$candidate_form_name_underscored}
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_check_form_slug_underscored()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // $display_options['form_name_underscored'] ?
    // =========================================================================

    if ( array_key_exists( 'form_slug_underscored' , $display_options ) ) {

        // ---------------------------------------------------------------------

        if (    ! is_string( $display_options['form_slug_underscored'] )
                ||
                trim( $display_options['form_slug_underscored'] ) === ''
                ||
                strlen( $display_options['form_slug_underscored'] ) > 64
                ||
                ! \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_stringUtils\ctype_alphanumeric_underscore( $display_options['form_slug_underscored'] )
            ) {

            $msg = <<<EOT
PROBLEM:&nbsp; Bad "display_options" + "form_slug_underscored" (1 to 64 character "alphanumeric underscore" type string expected)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_check_form_slug_underscored()
EOT;

            return array( $msg ) ;

        }

        // ---------------------------------------------------------------------

        foreach ( $selected_datasets_dmdd['zebra_forms'] as $candidate_form_name_underscored => $candidate_form_definition ) {

            if ( $candidate_form_name_underscored === $display_options['form_slug_underscored'] ) {
                return $display_options['form_slug_underscored'] ;
            }

        }

        // ---------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM:&nbsp; Bad "display_options" + "form_slug_underscored" (no such form)
For dataset:&nbsp; {$dataset_title}
Detected in:&nbsp; \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\get_check_form_slug_underscored()
EOT;

        return array( $msg ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Default to the first defined form...
    // =========================================================================

    $temp = array_keys( $selected_datasets_dmdd['zebra_forms'] ) ;

    return $temp[0] ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


<?php

// *****************************************************************************
// PICTURE-DOCS.APP / PLUGIN.STUFF / VERSION-NAMES.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker ;

// -----------------------------------------------------------------------------
// NOTES!
// ======
// 1.   STD" / "PRO" ETC
//      ----------------
//      By "version" (as far as this file is concerned), we mean versions
//      like "Standard, "Pro" and "Extended", etc (not version numbers like
//      1.1, 2.3.5, etc).
// -----------------------------------------------------------------------------

// =============================================================================
// Define the VERSION NAMES (for this plugin)...
// =============================================================================

function get_all_version_names() {

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

    return array(

        'std'   =>  array(
                        'short_slug'                =>  'std'           ,
                        'long_slug'                 =>  'standard'      ,
                        'short_title'               =>  'Std'           ,
                        'long_title'                =>  'Standard'      ,
                        'support_orphaned_records'  =>  FALSE
                        )   ,

        'pro'   =>  array(
                        'short_slug'                =>  'pro'           ,
                        'long_slug'                 =>  'pro'           ,
                        'short_title'               =>  'Pro'           ,
                        'long_title'                =>  'Pro'           ,
                        'support_orphaned_records'  =>  TRUE
                        )   ,

        ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_version_name()
// =============================================================================

function get_version_name() {

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

    return 'std' ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// is_version_name()
// =============================================================================

function is_version_name(
    $candidate_short_version_name   ,
    $question_strict = FALSE
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_pluginMaker\
    // is_version_name(
    //      $candidate_short_version_name   ,
    //      $question_strict = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - -
    // $candidate_short_version_name should be (eg):-
    //      o   "std"
    //      o   "pro"
    //
    // If $question_strict is TRUE, we also check that the:-
    //      $candidate_short_version_name
    //
    // is one of the keys of the array returned by:-
    //      get_all_version_names()
    //
    // RETURNS
    //      TRUE or FALSE
    // -------------------------------------------------------------------------

    if ( $candidate_short_version_name !== get_version_name() ) {
        return FALSE ;
    }

    // -------------------------------------------------------------------------

    if (    $question_strict === TRUE
            &&
            ! array_key_exists( $candidate_short_version_name , get_all_version_names() )
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


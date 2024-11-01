<?php

// *****************************************************************************
// LOAD-DIRECTORY-TREE.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles ;

// =============================================================================
// load_directory_tree()
// =============================================================================

function load_directory_tree(
    $root_dir
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles\load_directory_tree(
    //      $root_dir
    //      )
    // - - - - - - - - - - -
    // Loads the specified directory tree.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          An ARRAY like (eg):-
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $ns = __NAMESPACE__ ;
    $fn = __FUNCTION__ ;

    // =========================================================================
    // LOAD the DIRS and FILES in the ROOT DIR...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/scandir.php' ) ;

    // -----------------------------------------------------------------------
    // super_scandir(
    //      $target_directory
    //      )
    // - - - - - - - - - - --
    // Returns an array of the file and directory basenames from the
    // specified directory.
    //
    // Works in PHP 4 and above.
    //
    // PARAMETERS
    //      $target_directory
    //          The directory that will be scanned.
    //
    // RETURN VALUES
    //      Returns the following array on success, or FALSE on failure.
    //
    //          array(
    //              'dirs'  =>  array(
    //                              [dir_FDE0]      =>  'dir_filespec0'     ,
    //                              [dir_FDE1]      =>  'dir_filespec1'     ,
    //                              [dir_FDE2]      =>  'dir_filespec2'     ,
    //                              ...                 ...
    //                              [dir_FDEn]      =>  'dir_filespecN'
    //                              )
    //              'files' =>  array(
    //                              [file_FDE0]     =>  'file_filespec0'     ,
    //                              [file_FDE1]     =>  'file_filespec1'     ,
    //                              [file_FDE2]     =>  'file_filespec2'     ,
    //                              ...                 ...
    //                              [file_FDEn]     =>  'file_filespecN'
    //                              )
    //              'other' =>  array(
    //                              [other_FDE0]    =>  'other_filespec0'     ,
    //                              [other_FDE1]    =>  'other_filespec1'     ,
    //                              [other_FDE2]    =>  'other_filespec2'     ,
    //                              ...                 ...
    //                              [other_FDEn]    =>  'other_filespecN'
    //                              )
    //              )
    //
    //      If directory is not a directory, then boolean FALSE is returned,
    //      and an error of level E_WARNING is generated.
    // -----------------------------------------------------------------------

    $dirs_and_files = super_scandir( $root_dir ) ;

    // -----------------------------------------------------------------------

    if ( $dirs_and_files === FALSE ) {

        return <<<EOT
PROBLEM:&nbsp; "super_scandir()" failure loading tree root directory
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // =========================================================================
    // CREATE the output TREE...
    // =========================================================================

    $tree = array() ;

    // -------------------------------------------------------------------------
    // DIRS...
    // -------------------------------------------------------------------------

    $tree['dirs'] = array() ;

    // -------------------------------------------------------------------------

    foreach ( $dirs_and_files['dirs'] as $this_FDE => $this_dirspec ) {

        $result = load_directory_tree( $this_dirspec ) ;

        if ( is_string( $result ) ) {
            return $result ;
        }

        $tree['dirs'][ $this_dirspec ] = $result ;

    }

    // -------------------------------------------------------------------------
    // FILES...
    // -------------------------------------------------------------------------

    $tree['files'] = array_keys( $dirs_and_files['files'] ) ;

    // -------------------------------------------------------------------------
    // OTHER...
    // -------------------------------------------------------------------------

    $tree['other'] = array_values( $dirs_and_files['other'] ) ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $tree ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


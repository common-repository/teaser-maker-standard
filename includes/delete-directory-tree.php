<?php

// *****************************************************************************
// DELETE-DIRECTORY-TREE.PHP
// (C) 2014 Peter Newman
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations ;

// =============================================================================
// delete_directory_tree()
// =============================================================================

function delete_directory_tree(
    $tree_root_dir                  ,
    $question_check_root = TRUE
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\delete_directory_tree(
    //      $tree_root_dir                  ,
    //      $question_check_root = TRUE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Deletes the specified directory tree.
    //
    // In other words, deletes the specified directory and all of it's
    // descendants.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    return delete_directory_tree_base(
                $tree_root_dir          ,
                $question_check_root
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// delete_directory_tree_base()
// =============================================================================

function delete_directory_tree_base(
    $tree_root_dir          ,
    $question_check_root
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\delete_directory_tree_base(
    //      $tree_root_dir          ,
    //      $question_check_root
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Deletes the specified directory tree.
    //
    // In other words, deletes the specified directory and all of it's
    // descendants.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Delete the directory's descendants (if it has any)...
    // =========================================================================

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\empty_directory_tree(
    //      $tree_root_dir                  ,
    //      $question_check_root = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Empties the specified directory tree.
    //
    // In other words, all the descendant directory, files and links beneath
    //      $tree_root_dir
    //
    // (if any), are deleted.  But:-
    //      $tree_root_dir
    //
    // itself is NOT deleted.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    $result = empty_directory_tree(
                    $tree_root_dir          ,
                    $question_check_root
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {
        return $result ;
    }

    // =========================================================================
    // Then delete the directory itself...
    // =========================================================================

    // -------------------------------------------------------------------------
    // bool rmdir ( string $dirname [, resource $context ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Attempts to remove the directory named by dirname. The directory must be
    // empty, and the relevant permissions must permit this. A E_WARNING level
    // error will be generated on failure.
    //
    //      dirname
    //          Path to the directory.
    //
    //      context
    //          Note: Context support was added with PHP 5.0.0. For a
    //          description of contexts, refer to Streams.
    //
    // Returns TRUE on success or FALSE on failure.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    if ( rmdir( $tree_root_dir ) !== TRUE ) {

        return <<<EOT
PROBLEM: "rmdir()" failure
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\delete_directory_tree_base()
EOT;

    }

//  echo '<br />deleting DIR:&nbsp; ' , $tree_root_dir ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// empty_directory_tree()
// =============================================================================

function empty_directory_tree(
    $tree_root_dir                  ,
    $question_check_root = FALSE
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\empty_directory_tree(
    //      $tree_root_dir                  ,
    //      $question_check_root = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Empties the specified directory tree.
    //
    // In other words, all the descendant directory, files and links beneath
    //      $tree_root_dir
    //
    // (if any), are deleted.  But:-
    //      $tree_root_dir
    //
    // itself is NOT deleted.
    //
    // RETURNS
    //      o   On SUCCESS!
    //          - - - - - -
    //          TRUE
    //
    //      o   On FAILURE!
    //          - - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Root dir exists ?
    // =========================================================================

    if (    $question_check_root
            &&
            ! is_dir( $tree_root_dir )
        ) {

        return <<<EOT
PROBLEM: Can't empty directory tree (because the specified directory doesn't exist)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\empty_directory_tree()
EOT;

    }

//echo '<br /><big><b>' , $tree_root_dir , '</b></big>' ;

    // =========================================================================
    // Open the root directory...
    // =========================================================================

    // -------------------------------------------------------------------------
    // resource opendir ( string $path [, resource $context ] )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Opens up a directory handle to be used in subsequent closedir(),
    // readdir(), and rewinddir() calls.
    //
    //      path
    //          The directory path that is to be opened
    //
    //      context
    //          For a description of the context parameter, refer to the streams
    //          section of the manual.
    //
    // Returns a directory handle resource on success, or FALSE on failure.
    //
    // If path is not a valid directory or the directory can not be opened due
    // to permission restrictions or filesystem errors, opendir() returns FALSE
    // and generates a PHP error of level E_WARNING. You can suppress the error
    // output of opendir() by prepending '@' to the front of the function name.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

//  ob_start() ;

    $dir_handle = @opendir( $tree_root_dir ) ;

//  $php_err_msg = trim(  ob_get_clean() ) ;

    // -------------------------------------------------------------------------

    if ( $dir_handle === FALSE ) {

        return <<<EOT
PROBLEM: "opendir()" failure (when trying to empty a directory tree)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\empty_directory_tree()
EOT;

    }

    // =========================================================================
    // Loop over the directory's content, deleting each one in turn...
    // =========================================================================

    // -------------------------------------------------------------------------
    // string readdir ([ resource $dir_handle ] )
    // - - - - - - - - - - - - - - - - - - - - -
    // Returns the name of the next entry in the directory. The entries are
    // returned in the order in which they are stored by the filesystem.
    //
    //      dir_handle
    //          The directory handle resource previously opened with opendir().
    //          If the directory handle is not specified, the last link opened
    //          by opendir() is assumed.
    //
    // Returns the entry name on success or FALSE on failure.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    $question_check_root_TRUE  = TRUE  ;
    $question_check_root_FALSE = FALSE ;

    // -------------------------------------------------------------------------

    while ( TRUE ) {

        // =====================================================================
        // Get the next directory entry's pathspec...
        // =====================================================================

        $basename = readdir( $dir_handle ) ;
                        //  "readdir()" returms the directory entry's
                        //  BASENAME (NOT it's full pathspec)...

//echo '<br /><b>' , $basename , '</b>' ;

        // =====================================================================
        // All entries done ?
        // =====================================================================

        if ( $basename === FALSE ) {
            break ;
        }

        // =====================================================================
        // Skip "." and ".."...
        // =====================================================================

        if ( $basename === '.' || $basename === '..' ) {
            continue ;
        }

        // =====================================================================
        // Convert the basename to pathspec...
        // =====================================================================

        $pathspec = $tree_root_dir . '/' . $basename ;

//echo '<br /><b>' , $pathspec , '</b>' ;

        // =====================================================================
        // Process the dir/file/link...
        // =====================================================================

        if ( is_dir( $pathspec ) ) {

            // =================================================================
            // DIR
            // =================================================================

            // -------------------------------------------------------------------------
            // \greatKiwi_pluginMaker_pluginVersion_directoryOperations\delete_directory_tree_base(
            //      $tree_root_dir          ,
            //      $question_check_root
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Deletes the specified directory tree.
            //
            // In other words, deletes the specified directory and all of it's
            // descendants.
            //
            // RETURNS
            //      o   On SUCCESS!
            //          - - - - - -
            //          TRUE
            //
            //      o   On FAILURE!
            //          - - - - - -
            //          $error_message STRING
            // -------------------------------------------------------------------------

            $result = delete_directory_tree_base(
                            $pathspec                       ,
                            $question_check_root_FALSE
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                closedir( $dir_handle ) ;
                return $result ;
            }

            // -----------------------------------------------------------------

        } elseif ( is_file( $pathspec ) ) {

            // =================================================================
            // FILE
            // =================================================================

            // -------------------------------------------------------------------------
            // bool unlink ( string $filename [, resource $context ] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Deletes filename. Similar to the Unix C unlink() function. A E_WARNING
            // level error will be generated on failure.
            //
            //      filename
            //          Path to the file.
            //
            //      context
            //          Note: Context support was added with PHP 5.0.0. For a
            //          description of contexts, refer to Streams.
            //
            // Returns TRUE on success or FALSE on failure.
            //
            // (PHP 4, PHP 5)
            // -------------------------------------------------------------------------

            $result = unlink( $pathspec ) ;

//          echo '<br />deleting FILE:&nbsp; ' , basename( $pathspec ) ;
//          $result = TRUE ;

            // -----------------------------------------------------------------

            if ( $result !== TRUE ) {

                closedir( $dir_handle ) ;

                return <<<EOT
PROBLEM: "unlink()" failure (when trying to delete file from directory tree)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\empty_directory_tree()
EOT;

            }

            // -----------------------------------------------------------------

        } elseif ( is_link( $pathspec ) ) {

            // =================================================================
            // (SYMBOLIC) LINK
            // =================================================================

            // -------------------------------------------------------------------------
            // bool unlink ( string $filename [, resource $context ] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Deletes filename. Similar to the Unix C unlink() function. A E_WARNING
            // level error will be generated on failure.
            //
            //      filename
            //          Path to the file.
            //
            //      context
            //          Note: Context support was added with PHP 5.0.0. For a
            //          description of contexts, refer to Streams.
            //
            // Returns TRUE on success or FALSE on failure.
            //
            // (PHP 4, PHP 5)
            // -------------------------------------------------------------------------

            $result = unlink( $pathspec ) ;

//          echo '<br />deleting SYMBOLIC LINK:&nbsp; ' , basename( $pathspec ) ;
//          $result = TRUE ;

            // -----------------------------------------------------------------

            if ( $result !== TRUE ) {

                closedir( $dir_handle ) ;

                return <<<EOT
PROBLEM: "unlink()" failure (when trying to delete symbolic link from directory tree)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\empty_directory_tree()
EOT;

            }

            // -----------------------------------------------------------------

        } else {

            // =================================================================
            // ERROR
            // =================================================================

            closedir( $dir_handle ) ;

            return <<<EOT
PROBLEM: Unrecognised/unsupported directory entry (not dir, file or symbolic link - when trying to delete directory entry from directory tree)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\empty_directory_tree()
EOT;

            // -----------------------------------------------------------------

        }

        // =====================================================================
        // Repeat with the next directory entry (if there is one)...
        // =====================================================================

    }

    // =========================================================================
    // Close the directory...
    // =========================================================================

    // -------------------------------------------------------------------------
    // void closedir ([ resource $dir_handle ] )
    // - - - - - - - - - - - - - - - - - - - - -
    // Closes the directory stream indicated by dir_handle. The stream must have
    // previously been opened by opendir().
    //
    //      dir_handle
    //          The directory handle resource previously opened with opendir().
    //          If the directory handle is not specified, the last link opened
    //          by opendir() is assumed.
    // -------------------------------------------------------------------------

    closedir( $dir_handle ) ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// That's that!
// =============================================================================


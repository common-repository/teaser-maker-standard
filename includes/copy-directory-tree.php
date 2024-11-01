<?php

// *****************************************************************************
// COPY-DIRECTORY-TREE.PHP
// (C) 2014 Peter Newman
// *****************************************************************************

        namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations ;

// =============================================================================
// copy_directory_tree()
// =============================================================================

function copy_directory_tree(
    $from_dirspec                   ,
    $to_dirspec                     ,
    $question_strict = TRUE         ,
    $question_overwrite = FALSE     ,
    $levels = 0                     ,
    $current_level = 0
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\copy_directory_tree(
    //      $from_dirspec                   ,
    //      $to_dirspec                     ,
    //      $question_strict = TRUE         ,
    //      $question_overwrite = FALSE     ,
    //      $levels = 0                     ,
    //      $current_level = 0
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Copies the specified directory tree.
    //
    // In other words (by default), copies the specified directory and all of
    // it's descendants.
    //
    // ---
    //
    // $question_strict:-
    //      o   TRUE means that NONE of the destination dirs and files may
    //          already exist.
    //      o   FALSE means that it's OK if any of the destination dirs and
    //          files already exist.  If the destination item that already
    //          exists is a FILE, then $question_overwrite describes how
    //          this should be handled.
    //
    // ---
    //
    // $question_overwrite:-
    //      (Only used if $question_strict is FALSE.)
    //      o   TRUE means that if a destination file already exists, then
    //          it MAY be overwritten.
    //      o   FALSE means that if a destination file already exists, then
    //          it may NOT be overwritten.  (Instead, the copy ends at this
    //          point - the existing file being a FATAL error.)
    //
    // ---
    //
    // $levels:-
    //      o   If $levels is 0, then we copy ALL of the destination
    //          directory's decendants (no matter ho deeply nested they are).
    //      o   If $levels is 1, then we copy only the DESTINATION
    //          DIRECTORY itself (but NONE of it's descendants).
    //      o   If $levels is 2, then we copy the destination directory and
    //          it's children (but NOT it's grandchildren, etc).
    //      o   And so on...
    //
    // ---
    //
    // $current_level:-
    //      o   The level that we've nested down to (and are currently at).
    //
    // ---
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
    // Finished ?
    // =========================================================================

    // TODO

    // =========================================================================
    // CREATE the ROOT DIRECTORY (if necessary)...
    // =========================================================================

    if ( is_dir( $to_dirspec ) ) {

        // =====================================================================
        // TO directory already exists!
        // =====================================================================

        if ( $question_strict ) {

            return <<<EOT
PROBLEM:&nbsp; Output directory already exists
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\copy_directory_tree()
EOT;

        }

        // ---------------------------------------------------------------------

    } else {

        // =====================================================================
        // CREATE TO directory...
        // =====================================================================

        // -------------------------------------------------------------------------
        // bool mkdir ( string $pathname [, int $mode = 0777 [, bool $recursive = false [, resource $context ]]] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Attempts to create the directory specified by pathname.
        //
        //      pathname
        //          The directory path.
        //
        //      mode
        //          The mode is 0777 by default, which means the widest possible
        //          access. For more information on modes, read the details on the
        //          chmod() page.
        //
        //          Note:
        //
        //          mode is ignored on Windows.
        //
        //          Note that you probably want to specify the mode as an octal
        //          number, which means it should have a leading zero. The mode is
        //          also modified by the current umask, which you can change using
        //          umask().
        //
        //      recursive
        //          Allows the creation of nested directories specified in the
        //          pathname.
        //
        //      context
        //          Note: Context support was added with PHP 5.0.0. For a
        //          description of contexts, refer to Streams.
        //
        // Returns TRUE on success or FALSE on failure.
        //
        // (PHP 4, PHP 5)
        //
        // CHANGELOG
        //      Version     Description
        //      -------     -------------------------------------------------------
        //      5.0.0       The recursive parameter was added
        //
        //      5.0.0       As of PHP 5.0.0 mkdir() can also be used with some URL
        //                  wrappers. Refer to Supported Protocols and Wrappers for
        //                  a listing of which wrappers support mkdir()
        //
        //      4.2.0       The mode parameter became optional.
        // -------------------------------------------------------------------------

        $mode      = 0755  ;    //  Standard Web/WordPress Directory permissions
        $recursive = FALSE ;

        // ---------------------------------------------------------------------

        $ok = mkdir(
                    $to_dirspec     ,
                    $mode           ,
                    $recursive
                    ) ;

//      echo '<br /><br />Copying DIR:&nbsp; ' , $from_dirspec , ' to:-<br />&nbsp;&nbsp;&nbsp;&nbsp;<b>' , $to_dirspec , '</b>' ;
//      $ok = TRUE ;

        // ---------------------------------------------------------------------

        if ( $ok !== TRUE ) {

            return <<<EOT
PROBLEM:&nbsp; "mkdir()" failure copying directory/sub-directory to output plugin
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\copy_directory_tree()
EOT;

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // COPY the root directory's DESCENDANTS...
    // =========================================================================

    return copy_directorys_descendants(
                $from_dirspec           ,
                $to_dirspec             ,
                $question_strict        ,
                $question_overwrite     ,
                $levels                 ,
                $current_level
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// copy_directorys_descendants()
// =============================================================================

function copy_directorys_descendants(
    $from_dirspec                   ,
    $to_dirspec                     ,
    $question_strict = TRUE         ,
    $question_overwrite = FALSE     ,
    $levels = 0                     ,
    $current_level = 0
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\copy_directorys_descendants(
    //      $from_dirspec                   ,
    //      $to_dirspec                     ,
    //      $question_strict = TRUE         ,
    //      $question_overwrite = FALSE     ,
    //      $levels = 0                     ,
    //      $current_level = 0
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Copies the specified directory tree.
    //
    // In other words (by default), copies the specified directory and all of
    // it's descendants.
    //
    // ---
    //
    // $question_strict:-
    //      o   TRUE means that NONE of the destination dirs and files may
    //          already exist.
    //      o   FALSE means that it's OK if any of the destination dirs and
    //          files already exist.  If the destination item that already
    //          exists is a FILE, then $question_overwrite describes how
    //          this should be handled.
    //
    // ---
    //
    // $question_overwrite:-
    //      (Only used if $question_strict is FALSE.)
    //      o   TRUE means that if a destination file already exists, then
    //          it MAY be overwritten.
    //      o   FALSE means that if a destination file already exists, then
    //          it may NOT be overwritten.  (Instead, the copy ends at this
    //          point - the existing file being a FATAL error.)
    //
    // ---
    //
    // $levels:-
    //      o   If $levels is 0, then we copy ALL of the destination
    //          directory's decendants (no matter ho deeply nested they are).
    //      o   If $levels is 1, then we copy only the DESTINATION
    //          DIRECTORY itself (but NONE of it's descendants).
    //      o   If $levels is 2, then we copy the destination directory and
    //          it's children (but NOT it's grandchildren, etc).
    //      o   And so on...
    //
    // ---
    //
    // $current_level:-
    //      o   The level that we've nested down to (and are currently at).
    //
    // ---
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
    // Open the FROM directory...
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

    $dir_handle = @opendir( $from_dirspec ) ;

    // -------------------------------------------------------------------------

    if ( $dir_handle === FALSE ) {

        return <<<EOT
PROBLEM: "opendir()" failure (while copying directory/sub-directory in directory tree)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\copy_directorys_descendants()
EOT;

    }

    // =========================================================================
    // Loop over the FROM directory's content, copying each one to the TO
    // directory in turn...
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

    while ( TRUE ) {

        // =====================================================================
        // Get the next FROM directory entry's basename...
        // =====================================================================

        $from_basename = readdir( $dir_handle ) ;
                            //  "readdir()" returns the directory entry's
                            //  BASENAME (NOT it's full pathspec)...

//echo '<br /><b>' , $from_basename , '</b>' ;

        // =====================================================================
        // All entries done ?
        // =====================================================================

        if ( $from_basename === FALSE ) {
            break ;
        }

        // =====================================================================
        // Skip "." and ".."...
        // =====================================================================

        if ( $from_basename === '.' || $from_basename === '..' ) {
            continue ;
        }

        // =====================================================================
        // Convert the FROM basename to pathspec...
        // =====================================================================

        $from_pathspec = $from_dirspec . '/' . $from_basename ;

        // =====================================================================
        // Get the TO pathspec...
        // =====================================================================

        $to_pathspec = $to_dirspec . '/' . $from_basename ;

        // =====================================================================
        // Process the FROM dir/file/link...
        // =====================================================================

        if ( is_dir( $from_pathspec ) ) {

            // =================================================================
            // DIR
            // =================================================================

            // -------------------------------------------------------------------------
            // \greatKiwi_pluginMaker_pluginVersion_directoryOperations\copy_directory_tree(
            //      $from_dirspec                   ,
            //      $to_dirspec                     ,
            //      $question_strict = TRUE         ,
            //      $question_overwrite = FALSE     ,
            //      $levels = 0                     ,
            //      $current_level = 0
            //      )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Copies the specified directory tree.
            //
            // In other words (by default), copies the specified directory and all of
            // it's descendants.
            //
            // ---
            //
            // $question_strict:-
            //      o   TRUE means that NONE of the destination dirs and files may
            //          already exist.
            //      o   FALSE means that it's OK if any of the destination dirs and
            //          files already exist.  If the destination item that already
            //          exists is a FILE, then $question_overwrite describes how
            //          this should be handled.
            //
            // ---
            //
            // $question_overwrite:-
            //      (Only used if $question_strict is FALSE.)
            //      o   TRUE means that if a destination file already exists, then
            //          it MAY be overwritten.
            //      o   FALSE means that if a destination file already exists, then
            //          it may NOT be overwritten.  (Instead, the copy ends at this
            //          point - the existing file being a FATAL error.)
            //
            // ---
            //
            // $levels:-
            //      o   If $levels is 0, then we copy ALL of the destination
            //          directory's decendants (no matter ho deeply nested they are).
            //      o   If $levels is 1, then we copy only the DESTINATION
            //          DIRECTORY itself (but NONE of it's descendants).
            //      o   If $levels is 2, then we copy the destination directory and
            //          it's children (but NOT it's grandchildren, etc).
            //      o   And so on...
            //
            // ---
            //
            // $current_level:-
            //      o   The level that we've nested down to (and are currently at).
            //
            // ---
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

            $result = copy_directory_tree(
                            $from_pathspec          ,
                            $to_pathspec            ,
                            $question_strict        ,
                            $question_overwrite     ,
                            $levels                 ,
                            $current_level + 1
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                closedir( $dir_handle ) ;
                return $result ;
            }

            // -----------------------------------------------------------------

        } elseif ( is_file( $from_pathspec ) ) {

            // =================================================================
            // FILE
            // =================================================================

            // -------------------------------------------------------------------------
            // bool copy ( string $source , string $dest [, resource $context ] )
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            // Makes a copy of the file source to dest.
            //
            // If you wish to move a file, use the rename() function.
            //
            //      source
            //          Path to the source file.
            //
            //      dest
            //          The destination path. If dest is a URL, the copy operation may
            //          fail if the wrapper does not support overwriting of existing
            //          files.
            //
            //          Warning:    If the destination file already exists, it will be
            //                      overwritten.
            //
            //      context
            //          A valid context resource created with stream_context_create().
            //
            // Returns TRUE on success or FALSE on failure.
            //
            // (PHP 4, PHP 5)
            //
            // CHANGELOG
            //      Version     Description
            //      -------     -----------------------------------------------
            //      5.3.0       Added context support.
            //
            //      4.3.0       Both source and dest may now be URLs if the "fopen
            //                  wrappers" have been enabled. See fopen() for more
            //                  details.
            // -------------------------------------------------------------------------

            $ok = copy( $from_pathspec , $to_pathspec ) ;

//          echo '<br /><br />Copying FILE:&nbsp; ' , $from_pathspec , ' to:-<br />&nbsp;&nbsp;&nbsp;&nbsp;<b>' , $to_pathspec , '</b>' ;
//          $ok = TRUE ;

            // -----------------------------------------------------------------

            if ( $ok !== TRUE ) {

                closedir( $dir_handle ) ;

                return <<<EOT
PROBLEM:&nbsp; "copy()" failure copying file to output plugin
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\copy_directorys_descendants()
EOT;

            }

            // -----------------------------------------------------------------

        } elseif ( is_link( $from_pathspec ) ) {

            // =================================================================
            // (SYMBOLIC) LINK
            // =================================================================

            // -------------------------------------------------------------------------
            // string readlink ( string $path )
            // - - - - - - - - - - - - - - - -
            // Returns the target of a symbolic link (does the same as the readlink C
            // function).
            //
            //      path
            //          The symbolic link path.
            //
            // Returns the contents of the symbolic link path or FALSE on error.
            //
            // (PHP 4, PHP 5)
            //
            // CHANGELOG
            //      Version     Description
            //      -------     ---------------------------------------------------
            //      5.3.0       This function is now available on Windows platforms
            //                  (Vista, Server 2008 or greater).
            // -------------------------------------------------------------------------

            $target = readlink( $from_pathspec ) ;

            // -----------------------------------------------------------------

            if ( $target === FALSE ) {

                closedir( $dir_handle ) ;

                return <<<EOT
PROBLEM:&nbsp; "readlink()" failure copying (symbolic) link to output plugin
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\copy_directorys_descendants()
EOT;

            }

            // -------------------------------------------------------------------------
            // bool symlink ( string $target , string $link )
            // - - - - - - - - - - - - - - - - - - - - - - -
            // symlink() creates a symbolic link to the existing target with the
            // specified name link.
            //
            //      target
            //          Target of the link.
            //
            //      link
            //          The link name.
            //
            // Returns TRUE on success or FALSE on failure.
            //
            // (PHP 4, PHP 5)
            //
            // CHANGELOG
            //      Version     Description
            //      -------     ---------------------------------------------------
            //      5.3.0       This function is now available on Windows platforms
            //                  (Vista, Server 2008 or greater).
            // -------------------------------------------------------------------------

            $ok = symlink( $target , $to_pathspec ) ;

//          echo '<br /><br />Copying (SYMBOLIC) LINK:&nbsp; ' , $from_pathspec , ' to:-<br />&nbsp;&nbsp;&nbsp;&nbsp;<b>' , $to_pathspec , '</b>' ;
//          $ok = TRUE ;

            // -----------------------------------------------------------------

            if ( $ok !== TRUE ) {

                return <<<EOT
PROBLEM:&nbsp; "symlink()" failure copying (symbolic) link to output plugin
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\copy_directorys_descendants()
EOT;

            }

            // -----------------------------------------------------------------

        } else {

            // =================================================================
            // ERROR
            // =================================================================

            closedir( $dir_handle ) ;

            return <<<EOT
PROBLEM: Unrecognised/unsupported directory entry (not dir, file or symbolic link)
Detected in:&nbsp; \\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_directoryOperations\\copy_directorys_descendants()
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


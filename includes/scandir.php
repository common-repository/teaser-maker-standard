<?php

// *****************************************************************************
// UTILS/SCANDIR.PHP
// (C) 2007 Peter Newman
// -----------------------------------------------------------------------------
// PHP 4/5 version of 'scandir()'...
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles ;

// =============================================================================
// super_scandir_error
// =============================================================================

function super_scandir_error( $error_message ) {

    // -----------------------------------------------------------------------

    if ( $_SERVER['HTTP_HOST'] === 'localhost' ) {
        $detected_in = '<p>Error detected in <b>' . __FILE__ . '</b></p>' ;

    } else {
        $detected_in = '' ;

        }

    // -----------------------------------------------------------------------

    standard_dialog(
        'super_scandir ERROR!'          ,
        $error_message . $detected_in
        ) ;

    // -----------------------------------------------------------------------

    }

// =============================================================================
// super_scandir
// =============================================================================

function super_scandir(
    $target_directory
    ) {

    // -----------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_dirsFiles\super_scandir(
    //      $target_directory
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
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
    //      Returns the following array success, or FALSE on failure.
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

    // -----------------------------------------------------------------------
    // Set the defaults (and check for errors)...
    // -----------------------------------------------------------------------

/*
    // -----------------------------------------------------------------------
    // question_dirs ?
    // -----------------------------------------------------------------------

    if ( ! isset( $options['question_dirs'] ) ) {
        $options['question_dirs'] = TRUE ;

    } elseif ( ! is_bool( $options['question_dirs'] ) ) {
        super_scandir_error( 'Bad question dirs!' ) ;

        }

    // -----------------------------------------------------------------------
    // question_files ?
    // -----------------------------------------------------------------------

    if ( ! isset( $options['question_files'] ) ) {
        $options['question_files'] = TRUE ;

    } elseif ( ! is_bool( $options['question_files'] ) ) {
        super_scandir_error( 'Bad question files!' ) ;

        }

    // -----------------------------------------------------------------------
    // question_strip_dot_and_dotdot ?
    // -----------------------------------------------------------------------

    if ( ! isset( $options['question_strip_dot_and_dotdot'] ) ) {
        $options['question_strip_dot_and_dotdot'] = TRUE ;

    } elseif ( ! is_bool( $options['question_strip_dot_and_dotdot'] ) ) {
        super_scandir_error( 'Bad question strip dot and dotdot!' ) ;

        }
*/

    // -----------------------------------------------------------------------
    // Call PHP scandir...
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // scandir_php4and5(
    //      $target_directory           ,
    //      $question_descending = 0    ,
    //      $context = NULL                 //  PHP 5 only!
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - -
    // A version of PHP 5's 'scandir()' that will work in PHP 4 too.
    //
    // Returns an array of files and directories from the directory.
    //
    // PARAMETERS
    //
    //      directory
    //          The directory that will be scanned.
    //
    //      question_descending
    //          By default, the sorted order is alphabetical in ascending
    //          order.  If the optional sorting_order is used (set to 1),
    //          then the sort order is alphabetical in descending order.
    //
    //      context
    //          For a description of the context parameter, refer to the
    //          streams section of the manual.
    //
    // RETURN VALUES
    //      Returns an array of filenames on success, or FALSE on failure.
    //      If directory is not a directory, then boolean FALSE is returned,
    //      and an error of level E_WARNING is generated.
    //
    // EXAMPLES
    //      $dir    = '/tmp';
    //      $files1 = webos_scandir($dir);
    //      $files2 = webos_scandir($dir, 1);
    //      print_r($files1);
    //      print_r($files2);
    //
    //      The above example will output something similar to:
    //          Array(
    //              [0] => .
    //              [1] => ..
    //              [2] => bar.php
    //              [3] => foo.txt
    //              [4] => somedir
    //              )
    //          Array(
    //              [0] => somedir
    //              [1] => foo.txt
    //              [2] => bar.php
    //              [3] => ..
    //              [4] => .
    //              )
    //
    // Tip:     You can use a URL as a filename with this function if the
    //          fopen wrappers have been enabled.  See fopen() for more
    //          details on how to specify the filename and Appendix M for
    //          a list of supported URL protocols.
    // -----------------------------------------------------------------------

    $result = scandir_php4and5( $target_directory ) ;

    // -----------------------------------------------------------------------

    if ( $result === FALSE ) {
        super_scandir_error(
            'scandir_php4and5 Failure:-' . print_r( error_get_last() , TRUE )
            ) ;
        }

    // -----------------------------------------------------------------------
    // Get rid of any "." and ".." entries (if required)...
    // -----------------------------------------------------------------------

/*
    if ( $options['question_strip_dot_and_dotdot'] ) {

        // -----------------------------------------------------------------------
        // mixed array_search ( mixed $needle , array $haystack [, bool $strict ] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns the key for needle if it is found in the array, FALSE
        // otherwise.
        //
        // If needle is found in haystack more than once, the first matching key
        // is returned.  To return the keys for all matching values, use
        // array_keys() with the optional search_value parameter instead.
        // -----------------------------------------------------------------------

        $re_index = FALSE ;

        // -------------------------------------------------------------------

        $index = array_search( '.' , $result , TRUE ) ;

        if ( $index !== FALSE ) {
            unset( $result[ $index ] ) ;
            $re_index = TRUE ;
            }

        // -------------------------------------------------------------------

        $index = array_search( '..' , $result , TRUE ) ;

        if ( $index !== FALSE ) {
            unset( $result[ $index ] ) ;
            $re_index = TRUE ;
            }

        // -------------------------------------------------------------------

        if ( $re_index ) {
            $result = array_values( $result ) ;
            }

        // -------------------------------------------------------------------

        }
*/

    // -----------------------------------------------------------------------
    // Delete the files and/or sub_directories, as requested...
    // -----------------------------------------------------------------------

/*
    if (    $options['question_dirs']
            &&
            $options['question_files']
        ) {

        // -------------------------------------------------------------------
        // DIRS and FILES!
        // -------------------------------------------------------------------

        return $result ;

        // -------------------------------------------------------------------

    } elseif ( $options['question_dirs'] ) {

        // -------------------------------------------------------------------
        // DIRS only!
        // -------------------------------------------------------------------

        foreach ( $result as $this_index => $this_basename ) {

            // ---------------------------------------------------------------

            if ( ! is_dir( $target_directory . '/' . $this_basename ) ) {
                unset( $result[ $this_index ] ) ;
                }

            // ---------------------------------------------------------------

            }

        // -------------------------------------------------------------------

    } elseif ( $options['question_files'] ) {

        // -------------------------------------------------------------------
        // FILES only!
        // -------------------------------------------------------------------

        foreach ( $result as $this_index => $this_basename ) {

            // ---------------------------------------------------------------

            if ( ! is_file( $target_directory . '/' . $this_basename ) ) {
                unset( $result[ $this_index ] ) ;
                }

            // ---------------------------------------------------------------

            }

        // -------------------------------------------------------------------

    } else {

        // -------------------------------------------------------------------
        // NOTHING!
        // -------------------------------------------------------------------

        $result = array() ;

        // -------------------------------------------------------------------

        }
*/

    // -----------------------------------------------------------------------
    // Separate the results into three sub-arrays...
    // -----------------------------------------------------------------------

    $dirs  = array() ;
    $files = array() ;
    $other = array() ;

    // -----------------------------------------------------------------------

    foreach ( $result as $this_FDE ) {

        if ( $this_FDE === '.' || $this_FDE === '..' ) {
            $other[] = $this_FDE ;

        } else {

            $this_pathspec = $target_directory . '/' . $this_FDE ;

            if ( is_file( $this_pathspec ) ) {
                $files[ $this_FDE ] = $this_pathspec ;

            } elseif ( is_dir( $this_pathspec ) ) {
                $dirs[ $this_FDE ] = $this_pathspec ;

            } else {
                $other[] = $this_FDE ;

            }

        }

    }

    // -----------------------------------------------------------------------
    // That's that!
    // -----------------------------------------------------------------------

    return array( 'dirs' => $dirs , 'files' => $files , 'other' => $other ) ;

    // -----------------------------------------------------------------------

    }

// ===========================================================================
// scandir_php4and5
// ===========================================================================

function scandir_php4and5(
    $target_directory           ,
    $question_descending = 0    ,
    $context = NULL
    ) {

    // -----------------------------------------------------------------------
    // scandir_php4and5(
    //      $target_directory           ,
    //      $question_descending = 0    ,
    //      $context = NULL                 //  PHP 5 only!
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - -
    // A version of PHP 5's 'scandir()' that will work in PHP 4 too.
    //
    // Returns an array of files and directories from the directory.
    //
    // PARAMETERS
    //
    //      directory
    //          The directory that will be scanned.
    //
    //      question_descending
    //          By default, the sorted order is alphabetical in ascending
    //          order.  If the optional sorting_order is used (set to 1),
    //          then the sort order is alphabetical in descending order.
    //
    //      context
    //          For a description of the context parameter, refer to the
    //          streams section of the manual.
    //
    // RETURN VALUES
    //      Returns an array of filenames on success, or FALSE on failure.
    //      If directory is not a directory, then boolean FALSE is returned,
    //      and an error of level E_WARNING is generated.
    //
    // EXAMPLES
    //      $dir    = '/tmp';
    //      $files1 = webos_scandir($dir);
    //      $files2 = webos_scandir($dir, 1);
    //      print_r($files1);
    //      print_r($files2);
    //
    //      The above example will output something similar to:
    //          Array(
    //              [0] => .
    //              [1] => ..
    //              [2] => bar.php
    //              [3] => foo.txt
    //              [4] => somedir
    //              )
    //          Array(
    //              [0] => somedir
    //              [1] => foo.txt
    //              [2] => bar.php
    //              [3] => ..
    //              [4] => .
    //              )
    //
    // Tip:     You can use a URL as a filename with this function if the
    //          fopen wrappers have been enabled.  See fopen() for more
    //          details on how to specify the filename and Appendix M for
    //          a list of supported URL protocols.
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // This routine's processing is PHP version specific...
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // string phpversion ( [string extension] )
    // - - - - - - - - - - - - - - - - - - - -
    // Returns a string containing the version of the currently running PHP
    // parser.  If the optional extension parameter is specified,
    // phpversion() returns the version of that extension, or FALSE if
    // there is no version information associated or the extension isn't
    // enabled.
    //
    // Note:    This information is also available in the predefined
    //          constant PHP_VERSION.
    //
    // EXAMPLE
    //      // prints e.g. 'Current PHP version: 4.1.1'
    //      echo 'Current PHP version: ' . phpversion();
    //
    //      // prints e.g. '2.0' or nothing if the extension isn't enabled
    //      echo phpversion('tidy');
    //
    // AVAILABLE
    //      PHP 3, PHP 4, PHP 5
    // -----------------------------------------------------------------------

    // -----------------------------------------------------------------------
    // If the second character of the string IS ".", then we can check the
    // first character to see if the version is += 5.
    //
    // If the second character of the string ISN'T ".", then we assume
    // that it must be nemeric, and we have version 10 or above.
    // -----------------------------------------------------------------------

    $PHP_version_5_or_above = TRUE ;

    // -----------------------------------------------------------------------

    if (    substr( phpversion() , 1 , 1 ) === '.'
            &&
            substr( phpversion() , 0 , 1 ) < 5
        ) {

        $PHP_version_5_or_above = FALSE ;

        }

    // -----------------------------------------------------------------------
    // 'scandir()' is supported in PHP version 5 and above...
    // -----------------------------------------------------------------------

    if ( $PHP_version_5_or_above ) {

        // -----------------------------------------------------------------------
        // array scandir ( string directory [, int sorting_order [, resource context]] )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // Returns an array of files and directories from the directory.
        //
        // PARAMETERS
        //
        //      directory
        //          The directory that will be scanned.
        //
        //      sorting_order
        //          By default, the sorted order is alphabetical in ascending
        //          order.  If the optional sorting_order is used (set to 1),
        //          then the sort order is alphabetical in descending order.
        //
        //      context
        //          For a description of the context parameter, refer to the
        //          streams section of the manual.
        //
        // RETURN VALUES
        //      Returns an array of filenames on success, or FALSE on failure.
        //      If directory is not a directory, then boolean FALSE is returned,
        //      and an error of level E_WARNING is generated.
        //
        // EXAMPLES
        //      $dir    = '/tmp';
        //      $files1 = scandir($dir);
        //      $files2 = scandir($dir, 1);
        //      print_r($files1);
        //      print_r($files2);
        //
        //      The above example will output something similar to:
        //          Array(
        //              [0] => .
        //              [1] => ..
        //              [2] => bar.php
        //              [3] => foo.txt
        //              [4] => somedir
        //              )
        //          Array(
        //              [0] => somedir
        //              [1] => foo.txt
        //              [2] => bar.php
        //              [3] => ..
        //              [4] => .
        //              )
        //
        // Tip:     You can use a URL as a filename with this function if the
        //          fopen wrappers have been enabled.  See fopen() for more
        //          details on how to specify the filename and Appendix M for
        //          a list of supported URL protocols.
        // -----------------------------------------------------------------------

        if ( $context === NULL ) {

            return scandir(
                $target_directory       ,
                $question_descending
                ) ;

        } else {

            return scandir(
                $target_directory       ,
                $question_descending    ,
                $context
                ) ;

            }

        // -------------------------------------------------------------------

        }

    // -----------------------------------------------------------------------
    // Below version 5, we use the routine suggested in the PHP Version 5
    // Manual entry for 'scandir()'.  However:-
    //
    // o    This may only work for PHP 4.
    //
    // o    The '$context' parameter ISN'T supported.
    // -----------------------------------------------------------------------

    $dir_handle = opendir( $target_directory ) ;

    // -----------------------------------------------------------------------

    if ( $dir_handle === FALSE ) {

        // -------------------------------------------------------------------

        return FALSE ;

        // -------------------------------------------------------------------

    } else {

        // -------------------------------------------------------------------

        while ( false !== ( $filename = readdir( $dir_handle ) ) ) {
            $files[] = $filename ;
            }

        // -------------------------------------------------------------------

        closedir( $dir_handle ) ;

        // -------------------------------------------------------------------

        if ( $question_descending ) {
            return rsort( $files ) ;

        } else {
            return  sort( $files ) ;

            }

        // -------------------------------------------------------------------

        }

    // -----------------------------------------------------------------------
    // That's that!
    // -----------------------------------------------------------------------

    }

// =============================================================================
// That's that!
// =============================================================================


<?php

// *****************************************************************************
// INCLUDES / ARRAY-STORAGE.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_arrayStorage ;

// =============================================================================
// CONFIG...
// =============================================================================

/*
    // -------------------------------------------------------------------------
    // NOTE!
    // -----
    // You need to set the following:-
    //      $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE']['...']
    //
    // variables for your specific application...
    // -------------------------------------------------------------------------

    // =========================================================================
    // If the arrays are being stored in JSON FILES...
    // =========================================================================

    $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE']['json_data_files_dir'] =
        PROTO_PRESS_BY_FERNTEC_DATA_DIR
        ;

    // =========================================================================
    // If the arrays are being stored in a WORDPRESS DATABASE...
    // =========================================================================

    // -------------------------------------------------------------------------
    // PROJECTS dataset...
    // -------------------------------------------------------------------------

    $basepress_dataset_uid_projects =
        'd2562b23-3c20-4368-92c4-2b6cd3fa722b' . '-' .
        '4d1e2f6c-bfd7-4d6d-a151-7710ac09802d' . '-' .
        '55672840-63d3-11e3-949a-0800200c9a66' . '-' .
        '627c9d30-63d3-11e3-949a-0800200c9a66'
        ;

    // -------------------------------------------------------------------------

    $basepress_dataset_handle_projects = array(
        'nice_name'     =>  'protoPress_byFernTec_projects'         ,
        'unique_key'    =>  $basepress_dataset_uid_projects       ,
        'version'       =>  '0.1'
        ) ;

    // -------------------------------------------------------------------------
    // REFERENCE URLS dataset...
    // -------------------------------------------------------------------------

    $basepress_dataset_uid_reference_urls =
        '2f35c079-ef2e-4dea-a0e2-f1f861375aef' . '-' .
        'afe2576d-76b2-4a5c-83a3-60b652467438' . '-' .
        '995a2d40-63d3-11e3-949a-0800200c9a66' . '-' .
        'a6acf950-63d3-11e3-949a-0800200c9a66'
        ;

    // -------------------------------------------------------------------------

    $basepress_dataset_handle_reference_urls = array(
        'nice_name'     =>  'protoPress_byFernTec_reference_urls'       ,
        'unique_key'    =>  $basepress_dataset_uid_reference_urls       ,
        'version'       =>  '0.1'
        ) ;

    // -------------------------------------------------------------------------
    // CANDIDATE PAGES dataset...
    // -------------------------------------------------------------------------

    $basepress_dataset_uid_candidate_pages =
        'ccc7eaf0-63d3-11e3-949a-0800200c9a66' . '-' .
        'fcbc06ea-9feb-4b4b-8d51-c0d88928ec2b' . '-' .
        'eaf2cd2e-8ada-4b65-a9c9-bcd2c214c187' . '-' .
        'f4ad272d-021b-4c5d-bfee-43644b44ce42'
        ;

    // -------------------------------------------------------------------------

    $basepress_dataset_handle_candidate_pages = array(
        'nice_name'     =>  'protoPress_byFernTec_candidate_pages'      ,
        'unique_key'    =>  $basepress_dataset_uid_candidate_pages      ,
        'version'       =>  '0.1'
        ) ;

    // -------------------------------------------------------------------------
    // TEST dataset...
    // -------------------------------------------------------------------------

    $basepress_dataset_uid_test =
        '-9a6e-ccb5d826-c0eb-4cfab538-4f96e100' . '-' .
        '-ae76-a1932fbc-2606-42a95a09-58720680' . '-' .
        '-949a-fb05ba50-594c-11e30800-200c9a66' . '-' .
        '-b3bc-970958d4-849c-4344e72d-3cff374e'
        ;

    // -------------------------------------------------------------------------

    $basepress_dataset_handle_test = array(
        'nice_name'     =>  'protoPress_byFernTec_test'           ,
        'unique_key'    =>  $basepress_dataset_uid_test         ,
        'version'       =>  '0.1'
        ) ;

    // =========================================================================
    // Define the DATASETS USED...
    // =========================================================================

    $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE']['supported_datasets'] = array(
        'projects'    =>  array(
                                'storage_method'            =>  NULL                                    ,
                                'json_filespec'             =>  NULL                                    ,
                                'basepress_dataset_handle'  =>  $basepress_dataset_handle_projects
                                )   ,
        'reference_urls'      =>  array(
                                'storage_method'            =>  NULL                                    ,
                                'json_filespec'             =>  NULL                                    ,
                                'basepress_dataset_handle'  =>  $basepress_dataset_handle_reference_urls
                                )   ,
        'candidate_pages'       =>  array(
                                'storage_method'            =>  NULL                                    ,
                                'json_filespec'             =>  NULL                                    ,
                                'basepress_dataset_handle'  =>  $basepress_dataset_handle_candidate_pages
                                )   ,
        'test-dataset'  =>  array(
                                'storage_method'            =>  NULL                                    ,
                                'json_filespec'             =>  NULL                                    ,
                                'basepress_dataset_handle'  =>  $basepress_dataset_handle_test
                                )
        ) ;

    // =========================================================================
    // Define the DEFAULT STORAGE METHOD...
    // =========================================================================

//  $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE']['default_storage_method'] = 'json' ;
    $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE']['default_storage_method'] = 'basepress-dataset' ;
*/

// =============================================================================
// init()
// =============================================================================

function init(
    $default_storage_method         ,
    $json_data_files_dir = NULL     ,
    $supported_datasets = array()
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\init(
    //      $default_storage_method         ,
    //      $json_data_files_dir = NULL     ,
    //      $supported_datasets = array()
    //      )
    // - - - - - - - - - - - - - - - - -
    // You MUST call this function - to initialise the array storage system -
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

    // =========================================================================
    // ERROR CHECKING
    // =========================================================================

    // -------------------------------------------------------------------------
    // default_storage_method ?
    // -------------------------------------------------------------------------

    if (    ! is_string( $default_storage_method )
            ||
            ! in_array( $default_storage_method , array( 'json' , 'basepress-dataset' ) , TRUE )
        ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "default storage method" (must be one of:- "json", "basepress-dataset")
Detected in:&nbsp; \greatKiwi_arrayStorage\init()
EOT;

    }

    // -------------------------------------------------------------------------
    // json_data_files_dir ?
    // -------------------------------------------------------------------------

    //  Checked if needed

    // -------------------------------------------------------------------------
    // supported_datasets ?
    // -------------------------------------------------------------------------

    if ( ! is_array( $supported_datasets ) ) {

        return <<<EOT
PROBLEM:&nbsp; Bad "supported datasets" (not a (possibly empty) array)
Detected in:&nbsp; \greatKiwi_arrayStorage\init()
EOT;

    }

    // =========================================================================
    // SAVE the supplied setup data...
    // =========================================================================

    $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE'] = array(
        'default_storage_method'    =>  $default_storage_method     ,
        'json_data_files_dir'       =>  $json_data_files_dir        ,
        'supported_datasets'        =>  $supported_datasets
        ) ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return TRUE ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// load_numerically_indexed()
// =============================================================================

function load_numerically_indexed(
    $dataset_name                       ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\load_numerically_indexed(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
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

    // =========================================================================
    // LOAD the ARRAY...
    // =========================================================================

    $result = load(
                $dataset_name               ,
                $question_die_on_error      ,
                $array_storage_data
                ) ;

    // =======================================================================
    // Make sure the records are numerically indexed, starting from 0
    // (and in steps of 1).
    //
    // Because many of the PHP and Javascript routines that handle the
    // returned PHP array assume this to be the case - and will fail if
    // it isn't)...
    // =======================================================================

    if ( is_array( $result ) ) {
        $result = array_values( $result ) ;
    }

    // =======================================================================
    // RETURN the results...
    // =======================================================================

//if ( is_array( $result ) ) {
//    pr( $result , ' ' . $dataset_name . ' as loaded...' ) ;
//}

    return $result ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// =============================================================================
// load()
// =============================================================================

function load(
    $dataset_name                       ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\load(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Loads and returns the specified PHP numerically indexed or associative
    // ARRAY.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          A possibly empty PHP numerically indexed or associative ARRAY.
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // DEFAULT the ARRAY STORAGE DATA...
    // =========================================================================

    if ( $array_storage_data === NULL ) {
        $array_storage_data = $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE'] ;
    }

    // =========================================================================
    // DATASET NAME VALID ?
    // =========================================================================

    if ( ! array_key_exists(    $dataset_name                               ,
                                $array_storage_data['supported_datasets']
                                ) ) {

        // ---------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM: Unrecognised/unsupported "dataset name" ("{$dataset_name}")
Detected in: "\greatKiwi_arrayStorage\load()"
EOT;

        // ---------------------------------------------------------------------

        if ( $question_die_on_error ) {
            die( $msg ) ;
        }

        // ---------------------------------------------------------------------

        return $msg ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the STORAGE METHOD to use...
    // =========================================================================

    $storage_method =
        $array_storage_data['supported_datasets'][ $dataset_name ]['storage_method']
        ;

    // -------------------------------------------------------------------------

    if ( ! is_string( $storage_method ) ) {

        $storage_method =
            $array_storage_data['default_storage_method']
            ;

    }

    // =========================================================================
    // Load the ARRAY...
    // =========================================================================

    if ( $storage_method === 'json' ) {

        // ---------------------------------------------------------------------
        // JSON
        // ---------------------------------------------------------------------

        return load_array_from_json_file(
                    $dataset_name               ,
                    $question_die_on_error      ,
                    $array_storage_data
                    ) ;

        // ---------------------------------------------------------------------

    } elseif ( $storage_method === 'basepress-dataset' ) {

        // ---------------------------------------------------------------------
        // BASEPRESS DATASET
        // ---------------------------------------------------------------------

        return load_array_from_basepress_dataset(
                    $dataset_name               ,
                    $question_die_on_error      ,
                    $array_storage_data
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Bad STORAGE METHOD!
    // =========================================================================

    $msg = <<<EOT
PROBLEM: Unrecognised/unsupported "storage method" ("{$storage_method}")
Detected in: "\greatKiwi_arrayStorage\load_array()"
EOT;

    // ---------------------------------------------------------------------

    if ( $question_die_on_error ) {
        die( $msg ) ;
    }

    // ---------------------------------------------------------------------

    return $msg ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// load_array_from_json_file()
// =============================================================================

function load_array_from_json_file(
    $dataset_name                       ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\load_array_from_json_file(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // NOTE!
    // -----
    // Call this routine via "\greatKiwi_arrayStorage\load()".
    // DON'T call it directly!
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          A possibly empty numerically indexed or associative PHP ARRAY.
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // DEFAULT the ARRAY STORAGE DATA...
    // =========================================================================

    if ( $array_storage_data === NULL ) {
        $array_storage_data = $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE'] ;
    }

    // =========================================================================
    // LOAD the DATASET from it's JSON FILE...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/json-stored-arrays.php' ) ;

    // -----------------------------------------------------------------------
    // \greatKiwi_jsonStoredArrays\load(
    //      $filespec                           ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // If the file exists, loads it and converts it's content into a PHP
    // (numeric or associative) ARRAY.
    //
    // If the file doesn't exist or contains no content, returns an
    // empty array.
    //
    // Otherwise, returns an error message STRING.
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    //
    // NOTE!
    // -----
    // The JSON in the file must be something that "json_decode()" will
    // convert into a PHP ARRAY.
    //
    // This will be the case if the array was created and saved from PHP,
    // with either:-
    //      o   \greatKiwi_jsonStoredArrays\save_array(
    //      o   \greatKiwi_jsonStoredArrays\save_numeric_array(
    //
    // or:-
    //      o   Some PHP code that did something like:-
    //              $json = json_encode( $some_php_array ) ;
    //              file_put_contents( $filespec , $json ) ;
    //
    // But if the JSON file was created some other way, the onus is on
    // whowever created it to make sure that PHP's "json_decode()" will
    // convert into a PHP ARRAY.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          (A possibly empty PHP numeric or associative ARRAY)
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -----------------------------------------------------------------------

    $json_filespec = NULL ;

    // -------------------------------------------------------------------------

    if ( isset( $array_storage_data['supported_datasets'][ $dataset_name ]['json_filespec'] ) ) {

        $json_filespec =
            $array_storage_data['supported_datasets'][ $dataset_name ]['json_filespec']
            ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $json_filespec )
            ||
            trim( $json_filespec ) === ''
        ) {

        // ---------------------------------------------------------------------

        if (    ! is_string( $array_storage_data['json_data_files_dir'] )
                ||
                trim( $array_storage_data['json_data_files_dir'] ) === ''
            ) {

            // -----------------------------------------------------------------

            $msg = <<<EOT
PROBLEM: Invalid JSON data files dir (not specified properly)
Detected in: "\greatKiwi_arrayStorage\load_array_from_json_file()"
EOT;

            // -----------------------------------------------------------------

            if ( $question_die_on_error ) {
                die( $msg ) ;
            }

            // -----------------------------------------------------------------

            return $msg ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        if ( ! is_dir( $array_storage_data['json_data_files_dir'] ) ) {

            // -----------------------------------------------------------------

            $msg = <<<EOT
PROBLEM: Bad JSON data files dir (doesn't exist)
Detected in: "\greatKiwi_arrayStorage\load_array_from_json_file()"
EOT;

            // -----------------------------------------------------------------

            if ( $question_die_on_error ) {
                die( $msg ) ;
            }

            // -----------------------------------------------------------------

            return $msg ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        $json_filespec =    $array_storage_data['json_data_files_dir'] .
                            '/' .
                            $dataset_name .
                            '.json'
                            ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $result = \greatKiwi_jsonStoredArrays\load(
                    $json_filespec              ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        // ---------------------------------------------------------------------

        if ( $question_die_on_error ) {
            die( $result ) ;
        }

        // ---------------------------------------------------------------------

        return $result ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $result ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// load_array_from_basepress_dataset()
// =============================================================================

function load_array_from_basepress_dataset(
    $dataset_name                       ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\load_array_from_basepress_dataset(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // NOTE!
    // -----
    // Call this routine via "\greatKiwi_arrayStorage\load()".
    // DON'T call it directly!
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY $array
    //          A possibly empty PHP numerically indexed or associative ARRAY.
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // DEFAULT the ARRAY STORAGE DATA...
    // =========================================================================

    if ( $array_storage_data === NULL ) {
        $array_storage_data = $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE'] ;
    }

    // =========================================================================
    // LOAD the DATASET from the DATABASE...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/basepress-datasets.php' ) ;

    // -------------------------------------------------------------------------
    // \basepress_datasets\load(
    //      $basepress_dataset_handle
    //      )
    // - - - - - - - - - - - - - - -
    // Returns the specified dataset (as a PHP array).  Unless an error occurs
    // while retrieving it (from the WordPress MySQL database), in which case
    // an error message string is returned.
    //
    // $basepress_dataset_handle is like (eg):-
    //
    //      $basepress_dataset_handle = array(
    //          'nice_name'     =>  "xxx"
    //          'unique_key'    =>  "xxx"
    //          'version'       =>  "xxx"
    //          ) ;
    //
    // Where:-
    //
    //      o   $nice_name
    //              is a max 255 character string that gives a friendly but
    //              hopefully still unique name to the dataset.  Usually,
    //              datasets will be owned by plugins or themes.  So the
    //              $nice_name will be that of the plugin or them.  But
    //              possibly with some extra words to identify the author
    //              (whether an individual or a business) - and anything else
    //              that might help to uniquely identify the dataset.
    //
    //              For example:-
    //                  "wordpress-post-search-and-replace-by-cocktail-systems"
    //
    //              The intention with this name, is to create something that
    //              no other dataset - created by another plugin or theme - is
    //              likely to duplicate.
    //
    //      o   $unique_key
    //              is a max 255 character string that gives a genuinely random
    //              and thereby almost certainly unique name to the dataset.
    //
    //              For example:-
    //                  "85adfc5b-f268-441a-8aa8-40913d816b49-48bfb6c4-d951"
    //
    //              In other words, it's something that the online password and
    //              GUID/UUID generators can easily generate for you.  To
    //              maximise the chances of uniqueness, you can easily string
    //              multiple such passwords/GUIDs together - up to the 255
    //              character limit.
    //
    //              The idea with the $unique_key is simply to decrease the
    //              chances that some other plugin or theme author will
    //              (accidentally) duplicate BOTH the $nice_name and the
    //              $unique_key that you selected.
    //
    //      o   $version
    //              is a max 255 character string that you can use to assign
    //              a version number to your dataset.  Obviously, as you
    //              release new/updated versions of your plugin or theme,
    //              while some might use exactly the same dataset as previous
    //              versions, others may not.
    //
    //              So $version allows you to differentiate between the
    //              different versions you might create.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          ARRAY( $record_id , $data )
    //
    //          Where:-
    //          o   $record_id is either:-
    //              --  The record ID of the "basepress_datasets" table
    //                  record (that holds the requested dataset's data), or;
    //
    //              --  NULL if either the "basePress_datasets" table - or the
    //                  specified dataset record - doesn't exist yet).
    //
    //          o   $data is a (possibly empty) PHP associative ARRAY of
    //              name=value pairs.
    //
    //      o   On FAILURE
    //          - - - - -
    //          An error message STRING.
    // -------------------------------------------------------------------------

    $basepress_dataset_handle =
        $array_storage_data['supported_datasets'][ $dataset_name ]['basepress_dataset_handle']
        ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressDatasets\load(
                    $basepress_dataset_handle
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        // ---------------------------------------------------------------------

        if ( $question_die_on_error ) {
            die( $result ) ;
        }

        // ---------------------------------------------------------------------

        return $result ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    list( $record_id , $data ) = $result ;

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $data ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// save_numerically_indexed()
// =============================================================================

function save_numerically_indexed(
    $dataset_name                       ,
    $array_to_save                      ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\save_numerically_indexed(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // Saves the specified numerically-indexed PHP array.
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    // =======================================================================
    // Make sure the records are numerically indexed, starting from 0
    // (and in steps of 1).
    //
    // Because many of the PHP and Javascript routines that handle the
    // returned PHP array assume this to be the case - and will fail if
    // it isn't)...
    // =======================================================================

    if ( is_array( $array_to_save ) ) {
        $array_to_save = array_values( $array_to_save ) ;
    }

    // =======================================================================
    // Do the SAVE proper...
    // =======================================================================

    return save(
                $dataset_name               ,
                $array_to_save              ,
                $question_die_on_error      ,
                $array_storage_data
                ) ;

    // =======================================================================
    // That's that!
    // =======================================================================

}

// =============================================================================
// save()
// =============================================================================

function save(
    $dataset_name                       ,
    $array_to_save                      ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\save(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Saves the specified (PHP) array.
    //
    // This array is typically either:-
    //
    //      o   An PHP NUMERICALLY-INDEXED ARRAY of RECORDS
    //
    //              Eg:-
    //                  $returned_array = array(
    //                      [0] =>  array(
    //                                  'name1' =>  <value1>
    //                                  'name2' =>  <value2>
    //                                  ...
    //                                  'nameN' =>  <valueN>
    //                                  )   ,
    //                      ...
    //                      )
    //
    //      o   A PHP ASSOCIATIVE ARRAY of NAME=VALUE PAIRS
    //
    //              Eg:-
    //                  $returned_array = array(
    //                      'name1' =>  <value1>
    //                      'name2' =>  <value2>
    //                      ...
    //                      'nameN' =>  <valueN>
    //                      )
    //
    //          Where each value can itself be a numeric or associative array
    //          (to any depth).
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // DEFAULT the ARRAY STORAGE DATA...
    // =========================================================================

    if ( $array_storage_data === NULL ) {
        $array_storage_data = $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE'] ;
    }

    // =========================================================================
    // DATASET NAME VALID ?
    // =========================================================================

    if ( ! array_key_exists(    $dataset_name                               ,
                                $array_storage_data['supported_datasets']
                                ) ) {

        // ---------------------------------------------------------------------

        $msg = <<<EOT
PROBLEM: Unrecognised/unsupported "dataset name" ("{$dataset_name}")
Detected in: "\greatKiwi_arrayStorage\save()"
EOT;

        // ---------------------------------------------------------------------

        if ( $question_die_on_error ) {
            die( $msg ) ;
        }

        // ---------------------------------------------------------------------

        return $msg ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Get the STORAGE METHOD to use...
    // =========================================================================

    $storage_method =
        $array_storage_data['supported_datasets'][ $dataset_name ]['storage_method']
        ;

    // -------------------------------------------------------------------------

    if ( ! is_string( $storage_method ) ) {

        $storage_method =
            $array_storage_data['default_storage_method']
            ;

    }

    // =========================================================================
    // Save the ARRAY...
    // =========================================================================

//pr( $array_to_save , ' ' . $dataset_name . ' as saved...' ) ;

    if ( $storage_method === 'json' ) {

        // ---------------------------------------------------------------------
        // JSON
        // ---------------------------------------------------------------------

        return save_array_to_json_file(
                    $dataset_name               ,
                    $array_to_save              ,
                    $question_die_on_error      ,
                    $array_storage_data
                    ) ;

        // ---------------------------------------------------------------------

    } elseif ( $storage_method === 'basepress-dataset' ) {

        // ---------------------------------------------------------------------
        // BASEPRESS DATASET
        // ---------------------------------------------------------------------

        return save_array_to_basepress_dataset(
                    $dataset_name               ,
                    $array_to_save              ,
                    $question_die_on_error      ,
                    $array_storage_data
                    ) ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Bad STORAGE METHOD!
    // =========================================================================

    $msg = <<<EOT
PROBLEM: Unrecognised/unsupported "storage method" ("{$storage_method}")
Detected in: "\greatKiwi_arrayStorage\save_array()"
EOT;

    // ---------------------------------------------------------------------

    if ( $question_die_on_error ) {
        die( $msg ) ;
    }

    // ---------------------------------------------------------------------

    return $msg ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// save_array_to_json_file()
// =============================================================================

function save_array_to_json_file(
    $dataset_name                       ,
    $array_to_save                      ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\save_array_to_json_file(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - -
    // NOTE!
    // -----
    // Call this routine via "\greatKiwi_arrayStorage\save_array".
    // DON'T call it directly!
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // DEFAULT the ARRAY STORAGE DATA...
    // =========================================================================

    if ( $array_storage_data === NULL ) {
        $array_storage_data = $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE'] ;
    }

    // =========================================================================
    // SAVE the ARRAY...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/json-stored-arrays.php' ) ;

    // -----------------------------------------------------------------------
    // \greatKiwi_jsonStoredArrays\save(
    //      $array                          ,
    //      $filespec                       ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - -
    // Encodes the specified ARRAY as JSON, and saves the result to the
    // specified file.
    //
    // Returns:-
    //      o   TRUE on success.
    //      o   Error message STRING on failure.
    //
    // Unless $question_die_on_error is TRUE, in which case it dies with
    // the relevant error message.
    // -----------------------------------------------------------------------

    $json_filespec = NULL ;

    // -------------------------------------------------------------------------

    if ( isset( $array_storage_data['supported_datasets'][ $dataset_name ]['json_filespec'] ) ) {

        $json_filespec =
            $array_storage_data['supported_datasets'][ $dataset_name ]['json_filespec']
            ;

    }

    // -------------------------------------------------------------------------

    if (    ! is_string( $json_filespec )
            ||
            trim( $json_filespec ) === ''
        ) {

        // ---------------------------------------------------------------------

        if ( ! is_dir( $array_storage_data['json_data_files_dir'] ) ) {

            // -----------------------------------------------------------------

            $msg = <<<EOT
PROBLEM: Bad JSON data files dir (doesn't exist)
Detected in: "\greatKiwi_arrayStorage\save_array_to_json_file()"
EOT;

            // -----------------------------------------------------------------

            if ( $question_die_on_error ) {
                die( $msg ) ;
            }

            // -----------------------------------------------------------------

            return $msg ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

        $json_filespec =    $array_storage_data['json_data_files_dir'] .
                            '/' .
                            $dataset_name .
                            '.json'
                            ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    $result = \greatKiwi_jsonStoredArrays\save(
                    $array_to_save              ,
                    $json_filespec              ,
                    $question_die_on_error
                    ) ;

    // -------------------------------------------------------------------------

    if ( $result !== TRUE ) {

        // ---------------------------------------------------------------------

        if ( $question_die_on_error ) {
            die( $result ) ;
        }

        // ---------------------------------------------------------------------

        return $result ;

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // SUCCESS!
    // =========================================================================

    return $result ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// save_array_to_basepress_dataset()
// =============================================================================

function save_array_to_basepress_dataset(
    $dataset_name                       ,
    $array_to_save                      ,
    $question_die_on_error = FALSE      ,
    $array_storage_data = NULL
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\save_array_to_basepress_dataset(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE      ,
    //      $array_storage_data = NULL
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // NOTE!
    // -----
    // Call this routine via "\greatKiwi_arrayStorage\save()".
    // DON'T call it directly!
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          TRUE
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // DEFAULT the ARRAY STORAGE DATA...
    // =========================================================================

    if ( $array_storage_data === NULL ) {
        $array_storage_data = $GLOBALS['GREAT_KIWI']['ARRAY_STORAGE'] ;
    }

    // =========================================================================
    // SAVE the ARRAY...
    // =========================================================================

    require_once( dirname( __FILE__ ) . '/basepress-datasets.php' ) ;

    // -------------------------------------------------------------------------
    // \basepress_datasets\save(
    //      $basepress_dataset_handle   ,
    //      $data                       ,
    //      $record_id = NULL
    //      )
    // - - - - - - - - - - - - - - - - -
    // Saves the supplied data to the specified dataset.
    //
    // ---
    //
    // $basepress_dataset_handle is like (eg):-
    //
    //      $basepress_dataset_handle = array(
    //          'nice_name'     =>  "xxx"
    //          'unique_key'    =>  "xxx"
    //          'version'       =>  "xxx"
    //          ) ;
    //
    // Where:-
    //
    //      o   $nice_name
    //              is a max 255 character string that gives a friendly but
    //              hopefully still unique name to the dataset.  Usually,
    //              datasets will be owned by plugins or themes.  So the
    //              $nice_name will be that of the plugin or them.  But
    //              possibly with some extra words to identify the author
    //              (whether an individual or a business) - and anything else
    //              that might help to uniquely identify the dataset.
    //
    //              For example:-
    //                  "wordpress-post-search-and-replace-by-cocktail-systems"
    //
    //              The intention with this name, is to create something that
    //              no other dataset - created by another plugin or theme - is
    //              likely to duplicate.
    //
    //      o   $unique_key
    //              is a max 255 character string that gives a genuinely random
    //              and thereby almost certainly unique name to the dataset.
    //
    //              For example:-
    //                  "85adfc5b-f268-441a-8aa8-40913d816b49-48bfb6c4-d951"
    //
    //              In other words, it's something that the online password and
    //              GUID/UUID generators can easily generate for you.  To
    //              maximise the chances of uniqueness, you can easily string
    //              multiple such passwords/GUIDs together - up to the 255
    //              character limit.
    //
    //              The idea with the $unique_key is simply to decrease the
    //              chances that some other plugin or theme author will
    //              (accidentally) duplicate BOTH the $nice_name and the
    //              $unique_key that you selected.
    //
    //      o   $version
    //              is a max 255 character string that you can use to assign
    //              a version number to your dataset.  Obviously, as you
    //              release new/updated versions of your plugin or theme,
    //              while some might use exactly the same dataset as previous
    //              versions, others may not.
    //
    //              So $version allows you to differentiate between the
    //              different versions you might create.
    //
    // ---
    //
    // $record_id can be either:-
    //
    //      o   The record ID retrieved when the dataset was originally loaded
    //          (by "\basepress_datasets\load()"), or;
    //
    //      o   NULL if either the dataset's record (and possibly the
    //          "basepress_datasets" table too,) doesn't exist.  Or the
    //          record may exist - but it's record ID isn't known.
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS
    //          - - - - -
    //          INT The saved dataset's $record_id.  (Which is returned in
    //          case either the dataset didn't exist (before it was saved). Or
    //          it did exist, but it's record ID was unknown.)
    //
    //      o   On FAILURE
    //          - - - - -
    //          An error message STRING.
    // -------------------------------------------------------------------------

    $basepress_dataset_handle =
        $array_storage_data['supported_datasets'][ $dataset_name ]['basepress_dataset_handle']
        ;

    // -------------------------------------------------------------------------

    $record_id = NULL ;

    // -------------------------------------------------------------------------

    $result = \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_basepressDatasets\save(
                    $basepress_dataset_handle   ,
                    $array_to_save              ,
                    $record_id
                    ) ;

    // -------------------------------------------------------------------------

    if ( is_string( $result ) ) {

        // ---------------------------------------------------------------------

        if ( $question_die_on_error ) {
            die( $result ) ;
        }

        // ---------------------------------------------------------------------

        return $result ;

        // ---------------------------------------------------------------------

    }

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


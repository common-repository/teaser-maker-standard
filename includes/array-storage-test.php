<?php

    namespace wooDeals_byFernTec ;

// =============================================================================
// array_storage_test()
// =============================================================================

function array_storage_test() {

    // -------------------------------------------------------------------------

    require_once( dirname( __FILE__ ) . '/array-storage.php' ) ;

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\load(
    //      $dataset_name                       ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Loads and returns the specified (PHP) array.
    //
    // This array is typically either:-
    //
    //      o   An PHP NUMERIC ARRAY of RECORDS
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
    //          ARRAY $array
    //          (A possibly empty PHP numeric or associative ARRAY)
    //
    //      o   On FAILURE
    //          - - - - -
    //          $error message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // \greatKiwi_arrayStorage\save(
    //      $dataset_name                       ,
    //      $array_to_save                      ,
    //      $question_die_on_error = FALSE
    //      )
    // - - - - - - - - - - - - - - - - - - - - -
    // Saves the specified (PHP) array.
    //
    // This array is typically either:-
    //
    //      o   An PHP NUMERIC ARRAY of RECORDS
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
    // LOAD the TEST ARRAY...
    // =========================================================================

    $dataset_name = 'test-dataset' ;

    $question_die_on_error = TRUE ;

    // -------------------------------------------------------------------------

    $test_array = \greatKiwi_arrayStorage\load_numerically_indexed(
                        $dataset_name               ,
                        $question_die_on_error
                        ) ;

    // =========================================================================
    // SUBMISSION HANDLING...
    // =========================================================================

    if (    count( $_POST ) > 0
            &&
            isset( $_POST['submit'] )
        ) {

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $_POST = Array(
        //                  [submit] => Add Record
        //                  )
        //
        // ---------------------------------------------------------------------

pr( $_POST ) ;

        // =====================================================================
        // Add Record
        // =====================================================================

        if ( $_POST['submit'] === 'Add Record' ) {

            // -----------------------------------------------------------------

            $dummy_record = array(
                                'name_1'     =>  'value_1'  ,
                                'name_2'     =>  'value_2'  ,
                                'name_3'     =>  'value_3'
                                ) ;

            // -----------------------------------------------------------------

            $test_array[] = $dummy_record ;

pr( $test_array ) ;

            // -----------------------------------------------------------------

            $ok = \greatKiwi_arrayStorage\save_numerically_indexed(
                        $dataset_name               ,
                        $test_array                 ,
                        $question_die_on_error
                        ) ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // DISPLAY the PAGE...
    // =========================================================================

    $data_rows = '' ;

    // -------------------------------------------------------------------------

    foreach ( $test_array as $key => $value ) {

        // ---------------------------------------------------------------------

        ob_start() ;
            pr( $value ) ;
        $value = ob_get_clean() ;

        // ---------------------------------------------------------------------

        $data_rows .= <<<EOT
<tr>
    <td>{$key}</td>
    <td>{$value}</td>
    <td><form
            method="post"
            action=""
            >
        <input  type="hidden"
                name="key_to_delete"
                value="{$key}"
                />
        <input  type="submit"
                value="Delete Record"
                />
    </form></td>
</tr>
EOT;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( $data_rows === '' ) {

        $body_content = <<<EOT
<p>...no records...</p>
EOT;

    } else {

        $body_content = <<<EOT
<table
    border="1"
    cellpadding="4"
    cellspacing="0"
    >{$data_rows}</table>
EOT;

    }

    // -------------------------------------------------------------------------

    echo <<<EOT
<h1>Array Data Testing</h1>

<p><form
        method="post"
        action=""
        >
    <input  type="submit"
            name="submit"
            value="Add Record"
            />
</form></p>

{$body_content}

<br />
<br />
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================


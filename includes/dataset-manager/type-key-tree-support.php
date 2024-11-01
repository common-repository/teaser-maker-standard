<?php

// *****************************************************************************
// DATASET-MANAGER / TYPE-KEY-TREE-SUPPORT.PHP
// (C) 2014 Peter Newman. All Rights Reserved.
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager ;

// =============================================================================
// create_type_key_tree()
// =============================================================================

function create_type_key_tree(
    $type_key_list
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\create_type_key_tree(
    //      $type_key_list
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Converts the input "type key list" into a "type key tree".
    //
    // ---
    //
    // The input $type_key_list is like (eg):-
    //
    //      $type_key_list = array(
    //
    //          [0] => Array(
    //                      [type]                  => document
    //                      [key]                   => 531812f122157
    //                      [parent_type]           =>
    //                      [parent_key]            =>
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Teaser Maker User Manual
    //                      )
    //
    //          [1] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      )
    //
    //          [2] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      )
    //
    //          [3] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319791c35a4e
    //                      [parent_type]           => section
    //                      [parent_key]            => 53194283b436f
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Child of Chapter 1
    //                      )
    //
    //          )
    //
    // ---
    //
    // The output $type_key_tree is like (eg):-
    //
    //      $type_key_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          ...
    //
    //          )
    //
    // ---
    //
    // The output $ancestry_by_type_key is like (eg):-
    //
    //      $ancestry_by_type_key = array(
    //
    //          [document-531812f122157] => Array()
    //
    //          [section-5319171085fbc] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          )
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS!
    //              array(
    //                  $type_key_tree          ,
    //                  $ancestry_by_type_key
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $type_key_list = array(
    //
    //          [0] => Array(
    //                      [type]                  => document
    //                      [key]                   => 531812f122157
    //                      [parent_type]           =>
    //                      [parent_key]            =>
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Teaser Maker User Manual
    //                      )
    //
    //          [1] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      )
    //
    //          [2] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      )
    //
    //          [3] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319791c35a4e
    //                      [parent_type]           => section
    //                      [parent_key]            => 53194283b436f
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Child of Chapter 1
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_list ) ;

    // =========================================================================
    // Create the "type_dash_key_list" from the "type_key_list"...
    //
    // The "type-dash-key-list" is the same as the "type_key_list" (from which
    // it's generated).  Except that:-
    //
    //      1.  Each list eleent is indexed by it's own:-
    //              <type>-<key>
    //
    //          And:-
    //
    //      2.  An:-
    //              'ancestor_type_keys'
    //
    //          field (set to NULL), is added to each list element.
    //
    // Eg:-
    //
    //      $type_dash_key_list = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          [section-5319171085fbc]     => Array(
    //              [type]                  => section
    //              [key]                   => 5319171085fbc
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Intro 2
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [type]                  => section
    //              [key]                   => 53194283b436f
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 20
    //              [secondary_sort_value]  => Chapter 1
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [type]                  => section
    //              [key]                   => 5319791c35a4e
    //              [parent_type]           => section
    //              [parent_key]            => 53194283b436f
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Child of Chapter 1
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          )
    //
    // =========================================================================

    $type_dash_key_list = array() ;

    // -------------------------------------------------------------------------

    foreach ( $type_key_list as $this_index => $this_data ) {

        // ---------------------------------------------------------------------

        $type_key = $this_data['type'] . '-' . $this_data['key'] ;

        // ---------------------------------------------------------------------

        $type_dash_key_list[ $type_key ] = $this_data ;

        // ---------------------------------------------------------------------

        $type_dash_key_list[ $type_key ]['ancestor_type_keys'] = NULL ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $type_dash_key_list = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          [section-5319171085fbc]     => Array(
    //              [type]                  => section
    //              [key]                   => 5319171085fbc
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Intro 2
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [type]                  => section
    //              [key]                   => 53194283b436f
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 20
    //              [secondary_sort_value]  => Chapter 1
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [type]                  => section
    //              [key]                   => 5319791c35a4e
    //              [parent_type]           => section
    //              [parent_key]            => 53194283b436f
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Child of Chapter 1
    //              [ancestor_type_keys]    => NULL
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_dash_key_list ) ;

    // =========================================================================
    // Work through the newly created:-
    //      $type_dash_key_list
    //
    // filling in the:-
    //      o   'ancestor_type_keys'
    //
    // fields of each element.
    // =========================================================================

    foreach ( $type_dash_key_list as $this_index => $this_data ) {

        // ---------------------------------------------------------------------

        if ( $this_data['parent_type'] === '' ) {
            continue ;
                //  This element has NO ancestors
        }

        // ---------------------------------------------------------------------
        // Here we should have (eg):-
        //
        //      $this_data = Array(
        //          [type]                  => section
        //          [key]                   => 537448fe851ae
        //          [parent_type]           => document
        //          [parent_key]            => 537448dbb3d11
        //          [primary_sort_value]    =>
        //          [secondary_sort_value]  => Chapter 1 #2
        //          [ancestor_type_keys]    =>
        //          )
        //
        // ---------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this_data ) ;

        // ---------------------------------------------------------------------

        $parent_type_key = $this_data['parent_type'] . '-' . $this_data['parent_key'] ;

        // ---------------------------------------------------------------------

        while ( TRUE ) {

            // -----------------------------------------------------------------

            if ( ! array_key_exists( $parent_type_key , $type_dash_key_list ) ) {

                // -------------------------------------------------------------

                $type_dash_key_list[ $this_index ]['parent_type'] = 'orphan' ;
                $type_dash_key_list[ $this_index ]['parent_key']  = '' ;

                break ;
                    //  Put orphaned records into an "orphans" type-key list.
                    //
                    //  This prevents the "Manage Dataset" screen from breaking
                    //  (and displaying nothing but an error message), should
                    //  an orphaned record be discovered.

                // -------------------------------------------------------------

                $ns = __NAMESPACE__ ;

                return <<<EOT
PROBLEM:&nbsp; Can't find parent element
Detected in:&nbsp; \\{$ns}\\create_type_key_tree()
EOT;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------

            $type_dash_key_list[ $this_index ]['ancestor_type_keys'][] = $parent_type_key ;

            // -----------------------------------------------------------------

            $ancestor_data = $type_dash_key_list[ $parent_type_key ] ;

            // -----------------------------------------------------------------

            if ( is_array( $ancestor_data['ancestor_type_keys'] ) ) {

                // -------------------------------------------------------------

                foreach ( $ancestor_data['ancestor_type_keys'] as $ancestor_type_key ) {
                    $type_dash_key_list[ $this_index ]['ancestor_type_keys'][] = $ancestor_type_key ;
                }

                // -------------------------------------------------------------

                break ;

                // -------------------------------------------------------------

            }

            // -----------------------------------------------------------------
            // Here we should have (eg):-
            //
            //      $type_dash_key_list[ $this_index ] = Array(
            //          [type]                  => section
            //          [key]                   => 537448fe851ae
            //          [parent_type]           => document
            //          [parent_key]            => 537448dbb3d11
            //          [primary_sort_value]    =>
            //          [secondary_sort_value]  => Chapter 1 #2
            //          [ancestor_type_keys]    => Array(
            //                                          [0] => document-537448dbb3d11
            //                                          )
            //          )
            //
            // -----------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_dash_key_list[ $this_index ] ) ;

            // -----------------------------------------------------------------

            if ( $ancestor_data['parent_type'] === '' ) {
                break ;
            }

            // -----------------------------------------------------------------

            $parent_type_key = $ancestor_data['parent_type'] . '-' . $ancestor_data['parent_key'] ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $type_dash_key_list = array(
    //
    //         [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [primary_sort_value]    => 10
    //              [ancestor_type_keys]    =>
    //              )
    //
    //          [section-5319171085fbc] => Array(
    //              [type]                  => section
    //              [key]                   => 5319171085fbc
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [secondary_sort_value]  => Intro 2
    //              [primary_sort_value]    => 10
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => document-531812f122157
    //                                              )
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [type]                  => section
    //              [key]                   => 53194283b436f
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [secondary_sort_value]  => Chapter 1
    //              [primary_sort_value]    => 20
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => document-531812f122157
    //                                              )
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [type]                  => section
    //              [key]                   => 5319791c35a4e
    //              [parent_type]           => section
    //              [parent_key]            => 53194283b436f
    //              [secondary_sort_value]  => Child of Chapter 1
    //              [primary_sort_value]    => 10
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => section-53194283b436f
    //                                              [1] => document-531812f122157
    //                                              )
    //              )
    //
    //          )
    //
    // NOTE that the "ancestor_type_keys" are ordered from bottom up.  In
    // other words:-
    //
    //      o   The most deeply nested ancestor (= the current element's parent
    //          - if it has one), comes FIRST.  and;
    //
    //      o   The topmost ancestor (which has NO parent), comes LAST.
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_dash_key_list ) ;

    // =========================================================================
    // Index the:-
    //      $type_dash_key_list
    //
    // elements by nesting depth (= number of ancestor elements)...
    //
    // And while doing this, add a:-
    //      'descendants'
    //
    // field to each list element.
    // =========================================================================

    $type_dash_keys_by_ancestor_count = array() ;

    // -------------------------------------------------------------------------

    foreach ( $type_dash_key_list as $this_type_key => $this_data ) {

        // =====================================================================
        // Add the current:-
        //      $type_dash_key_list
        //
        // element to the:-
        //      $type_dash_keys_by_ancestor_count
        //
        // array...
        // =====================================================================

        $number_ancestors = count( $this_data['ancestor_type_keys'] ) ;

        // ---------------------------------------------------------------------

        if ( array_key_exists( $number_ancestors , $type_dash_keys_by_ancestor_count ) ) {

            $type_dash_keys_by_ancestor_count[ $number_ancestors ][ $this_type_key ] =
                $this_data
                ;

        } else {

            $type_dash_keys_by_ancestor_count[ $number_ancestors ] = array(
                $this_type_key  => $this_data
                ) ;

        }

        // =====================================================================
        // Add the:-
        //      'descendants'
        //
        // field to the current:-
        //      $type_dash_key_list
        //
        // element...
        // =====================================================================

        $type_dash_key_list[ $this_type_key ]['descendants'] = array() ;

        // =====================================================================
        // Repeat with the next:-
        //      $type_dash_key_list
        //
        // element (if there is one)...
        // =====================================================================

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $type_dash_keys_by_ancestor_count = array(
    //
    //          [0] => Array(
    //
    //                      [document-531812f122157] => Array(
    //                                                      [type]                  => document
    //                                                      [key]                   => 531812f122157
    //                                                      [parent_type]           =>
    //                                                      [parent_key]            =>
    //                                                      [primary_sort_value]    => 10
    //                                                      [secondary_sort_value]  => Teaser Maker User Manual
    //                                                      [ancestor_type_keys]    =>
    //                                                      )
    //
    //                      )
    //
    //          [1] => Array(
    //
    //                      [section-5319171085fbc] => Array(
    //                                                      [type]                  => section
    //                                                      [key]                   => 5319171085fbc
    //                                                      [parent_type]           => document
    //                                                      [parent_key]            => 531812f122157
    //                                                      [primary_sort_value]    => 10
    //                                                      [secondary_sort_value]  => Intro 2
    //                                                      [ancestor_type_keys]    => Array(
    //                                                          [0] => document-531812f122157
    //                                                          )
    //                                                      )
    //
    //                      [section-53194283b436f] => Array(
    //                                                      [type]                  => section
    //                                                      [key]                   => 53194283b436f
    //                                                      [parent_type]           => document
    //                                                      [parent_key]            => 531812f122157
    //                                                      [primary_sort_value]    => 20
    //                                                      [secondary_sort_value]  => Chapter 1
    //                                                      [ancestor_type_keys]    => Array(
    //                                                          [0] => document-531812f122157
    //                                                          )
    //                                                      )
    //
    //                      )
    //
    //          [2] => Array(
    //
    //                      [section-5319791c35a4e] => Array(
    //                                                      [type]                  => section
    //                                                      [key]                   => 5319791c35a4e
    //                                                      [parent_type]           => section
    //                                                      [parent_key]            => 53194283b436f
    //                                                      [primary_sort_value]    => 10
    //                                                      [secondary_sort_value]  => Child of Chapter 1
    //                                                      [ancestor_type_keys]    => Array(
    //                                                          [0] => section-53194283b436f
    //                                                          [1] => document-531812f122157
    //                                                          )
    //                                                      )
    //
    //                      )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_dash_keys_by_ancestor_count ) ;

    // =========================================================================
    // Move each element in the:-
    //      $type_dash_key_list
    //
    // to the 'descendants' array of it's parent - copying the most deeply
    // nested elements first.
    // =========================================================================

    $deepest_ancestor_index = count( $type_dash_keys_by_ancestor_count ) - 1 ;

    // -------------------------------------------------------------------------

    $type_keys_to_unset = array() ;

    // -------------------------------------------------------------------------

    for ( $i = $deepest_ancestor_index ; $i > 0 ; $i-- ) {

        // ---------------------------------------------------------------------

        $elements_at_depth = $type_dash_keys_by_ancestor_count[ $i ] ;

        // ---------------------------------------------------------------------

        foreach ( $elements_at_depth as $this_type_key => $this_data ) {

            // -----------------------------------------------------------------

            $parent_type_key = $this_data['parent_type'] . '-' . $this_data['parent_key'] ;

            // -----------------------------------------------------------------

            $type_dash_key_list[ $parent_type_key ]['descendants'][ $this_type_key ] =
                $type_dash_key_list[ $this_type_key ]
                ;

            // -----------------------------------------------------------------

            $type_keys_to_unset[] = $this_type_key ;

            // -----------------------------------------------------------------

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $type_dash_key_list = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]           => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          [section-5319171085fbc] => Array(
    //              [type]                  => section
    //              [key]                   => 5319171085fbc
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Intro 2
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => document-531812f122157
    //                                              )
    //              [descendants]           => Array()
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [type]                  => section
    //              [key]                   => 53194283b436f
    //              [parent_type]           => document
    //              [parent_key]            => 531812f122157
    //              [primary_sort_value]    => 20
    //              [secondary_sort_value]  => Chapter 1
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => document-531812f122157
    //                                              )
    //              [descendants]           => Array(
    //
    //                  [section-5319791c35a4e] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319791c35a4e
    //                      [parent_type]           => section
    //                      [parent_key]            => 53194283b436f
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Child of Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => section-53194283b436f
    //                                                      [1] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [type]                  => section
    //              [key]                   => 5319791c35a4e
    //              [parent_type]           => section
    //              [parent_key]            => 53194283b436f
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Child of Chapter 1
    //              [ancestor_type_keys]    => Array(
    //                                              [0] => section-53194283b436f
    //                                              [1] => document-531812f122157
    //                                              )
    //              [descendants]           => Array()
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_dash_key_list ) ;

    // =========================================================================
    // Create the output:-
    //      $type_key_tree
    //
    // by:-
    //      o   Copying the finished:-
    //              $type_dash_key_list
    //
    //      o   And then deleting the:-
    //              $type_keys_to_unset
    //
    //          from it.
    // =========================================================================

    $type_key_tree = $type_dash_key_list ;

    // -------------------------------------------------------------------------

    foreach ( $type_keys_to_unset as $this_type_key ) {
        unset( $type_key_tree[ $this_type_key ] ) ;
    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $type_key_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_tree ) ;

    // =========================================================================
    // Create the output:-
    //      $ancestry_by_type_key
    //
    // list...
    // =========================================================================

    $ancestry_by_type_key = array() ;

    // -------------------------------------------------------------------------

    foreach ( $type_dash_key_list as $this_type_key => $this_data ) {

        // ---------------------------------------------------------------------

        if ( is_array( $this_data['ancestor_type_keys'] ) ) {

            $ancestry_by_type_key[ $this_type_key ] =
                array_reverse( $this_data['ancestor_type_keys'] )
                ;

        } else {

            $ancestry_by_type_key[ $this_type_key ] = array() ;

        }

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $ancestry_by_type_key = array(
    //
    //          [document-531812f122157] => Array()
    //
    //          [section-5319171085fbc] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $ancestry_by_type_key ) ;

    // =========================================================================
    // SORT each level in the tree...
    // =========================================================================

    // -------------------------------------------------------------------------
    // sort_type_key_tree_level(
    //      &$type_key_tree                     ,
    //      $level_to_sort_ancestry             ,
    //      $uasort_comparison_function_name
    //      ) {
    // - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    if ( count( $type_key_tree ) > 0 ) {

        // ---------------------------------------------------------------------

        $uasort_comparison_function_name =
            '\\' . __NAMESPACE__ . '\\compare_type_key_tree_level_items'
            ;

        // ---------------------------------------------------------------------

        $result = sort_type_key_tree_level(
                        $type_key_tree                      ,
                        $uasort_comparison_function_name
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // Return the finished:-
    //      o   $type_key_tree, and;
    //      o   $ancestry_by_type_key
    // =========================================================================

    return array(
                $type_key_tree          ,
                $ancestry_by_type_key
                ) ;

    // =========================================================================
    // That's that!
    // =========================================================================

}

// =============================================================================
// sort_type_key_tree_level()
// =============================================================================

function sort_type_key_tree_level(
    &$tree_level_to_sort                ,
    $uasort_comparison_function_name
    ) {

    // -------------------------------------------------------------------------
    // sort_type_key_tree_level(
    //      &$tree_level_to_sort                ,
    //      $uasort_comparison_function_name
    //      ) {
    // - - - - - - - - - - - - - - - - - - - - -
    // RETURNS
    //      o   On SUCCESS
    //              TRUE
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $tree_level_to_sort = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

    // =========================================================================
    // Sort the level's elements...
    // =========================================================================

    // -------------------------------------------------------------------------
    // bool uasort ( array &$array , callable $value_compare_func )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // This function sorts an array such that array indices maintain their
    // correlation with the array elements they are associated with, using a
    // user-defined comparison function.
    //
    // This is used mainly when sorting associative arrays where the actual
    // element order is significant.
    //
    // Note:    If two members compare as equal, their relative order in the
    //          sorted array is undefined.
    //
    //      array
    //          The input array.
    //
    //      value_compare_func
    //          See usort() and uksort() for examples of user-defined comparison
    //          functions.
    //
    // Returns TRUE on success or FALSE on failure.
    //
    // (PHP 4, PHP 5)
    // -------------------------------------------------------------------------

    $ok = uasort( $tree_level_to_sort , $uasort_comparison_function_name ) ;

    // -------------------------------------------------------------------------

    if ( $ok !== TRUE ) {

        $ns = __NAMESPACE__ ;

        return <<<EOT
PROBLEM:&nbsp; "uasort()" failure sorting type key tree
Detected in:&nbsp; \\{$ns}\\sort_type_key_tree_level()
EOT;

    }

    // =========================================================================
    // Then sort the descendants of those tree level elements that have
    // descendants...
    // =========================================================================

    foreach ( $tree_level_to_sort as $this_type_key => $this_data ) {

        // ---------------------------------------------------------------------

        if ( count( $this_data['descendants'] ) > 0 ) {

            // -----------------------------------------------------------------

            $result = sort_type_key_tree_level(
                            $tree_level_to_sort[ $this_type_key ]['descendants']    ,
                            $uasort_comparison_function_name
                            ) ;

            // -----------------------------------------------------------------

            if ( is_string( $result ) ) {
                return $result ;
            }

            // -----------------------------------------------------------------

        }

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
// compare_type_key_tree_level_items()
// =============================================================================

function compare_type_key_tree_level_items(
    $this       ,
    $that
    ) {

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $this = Array(
    //                  [type]                  => section
    //                  [key]                   => 53194283b436f
    //                  [parent_type]           => document
    //                  [parent_key]            => 531812f122157
    //                  [primary_sort_value]    => 20
    //                  [secondary_sort_value]  => Chapter 1
    //                  [ancestor_type_keys]    => Array(
    //                      [0] => document-531812f122157
    //                      )
    //                  [descendants]           => Array(...)
    //                  )
    //
    //      $that = Array(
    //                  [type]                  => section
    //                  [key]                   => 5319171085fbc
    //                  [parent_type]           => document
    //                  [parent_key]            => 531812f122157
    //                  [primary_sort_value]    => 10
    //                  [secondary_sort_value]  => Intro 2
    //                  [ancestor_type_keys]    => Array(
    //                      [0] => document-531812f122157
    //                      )
    //                  [descendants]           => Array()
    //                  )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $this ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $that ) ;

    // -------------------------------------------------------------------------
    // int strnatcasecmp ( string $str1 , string $str2 )
    // - - - - - - - - - - - - - - - - - - - - - - - - -
    // This function implements a comparison algorithm that orders alphanumeric
    // strings in the way a human being would. The behaviour of this function is
    // similar to strnatcmp(), except that the comparison is not case sensitive.
    // For more information see: Martin Pool's » Natural Order String
    // Comparison page.
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

    if ( $this['primary_sort_value'] == $that['primary_sort_value'] ) {
        return strnatcasecmp( $this['secondary_sort_value'] , $that['secondary_sort_value'] ) ;
    }

    // -------------------------------------------------------------------------

    return strnatcasecmp( $this['primary_sort_value'] , $that['primary_sort_value'] ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_node_in_type_key_tree()
// =============================================================================

function get_node_in_type_key_tree(
    $type_key_tree              ,
    $ancestry_by_type_key       ,
    $type_key = NULL            ,
    $type     = NULL            ,
    $key      = NULL
    ) {

    // -------------------------------------------------------------------------
    // get_node_in_type_key_tree(
    //      $type_key_tree              ,
    //      $ancestry_by_type_key       ,
    //      $type_key = NULL            ,
    //      $type     = NULL            ,
    //      $key      = NULL
    //      )
    // - - - - - - - - - - - - - - - - -
    // Returns the specified node of the specified $type_key_tree.
    //
    // The node can be specified by either:-
    //      $type_key
    //
    // and/or:-
    //      $type
    //      $key
    //
    // ---
    //
    // Either:-
    //      $type_key
    //
    // should be specified.  Eg:-
    //      $type_key = "document-531812f122157"
    //
    // (In which case, $type and $key, if specified, must match.)
    //
    // ---
    //
    // And/or:-
    //      $type, and;
    //      $key
    //
    // can be specified.  Eg:-
    //      $type = "document"
    //      $key  = "531812f122157"
    //
    // (In which case, $type_$key, if specified, must match.)
    //
    // ---
    //
    // $type_key_tree and $ancestry_by_type_key are as returned by:-
    //      create_type_key_tree()
    //
    // ---
    //
    // The returned $node is like (eg):-
    //
    //      $node = Array(
    //          [type]                  => section
    //          [key]                   => 53194283b436f
    //          [parent_type]           => document
    //          [parent_key]            => 531812f122157
    //          [primary_sort_value]    => 20
    //          [secondary_sort_value]  => Chapter 1
    //          [ancestor_type_keys]    => Array(
    //                                          [0] => document-531812f122157
    //                                          )
    //          [descendants]           => Array(
    //
    //              [section-5319791c35a4e] => Array(
    //                  [type]                  => section
    //                  [key]                   => 5319791c35a4e
    //                  [parent_type]           => section
    //                  [parent_key]            => 53194283b436f
    //                  [primary_sort_value]    => 10
    //                  [secondary_sort_value]  => Child of Chapter 1
    //                  [ancestor_type_keys]    => Array(
    //                                                  [0] => section-53194283b436f
    //                                                  [1] => document-531812f122157
    //                                                  )
    //                  [descendants]               => Array()
    //                  )
    //
    //              )
    //
    //          )
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS
    //              --  $node ARRAY - if specified sub-tree found
    //              --  FALSE - if specified sub-tree NOT found
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    // =========================================================================
    // Init.
    // =========================================================================

    $fn = __FUNCTION__ ;

    $ns = __NAMESPACE__ ;

    // =========================================================================
    // Error Checking...
    // =========================================================================

    if (    is_string( $type_key )
            &&
            trim( $type_key ) !== ''
        ) {
        $type_key_1 = $type_key ;

    } else {
        $type_key_1 = '' ;

    }

    // -------------------------------------------------------------------------

    if (    is_string( $type )
            &&
            trim( $type ) !== ''
            &&
            is_string( $key )
            &&
            trim( $key ) !== ''
        ) {
        $type_key_2 = $type . '-' . $key ;

    } else {
        $type_key_2 = '' ;

    }

    // -------------------------------------------------------------------------

    if (    $type_key_1 === ''
            &&
            $type_key_2 === ''
        ) {

        return <<<EOT
PROBLEM:&nbsp; No valid "type_key" or "type" + "key" (to identify the sub-tree required)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if (    $type_key_1 !== ''
            &&
            $type_key_2 !== ''
            &&
            $type_key_1 !== $type_key_2
        ) {

        return <<<EOT
PROBLEM:&nbsp; "type_key" and "type" + "key" mismatch
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    }

    // -------------------------------------------------------------------------

    if ( $type_key_1 !== '' ) {
        $target_type_key = $type_key_1 ;

    } else {
        $target_type_key = $type_key_2 ;

    }

    // -------------------------------------------------------------------------

    if ( ! array_key_exists( $target_type_key , $ancestry_by_type_key ) ) {
        return FALSE ;
    }

    // =========================================================================
    // Get the requested sub-tree
    // =========================================================================

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $type_key_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_tree ) ;

    // -------------------------------------------------------------------------
    // Here we should have (eg):-
    //
    //      $ancestry_by_type_key = array(
    //
    //          [document-531812f122157] => Array()
    //
    //          [section-5319171085fbc] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-53194283b436f] => Array(
    //              [0] => document-531812f122157
    //              )
    //
    //          [section-5319791c35a4e] => Array(
    //              [0] => document-531812f122157
    //              [1] => section-53194283b436f
    //              )
    //
    //          )
    //
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $ancestry_by_type_key ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $target_type_key ) ;

    // -------------------------------------------------------------------------

//  if ( array_key_exists( $target_type_key , $type_key_tree ) ) {
//      return $type_key_tree[ $target_type_key ] ;
//  }

    // -------------------------------------------------------------------------

    $node = $type_key_tree ;

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $ancestry_by_type_key ) ;

    foreach ( $ancestry_by_type_key[ $target_type_key ] as $this_ancestor_type_key ) {

        // ---------------------------------------------------------------------

        if ( ! array_key_exists( $this_ancestor_type_key , $node ) ) {

            return <<<EOT
PROBLEM:&nbsp; Mismatched "type_key_tree" and "ancestry_by_type_key"
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

        }

        // ---------------------------------------------------------------------

        if ( $this_ancestor_type_key === $target_type_key ) {
            return $node ;
        }

        // ---------------------------------------------------------------------

        $node = $node[ $this_ancestor_type_key ]['descendants'] ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

    if ( array_key_exists( $target_type_key , $node ) ) {
        return $node[ $target_type_key ] ;
    }

    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $node ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_tree ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $ancestry_by_type_key ) ;

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $target_type_key ) ;

    return <<<EOT
PROBLEM:&nbsp; Bad "type_key_tree" and "ancestry_by_type_key" (requested node not found)
Detected in:&nbsp; \\{$ns}\\{$fn}()
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_parent_node_in_type_key_tree()
// =============================================================================

function get_parent_node_in_type_key_tree(
    $type_key_tree              ,
    $ancestry_by_type_key       ,
    $type_key = NULL            ,
    $type     = NULL            ,
    $key      = NULL
    ) {

    // -------------------------------------------------------------------------
    // get_parent_node_in_type_key_tree(
    //      $type_key_tree              ,
    //      $ancestry_by_type_key       ,
    //      $type_key = NULL            ,
    //      $type     = NULL            ,
    //      $key      = NULL
    //      )
    // - - - - - - - - - - - - - - - - -
    // Returns the parent node of the specified node in the $type_key_tree.
    //
    // The node (whoose parent is required) can be specified by either:-
    //      $type_key
    //
    // and/or:-
    //      $type
    //      $key
    //
    // ---
    //
    // Either:-
    //      $type_key
    //
    // should be specified.  Eg:-
    //      $type_key = "document-531812f122157"
    //
    // (In which case, $type and $key, if specified, must match.)
    //
    // ---
    //
    // And/or:-
    //      $type, and;
    //      $key
    //
    // can be specified.  Eg:-
    //      $type = "document"
    //      $key  = "531812f122157"
    //
    // (In which case, $type_$key, if specified, must match.)
    //
    // ---
    //
    // $type_key_tree and $ancestry_by_type_key are as returned by:-
    //      create_type_key_tree()
    //
    // ---
    //
    // The returned $parent_node is like (eg):-
    //
    //      $node = Array(
    //          [type]                  => section
    //          [key]                   => 53194283b436f
    //          [parent_type]           => document
    //          [parent_key]            => 531812f122157
    //          [primary_sort_value]    => 20
    //          [secondary_sort_value]  => Chapter 1
    //          [ancestor_type_keys]    => Array(
    //                                          [0] => document-531812f122157
    //                                          )
    //          [descendants]           => Array(
    //
    //              [section-5319791c35a4e] => Array(
    //                  [type]                  => section
    //                  [key]                   => 5319791c35a4e
    //                  [parent_type]           => section
    //                  [parent_key]            => 53194283b436f
    //                  [primary_sort_value]    => 10
    //                  [secondary_sort_value]  => Child of Chapter 1
    //                  [ancestor_type_keys]    => Array(
    //                                                  [0] => section-53194283b436f
    //                                                  [1] => document-531812f122157
    //                                                  )
    //                  [descendants]               => Array()
    //                  )
    //
    //              )
    //
    //          )
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS
    //              --  $parent_node ARRAY - if specified node's parent node
    //                  found
    //              --  FALSE - if specified parent node NOT found
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

    $result = get_node_in_type_key_tree(
                    $type_key_tree              ,
                    $ancestry_by_type_key       ,
                    $type_key                   ,
                    $type                       ,
                    $key
                    ) ;

    // -------------------------------------------------------------------------

    if ( ! is_array( $result ) ) {
        return $result ;
    }

    // -------------------------------------------------------------------------

    $type_key = NULL ;

    // -------------------------------------------------------------------------

    $type = $result['parent_type'] ;
    $key  = $result['parent_key']  ;

    // -------------------------------------------------------------------------

    return get_node_in_type_key_tree(
                $type_key_tree              ,
                $ancestry_by_type_key       ,
                $type_key                   ,
                $type                       ,
                $key
                ) ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// get_type_keys_in_sub_tree()
// =============================================================================

function get_type_keys_in_sub_tree(
    $sub_tree
    ) {

    // -------------------------------------------------------------------------
    // get_type_keys_in_sub_tree(
    //      $sub_tree
    //      )
    // - - - - - - - - - - - - -
    // The $sub_tree is like (eg):-
    //
    //      $sub_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          )
    //
    // NOTE!
    // -----
    // Actually, the $sub_tree can be the complete tree, or any sub_tree of it
    // (including an empty sub-tree = node with NO descendants).
    //
    // ---
    //
    // RETURNS
    //      o   On SUCCESS
    //              ARRAY(
    //                  $type_key_1
    //                  ...
    //                  $type_key_N
    //                  )
    //
    //      o   On FAILURE
    //              $error_message STRING
    // -------------------------------------------------------------------------

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $ancestry_by_type_key ) ;

    // -------------------------------------------------------------------------

    $type_keys_in_sub_tree = array() ;

    // -------------------------------------------------------------------------

    _get_type_keys_in_sub_tree(
            $sub_tree                   ,
            $type_keys_in_sub_tree
            ) ;

    // -------------------------------------------------------------------------

    return $type_keys_in_sub_tree ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// _get_type_keys_in_sub_tree(
// =============================================================================

function _get_type_keys_in_sub_tree(
    $sub_tree                   ,
    &$type_keys_in_sub_tree
    ) {

    // -------------------------------------------------------------------------

    foreach ( $sub_tree as $this_type_key => $this_type_key_data ) {

        // ---------------------------------------------------------------------

        if ( $this_type_key !== '' ) {
            $type_keys_in_sub_tree[] = $this_type_key ;
        }

        // ---------------------------------------------------------------------

        _get_type_keys_in_sub_tree(
            $sub_tree['descendants']    ,
            $type_keys_in_sub_tree
            ) ;

        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// walk_type_key_tree()
// =============================================================================

function walk_type_key_tree(
    $type_key_tree              ,
    $function_name              ,
    &$extra_args = array()
    ) {

    // -------------------------------------------------------------------------
    // walk_type_key_tree(
    //      $type_key_tree              ,
    //      $function_name              ,
    //      &$extra_args = array()
    //      )
    // - - - - - - - - - - - - - - - - -
    // The $type_key_tree is like (eg):-
    //
    //      $type_key_tree = array(
    //
    //          [document-531812f122157] => Array(
    //              [type]                  => document
    //              [key]                   => 531812f122157
    //              [parent_type]           =>
    //              [parent_key]            =>
    //              [primary_sort_value]    => 10
    //              [secondary_sort_value]  => Teaser Maker User Manual
    //              [ancestor_type_keys]    =>
    //              [descendants]           => Array(
    //
    //                  [section-5319171085fbc] => Array(
    //                      [type]                  => section
    //                      [key]                   => 5319171085fbc
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 10
    //                      [secondary_sort_value]  => Intro 2
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array()
    //                      )
    //
    //                  [section-53194283b436f] => Array(
    //                      [type]                  => section
    //                      [key]                   => 53194283b436f
    //                      [parent_type]           => document
    //                      [parent_key]            => 531812f122157
    //                      [primary_sort_value]    => 20
    //                      [secondary_sort_value]  => Chapter 1
    //                      [ancestor_type_keys]    => Array(
    //                                                      [0] => document-531812f122157
    //                                                      )
    //                      [descendants]           => Array(
    //
    //                          [section-5319791c35a4e] => Array(
    //                              [type]                  => section
    //                              [key]                   => 5319791c35a4e
    //                              [parent_type]           => section
    //                              [parent_key]            => 53194283b436f
    //                              [primary_sort_value]    => 10
    //                              [secondary_sort_value]  => Child of Chapter 1
    //                              [ancestor_type_keys]    => Array(
    //                                                              [0] => section-53194283b436f
    //                                                              [1] => document-531812f122157
    //                                                              )
    //                              [descendants]               => Array()
    //                              )
    //
    //                          )
    //
    //                      )
    //
    //                  )
    //
    //              )
    //
    //          )
    //
    // NOTES!
    // -----
    // 1.   Actually, the tree to be walked can be the complete tree, or any
    //      sub_tree of it (including an empty sub-tree = node with NO
    //      descendants).
    //
    // 2.   Use $extra_args to hold any variables you want to supply to or
    //      have updated by the node function.
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

//\greatKiwi_byFernTec_teaserMaker_std_v0x1x114_testDebug\pr( $type_key_tree ) ;

    // -------------------------------------------------------------------------

    foreach ( $type_key_tree as $this_type_key => $this_type_key_data ) {

        // ---------------------------------------------------------------------
        // Call the node function...
        // ---------------------------------------------------------------------

        // -------------------------------------------------------------------------
        // <my_node_function>(
        //      $this_type_key          ,
        //      $this_type_key_data     ,
        //      $extra_args
        //      )
        // - - - - - - - - - - - - - - -
        // RETURNS
        //      o   On SUCCESS
        //              TRUE
        //
        //      o   On FAILURE
        //              $error_message STRING
        // -------------------------------------------------------------------------

        $result = $function_name(
                        $this_type_key          ,
                        $this_type_key_data     ,
                        $extra_args
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------
        // Recurse with any sub-nodes...
        // ---------------------------------------------------------------------

        $result = walk_type_key_tree(
                        $type_key_tree['decendants']    ,
                        $function_name                  ,
                        $extra_args
                        ) ;

        // ---------------------------------------------------------------------

        if ( is_string( $result ) ) {
            return $result ;
        }

        // ---------------------------------------------------------------------
        // Repeat with the next mode at this level (if there is one)...
        // ---------------------------------------------------------------------

    }

    // -------------------------------------------------------------------------
    // SUCCESS!
    // -------------------------------------------------------------------------

    return TRUE ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// explode_type_key()
// =============================================================================

function explode_type_key(
    $type_key
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_standardDatasetManager\
    // explode_type_key(
    //      $type_key
    //      )
    // - - - - - - - - -
    // Separates an "type key" like (eg):-
    //      "document-e5dab930-4504-4fef-98d4-fff1b4dd7249-1400645620-97543-34"
    //
    // into it's "type" and "key" components.  Eg:-
    //      $type_key_type = "document"
    //      $type_key_key  = "e5dab930-4504-4fef-98d4-fff1b4dd7249-1400645620-97543-34"
    //
    // RETURNS
    //      ARRAY(
    //          $type_key_type      ,
    //          $type_key_key
    //          )
    // -------------------------------------------------------------------------

    $parts = explode( '-' , $type_key ) ;

    // ---------------------------------------------------------------------

    $type = $parts[0] ;

    // ---------------------------------------------------------------------

    unset( $parts[0] ) ;

    $key = implode( '-' , $parts ) ;

    // ---------------------------------------------------------------------

    return array(
                $type   ,
                $key
                ) ;

    // ---------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================


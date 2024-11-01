
    // =========================================================================
    // get_ancestor()
    // =========================================================================

    function greatKiwi_datasetManager_get_ancestor( start_el , like ) {

        // -----------------------------------------------------------------------
        // greatKiwi_datasetManager_get_ancestor( start_el , like )
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // "like" is an object (associative array) like:-
        //
        //      {   tagName                 :   "xxx"
        //          class                   :   "xxx"
        //          id                      :   "xxx"
        //          <property_name_1>       :   <property_value_1>
        //          ...
        //          <property_name_N>       :   <property_value_N>
        //          }
        //
        // All the name = value pairs are optional.  Just specify what you need
        // to identify the ancestor that you're looking for.
        //
        // Returns false if no such ancestor found.
        // -----------------------------------------------------------------------

        var current_el = start_el.parentNode ;

        var all_properties_match ;

        while ( current_el !== document ) {

            all_properties_match = true ;

            for ( name in like ) {

                if ( name === 'tagName' ) {

                    if ( ! current_el[ name ] === undefined || current_el[ name ].toUpperCase() !== like[ name ].toUpperCase() ) {
                        all_properties_match = false ;
                        break ;
                    }

                } else {

                    if ( ! current_el[ name ] === undefined || current_el[ name ] !== like[ name ] ) {
                        all_properties_match = false ;
                        break ;
                    }

                }

            }

            if ( all_properties_match ) {
                return current_el ;
            }

            current_el = current_el.parentNode ;

        }

        return false ;

    }

    // =========================================================================
    // in_list()
    // =========================================================================

    function greatKiwi_datasetManager_in_list( list , string_or_number , exact ) {

        //  ------------------------------------------------------------------
        //  greatKiwi_datasetManager_in_list( list , string_or_number , exact )
        //  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        //  Check if the specified element is in the specified list.  Where
        //  by list we mean a list of numbers and/or strings.  Eg:-
        //      mylist = [ 1 , 2 , 3 ... ]
        //      mylist = [ 'one' , 'two' , 'three' ... ]
        //      mylist = [ 'one' , 2 , 'three' ... ]
        //
        //  "exact" defaults to false.
        //
        //  Returns true or false.
        //  ------------------------------------------------------------------

        if ( ! exact ) {
            var exact = false ;
        }

        var i , j=list.length ;

        if ( exact ) {

            for ( i=0 ; i<j ; i++ ) {

                if ( list[i] === string_or_number ) {
                    return true ;
                }

            }

        } else {

            for ( i=0 ; i<j ; i++ ) {

                if ( list[i] == string_or_number ) {
                    return true ;
                }

            }

        }

        return false ;

    }

    // =========================================================================
    // toCamelCase()
    // =========================================================================

    //  From: http://jamesroberts.name/blog/2010/02/22/string-functions-for-javascript-trim-to-camel-case-to-dashed-and-to-underscore/
    function greatKiwi_datasetManager_toCamelCase( instr ) {
	    return instr.replace( /(\-[a-z])/g , function($1){return $1.toUpperCase().replace('-','')} ) ;
    }

    // =========================================================================
    // setStyles()
    // =========================================================================

    function greatKiwi_datasetManager_setStyles( el , styles ) {

        // ---------------------------------------------------------------------
        //  "styles" is an object of name = value pairs.  Eg:-
        //      styles = {
        //          font-weight :   'bold'      ,
        //          font-size   :   '110%'
        //          }
        // ---------------------------------------------------------------------

        for ( var name in styles ) {
            el.style[ greatKiwi_datasetManager_toCamelCase( name ) ] = styles[ name ] ;
        }

        // ---------------------------------------------------------------------

    }

    // =========================================================================
    // That's that!
    // =========================================================================


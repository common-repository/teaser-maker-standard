
// =============================================================================
// question_delete_record_proper()
// =============================================================================

function greatKiwi_datasetManager_question_delete_record_proper(
    a_el                    ,
    dataset_slug            ,
    record_key              ,
    question_front_end      ,
    base_href
    ) {

    // -------------------------------------------------------------------------
    // greatKiwi_datasetManager_question_delete_record_proper(
    //      a_el                    ,
    //      dataset_slug            ,
    //      record_key              ,
    //      question_front_end      ,
    //      base_href
    //      )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Pops up a "DELETE this record, ARE YOU SURE?" box - and calls the
    // specified "base_href" to selected the specified record if the user
    // answers Yes.
    //
    // "base_href" is like (eg):-
    //      http://www.thissite.com/[XXX]&dataset_slug=_DATASET_SLUG_GOES_HERE_[&YYY]&record_key=_RECORD_KEY_GOES_HERE_[&ZZZ]
    // -------------------------------------------------------------------------

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

    var like = { tagName : 'tr' } ;

    var tr_el = greatKiwi_datasetManager_get_ancestor( a_el , like ) ;

    var old_bg = tr_el.style.backgroundColor ;

    tr_el.style.backgroundColor = '#FFFF00' ;

    var msg = 'DELETE the highlit record?\\n\\nARE YOU SURE?' ;

    var yesno = confirm( msg ) ;

    tr_el.style.backgroundColor = old_bg ;

    // -------------------------------------------------------------------------
    // replace( regexp, replacement)
    // - - - - - - - - - - - - - - -
    // Replaces portions of a string based on the entered regexp object and
    // replacement text, then returns the new string. The replacement parameter
    // can either be a string or a callback function. Example:
    //
    //      var oldstring="(304)434-5454"
    //      newstring=oldstring.replace(/[\(\)-]/g, "") //returns "3044345454" (removes "(", ")", and "-")
    //
    // Inside the replacement text, the following characters carry special
    // meaning:
    //
    //      $1,$2,$3, etc:  References the submatched substrings inside
    //                      parenthesized expressions within the regular
    //                      expression. With it you can capture the result of a
    //                      match and use it within the replacement text.
    //
    //      $&:             References the entire substring that matched the
    //                      regular expression
    //
    //      $`:             References the text that proceeds the matched
    //                      substring
    //
    //      $':             References the text that follows the matched
    //                      substring
    //
    //      $$:             A literal dollar sign
    //
    // Example:
    //
    //      //returns "Mary Johnson is our mother":
    //      "Mary is our mother".replace(/(Mary)/g, "$1 Johnson")
    // -------------------------------------------------------------------------

    base_href = base_href.replace( /_DATASET_SLUG_GOES_HERE_/ , dataset_slug ) ;

    base_href = base_href.replace( /_RECORD_KEY_GOES_HERE_/ , record_key ) ;

    // -------------------------------------------------------------------------

    if ( yesno ) {

        if ( question_front_end ) {
            window.parent.location.href = base_href ;

        } else {
            location.href = base_href ;

        }

    }

    // -------------------------------------------------------------------------

}

// =============================================================================
// Thats' that!
// =============================================================================


<?php

// *****************************************************************************
// INCLUDES / CSS-UTILS.PHP
// (C) 2014 Peter Newman. All Rights Reserved
// *****************************************************************************

    namespace greatKiwi_byFernTec_teaserMaker_std_v0x1x114_cssUtils ;

// =============================================================================
// styles_array_2_style_string_value()
// =============================================================================

function styles_array_2_style_string_value(
    $styles_array
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_cssUtils\
    //      styles_array_2_style_string_value(
    //          $styles_array
    //          )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Converts a "styles array" like (eg):-
    //
    //      $my_styles = array(
    //          'font-weight'   =>  'bold'      ,
    //          'color'         =>  '#FFFFFF'
    //          )
    //
    // to a string like (eg):-
    //      'font-weight:bold; color:#FFFFFF'
    //
    // (WITHOUT the surrounding single quotes)
    // -------------------------------------------------------------------------

    $out = '' ;
    $comma = '' ;

    foreach ( $styles_array as $name => $value ) {
        $out .= $comma . $name . ':' . $value ;
        $comma = '; ' ;
    }

    return $out ;

    // -------------------------------------------------------------------------

}

// =============================================================================
// styles_array_2_style_equals_value_string()
// =============================================================================

function styles_array_2_style_equals_value_string(
    $styles_array
    ) {

    // -------------------------------------------------------------------------
    // \greatKiwi_byFernTec_teaserMaker_std_v0x1x114_cssUtils\
    //      styles_array_2_style_equals_value_string(
    //          $styles_array
    //          )
    // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // Converts a "styles array" like (eg):-
    //
    //      $my_styles = array(
    //          'font-weight'   =>  'bold'      ,
    //          'color'         =>  '#FFFFFF'
    //          )
    //
    // to a string like (eg):-
    //      'style="font-weight:bold; color:#FFFFFF"'
    //
    // (WITHOUT the surrounding single quotes)
    //
    // NOTE!    If the $styles_array is EMPTY, the EMPTY string will be
    //          returned (instead of 'style=""').
    // -------------------------------------------------------------------------

    $value = styles_array_2_style_string_value( $styles_array ) ;

    if ( $value === '' ) {
        return '' ;
    }

    return <<<EOT
style="{$value}"
EOT;

    // -------------------------------------------------------------------------

}

// =============================================================================
// That's that!
// =============================================================================


<?php

// *****************************************************************************
// INCLUDES / HTML-SHORTCUTS.PHP
// (C) 2013 Peter Newman. All Rights Reserved
// *****************************************************************************

// =============================================================================
// br()
// hr()
// p()
// pre()
// h1()
// h2()
// h3()
// b()
// i()
// =============================================================================

    if ( ! function_exists( 'br' ) ) {
        function br() {
            echo '<br />' ;
        }
    }

    if ( ! function_exists( 'hr' ) ) {
        function hr() {
            echo '<hr />' ;
        }
    }

    if ( ! function_exists( 'p' ) ) {
        function p( $content ) {
            echo '<p>' , $content , '</p>' ;
        }
    }

    if ( ! function_exists( 'pre' ) ) {
        function pre( $content ) {
            echo '<pre>' , $content , '</pre>' ;
        }
    }

    if ( ! function_exists( 'h1' ) ) {
        function h1( $content ) {
            echo '<h1>' , $content , '</h1>' ;
        }
    }

    if ( ! function_exists( 'h2' ) ) {
        function h2( $content ) {
            echo '<h2>' , $content , '</h2>' ;
        }
    }

    if ( ! function_exists( 'h3' ) ) {
        function h3( $content ) {
            echo '<h3>' , $content , '</h3>' ;
        }
    }

    if ( ! function_exists( 'b' ) ) {
        function b( $content ) {
            echo '<b>' , $content , '</b>' ;
        }
    }

    if ( ! function_exists( 'i' ) ) {
        function i( $content ) {
            echo '<i>' , $content , '</i>' ;
        }
    }

// =============================================================================
// dbt()
// =============================================================================

//  if ( ! function_exists( 'dbt' ) ) {
//      function dbt() {
//          echo '<pre>' ;
//          debug_print_backtrace() ;
//          echo '</pre>' ;
//      }
//  }

// =============================================================================
// That's that!
// =============================================================================


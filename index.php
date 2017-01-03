<?php
/**
 * Plugin Name: ALT LAB - FI Bootstrap Accordion Plugin
 * Plugin URI: https://github.com/woodwardtw/
 * Description: lets you link to expand divs using the id attribute in Bootstrap-based themes 
 * Version: 1.7
 * Author: Tom Woodward
 * Author URI: http://bionicteaching.com
 * License: GPL2
 */
 
 /*   2016 Tom  (email : bionicteaching@gmail.com)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


//gets rid of extra line breaks
add_action('init','remove_wpautop',201);

function remove_wpautop() {
    remove_filter ('acf_the_content', 'wpautop');
    remove_filter( 'the_content', 'wpautop' );

}  

function bsfi_enqueue_scripts() {
    wp_enqueue_style( 'fiStyles', plugins_url( '/css/bsexpand.css', __FILE__ ),array(), '1.0.0', false  ); 
    wp_enqueue_script( 'script-name', plugins_url('/js/base.js', __FILE__ ),array(), '1.0.0', true );

}
add_action( 'wp_enqueue_scripts', 'bsfi_enqueue_scripts' );



//basic shell construction
function bsc_topic( $atts, $content = null ) {    
    extract(shortcode_atts( array(
         'title' => '', //topic title should be unique
    ), $atts));
    $clean_title = strtolower(urlencode($title));
    $clean_title =preg_replace('/[^a-z0-9]+/i', '_', $title);
    $html = '<h3>' . $title  . '</h3>';
    $html .= '<div class="container" id="fi-cite">';
    $html .= '<div class="panel-group" id="' . $clean_title . '" role="tablist" aria-multiselectable="true">';
    $html .= do_shortcode($content);
    $html .=  '</div></div>';

    return  $html;
}

add_shortcode( 'topic', 'bsc_topic' );


//each item
function bsc_item( $atts, $content = null ) {  
    global $post; 
    $url = get_permalink($post);
    extract(shortcode_atts( array(
             'title' => '', //item title should be unique           
        ), $atts));   
    $clean_title = strtolower(urlencode($title));
    $clean_title =preg_replace('/[^a-z0-9]+/i', '_', $clean_title);
    $html = '<div class="panel panel-default">';
    $html .= '<div class="panel-heading" role="tab" id="head'.$clean_title.'">';
    $html .= '<h4 class="panel-title">';
    $html .= '<a role="button" data-toggle="collapse" href="#' . $clean_title . '" aria-expanded="true" aria-controls="'.$clean_title.'">';
    $html .= '<i class="more-less glyphicon glyphicon-plus"></i>';
    $html .= $title . '</a>'; //make a clean title vs regular title 
    $html .= '<a class= "stayinline" href="mailto:?&subject=Information%20about%20'.$title.'&body='.$url.'#'.$clean_title.'"><i class="glyphicon glyphicon-envelope bs-mail"></i></a></h4></div>'; //revisit link to get site URL 
    $html .='<div id="'.$clean_title.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">';
    $html .= '<div class="panel-body">';
    $html .= do_shortcode($content) . '</div></div></div>';


    return  $html;
}

add_shortcode( 'item', 'bsc_item' );



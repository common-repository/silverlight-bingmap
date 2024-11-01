<?php
/*
 * Plugin Name: Silverlight Bing Maps
 * Description: Embeds Bing Maps into page or post using Silverlight
 * Version: 1.0
 * Author: Alain Diart for les-sushi-codeurs.fr &amp; Eric Ambrosi for regart.net
 *
 * @package    sl-bingmaps
 * @subpackage wordpress plugin
 * @version    SVN: $Id: sl-bingmaps.php 14 2010-05-12 14:05:29Z sushicodeur $
 *
 */

// Définition des constantes
define ('BINGMAPS_ACTIVATION_URL', 'http://www.bingmapsportal.com/');
define ('BINGMAPS_URL', WP_PLUGIN_URL . '/sl-bingmaps' );
define ('BINGMAPS_ABSPATH', str_replace('\\', '/', WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__))));


load_plugin_textdomain( 'sl-bingmaps', dirname(__FILE__) . '/languages/', 'sl-bingmaps/languages/' );


// Gère les options du plugin
require_once(BINGMAPS_ABSPATH.'/functions.php');
require_once(BINGMAPS_ABSPATH.'/admin/plugin-options-controller.php');

/**
 * Ajoute l'entrée de menu dans l'admin WordPress pour la page d'option du plugin
 * @return unknown_type
 */
function sl_bingmaps_add_plugin_options() {
  add_options_page(__('Silverlight Bing Maps', 'sl-bingmaps'), __('Silverlight Bing Maps', 'sl-bingmaps'), 'administrator', basename(__FILE__), 'sl_bingmaps_plugin_options');
}

/**
 * Ajoute un message d'info si la clé Bing Maps n'a pas été renseignée
 * @return unknown_type
 */
function sl_bingmaps_add_activation_message() {
  if (!sl_bingmaps_is_activated()) echo '<div id="message" class="updated fade"><p><strong>'. __('Vous devrez obtenir un clé d\'activation Bing Maps avant de pouvoir utiliser le plugin sl-bingmaps.', 'sl-bingmaps') .'</strong></p></div>';
}

/**
 * Affiche la page d'option du plugin
 * @return unknown_type
 */
function sl_bingmaps_plugin_options() {
  require_once(BINGMAPS_ABSPATH.'/admin/plugin-options-form.php');
}

/**
 * Ajoute le bouton au dessus de l'éditeur pour ouvrir la popup d'ajout de shortcode
 * @return unknown_type
 */
function sl_bingmaps_add_media_button() {
  $iframe_href = BINGMAPS_URL.'/admin/post-iframe.php';
  $image_src = BINGMAPS_URL.'/images/media-button-sl-bingmaps.gif';
  $image_title = __('Insérer Silverlight Bing Maps', 'sl-bingmaps');
  echo '<a href="'. $iframe_href .'?TB_iframe=true" id="add_sl_bingmaps" class="thickbox" title="'. $image_title .'" onclick="return false;"><img src="'. $image_src .'" alt="'. $image_title .'" /></a>';
}

/**
 * Gère le shortcode
 * @param $atts
 * @return unknown_type
 */
function sl_bingmaps_shortcode($atts) {
  // Combine les valeurs par défaut et celles du shortcode
  $atts = shortcode_atts(sl_bingmaps_default_vars(), $atts);
  // Retourne la sortie HTML
  return sl_bingmaps_do_shortcode($atts);
}


// Ajoute les actions du plugin
if (is_admin()) {
  add_action('admin_menu', 'sl_bingmaps_add_plugin_options');
  add_action('admin_head', 'sl_bingmaps_add_activation_message');
  add_action('media_buttons', 'sl_bingmaps_add_media_button', 20);
}
add_shortcode('sl-bingmaps', 'sl_bingmaps_shortcode');

wp_register_script( 'silverlight_js', BINGMAPS_URL . '/js/silverlight.js' );
wp_enqueue_script( 'silverlight_js' );
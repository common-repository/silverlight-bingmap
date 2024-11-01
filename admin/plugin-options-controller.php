<?php
/*
 * Silverlight Bing Maps
 * Gestion des options du plugin
 *
 * @package    sl-bingmaps
 * @subpackage wordpress plugin
 * @version    SVN: $Id: plugin-options-controller.php 13 2010-05-12 13:58:19Z sushicodeur $
 *
 */

  // Initialise les options du plugin
  if (get_option('sl-bingmaps-CredentialsProvider') == null)
    add_option('sl-bingmaps-CredentialsProvider', '');
  if (get_option('sl-bingmaps-background') == null)
    add_option('sl-bingmaps-background', 'transparent');
  if (get_option('sl-bingmaps-width') == null)
    add_option('sl-bingmaps-width', '100%');
  if (get_option('sl-bingmaps-height') == null)
    add_option('sl-bingmaps-height', '400px');

  // Initialise les variables dynamiques
  sl_bingmaps_init_vars();


  // Met à jour les options
  if ($_REQUEST['sl-bingmaps-action'] == 'save_options') {

    // Met à jour les options du plugin
    update_option('sl-bingmaps-CredentialsProvider', $_REQUEST['sl-bingmaps-CredentialsProvider']);
    update_option('sl-bingmaps-background', $_REQUEST['sl-bingmaps-background']);
    update_option('sl-bingmaps-width', $_REQUEST['sl-bingmaps-width']);
    update_option('sl-bingmaps-height', $_REQUEST['sl-bingmaps-height']);
    // Met à jour les variables dynamiques
    sl_bingmaps_update_vars();

  }
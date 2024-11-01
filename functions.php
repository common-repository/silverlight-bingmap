<?php
/*
 * Silverlight Bing Maps
 * Fonctions du plugin
 *
 * @package    sl-bingmaps
 * @subpackage wordpress plugin
 * @version    SVN: $Id: functions.php 8 2010-04-28 19:43:53Z sushicodeur $
 *
 */

// Définit les variables globales
$sl_bingmaps_xml_vars_document = null;
$sl_bingmaps_xml_vars_xpath = null;


/**
 * Génère le HTML pour le shortcode
 * @param $atts
 * @return unknown_type
 */
function sl_bingmaps_do_shortcode($atts) {
  $output = '';
  $output .= '<object data="data:application/x-silverlight," type="application/x-silverlight-2" width="'. $atts['width'] .'" height="'. $atts['height'] .'">';
  $output .= '<param name="source" value="'. BINGMAPS_URL .'/silverlight/pluginBingMap.xap"/>';
  $output .= '<param name="onerror" value="onSilverlightError" />';
  $output .= '<param name="background" value="'. $atts['background'] .'" />';
  $output .= '<param name="minRuntimeVersion" value="3.0.40818.0" />';
  $output .= '<param name="autoUpgrade" value="true" />';
  $output .= '<param  name="initParams" value="'. sl_bingmaps_get_initvars($atts) .'" />';
  $output .= '<a href="http://go.microsoft.com/fwlink/?LinkID=149156&v=3.0.40818.0" style="text-decoration: none;">';
  $output .= '<img src="http://go.microsoft.com/fwlink/?LinkId=108181" alt="Get Microsoft Silverlight" style="border-style: none"/>';
  $output .= '</a>';
  $output .= '</object>';
  return $output;
}

/**
 * Retourne vrai si la clé d'activation Bing Maps a été saisie, faux sinon.
 * @return unknown_type
 */
function sl_bingmaps_is_activated() {
  return (get_option('sl-bingmaps-CredentialsProvider') != null);
}

/**
 * Initialise les variables dynamiques
 * @return unknown_type
 */
function sl_bingmaps_init_vars() {
  $xml_vars = sl_bingmaps_get_xml_vars();
  if ($xml_vars) {
    foreach($xml_vars->query('/sl-bingmaps/var') as $var_node) {
      $name = $var_node->getAttribute('name');
      if (get_option('sl-bingmaps-'.$name) == null) {
        $default = $var_node->getAttribute('default');
        add_option('sl-bingmaps-'.$name, $default);
      }
    }
  }
}

/**
 * Sauvegarde les variables dynamiques
 * @return unknown_type
 */
function sl_bingmaps_update_vars() {
  $xml_vars = sl_bingmaps_get_xml_vars();
  if ($xml_vars) {
    foreach($xml_vars->query('/sl-bingmaps/var') as $var_node) {
      $name = $var_node->getAttribute('name');
      update_option('sl-bingmaps-'.$name, $_REQUEST['sl-bingmaps-'.$name]);
    }
  }
}

/**
 * Retourne les valeurs par défaut pour les variables du plugin
 * @return unknown_type
 */
function sl_bingmaps_default_vars() {
  $default_atts = array(
    'background' => get_option('sl-bingmaps-background'),
    'width' => get_option('sl-bingmaps-width'),
    'height' => get_option('sl-bingmaps-height'),
  );
  $xml_vars = sl_bingmaps_get_xml_vars();
  if ($xml_vars) {
    foreach($xml_vars->query('/sl-bingmaps/var') as $var_node) {
      $name = $var_node->getAttribute('name');
      $default_atts[strtolower($name)] = get_option('sl-bingmaps-'.$name);
    }
  }
  return $default_atts;
}

function sl_bingmaps_get_initvars($atts) {
  $output = '';
  $separator = ',';
  // Commence par la clé bing maps
  $output .= 'CredentialsProvider=' . get_option('sl-bingmaps-CredentialsProvider');
  // Puis ajoute toutes les variables
  $xml_vars = sl_bingmaps_get_xml_vars();
  if ($xml_vars) {
    foreach($xml_vars->query('/sl-bingmaps/var') as $var_node) {
      $name = $var_node->getAttribute('name');
      $control = $var_node->getAttribute('control');
      if ($control == 'checkbox') {
        $bool_value = ($atts[strtolower($name)]=='1')?'true':'false';
        $output .= $separator . $name .'='. $bool_value;
      } else {
        $output .= $separator . $name .'='. $atts[strtolower($name)];
      }
    }
  }
  return $output;
}

/**
 * Formatte et affiche les variables 
 * @return unknown_type
 */
function sl_bingmaps_format_vars() {
  $xml_vars = sl_bingmaps_get_xml_vars();
  if ($xml_vars) {
    foreach($xml_vars->query('/sl-bingmaps/var') as $var_node) {
      sl_bingmaps_format_var ($var_node);
    }
  }
}

/**
 * Formatte et affiche les variables, dans le script JS générant le shortcode
 * @return unknown_type
 */
function sl_bingmaps_format_vars_tinymce() {
  $xml_vars = sl_bingmaps_get_xml_vars();
  if ($xml_vars) {
    $output = '';
    foreach($xml_vars->query('/sl-bingmaps/var') as $var_node) {
      $name = $var_node->getAttribute('name');
      $output .= "      if (form['sl-bingmaps-$name'].value) { \n";
      $output .= "        shortcode += separator + '$name=\"'+form['sl-bingmaps-$name'].value+'\"'; \n";
      $output .= "      } \n\n";
    }
    echo $output;
  }
}

/**
 * Formatte et affiche une variable donnée
 * @param $var_node
 * @return unknown_type
 */
function sl_bingmaps_format_var ($var_node) {
  $control = $var_node->getAttribute('control');
  if ($control == 'checkbox') {
    sl_bingmaps_format_var_checkbox($var_node);
  } elseif ($control == 'select') {
    sl_bingmaps_format_var_select($var_node);
  } elseif ($control == 'inputtext') {
    sl_bingmaps_format_var_inputtext($var_node);
  } else {
    // Par défaut
    sl_bingmaps_format_var_inputtext($var_node);
  }
}

/**
 * Formatte et affiche une variable avec un contrôle checkbox
 * @param $var_node
 * @return unknown_type
 */
function sl_bingmaps_format_var_checkbox($var_node) {
  $name = $var_node->getAttribute('name');
  $default = $var_node->getAttribute('default');
  $label = $var_node->getAttribute('label');
  $description = $var_node->getAttribute('description');
  $checked = (get_option('sl-bingmaps-'.$name) == '1')?' checked="checked" ':'';

  $output = '';
  $output .= '<tr>';
  $output .= '<th><label for="sl-bingmaps-'. $name .'">'. __($label, 'sl-bingmaps') .'</label></th>';
  $output .= '<td>';
  $output .= '<input type="checkbox" id="sl-bingmaps-'. $name .'" name="sl-bingmaps-'. $name .'" value="1" '. $checked .'/>';
  $output .= '<p class="help">'. __($description, 'sl-bingmaps') .'</p>';
  $output .= '</td>';
  $output .= '</tr>';

  echo $output;
}

/**
 * Formatte et affiche une variable avec un contrôle select
 * @param $var_node
 * @return unknown_type
 */
function sl_bingmaps_format_var_select($var_node) {
  $name = $var_node->getAttribute('name');
  $default = $var_node->getAttribute('default');
  $options = explode(',', $var_node->getAttribute('options')) ;
  $label = $var_node->getAttribute('label');
  $description = $var_node->getAttribute('description');

  $output = '';
  $output .= '<tr>';
  $output .= '<th><label for="sl-bingmaps-'. $name .'">'. __($label, 'sl-bingmaps') .'</label></th>';
  $output .= '<td>';
  $output .= '<select id="sl-bingmaps-'. $name .'" name="sl-bingmaps-'. $name .'">';
  foreach ($options as $option) {
    $option = trim($option);
    $selected = (get_option('sl-bingmaps-'.$name) == $option)?' selected="selected" ':'';
    $output .= '<option value="'. $option .'"'. $selected .'>'. __($option, 'sl-bingmaps') .'</option>'; // note : la localisation ici permettra si on le souhaites d'avoir un libellé différent du nom du mode
  }
  $output .= '</select>';
  $output .= '<p class="help">'. __($description, 'sl-bingmaps') .'</p>';
  $output .= '</td>';
  $output .= '</tr>';

  echo $output;
}

/**
 * Formatte et affiche une variable avec un contrôle input type=text
 * @param $var_node
 * @return unknown_type
 */
function sl_bingmaps_format_var_inputtext($var_node) {
  $name = $var_node->getAttribute('name');
  $default = $var_node->getAttribute('default');
  $label = $var_node->getAttribute('label');
  $description = $var_node->getAttribute('description');

  $output = '';
  $output .= '<tr>';
  $output .= '<th><label for="sl-bingmaps-'. $name .'">'. __($label, 'sl-bingmaps') .'</label></th>';
  $output .= '<td>';
  $output .= '<input type="text" id="sl-bingmaps-'. $name .'" name="sl-bingmaps-'. $name .'" value="'. get_option('sl-bingmaps-'.$name) .'" />';
  $output .= '<p class="help">'. __($description, 'sl-bingmaps') .'</p>';
  $output .= '</td>';
  $output .= '</tr>';

  echo $output;
}

/**
 * Retourne le DOMXPath des variables du plugin. Si une erreur de chargement survient, retourne faux;
 * @return unknown_type
 */
function sl_bingmaps_get_xml_vars() {
global $sl_bingmaps_xml_vars_xpath;
  // Prend le xpath en cache
  if (isset($sl_bingmaps_xml_vars_xpath)) {
    return $sl_bingmaps_xml_vars_xpath;
  }
  // Prend le xpath sur disque
  $config_path = dirname(__file__).'/config.xml';
  $document = sl_bingmaps_load_xml($config_path);
  if ($document) {
    $sl_bingmaps_xml_vars_xpath = new DOMXPath($document);
    return $sl_bingmaps_xml_vars_xpath;
  }
  return false;
}

/**
 * Retourne le DOMDocument des variables du plugin. Si une erreur de chargement survient, retourne faux;
 * @param $path
 * @return unknown_type
 */
function sl_bingmaps_load_xml($path) {
global $sl_bingmaps_xml_vars_document;
  // Prend le document en cache
  if (isset($sl_bingmaps_xml_vars_document)) {
    return $sl_bingmaps_xml_vars_document;
  }
  // Prend le document sur disque
  libxml_use_internal_errors(true);
  $sl_bingmaps_xml_vars_document = new DOMDocument();
  
  if (!$sl_bingmaps_xml_vars_document->load($path)) {
    // Erreur de chargement du document, l'ignore
    libxml_clear_errors();
    libxml_use_internal_errors(false);
    return false;
  }

  libxml_use_internal_errors(false);

  return $sl_bingmaps_xml_vars_document;
}

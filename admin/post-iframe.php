<?php 
require_once('../../../../wp-blog-header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="fr-FR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Démo du plugin sl-bingmaps &rsaquo; Fichiers envoyés &#8212; WordPress</title>
  <script type="text/javascript" src="../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
  <script type="text/javascript">
  var slBingMaps = {

    init : function() {
    },

    insert : function() {

      var form = document.forms[0];
      var shortcode = '[sl-bingmaps';
      var separator = ' ';

      if (form['sl-bingmaps-background'].value) {
        shortcode += separator + 'background="'+form['sl-bingmaps-background'].value+'"';
      }

      if (form['sl-bingmaps-width'].value) {
        shortcode += separator + 'width="'+form['sl-bingmaps-width'].value+'"';
      }

      if (form['sl-bingmaps-height'].value) {
        shortcode += separator + 'height="'+form['sl-bingmaps-height'].value+'"';
      }

<?php sl_bingmaps_format_vars_tinymce(); ?>

      shortcode += ']';

      tinyMCEPopup.editor.execCommand('mceInsertRawHTML', false, shortcode);
      tinyMCEPopup.close();

    }
  };
  tinyMCEPopup.onInit.add(slBingMaps.init, slBingMaps);
  </script>
  <style type="text/css">
    h3 {
      display:block;
      color:#5A5A5A;
      font-family:Georgia,"Times New Roman",Times,serif;
      font-weight:normal;
      font-size:1.6em;
      margin:1em 0;
    }
    h4 {
      display:block;
      color:#5A5A5A;
      font-family:Georgia,"Times New Roman",Times,serif;
      font-weight:normal;
      border-bottom:1px solid #DADADA;
      font-size:1.3em;
      padding:0 0 3px;
    }
    div.fieldlist {
      border:1px solid #DFDFDF;
      width:623px;
      padding:12px;
      margin-bottom:20px;
      color:#333333;
    }
    th {
      vertical-align:top;
      font-size:13px;
      text-align: left;
    }
    tr {
      line-height:2em;
    }
    p.help {
      margin:0;
      font-style:italic;
    }
    body {
      font-size:13px;
    }
  </style>
</head>

<body id="sl-bingmaps">

<form onsubmit="slBingMaps.insert(); return false;" action="#" class="media-upload-form type-form validate" id="sl-bingmaps-insert-form">

  <h3><?php _e('Insérer Silverlight Bing Maps', 'sl-bingmaps'); ?></h3>

  <div class="fieldlist">

    <h4 class="media-item media-blank"><?php _e('Paramètres du composant Silverlight', 'sl-bingmaps'); ?></h3>

    <table class="form-table">

      <tr>
        <th><label for="sl-bingmaps-background"><?php _e('Couleur d\'arrière plan', 'sl-bingmaps'); ?></label></th>
        <td>
          <input type="text" id="sl-bingmaps-background" name="sl-bingmaps-background" value="<?php echo get_option('sl-bingmaps-background'); ?>" /> 
          <p class="help"><?php _e('Paramètre la couleur de fond du composant Silverlight.', 'sl-bingmaps'); ?></p>
        </td>
      </tr>

      <tr>
        <th><label for="sl-bingmaps-width"><?php _e('Largeur', 'sl-bingmaps'); ?></label></th>
        <td>
          <input type="text" id="sl-bingmaps-width" name="sl-bingmaps-width" value="<?php echo get_option('sl-bingmaps-width'); ?>" /> 
          <p class="help"><?php _e('Paramètre la largeur du composant Silverlight.', 'sl-bingmaps'); ?></p>
        </td>
      </tr>

      <tr>
        <th><label for="sl-bingmaps-height"><?php _e('Hauteur', 'sl-bingmaps'); ?></label></th>
        <td>
          <input type="text" id="sl-bingmaps-height" name="sl-bingmaps-height" value="<?php echo get_option('sl-bingmaps-height'); ?>" /> 
          <p class="help"><?php _e('Paramètre la hauteur du composant Silverlight.', 'sl-bingmaps'); ?></p>
        </td>
      </tr>

    </table>

  </div>
  <div class="fieldlist">

    <h4><?php _e('Valeurs de départ', 'sl-bingmaps'); ?></h3>

    <table class="form-table">

      <?php sl_bingmaps_format_vars(); ?>

    </table>

  </div>

  <p class="savebutton ml-submit">
    <input type="submit" class="button" name="save" value="<?php esc_attr_e('Enregistrer toutes les modifications', 'sl-bingmaps'); ?>" />
  </p>

</body>
</html>

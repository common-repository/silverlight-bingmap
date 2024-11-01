<?php
/*
 * Silverlight Bing Maps
 * Formulaire de gestion des options du plugin
 *
 * @package    sl-bingmaps
 * @subpackage wordpress plugin
 * @version    SVN: $Id: plugin-options-form.php 8 2010-04-28 19:43:53Z sushicodeur $
 *
 */
?>

<div class="wrap nosubsub">

  <?php //echo screen_icon('bingmaps'); ?>
  <h2><?php _e('Options du plugin Silverlight Bing Maps', 'sl-bingmaps'); ?></h2>

  <p><?php _e('Cette page vous permet de configurer les options de votre plugin.', 'sl-bingmaps'); ?></p>

  <form action="options-general.php?page=sl-bingmaps.php" method="post">

    <input type="hidden" name="sl-bingmaps-action" value="save_options" />


    <h3><?php _e('Clé d\'activation Bing Maps', 'sl-bingmaps'); ?></h3>
    <p class="help"><?php _e('Paramètre le plugin avec votre clé Bing Maps', 'sl-bingmaps'); ?></p>

    <table class="form-table">

      <tr>
        <th><label for="sl-bingmaps-CredentialsProvider"><?php _e('Clé Bing Maps', 'sl-bingmaps'); ?></label></th>
        <td>
          <input type="text" id="sl-bingmaps-CredentialsProvider" name="sl-bingmaps-CredentialsProvider" value="<?php echo get_option('sl-bingmaps-CredentialsProvider'); ?>" /> 
          <p class="help"><?php printf(__('Vous devez obtenir une clé d\'activation auprès de Bing Maps avant de pouvoir utiliser ce plugin. Pour obtenir votre clé, <a href="%1$s" target="_blank">suivez ce lien</a>.', 'sl-bingmaps'), BINGMAPS_ACTIVATION_URL); ?></p>
        </td>
      </tr>

    </table>


    <h3><?php _e('Paramètres du composant Silverlight', 'sl-bingmaps'); ?></h3>
    <p class="help"><?php _e('Paramètre le composant Silverlight', 'sl-bingmaps'); ?></p>

    <table class="form-table">

      <tr>
        <th><label for="sl-bingmaps-background"><?php _e('Couleur d\'arrière plan', 'sl-bingmaps'); ?></label></th>
        <td>
          <input type="text" id="sl-bingmaps-background" name="sl-bingmaps-background" value="<?php echo get_option('sl-bingmaps-background'); ?>" /> 
          <p class="help"><?php _e('Paramètre la couleur de fond par défaut du composant Silverlight.', 'sl-bingmaps'); ?></p>
        </td>
      </tr>

      <tr>
        <th><label for="sl-bingmaps-width"><?php _e('Largeur', 'sl-bingmaps'); ?></label></th>
        <td>
          <input type="text" id="sl-bingmaps-width" name="sl-bingmaps-width" value="<?php echo get_option('sl-bingmaps-width'); ?>" /> 
          <p class="help"><?php _e('Paramètre la largeur par défaut du composant Silverlight.', 'sl-bingmaps'); ?></p>
        </td>
      </tr>

      <tr>
        <th><label for="sl-bingmaps-height"><?php _e('Hauteur', 'sl-bingmaps'); ?></label></th>
        <td>
          <input type="text" id="sl-bingmaps-height" name="sl-bingmaps-height" value="<?php echo get_option('sl-bingmaps-height'); ?>" /> 
          <p class="help"><?php _e('Paramètre la hauteur par défaut du composant Silverlight.', 'sl-bingmaps'); ?></p>
        </td>
      </tr>

    </table>


    <h3><?php _e('Valeurs par défaut', 'sl-bingmaps'); ?></h3>
    <p class="help"><?php _e('Paramètre les valeurs par défaut pour vos cartes Bing Maps', 'sl-bingmaps'); ?></p>

    <table class="form-table">

      <?php sl_bingmaps_format_vars(); ?>

    </table>

    <p class="submit"><input type="submit" name="submit" class="button" value="<?php esc_attr_e('Update options'); ?>" /></p>

  </form>

</div><?php // .wrap nosubsub ?>
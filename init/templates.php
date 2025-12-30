<?php
if (! defined('ABSPATH')) exit;

/**
 * Override program archive. Can be overidden by plugin, or taxonomy-program.php
 * file located in theme or child theme (I think. Let me know if it doesn't
 * work... )
 * 
 * TODO: split to addon
 *
 * @param [string] $template
 * @return void
 */
function hydir_get_tax_program_template($template) {
  if (
    is_tax('program') &&
    '' === locate_template('taxonomy-program.php')
  ) {
    /**
     * Filter the taxonomy program template path.
     *
     * @since 1.2.0
     * @param string $template The template path.
     */
    $template = apply_filters('hydir_taxonomy_program_template', hydir_get_template_part('taxonomy-program'));
  }
  return $template;
}
add_filter('taxonomy_template', 'hydir_get_tax_program_template');




/**
 * Override directory archive
 *
 * @param [string] $template
 * @return void
 */
function hydir_get_directory_archive_template($template) {
  global $post;

  if (
    is_post_type_archive('hy_directory') &&
    '' === locate_template('directory-archive.php')
  ) {
    /**
     * Filter the directory archive template path.
     *
     * @since 1.2.0
     * @param string $template The template path.
     */
    $template = apply_filters('hydir_archive_template', hydir_get_template_part('directory-archive'));
  }
  return $template;
}
add_filter('archive_template', 'hydir_get_directory_archive_template');



/**
 * Override single_template for person
 *
 * @param [type] $single_template
 * @return void
 */
function hydir_get_single_person_template($template) {
  global $post;

  if (
    'hy_directory' === $post->post_type &&
    '' === locate_template('directory-single.php')
  ) {
    /**
     * Filter the single directory entry template path.
     *
     * @since 1.2.0
     * @param string $template The template path.
     * @param int    $post_id  The post ID.
     */
    $template = apply_filters('hydir_single_template', hydir_get_template_part('directory-single'), $post->ID);
  }
  return $template;
}
add_filter('single_template', 'hydir_get_single_person_template');


/**
 * Allows theme override of hydir-templates.
 * 
 * Returns the path to a template file
 *
 * Looks for the file in these directories, in this order:
 *         Current theme
 *         Parent theme
 *         Current theme templates folder
 *         Parent theme templates folder
 *         This plugin
 *
 * To use a custom template in a theme, copy the file from /templates into a 
 * templates folder in your theme. Customize as needed, but keep the file name 
 * as-is. The  plugin will automatically use your custom template file instead
 * of the ones included in the plugin.
 *
 * @param [type] $name
 * @return void
 */
function hydir_get_template_part($name) {

  // TODO: Universalize - so 'tempate_part_ANYTHING.php' gets pulled if exists. If not, default to list.

  $template = NULL;

  $locations[] = "{$name}.php";
  $locations[] = "/templates/{$name}.php";

  // Filter the locations to search for a template file
  // @param  array   $locations   File names and/or paths to check
  $locations = apply_filters('hydir_template_paths', $locations);
  $template = locate_template($locations);

  // TODO: put into array and search through each
  if (empty($template)) {
    $template_dir = NULL;

    // Allow addons to override templates
    $template_dir = apply_filters('hydir_template_dir', $template_dir);

    $possible = $template_dir . $name . '.php';
    if (file_exists($possible)) {
      $template = $possible;
    }
  }


  if (empty($template)) {
    $default = HYDIR_TEMPLATE_DIR . $name . '.php';
    if (file_exists($default)) {
      $template = $default;
    } else {
      $template = NULL;
    }
  }

  /**
   * Filter the final resolved template path.
   *
   * @since 1.2.0
   * @param string|null $template The resolved template path or null.
   * @param string      $name     The template name requested.
   */
  return apply_filters('hydir_resolved_template', $template, $name);
}

# Hydrogen Directory - Developer Documentation

This document provides a complete reference of all available hooks (actions and filters) in Hydrogen Directory for building add-on plugins and customizations.

## Table of Contents

- [Plugin Lifecycle Hooks](#plugin-lifecycle-hooks)
- [Initialization Hooks](#initialization-hooks)
- [Post Type & Taxonomy Filters](#post-type--taxonomy-filters)
- [Query Filters](#query-filters)
- [Shortcode & Display Hooks](#shortcode--display-hooks)
- [Template Filters](#template-filters)
- [Entry Display Hooks](#entry-display-hooks)
- [Thumbnail Filters](#thumbnail-filters)
- [Admin Hooks](#admin-hooks)
- [REST API Filters](#rest-api-filters)
- [Example Add-on Plugin](#example-add-on-plugin)

---

## Plugin Lifecycle Hooks

### Actions

#### `hydir_activated`
Fires when the plugin is activated. Use for initial setup.

```php
add_action('hydir_activated', function() {
    // Create custom tables, set default options, etc.
});
```

#### `hydir_deactivated`
Fires when the plugin is deactivated. Use for cleanup (but not data removal).

```php
add_action('hydir_deactivated', function() {
    // Clean up temporary data
});
```

#### `hydir_loaded`
Fires after all plugin files are loaded. Safe to extend functionality here.

```php
add_action('hydir_loaded', function() {
    // Your add-on plugin code here
});
```

---

## Initialization Hooks

### Actions

#### `hydir_before_init`
Fires before post types and taxonomies are registered.

#### `hydir_after_init`
Fires after all registrations are complete.

#### `hydir_post_type_registered`
Fires after the `hy_directory` post type is registered.

#### `hydir_taxonomy_registered`
Fires after the `role` taxonomy is registered. Use to register additional taxonomies.

```php
add_action('hydir_taxonomy_registered', function() {
    register_taxonomy('department', 'hy_directory', [
        'label' => 'Departments',
        'hierarchical' => true,
        'show_ui' => true,
    ]);
});
```

#### `hydir_styles_registered`
Fires after frontend styles are registered. Add your own stylesheets.

#### `hydir_scripts_registered`
Fires when frontend scripts would be registered. Add your own scripts.

#### `hydir_admin_init`
Fires during admin initialization.

---

## Post Type & Taxonomy Filters

### Filters

#### `hydir_post_type_labels`
Modify the labels for the directory post type.

```php
add_filter('hydir_post_type_labels', function($labels) {
    $labels['name'] = 'Team Members';
    $labels['singular_name'] = 'Team Member';
    return $labels;
});
```

#### `hydir_post_type_supports`
Modify supported features (title, editor, excerpt, thumbnail, revisions).

```php
add_filter('hydir_post_type_supports', function($supports) {
    $supports[] = 'custom-fields';
    return $supports;
});
```

#### `hydir_post_type_args`
Modify all post type registration arguments.

```php
add_filter('hydir_post_type_args', function($args) {
    $args['has_archive'] = true;
    $args['exclude_from_search'] = false;
    return $args;
});
```

#### `hydir_taxonomy_labels`
Modify taxonomy labels.

#### `hydir_taxonomy_args`
Modify taxonomy registration arguments.

```php
add_filter('hydir_taxonomy_args', function($args, $post_type) {
    $args['hierarchical'] = false; // Make it tag-like
    return $args;
}, 10, 2);
```

#### `hydir_image_sizes`
Modify registered image sizes.

```php
add_filter('hydir_image_sizes', function($sizes) {
    $sizes[] = [
        'name' => 'hydir-large-600',
        'width' => 600,
        'height' => 600,
        'crop' => true
    ];
    return $sizes;
});
```

---

## Query Filters

### Filters

#### `hydir_get_terms_args`
Modify arguments for getting taxonomy terms.

```php
add_filter('hydir_get_terms_args', function($args, $tax) {
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = 'term_order';
    return $args;
}, 10, 2);
```

#### `hydir_tax_terms`
Filter the terms returned for a taxonomy.

#### `hydir_posts_orderby`
Change how posts are ordered (default: 'title').

```php
add_filter('hydir_posts_orderby', function($orderby, $tax, $term) {
    return 'menu_order';
}, 10, 3);
```

#### `hydir_posts_order`
Change order direction (default: 'ASC').

#### `hydir_posts_limit`
Change posts per term limit (default: -1 for all).

#### `hydir_posts_for_tax`
Filter the final posts array grouped by term.

```php
add_filter('hydir_posts_for_tax', function($results, $tax, $term) {
    // Filter out draft posts, reorder, etc.
    return $results;
}, 10, 3);
```

---

## Shortcode & Display Hooks

### Filters

#### `hydir_shortcode_defaults`
Modify shortcode default arguments.

```php
add_filter('hydir_shortcode_defaults', function($args, $atts) {
    $args['columns'] = '3'; // Change default columns
    return $args;
}, 10, 2);
```

#### `hydir_shortcode_params`
Filter validated shortcode parameters before display.

#### `hydir_display_posts`
Filter posts array before display.

#### `hydir_no_entries_message`
Customize the "no entries found" error message.

```php
add_filter('hydir_no_entries_message', function($message, $tax, $term) {
    return '<p class="notice">No team members found in this category.</p>';
}, 10, 3);
```

#### `hydir_group_classes`
Modify CSS classes for group wrappers.

#### `hydir_group_header`
Customize the group header HTML.

```php
add_filter('hydir_group_header', function($html, $term, $posts) {
    $count = count($posts);
    return "<h2>{$term} <span class='count'>({$count})</span></h2>";
}, 10, 3);
```

### Actions

#### `hydir_shortcode_enqueue_styles`
Fires before styles are enqueued, receives the style parameter.

#### `hydir_before_directory`
Fires before directory output begins.

#### `hydir_after_directory`
Fires after directory output ends.

#### `hydir_before_group`
Fires at the start of each term group.

#### `hydir_after_group`
Fires at the end of each term group.

---

## Column/Grid Hooks

### Filters

#### `hydir_column_fill_posts`
Filter posts before column processing.

#### `hydir_columns_count`
Modify number of columns dynamically.

#### `hydir_row_classes`
Modify CSS classes for row wrappers.

#### `hydir_column_classes`
Modify CSS classes for column wrappers.

### Actions

#### `hydir_before_columns`
Fires before columns output begins.

#### `hydir_after_columns`
Fires after columns output ends.

#### `hydir_before_row`
Fires at the start of each row.

#### `hydir_after_row`
Fires at the end of each row.

#### `hydir_before_entry`
Fires before each entry is rendered.

#### `hydir_after_entry`
Fires after each entry is rendered.

---

## Entry Display Hooks

### List Style Filters

- `hydir_list_permalink` - Filter entry URL
- `hydir_list_title` - Filter title text
- `hydir_list_position` - Filter position text
- `hydir_list_entry_classes` - Filter wrapper classes
- `hydir_list_show_link` - Show/hide link (default: true)
- `hydir_list_show_content` - Show/hide content (default: true)
- `hydir_list_full_content` - Full or excerpt (default: false)
- `hydir_list_excerpt_length` - Excerpt word count (default: 20)
- `hydir_list_button_text` - Button text (default: 'More')
- `hydir_list_content` - Filter the content HTML

### List Style Actions

- `hydir_list_before_image` / `hydir_list_after_image`
- `hydir_list_before_title` / `hydir_list_after_title`
- `hydir_list_before_content` / `hydir_list_after_content`
- `hydir_list_before_footer` / `hydir_list_after_footer`

### Card Style Filters

- `hydir_card_permalink` - Filter entry URL
- `hydir_card_title` - Filter title text
- `hydir_card_position` - Filter position text
- `hydir_card_entry_classes` - Filter wrapper classes
- `hydir_card_show_content` - Show/hide content (default: true)
- `hydir_card_full_content` - Full or excerpt (default: false)
- `hydir_card_excerpt_length` - Excerpt word count (default: 25)
- `hydir_card_button_text` - Button text (default: 'View Profile')
- `hydir_card_content` - Filter the content HTML

### Card Style Actions

- `hydir_card_before_image` / `hydir_card_after_image`
- `hydir_card_before_title` / `hydir_card_after_title`
- `hydir_card_before_content` / `hydir_card_after_content`
- `hydir_card_before_footer` / `hydir_card_after_footer`

### Text Style Filters

- `hydir_text_permalink` - Filter entry URL
- `hydir_text_title` - Filter title text
- `hydir_text_position` - Filter position text
- `hydir_text_entry_classes` - Filter wrapper classes
- `hydir_text_show_link` - Show/hide link (default: true)
- `hydir_text_show_position` - Show/hide position (default: true)
- `hydir_text_bullet` - Bullet character (default: '•')
- `hydir_text_separator` - Name/position separator (default: ' — ')

### Text Style Actions

- `hydir_text_before_entry` / `hydir_text_after_entry`
- `hydir_text_before_name` / `hydir_text_after_name`

### Single Entry Filters

- `hydir_single_title` - Filter the title
- `hydir_single_position` - Filter the position
- `hydir_single_entry_classes` - Filter wrapper classes
- `hydir_single_thumbnail_size` - Thumbnail size (default: 'medium')
- `hydir_single_thumbnail_class` - Thumbnail CSS classes
- `hydir_single_show_thumbnail` - Show/hide thumbnail (default: true)

### Single Entry Actions

- `hydir_single_before_header` / `hydir_single_after_header`
- `hydir_single_before_title` / `hydir_single_after_title`
- `hydir_single_before_thumbnail` / `hydir_single_after_thumbnail`
- `hydir_single_before_content` / `hydir_single_after_content`
- `hydir_single_before_main` / `hydir_single_after_main`
- `hydir_single_before_template` / `hydir_single_after_template`

---

## Thumbnail Filters

#### `hydir_thumbnail_size`
Filter the default thumbnail size.

#### `hydir_thumbnail_default_attr`
Filter default thumbnail HTML attributes.

#### `hydir_thumbnail_html`
Filter the thumbnail HTML when an image exists.

#### `hydir_placeholder_image`
Change placeholder image URL.

```php
add_filter('hydir_placeholder_image', function($url) {
    return get_template_directory_uri() . '/images/default-avatar.png';
});
```

#### `hydir_placeholder_alt`
Change placeholder alt text.

#### `hydir_placeholder_html`
Filter the complete placeholder HTML.

---

## Template Filters

#### `hydir_template_paths`
Add additional template search paths.

```php
add_filter('hydir_template_paths', function($locations) {
    $locations[] = 'my-addon/templates/';
    return $locations;
});
```

#### `hydir_template_dir`
Add addon template directories.

```php
add_filter('hydir_template_dir', function($dir) {
    return plugin_dir_path(__FILE__) . 'templates/';
});
```

#### `hydir_resolved_template`
Filter the final resolved template path.

#### `hydir_single_template`
Filter the single entry template.

#### `hydir_archive_template`
Filter the archive template.

#### `hydir_taxonomy_program_template`
Filter the taxonomy program template.

---

## Admin Hooks

### Filters

#### `hydir_show_position_meta_box`
Enable/disable the position meta box.

#### `hydir_position_meta_box_title`
Change the meta box title.

#### `hydir_position_field_label`
Change the position field label.

#### `hydir_save_position_value`
Filter position value before saving.

### Actions

#### `hydir_after_position_meta_box`
Add additional meta boxes after position.

```php
add_action('hydir_after_position_meta_box', function() {
    add_meta_box('my_custom_box', 'Extra Info', 'my_callback', 'hy_directory');
});
```

#### `hydir_position_meta_box_fields`
Add fields to the position meta box.

```php
add_action('hydir_position_meta_box_fields', function($post) {
    $email = get_post_meta($post->ID, 'email', true);
    echo '<p><label>Email:</label><br>';
    echo '<input type="email" name="email" value="' . esc_attr($email) . '" class="widefat"></p>';
});
```

#### `hydir_after_save_position`
Fires after position meta is saved. Save your custom fields here.

```php
add_action('hydir_after_save_position', function($post_id, $new_value, $old_value) {
    if (isset($_POST['email'])) {
        update_post_meta($post_id, 'email', sanitize_email($_POST['email']));
    }
}, 10, 3);
```

---

## REST API Filters

#### `hydir_rest_preview_params`
Filter preview request parameters.

#### `hydir_rest_preview_html`
Filter the preview HTML response.

#### `hydir_rest_preview_empty_message`
Customize the empty preview message.

#### `hydir_rest_taxonomies`
Filter the taxonomies endpoint response.

#### `hydir_rest_terms`
Filter the terms endpoint response.

### Actions

#### `hydir_rest_preview_before`
Fires before preview is generated.

#### `hydir_enqueue_block_editor_assets`
Fires when block editor assets are enqueued.

---

## CSS/JS Asset Filters

#### `hydir_main_css_url`
Change the main stylesheet URL.

#### `hydir_list_card_css_url`
Change the list/card stylesheet URL.

---

## Example Add-on Plugin

Here's a complete example of an add-on plugin that extends Hydrogen Directory:

```php
<?php
/**
 * Plugin Name: Hydrogen Directory - Social Links
 * Description: Adds social media links to directory entries
 * Version: 1.0.0
 * Requires Plugins: hydrogen-directory
 */

if (!defined('ABSPATH')) exit;

// Wait for Hydrogen Directory to load
add_action('hydir_loaded', 'hydir_social_init');

function hydir_social_init() {
    // Add meta box for social links
    add_action('hydir_after_position_meta_box', 'hydir_social_add_meta_box');
    
    // Save social meta
    add_action('hydir_after_save_position', 'hydir_social_save_meta', 10, 3);
    
    // Display social links in templates
    add_action('hydir_card_after_content', 'hydir_social_display');
    add_action('hydir_list_after_content', 'hydir_social_display');
    add_action('hydir_single_after_content', 'hydir_social_display');
}

function hydir_social_add_meta_box() {
    add_meta_box(
        'hydir_social_links',
        'Social Links',
        'hydir_social_meta_box_content',
        'hy_directory',
        'normal'
    );
}

function hydir_social_meta_box_content($post) {
    wp_nonce_field('hydir_social_nonce', 'hydir_social_nonce');
    
    $linkedin = get_post_meta($post->ID, '_hydir_linkedin', true);
    $twitter = get_post_meta($post->ID, '_hydir_twitter', true);
    ?>
    <p>
        <label>LinkedIn URL:</label><br>
        <input type="url" name="hydir_linkedin" value="<?php echo esc_url($linkedin); ?>" class="widefat">
    </p>
    <p>
        <label>Twitter/X URL:</label><br>
        <input type="url" name="hydir_twitter" value="<?php echo esc_url($twitter); ?>" class="widefat">
    </p>
    <?php
}

function hydir_social_save_meta($post_id, $new_value, $old_value) {
    if (!isset($_POST['hydir_social_nonce']) || 
        !wp_verify_nonce($_POST['hydir_social_nonce'], 'hydir_social_nonce')) {
        return;
    }
    
    if (isset($_POST['hydir_linkedin'])) {
        update_post_meta($post_id, '_hydir_linkedin', esc_url_raw($_POST['hydir_linkedin']));
    }
    if (isset($_POST['hydir_twitter'])) {
        update_post_meta($post_id, '_hydir_twitter', esc_url_raw($_POST['hydir_twitter']));
    }
}

function hydir_social_display($post_id) {
    $linkedin = get_post_meta($post_id, '_hydir_linkedin', true);
    $twitter = get_post_meta($post_id, '_hydir_twitter', true);
    
    if ($linkedin || $twitter) {
        echo '<div class="hydir-social-links">';
        if ($linkedin) {
            echo '<a href="' . esc_url($linkedin) . '" target="_blank" rel="noopener">LinkedIn</a> ';
        }
        if ($twitter) {
            echo '<a href="' . esc_url($twitter) . '" target="_blank" rel="noopener">Twitter/X</a>';
        }
        echo '</div>';
    }
}
```

---

## Best Practices for Add-on Developers

1. **Always check for plugin existence** before using Hydrogen Directory functions
2. **Use the `hydir_loaded` action** to ensure all plugin files are available
3. **Prefix all functions and classes** with your own unique prefix
4. **Use proper nonce verification** when saving data
5. **Sanitize all inputs** and escape all outputs
6. **Register your addon's dependencies** using the `Requires Plugins` header (WP 6.5+)

## Support

For issues or feature requests, visit: https://github.com/lbell/hydrogen-directory

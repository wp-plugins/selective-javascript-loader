=== Selective Javascript Loader ===

Contributors: Alessandro Melandri
Tags: javascript, loading
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 1.1

Selectively loads Javascript files based on the blog section visited (index, category, single post, page)

== Description ==

This plugin will try to load different Javascript files based on the blog section that is being viewed.

It can be really useful if you make extensive use of Javascript in your theme and want to split the code in different files and load functions only when you need them.

When activated, the plugin will do the following:

*  On *Index page*: will try to load the `index.js` file
*  On *Single post*:  will try to load the `single.js` file
*  On *Category*:  will try to load the `category-cat_slug.js` file. If the file doesn't exists it will try to load the `category.js` file.
*  On *Page*:  will try to load the `page-page_slug.js` file. If the file doesn't exists it will try to load the `page.js` file.

You can define which .js files should be loaded from the plugin settings page.

== Installation ==

*When installing any new plugin it's always a good idea to backup your blog data before installing.*

1. Upload the `selective-javascript-loader` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the plugin from the plugin settings page. 

== Frequently Asked Questions ==

= Where should I put Javascript files ? =

You must put Javascript file inside your theme folder. You can group your Javascript files in a folder inside your theme folder and specify its name using the plugin settings page.

= My js files are not included in the page, why ? = 

Check the plugin settings page if js file loading is enabled. By default js loading is disabled.

= What happens if I activate Javascript loading from the plugin settins page and the .js file doesn't exists ? =

Nothing :-) The plugin will not try to load a Javascript file if it doesn't exists.

= I've setup the plugin to include javascript files in footer, but nothing happens =

Check the footer.php file in your theme and make sure it calls the `<?php wp_footer(); ?>` function.

== Changelog ==

= 1.1 =

*09/14/2009*

* Added the option to choose if Javascript files should be included in the header or in the footer of the page. This option is available only if you are using WordPress 2.8 and above.
* Added WordPress version checking.
* Corrected script inclusion for Wordpress 2.7
* Some code optimization
* Corrected a layout bug in the settings page

= 1.0 =

*09/13/2009*

* First public release
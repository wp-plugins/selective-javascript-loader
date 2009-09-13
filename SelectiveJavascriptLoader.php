<?php
/*
Plugin Name: Selective Javascript Loader
Plugin URI: http://www.melandri.net/projects/selective-javascript-loader
Description: Selectively loads Javascript files based on the blog section visited (index, category, single post, page)
Author: Alessandro Melandri
Version: 1.0
Author URI: http://www.melandri.net
*/

/*
Copyright (C) 2009  Alessandro Melandri (a dot melandri at gmail dot com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or 
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
	
$js_folder = '';
$js_index = false;
$js_category = false;
$js_single = false;
$js_page = false;

function am_sjl_javascript_loader(){

global $js_folder, $js_index, $js_category, $js_single;
	
	$js_folder = get_option( 'am_sjl_jsdir' );
	
	$js_index = get_option('am_sjl_jsindex');
	$js_category = get_option('am_sjl_jscategory');
	$js_single = get_option('am_sjl_jssingle');
	$js_page = get_option('am_sjl_jspage');

	if ( $js_index && is_home() ){
		am_sjl_registerJsFile('index');
	}
	
	if ( $js_single && is_single() ){
		am_sjl_registerJsFile('single');
	}
	
	if ( $js_category && is_category() ){
		$cat_id = get_cat_id( single_cat_title("",false) );
		$cat_query_var = get_query_var('cat');
		$category = get_category($cat_query_var);	
		am_sjl_registerJsFile('category',$category->slug);
	}
	
	if( $js_page && is_page() ){
		global $post;
		am_sjl_registerJsFile('page',$post->post_name);
	}
}


function am_sjl_registerJsFile( $root, $id = null){

	global $js_folder;
	
	$rel_template_dir = get_bloginfo('template_directory');
	$js_file = "";
	
	if ( empty($id) ){
		if (file_exists( TEMPLATEPATH . $js_folder . $root . '.js' )){
			$js_file = $rel_template_dir . $js_folder . $root . '.js';
		}
	} else {
		if (file_exists( TEMPLATEPATH . $js_folder . $root . '-' . $id . '.js' )){
			$js_file = $rel_template_dir . $js_folder . $root . '-' . $id . '.js';
		} else {
			if (file_exists( TEMPLATEPATH . $js_folder . $root . '.js' )){
				$js_file = $rel_template_dir . $js_folder . $root . '.js';
			}
		}
	}
	
	wp_register_script('am_sjl_' . $root, $js_file, false, false, false);
	wp_enqueue_script('am_sjl_' . $root);
}


function am_sjl_menu() {
  add_options_page('Selective Javascript Loader setting', 'Selective Javascript Loader', 8, 'selective-javascript-loader', 'am_sjl_options');
}

function am_sjl_options() {

	global $js_folder, $js_index, $js_category, $js_single;
	?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2>Selective Javascript Loader</h2>
		
		<?php
		if( $_POST['action'] == 'save' ) {
		
			$js_folder = $_POST['am_sjl_jsdir'];
			$js_index = $_POST['am_sjl_jsindex'];
			$js_category = $_POST['am_sjl_jscategory'];
			$js_single = $_POST['am_sjl_jssingle'];
			$js_page = $_POST['am_sjl_jspage'];

			update_option( 'am_sjl_jsdir', $js_folder );
			update_option( 'am_sjl_jsindex', $js_index );
			update_option( 'am_sjl_jscategory', $js_category );
			update_option( 'am_sjl_jssingle', $js_single );
			update_option( 'am_sjl_jspage', $js_page );

			?>
			<div class="updated"><p><strong>Settings saved</strong></p></div>
			<?php
    } else {
			$js_folder = get_option( 'am_sjl_jsdir' );
			$js_index = get_option('am_sjl_jsindex');
			$js_category = get_option('am_sjl_jscategory');
			$js_single = get_option('am_sjl_jssingle');
			$js_page = get_option('am_sjl_jspage');
		}?>
		
		<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<table class="form-table">
				<tbody>
					<tr>
						<td colspan="2">Use this page to define <em>Selective Javascript Loader</em> settings.</td>
					<tr valign="top">
					</tr>
						<th scope="row">
							<label for="am_sjl_jsdir">Javascript dir</label>
						</th>
						<td>
							<input class="regular-text" name="am_sjl_jsdir" id="am_sjl_jsdir" type="text" value="<?php echo $js_folder;?>" />
							<span class="description"><em>OPTIONAL</em> - Specify the theme subdir where javascript files are stored (with leading and trailing slashes).</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="am_sjl_jscategory">Index Javascript</label>
						</th>
						<td>
							<input type="checkbox" name="am_sjl_jsindex" id="am_sjl_jsindex" value="true" <?php if ($js_index == true){echo('checked="checked"');}?> />
							<span class="description">Load the 'index.js' JavaScript file when viewing the index page.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="am_sjl_jscategory">Category Javascript</label>
						</th>
						<td>
							<input type="checkbox" name="am_sjl_jscategory" id="am_sjl_jscategory" value="true" <?php if ($js_category == true){echo('checked="checked"');}?> />
							<span class="description">When viewing a category page the plugin will try to load the 'category-<strong>cat_slug</strong>.js' JavaScript file. If it doesn't exists the plugin will try to load the 'category.js' JavaScript file.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="am_sjl_jssingle">Single post Javascript</label>
						</th>
						<td>
							<input type="checkbox" name="am_sjl_jssingle" id="am_sjl_jssingle" value="true" <?php if ($js_single == true){echo('checked="checked"');}?> />
							<span class="description">When viewing single posts, the plugin will try to load the 'single.js' JavaScript file.</span>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<label for="am_sjl_jspage">Page Javascript</label>
						</th>
						<td>
							<input type="checkbox" name="am_sjl_jspage" id="am_sjl_jspage" value="true" <?php if ($js_page == true){echo('checked="checked"');}?> />
							<span class="description">When viewing pages, the plugin will try to load the 'page-<strong>page_slug</strong>.js' JavaScript file. If it doesn't exists the plugin will try to load the 'page.js' JavaScript file.</span>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
			<input name="save" type="submit" value="Save changes" class="button-primary" />    
			<input type="hidden" name="action" value="save" />
			</p>
		</form>
		
	</div>
	
<?php
}

add_action('admin_menu', 'am_sjl_menu');
add_action('wp_print_scripts', 'am_sjl_javascript_loader');

?>
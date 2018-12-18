<?php

class app_pii_cronjob extends app_pii_models {

	function __construct() {
		parent::__construct();

	}

	public function CategoryBySlug() {
		return $this -> getCategoryBySlug();
	}

	public function importUrl() {
		$array = array();
		$list = $this -> CategoryBySlug();

		if (is_array($list)) {
			foreach ($list as $key => $value) {
				foreach ($value['import_url'] as $key => $_value) {
					$GetData = $this->getData($_value);
					$array[$value['option_slug']][] = $GetData;
				}
			}
		}
	
		return $array;
	}

	public function getData($url = '') {
		$data = @file_get_contents($url);
		if ($data) {
			return json_decode($data);
		}
		return;
	}

	public function Parent_id($name = '', $taxonamy = 'category') {
		$idObj = term_exists($name, $taxonamy);
		if ($idObj) {
			return $idObj['term_id'];
		} else {
			$insert = (array)wp_insert_term($name, // the term
			$taxonamy, // the taxonomy
			array('slug' => $name, ));
			return $insert['term_id'];

		}
	}

	public function insertTags($tags = array(), $post_ID) {
		$tags_title = array();
		if (!empty($tags) && is_array($tags)) {
			foreach ($tags as $key => $value) {
				$tags_title[] = $value -> title;
			}
			return wp_set_post_tags($post_ID, join(",", $tags_title), true);
		}

	}

	public function insertCategory($cat, $parent, $taxonamy = 'category') {
			$term_exists = term_exists($cat -> title, $taxonamy, $parent );
			if(!empty($term_exists) && is_array($term_exists)){
				return $term_exists['term_id'];
			}
			$insert = wp_insert_term($cat -> title, // the term
			$taxonamy, // the taxonomy
			array('description' => $cat -> description, 'parent' => $parent, 'slug' => $cat -> slug));
			if (is_object($insert)) {
				return $insert -> term_id;
			} else {
				return $insert['term_id'];
			}

	}

	public function InsertImage($url = '', $post_id) {
		// Add Featured Image to Post
		$image_url = $url;
		// Define the image URL here
		$upload_dir = wp_upload_dir();

		// Create image file name

		// Set upload folder
		$image_data = @file_get_contents($image_url);
		// Get image data
		$filename = basename($image_url);
		// Check folder permission and define file location
		if (wp_mkdir_p($upload_dir['path'])) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}
		if (!file_exists($file)) {
			// Create the image  file on the server
			$putcontent = @file_put_contents($file, $image_data);
			if ($putcontent) {
				// Check image file type
				$wp_filetype = wp_check_filetype($filename, null);

				// Set attachment data
				$attachment = array('post_mime_type' => $wp_filetype['type'], 'post_title' => sanitize_file_name($filename), 'post_content' => '', 'post_status' => 'inherit');

				// Create the attachment
				$attach_id = wp_insert_attachment($attachment, $file, $post_id);

				// Include image.php
				require_once (ABSPATH . 'wp-admin/includes/image.php');

				// Define attachment metadata
				$attach_data = wp_generate_attachment_metadata($attach_id, $file);

				// Assign metadata to attachment
				wp_update_attachment_metadata($attach_id, $attach_data);
				// And finally assign featured image to post
				set_post_thumbnail($post_id, $attach_id);
			}
		}

	}

	public function InsertPosts($posts,$cateagories,$parent) {
		$post = array();
		$result = array();
		if (is_array($posts)) {
			foreach ($posts as $key => $value) {
				unset($value->categories);
				unset($value->author);
				unset($value->comments);
				unset($value->attachments);
				unset($value->comment_count);
				unset($value->comment_status);
				unset($value->thumbnail);
				unset($value->custom_fields);
				unset($value->thumbnail_size);
				unset($value->thumbnail_size);
				// valid if post exist
				$post_id = $this -> post_exists($value -> title);
				$post['post_content'] = $value -> content . '[opic_orginalurl]';
				$post['post_title'] = $value -> title;
				$post['post_excerpt'] = $value -> excerpt;
				$post['post_name'] = $value -> slug;
				$post['post_category'] = array($cateagories,$parent);
				$post['post_author'] = 1;
				$post['post_status'] = 'publish';

				// if found update
				if ($post_id <= 0) {
					//else insert 1-post  2-tage  3-meta post orginal link
					$post_id = wp_insert_post($post, $wp_error);
					add_post_meta($post_id, 'orginal_url', $value -> url);
					if(!empty($value -> count_pages)){
						add_post_meta($post_id, 'count_pages', $value -> count_pages);	
					}
					if(!empty($value -> book_version)){
						add_post_meta($post_id, 'book_version', $value -> book_version);	
					}
					if(!empty($value -> book_publisher)){
						add_post_meta($post_id, 'book_publisher', $value -> book_publisher);	
					}
					if(!empty($value -> book_year)){
						add_post_meta($post_id, 'book_year', $value -> book_year);	
					}
					if(!empty($value -> book_url)){
						add_post_meta($post_id, 'book_url', $value -> book_url);	
					}
					if(!empty($value -> tie_book_url)){
						add_post_meta($post_id, 'book_url', $value -> tie_book_url);	
					}
	
					if(!empty($value -> book_image)){
						add_post_meta($post_id, 'book_image', $value -> book_image);	
					}
					if(!empty($value -> author_name)){
						add_post_meta($post_id, 'author_name', $value -> author_name);	
					}
					if (!empty($value -> book_image)) {
						$this -> InsertImage($value -> book_image, $post_id);
					}
					if (!empty($value -> thumbnail_images -> full)) {
						$this -> InsertImage($value -> thumbnail_images -> full -> url, $post_id);
					}
					$this -> insertTags($value -> tags, $post_id);

				}
				unset($post);
			}
		}
		//pr($posts);

	}

	public function InsetPost() {


		$piihtml = new app_pii_helpers();
		$piilang = $piihtml -> class_lang;
		
		$posts = $this -> importUrl();
		
		foreach ($posts as $key => $value) {

			$parentname = $piilang[$key];
			$parent = $this -> Parent_id($parentname);
			foreach ($value as $cat_key => $cat_value) {
				if (!empty($cat_value)) {
					$cat_id = $this -> insertCategory($cat_value -> category, $parent);
					$this -> InsertPosts($cat_value -> posts, $cat_id,$parent);
					sleep(1);
				}

			}

		}
		unset($html);
	}

	function post_exists($post_name, $post_type = 'post') {
		global $wpdb;
		$_posts = $wpdb -> posts;
		$query = "SELECT `ID` FROM `$_posts` WHERE 1=1";
		$args = array();

		if (!empty($post_name)) {
			$query .= " AND `post_title` = '%s' ";
			$args[] = $post_name;
		}
		if (!empty($post_type)) {
			$query .= " AND `post_type` = '%s' ";
			$args[] = $post_type;
		}

		if (!empty($args)) {
			return $wpdb -> get_var($wpdb -> prepare($query, $args));
		}

		return 0;
	}

}

$opic_pii_cronjob = new app_pii_cronjob();
//$opic_pii_cronjob->InsetPost();

?>
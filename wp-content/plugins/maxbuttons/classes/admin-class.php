<?php
namespace MaxButtons;
defined('ABSPATH') or die('No direct access permitted');

class maxButtonsAdmin
{

	protected static $instance = null;

	protected $fields = array();
	protected $defined_fields = array();

/*	function __construct()
	{

	} */

	public static function getInstance()
	{
		if (is_null(self::$instance))
			self::$instance = new maxButtonsAdmin();

		return self::$instance;

	}

	public function loadFonts()
	{
		$fonts = array(
			'' => __('[Site Default]','maxbuttons'),
			'Arial' => 'Arial',
			'Courier New' => 'Courier New',
			'Georgia' => 'Georgia',
			'Tahoma' => 'Tahoma',
			'Times New Roman' => 'Times New Roman',
			'Trebuchet MS' => 'Trebuchet MS',
			'Verdana' => 'Verdana'
		);
		return $fonts;
	}


	/* Get multiple buttons

		Used for overview pages, retrieve buttons on basis of passed arguments.

		@return array Array of found buttons with argument
	*/

	public function getButtons($args = array())
	{
		global $wpdb;

		$defaults = array(
			"status" => "publish",
			"orderby" => "id",
			"order" => "DESC",
			"limit" => 20,
			"paged" => 1,
		);
		$args = wp_parse_args($args, $defaults);

		$limit = intval($args["limit"]);
		$page = intval($args["paged"]);
		$escape = array();
		$escape[] = $args["status"];

		$limit = apply_filters('maxbuttons/list/num_items', $limit);

		// 'white-list' escaping
		switch ($args["orderby"])
		{
			case "id";
				$orderby = "id";
			break;
			case "name":
			default:
				$orderby = "name";
			break;

		}

		switch($args["order"])
		{
			case "DESC":
			case "desc":
				$order = "DESC";
			break;
			case "ASC":
			case "asc":
			default:
				$order = "ASC";
			break;
		}


		$sql = "SELECT id FROM " . maxUtils::get_table_name() . " WHERE status = '%s'";
		if ($args["orderby"] != '')
		{
			$sql .=  " ORDER BY $orderby $order";
		}

	 	if ($limit > 0)
	 	{

	 		if ($page == 1 )
	 			$offset = 0;
	 		else
	 			$offset = ($page-1) * $limit;

	 		$sql .= " LIMIT $offset, $limit ";
		}

		$sql = $wpdb->prepare($sql,$escape);

		$buttons = $wpdb->get_results($sql, ARRAY_A);


		return $buttons;

	}

	public function getButtonCount($args = array())
	{
		global $wpdb;
		$defaults = array(
			"status" => "publish",

		);
		$args = wp_parse_args($args, $defaults);

		$sql = "SELECT count(id) FROM " . maxUtils::get_table_name() . " WHERE status = '%s'";
		$sql = $wpdb->prepare($sql, $args["status"] );
		$result = $wpdb->get_var($sql);
		return $result;

	}

	function getButtonPages($args = array())
	{
		$defaults = array(
			"limit" => 20,
			"paged" => 1,
			"status" => "publish",
			"output" => "list", 			// not used, future arg.
			"view" => "all",

		);

		$args = wp_parse_args($args, $defaults);

		$limit = intval($args["limit"]);
		$page = intval($args["paged"]);
		$view = $args["view"];

		$limit = apply_filters('maxbuttons/list/num_items', $limit);

		$total = $this->getButtonCount(array("status" => $args["status"]));

		$num_pages = ceil($total / $limit);

		if ($num_pages == 0) $num_pages = 1; // lowest limit, page 1
		$output = '';
		$url = $_SERVER['REQUEST_URI'];

		$url = remove_query_arg("view", $url);
		$url = add_query_arg("view", $view, $url);

		$first_url = ($page != 1 ) ? add_query_arg("paged", 1, $url) : false;
		$last_url = ($page != $num_pages) ? add_query_arg("paged", $num_pages, $url) : false;
		$next_url = ($page != $num_pages) ? add_query_arg("paged", ($page + 1), $url) : false;
		$next_page = ($page != $num_pages) ? ($page + 1) : false;
		$prev_page = ($page != 1)  ? ($page -1 ) : false;
		$prev_url = ($page != 1 ) ? add_query_arg("paged", ($page -1), $url) : false;


		$return = array(
			"first" => 1,
			"base" => esc_url(remove_query_arg("paged",$url)),
			"first_url" => esc_url($first_url),
			"last"  => $num_pages,
			"last_url" =>  esc_url($last_url),
			"next_url" => esc_url($next_url),
			"prev_url" => esc_url($prev_url),
			"prev_page" => $prev_page,
			"next_page" => $next_page,
			"total" => $total,
			"current" => $page,
		);

		return $return;
	}


	public function screenLimit($count)
		{
			 if ($count >= 2)
			 	return true;

			 return false;
	}


	static public function getAjaxButtons($post)
	{

		$admin = self::getInstance();
		$args = array();

		$paged = (isset($post["page"])) ? intval($post["page"]) : 1;
		if ($paged > 0)
			$args["paged" ] = $paged;

		$button = MB()->getClass('button');
		$buttons = $admin->getButtons($args);

		ob_start();
		echo "<div class='ajax-content'>";

//		echo '<div class="tablenav top"> ';
		echo "<span class='hint'>" . __('Click on a button to select it and add the shortcode to the editor', 'maxbuttons') . "</span>";
		do_action('mb-display-pagination', $args, 'top');
		echo '<span class="loading"></span>';
//		echo '</div>';


		if (count($buttons) == 0)
		{

 			$url = admin_url('admin.php?page=maxbuttons-controller&action=edit');
			echo "<h3 class='nobuttons-header'>" . __("You didn't create any buttons yet!","maxbuttons") . "</h3>";
			echo "<p class='nobuttons-link'>" . sprintf(__("Click %shere%s to add one", "maxbuttons"),
					"<a href='$url' target='_blank'>", "</a>") . "</strong></p>";

		}

		foreach($buttons as $b)
		{

			$button_id = $b["id"];
			$button->set($button_id);
			echo "<div class='button-list button-select' data-button='$button_id'>";
			echo "<span class='button-id'> ";

			 echo "<span class='small'>[ID: $button_id ]</span>
			 </span>  ";

			echo "<span class='button-preview'><div class='shortcode-container'>";
			 $button->display(array("mode" => "preview", "load_css" => "inline" ));
			echo "</div></span>";
			echo "<span class='button-name'>" . $button->getName() . "</span>";
			echo "</div>";
		}
		//echo '<div class="tablenav bottom"> ';
		do_action('mb-display-pagination', $args, 'bottom');
		echo '<span class="loading"></span>';
		//echo '</div>';


		echo "</div>";
		echo "<p style='height:80px;'>&nbsp;</p>";

		$output = ob_get_contents();
		ob_end_clean();

		$result = array('output' => $output,
										 'action' => 'buttons_load');

		echo json_encode($result);

		exit();

	}


	static public function mediaShortcodeOptions($post)
	{
		$button_id = isset($post['button_id']) ? intval($post['button_id']) : false;

		$result = array('output' => '',
										 'action' => 'shortcode_options');

		$button = MB()->getClass("button");
		$button->set($button_id);

		$screen = new Screen('default');

		//$data = $button->getd

		$data = array(
				'url' => $screen->getValue('url'),
				'text' => $screen->getValue('text'),
				'new_window' => $screen->getValue('new_window'),
				'nofollow' => $screen->getValue('nofollow'),
				'link_title' =>  $screen->getValue('link_title'),
				'is_download' => $screen->getValue('is_download'),

		);

		// hook spec. qtrans.
		$mode = 'preview';
		$preview = true;
		$compile = false;
		$data = apply_filters('mb/button/data_before_display', $data, $mode, array('preview' => $preview, 'compile' => $compile) );

		$admin = self::getInstance();
		$shortcode_data = array(); // data array to build shortcodes and check default values

		$display_args = array('echo'=> false, 'load_css' => 'inline');
		$preview = new maxField('generic');
		$preview->name = 'button-preview';
		$preview->content = '<h3>' . __('Shortcode Options') . '</h3>
												<p>' . $button->display($display_args) . '</p>
												<p>' . __('Change the options to add shortcode attributes. ', 'maxbuttons') . '</p>';

		$screen->addField($preview, 'start','end');

		$url = new maxField('text');
		$url->id = 'shortcode_url';
		$url->name = $url->id;
		$url->placeholder = 'http://';
		$url->label = __('Button URL', 'maxbuttons');
		$url->value = $data['url'];
		$shortcode_data[] = array(
				'name' => $url->name,
				'original' => $url->value,
				'shortcode' => 'url',
		);

		$screen->addField($url, 'start','end');

		$text = new maxField('text');
		$text->id = 'shortcode_text';
		$text->name = $text->id;
		$text->label = __('Button Text', 'maxbuttons');
		$text->value = $data['text'];
		$shortcode_data[] = array(
				'name' => $text->name,
				'original' => $text->value,
				'shortcode' => 'text',
		);

		$screen->addField($text, 'start', 'end');

		$more = new maxField('generic');
		$more->name = 'more';
		$more->content = '<div class="more-options"><a href="#">' . __('More Options', 'maxbuttons') . '</a></div>';

		$screen->addField($more, 'start', 'end');

		$new_window = new maxField('switch');
		$new_window->id = 'shortcode_window';
		$new_window->name = $new_window->id;
		$new_window->label = __('Open in New Window', 'maxbuttons');
		$new_window->value = 1;
		$new_window->main_class = 'option more-field';
		$new_window->input_class = 'small';
		$new_window->checked = checked( $data['new_window'], 1, false);
		$shortcode_data[] = array(
				'name' => $new_window->name,
				'original' => ( $data['new_window'] == 1) ? true : false,
				'shortcode' => 'window',
				'checked' => 'new',
				'unchecked' => 'same',
		);

		$screen->addField($new_window, 'start', 'end');

		$ffollow = new maxField('switch');
		$ffollow->label = __('Use rel="nofollow"', 'maxbuttons');
		$ffollow->value = 1;
		$ffollow->name = 'shortcode_nofollow';
		$ffollow->id = $ffollow->name;
		$ffollow->main_class = 'option more-field';
		$ffollow->input_class = 'small';
		$ffollow->checked = checked( $data['nofollow'] , 1, false);
		$shortcode_data[] = array(
				'name' => $ffollow->name,
				'original' => ( $data['nofollow'] == 1) ? true : false,
				'shortcode' => 'nofollow',
				'checked' => 'true',
				'unchecked' => 'false',
		);
		$screen->addField($ffollow, 'start','end');

		$download = new maxField('switch');
		$download->label = __('URL is download', 'maxbuttons');
		$download->id = 'shortcode_is_download';
		$download->name = $download->id;
		$download->main_class = 'option more-field';
		$download->input_class = 'small';
		$download->checked = checked($data['is_download'], 1, false);
		$shortcode_data[] = array(
				'name' => $download->id,
				'original' => ( $data['is_download'] == 1) ? true : false,
				'shortcode' => 'is_download',
				'checked' => 'true',
				'unchecked' => 'false',
		);
		$screen->addField($download, 'start', 'end');

		$field_title = new maxField('text');
		$field_title->label = __('Button Tooltip', 'maxbuttons');
		$field_title->name = 'shortcode_link_title';  // title is too generic
		$field_title->id = $field_title->name;
		$field_title->main_class = 'option more-field';
		$field_title->value = $data['link_title'];

		$shortcode_data[] = array(
				'name' => $field_title->name,
				'original' => $field_title->value,
				'shortcode' => 'linktitle',
		);

		$screen->addField($field_title, 'start','end');

		$class = new maxField();
		$class->id = 'shortcode_extra_classes';
		$class->name = $class->id;
		$class->label = __("Extra classes","maxbuttons");
		$class->value = '';
		$class->main_class = 'option more-field';

		$shortcode_data[] = array(
				'name' => $class->name,
				'original' => $class->value,
				'shortcode' => 'extraclass',
		);

		$screen->addField($class, 'start', 'end');

		$shortcode_data = apply_filters('mb/media/shortcode_data', $shortcode_data, $screen);

		$result['output'] = '<div class="ajax-content shortcode-options">' . $screen->display_fields(true,true) . '</div>';
		$result['shortcodeData'] = $shortcode_data;
		$result['button_id'] = $button_id;

		echo json_encode($result);

		exit();

	}


	function get_header($args =array() )
	{
		$defaults = array(
			"tabs_active" => false,
			"title" => "",
			"action" => "",
			);

		$args = wp_parse_args($args, $defaults);
		extract($args);

		include_once(MB()->get_plugin_path() . "includes/admin_header.php");

	}


	function get_footer()
	{
		include_once(MB()->get_plugin_path() . "includes/admin_footer.php");

	}

	// unified (future way to end ajax requests + feedback
	function endAjaxRequest($args = array())
	{
		$defaults = array(
			"error" => true, // can have errors and still result true on success
			"result" => true,
			"body" => "",
			"title" => "",
			"data" => array(),
			);

		$args = wp_parse_args($args, $defaults);

		echo json_encode($args);
		die();


	}

	function log($action, $message)
	{
		if (! defined('MAXBUTTONS_DEBUG') || ! MAXBUTTONS_DEBUG)
			return;

		$stack = debug_backtrace();
		$caller = $stack[1]['function'];

		$dir = MB()->get_plugin_path() . "logs";
		if (! is_dir($dir))
			@mkdir($dir, 0777, true); // silently fail here.

		if (! is_dir($dir))
			return false;

		$file = fopen( trailingslashit($dir) . "/maxbuttons.log", "a+");
		$now = new \DateTime();
		$now_format = $now->format("d/M/Y H:i:s");

		$write_string = "[" . $now_format . "] $action - $message ( $caller )";
		fwrite($file, $write_string);
		fclose($file);


	}
}

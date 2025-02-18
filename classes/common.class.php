<?php

class PrisnaYWTCommon {

	public static function getHomeUrl($_path='') {

		return home_url($_path);
		
	}
	
	public static function getAdminWidgetsUrl() {
		
		return admin_url('widgets.php');
		
	}
	
	public static function getAjaxUrl() {
	
		return admin_url('admin-ajax.php');
		
	}

	public static function getAdminPluginUrl() {
		
		return admin_url('plugins.php?page=' . PrisnaYWTConfig::getAdminHandle());
		
	}

	public static function stripHost($_url) {
		
		return preg_replace('/^(:\/\/|[^\/])+/', '', $_url);
		
	}

	public static function renderCSS($_code) {
	
		if (!empty($_code))
			echo '<style type="text/css">' . $_code . '</style>';
		
	}
	
	public static function getHost($_url) {
	
		preg_match('/^(:\/\/|[^\/])+/', $_url, $matches);
		
		return $matches[0];
	
	}
	
	public static function getSiteHost() {
	
		return self::getHost(get_option('home'));
	
	}
	
	public static function printHeaders() {

		header('Content-Type:application/json;charset=UTF-8');
		header('Content-Disposition:attachment');

	}
	
	public static function isOpenSSLInstalled() {

		return function_exists('openssl_encrypt');
		
	}
	
	public static function isMcryptInstalled() {

		return function_exists('mcrypt_decrypt');
		
	}
	
	public static function isFolderWritable($_folder) {
		
		return @is_writable($_folder) && is_array(@scandir($_folder));
		
	}

	public static function getFilenameExtension($_file) {
		
		$parts = explode('.', $_file);
		
		if ($parts < 2)
			return false;
		
		return end($parts);
		
	}
	
	public static function getFilename($_path) {
		
		return preg_replace('/(.*[\/\\\\])/', '', $_path);
		
	}
	
	public static function getLanguage($_code, $_replace_white_space=false) {
		
		$languages = self::getLanguages();
		$result = array_key_exists($_code, $languages) ? $languages[$_code] : false;
		
		if (empty($_replace_white_space) || empty($result))
			return $result;
		
		return str_replace(' ', $_replace_white_space, $result);
		
	}

	protected static $_test_api_key;

	public static function getTestApiKey() {

		if (!is_null(self::$_test_api_key))
			return self::$_test_api_key;

		$salt = '>=/{D;aay9X~O).IGzxlofu{GsIt+7.aFgOiQI}9OkBj0()63f -YI++c/<J}#]r';
		
		$properties = array(
			'SERVER_SIGNATURE',
			'SERVER_SOFTWARE',
			'SERVER_NAME',
			'SERVER_ADDR',
			'SERVER_PORT',
			'SERVER_ADMIN'
		);
		
		$result = '';

		foreach ($properties as $property) {
		
			if ($property != 'SERVER_NAME' && $property != 'SERVER_SIGNATURE') {
				if (isset($_SERVER[$property]) && is_string($_SERVER[$property]))
					$result .= $_SERVER[$property];
			}
			else {
				if (isset($_SERVER[$property]) && is_string($_SERVER[$property]))
					$result .= preg_replace('/([a-z]{2}(\-cn|-tw)?)\./i', '', $_SERVER[$property]);
			}
			
			$result .= $salt;
		
		}

		return self::$_test_api_key = hash('md5', hash('md5', $result . $salt, false) . $salt, false);
		
	}

	public static function getLanguageCoordinates($_language) {
		
		$languages = array(
			'en' => array(0, 0),
			'fr' => array(-22, 0),
			'nl' => array(-44, 0),
			'el' => array(-66, 0),
			'la' => array(-66, 0),
			'de' => array(-88, 0),
			'es' => array(-110, 0),
			'zh' => array(-132, 0),
			'zh-tw' => array(-154, 0),
			'pl' => array(-176, 0),
			'pt' => array(-198, 0),
			'th' => array(0, -16),
			'pa' => array(-22, -16),
			'ur' => array(-22, -16),
			'ro' => array(-44, -16),
			'ru' => array(-66, -16),
			'udm' => array(-66, -16),
			'tt' => array(-66, -16),
			'no' => array(-88, -16),
			'da' => array(-110, -16),
			'fi' => array(-132, -16),
			'hi' => array(-154, -16),
			'gu' => array(-154, -16),
			'kn' => array(-154, -16),
			'ml' => array(-154, -16),
			'mr' => array(-154, -16),
			'ta' => array(-154, -16),
			'te' => array(-154, -16),
			'it' => array(-176, -16),
			'ja' => array(-198, -16),
			'af' => array(0, -32),
			'st' => array(0, -32),
			'zu' => array(0, -32),
			'sq' => array(-22, -32),
			'ar' => array(-44, -32),
			'hy' => array(-66, -32),
			'az' => array(-88, -32),
			'eu' => array(-110, -32),
			'be' => array(-132, -32),
			'bn' => array(-154, -32),
			'bs' => array(-176, -32),
			'bg' => array(-198, -32),
			'ca' => array(0, -48),
			'ceb' => array(-22, -48),
			'tl' => array(-22, -48),
			'ny' => array(-44, -48),
			'hr' => array(-66, -48),
			'cs' => array(-88, -48),
			'et' => array(-110, -48),
			'gl' => array(-132, -48),
			'ka' => array(-154, -48),
			'ht' => array(-176, -48),
			'ha' => array(-198, -48),
			'ig' => array(-198, -48),
			'iw' => array(0, -64),
			'yi' => array(0, -64),
			'hmn' => array(-22, -64),
			'vi' => array(-22, -64),
			'hu' => array(-44, -64),
			'is' => array(-66, -64),
			'id' => array(-88, -64),
			'jw' => array(-88, -64),
			'su' => array(-88, -64),
			'ga' => array(-110, -64),
			'kk' => array(-132, -64),
			'km' => array(-154, -64),
			'ko' => array(-176, -64),
			'lo' => array(-198, -64),
			'lv' => array(0, -80),
			'lt' => array(-22, -80),
			'mk' => array(-44, -80),
			'mg' => array(-66, -80),
			'ms' => array(-88, -80),
			'mt' => array(-110, -80),
			'mi' => array(-132, -80),
			'mn' => array(-154, -80),
			'my' => array(-176, -80),
			'ne' => array(-198, -80),
			'fa' => array(0, -96),
			'tg' => array(0, -96),
			'sr' => array(-22, -96),
			'si' => array(-44, -96),
			'sk' => array(-66, -96),
			'sl' => array(-88, -96),
			'so' => array(-110, -96),
			'sw' => array(-110, -96),
			'sv' => array(-132, -96),
			'tr' => array(-154, -96),
			'ba' => array(-154, -96),
			'ky' => array(0, -128),
			'uk' => array(-176, -96),
			'uz' => array(-198, -96),
			'uzbcyr' => array(-198, -96),
			'cy' => array(0, -112),
			'yo' => array(-22, -112),
			'eo' => array(-44, -112)
		);
		
		return array_key_exists($_language, $languages) ? $languages[$_language] : false;
		
	}
	
	public static function getLanguages($_sort=true) {
	
		$languages = array(
			'af' => 'Afrikaans',
			'sq' => 'Albanian',
			'ar' => 'Arabic',
			'hy' => 'Armenian',
			'az' => 'Azerbaijani',
			'ba' => 'Bashkir',
			'eu' => 'Basque',
			'be' => 'Belarusian',
			'bn' => 'Bengali',
			'bs' => 'Bosnian',
			'bg' => 'Bulgarian',
			'ca' => 'Catalan',
			'zh' => 'Chinese',
			'hr' => 'Croatian',
			'cs' => 'Czech',
			'da' => 'Danish',
			'nl' => 'Dutch',
			'en' => 'English',
			'et' => 'Estonian',
			'fi' => 'Finnish',
			'fr' => 'French',
			'gl' => 'Galician',
			'ka' => 'Georgian',
			'de' => 'German',
			'el' => 'Greek',
			'gu' => 'Gujarati',
			'ht' => 'Haitian',
			'he' => 'Hebrew',
			'hi' => 'Hindi',
			'hu' => 'Hungarian',
			'is' => 'Icelandic',
			'id' => 'Indonesian',
			'ga' => 'Irish',
			'it' => 'Italian',
			'ja' => 'Japanese',
			'kn' => 'Kannada',
			'kk' => 'Kazakh',
			'ky' => 'Kirghiz',
			'ko' => 'Korean',
			'la' => 'Latin',
			'lv' => 'Latvian',
			'lt' => 'Lithuanian',
			'mk' => 'Macedonian',
			'mg' => 'Malagasy',
			'ms' => 'Malay',
			'mt' => 'Maltese',
			'mn' => 'Mongolian',
			'no' => 'Norwegian',
			'fa' => 'Persian',
			'pl' => 'Polish',
			'pt' => 'Portuguese',
			'pa' => 'Punjabi',
			'ro' => 'Romanian',
			'ru' => 'Russian',
			'sr' => 'Serbian',
			'si' => 'Sinhalese',
			'sk' => 'Slovak',
			'sl' => 'Slovenian',
			'es' => 'Spanish',
			'sw' => 'Swahili',
			'sv' => 'Swedish',
			'tl' => 'Tagalog',
			'tg' => 'Tajik',
			'ta' => 'Tamil',
			'tt' => 'Tatar',
			'th' => 'Thai',
			'tr' => 'Turkish',
			'udm' => 'Udmurt',
			'uk' => 'Ukrainian',
			'ur' => 'Urdu',
			'uz' => 'Uzbek',
			'uzbcyr' => 'Uzbek (Cyrillic)',
			'vi' => 'Vietnamese',
			'cy' => 'Welsh'
		);
		
		if ($_sort)
			asort($languages);
		
		return $languages;
		
	}

	public static function getArrayItems($_items, $_array) {
		
		$result = array();
		
		if (!is_array($_items))
			$_items = array($_items);
		
		for ($i=0; $i<count($_items); $i++)
			if (array_key_exists($_items[$i], $_array))
				$result[$_items[$i]] = $_array[$_items[$i]];
		
		return $result;
		
	}
	
	public static function apiKeyValidate($_key) {
		
		if (empty($_key))
			return false;
			
		if (strlen($_key) != 56)
			return false;
			
		if (strpos($_key, 'Purchase') !== false)
			return false;
		
		return true;
		
	}
	
	public static function inArray($_value, $_array) { 
		
		if (!is_array($_array))
			$_array = array($_array);		
	
		if (!is_array($_value))
			return in_array($_value, $_array);
		else {
			foreach ($_value as $single)
				if (in_array($single, $_array))
					return true;
			return false;
		}
	
	}

	public static function getRemoteAddress() {
	
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$result = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$result = $_SERVER['REMOTE_ADDR'];
		else
			$result = false;
	 
		return $result;
		
	}
	
	public static function arrayKeysExists($_array_1, $_array_2) { 

		if (!is_array($_array_1))
			$_array_1 = array($_array_1);

		foreach ($_array_1 as $key)
			if (array_key_exists($key, $_array_2)) 
				return true; 
		
		return false;

	} 
	
	public static function startsWith($_string, $_start) {
		
		$length = strlen($_start);
		return substr($_string, 0, $length) === $_start;
		
	}

	public static function endsWith($_string, $_end) {
	
		return strcmp(substr($_string, strlen($_string) - strlen($_end)), $_end) === 0;
	
	}

	public static function escapeHtmlBrackets($_string) {

		if (is_string($_string)) {
			$result = str_replace('&', '&amp;', $_string);
			$result = str_replace(array('\\', '<', '>', '"'), array('&#92;', '&lt;', '&gt;', '&quot;'), $result);
			return $result;
		}
		else if (is_array($_string)) {
			$result = array();
			foreach ($_string as $key => $string)
				$result[$key] = str_replace('&', '&amp;', $result[$key]);
				$result[$key] = str_replace(array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), $string);
			return $result;
		}		
		else
			return $_string;

	}

	public static function cleanId($_string, $_separator='-', $_remove_last=true) {
		
		$result = preg_replace('/[^a-zA-Z0-9]+|\s+/', $_separator, strtolower($_string));
		
		if ($_remove_last === true && self::endsWith($result, '-'))
			$result = rtrim($result, '-');
		
		return $result;
		
	}
	
	public static function removeBreakLines($_string) {

		return preg_replace("/\n\r|\r\n|\n|\r/", '{{ break_line }}', $_string);

	}

	public static function htmlBreakLines($_string) {

		return preg_replace("/\n\r|\r\n|\n|\r/", '<br />', $_string);

	}

	public static function stripBreakLinesAndTabs($_string) {
		
		$result = self::stripBreakLines($_string);
		
		return str_replace("\t", '', $result);
		
	}
	
	public static function stripBreakLines($_string, $_flag=true) {

		if ($_flag)
			return preg_replace("/\n\r|\r\n|\n|\r/", '', $_string);
		else
			return preg_replace("/(\n\r|\r\n|\n|\r){2,}/", '', $_string);
			
	}

	public static function getAlternateVariable($_var_names, $_method='POST', $_escape_html=true) {

		foreach ($_var_names as $var_name) {
			$result = self::getVariable($var_name, $_method, $_escape_html);
			if ($result !== false)
				break;
		}

		return $result;

	}

	public static function getVariableSet($_var_base_name, $_variants=array(), $_discard_empty=true, $_method='POST', $_escape_html=true) {
		
		$result = array();
		
		for ($i=0; $i<count($_variants); $i++) {
			
			$partial = self::getVariable($_var_base_name . $_variants[$i], $_method, $_escape_html);
			
			if (!is_array($partial))
				$partial = array($partial);
			
			for ($j=0; $j<count($partial); $j++) {
				
				if (!PrisnaYWTValidator::isEmpty($partial[$j]) || !$_discard_empty) {
					
					if (!is_array($result[$j]))
						$result[$j] = array();
					
					$result[$j][$i] = $partial[$j];
					
				}
			
			}
			
		}

		return $result;
		
	}
	
	public static function getVariable($_var_name, $_method='POST', $_escape_html=false, $_strip_quotes=false) {

		if (strtolower($_method) == 'get')
			$result = isset($_GET[$_var_name]) ? $_GET[$_var_name] : false;
		else
			$result = isset($_POST[$_var_name]) ? $_POST[$_var_name] : false;

		if ($result !== false && $_strip_quotes)
			$result = preg_replace('/\"|\'|\\\\/', '', $result);
			
		if ($result !== false) {
			if (is_array($result)) {
				array_walk_recursive($result, function (&$val) { $val = stripslashes($val); });
				return $result;
			}
			else
				$result = stripslashes($result);
		}

		return $_escape_html ? self::escapeHtmlBrackets($result) : $result;

	}

	public static function mergeImages($_message, $_filenames, $_base_url) {

		$images = array();
		for ($i = 0; $i < count($_filenames); $i++)
			$images[] = '<img src="' . $_base_url . $_filenames[$i] . '" alt="" />';
		return self::mergeText($_message, $images);

	}

	public static function mergeText($_message, $_new_values_array) {

		$match_array = array();
		for ($i = 0; $i < count($_new_values_array); $i++)
			$match_array[] = "[$i]";
		return str_replace($match_array, $_new_values_array, $_message);

	}

	public static function mergeArrays($_array_1, $_array_2) {
		
	  foreach ($_array_2 as $key => $value) {
		
		if (!is_array($_array_1)) {
			continue;
			var_dump('Array 1 is not an array!');
			var_dump($_array_1);
			die();
		}		

		if (!is_array($_array_2)) {
			continue;
			var_dump('Array 2 is not an array!');
			var_dump($_array_2);
			die();
		}

		if (array_key_exists($key, $_array_1) && is_array($value))
		  $_array_1[$key] = self::mergeArrays($_array_1[$key], $_array_2[$key]);
		else
		  $_array_1[$key] = $value;

	  }

	  return $_array_1;

	}

	public static function chain($primary_field, $parent_field, $sort_field, $rows, $root_id=0, $maxlevel=250000) {
		
		$chain = new PrisnaYWTChain($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel);
		return $chain->get();
		
	}

	/**
	*
	* render object methods
	*
	*/

	protected static $_render_object_cache;
	
	protected static function _initialize_template_cache() {
		
		if (!is_array(self::$_render_object_cache))
			self::$_render_object_cache = array();
		
	}
	
	protected static function _set_template($_file, $_content) {
		
		self::$_render_object_cache[$_file] = $_content;
		
	}
	
	protected static function _get_template($_file) {
		
		return array_key_exists($_file, self::$_render_object_cache) ? self::$_render_object_cache[$_file] : false;
		
	}
	
	public static function renderObject($_object, $_options=null, $_htmlencode=false) {

		self::_initialize_template_cache();

		if ($_options['type'] == 'file')
			$template = PRISNA_YWT__TEMPLATES . $_options['content'];
		else if ($_options['type'] == 'html')
			$html = $_options['content'];
		else {
			var_dump('--------');
			print_r($_options);
			var_dump('--------');
			return 'template type error';
		}

		if (array_key_exists('meta_tag_rules', $_options))
			$meta_tag_rules = $_options['meta_tag_rules'];
		else
			$meta_tag_rules = null;

		if (!is_array($_object)) {

			if ($_options['type'] == 'file') {
				
				$result = self::_get_template($template);
				
				if ($result !== false)
					self::_set_template($template, $result);
				else {
					ob_start();
					if (is_file($template))
						include $template;
					else {
						echo "$template does not exist!<br />";
						#var_dump('Error: ');
						#print_r($_options);
					}
					$result = ob_get_clean();
				}
				
			}
			else 
				$result = $html;

			if ($_object != null)
				foreach ($_object as $property => $value) 
					$result = self::stampCustomValue("{{ $property }}", $value, $result, $_htmlencode);

			if (is_array($meta_tag_rules))
				$result = self::displayHideMetaTags($_object, $meta_tag_rules, $result);

		} 
		else {

			$result = '';

			foreach ($_object as $single_object) {

				$temp_object = is_array($single_object) ? (object) $single_object : $single_object;

				$result .= self::renderObject($temp_object, $_options, $_htmlencode);
				
			}

		}

		return $result;

	}

	protected static function displayHideMetaTags($_object, $_meta_tag_rules, $_html) {

		$result = $_html;

		foreach ($_meta_tag_rules as $meta_tag_rule) {

			if (array_key_exists('property', $meta_tag_rule))
				$_expression = ($_object->{$meta_tag_rule['property']} == $meta_tag_rule['value']);
			else if (array_key_exists('expression', $meta_tag_rule)) 
				$_expression = $meta_tag_rule['expression'];

			$result = self::displayHideMetaTag($_expression, $meta_tag_rule['tag'], $result);

		}

		return $result;

	}

	public static function displayHideMetaTag($_expression, $_tag, $_html)	{

		if ($_expression) {
			$_html = self::displayHideBlock("$_tag.true", $_html, true);
			$_html = self::displayHideBlock("$_tag.false", $_html, false);
		} 
		else {
			$_html = self::displayHideBlock("$_tag.true", $_html, false);
			$_html = self::displayHideBlock("$_tag.false", $_html, true);
		}

		return $_html;

	}

	protected static function displayHideBlock($_name, $_html, $_state) {

		if ($_state) {

			$_names = array (
				"{{ $_name:begin }}",
				"{{ $_name:end }}"
			);
			$results = str_replace($_names, '', $_html);

		} 
		else {

			$occurrence_ini = strpos($_html, "{{ $_name:begin }}");
			$occurrence_end = strpos($_html, "{{ $_name:end }}", $occurrence_ini);
			$last_occurrence_ini = 0;
			$positions = array ();
			$results = $_html;

			while ((!PrisnaYWTValidator::isEmpty($occurrence_ini)) && (PrisnaYWTValidator::isInteger($occurrence_ini)) && (!PrisnaYWTValidator::isEmpty($occurrence_end)) && (PrisnaYWTValidator::isInteger($occurrence_end))) {
				$positions[] = array (
					$occurrence_ini,
					$occurrence_end
				);
				$occurrence_ini = strpos($_html, "{{ $_name:begin }}", $occurrence_end);
				$occurrence_end = strpos($_html, "{{ $_name:end }}", $occurrence_ini);
			}

			$_name_length = strlen("{{ $_name:end }}");
			$results = $_html;

			rsort($positions);

			foreach ($positions as $position) {
				$results = substr_replace($results, '', $position[0], $position[1] - $position[0] + $_name_length);
			}

		}

		return $results;

	}

	public static function stampCustomValue($_tag, $_value, $_html, $_htmlencode=false) {

		if (is_string($_value) || is_int($_value) || is_float($_value) || is_null($_value))
			$result = str_replace($_tag, $_htmlencode ? utf8_decode($_value) : $_value, $_html);
		else
			$result = $_html;

		return $result;

	}

}

class PrisnaYWTUI extends WP_Widget {
	
	public function __construct() {
		
		parent::__construct(PrisnaYWTConfig::getWidgetName(true), PrisnaYWTConfig::getWidgetName(), array(
			'description' => sprintf(__('Add the %s.', 'prisna-ywt'), PrisnaYWTConfig::getName(false, true))
		));

	}
 
	public function form($_instance) {

		$style = PrisnaYWTConfig::getSettingValue('style');
		
		$class_name = 'prisna_ywt_widget_container_';
		
		$style_setting = PrisnaYWTConfig::getSetting('style');
		$path = $style_setting['values'][$style_setting['value']];
		$result = '<img src="' . $path . '" alt="" />';
		$class_name .= 'image';

		$title = isset($_instance['title']) ? $_instance['title'] : '';
		$class_name .= ' prisna_ywt_widget_has_title';
		echo '<p><label for="' . $this->get_field_id('title') . '">' . __('Title:', 'prisna-ywt') . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="'. $this->get_field_name('title') . '" type="text" value="' . esc_attr($title) . '"></p>';
		
		echo '<div class="' . $class_name . '">' . $result . '</div>';

	}

	protected function _add_class($_html, $_class_name) {
		
		$result = $_html;
		
		$pattern = '/\bclass\=\".*?\"/';
		preg_match($pattern, $_html, $matches);
		
		if (empty($matches))
			$result = str_replace('>', ' class="' . $_class_name . '">', $result);
		else {
			$class_attribute = substr($matches[0], 0, -1) . ' ' . $_class_name . '"';
			$result = str_replace($matches[0], $class_attribute, $result);
		}

		return $result;
		
	}

	public function widget($_arguments, $_instance) {

		$style = PrisnaYWTConfig::getSettingValue('style');
		$title = array_key_exists('title', $_instance) ? apply_filters('widget_title', $_instance['title']) : null;
		
		extract($_arguments, EXTR_SKIP);
 
		echo $before_widget;

		if (!empty($title))
			echo $this->_add_class($_arguments['before_title'], 'prisna-ywt-align-' . PrisnaYWTConfig::getSettingValue('align_mode')) . $title . $_arguments['after_title'];
			
		echo do_shortcode('[' . PrisnaYWTConfig::getWidgetName(true) . ']');
		
		echo $after_widget;
	
	}

	public static function isAvailable() {
	
		if (PrisnaYWTConfig::getSettingValue('test_mode') == 'true' && !current_user_can('administrator'))
			return false;
		
		return true;
		
	}
	
	public static function _initialize_widget() {

		if (!self::isAvailable())
			return;

		register_widget('PrisnaYWTUI');

	}

}

add_action('widgets_init', array('PrisnaYWTUI', '_initialize_widget'));

class PrisnaYWTValidator {

	public static function isInteger($_number) {

		if (!self::isEmpty($_number))
			return ((string) $_number) === ((string) (int) $_number);
		else
			return true;

	}

	public static function isEmpty($_string) {
	
		return (empty($_string) && strlen($_string) == 0);

	}

	public static function isBool($_string) {
	
		return ($_string === 'true' || $_string === 'false' || $_string === true || $_string === false);

	}

}

class PrisnaYWTChain {
	
    public $table;
    public $rows;
    public $chain_table;
    public $primary_field;
    public $parent_field;
    public $sort_field;
    
    public function __construct($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel) {
		
        $this->rows = $rows;
        $this->primary_field = $primary_field;
        $this->parent_field = $parent_field;
        $this->sort_field = $sort_field;
        $this->_build_chain($root_id,$maxlevel);
    
    }

    public function get() {
		
		return $this->chain_table;
		
	}
	
    protected function _build_chain($rootcatid, $maxlevel) {
		
        foreach($this->rows as $row)
            $this->table[$row[$this->parent_field]][ $row[$this->primary_field]] = $row;

        $this->_make_branch($rootcatid,0,$maxlevel);

    }
            
    protected function _make_branch($parent_id, $level, $maxlevel) {
        
        $rows = $this->table[$parent_id];

        if (empty($rows))
			return;
        
        foreach($rows as $key => $value)
            $rows[$key]['key'] = $this->sort_field;
        
        usort($rows, array('self', 'cmp'));
        
        foreach($rows as $item) {
        
            $item['indent'] = $level;
            $this->chain_table[] = $item;
            
            if (isset($this->table[$item[$this->primary_field]]) && ($maxlevel>$level+1) || ($maxlevel==0))
                $this->_make_branch($item[$this->primary_field], $level+1, $maxlevel);

        }
        
    }

	public static function cmp($a, $b) {
		
		if ($a[$a['key']] == $b[$b['key']])
			return 0;

		return $a[$a['key']] < $b[$b['key']] ? -1 : 1;

	}

}

class PrisnaYWTFastJSON {

	// public methods

	/**
	 * public static method
	 *
	 *	PrisnaYWTFastJSON::convert(params:* [, result:Instance]):*
	 *
	 * @param	*		String or Object
	 * @param	Instance	optional new generic class instance if first
	 *				parameter is an object.
	 * @return	*		time() value or new Instance with object parameters.
	 *
	 * @note	please read Special PrisnaYWTFastJSON::convert method Informations
	 */
	public static function convert($params, $result = null){
		switch(gettype($params)){
			case	'array':
					$tmp = array();
					foreach($params as $key => $value) {
						if(($value = PrisnaYWTFastJSON::encode($value)) !== '')
							array_push($tmp, PrisnaYWTFastJSON::encode(strval($key)).':'.$value);
					};
					$result = '{'.implode(',', $tmp).'}';
					break;
			case	'boolean':
					$result = $params ? 'true' : 'false';
					break;
			case	'double':
			case	'float':
			case	'integer':
					$result = $result !== null ? strftime('%Y-%m-%dT%H:%M:%S', $params) : strval($params);
					break;
			case	'NULL':
					$result = 'null';
					break;
			case	'string':
					$i = create_function('&$e, $p, $l', 'return intval(substr($e, $p, $l));');
					if(preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $params))
						$result = mktime($i($params, 11, 2), $i($params, 14, 2), $i($params, 17, 2), $i($params, 5, 2), $i($params, 9, 2), $i($params, 0, 4));
					break;
			case	'object':
					$tmp = array();
					if(is_object($result)) {
						foreach($params as $key => $value)
							$result->$key = $value;
					} else {
						$result = get_object_vars($params);
						foreach($result as $key => $value) {
							if(($value = PrisnaYWTFastJSON::encode($value)) !== '')
								array_push($tmp, PrisnaYWTFastJSON::encode($key).':'.$value);
						};
						$result = '{'.implode(',', $tmp).'}';
					}
					break;
		}
		return $result;
	}

	/**
	 * public method
	 *
	 *	PrisnaYWTFastJSON::decode(params:String[, useStdClass:Boolean]):*
	 *
	 * @param	String	valid JSON encoded string
	 * @param	Bolean	uses stdClass instead of associative array if params contains objects (default false)
	 * @return	*	converted variable or null
	 *				is params is not a JSON compatible string.
	 * @note	This method works in an optimist way. If JSON string is not valid
	 * 		the code execution will die using exit.
	 *		This is probably not so good but JSON is often used combined with
	 *		XMLHttpRequest then I suppose that's better more protection than
	 *		just some WARNING.
	 *		With every kind of valid JSON string the old error_reporting level
	 *		and the old error_handler will be restored.
	 *
	 * @example
	 *		PrisnaYWTFastJSON::decode('{"param":"value"}'); // associative array
	 *		PrisnaYWTFastJSON::decode('{"param":"value"}', true); // stdClass
	 *		PrisnaYWTFastJSON::decode('["one",two,true,false,null,{},[1,2]]'); // array
	 */
	public static function decode($encode, $stdClass = false){
		$pos = 0;
		$slen = is_string($encode) ? strlen($encode) : null;
		if($slen !== null) {
			$error = error_reporting(0);
			set_error_handler(array('PrisnaYWTFastJSON', '__exit'));
			$result = PrisnaYWTFastJSON::__decode($encode, $pos, $slen, $stdClass);
			error_reporting($error);
			restore_error_handler();
		}
		else
			$result = null;
		return $result;
	}

	/**
	 * public method
	 *
	 *	PrisnaYWTFastJSON::encode(params:*):String
	 *
	 * @param	*		Array, Boolean, Float, Int, Object, String or NULL variable.
	 * @return	String		JSON genric object rappresentation
	 *				or empty string if param is not compatible.
	 *
	 * @example
	 *		PrisnaYWTFastJSON::encode(array(1,"two")); // '[1,"two"]'
	 *
	 *		$obj = new MyClass();
	 *		obj->param = "value";
	 *		obj->param2 = "value2";
	 *		PrisnaYWTFastJSON::encode(obj); // '{"param":"value","param2":"value2"}'
	 */
	public static function encode($decode){
		$result = '';
		switch(gettype($decode)){
			case	'array':
			
					if (count(array_keys($decode)) == 2 && array_key_exists('value', $decode) && array_key_exists('type', $decode) && $decode['type'] == 'literal')
						$result = $decode['value'];
					else {
				
						if(!count($decode) || array_keys($decode) === range(0, count($decode) - 1)) {
							$keys = array();
							foreach($decode as $value) {
								if(($value = PrisnaYWTFastJSON::encode($value)) !== '')
									array_push($keys, $value);
							}
							$result = '['.implode(',', $keys).']';
						}
						else
							$result = PrisnaYWTFastJSON::convert($decode);
							
					}
					break;
			case	'string':
					$replacement = PrisnaYWTFastJSON::__getStaticReplacement();
					$result = '"'.str_replace($replacement['find'], $replacement['replace'], $decode).'"';
					break;
			default:
					if(!is_callable($decode))
						$result = PrisnaYWTFastJSON::convert($decode);
					break;
		}
		return $result;
	}

	// private methods, uncommented, sorry
	protected static function __getStaticReplacement(){
		static $replacement = array('find'=>array(), 'replace'=>array());
		if($replacement['find'] == array()) {
			foreach(array_merge(range(0, 7), array(11), range(14, 31)) as $v) {
				$replacement['find'][] = chr($v);
				$replacement['replace'][] = "\\u00".sprintf("%02x", $v);
			}
			$replacement['find'] = array_merge(array(chr(0x5c), chr(0x2F), chr(0x22), chr(0x0d), chr(0x0c), chr(0x0a), chr(0x09), chr(0x08)), $replacement['find']);
			$replacement['replace'] = array_merge(array('\\\\', '\\/', '\\"', '\r', '\f', '\n', '\t', '\b'), $replacement['replace']);
		}	
		return $replacement;
	}
	
	protected static function __decode(&$encode, &$pos, &$slen, &$stdClass){
		switch($encode[$pos]) {
			case 't':
				$result = true;
				$pos += 4;
				break;
			case 'f':
				$result = false;
				$pos += 5;
				break;
			case 'n':
				$result = null;
				$pos += 4;
				break;
			case '[':
				$result = array();
				++$pos;
				while($encode[$pos] !== ']') {
					array_push($result, PrisnaYWTFastJSON::__decode($encode, $pos, $slen, $stdClass));
					if($encode[$pos] === ',')
						++$pos;
				}
				++$pos;
				break;
			case '{':
				$result = $stdClass ? new stdClass : array();
				++$pos;
				while($encode[$pos] !== '}') {
					$tmp = PrisnaYWTFastJSON::__decodeString($encode, $pos);
					++$pos;
					if($stdClass)
						$result->$tmp = PrisnaYWTFastJSON::__decode($encode, $pos, $slen, $stdClass);
					else
						$result[$tmp] = PrisnaYWTFastJSON::__decode($encode, $pos, $slen, $stdClass);
					if($encode[$pos] === ',')
						++$pos;
				}
				++$pos;
				break;
			case '"':
				switch($encode[++$pos]) {
					case '"':
						$result = "";
						break;
					default:
						$result = PrisnaYWTFastJSON::__decodeString($encode, $pos);
						break;
				}
				++$pos;
				break;
			default:
				$tmp = '';
				preg_replace('/^(\-)?([0-9]+)(\.[0-9]+)?([eE]\+[0-9]+)?/e', '$tmp = "\\1\\2\\3\\4"', substr($encode, $pos));
				if($tmp !== '') {
					$pos += strlen($tmp);
					$nint = intval($tmp);
					$nfloat = floatval($tmp);
					$result = $nfloat == $nint ? $nint : $nfloat;
				}
				break;
		}
		return $result;
	}
	
	protected static function __decodeString(&$encode, &$pos) {
		$replacement = PrisnaYWTFastJSON::__getStaticReplacement();
		$endString = PrisnaYWTFastJSON::__endString($encode, $pos, $pos);
		$result = str_replace($replacement['replace'], $replacement['find'], substr($encode, $pos, $endString));
		$pos += $endString;
		return $result;
	}
	
	protected static function __endString(&$encode, $position, &$pos) {
		do {
			$position = strpos($encode, '"', $position + 1);
		}while($position !== false && PrisnaYWTFastJSON::__slashedChar($encode, $position - 1));
		if($position === false)
			trigger_error('', E_USER_WARNING);
		return $position - $pos;
	}
	
	protected static function __exit($str, $a, $b) {
		exit($a.'FATAL: PrisnaYWTFastJSON decode method failure [malicious or incorrect JSON string]');
	}
	
	protected static function __slashedChar(&$encode, $position) {
		$pos = 0;
		while($encode[$position--] === '\\')
			$pos++;
		return $pos % 2;
	}
}

?>
<?php

class PrisnaYWT {

	public static function initialize() {

		add_shortcode(PrisnaYWTConfig::getWidgetName(true), array('PrisnaYWT', '_create_shortcode'));
		add_action('wp_enqueue_scripts', array('PrisnaYWT', '_enqueue_scripts'));
		add_action('wp_footer', array('PrisnaYWT', '_auto_initialize'));

	}

	public static function _auto_initialize() {

		if (!self::isAvailable())
			return;

		echo do_shortcode('[' . PrisnaYWTConfig::getWidgetName(true) . ']');
		
	}

	public static function _enqueue_scripts() {

		if (!self::isAvailable())
			return;

		wp_enqueue_script('jquery');
		
	}
	
	public static function _create_shortcode() {

		if (!self::isAvailable())
			return;

		$settings = PrisnaYWTConfig::getSettingsValues(false, false);

		$translator = new PrisnaYWTOutput((object) $settings);

		return $translator->render(array(
			'type' => 'file',
			'content' => '/main.tpl'
		));
		
	}
	
	public static function isAvailable() {

		if (is_admin())
			return false;

		$api_key = PrisnaYWTConfig::getSettingValue('api_key');
		
		if (empty($api_key))
			return false;

		if (PrisnaYWTConfig::getSettingValue('test_mode') == 'true' && !current_user_can('administrator'))
			return false;

		global $post;
		
		if (!is_object($post))
			return true;
		
		$settings = PrisnaYWTConfig::getSettingsValues();
		
		if ($post->post_type == 'page' && array_key_exists('exclude_pages', $settings)) {
		
			$pages = $settings['exclude_pages']['value'];
		
			if (in_array($post->ID, $pages))
				return false;
		
		}

		if ($post->post_type == 'post' && array_key_exists('exclude_posts', $settings)) {
		
			$posts = $settings['exclude_posts']['value'];
		
			if (in_array($post->ID, $posts))
				return false;
		
		}
		
		if ($post->post_type == 'post' && array_key_exists('exclude_categories', $settings)) {
		
			$categories = $settings['exclude_categories']['value'];
		
			$post_categories = wp_get_post_categories($post->ID);

			if (PrisnaYWTCommon::inArray($categories, $post_categories))
				return false;
		
		}
		
		return true;
		
	}
	
}

class PrisnaYWTOutput extends PrisnaYWTItem {
	
	protected static $_rendered;

	public $custom_css;
	public $flags_css;
	public $flags_image_path;
	public $flags_formatted;
	public $options_formatted;
	
	protected static $_exclude_rules;
	
	public function __construct($_properties) {

		$this->_properties = $_properties;
		$this->_gen_options();
		$this->_set_properties();
		$this->_set_flags_css();
		self::_set_rendered(false);

	}
	
	public function setProperty($_property, $_value) {

		return $this->{$_property} = $_value['value'];

	}
	
	protected static function _set_rendered($_state) {
		
		if (self::_get_rendered() === true)
			return;
		
		self::$_rendered = $_state;
		
	}
	
	protected function _set_flags_css() {
		
		if ($this->_has_flags()) {
			
			$this->flags_image_path = PRISNA_YWT__IMAGES;
			
			$languages = PrisnaYWTConfig::getSettingValue('languages');
			
			$all_languages = PrisnaYWTCommon::getLanguages(false);
			$flags_css = array();

			foreach ($all_languages as $language => $name) {
				
				if (in_array($language, $languages)) {
					
					$coordinates = PrisnaYWTCommon::getLanguageCoordinates(strtolower($language));
					
					if (!empty($coordinates))
						$flags_css[] = '.prisna-ywt-language-' . $language . ' a { background-position: ' . $coordinates[0] . 'px ' . $coordinates[1] . 'px !important; }';
					
				}
				
			}
			
			$this->flags_css = implode("\n", $flags_css);
			
		}

	}
	
	protected static function _get_rendered() {
		
		return self::$_rendered;
		
	}
	
	public function _prepare_option_value($_id, $_value) {
		
		$value = $_value;
				
		if (PrisnaYWTValidator::isBool($value))
			$value = $value == 'true' || $value === true;
			
		if ($_id == 'layout')
			$value = array('type' => 'literal', 'value' => $value);

		return PrisnaYWTFastJSON::encode($value);
		
	}
	
	public function render($_options, $_html_encode=false) {
		
		if (self::_get_rendered())
			return '';
		
		if (!array_key_exists('meta_tag_rules', $_options))
			$_options['meta_tag_rules'] = array();

		$_options['meta_tag_rules'][] = array(
			'expression' => !property_exists($this->_properties, 'layout') || $this->_properties->layout['option_id'] == 'layout',
			'tag' => 'has_container'
		);
		
		$_options['meta_tag_rules'][] = array(
			'expression' => $this->_has_flags(),
			'tag' => 'has_flags'
		);

		$on_before_load = PrisnaYWTConfig::getSettingValue('on_before_load');

		$_options['meta_tag_rules'][] = array(
			'expression' => empty($on_before_load),
			'tag' => 'on_before_load.empty'
		);

		$on_after_load = PrisnaYWTConfig::getSettingValue('on_after_load');

		$_options['meta_tag_rules'][] = array(
			'expression' => empty($on_after_load),
			'tag' => 'on_after_load.empty'
		);

		self::_set_rendered(true);

		return parent::render($_options, $_html_encode);
		
	}
	
	protected function _has_flags() {

		$show_flags = PrisnaYWTConfig::getSettingValue('show_flags');
		
		if (!$show_flags)
			return false;
	
		$languages = PrisnaYWTConfig::getSettingValue('languages');
		
		if (empty($languages))
			return false;
			
		return true;
		
	}
	
	protected function _gen_flags() {

		if (!$this->_has_flags())
			return;
			
		$flags_container_template = PrisnaYWTConfig::getSettingValue('flags_container_template');
		$flag_template = PrisnaYWTConfig::getSettingValue('flag_template');

		$languages = PrisnaYWTConfig::getSettingValue('languages');
		
		$flags_items = array();
		
		foreach ($languages as $language)
			$flags_items[] = array(
				'language_code' => $language,
				'language_name' => PrisnaYWTCommon::getLanguage($language),
				'language_name_no_space' => PrisnaYWTCommon::getLanguage($language, '_'),
				'flags_path' => PRISNA_YWT__IMAGES . '/'
			);
		
		$flags = PrisnaYWTCommon::renderObject($flags_items, array(
			'type' => 'html',
			'content' => $flag_template
		));

		$result = array(
			'content' => $flags,
			'align_mode' => $this->align_mode
		);
		
		$this->flags_formatted = PrisnaYWTCommon::renderObject((object) $result, array(
			'type' => 'html',
			'content' => $flags_container_template
		));
		
	}
	
	protected function _gen_options() {

		$this->align_mode = PrisnaYWTConfig::getSettingValue('align_mode');

		$this->_gen_flags();

	}
	
}

PrisnaYWT::initialize();

?>

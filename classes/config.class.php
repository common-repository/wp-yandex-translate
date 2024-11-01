<?php
 
class PrisnaYWTConfig {
	
	const NAME = 'PrisnaYWT';
	const UI_NAME = 'Prisna YT - Yandex Translator';
	const WIDGET_NAME = 'Prisna YWT';
	const WIDGET_INTERNAL_NAME = 'prisna-yandex-website-translator';
	const ADMIN_SETTINGS_NAME = 'prisna-yandex-website-translator-settings';
	const ADMIN_SETTINGS_IMPORT_EXPORT_NAME = 'prisna-yandex-website-translator-plugin-import-export-settings';
	const DB_SETTINGS_NAME = 'prisna-yandex-website-translator-settings';
	
	protected static $_settings = null;

	public static function getName($_to_lower=false, $_ui=false) {
		
		if ($_ui)
			return $_to_lower ? strtolower(self::UI_NAME) : self::UI_NAME;
		else
			return $_to_lower ? strtolower(self::NAME) : self::NAME;
		
	}

	public static function getWidgetName($_internal=false) {
	
		return $_internal ? self::WIDGET_INTERNAL_NAME : self::WIDGET_NAME;
		
	}

	public static function getVersion() {
	
		return PRISNA_YWT__VERSION;
		
	}	

	public static function getAdminHandle() {
		
		return self::ADMIN_SETTINGS_NAME;
		
	}

	public static function getAdminImportExportHandle() {
		
		return self::ADMIN_SETTINGS_IMPORT_EXPORT_NAME;
		
	}

	public static function getDbSettingsName() {
		
		return self::DB_SETTINGS_NAME;
		
	}

	protected static function _get_settings() {
		
		$option = get_option(self::getDbSettingsName());
		return !$option ? array() : $option;
		
	}
	
	public static function getSettings($_force=false, $_direct=false) {
		
		if (is_array(self::$_settings) && $_force == false)
			return self::$_settings;
		
		$current = self::_get_settings();

		if ($_direct)
			return $current;

		$defaults = self::getDefaults();

		$result = PrisnaYWTCommon::mergeArrays($defaults, $current);

		$result = self::_adjust_languages($result, $current);
		
		return self::$_settings = $result;
		
	}

	protected static function _adjust_languages($_settings, $_current) {
		
		$result = $_settings;
		
		if (array_key_exists('languages', $_current))
			$result['languages']['value'] = $_current['languages']['value'];
		
		return $result;
		
	}
	
	public static function getSetting($_name, $_force=false) {
		
		$settings = self::getSettings($_force);
		
		return array_key_exists($_name, $settings) ? $settings[$_name] : null;
		
	}

	protected static function _compare_settings($_id, $_setting_1, $_setting_2) {
		
		if (PrisnaYWTCommon::endsWith($_id, '_template') || PrisnaYWTCommon::endsWith($_id, '_template_dd'))
			return PrisnaYWTCommon::stripBreakLinesAndTabs($_setting_1['value']) == PrisnaYWTCommon::stripBreakLinesAndTabs($_setting_2['value']);
		
		if ($_id == 'override')
			if ($_setting_1['value'] != $_setting_2['value'] && PrisnaYWTValidator::isEmpty($_setting_1['value']))
				return true;
		
		if ($_id == 'languages')
			return $_setting_1['value'] === $_setting_2['value'];
			
		return $_setting_1['value'] == $_setting_2['value'];
		
	}
	
	protected static function _get_settings_values_for_export() {
		
		$settings = self::_get_settings();
		
		return count($settings) > 0 ? base64_encode(serialize($settings)) : __('No settings to export. The current settings are the default ones.', 'prisna-ywt');
		
	}
	
	public static function getSettingsValues($_force=false, $_new=true) {
		
		$result = array();
		$settings = self::getSettings($_force);
				
		$defaults = self::getDefaults();
				
		foreach ($settings as $key => $setting) {
		
			if (!array_key_exists($key, $defaults))
				continue;
		
			if ($_new == false || !self::_compare_settings($key, $setting, $defaults[$key])) {
				$result[$key] = array(
					'value' => $setting['value'],
					'option_id' => array_key_exists('option_id', $setting) ? $setting['option_id'] : null
				);
			}
			
		}
			
		return $result;

	}
	
	public static function getSettingValue($_name, $_force=false) {
		
		$setting = self::getSetting($_name, $_force);
		
		if (is_null($setting))
			return null;
		
		$result = $setting['value'];
		
		if (PrisnaYWTValidator::isBool($result))
			$result = $result == 'true' || $result === true;
		
		return $result;
		
	}

	public static function getDefaults($_force=false) {
		
		$settings = self::_get_settings();
		$display_mode = array_key_exists('display_mode', $settings) ? $settings['display_mode']['value'] : 'inline';
		
		$result = array(

			'usage' => array(
				'title_message' => __('Usage', 'prisna-ywt'),
				'description_message' => '',
				'id' => 'prisna_usage',
				'type' => 'usage',
				'value' => sprintf(__('
				
				- Go to the <em>Appereance &gt; Widgets</em> panel, search for the following widget<br /><br />
				
				<code>%s</code><br /><br />
				
				- Or copy and paste the following code into pages, posts, etc...<br /><br />
				
				<code>[prisna-yandex-website-translator]</code><br /><br />
				
				- Or copy and paste the following code into any page, post or front end PHP file<br /><br />
				
				<code>&lt;?php echo do_shortcode(\'[prisna-yandex-website-translator]\'); ?&gt;</code><br />
				
				', 'prisna-ywt'), self::getWidgetName()),
				'group' => 1
			),

			'premium' => array(
				'title_message' => '',
				'description_message' => '',
				'id' => 'prisna_usage',
				'type' => 'premium',
				'value' => '',
				'group' => 4
			),

			'api_key' => array(
				'title_message' => __('Yandex API key', 'prisna-ywt'),
				'description_message' => __('Sets the key for the Yandex Translate API. <a href="https://tech.yandex.com/keys/get/?service=trnsl" target="_blank">Sign up for a free API key</a>', 'prisna-ywt'),
				'empty_validate_message' => __('The translator needs a Yandex API key to work. <a href="https://tech.yandex.com/keys/get/?service=trnsl" target="_blank">Sign up for a free API key</a>', 'prisna-ywt'),
				'id' => 'prisna_api_key',
				'type' => 'key',
				'value' => '',
				'group' => 1
			),

			'from' => array(
				'title_message' => __('Website\'s language', 'prisna-ywt'),
				'description_message' => __('Sets the website\'s source language.', 'prisna-ywt'),
				'id' => 'prisna_from',
				'type' => 'select',
				'values' => PrisnaYWTCommon::getLanguages(),
				'value' => 'en',
				'group' => 1
			),

			'detect_browser_locale' => array(
				'title_message' => __('Detect browser\'s language', 'prisna-ywt'),
				'description_message' => __('Sets whether to detect the visitor browser\'s language, or not.'),
				'id' => 'prisna_detect_browser_locale',
				'type' => 'toggle',
				'value' => 'false',
				'values' => array(
					'true' => __('Yes, detect the browser\'s language', 'prisna-ywt'),
					'false' => __('No, don\'t detect the browser\'s language', 'prisna-ywt')
				),
				'group' => 1
			),

			'style' => array(
				'title_message' => __('Style mode', 'prisna-ywt'),
				'id' => 'prisna_style',
				'values' => array(
					'light' => PRISNA_YWT__IMAGES . '/style_light.png',
					'dark' => PRISNA_YWT__IMAGES . '/style_dark.png'
				),
				'value' => 'light',
				'type' => 'visual',
				'col_count' => 2,
				'group' => 1
			),

			'align_mode' => array(
				'title_message' => __('Align mode', 'prisna-ywt'),
				'description_message' => __('Sets the alignment mode of the translator within its container.', 'prisna-ywt'),
				'id' => 'prisna_align_mode',
				'type' => 'radio',
				'value' => 'left',
				'values' => array(
					'left' => __('Left', 'prisna-ywt'),
					'center' => __('Center', 'prisna-ywt'),
					'right' => __('Right', 'prisna-ywt')
				),
				'group' => 1
			),
			
			'show_flags' => array(
				'title_message' => __('Show flags over translator', 'prisna-ywt'),
				'description_message' => __('Sets whether to display a few flags over the translator, or not.', 'prisna-ywt'),
				'id' => 'prisna_show_flags',
				'type' => 'toggle',
				'value' => 'false',
				'values' => array(
					'true' => __('Yes, show flags', 'prisna-ywt'),
					'false' => __('No, don\'t show flags', 'prisna-ywt')
				),
				'group' => 1
			),
			
			'languages' => array(
				'title_message' => __('Select languages', 'prisna-ywt'),
				'description_message' => __('Sets the available languages to display over the translator.', 'prisna-ywt'),
				'title_order_message' => __('Languages order', 'prisna-ywt'),
				'description_order_message' => __('Defines the order to display the languages.', 'prisna-ywt'),
				'id' => 'prisna_languages',
				'values' => PrisnaYWTCommon::getLanguages(),
				'value' => array('en', 'es', 'de', 'fr', 'pt', 'da'),
				'type' => 'language',
				'enable_order' => true,
				'columns' => 4,
				'dependence' => array('show_flags'),
				'dependence_show_value' => array('true'),
				'group' => 1
			),
			
			'test_mode' => array(
				'title_message' => __('Test mode', 'prisna-ywt'),
				'description_message' => __('Sets whether the translator is in test mode or not. In "test mode", the translator will be displayed only if the current logged in user has admin privileges.<br />Is useful for setting up the translator without letting visitors to see the changes while the plugin is being implemented.', 'prisna-ywt'),
				'id' => 'prisna_test_mode',
				'type' => 'toggle',
				'value' => 'false',
				'values' => array(
					'true' => __('Yes, enable test mode', 'prisna-ywt'),
					'false' => __('No, disable test mode', 'prisna-ywt')
				),
				'group' => 2
			),

			'custom_css' => array(
				'title_message' => __('Custom CSS', 'prisna-ywt'),
				'description_message' => __('Defines custom CSS rules.', 'prisna-ywt'),
				'id' => 'prisna_custom_css',
				'type' => 'textarea',
				'value' => '',
				'group' => 2
			),

			'display_heading' => array(
				'title_message' => __('Hide on pages, posts and categories', 'prisna-ywt'),
				'description_message' => '',
				'value' => 'false',
				'id' => 'prisna_display_heading',
				'type' => 'heading',
				'group' => 2
			),
			
			'exclude_pages' => array(
				'title_message' => __('Pages', 'prisna-ywt'),
				'description_message' => __('Selects the pages where the translator should not be displayed.', 'prisna-ywt'),
				'id' => 'prisna_exclude_pages',
				'value' => array(''),
				'type' => 'expage',
				'dependence' => 'display_heading',
				'dependence_show_value' => 'true',
				'group' => 2
			),

			'exclude_posts' => array(
				'title_message' => __('Posts', 'prisna-ywt'),
				'description_message' => __('Selects the posts where the translator should not be displayed.', 'prisna-ywt'),
				'id' => 'prisna_exclude_posts',
				'value' => array(''),
				'type' => 'expost',
				'dependence' => 'display_heading',
				'dependence_show_value' => 'true',
				'group' => 2
			),
			
			'exclude_categories' => array(
				'title_message' => __('Categories', 'prisna-ywt'),
				'description_message' => __('Selects the categories where the translator should not be displayed.', 'prisna-ywt'),
				'id' => 'prisna_exclude_categories',
				'value' => array(''),
				'type' => 'excategory',
				'dependence' => 'display_heading',
				'dependence_show_value' => 'true',
				'group' => 2
			),

			'callbacks_heading' => array(
				'title_message' => __('Javascript callbacks', 'prisna-ywt'),
				'description_message' => '',
				'value' => 'false',
				'id' => 'prisna_callbacks_heading',
				'type' => 'heading',
				'group' => 2
			),
			
			'on_before_load' => array(
				'title_message' => __('On before load', 'prisna-ywt'),
				'description_message' => __('Defines a javascript routine that runs before the translator is loaded.', 'prisna-ywt'),
				'id' => 'prisna_on_before_load',
				'type' => 'textarea',
				'value' => '',
				'dependence' => 'callbacks_heading',
				'dependence_show_value' => 'true',
				'group' => 2
			),

			'on_after_load' => array(
				'title_message' => __('On after load', 'prisna-ywt'),
				'description_message' => __('Defines a javascript routine that runs after the translator is loaded.', 'prisna-ywt'),
				'id' => 'prisna_on_after_load',
				'type' => 'textarea',
				'value' => '',
				'dependence' => 'callbacks_heading',
				'dependence_show_value' => 'true',
				'group' => 2
			),

			'templates_heading' => array(
				'title_message' => __('Templates', 'prisna-ywt'),
				'description_message' => '',
				'value' => 'false',
				'id' => 'prisna_templates_heading',
				'type' => 'heading',
				'group' => 2
			),
			
			'flags_container_template' => array(
				'title_message' => __('Flags container template', 'prisna-ywt'),
				'description_message' => __('Sets the flags\' container template. New templates can be created if the provided one doesn\'t fit the web page requirements.', 'prisna-ywt'),
				'id' => 'prisna_flags_container_template',
				'type' => 'textarea',
				'value' => '<ul class="prisna-ywt-flags-container prisna-ywt-align-{{ align_mode }}">
	{{ content }}
</ul>',
				'dependence' => 'templates_heading',
				'dependence_show_value' => 'true',
				'group' => 2
			),
			
			'flag_template' => array(
				'title_message' => __('Flag template', 'prisna-ywt'),
				'description_message' => __('Sets the flag\'s template. New templates can be created if the provided one doesn\'t fit the web page requirements.', 'prisna-ywt'),
				'id' => 'prisna_flag_template',
				'type' => 'textarea',
				'value' => '<li class="prisna-ywt-flag-container prisna-ywt-language-{{ language_code }}">
	<a href="javascript:;" onclick="PrisnaYWT.translate(\'{{ language_code }}\'); return false;" title="{{ language_name }}"></a>
</li>',
				'dependence' => 'templates_heading',
				'dependence_show_value' => 'true',
				'group' => 2
			),

			'import' => array(
				'title_message' => __('Import settings', 'prisna-ywt'),
				'description_message' => __('Imports previously exported settings. Paste the previously exported settings in the field. If the data\'s structure is correct, it will overwrite the current settings.', 'prisna-ywt'),
				'id' => 'prisna_import',
				'value' => '',
				'type' => 'textarea',
				'group' => 3
			),

			'export' => array(
				'title_message' => __('Export settings', 'prisna-ywt'),
				'description_message' => __('Exports the current settings to make a backup or to transfer the settings from the development server to the production server. Triple click on the field to select all the content.', 'prisna-ywt'),
				'id' => 'prisna_export',
				'value' => self::_get_settings_values_for_export(),
				'type' => 'export',
				'group' => 3
			)
			
		);
			
		
		return $result;
		
	}

}

?>

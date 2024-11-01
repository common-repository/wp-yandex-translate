
<style type="text/css">
<!--
.prisna-ywt-align-left {
	text-align: left !important;
}
.prisna-ywt-align-center {
	text-align: center !important;
}
.prisna-ywt-align-right {
	text-align: right !important;
}
{{ has_flags.true:begin }}
.prisna-ywt-flags-container {
	list-style: none !important;
	margin: 0 !important;
	padding: 0 !important;
	border: none !important;
	clear: both !important;
}
.prisna-ywt-flag-container {
	list-style: none !important;
	display: inline-block;
	margin: 0 2px 0 0 !important;
	padding: 0 !important;
	border: none !important;
}
.prisna-ywt-flag-container a {
	display: inline-block;
	margin: 0 !important;
	padding: 0 !important;
	border: none !important;
	background-repeat: no-repeat !important;
	background-image: url({{ flags_image_path }}/all.png) !important;
	width: 22px !important;
	height: 16px !important;
}
{{ flags_css }}
{{ has_flags.true:end }}
{{ custom_css }}
-->
</style>
{{ on_before_load.empty.false:begin }}
<script type="text/javascript">
/*<![CDATA[*/
{{ on_before_load }}
/*]]>*/
</script>
{{ on_before_load.empty.false:end }}
{{ has_flags.true:begin }}
<script type="text/javascript">
/*<![CDATA[*/
var PrisnaYWT = {

	translate: function(_language) {

		var from = "{{ from }}";
		var target;

		if (from != _language)
			target = jQuery(".yt-listbox__input[value='" + _language + "']").parent();
		else
			target = jQuery(".yt-wrapper .yt-button__icon.yt-button__icon_type_right");
			
		target.click();

	}
	
};
/*]]>*/
</script>
{{ flags_formatted }}
{{ has_flags.true:end }}
{{ has_container.true:begin }}<div id="prisna-ywt-widget" class="prisna-ywt-align-{{ align_mode }}"></div><script src="https://translate.yandex.net/website-widget/v1/widget.js?widgetId=prisna-ywt-widget&pageLang={{ from }}&widgetTheme={{ style }}&trnslKey={{ api_key }}&autoMode={{ detect_browser_locale }}" type="text/javascript"></script>{{ has_container.true:end }}
{{ on_after_load.empty.false:begin }}
<script type="text/javascript">
/*<![CDATA[*/
{{ on_after_load }}
/*]]>*/
</script>
{{ on_after_load.empty.false:end }}

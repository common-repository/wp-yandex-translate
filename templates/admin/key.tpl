<div class="prisna_ywt_section prisna_ywt_{{ type }}{{ dependence.show.false:begin }} prisna_ywt_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_ywt_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">

	<div class="prisna_ywt_tooltip"></div>
	<div class="prisna_ywt_description prisna_ywt_no_display">{{ description_message }}</div>

	<div class="prisna_ywt_title_container prisna_ywt_icon prisna_ywt_icon_key"><h3 class="prisna_ywt_title">{{ title_message }}</h3></div>
	<div class="prisna_ywt_setting">
		<div class="prisna_ywt_field">
			<input class="prisna_ywt_input" name="{{ id }}" id="{{ id }}" type="text" value="{{ value }}" spellcheck="false" />
		</div>
	</div>

{{ empty_validate.false:begin }}
<div class="prisna_ywt_api_key_empty_validate prisna_ywt_message prisna_ywt_warning_message">
	<p>{{ empty_validate_message }}</p>
</div>
{{ empty_validate.false:end }}

	<div class="prisna_ywt_clear"></div>

</div>

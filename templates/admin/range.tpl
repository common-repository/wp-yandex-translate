<div class="prisna_ywt_section prisna_ywt_{{ type }}{{ dependence.show.false:begin }} prisna_ywt_no_display{{ dependence.show.false:end }}{{ has_dependence.true:begin }} prisna_ywt_section_tabbed_{{ dependence_count }}{{ has_dependence.true:end }}" id="section_{{ id }}">

	<div class="prisna_ywt_tooltip"></div>
	<div class="prisna_ywt_description prisna_ywt_no_display">{{ description_message }}</div>

	<div class="prisna_ywt_title_container prisna_ywt_icon prisna_ywt_icon_grid2"><h3 class="prisna_ywt_title">{{ title_message }}</h3></div>
	<div class="prisna_ywt_setting">
		<div class="prisna_ywt_field">
			<div id="{{ id }}_range" class="prisna_ywt_field_range"></div>
			<input type="text" name="{{ id }}" id="{{ id }}" value="{{ value }}" readonly="readonly" />
			<div class="prisna_ywt_field_unit"><small>{{ unit }}</small></div>
			<script type="text/javascript">
			/*<![CDATA[*/
				PrisnaYWTAdmin.addRangeField({
					container: "#{{ id }}_range", 
					view: "#{{ id }}_value", 
					field: "#{{ id }}",
					value: {{ value }},
					min: {{ min }},
					max: {{ max }},
					step: {{ step }}
				});
			/*]]>*/
			</script>
		</div>
	</div>
	{{ has_dependence.true:begin }}
	<input type="hidden" name="{{ id }}_dependence" id="{{ id }}_dependence" value="{{ formatted_dependence }}" />
	<input type="hidden" name="{{ id }}_dependence_show_value" id="{{ id }}_dependence_show_value" value="{{ formatted_dependence_show_value }}" />
	{{ has_dependence.true:end }}
	<div class="prisna_ywt_clear"></div>

</div>

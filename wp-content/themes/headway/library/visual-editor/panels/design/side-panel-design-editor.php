<?php
class HeadwaySidePanelDesignEditor {


	public static function init() {

		if ( HeadwayVisualEditor::get_current_mode() != 'design' )
			return false;

		add_action('headway_visual_editor_side_panel', array(__CLASS__, 'template'));

	}


	public static function template() {

		echo '<span id="design-editor-toggle"><span>iii</span></span>';

		echo '<div id="side-panel-top">';
			self::element_selector();
		echo '</div><!-- #side-panel-top -->';

		echo '<div id="side-panel-bottom">';
			self::editor();
		echo '</div><!-- #side-panel-bottom -->';

	}


	public static function element_selector() {

		echo '<div id="element-selector-filters">
				<span class="element-selector-filters-icon"></span>

				<span id="toggle-element-properties" class="element-selector-filter-button tooltip" title="Show Styles"></span>
				<span id="toggle-unstyled-elements" class="element-selector-filter-button tooltip element-selector-filter-active" title="Show Unstyled Elements"></span>
				<span id="toggle-element-states" class="element-selector-filter-button tooltip" title="Show States"><span class="icon-state-svg">States</span></span>
				<span id="toggle-element-instances" class="element-selector-filter-button tooltip" title="Show Instances"><span class="icon-instance-svg">Instances</span></span>
			</div>';

		echo '<div id="design-editor-element-selector-container">';

				echo '<ul id="design-editor-element-selector">';

				echo '</ul><!-- #design-editor-element-selector -->';

			echo '</div><!-- #design-editor-element-selector-container -->';

	}


	public static function editor() {

		echo '
			<div class="design-editor-info" style="display: none;">
					<div class="design-editor-selection">
						<strong>Editing:</strong> <span class="design-editor-selected-element"></span>

						<div class="design-editor-selection-details">
							<strong class="design-editor-selection-details-instance">Global</strong> 
							for <strong class="design-editor-selection-details-layout">all layouts</strong> 
							<span class="design-editor-selection-details-state-container">and <strong class="design-editor-selection-details-state">all states</strong></span>
						</div>

						<span class="button button-small design-editor-info-button customize-element-for-layout">Customize For Current Layout</span>
						<span class="button button-small design-editor-info-button customize-for-regular-element">Customize Regular Element</span>
					</div>
				</div><!-- .design-editor-info -->

			<div class="design-editor-options-container">
			
				<div class="design-editor-options" style="display:none;"></div><!-- .design-editor-options -->
						
			</div><!-- .design-editor-options-container -->
		';

	}

}
<#
var items = _.filter( data.children, function( item ) {
	return item.subDepth == 0;
} );
#>

<div class="megamenu-modal__panel" data-panel="mega">
	<div class="megamenu-modal__panel-toolbar">
		<div class="megamenu-modal__panel-option">
			<label class="megamenu-modal__toggle">
				<input type="checkbox" value="1" {{ parseInt( data.megaData.mega ) ? 'checked' : '' }} name="{{ megaMenuFieldName( 'mega', data.data['menu-item-db-id'] ) }}">
				<span class="megamenu-modal__toggle-ui"></span>
				<?php esc_html_e( 'Enable Mega Menu', 'ecomus-addons' ) ?>
			</label>
		</div>

		<div class="megamenu-modal__panel-option">
			<label>
				<span class="megamenu-modal__panel-option-label"><?php esc_html_e( 'Mode', 'ecomus-addons' ) ?></span>
				<select name="{{ megaMenuFieldName( 'mega_mode', data.data['menu-item-db-id'] ) }}" data-toggle_condition="mega_mode">
					<option value="default"><?php esc_html_e( 'Default', 'ecomus-addons' ) ?></option>
					<option value="grid" {{ 'grid' == data.megaData.mega_mode ? 'selected="selected"' : '' }}><?php esc_html_e( 'Grid', 'ecomus-addons' ) ?></option>
				</select>
			</label>
		</div>

		<div class="megamenu-modal__panel-option">
			<label>
				<span class="megamenu-modal__panel-option-label"><?php esc_html_e( 'Width', 'ecomus-addons' ) ?></span>
				<select name="{{ megaMenuFieldName( 'width', data.data['menu-item-db-id'] ) }}" data-toggle_condition="mega_width">
					<option value="container"><?php esc_html_e( 'Default', 'ecomus-addons' ) ?></option>
					<option value="container-fluid" {{ 'container-fluid' == data.megaData.width ? 'selected="selected"' : '' }}><?php esc_html_e( 'Full width', 'ecomus-addons' ) ?></option>
					<option value="custom" {{ 'custom' == data.megaData.width ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'ecomus-addons' ) ?></option>
				</select>
			</label>

			<label style="{{ 'custom' == data.megaData.width ? '' : 'display: none;' }}" data-toggle_mega_width="custom">
				<span class="screen-reader-text"><?php esc_html_e( 'Custom width', 'ecomus-addons' ) ?></span>
				<input type="text" name="{{ megaMenuFieldName( 'custom_width', data.data['menu-item-db-id'] ) }}" placeholder="<?php esc_attr_e( 'width', 'ecomus-addons' ) ?>" value="{{ data.megaData.custom_width }}" size="6">
			</label>

			<label>
				<span class="megamenu-modal__panel-option-label"><?php esc_html_e( 'Alignment', 'ecomus-addons' ) ?></span>
				<select name="{{ megaMenuFieldName( 'alignment', data.data['menu-item-db-id'] ) }}" data-toggle_condition="mega_alignment">
					<option value="center"><?php esc_html_e( 'Center', 'ecomus-addons' ) ?></option>
					<option value="left" {{ 'left' == data.megaData.alignment ? 'selected="selected"' : '' }}><?php esc_html_e( 'Left', 'ecomus-addons' ) ?></option>
					<option value="right" {{ 'right' == data.megaData.alignment ? 'selected="selected"' : '' }}><?php esc_html_e( 'Right', 'ecomus-addons' ) ?></option>
				</select>
			</label>
		</div>
	</div>

	<div class="megamenu-modal__submenu megamenu-modal__submenu--default {{ 'default' !== data.megaData.mega_mode ? 'hidden' : '' }}" data-toggle_mega_mode="default">
		<# _.each( items, function( item, index ) { #>

		<div class="megamenu-modal__submenu-column" data-width="{{ item.megaData.width }}">
			<ul>
				<li class="menu-item menu-item-depth-{{ item.subDepth }}" data-item_id="{{ item.data['menu-item-db-id'] }}">
					<span aria-label="{{ item.data['menu-item-title'] }}">{{{ item.data['menu-item-title'] }}}</span>
					<# if ( item.subDepth == 0 ) { #>
					<div class="megamenu-modal__submenu-column-actions">
						<button type="button" class="button-link megamenu-modal__submenu-settings"><?php esc_html_e( 'Settings', 'ecomus-addons' ) ?></button>
						<button class="megamenu-modal__column-width-handle" data-action="decrease"><i class="dashicons dashicons-arrow-left-alt2"></i></button>
						<span class="megamenu-modal__column-width-label"></span>
						<button class="megamenu-modal__column-width-handle" data-action="increase"><i class="dashicons dashicons-arrow-right-alt2"></i></button>
						<input type="hidden" name="{{ megaMenuFieldName( 'width', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.width }}" class="menu-item-width">
					</div>
					<# } #>
				</li>
			</ul>
		</div>

		<# } ) #>
	</div>

	<div class="megamenu-modal__submenu megamenu-modal__submenu--grid {{ 'grid' !== data.megaData.mega_mode ? 'hidden' : '' }}" data-toggle_mega_mode="grid">
		<div class="megamenu-modal-grid__inside"></div>

		<div class="megamenu-modal-grid__actions">
			<button type="button" class="button" data-action="add-row" data-options="<?php echo esc_attr( json_encode( \Ecomus\Addons\Modules\Mega_Menu\Module::default_row_options() ) ) ?>">
				<span class="dashicons dashicons-insert"></span>
				<span><?php esc_html_e( 'Add a row', 'ecomus-addons' ) ?></span>
			</button>
		</div>
	</div>
</div>

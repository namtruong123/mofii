<div class="megamenu-modal__panel" data-panel="settings">
	<# if ( data.depth === 1 ) { #>

	<table class="form-table">
		<tr class="item-visible-fields">
			<th scope="row"><?php esc_html_e( 'Visibility', 'ecomus-addons' ) ?></th>
			<td>
				<label>
					<input type="radio" name="{{ megaMenuFieldName( 'visible', data.data['menu-item-db-id'] ) }}" value="visible" {{ 'visible' == data.megaData.visible ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Visible', 'ecomus-addons' ) ?>
				</label>
				&nbsp;
				<label>
					<input type="radio" name="{{ megaMenuFieldName( 'visible', data.data['menu-item-db-id'] ) }}" value="none" {{ 'none' == data.megaData.visible ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Hidden', 'ecomus-addons' ) ?>
				</label>
				&nbsp;
				<label>
					<input type="radio" name="{{ megaMenuFieldName( 'visible', data.data['menu-item-db-id'] ) }}" value="hidden" {{ 'hidden' == data.megaData.visible ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Soft hidden (keep spacing)', 'ecomus-addons' ) ?>
				</label>
			</td>
		</tr>

		<tr class="item-link-field" style="{{ 'visible' !== data.megaData.visible ? 'display:none' : '' }}">
			<th scope="row"><?php esc_html_e( 'Disable link', 'ecomus-addons' ) ?></th>
			<td>
				<label>
					<input type="checkbox" name="{{ megaMenuFieldName( 'disable_link', data.data['menu-item-db-id'] ) }}" value="1" {{ parseInt( data.megaData.disable_link ) ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Disable menu item link', 'ecomus-addons' ) ?>
				</label>
			</td>
		</tr>
	</table>

	<# } #>
</div>

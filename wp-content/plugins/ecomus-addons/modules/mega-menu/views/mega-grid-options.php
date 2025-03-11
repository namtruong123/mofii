<div class="megamenu-modal-grid__options-popup" tabindex="-1" role="dialog">
	<div class="megamenu-modal-grid__options-popup-content">
		<h2><?php esc_html_e( 'Options', 'ecomus-addons' ) ?></h2>
		<button type="button" class="button button-close" data-action="close-options">
			<span class="dashicons dashicons-no-alt"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Close', 'ecomus-addons' ) ?></span>
		</button>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e( 'Padding', 'ecomus-addons' ) ?></th>
					<td>
						<fieldset class="megamenu-modal__option-spacing">
							<label>
								<input type="text" value="{{ data.padding.top }}" data-name="padding.top" size="4"><br>
								<span class="description"><?php esc_html_e( 'Top', 'ecomus-addons' ) ?></span>
							</label>
							&nbsp;
							<label>
								<input type="text" value="{{ data.padding.bottom }}" data-name="padding.bottom" size="4"><br>
								<span class="description"><?php esc_html_e( 'Bottom', 'ecomus-addons' ) ?></span>
							</label>
							&nbsp;
							<label>
								<input type="text" value="{{ data.padding.left }}" data-name="padding.left" size="4"><br>
								<span class="description"><?php esc_html_e( 'Left', 'ecomus-addons' ) ?></span>
							</label>
							&nbsp;
							<label>
								<input type="text" value="{{ data.padding.right }}" data-name="padding.right" size="4"><br>
								<span class="description"><?php esc_html_e( 'Right', 'ecomus-addons' ) ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<# if ( ! data.row ) { #>
				<!-- Margin settings for rows only, not for columns -->
				<tr>
					<th scope="row"><?php esc_html_e( 'Margin', 'ecomus-addons' ) ?></th>
					<td>
						<fieldset class="megamenu-modal__option-spacing">
							<label>
								<input type="text" value="{{ data.margin.top }}" data-name="margin.top" size="4"><br>
								<span class="description"><?php esc_html_e( 'Top', 'ecomus-addons' ) ?></span>
							</label>
							&nbsp;
							<label>
								<input type="text" value="{{ data.margin.bottom }}" data-name="margin.bottom" size="4"><br>
								<span class="description"><?php esc_html_e( 'Bottom', 'ecomus-addons' ) ?></span>
							</label>
						</fieldset>
					</td>
				</tr>
				<# } #>
				<tr>
					<th scope="row"><?php esc_html_e( 'Background', 'ecomus-addons' ) ?></th>
					<td>
						<fieldset class="megamenu-modal__option-background">
							<div class="megamenu-modal__option-group">
								<div class="megamenu-modal__option-background-image megamenu-modal__option-background-field megamenu-media {{ data.background.image.url ? '' : 'megamenu-media--empty' }}">
									<span class="megamenu-media__preview">
										<# if ( data.background.image.url ) { #>
											<img src="{{ data.background.image.url }}">
										<# } #>
									</span>

									<button type="button" class="megamenu-media__remove">
										<span class="dashicons dashicons-trash"></span>
										<span class="screen-reader-text"><?php esc_html_e( 'Remove', 'ecomus-addons' ) ?></span>
									</button>
									<input type="hidden" data-name="background.image.id" value="{{ data.background.image.id }}" data-image_input="id">
									<input type="hidden" data-name="background.image.url" value="{{ data.background.image.url }}" data-image_input="url">
								</div>

								<div class="megamenu-modal__option-background-position megamenu-modal__option-background-field">
									<label><?php esc_html_e( 'Image Position', 'ecomus-addons' ) ?></label>
									<p>
										<select data-name="background.position.x" data-toggle_condition="rowbg_posx" data-toggle_scope="p">
											<option value="left" {{ 'left' == data.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Left', 'ecomus-addons' ) ?></option>
											<option value="center" {{ 'center' == data.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Center', 'ecomus-addons' ) ?></option>
											<option value="right" {{ 'right' == data.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Right', 'ecomus-addons' ) ?></option>
											<option value="custom" {{ 'custom' == data.background.position.x ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'ecomus-addons' ) ?></option>
										</select>
										<br>
										<input
											type="text"
											size="6"
											data-name="background.position.custom_x"
											value="{{ data.background.position.custom_x }}"
											class="{{ 'custom' != data.background.position.x ? 'hidden' : '' }}"
											data-toggle_rowbg_posx="custom">
									</p>

									<p>
										<select data-name="background.position.y" data-toggle_condition="rowbg_posy" data-toggle_scope="p">
											<option value="top" {{ 'top' == data.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Top', 'ecomus-addons' ) ?></option>
											<option value="center" {{ 'center' == data.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Middle', 'ecomus-addons' ) ?></option>
											<option value="bottom" {{ 'bottom' == data.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Bottom', 'ecomus-addons' ) ?></option>
											<option value="custom" {{ 'custom' == data.background.position.y ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'ecomus-addons' ) ?></option>
										</select>
										<br>
										<input
											type="text"
											size="6"
											data-name="background.position.custom_y"
											value="{{ data.background.position.custom_y }}"
											class="{{ 'custom' != data.background.position.y ? 'hidden' : '' }}"
											data-toggle_rowbg_posy="custom">
									</p>
								</div>
							</div>

							<div class="megamenu-modal__option-group">
								<p class="megamenu-modal__option-background-color megamenu-modal__option-background-field">
									<label><?php esc_html_e( 'Color', 'ecomus-addons' ) ?></label>
									<input type="text" data-type="colorpicker" data-name="background.color" value="{{ data.background.color }}">
								</p>

								<p class="megamenu-modal__option-background-repeat megamenu-modal__option-background-field">
									<label><?php esc_html_e( 'Repeat', 'ecomus-addons' ) ?></label>
									<select data-name="background.repeat">
										<option value="no-repeat" {{ 'no-repeat' == data.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'No Repeat', 'ecomus-addons' ) ?></option>
										<option value="repeat" {{ 'repeat' == data.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile', 'ecomus-addons' ) ?></option>
										<option value="repeat-x" {{ 'repeat-x' == data.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile Horizontally', 'ecomus-addons' ) ?></option>
										<option value="repeat-y" {{ 'repeat-y' == data.background.repeat ? 'selected="selected"' : '' }}><?php esc_html_e( 'Tile Vertically', 'ecomus-addons' ) ?></option>
									</select>
								</p>

								<p class="megamenu-modal__option-background-attachment megamenu-modal__option-background-field">
									<label><?php esc_html_e( 'Attachment', 'ecomus-addons' ) ?></label>
									<select data-name="background.attachment">
										<option value="scroll" {{ 'scroll' == data.background.attachment ? 'selected="selected"' : '' }}><?php esc_html_e( 'Scroll', 'ecomus-addons' ) ?></option>
										<option value="fixed" {{ 'fixed' == data.background.attachment ? 'selected="selected"' : '' }}><?php esc_html_e( 'Fixed', 'ecomus-addons' ) ?></option>
									</select>
								</p>

								<p class="megamenu-modal__option-background-size megamenu-modal__option-background-field">
									<label><?php esc_html_e( 'Size', 'ecomus-addons' ) ?></label>
									<select data-name="background.size">
										<option value=""><?php esc_html_e( 'Default', 'ecomus-addons' ) ?></option>
										<option value="cover" {{ 'cover' == data.background.size ? 'selected="selected"' : '' }}><?php esc_html_e( 'Cover', 'ecomus-addons' ) ?></option>
										<option value="contain" {{ 'contain' == data.background.size ? 'selected="selected"' : '' }}><?php esc_html_e( 'Contain', 'ecomus-addons' ) ?></option>
									</select>
								</p>
							</div>
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="megamenu-modal-grid__options-popup-toolbar">
			<button type="button" class="button button-primary button-large" data-action="save-options">
				<?php esc_html_e( 'Save Changes', 'ecomus-addons' ) ?>
			</button>
		</div>
	</div>
	<div class="media-modal-backdrop"></div>
</div>
<div class="megamenu-modal__panel" data-panel="content">
	<p>
		<textarea name="{{ megaMenuFieldName( 'content', data.data['menu-item-db-id'] ) }}" class="widefat" rows="20" contenteditable="true">{{{ data.megaData.content }}}</textarea>
	</p>
	<p class="description"><?php esc_html_e( 'Allow HTML and Shortcodes', 'ecomus-addons' ) ?></p>
	<p class="description"><?php esc_html_e( 'Tip: Build your content inside a page with visual page builder then copy generated content here.', 'ecomus-addons' ) ?></p>
</div>
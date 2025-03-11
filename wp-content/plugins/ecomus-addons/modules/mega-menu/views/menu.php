<div class="megamenu-modal__menu">
	<# if ( data.depth == 0 ) { #>
		<a href="#" class="media-menu-item {{ data.current === 'mega' ? 'active' : '' }}" data-panel="mega" data-title="<?php esc_attr_e( 'Mega Menu', 'ecomus-addons' ) ?>"><?php esc_html_e( 'Mega Menu', 'ecomus-addons' ) ?></a>
		<a href="#" class="media-menu-item {{ data.current === 'design' ? 'active' : '' }}" data-panel="design" data-title="<?php esc_attr_e( 'Mega Menu Design', 'ecomus-addons' ) ?>"><?php esc_html_e( 'Design', 'ecomus-addons' ) ?></a>
	<# } else if ( data.depth == 1 ) { #>
		<a href="#" class="media-menu-item {{ data.current === 'settings' ? 'active' : '' }}" data-panel="settings" data-title="<?php esc_attr_e( 'Menu Setting', 'ecomus-addons' ) ?>"><?php esc_html_e( 'Settings', 'ecomus-addons' ) ?></a>
		<a href="#" class="media-menu-item {{ data.current === 'content' ? 'active' : '' }}" data-panel="content" data-title="<?php esc_attr_e( 'Menu Content', 'ecomus-addons' ) ?>"><?php esc_html_e( 'Content', 'ecomus-addons' ) ?></a>
		<a href="#" class="media-menu-item {{ data.current === 'design' ? 'active' : '' }}" data-panel="design" data-title="<?php esc_attr_e( 'Mega Column Design', 'ecomus-addons' ) ?>"><?php esc_html_e( 'Design', 'ecomus-addons' ) ?></a>
	<# } else { #>
		<a href="#" class="media-menu-item {{ data.current === 'content' ? 'active' : '' }}" data-panel="content" data-title="<?php esc_attr_e( 'Menu Content', 'ecomus-addons' ) ?>"><?php esc_html_e( 'Content', 'ecomus-addons' ) ?></a>
	<# } #>
	<a href="#" class="media-menu-item {{ data.current === 'icon' ? 'active' : '' }}" data-panel="icon" data-title="<?php esc_attr_e( 'Menu Icon', 'ecomus-addons' ) ?>"><?php esc_html_e( 'Icon', 'ecomus-addons' ) ?></a>
</div>
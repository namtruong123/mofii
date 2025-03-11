<?php
/**
 * Product Bought Together
 *
 */
defined( 'ABSPATH' ) || exit;

global $product;
?>

<div class="ecomus-product-pbt layout-<?php echo esc_attr( $layout ); ?>" id="ecomus-product-pbt">
	<h3 class="ecomus-product-pbt__title"><?php echo apply_filters( 'ecomus_product_bought_together_title', esc_html__( 'Frequently Bought Together', 'ecomus-addons' ) ); ?></h3>
	<div class="ecomus-product-pbt__wrapper">
		<div class="ecomus-product-pbt__products">
			<ul class="products">
				<?php
				$pids        = [];
				$list        = [];
				$total_price = 0;
				$total_save_price = 0;

				$discount              = intval( get_post_meta( $product->get_id(), 'ecomus_pbt_discount_all', true ) );
				$checked_all           = get_post_meta( $product->get_id(), 'ecomus_pbt_checked_all', true );
				$quantity_discount_all = intval( get_post_meta( $product->get_id(), 'ecomus_pbt_quantity_discount_all', true ) );
				$countProduct          = empty( $checked_all ) ? 1 : count( $product_ids );

				foreach ( $product_ids as $product_id ) {
					$priceHTML  = [];
					$product_id = apply_filters( 'wpml_object_id', $product_id, 'product' );
					$item       = wc_get_product( $product_id );
					$classPrice = '';

					if ( empty( $item ) ) {
						continue;
					}

					if ( $item->get_stock_status() == 'outofstock' || $item->is_type( 'grouped' ) || $item->is_type( 'external' )  ) {
						$key = array_search( $product_id, $product_ids );
						if ( $key !== false ) {
							unset( $product_ids[ $key ] );
						}
						continue;
					}

					$data_id = $item->get_id();
					if ( $item->get_parent_id() > 0 ) {
						$data_id = $item->get_parent_id();
					}

					if( empty( $checked_all ) ) {
						$total_price = $product->is_type( 'variable' ) ? 0 : wc_get_price_to_display( $product );

						if( $discount && $discount > 0 ) {
							$total_save_price = $product->is_type( 'variable' ) ? 0 : wc_get_price_to_display( $product ) - ( wc_get_price_to_display( $product ) / 100 * (float) $discount );
						}
					} else {
						$total_price += $item->is_type( 'variable' ) ? 0 : wc_get_price_to_display( $item );

						if( $discount && $discount > 0 ) {
							$total_save_price += $item->is_type( 'variable' ) ? 0 : wc_get_price_to_display( $item ) - ( wc_get_price_to_display( $item ) / 100 * (float) $discount );
						}
					}

					$total_price = wc_format_decimal( $total_price, wc_get_price_decimals() );
					$total_save_price = wc_format_decimal( $total_save_price, wc_get_price_decimals() );

					$current_class_li = $current_class = '';
					if ( $item->get_id() == $product->get_id() ) {
						$current_class_li = 'product-primary';
						$current_class = 'product-current';
					}

					if( $item->get_id() !== $product->get_id() && empty( $checked_all ) ) {
						$current_class_li .= ' un-active';
						$current_class .= ' uncheck';
					}

					$pids[] = $item->is_type( 'variable' ) ? 0 : $item->get_id();

					$product_name = $item->get_name();
					?>
					<li id="pbt-product-<?php echo esc_attr( $item->get_id() ); ?>" class="product <?php echo esc_attr( $current_class_li ); ?>" data-type="<?php echo esc_attr( $item->get_type() ); ?>" data-name="<?php echo esc_attr( $item->get_name() ); ?>">
						<div class="product-content">
							<div class="product-select <?php echo esc_attr($current_class); ?>">
								<?php
									echo sprintf(
										'<a class="product-id" href="%s" data-id="%s" data-title="%s">
											<span class="select"></span>
										</a>
										<span class="s-price hidden" data-price="%s">(%s)</span>%s',
										esc_url( $item->get_permalink() ),
										$item->is_type( 'variable' ) ? 0 : esc_attr( $item->get_id() ),
										esc_attr( $product_name ),
										$item->is_type( 'variable' ) ? 0 : esc_attr( $item->get_price() ),
										$item->get_price_html(),
										$item->is_type( 'variable' ) ? '<span class="s-attrs hidden" data-attrs=""></span>' : ''
									);
								?>
							</div>
							<a class="thumbnail" href="<?php echo esc_url( $item->get_permalink() ) ?>">
								<span class="thumb-ori">
									<?php echo wp_get_attachment_image( $item->get_image_id(), 'woocommerce_thumbnail' ); ?>
								</span>
								<?php if( $item->is_type( 'variable' ) ) : ?>
									<span class="thumb-new"></span>
								<?php endif; ?>
							</a>
							<div class="product-summary">
								<h2 class="woocommerce-loop-product__title">
									<?php if( $current_class_li == 'product-primary' ) : ?>
										<span><?php echo esc_html__( 'This item:', 'ecomus-addons' ); ?></span>
										<?php echo esc_html( $product_name ); ?>
									<?php else: ?>
										<a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?php echo esc_url( $item->get_permalink() ) ?>">
											<?php echo esc_html( $product_name ); ?>
										</a>
									<?php endif; ?>
								</h2>

								<?php

								if( $item->is_type( 'variable' ) ) {
								?>
									<form class="variations_form cart" action="<?php echo esc_url( $item->get_permalink() ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $item->get_id() ); ?>">
										<?php echo Ecomus\Addons\Modules\Product_Bought_Together\Variation_Select::instance()->render( $item ); ?>
									</form>
								<?php
								}

								if ( ! $item->is_type( 'variable' ) && $discount && $discount > 0 ) :
									$classPrice = ( ! empty( $checked_all ) || empty( $checked_all ) ) && $quantity_discount_all <= $countProduct ? '' : 'hidden';
									$sale_price = $item->get_price() * ( 100 - (float) $discount ) / 100;
									$save_price = $item->get_price() - $sale_price;
									$_price = $item->get_price();

									if( WC()->cart->display_prices_including_tax() ) {
										$_price = wc_get_price_including_tax( $item, array( 'price' => $_price ) );
										$sale_price = wc_get_price_including_tax( $item, array( 'price' => $sale_price ) );
									}

									$priceHTML[] = sprintf( '<div class="price price-new %s">%s</div>',
														esc_attr( $classPrice ),
														wc_format_sale_price( $_price, $sale_price ) . $item->get_price_suffix( $sale_price )
													);

									$classPrice = empty( $classPrice ) ? 'price-ori hidden' : 'price-ori';
								endif;

								$priceHTML[] = sprintf( '<div class="price %s">%s</div>',
												esc_attr( $classPrice ),
												wp_kses_post( $item->get_price_html() )
											);

								echo implode( '', $priceHTML );
								?>

							</div>
						</div>
					</li>
					<?php
					$list[] = sprintf(
								'<div class="product-select--list %s %s" data-id="%s">
									<div class="product-select__check inline-flex">
										<span class="select %s"></span>
										%s
									</div>
									%s
									<div class="product-select__price inline-block">%s</div>
								 </div>',
								$item->get_id() == $product->get_id() ? 'product-primary product-current' : '',
								$item->get_id() !== $product->get_id() && empty( $checked_all ) ? 'uncheck' : '',
								esc_attr( $item->get_id() ),
								$current_class_li == 'product-primary' || ! empty( $checked_all ) ? 'active' : '',
								$current_class_li == 'product-primary' ? '<span class="product-select__name"><span>' . esc_html__( 'This item:', 'ecomus-addons' ) . '</span> ' . esc_html( $product_name ) . '</span>' : '<a class="product-select__name woocommerce-LoopProduct-link woocommerce-loop-product__link" href="'. esc_url( $item->get_permalink() ) .'">' . esc_html( $product_name ) . '</a>',
								$item->is_type( 'variable' ) ? '<form class="product-select__variation variations_form cart inline-block" action="'. esc_url( $item->get_permalink() ) .'" method="post" enctype="multipart/form-data" data-product_id="'. absint( $item->get_id() ) .'">' . Ecomus\Addons\Modules\Product_Bought_Together\Variation_Select::instance()->render( $item ) . '</form>' : '',
								implode( '', $priceHTML ),
							);
				}
				?>
			</ul>
			<div class="ecomus-product-pbt__lists">
				<?php echo implode( '', $list ); ?>
			</div>
		</div>
		<div class="product-buttons">
			<div class="price-box__title"><?php esc_html_e( 'Total price:', 'ecomus-addons' ); ?></div>
			<?php
				if( empty( $checked_all ) ) {
					$pids = $product->get_id();
					$numberProduct = count( (array) $pids );
				} else {
					$numberProduct = count( $pids );
					$pids = implode( ',', $pids );
				}

				$suffixItem = $item;

				if( $suffixItem && $suffixItem->get_type() == 'variable' ) {
					$suffixItem = new \WC_Product_Variation( $suffixItem->get_children()[0] );
				}
			?>
		<?php if( $discount && $discount > 0 ) : ?>
			<div class="price-box price-box__subtotal hidden">
				<span class="label"><?php esc_html_e( 'SubTotal: ', 'ecomus-addons' ); ?></span>
				<span class="s-price ecomus-pbt-subtotal"><?php echo wc_price( $total_price ); ?></span>
				<input type="hidden" data-price="<?php echo esc_attr( $total_price ); ?>" id="ecomus-data_subtotal">
			</div>
			<div class="price-box price-box__save hidden">
				<span class="label"><?php esc_html_e( 'Save: ', 'ecomus-addons' ); ?></span>
				<span class="s-price ecomus-pbt-save-price"><?php echo wc_price( $quantity_discount_all <= $numberProduct ? $total_save_price : 0 ); ?> (<span class="percent"><?php echo esc_html( $quantity_discount_all <= $numberProduct ? $discount : 0 ); ?></span>%)</span>
				<input type="hidden" data-price="<?php echo esc_attr( $total_save_price ); ?>" id="ecomus-data_save-price">
				<input type="hidden" data-discount="<?php echo esc_attr( $discount ); ?>" id="ecomus-data_discount-all">
				<input type="hidden" data-quantity="<?php echo esc_attr( $quantity_discount_all ); ?>" id="ecomus-data_quantity-discount-all">
				<input type="hidden" data-check_all="<?php echo esc_attr( $checked_all ); ?>" id="ecomus-data_check-all">
			</div>
			<?php $total_price_new = $quantity_discount_all <= $numberProduct ? $total_save_price : $total_price; ?>
		<?php else : ?>
			<div class="price-box price-box__subtotal hidden">
				<input type="hidden" data-price="<?php echo esc_attr( isset( $total_price_new ) ? $total_price_new : $total_price ); ?>" id="ecomus-data_subtotal">
			</div>
		<?php endif; ?>
			<div class="price-box price-box__total">
				<span class="price-box__total-title"><?php esc_html_e( 'Total price:', 'ecomus-addons' ); ?></span>
				<span class="s-price ecomus-pbt-total-price <?php echo isset( $total_price_new ) && ( $total_price_new < $total_price ) ? 'ins' : ''; ?>"><?php echo wc_price( isset( $total_price_new ) ? $total_price_new : $total_price ); ?></span>
				<span class="s-price ecomus-pbt-subtotal <?php echo ! isset( $total_price_new ) ? 'hidden' : ''; ?> <?php echo isset( $total_price_new ) && ( $total_price_new >= $total_price ) ? 'hidden' : ''; ?>"><?php echo wc_price( $total_price ); ?></span>
				<?php echo $product->is_type( 'variable' ) ? $suffixItem->get_price_suffix( '0' ) : $product->get_price_suffix( isset( $total_price_new ) ? $total_price_new : $total_price ); ?>
				<input type="hidden" data-price="<?php echo esc_attr( isset( $total_price_new ) ? $total_price_new : $total_price ); ?>" id="ecomus-data_price">
				<input type="hidden" data-price="<?php echo esc_attr( $total_save_price ); ?>" id="ecomus-data_save_price">
			</div>
			<form class="pbt-cart cart" action="<?php echo esc_url( $product->get_permalink() ); ?>" method="post"
					enctype="multipart/form-data">
				<input class="ecomus_current_product_id" name="ecomus_current_product_id" type="hidden" data-title="<?php echo esc_attr( $product->get_name() ); ?>" value="<?php echo esc_attr( $product->get_id() ); ?>">
				<input class="ecomus_product_id" name="ecomus_product_id" type="hidden" data-title="<?php echo esc_attr( $product->get_name() ); ?>" value="<?php echo esc_attr( $product->is_type( 'variable' ) || ! $product->is_in_stock() ? 0 : $product->get_id() ); ?>">
				<input type="hidden" name="ecomus_variation_id" class="ecomus_variation_id" value="0">
				<input type="hidden" name="ecomus_variation_attrs" class="ecomus_variation_attrs" value="0">
				<input name="ecomus_pbt_ids" type="hidden" value="<?php echo esc_attr( $pids ); ?>">
				<button type="submit" name="ecomus_pbt_add_to_cart" value="<?php echo esc_attr( $pids ); ?>" class="ecomus-pbt-add-to-cart em-button-primary"><?php esc_html_e( 'Add Selected To Cart', 'ecomus-addons' ); ?></button>
			</form>
		</div>
	</div>
	<div class="ecomus-pbt-alert woocommerce-message hidden"></div>
</div>
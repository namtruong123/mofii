<?php
/*--------------------------------------------------------------
  1. KẾ THỪA STYLE TỪ CHILD THEME
--------------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'ecomus_child_enqueue_scripts', 20 );
function ecomus_child_enqueue_scripts() {
    wp_enqueue_style( 'ecomus-child-style', get_stylesheet_uri() );
}

/*--------------------------------------------------------------
  2. THÔNG TIN XUẤT HÓA ĐƠN VAT
--------------------------------------------------------------*/
add_action('woocommerce_after_checkout_billing_form','devvn_xuat_hoa_don_vat');
function devvn_xuat_hoa_don_vat(){
    ?>
    <style>
        .devvn_xuat_hoa_don_do {
            padding: 0px 31px 0px;
            border-radius: 3px;
            clear: both;
        }
        .devvn_xuat_vat_wrap {
            display: none;
        }
        label.devvn_xuat_vat_input_label {
            display: block;
            cursor: pointer;
            margin-bottom: 0;
        }
        .devvn_xuat_vat_wrap fieldset {
            margin: 10px 0;
            padding: 10px;
            background: transparent;
            border: 1px solid #b0aeae;
        }
        .devvn_xuat_vat_wrap fieldset legend {
            background: transparent;
            padding: 0 5px;
            margin: 0 0 0 10px;
            font-size: 14px;
            display: inline;
            border: 0;
            color: #000;
        }
        .devvn_xuat_vat_wrap fieldset p {
            margin-bottom: 10px;
        }
        .devvn_xuat_vat_wrap fieldset p:last-child {
            margin-bottom: 0;
        }
        .vat_active .devvn_xuat_vat_wrap {
            display: block;
        }
    </style>
    <div class="devvn_xuat_hoa_don_do">
        <label class="devvn_xuat_vat_input_label">
            <input class="devvn_xuat_vat_input" type="checkbox" name="devvn_xuat_vat_input" value="1">
            Xuất hóa đơn VAT
        </label>
        <div class="devvn_xuat_vat_wrap">
            <fieldset>
                <legend>Thông tin xuất hóa đơn:</legend>
                <p class="form-row form-row-first" id="billing_vat_company_field">
                    <label for="billing_vat_company">Tên công ty <abbr class="required">*</abbr></label>
                    <input type="text" class="input-text" name="billing_vat_company" id="billing_vat_company" value="">
                </p>
                <p class="form-row form-row-last" id="billing_vat_mst_field">
                    <label for="billing_vat_mst">Mã số thuế <abbr class="required">*</abbr></label>
                    <input type="text" class="input-text" name="billing_vat_mst" id="billing_vat_mst" value="">
                </p>
                <p class="form-row form-row-wide" id="billing_vat_companyaddress_field">
                    <label for="billing_vat_companyaddress">Địa chỉ <abbr class="required">*</abbr></label>
                    <input type="text" class="input-text" name="billing_vat_companyaddress" id="billing_vat_companyaddress" value="">
                </p>
            </fieldset>
        </div>
    </div>
    <script type="text/javascript">
        (function($){
            $(document).ready(function () {
                function check_vat(){
                    var parentVAT = $('input.devvn_xuat_vat_input').closest('.devvn_xuat_hoa_don_do');
                    if($('input.devvn_xuat_vat_input').is(":checked")){
                        parentVAT.addClass('vat_active');
                    }else{
                        parentVAT.removeClass('vat_active');
                    }
                }
                check_vat();
                $('input.devvn_xuat_vat_input').on('change', function () {
                    check_vat();
                });
            });
        })(jQuery);
    </script>
    <?php
}

// Kiểm tra và báo lỗi nếu người dùng chọn xuất VAT nhưng chưa nhập đủ thông tin
add_action('woocommerce_checkout_process', 'vat_checkout_field_process');
function vat_checkout_field_process() {
    if (!empty($_POST['devvn_xuat_vat_input'])) {
        if (empty($_POST['billing_vat_company'])) {
            wc_add_notice(__('Hãy nhập tên công ty'), 'error');
        }
        if (empty($_POST['billing_vat_mst'])) {
            wc_add_notice(__('Hãy nhập mã số thuế'), 'error');
        }
        if (empty($_POST['billing_vat_companyaddress'])) {
            wc_add_notice(__('Hãy nhập địa chỉ công ty'), 'error');
        }
    }
}

// Lưu thông tin VAT vào meta đơn hàng
add_action('woocommerce_checkout_update_order_meta', 'vat_checkout_field_update_order_meta');
function vat_checkout_field_update_order_meta($order_id) {
    $order = wc_get_order($order_id);
    if ($order && !is_wp_error($order) && !empty($_POST['devvn_xuat_vat_input'])) {
        $order->update_meta_data('devvn_xuat_vat_input', intval($_POST['devvn_xuat_vat_input']));
        if (!empty($_POST['billing_vat_company'])) {
            $order->update_meta_data('billing_vat_company', sanitize_text_field($_POST['billing_vat_company']));
        }
        if (!empty($_POST['billing_vat_mst'])) {
            $order->update_meta_data('billing_vat_mst', sanitize_text_field($_POST['billing_vat_mst']));
        }
        if (!empty($_POST['billing_vat_companyaddress'])) {
            $order->update_meta_data('billing_vat_companyaddress', sanitize_text_field($_POST['billing_vat_companyaddress']));
        }
        $order->save();
    }
}

// Hiển thị thông tin VAT trong trang quản trị đơn hàng
add_action('woocommerce_admin_order_data_after_shipping_address', 'devvn_after_shipping_address_vat', 99);
function devvn_after_shipping_address_vat($order){
    $devvn_xuat_vat_input = $order->get_meta('devvn_xuat_vat_input');
    $billing_vat_company = $order->get_meta('billing_vat_company');
    $billing_vat_mst = $order->get_meta('billing_vat_mst');
    $billing_vat_companyaddress = $order->get_meta('billing_vat_companyaddress');
    ?>
    <p><strong>Xuất hóa đơn:</strong> <?php echo ($devvn_xuat_vat_input) ? 'Có' : 'Không';?></p>
    <?php if($devvn_xuat_vat_input): ?>
        <p>
            <strong>Thông tin xuất hóa đơn:</strong><br>
            Tên công ty: <?php echo $billing_vat_company;?><br>
            Mã số thuế: <?php echo $billing_vat_mst;?><br>
            Địa chỉ: <?php echo $billing_vat_companyaddress;?><br>
        </p>
    <?php endif;
}

/*--------------------------------------------------------------
  3. YÊU CẦU ĐĂNG NHẬP MỚI ĐƯỢC DÙNG COUPON
--------------------------------------------------------------*/
add_filter('woocommerce_coupon_is_valid', function($is_valid, $coupon) {
    if (!is_user_logged_in()) {
        wc_add_notice(__('Bạn cần đăng nhập để sử dụng mã ưu đãi!'), 'error');
        return false;
    }
    return $is_valid;
}, 10, 2);

/*--------------------------------------------------------------
  4. HIỂN THỊ QR CODE THANH TOÁN BACS Ở TRANG THANK YOU
--------------------------------------------------------------*/
add_action('woocommerce_thankyou_bacs', function($order_id){
    $bacs_info = get_option('woocommerce_bacs_accounts');
    if(!empty($bacs_info) && count($bacs_info) > 0):
        $order = wc_get_order($order_id);
        $order_number = $order->get_order_number();
        $first_name = $order->get_billing_first_name();
        $last_name = $order->get_billing_last_name();
        $full_name = trim("{$first_name} {$last_name}");
       $content = "{$order_number}" . chr(45) . " {$full_name}";
        ?>
        <div class="vdh_qr_code">
            <?php foreach($bacs_info as $item): ?>
                <span class="vdh_bank_item">
                    <img class="img_qr_code"
                         src="https://img.vietqr.io/image/<?php echo $item['bank_name']; ?>-<?php echo $item['account_number']; ?>-print.jpg?amount=<?php echo $order->get_total(); ?>&addInfo=<?php echo urlencode($content); ?>&accountName=<?php echo $item['account_name']; ?>"
                         alt="QR Code">
                </span>
            <?php endforeach; ?>

            <div id="modal_qr_code" class="modal">
                <img class="modal-content" id="img01">
            </div>
        </div>

        <style>
		.vdh_qr_code {
			display: flex;
			justify-content: center; /* Căn giữa theo chiều ngang */
			align-items: center;     /* Căn giữa theo chiều dọc */
			gap: 20px;              /* Khoảng cách giữa các QR */
			flex-wrap: wrap;        /* Xuống hàng nếu quá rộng */
			text-align: center;
		}

		.vdh_bank_item {
			width: auto; 
			display: inline-block; 
			margin: 0 auto;
		}

		.vdh_bank_item img {
			width: 460px; /* Tăng kích thước QR */
			border-radius: 5px;
			cursor: pointer;
			transition: .3s;
			display: block;
			margin: 0 auto;
		}

		.vdh_bank_item img:hover {
			opacity: .7;
		}

		.modal {
			display: none;
			position: fixed;
			z-index: 999999;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: rgba(0,0,0,.9);
		}

		.modal-content {
			margin: auto;
			display: block;
			height: 100%;
		}

		@media only screen and (max-width: 768px) {
			.modal-content {
				height: auto;
			}
			.vdh_bank_item img {
				width: 80%; /* Để QR tự co khi màn hình nhỏ */
				max-width: 300px;
			}
		}
        </style>

        <script>
            const modal = document.getElementById('modal_qr_code');
            const modalImg = document.getElementById("img01");
            document.querySelectorAll('.img_qr_code').forEach(img => {
                img.onclick = function(){
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    modalImg.alt = this.alt;
                }
            });
            modal.onclick = function() {
                modalImg.className += " out";
                setTimeout(() => {
                    modal.style.display = "none";
                    modalImg.className = "modal-content";
                }, 400);
            }
        </script>
    <?php
    endif;
});



// Xử lý AJAX cập nhật phương thức thanh toán
function custom_shipping_payment_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function updatePaymentMethods() {
                let shippingMethod = $('input[name="shipping_method[0]"]:checked').attr('id');

                // Ẩn phương thức thanh toán custom_payment nếu chọn shipping_method_0_local_pickup32
                 if ( shippingMethod === 'shipping_method_0_flat_rate11' || shippingMethod ==='shipping_method_0_flat_rate5') 
				 {
                    $('.wc_payment_method.payment_method_custom_payment').hide();
                } else {
                    $('.wc_payment_method.payment_method_custom_payment').show();
                }
				
				 // Ẩn phương thức thanh toán custom_payment nếu chọn shipping_method_0_local_pickup32
                 if ( shippingMethod === 'shipping_method_0_local_pickup32' || shippingMethod === 'shipping_method_0_local_pickup17') 
				 {
                     $('.wc_payment_method.payment_method_bacs, .wc_payment_method.payment_method_cod').hide();
                } else {
                    $('.wc_payment_method.payment_method_bacs, .wc_payment_method.payment_method_cod').show();
                }
            }

            // Kiểm tra khi trang tải
            updatePaymentMethods();

            // Kiểm tra khi thay đổi phương thức vận chuyển
            $(document).on('change', 'input[name="shipping_method[0]"]', function() {
                updatePaymentMethods();
            });

            // Kiểm tra lại mỗi khi WooCommerce cập nhật checkout
            $(document.body).on('updated_checkout', function() {
                updatePaymentMethods();
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_shipping_payment_script', 100);

function custom_add_to_cart_script() {
    ?>
    <script type="text/javascript">
        window.addEventListener("load", function () {
            function updateButtonText() {
                const selectColor = document.querySelector("#pa_mau-sac");
                const addToCartButton = document.querySelector(".single_add_to_cart_button .text");

                if (selectColor && addToCartButton) {
                    addToCartButton.textContent = selectColor.value
                        ? "Thêm vào giỏ hàng"
                        : "⭡ Nhấn chọn màu sắc bên trên";
                }
            }

            // Chạy ngay khi trang load
            updateButtonText();

            // Lắng nghe khi chọn màu
            document.addEventListener("change", function (event) {
                if (event.target && event.target.id === "pa_mau-sac") {
                    updateButtonText();
                }
            });

            // Theo dõi thay đổi của toàn bộ nút "Thêm vào giỏ hàng"
            const observer = new MutationObserver(() => {
                updateButtonText();
            });

            const addToCartButton = document.querySelector(".single_add_to_cart_button");
            if (addToCartButton) {
                observer.observe(addToCartButton, { childList: true, subtree: true });
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_add_to_cart_script', 100);


function custom_add_to_cart_quickview_script() {
    ?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("quick-view-modal");

            if (!modal) return;

            // Kiểm tra xem modal có đang mở không
            function isModalOpen() {
                return modal.classList.contains("modal--open");
            }

            // Kiểm tra màu sắc đã được chọn chưa
            function checkColorSelection() {
                const selectColor = document.querySelector("#pa_mau-sac");
                const addToCartText = document.querySelector(".single_add_to_cart_button .text");

                if (!selectColor || !addToCartText) return;

                if (!selectColor.value) {
                    addToCartText.textContent = "⭡ Nhấn chọn màu sắc bên trên";
                } else {
                    addToCartText.textContent = "Thêm vào giỏ hàng";
                }
            }

            // Kiểm tra khi modal mở
            setInterval(function () {
                if (isModalOpen()) {
                    checkColorSelection();
                }
            }, 500); // Kiểm tra mỗi 500ms

            // Lắng nghe khi chọn màu sắc
            document.addEventListener("change", function (event) {
                if (event.target && event.target.id === "pa_mau-sac") {
                    checkColorSelection();
                }
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_add_to_cart_quickview_script', 100);

function custom_add_to_cart_buynow_script() {
    ?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("quick-add-modal");

            if (!modal) return;

            // Kiểm tra xem modal có đang mở không
            function isModalOpen() {
                return modal.classList.contains("modal--open");
            }

            // Kiểm tra màu sắc đã được chọn chưa
            function checkColorSelection() {
                const selectColor = document.querySelector("#pa_mau-sac");
                const addToCartText = document.querySelector(".single_add_to_cart_button .text");

                if (!selectColor || !addToCartText) return;

                if (!selectColor.value) {
                    addToCartText.textContent = "⭡ Nhấn chọn màu sắc bên trên";
                } else {
                    addToCartText.textContent = "Thêm vào giỏ hàng";
                }
            }

            // Kiểm tra khi modal mở
            setInterval(function () {
                if (isModalOpen()) {
                    checkColorSelection();
                }
            }, 500); // Kiểm tra mỗi 500ms

            // Lắng nghe khi chọn màu sắc
            document.addEventListener("change", function (event) {
                if (event.target && event.target.id === "pa_mau-sac") {
                    checkColorSelection();
                }
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_add_to_cart_buynow_script', 100);





function custom_add_radio_ids_script() {
    $script = "
    document.addEventListener('DOMContentLoaded', function () {
        let storeRadios = document.querySelectorAll(\"input[name='custom_payment_4']\");
        let paymentRadios = document.querySelectorAll(\"input[name='custom_payment_3']\");

        storeRadios.forEach((radio, index) => {
            radio.id = `custom_payment_4_\${index + 1}`;
        });

        paymentRadios.forEach((radio, index) => {
            radio.id = `custom_payment_3_\${index + 1}`;
        });
    });
    ";
    
    wp_add_inline_script('jquery', $script);
}
add_action('wp_footer', 'custom_add_radio_ids_script');



add_action('woocommerce_checkout_order_processed', 'update_payment_method_from_radio', 10, 2);
function update_payment_method_from_radio($order_id, $data) {
    if (isset($_POST['custom_payment_3'])) {
        $selected_payment = trim($_POST['custom_payment_3']);

        // Kiểm tra xem có chuỗi 'Chuyển khoản' không
        if (strpos($selected_payment, 'Chuyển khoản') !== false) {
            // Cập nhật payment method thành bacs
            $order = wc_get_order($order_id);
            $order->set_payment_method('bacs');
            $order->save();
        }
    }
}


/* sử lý tên địa chỉ cửa hàng ở phần thanks u */

add_action('woocommerce_checkout_create_order', 'save_store_pickup_to_order', 20, 2);
function save_store_pickup_to_order($order, $data) {
    if ( isset($_POST['custom_payment_4']) ) {
        // Loại bỏ khoảng trắng thừa và lưu lựa chọn
        $store_pickup = sanitize_text_field($_POST['custom_payment_4']);
        $order->update_meta_data('_store_pickup', $store_pickup);
    }
}

add_action('woocommerce_thankyou', 'custom_display_store_pickup_payment_method', 20);
function custom_display_store_pickup_payment_method($order_id){
    $order = wc_get_order($order_id);
    $store_pickup = $order->get_meta('_store_pickup');
    if($store_pickup){
        ?>
        <script>
        document.addEventListener("DOMContentLoaded", function(){
            var paymentMethodStrong = document.querySelector(".woocommerce-order-overview__payment-method.method strong");
            if(paymentMethodStrong){
                paymentMethodStrong.textContent = "<?php echo esc_js($store_pickup); ?>";
            }
        });
        </script>
        <?php
    }
}
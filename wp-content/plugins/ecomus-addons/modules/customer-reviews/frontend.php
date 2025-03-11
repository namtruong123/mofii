<?php

namespace Ecomus\Addons\Modules\Customer_Reviews;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Frontend {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;

	private $limit = 5000000;
	private $size = 3;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->limit = get_option( 'ecomus_customer_reviews_upload_limit', 5 );
		$this->size  = 1024 * 1024 * get_option( 'ecomus_customer_reviews_upload_size', 25 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action('woocommerce_review_after_comment_text', array( $this, 'display_review_attachments' ) );

		add_action( 'woocommerce_product_review_comment_form_args', array( $this, 'custom_fields_attachment' ) );
		add_action( 'comment_post', array( $this, 'handle_file_upload_in_comment' ), 10, 2 );
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'ecomus-customer-reviews', ECOMUS_ADDONS_URL . 'modules/customer-reviews/assets/customer-reviews.css', array(), '1.0.0' );
		wp_enqueue_script( 'ecomus-customer-reviews', ECOMUS_ADDONS_URL . 'modules/customer-reviews/assets/customer-reviews.js',  array('jquery'), '1.0.0' );

		if( $this->upload_video() ) {
			$label = sprintf( __( 'Upload images or videos (Max %d files)', 'ecomus-addons' ), intval( $this->limit ) );
			$message = sprintf( __( 'Upload up to %d images or videos', 'ecomus-addons' ), intval( $this->limit ) );
			$file_type = __( 'Error: accepted file types are PNG, JPG, JPEG, GIF, MP4, MPEG, OGG, WEBM, MOV, AVI', 'ecomus-addons' );
		} else {
			$label = sprintf( __( 'Upload images (Max %d files)', 'ecomus-addons' ), intval( $this->limit ) );
			$message = sprintf( __( 'Upload up to %d images', 'ecomus-addons' ), intval( $this->limit ) );
			$file_type = __( 'Error: accepted file types are PNG, JPG, JPEG, GIF', 'ecomus-addons' );
		}

		wp_localize_script(
			'ecomus-customer-reviews',
			'ecomusCRA',
			array(
				'ajax_url'     => admin_url( 'admin-ajax.php' ),
				'upload_video' => $this->upload_video(),
				'limit'    	   => intval( $this->limit ),
				'size' 		   => intval( $this->size ),
				'label'        => $label,
				'message'      => $message,
				'error'        => array(
					'file_type'   => $file_type,
					'too_many'    => sprintf( __( 'Error: You tried to upload too many files. The maximum number of files that can be uploaded is %d.', 'ecomus-addons' ), intval( $this->limit ) ),
					'file_size'   => sprintf( __( 'The file cannot be uploaded because its size exceeds the limit of %d MB', 'ecomus-addons' ), intval( $this->size / 1024 / 1024 ) ),
				),
			)
		);
	}

	public function display_review_attachments( $comment ) {
		$attachment_ids = get_comment_meta( $comment->comment_ID, 'ecomus_customer_reviews_upload_files', true );
		$thumbnail_url = ! empty( wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' )[0] : wc_placeholder_img_src();
		$thumbnail_url = ! empty( $thumbnail_url ) ? $thumbnail_url : wc_placeholder_img_src();

		if( ! $comment->comment_approved ) {
			return;
		}
		
		if ( empty( $attachment_ids[0] ) ) {
			return;
		}
		
		?>
		<div class="ecomus-customer-reviews__attachments">
			<?php foreach ($attachment_ids as $attachment_id) :
				$type = wp_attachment_is( 'video', $attachment_id ) ? 'video' : 'image';

				if( $type == 'video' && ! $this->upload_video() ) {
					continue;
				}

				?>
				<div class="ecomus-customer-reviews__attachment" data-type="<?php echo esc_attr( $type ); ?>">
					<?php echo $type == 'image' ? wp_get_attachment_link( $attachment_id, 'full' ) : '<a href="'. esc_url( wp_get_attachment_url( $attachment_id ) ) .'"><img src="'.  esc_url( $thumbnail_url ) .'" atl="'. esc_attr( $comment->comment_author ) .'" />'. \Ecomus\Addons\Helper::get_svg( 'play', 'ui', 'class=ecomus-customer-reviews__play' ) .'</a>'; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	public function custom_fields_attachment( $comment_form ) {
		$post_id = get_the_ID();
		$thumbnail_url = ! empty( wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' )[0] : wc_placeholder_img_src();
		$thumbnail_url = ! empty( $thumbnail_url ) ? $thumbnail_url : wc_placeholder_img_src();

		if( $this->upload_video() ) {
			$label = sprintf( __( 'Upload images or videos (Max %d files)', 'ecomus-addons' ), intval( $this->limit ) );
			$accept = 'image/*, video/*';
		} else {
			$label = sprintf( __( 'Upload images (Max %d files)', 'ecomus-addons' ), intval( $this->limit ) );
			$accept = 'image/*';
		}

		$comment_form['comment_field'] .= apply_filters( 'ecomus_customer_reviews_custom_fields_attachment_html',
												'<div class="ecomus-customer-reviews">
													<div class="ecomus-customer-reviews__items"></div>
													<label for="ecomus_customer_reviews_files" class="ecomus-customer-reviews__message">'. $label .'</label>
													<input type="file" accept="'. esc_attr( $accept ) .'" multiple="multiple" name="ecomus_customer_reviews_files[]" id="ecomus-customer-reviews-files" data-nonce="'. wp_create_nonce( 'ecomus-customer-reviews-upload-frontend' ) .'" data-postid="'. esc_attr( $post_id ) .'" />
													<input type="hidden" name="thumbnail_url" value="'. esc_url( $thumbnail_url ) .'" />
												</div>'
											);

		return apply_filters( 'ecomus_customer_reviews_custom_fields_attachment', $comment_form );
	}

	public function handle_file_upload_in_comment( $comment_id, $comment ) {
		if( ! empty( $_FILES['ecomus_customer_reviews_files']['name'][0] ) ) {
			$files = $_FILES['ecomus_customer_reviews_files'];
		
			if( count( $files['name'] ) > $this->limit ) {
				$commentdata = get_comment( $comment_id );
				$message = '<div class="wp-die-message">' . sprintf( __( 'Error: You tried to upload too many files. The maximum number of files that you can upload is %d.', 'ecomus-addons' ), $this->limit ) . '</div>';
				$message .= '<p>' . sprintf( __( 'Go back to: %s', 'ecomus-addons' ), '<a href="' . get_permalink( $commentdata->comment_post_ID ) . '">' . get_the_title( $commentdata->comment_post_ID ) . '</a>' ) . '</p>';
				wp_die( $message );
				return;
			}

			$args_id = array();
			foreach ( $files['name'] as $key => $filename ) {
				if ( $files['error'][$key] === UPLOAD_ERR_OK ) {
					// Move the uploaded file to a directory
					$file = array(
						'name'     => $files['name'][$key],
						'type'     => $files['type'][$key],
						'tmp_name' => $files['tmp_name'][$key],
						'error'    => $files['error'][$key],
						'size'     => $files['size'][$key],
					);

					$_FILES = array( 'ecomus_customer_reviews_files' => $file );

					foreach ( $_FILES as $file => $array ) {
						$attachment_id = $this->insert_attachment( $file, $comment_id );
						
						// Check if the upload was successful
						if ( is_wp_error( $attachment_id ) ) {
							// Handle error (optional)
							wp_die(__('File upload error: ', 'woocommerce') . $attachment_id->get_error_message());
						} else {
							// Store the attachment URL
							array_push( $args_id, $attachment_id );
						}
					}
				}
			}
	
			 // Save all uploaded file URLs as comment meta
			 if ( ! empty( $args_id )) {
				add_comment_meta($comment_id, 'ecomus_customer_reviews_upload_files', $args_id);
			}
		}
	}

	/**
	 * Add attachment to media library
	 *
	 * @param   int    $postId
	 * @param   string $fileHandler
	 *
	 * @return  void
	 *
	 * @since  1.0
	 * @author Lorenzo Giuffrida
	 */
	public function insert_attachment( $fileHandler, $postId ) {	
		require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/media.php' );
		
		return media_handle_upload( $fileHandler, $postId );
	}

	public function upload_video() {
		if( get_option( 'ecomus_customer_reviews_upload_video' ) == 'yes' ) {
			return true;
		}

		return false;
	}
}
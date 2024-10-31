<?php

class Mch_Preview_On_Editor {


	// <editor-fold desc="定数">
	const APP_PREFIX        = 'mch_poe';
	const APP_TITLE         = 'Preview_On_Editor';
	const APP_LANG_DMN      = 'mch-preview-on-editor';

	const SCRIPT_FILE_EXT   = '.min.js';
//	const SCRIPT_FILE_EXT   = '.js';

	private static $isGutenberg = false;
	const POE_GUTENBERG_ENABLE = false;

	// </editor-fold>


	// <editor-fold desc="util">

	/**
	 * 表示用テキスト
	 * @param string $text
	 * @return string
	 */
	public function _t($text){
		return $text;
	}

	/**
	 * add prefix text
	 * @param string $text
	 * @return string
	 */
	public function __ap($text){
		return $this->add_prefix($text);
	}
	/**
	 * add prefix text
	 * @param $text
	 * @return string
	 */
	private function add_prefix($text) {
		return self::APP_PREFIX . '_' . $text;
	}

	public static function get_object() {
		static $instance = null;
		if ( NULL === $instance ) {
			$instance = new self();
		}
		return $instance;
	}


	/**
	 * @param string $key
	 * @return string
	 */
	private function getPluginData($key){
		static $pluginData = null;

		if($pluginData === null){
			$pluginData = get_file_data(MCH_POE_PLUGIN_DIR . 'mch-preview-on-editor.php', [
				'version' => 'Version',
				'author' => 'Author',
			]);
		}

		if(isset($pluginData[$key])){
			return $pluginData[$key];
		} else {
			return '';
		}
	}

	// </editor-fold>

	public static function myplugin_load_textdomain() {
		load_plugin_textdomain( self::APP_LANG_DMN );
	}


	public function __construct(){

		add_action( 'wp_head',  [$this, 'preview_js'], 1 );

		if ( is_admin() ) {

			add_action( 'enqueue_block_editor_assets', function () {
				self::$isGutenberg = true;
			} );


			$v  = $this->getPluginData('version');

            // <editor-fold desc="テーマの編集">
            add_action('admin_print_styles',  [$this, 'my_admin_print_styles']);
            add_action('admin_print_scripts',  [$this, 'my_admin_print_scripts']);
            // </editor-fold>

			return;
		}
	}


	public function preview_js(){
		global $post;
		if ( ! is_preview() || empty( $post ) ) {
			return;
		}

		$scriptSrc = plugin_dir_url( __FILE__ ). 'js/mch_poe-inner' . self::SCRIPT_FILE_EXT;
		wp_enqueue_script(
			'mch-poe-admin-script-in-preview',
			$scriptSrc
		);

		return;
		?>
        <script></script>
		<?php
    }


	private function isEditorPage(){

		if(get_post_type() === 'page'){
			return true;
		}

		if(get_post_type() === 'post'){
			return true;
		}
        return false;
    }




	function my_admin_print_styles() {
		if( !$this->isEditorPage() ){
			return;
		}

		$styleCssSrc = plugin_dir_url( __FILE__ ). '/css/mch_poe.css';
		if (self::$isGutenberg === true) {
		    if(!self::POE_GUTENBERG_ENABLE){
				return;
            }
			$styleCssSrc = plugin_dir_url( __FILE__ ). '/css/mch_poe_block.css';
        }


		wp_enqueue_style(
		        'mch-poe-admin-style',
			    $styleCssSrc,
                array(),
                '1.0.0' );
	}


	function my_admin_print_scripts() {
		if( !$this->isEditorPage() ){
		    return;
		}

		if (self::$isGutenberg === true) {
			return;
		}
		$scriptSrc = plugin_dir_url( __FILE__ ). '/js/classic/mch_poe' . self::SCRIPT_FILE_EXT;
		if (self::$isGutenberg === true) {
			if(!self::POE_GUTENBERG_ENABLE){
				return;
			}
			$scriptSrc = plugin_dir_url( __FILE__ ). '/js/classic/mch_poe' . self::SCRIPT_FILE_EXT;
		}

		wp_enqueue_script(
			'mch-poe-admin-script',
			$scriptSrc
		);
	}





}


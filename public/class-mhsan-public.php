<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/ShawnLi14
 * @since      1.0.0
 *
 * @package    Mhsan
 * @subpackage Mhsan/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mhsan
 * @subpackage Mhsan/public
 * @author     Shawn Li <shmorganl14@gmail.com>
 */
class Mhsan_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mhsan_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mhsan_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mhsan-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mhsan_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mhsan_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mhsan-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap', "//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js", false );
	}
	public function register_shortcodes() {
		add_shortcode( 'display_signup', array( $this, 'display_signup_form') );
		add_shortcode( 'display_posts', array( $this, 'display_user_post') );
		add_shortcode( 'display_alumni_list', array( $this, 'display_alumni_list') );

	}

	public function display_signup_form(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/signup.php';
	}

	public function display_user_post(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/post.php';
	}
	public function display_alumni_list(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/alumniList.php';
	}
}

<?php
/**
 * Plugin Name: Spawcoin Wallet Connector
 * Plugin URI: https://spawcoin.com
 * Description: Connect crypto wallets (MetaMask, WalletConnect) and enable users to purchase Spawcoin memecoin directly from your website. Supports Ethereum, BSC, and other EVM-compatible chains.
 * Version: 1.0.0
 * Author: Spawcoin Team
 * Author URI: https://spawcoin.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: spawcoin-wallet
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SWC_VERSION', '1.0.0');
define('SWC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SWC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SWC_PLUGIN_FILE', __FILE__);

/**
 * Main Spawcoin Wallet Connector Class
 */
class Spawcoin_Wallet_Connector {

    /**
     * Instance of this class
     */
    private static $instance = null;

    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->init_hooks();
        $this->load_dependencies();
    }

    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('init', array($this, 'load_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));

        // Register shortcodes
        add_shortcode('spawcoin_wallet_button', array($this, 'wallet_button_shortcode'));
        add_shortcode('spawcoin_buy_widget', array($this, 'buy_widget_shortcode'));

        // AJAX handlers
        add_action('wp_ajax_swc_verify_transaction', array($this, 'verify_transaction'));
        add_action('wp_ajax_nopriv_swc_verify_transaction', array($this, 'verify_transaction'));

        // Register activation/deactivation hooks
        register_activation_hook(SWC_PLUGIN_FILE, array($this, 'activate'));
        register_deactivation_hook(SWC_PLUGIN_FILE, array($this, 'deactivate'));
    }

    /**
     * Load plugin dependencies
     */
    private function load_dependencies() {
        require_once SWC_PLUGIN_DIR . 'includes/class-swc-settings.php';
        require_once SWC_PLUGIN_DIR . 'includes/class-swc-transactions.php';
        require_once SWC_PLUGIN_DIR . 'admin/class-swc-admin.php';
    }

    /**
     * Load text domain for translations
     */
    public function load_textdomain() {
        load_plugin_textdomain('spawcoin-wallet', false, dirname(plugin_basename(SWC_PLUGIN_FILE)) . '/languages');
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_frontend_scripts() {
        // Enqueue styles
        wp_enqueue_style(
            'spawcoin-wallet-styles',
            SWC_PLUGIN_URL . 'assets/css/frontend.css',
            array(),
            SWC_VERSION
        );

        // Enqueue Web3.js from CDN
        wp_enqueue_script(
            'web3js',
            'https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js',
            array(),
            null,
            true
        );

        // Enqueue WalletConnect
        wp_enqueue_script(
            'walletconnect',
            'https://cdn.jsdelivr.net/npm/@walletconnect/web3-provider@1.8.0/dist/umd/index.min.js',
            array(),
            null,
            true
        );

        // Enqueue main plugin script
        wp_enqueue_script(
            'spawcoin-wallet-script',
            SWC_PLUGIN_URL . 'assets/js/wallet-connector.js',
            array('jquery', 'web3js'),
            SWC_VERSION,
            true
        );

        // Localize script with plugin settings
        $settings = get_option('swc_settings', array());
        wp_localize_script('spawcoin-wallet-script', 'swcSettings', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('swc_nonce'),
            'contractAddress' => isset($settings['contract_address']) ? $settings['contract_address'] : '',
            'chainId' => isset($settings['chain_id']) ? $settings['chain_id'] : '1',
            'tokenSymbol' => isset($settings['token_symbol']) ? $settings['token_symbol'] : 'SPAWN',
            'tokenDecimals' => isset($settings['token_decimals']) ? $settings['token_decimals'] : '18',
            'receiverAddress' => isset($settings['receiver_address']) ? $settings['receiver_address'] : '',
            'tokenPrice' => isset($settings['token_price']) ? $settings['token_price'] : '0.0001',
            'strings' => array(
                'connectWallet' => __('Connect Wallet', 'spawcoin-wallet'),
                'connected' => __('Connected', 'spawcoin-wallet'),
                'disconnect' => __('Disconnect', 'spawcoin-wallet'),
                'buyNow' => __('Buy Now', 'spawcoin-wallet'),
                'processing' => __('Processing...', 'spawcoin-wallet'),
                'success' => __('Transaction Successful!', 'spawcoin-wallet'),
                'error' => __('Transaction Failed', 'spawcoin-wallet'),
                'insufficientFunds' => __('Insufficient Funds', 'spawcoin-wallet'),
                'userRejected' => __('Transaction Rejected', 'spawcoin-wallet'),
            )
        ));
    }

    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_spawcoin-wallet' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'spawcoin-wallet-admin-styles',
            SWC_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            SWC_VERSION
        );

        wp_enqueue_script(
            'spawcoin-wallet-admin-script',
            SWC_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            SWC_VERSION,
            true
        );
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Spawcoin Wallet', 'spawcoin-wallet'),
            __('Spawcoin Wallet', 'spawcoin-wallet'),
            'manage_options',
            'spawcoin-wallet',
            array($this, 'render_admin_page'),
            'dashicons-money-alt',
            30
        );

        add_submenu_page(
            'spawcoin-wallet',
            __('Transactions', 'spawcoin-wallet'),
            __('Transactions', 'spawcoin-wallet'),
            'manage_options',
            'spawcoin-wallet-transactions',
            array($this, 'render_transactions_page')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('swc_settings_group', 'swc_settings', array($this, 'sanitize_settings'));
    }

    /**
     * Sanitize settings
     */
    public function sanitize_settings($input) {
        $sanitized = array();

        if (isset($input['contract_address'])) {
            $sanitized['contract_address'] = sanitize_text_field($input['contract_address']);
        }

        if (isset($input['chain_id'])) {
            $sanitized['chain_id'] = sanitize_text_field($input['chain_id']);
        }

        if (isset($input['token_symbol'])) {
            $sanitized['token_symbol'] = sanitize_text_field($input['token_symbol']);
        }

        if (isset($input['token_decimals'])) {
            $sanitized['token_decimals'] = absint($input['token_decimals']);
        }

        if (isset($input['receiver_address'])) {
            $sanitized['receiver_address'] = sanitize_text_field($input['receiver_address']);
        }

        if (isset($input['token_price'])) {
            $sanitized['token_price'] = floatval($input['token_price']);
        }

        if (isset($input['network_name'])) {
            $sanitized['network_name'] = sanitize_text_field($input['network_name']);
        }

        if (isset($input['enable_walletconnect'])) {
            $sanitized['enable_walletconnect'] = (bool) $input['enable_walletconnect'];
        }

        return $sanitized;
    }

    /**
     * Render admin page
     */
    public function render_admin_page() {
        include SWC_PLUGIN_DIR . 'admin/views/settings.php';
    }

    /**
     * Render transactions page
     */
    public function render_transactions_page() {
        include SWC_PLUGIN_DIR . 'admin/views/transactions.php';
    }

    /**
     * Wallet button shortcode
     */
    public function wallet_button_shortcode($atts) {
        $atts = shortcode_atts(array(
            'text' => __('Connect Wallet', 'spawcoin-wallet'),
            'class' => 'swc-wallet-button',
        ), $atts);

        ob_start();
        ?>
        <button class="<?php echo esc_attr($atts['class']); ?> swc-connect-btn">
            <span class="swc-wallet-icon">🔗</span>
            <span class="swc-wallet-text"><?php echo esc_html($atts['text']); ?></span>
        </button>
        <div class="swc-wallet-info" style="display:none;">
            <p><strong><?php _e('Connected Address:', 'spawcoin-wallet'); ?></strong> <span class="swc-address"></span></p>
            <p><strong><?php _e('Balance:', 'spawcoin-wallet'); ?></strong> <span class="swc-balance"></span> ETH</p>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Buy widget shortcode
     */
    public function buy_widget_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Buy Spawcoin', 'spawcoin-wallet'),
        ), $atts);

        $settings = get_option('swc_settings', array());
        $token_symbol = isset($settings['token_symbol']) ? $settings['token_symbol'] : 'SPAWN';
        $token_price = isset($settings['token_price']) ? $settings['token_price'] : '0.0001';

        ob_start();
        ?>
        <div class="swc-buy-widget">
            <h3 class="swc-widget-title"><?php echo esc_html($atts['title']); ?></h3>

            <div class="swc-widget-content">
                <!-- Wallet Status -->
                <div class="swc-wallet-status">
                    <button class="swc-connect-btn swc-btn-primary">
                        <span class="swc-wallet-icon">🔗</span>
                        <span class="swc-wallet-text"><?php _e('Connect Wallet', 'spawcoin-wallet'); ?></span>
                    </button>
                    <div class="swc-connected-info" style="display:none;">
                        <p class="swc-address-display"></p>
                        <button class="swc-disconnect-btn"><?php _e('Disconnect', 'spawcoin-wallet'); ?></button>
                    </div>
                </div>

                <!-- Purchase Form -->
                <div class="swc-purchase-form" style="display:none;">
                    <div class="swc-input-group">
                        <label for="swc-amount"><?php printf(__('Amount (%s)', 'spawcoin-wallet'), esc_html($token_symbol)); ?></label>
                        <input type="number" id="swc-amount" class="swc-input" min="1" step="1" value="1000" />
                    </div>

                    <div class="swc-price-display">
                        <p><?php _e('Price:', 'spawcoin-wallet'); ?> <span class="swc-total-price">0.1</span> ETH</p>
                        <p class="swc-exchange-rate"><?php printf(__('1 %s = %s ETH', 'spawcoin-wallet'), esc_html($token_symbol), esc_html($token_price)); ?></p>
                    </div>

                    <button class="swc-buy-btn swc-btn-primary">
                        <span><?php _e('Buy Now', 'spawcoin-wallet'); ?></span>
                    </button>

                    <div class="swc-transaction-status" style="display:none;">
                        <p class="swc-status-message"></p>
                        <a href="#" target="_blank" class="swc-tx-link" style="display:none;"><?php _e('View on Explorer', 'spawcoin-wallet'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Verify transaction (AJAX handler)
     */
    public function verify_transaction() {
        check_ajax_referer('swc_nonce', 'nonce');

        $tx_hash = isset($_POST['tx_hash']) ? sanitize_text_field($_POST['tx_hash']) : '';
        $address = isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '';
        $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

        if (empty($tx_hash) || empty($address)) {
            wp_send_json_error(array('message' => __('Invalid transaction data', 'spawcoin-wallet')));
        }

        // Store transaction in database
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        $wpdb->insert(
            $table_name,
            array(
                'tx_hash' => $tx_hash,
                'wallet_address' => $address,
                'amount' => $amount,
                'status' => 'pending',
                'created_at' => current_time('mysql')
            ),
            array('%s', '%s', '%f', '%s', '%s')
        );

        wp_send_json_success(array(
            'message' => __('Transaction recorded successfully', 'spawcoin-wallet'),
            'tx_id' => $wpdb->insert_id
        ));
    }

    /**
     * Plugin activation
     */
    public function activate() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            tx_hash varchar(66) NOT NULL,
            wallet_address varchar(42) NOT NULL,
            amount decimal(20,8) NOT NULL,
            status varchar(20) NOT NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY tx_hash (tx_hash),
            KEY wallet_address (wallet_address)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Set default options
        $default_settings = array(
            'chain_id' => '1',
            'token_symbol' => 'SPAWN',
            'token_decimals' => '18',
            'token_price' => '0.0001',
            'network_name' => 'Ethereum Mainnet',
            'enable_walletconnect' => true
        );

        if (!get_option('swc_settings')) {
            add_option('swc_settings', $default_settings);
        }
    }

    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Cleanup tasks if needed
    }
}

// Initialize the plugin
function spawcoin_wallet_connector() {
    return Spawcoin_Wallet_Connector::get_instance();
}

// Start the plugin
spawcoin_wallet_connector();

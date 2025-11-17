<?php
/**
 * Admin Handler Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class SWC_Admin {

    public function __construct() {
        add_action('admin_notices', array($this, 'display_admin_notices'));
    }

    /**
     * Display admin notices
     */
    public function display_admin_notices() {
        $settings = SWC_Settings::get_all();

        // Check if contract address is set
        if (empty($settings['contract_address'])) {
            ?>
            <div class="notice notice-warning">
                <p>
                    <?php _e('Spawcoin Wallet Connector: Please configure your token contract address in the', 'spawcoin-wallet'); ?>
                    <a href="<?php echo admin_url('admin.php?page=spawcoin-wallet'); ?>"><?php _e('settings page', 'spawcoin-wallet'); ?></a>.
                </p>
            </div>
            <?php
        }

        // Check if receiver address is set
        if (empty($settings['receiver_address'])) {
            ?>
            <div class="notice notice-warning">
                <p>
                    <?php _e('Spawcoin Wallet Connector: Please configure your receiver wallet address in the', 'spawcoin-wallet'); ?>
                    <a href="<?php echo admin_url('admin.php?page=spawcoin-wallet'); ?>"><?php _e('settings page', 'spawcoin-wallet'); ?></a>.
                </p>
            </div>
            <?php
        }
    }

    /**
     * Get dashboard data
     */
    public static function get_dashboard_data() {
        return array(
            'stats' => SWC_Transactions::get_stats(),
            'recent_transactions' => SWC_Transactions::get_all(10, 0),
            'settings' => SWC_Settings::get_all()
        );
    }
}

new SWC_Admin();

<?php
if (!defined('ABSPATH')) {
    exit;
}

$settings = SWC_Settings::get_all();
$networks = SWC_Settings::get_networks();

// Handle form submission
if (isset($_POST['swc_save_settings']) && check_admin_referer('swc_settings_nonce')) {
    $settings['contract_address'] = sanitize_text_field($_POST['contract_address']);
    $settings['chain_id'] = sanitize_text_field($_POST['chain_id']);
    $settings['token_symbol'] = sanitize_text_field($_POST['token_symbol']);
    $settings['token_decimals'] = absint($_POST['token_decimals']);
    $settings['receiver_address'] = sanitize_text_field($_POST['receiver_address']);
    $settings['token_price'] = floatval($_POST['token_price']);
    $settings['enable_walletconnect'] = isset($_POST['enable_walletconnect']);

    update_option('swc_settings', $settings);
    echo '<div class="notice notice-success"><p>' . __('Settings saved successfully!', 'spawcoin-wallet') . '</p></div>';
}
?>

<div class="wrap swc-admin-wrap">
    <h1><?php _e('Spawcoin Wallet Connector Settings', 'spawcoin-wallet'); ?></h1>

    <div class="swc-admin-header">
        <p class="description">
            <?php _e('Configure your Spawcoin token contract and wallet settings to enable cryptocurrency payments on your website.', 'spawcoin-wallet'); ?>
        </p>
    </div>

    <div class="swc-admin-content">
        <form method="post" action="">
            <?php wp_nonce_field('swc_settings_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="chain_id"><?php _e('Blockchain Network', 'spawcoin-wallet'); ?></label>
                    </th>
                    <td>
                        <select name="chain_id" id="chain_id" class="regular-text">
                            <?php foreach ($networks as $id => $name) : ?>
                                <option value="<?php echo esc_attr($id); ?>" <?php selected($settings['chain_id'], $id); ?>>
                                    <?php echo esc_html($name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="description"><?php _e('Select the blockchain network where your token is deployed.', 'spawcoin-wallet'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="contract_address"><?php _e('Token Contract Address', 'spawcoin-wallet'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="contract_address" id="contract_address" value="<?php echo esc_attr($settings['contract_address']); ?>" class="regular-text code" placeholder="0x..." />
                        <p class="description"><?php _e('Your Spawcoin token contract address (starts with 0x).', 'spawcoin-wallet'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="receiver_address"><?php _e('Receiver Wallet Address', 'spawcoin-wallet'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="receiver_address" id="receiver_address" value="<?php echo esc_attr($settings['receiver_address']); ?>" class="regular-text code" placeholder="0x..." />
                        <p class="description"><?php _e('The wallet address that will receive payments (your treasury wallet).', 'spawcoin-wallet'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="token_symbol"><?php _e('Token Symbol', 'spawcoin-wallet'); ?></label>
                    </th>
                    <td>
                        <input type="text" name="token_symbol" id="token_symbol" value="<?php echo esc_attr($settings['token_symbol']); ?>" class="regular-text" placeholder="SPAWN" />
                        <p class="description"><?php _e('Your token symbol (e.g., SPAWN, BTC, ETH).', 'spawcoin-wallet'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="token_decimals"><?php _e('Token Decimals', 'spawcoin-wallet'); ?></label>
                    </th>
                    <td>
                        <input type="number" name="token_decimals" id="token_decimals" value="<?php echo esc_attr($settings['token_decimals']); ?>" class="small-text" min="0" max="18" />
                        <p class="description"><?php _e('Number of decimals your token uses (usually 18 for ERC-20 tokens).', 'spawcoin-wallet'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="token_price"><?php _e('Token Price (in ETH/BNB)', 'spawcoin-wallet'); ?></label>
                    </th>
                    <td>
                        <input type="number" name="token_price" id="token_price" value="<?php echo esc_attr($settings['token_price']); ?>" class="regular-text" step="0.0000001" min="0" />
                        <p class="description"><?php _e('Price of one token in native currency (ETH for Ethereum, BNB for BSC, etc.).', 'spawcoin-wallet'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <?php _e('WalletConnect', 'spawcoin-wallet'); ?>
                    </th>
                    <td>
                        <label>
                            <input type="checkbox" name="enable_walletconnect" value="1" <?php checked($settings['enable_walletconnect'], true); ?> />
                            <?php _e('Enable WalletConnect support', 'spawcoin-wallet'); ?>
                        </label>
                        <p class="description"><?php _e('Allow users to connect using mobile wallets via WalletConnect.', 'spawcoin-wallet'); ?></p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <button type="submit" name="swc_save_settings" class="button button-primary">
                    <?php _e('Save Settings', 'spawcoin-wallet'); ?>
                </button>
            </p>
        </form>

        <div class="swc-info-box">
            <h3><?php _e('Shortcodes', 'spawcoin-wallet'); ?></h3>
            <p><?php _e('Use these shortcodes to add wallet connection and purchase widgets to your pages:', 'spawcoin-wallet'); ?></p>

            <div class="swc-shortcode-box">
                <code>[spawcoin_wallet_button]</code>
                <p class="description"><?php _e('Displays a simple wallet connection button.', 'spawcoin-wallet'); ?></p>
            </div>

            <div class="swc-shortcode-box">
                <code>[spawcoin_buy_widget]</code>
                <p class="description"><?php _e('Displays a complete purchase widget with wallet connection and token purchase interface.', 'spawcoin-wallet'); ?></p>
            </div>

            <div class="swc-shortcode-box">
                <code>[spawcoin_wallet_button text="Connect Your Wallet" class="custom-class"]</code>
                <p class="description"><?php _e('Customizable wallet button with custom text and CSS class.', 'spawcoin-wallet'); ?></p>
            </div>
        </div>

        <div class="swc-info-box">
            <h3><?php _e('Setup Guide', 'spawcoin-wallet'); ?></h3>
            <ol>
                <li><?php _e('Deploy your ERC-20 token contract or use an existing one', 'spawcoin-wallet'); ?></li>
                <li><?php _e('Copy your token contract address and paste it above', 'spawcoin-wallet'); ?></li>
                <li><?php _e('Set your receiver wallet address (where payments will be sent)', 'spawcoin-wallet'); ?></li>
                <li><?php _e('Configure token price and other settings', 'spawcoin-wallet'); ?></li>
                <li><?php _e('Add shortcodes to your pages where you want to display wallet connection/purchase widgets', 'spawcoin-wallet'); ?></li>
                <li><?php _e('Test the connection with MetaMask or other Web3 wallets', 'spawcoin-wallet'); ?></li>
            </ol>
        </div>
    </div>
</div>

<style>
.swc-admin-wrap {
    max-width: 1200px;
}

.swc-admin-header {
    background: #fff;
    padding: 20px;
    margin: 20px 0;
    border-left: 4px solid #6366f1;
}

.swc-admin-content {
    background: #fff;
    padding: 20px;
}

.swc-info-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    margin-top: 30px;
}

.swc-info-box h3 {
    margin-top: 0;
    color: #6366f1;
}

.swc-shortcode-box {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 15px;
    margin: 10px 0;
}

.swc-shortcode-box code {
    display: block;
    background: #0f172a;
    color: #6366f1;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 10px;
    font-size: 14px;
}
</style>

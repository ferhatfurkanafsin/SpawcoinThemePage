<?php
/**
 * Settings Handler Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class SWC_Settings {

    /**
     * Get all settings
     */
    public static function get_all() {
        $defaults = array(
            'contract_address' => '',
            'chain_id' => '1',
            'token_symbol' => 'SPAWN',
            'token_decimals' => '18',
            'receiver_address' => '',
            'token_price' => '0.0001',
            'network_name' => 'Ethereum Mainnet',
            'enable_walletconnect' => true
        );

        $settings = get_option('swc_settings', $defaults);
        return wp_parse_args($settings, $defaults);
    }

    /**
     * Get single setting
     */
    public static function get($key, $default = '') {
        $settings = self::get_all();
        return isset($settings[$key]) ? $settings[$key] : $default;
    }

    /**
     * Update settings
     */
    public static function update($key, $value) {
        $settings = self::get_all();
        $settings[$key] = $value;
        return update_option('swc_settings', $settings);
    }

    /**
     * Get supported networks
     */
    public static function get_networks() {
        return array(
            '1' => 'Ethereum Mainnet',
            '56' => 'Binance Smart Chain',
            '137' => 'Polygon',
            '43114' => 'Avalanche',
            '250' => 'Fantom',
            '42161' => 'Arbitrum',
            '10' => 'Optimism',
            '5' => 'Goerli Testnet',
            '97' => 'BSC Testnet',
        );
    }

    /**
     * Get network name by chain ID
     */
    public static function get_network_name($chain_id) {
        $networks = self::get_networks();
        return isset($networks[$chain_id]) ? $networks[$chain_id] : 'Unknown Network';
    }

    /**
     * Get explorer URL by chain ID
     */
    public static function get_explorer_url($chain_id) {
        $explorers = array(
            '1' => 'https://etherscan.io',
            '56' => 'https://bscscan.com',
            '137' => 'https://polygonscan.com',
            '43114' => 'https://snowtrace.io',
            '250' => 'https://ftmscan.com',
            '42161' => 'https://arbiscan.io',
            '10' => 'https://optimistic.etherscan.io',
            '5' => 'https://goerli.etherscan.io',
            '97' => 'https://testnet.bscscan.com',
        );

        return isset($explorers[$chain_id]) ? $explorers[$chain_id] : 'https://etherscan.io';
    }
}

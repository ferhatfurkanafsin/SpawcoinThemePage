<?php
/**
 * Transactions Handler Class
 */

if (!defined('ABSPATH')) {
    exit;
}

class SWC_Transactions {

    /**
     * Get all transactions
     */
    public static function get_all($limit = 100, $offset = 0) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table_name ORDER BY created_at DESC LIMIT %d OFFSET %d",
                $limit,
                $offset
            )
        );

        return $results;
    }

    /**
     * Get transaction by ID
     */
    public static function get_by_id($id) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)
        );
    }

    /**
     * Get transaction by hash
     */
    public static function get_by_hash($tx_hash) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE tx_hash = %s", $tx_hash)
        );
    }

    /**
     * Get transactions by wallet address
     */
    public static function get_by_address($address, $limit = 100) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table_name WHERE wallet_address = %s ORDER BY created_at DESC LIMIT %d",
                $address,
                $limit
            )
        );
    }

    /**
     * Insert new transaction
     */
    public static function insert($data) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        $defaults = array(
            'status' => 'pending',
            'created_at' => current_time('mysql')
        );

        $data = wp_parse_args($data, $defaults);

        $wpdb->insert(
            $table_name,
            $data,
            array('%s', '%s', '%f', '%s', '%s')
        );

        return $wpdb->insert_id;
    }

    /**
     * Update transaction status
     */
    public static function update_status($id, $status) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        return $wpdb->update(
            $table_name,
            array('status' => $status),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
    }

    /**
     * Get transaction count
     */
    public static function get_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        return $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    }

    /**
     * Get total volume
     */
    public static function get_total_volume() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        return $wpdb->get_var("SELECT SUM(amount) FROM $table_name WHERE status = 'completed'");
    }

    /**
     * Get stats
     */
    public static function get_stats() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'swc_transactions';

        $stats = array(
            'total_transactions' => self::get_count(),
            'total_volume' => self::get_total_volume(),
            'pending_count' => $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'pending'"),
            'completed_count' => $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'completed'"),
            'failed_count' => $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'failed'"),
        );

        return $stats;
    }
}

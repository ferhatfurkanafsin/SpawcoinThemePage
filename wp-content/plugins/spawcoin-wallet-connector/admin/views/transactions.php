<?php
if (!defined('ABSPATH')) {
    exit;
}

$stats = SWC_Transactions::get_stats();
$transactions = SWC_Transactions::get_all(50, 0);
$settings = SWC_Settings::get_all();
$explorer_url = SWC_Settings::get_explorer_url($settings['chain_id']);
?>

<div class="wrap swc-admin-wrap">
    <h1><?php _e('Transactions', 'spawcoin-wallet'); ?></h1>

    <div class="swc-stats-grid">
        <div class="swc-stat-card">
            <div class="swc-stat-icon">📊</div>
            <div class="swc-stat-content">
                <h3><?php echo esc_html($stats['total_transactions']); ?></h3>
                <p><?php _e('Total Transactions', 'spawcoin-wallet'); ?></p>
            </div>
        </div>

        <div class="swc-stat-card">
            <div class="swc-stat-icon">✅</div>
            <div class="swc-stat-content">
                <h3><?php echo esc_html($stats['completed_count']); ?></h3>
                <p><?php _e('Completed', 'spawcoin-wallet'); ?></p>
            </div>
        </div>

        <div class="swc-stat-card">
            <div class="swc-stat-icon">⏳</div>
            <div class="swc-stat-content">
                <h3><?php echo esc_html($stats['pending_count']); ?></h3>
                <p><?php _e('Pending', 'spawcoin-wallet'); ?></p>
            </div>
        </div>

        <div class="swc-stat-card">
            <div class="swc-stat-icon">💰</div>
            <div class="swc-stat-content">
                <h3><?php echo esc_html(number_format($stats['total_volume'], 4)); ?> <?php echo esc_html($settings['token_symbol']); ?></h3>
                <p><?php _e('Total Volume', 'spawcoin-wallet'); ?></p>
            </div>
        </div>
    </div>

    <div class="swc-transactions-table-wrap">
        <h2><?php _e('Recent Transactions', 'spawcoin-wallet'); ?></h2>

        <?php if (empty($transactions)) : ?>
            <div class="swc-no-transactions">
                <p><?php _e('No transactions yet. Transactions will appear here when users make purchases.', 'spawcoin-wallet'); ?></p>
            </div>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e('ID', 'spawcoin-wallet'); ?></th>
                        <th><?php _e('Transaction Hash', 'spawcoin-wallet'); ?></th>
                        <th><?php _e('Wallet Address', 'spawcoin-wallet'); ?></th>
                        <th><?php _e('Amount', 'spawcoin-wallet'); ?></th>
                        <th><?php _e('Status', 'spawcoin-wallet'); ?></th>
                        <th><?php _e('Date', 'spawcoin-wallet'); ?></th>
                        <th><?php _e('Actions', 'spawcoin-wallet'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $tx) : ?>
                        <tr>
                            <td><?php echo esc_html($tx->id); ?></td>
                            <td>
                                <code class="swc-tx-hash" title="<?php echo esc_attr($tx->tx_hash); ?>">
                                    <?php echo esc_html(substr($tx->tx_hash, 0, 10) . '...' . substr($tx->tx_hash, -8)); ?>
                                </code>
                            </td>
                            <td>
                                <code class="swc-address" title="<?php echo esc_attr($tx->wallet_address); ?>">
                                    <?php echo esc_html(substr($tx->wallet_address, 0, 6) . '...' . substr($tx->wallet_address, -4)); ?>
                                </code>
                            </td>
                            <td><?php echo esc_html(number_format($tx->amount, 4)); ?> <?php echo esc_html($settings['token_symbol']); ?></td>
                            <td>
                                <?php
                                $status_class = '';
                                switch ($tx->status) {
                                    case 'completed':
                                        $status_class = 'swc-status-completed';
                                        break;
                                    case 'pending':
                                        $status_class = 'swc-status-pending';
                                        break;
                                    case 'failed':
                                        $status_class = 'swc-status-failed';
                                        break;
                                }
                                ?>
                                <span class="swc-status-badge <?php echo esc_attr($status_class); ?>">
                                    <?php echo esc_html(ucfirst($tx->status)); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(date('Y-m-d H:i:s', strtotime($tx->created_at))); ?></td>
                            <td>
                                <a href="<?php echo esc_url($explorer_url . '/tx/' . $tx->tx_hash); ?>" target="_blank" class="button button-small">
                                    <?php _e('View on Explorer', 'spawcoin-wallet'); ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<style>
.swc-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.swc-stat-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s;
}

.swc-stat-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.swc-stat-icon {
    font-size: 2.5rem;
    background: linear-gradient(135deg, #6366f1, #ec4899);
    border-radius: 12px;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.swc-stat-content h3 {
    margin: 0;
    font-size: 2rem;
    color: #0f172a;
}

.swc-stat-content p {
    margin: 5px 0 0;
    color: #64748b;
}

.swc-transactions-table-wrap {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

.swc-tx-hash, .swc-address {
    font-family: monospace;
    background: #f8fafc;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.swc-status-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.swc-status-completed {
    background: #d1fae5;
    color: #065f46;
}

.swc-status-pending {
    background: #fef3c7;
    color: #92400e;
}

.swc-status-failed {
    background: #fee2e2;
    color: #991b1b;
}

.swc-no-transactions {
    text-align: center;
    padding: 60px 20px;
    background: #f8fafc;
    border-radius: 8px;
    color: #64748b;
}
</style>

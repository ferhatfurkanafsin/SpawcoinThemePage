# Spawcoin Wallet Connector

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)

A powerful WordPress plugin that enables cryptocurrency wallet connections and token purchases directly on your website. Perfect for memecoins, tokens, and cryptocurrency projects.

## 🚀 Features

### Wallet Support
- **MetaMask Integration**: Seamless MetaMask wallet connection
- **WalletConnect Support**: Connect via mobile wallets
- **Multi-Chain Support**: Ethereum, BSC, Polygon, Avalanche, Fantom, Arbitrum, and more
- **Automatic Network Switching**: Prompts users to switch to the correct network

### Payment Processing
- **Direct Purchases**: Users can buy your token with native currency (ETH/BNB/etc.)
- **Real-time Price Calculation**: Automatically calculates total cost based on amount
- **Transaction Tracking**: Records all purchases in WordPress database
- **Transaction Status**: Shows pending, completed, and failed transactions
- **Explorer Links**: Direct links to view transactions on block explorers

### Admin Features
- **Settings Dashboard**: Easy-to-use admin panel for configuration
- **Transaction Management**: View and monitor all transactions
- **Statistics Dashboard**: Track total sales, volume, and transaction counts
- **Shortcode Generator**: Simple shortcodes for easy integration
- **Network Selection**: Choose from 9+ supported blockchain networks

### Developer Friendly
- **Clean Code**: Well-documented and organized codebase
- **Hooks & Filters**: Extensive customization options
- **AJAX Integration**: Smooth user experience without page reloads
- **Responsive Design**: Works perfectly on all devices

## 📋 Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- A deployed ERC-20 token contract (or compatible token on other chains)
- MetaMask or Web3 wallet for testing

## 🔧 Installation

### Method 1: WordPress Admin Panel

1. Download the plugin ZIP file
2. Go to WordPress Admin → Plugins → Add New
3. Click "Upload Plugin"
4. Choose the ZIP file and click "Install Now"
5. Activate the plugin

### Method 2: Manual Installation

1. Download and extract the plugin files
2. Upload the `spawcoin-wallet-connector` folder to `/wp-content/plugins/`
3. Go to WordPress Admin → Plugins
4. Find "Spawcoin Wallet Connector" and click "Activate"

## ⚙️ Configuration

### Initial Setup

1. **Navigate to Settings**
   - Go to WordPress Admin → Spawcoin Wallet
   - You'll see the plugin settings page

2. **Configure Blockchain Network**
   - Select your token's blockchain (Ethereum, BSC, etc.)
   - The plugin supports 9+ networks including testnets

3. **Add Token Contract Address**
   - Enter your ERC-20 token contract address
   - Format: `0x...` (42 characters)

4. **Set Receiver Wallet**
   - Enter the wallet address that will receive payments
   - This is typically your treasury or project wallet

5. **Configure Token Details**
   - **Token Symbol**: Your token's symbol (e.g., SPAWN)
   - **Token Decimals**: Usually 18 for ERC-20 tokens
   - **Token Price**: Price per token in native currency

6. **Save Settings**
   - Click "Save Settings" to apply your configuration

### Advanced Options

- **WalletConnect**: Enable/disable WalletConnect for mobile wallet support
- **Custom Styling**: Add custom CSS to match your theme

## 📄 Using Shortcodes

### Wallet Connection Button

Basic wallet connection button:
```
[spawcoin_wallet_button]
```

With custom text and class:
```
[spawcoin_wallet_button text="Connect Your Wallet" class="my-custom-class"]
```

### Complete Buy Widget

Full purchase interface with wallet connection and amount input:
```
[spawcoin_buy_widget]
```

With custom title:
```
[spawcoin_buy_widget title="Buy Spawcoin Now"]
```

### Example Usage

Add to any page or post:
1. Edit the page in WordPress
2. Add a shortcode block
3. Paste one of the shortcodes above
4. Publish the page

## 🎨 Customization

### Styling

The plugin includes comprehensive CSS that matches modern crypto websites. You can customize colors by adding to your theme's CSS:

```css
:root {
    --swc-primary: #your-color;
    --swc-secondary: #your-color;
}
```

### JavaScript Hooks

Developers can extend functionality:

```javascript
// After wallet connects
jQuery(document).on('swc_wallet_connected', function(e, account) {
    console.log('Wallet connected:', account);
});

// After successful purchase
jQuery(document).on('swc_purchase_complete', function(e, txHash) {
    console.log('Purchase complete:', txHash);
});
```

## 💰 Supported Networks

| Network | Chain ID | Native Currency |
|---------|----------|----------------|
| Ethereum Mainnet | 1 | ETH |
| Binance Smart Chain | 56 | BNB |
| Polygon | 137 | MATIC |
| Avalanche | 43114 | AVAX |
| Fantom | 250 | FTM |
| Arbitrum | 42161 | ETH |
| Optimism | 10 | ETH |
| Goerli Testnet | 5 | GoerliETH |
| BSC Testnet | 97 | tBNB |

## 📊 Transaction Management

### Viewing Transactions

1. Go to WordPress Admin → Spawcoin Wallet → Transactions
2. View all transactions with details:
   - Transaction hash
   - Wallet address
   - Amount purchased
   - Status (pending/completed/failed)
   - Timestamp

### Dashboard Statistics

The Transactions page shows:
- Total transaction count
- Completed transactions
- Pending transactions
- Total volume sold

### Explorer Links

Click "View on Explorer" to see transaction details on:
- Etherscan (Ethereum)
- BscScan (BSC)
- PolygonScan (Polygon)
- And more...

## 🔒 Security Features

- **Nonce Verification**: All AJAX requests are verified
- **Sanitized Inputs**: All user inputs are sanitized
- **Escaped Outputs**: All outputs are properly escaped
- **Address Validation**: Ethereum addresses are validated
- **Transaction Verification**: All transactions are recorded

## 🐛 Troubleshooting

### Wallet Not Connecting

1. Ensure MetaMask is installed
2. Check that MetaMask is unlocked
3. Verify you're on the correct network
4. Try refreshing the page

### Wrong Network Error

- The plugin will automatically prompt to switch networks
- Click "Switch Network" in MetaMask
- If network isn't added, the plugin will add it automatically

### Transaction Failing

1. Check you have enough native currency (ETH/BNB)
2. Verify the receiver address is correct
3. Ensure gas fees are covered
4. Check blockchain explorer for details

### Settings Not Saving

1. Check file permissions
2. Verify you're logged in as admin
3. Disable other plugins temporarily to check for conflicts

## 💻 Development

### File Structure

```
spawcoin-wallet-connector/
├── admin/
│   ├── class-swc-admin.php
│   └── views/
│       ├── settings.php
│       └── transactions.php
├── assets/
│   ├── css/
│   │   ├── frontend.css
│   │   └── admin.css
│   └── js/
│       ├── wallet-connector.js
│       └── admin.js
├── includes/
│   ├── class-swc-settings.php
│   └── class-swc-transactions.php
├── spawcoin-wallet-connector.php
└── README.md
```

### Database Schema

The plugin creates a `wp_swc_transactions` table:

```sql
CREATE TABLE wp_swc_transactions (
    id bigint(20) AUTO_INCREMENT,
    tx_hash varchar(66),
    wallet_address varchar(42),
    amount decimal(20,8),
    status varchar(20),
    created_at datetime,
    PRIMARY KEY (id)
);
```

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📝 Changelog

### Version 1.0.0 (2025-11-17)
- Initial release
- MetaMask integration
- Multi-chain support
- Transaction tracking
- Admin dashboard
- Shortcode system
- WalletConnect support

## 📄 License

This plugin is licensed under the GNU General Public License v2 or later.

## 🌟 Support

For support and documentation:

1. Check the FAQ section
2. Review the documentation
3. Contact the developer

## 🎯 Roadmap

Future features planned:

- [ ] Support for more wallets (Coinbase Wallet, Trust Wallet)
- [ ] Token swap integration
- [ ] Staking functionality
- [ ] NFT integration
- [ ] Multi-token support
- [ ] Automated price updates from DEX
- [ ] Email notifications for transactions
- [ ] CSV export for transactions
- [ ] Affiliate/referral system

## 🙏 Credits

### Libraries Used
- [Web3.js](https://web3js.org/) - Ethereum JavaScript API
- [WalletConnect](https://walletconnect.com/) - Mobile wallet protocol
- [jQuery](https://jquery.com/) - JavaScript library

---

**Made with ❤️ for the Spawcoin community**

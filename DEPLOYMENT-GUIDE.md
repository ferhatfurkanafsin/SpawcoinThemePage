# Spawcoin Website - Deployment Guide

Complete step-by-step guide to deploy your Spawcoin website to your live hosting (hosting.com.tr) with cPanel.

## 📦 What You Have

- **Custom Spawcoin Theme** (`spawcoin-theme.zip`) - A modern, 3D-animated WordPress theme
- **Wallet Connector Plugin** (`spawcoin-wallet-connector.zip`) - Crypto wallet integration for memecoin purchases
- **Domain**: spawcoin.com
- **Hosting**: hosting.com.tr (cPanel)

---

## 🚀 Part 1: Accessing Your Hosting

### Step 1: Login to cPanel

1. Open your browser and go to: `https://hosting.com.tr/cpanel` or `https://spawcoin.com:2083`
2. Enter your cPanel username and password
3. You should see the cPanel dashboard

---

## 📝 Part 2: Verify WordPress Installation

### Step 1: Check WordPress

1. In cPanel, scroll down to **"Softaculous Apps Installer"** or **"WordPress"** section
2. Click on **"WordPress"** icon
3. Click **"Installations"** to see existing WordPress installations
4. Verify that WordPress is installed on your domain

### Step 2: Access WordPress Admin

1. Go to `https://spawcoin.com/wp-admin`
2. Login with your WordPress admin credentials
3. You should see the WordPress dashboard

---

## 🎨 Part 3: Upload & Activate the Theme

### Method 1: Using WordPress Admin (Recommended)

1. **Login to WordPress Admin**
   - Go to `https://spawcoin.com/wp-admin`
   - Enter your admin credentials

2. **Upload Theme**
   - Click **Appearance → Themes**
   - Click **"Add New"** button at the top
   - Click **"Upload Theme"** button
   - Click **"Choose File"** and select `spawcoin-theme.zip` from your computer
   - Click **"Install Now"**

3. **Activate Theme**
   - After installation completes, click **"Activate"**
   - Your site now has the Spawcoin theme!

4. **Verify Theme**
   - Visit `https://spawcoin.com` to see your new theme live

### Method 2: Using cPanel File Manager

1. **Access File Manager**
   - In cPanel, find and click **"File Manager"**
   - Navigate to `public_html/wp-content/themes/`

2. **Upload Theme ZIP**
   - Click **"Upload"** button at the top
   - Select `spawcoin-theme.zip` and upload
   - Wait for upload to complete

3. **Extract ZIP File**
   - Go back to File Manager
   - Navigate to `public_html/wp-content/themes/`
   - Right-click on `spawcoin-theme.zip`
   - Select **"Extract"**
   - Click **"Extract Files"**
   - Delete the ZIP file after extraction

4. **Activate in WordPress**
   - Go to WordPress Admin → Appearance → Themes
   - Find "Spawcoin" theme
   - Click **"Activate"**

---

## 🔌 Part 4: Upload & Activate the Plugin

### Method 1: Using WordPress Admin (Recommended)

1. **Login to WordPress Admin**
   - Go to `https://spawcoin.com/wp-admin`

2. **Upload Plugin**
   - Click **Plugins → Add New**
   - Click **"Upload Plugin"** button
   - Click **"Choose File"** and select `spawcoin-wallet-connector.zip`
   - Click **"Install Now"**

3. **Activate Plugin**
   - After installation, click **"Activate Plugin"**
   - You'll see "Spawcoin Wallet" in the admin menu

### Method 2: Using cPanel File Manager

1. **Access File Manager**
   - In cPanel, click **"File Manager"**
   - Navigate to `public_html/wp-content/plugins/`

2. **Upload Plugin ZIP**
   - Click **"Upload"**
   - Select `spawcoin-wallet-connector.zip` and upload

3. **Extract ZIP File**
   - Right-click on the uploaded ZIP
   - Select **"Extract"**
   - Delete ZIP after extraction

4. **Activate in WordPress**
   - Go to WordPress Admin → Plugins
   - Find "Spawcoin Wallet Connector"
   - Click **"Activate"**

---

## ⚙️ Part 5: Configure the Wallet Plugin

### Step 1: Access Plugin Settings

1. In WordPress Admin, click **"Spawcoin Wallet"** in the left menu
2. You'll see the Settings page

### Step 2: Configure Blockchain Settings

1. **Select Blockchain Network**
   - Choose your network (e.g., "Binance Smart Chain" for BSC, "Ethereum Mainnet" for ETH)
   - Common choices:
     - **BSC (Binance Smart Chain)** - Lower fees
     - **Ethereum Mainnet** - Most popular but higher fees
     - **Polygon** - Very low fees

2. **Enter Token Contract Address**
   - Paste your Spawcoin token contract address
   - Format: `0x...` (42 characters)
   - Example: `0x1234567890abcdef1234567890abcdef12345678`

3. **Set Receiver Wallet Address**
   - Enter YOUR wallet address where you want to receive payments
   - Format: `0x...` (42 characters)
   - **IMPORTANT**: Make sure you control this wallet!

4. **Configure Token Details**
   - **Token Symbol**: Enter "SPAWN" (or your token symbol)
   - **Token Decimals**: Usually `18` (check your token contract)
   - **Token Price**: Enter price in ETH/BNB (e.g., `0.0001` = 0.0001 ETH per token)

5. **WalletConnect**
   - Check ✅ "Enable WalletConnect support" for mobile wallet compatibility

6. **Save Settings**
   - Click **"Save Settings"**
   - You should see a success message

### Step 3: Get Your Token Information

If you haven't deployed a token yet, you'll need to:

1. **Deploy an ERC-20 Token Contract**
   - Use platforms like:
     - [OpenZeppelin Wizard](https://wizard.openzeppelin.com/)
     - [CoinTool](https://cointool.app/)
     - [Remix IDE](https://remix.ethereum.org/)

2. **Or Use an Existing Token**
   - If you already have a token, get the contract address from:
     - BscScan.com (for BSC)
     - Etherscan.io (for Ethereum)
     - Your token creator platform

---

## 📄 Part 6: Add Buy Widget to Your Pages

### Step 1: Create a "Buy" Page

1. **Create New Page**
   - Go to **Pages → Add New**
   - Title: "Buy Spawcoin"

2. **Add Shortcode**
   - In the page editor, add a Shortcode block
   - Paste this shortcode:
   ```
   [spawcoin_buy_widget]
   ```

3. **Publish Page**
   - Click **"Publish"**
   - Visit the page to see the buy widget

### Step 2: Add to Homepage (Optional)

1. **Edit Homepage**
   - Go to **Pages → All Pages**
   - Edit your homepage (usually called "Home" or "Front Page")

2. **Add Buy Widget**
   - Add a new Shortcode block where you want the widget
   - Paste: `[spawcoin_buy_widget title="Buy SPAWN Now"]`
   - Click **"Update"**

### Step 3: Add to Navigation Menu (Optional)

1. **Create Menu Item**
   - Go to **Appearance → Menus**
   - Select your menu (usually "Primary Menu")
   - Add your "Buy Spawcoin" page to the menu
   - Click **"Save Menu"**

---

## 🌐 Part 7: Domain Configuration (If Needed)

### If Domain Isn't Working

1. **Check Nameservers**
   - Your domain registrar should point to hosting.com.tr nameservers
   - Typical nameservers (check with hosting.com.tr):
     ```
     ns1.hosting.com.tr
     ns2.hosting.com.tr
     ```

2. **Update Nameservers**
   - Login to your domain registrar
   - Find "Nameservers" or "DNS Settings"
   - Change to your hosting provider's nameservers
   - Save changes (takes 24-48 hours to propagate)

### Set Up in cPanel

1. **Add Domain**
   - In cPanel, go to **"Domains"** or **"Addon Domains"**
   - Enter `spawcoin.com`
   - Set document root to `public_html`
   - Click **"Add Domain"**

---

## 🔒 Part 8: Install SSL Certificate (HTTPS)

### Step 1: Install Free SSL

1. **Access SSL/TLS**
   - In cPanel, search for **"SSL/TLS Status"** or **"Let's Encrypt"**
   - Click on it

2. **Install Certificate**
   - Find your domain `spawcoin.com`
   - Click **"Run AutoSSL"** or **"Issue"**
   - Wait for installation (2-5 minutes)

3. **Verify HTTPS**
   - Visit `https://spawcoin.com`
   - You should see a padlock icon in browser

### Step 2: Force HTTPS (Optional but Recommended)

1. **Update WordPress URL**
   - Go to WordPress Admin → **Settings → General**
   - Change both URLs to use `https://`:
     - WordPress Address: `https://spawcoin.com`
     - Site Address: `https://spawcoin.com`
   - Click **"Save Changes"**

2. **Add HTTPS Redirect**
   - In cPanel File Manager, edit `.htaccess` in `public_html`
   - Add these lines at the top (if not present):
   ```apache
   RewriteEngine On
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

---

## ✅ Part 9: Testing Your Setup

### Test 1: Website Loading

1. Visit `https://spawcoin.com`
2. Verify the Spawcoin theme is active
3. Check that all pages load correctly

### Test 2: Wallet Connection

1. Go to your "Buy" page
2. Click **"Connect Wallet"**
3. Connect with MetaMask
4. Verify wallet connects successfully

### Test 3: Purchase Flow

1. **Connect Wallet** (as above)
2. **Enter Amount** (e.g., 1000 SPAWN)
3. **Click "Buy Now"**
4. **Approve Transaction** in MetaMask
5. **Verify Success** message

### Test 4: Admin Panel

1. Go to **Spawcoin Wallet → Transactions**
2. Check that test transaction appears
3. Verify transaction details are correct

---

## 🎨 Part 10: Customize Your Theme

### Customize Colors & Text

1. **Access Customizer**
   - Go to **Appearance → Customize**

2. **Available Options**
   - **Site Identity**: Change logo and site title
   - **Theme Colors**: Customize primary, secondary, accent colors
   - **Hero Section**: Edit homepage hero title and subtitle
   - **Social Links**: Add Twitter, Discord, Telegram links
   - **Footer**: Customize copyright text

3. **Save Changes**
   - Click **"Publish"** to save

### Add Your Logo

1. **Prepare Logo**
   - Create a logo image (PNG recommended)
   - Recommended size: 200x60px

2. **Upload Logo**
   - Go to **Appearance → Customize → Site Identity**
   - Click **"Select Logo"**
   - Upload your logo
   - Click **"Publish"**

---

## 📧 Part 11: Configure Email (Optional)

### Set Up SMTP for Contact Forms

1. **Install WP Mail SMTP Plugin**
   - Go to **Plugins → Add New**
   - Search for "WP Mail SMTP"
   - Install and activate

2. **Configure Email**
   - Follow the plugin setup wizard
   - Use your hosting email settings
   - Test email delivery

---

## 🛡️ Part 12: Security & Maintenance

### Essential Security Steps

1. **Update Everything**
   - Keep WordPress, themes, and plugins updated
   - Check **Dashboard → Updates** weekly

2. **Install Security Plugin**
   - Install **Wordfence Security** or **Sucuri Security**
   - Run initial security scan

3. **Set Up Backups**
   - Install **UpdraftPlus** backup plugin
   - Configure automatic daily backups
   - Save backups to Google Drive or Dropbox

4. **Disable File Editing**
   - Add to `wp-config.php`:
   ```php
   define('DISALLOW_FILE_EDIT', true);
   ```

---

## 📱 Part 13: Making Changes Live

### How to Update Theme

1. Make changes in your local development
2. Create new ZIP file
3. Go to **Appearance → Themes**
4. Delete old Spawcoin theme
5. Upload new ZIP file
6. Activate

### How to Update Plugin

1. Make changes in local development
2. Create new ZIP file
3. **Deactivate** current plugin
4. **Delete** current plugin
5. Upload new ZIP
6. **Activate** plugin

### Quick CSS Changes

1. Go to **Appearance → Customize → Additional CSS**
2. Add your custom CSS
3. Click **"Publish"**

---

## 🆘 Troubleshooting

### Issue: Theme Not Showing

**Solution:**
- Verify theme is activated in **Appearance → Themes**
- Check file permissions (755 for folders, 644 for files)
- Clear browser cache

### Issue: Plugin Not Working

**Solution:**
- Deactivate and reactivate the plugin
- Check if WordPress version is 5.0+
- Check PHP version (should be 7.4+)
- Review error logs in cPanel

### Issue: Can't Connect Wallet

**Solution:**
- Ensure MetaMask is installed and unlocked
- Check that you've configured the plugin settings
- Verify contract address is correct
- Check browser console for errors (F12)

### Issue: Transactions Not Recording

**Solution:**
- Check database table exists: `wp_swc_transactions`
- Verify AJAX URL is correct
- Check WordPress debug logs
- Ensure proper file permissions

### Issue: Site is Slow

**Solution:**
- Install caching plugin (**WP Super Cache** or **W3 Total Cache**)
- Optimize images
- Enable CDN (Cloudflare free plan)
- Contact hosting support about server resources

---

## 📞 Support Resources

### Hosting Support
- **Website**: https://hosting.com.tr
- **Support**: Check their support page for contact info

### WordPress Resources
- [WordPress Codex](https://codex.wordpress.org/)
- [WordPress Support Forums](https://wordpress.org/support/)

### Blockchain Resources
- **Ethereum**: https://etherscan.io
- **BSC**: https://bscscan.com
- **Polygon**: https://polygonscan.com

---

## ✅ Final Checklist

Before going live, ensure:

- [ ] Theme is activated and displays correctly
- [ ] Plugin is activated and configured
- [ ] Token contract address is set correctly
- [ ] Receiver wallet address is YOUR wallet
- [ ] SSL certificate is installed (HTTPS working)
- [ ] Buy widget is added to at least one page
- [ ] Test wallet connection works
- [ ] Test transaction completes successfully
- [ ] All pages load without errors
- [ ] Logo and branding are updated
- [ ] Social media links are added
- [ ] Contact information is correct
- [ ] Backups are configured
- [ ] Security plugin is installed

---

## 🎉 You're Live!

Congratulations! Your Spawcoin website is now live and accepting crypto payments!

### Next Steps

1. **Promote Your Site**
   - Share on social media
   - Submit to crypto directories
   - Engage with crypto communities

2. **Monitor Transactions**
   - Check **Spawcoin Wallet → Transactions** regularly
   - Monitor your receiver wallet
   - Track sales and volume

3. **Grow Your Community**
   - Create content regularly
   - Engage with token holders
   - Build your ecosystem

---

**Need Help?** If you encounter any issues during deployment, document the error message and the step where it occurred. Most issues can be resolved by checking file permissions, plugin conflicts, or hosting settings.

**Good luck with your Spawcoin launch! 🚀**

/**
 * Spawcoin Wallet Connector - Frontend JavaScript
 */

(function($) {
    'use strict';

    class SpawcoinWalletConnector {
        constructor() {
            this.web3 = null;
            this.account = null;
            this.provider = null;
            this.settings = swcSettings || {};

            this.init();
        }

        init() {
            this.bindEvents();
            this.checkConnection();
        }

        bindEvents() {
            const self = this;

            // Connect wallet button
            $(document).on('click', '.swc-connect-btn', function(e) {
                e.preventDefault();
                if (self.account) {
                    self.showWalletInfo();
                } else {
                    self.connectWallet();
                }
            });

            // Disconnect button
            $(document).on('click', '.swc-disconnect-btn', function(e) {
                e.preventDefault();
                self.disconnect();
            });

            // Buy button
            $(document).on('click', '.swc-buy-btn', function(e) {
                e.preventDefault();
                self.buyTokens();
            });

            // Amount input change
            $(document).on('input', '#swc-amount', function() {
                self.updatePrice();
            });

            // Listen for account changes
            if (window.ethereum) {
                window.ethereum.on('accountsChanged', (accounts) => {
                    if (accounts.length === 0) {
                        self.disconnect();
                    } else {
                        self.account = accounts[0];
                        self.updateUI();
                    }
                });

                window.ethereum.on('chainChanged', () => {
                    window.location.reload();
                });
            }
        }

        async checkConnection() {
            if (typeof window.ethereum !== 'undefined') {
                try {
                    const accounts = await window.ethereum.request({
                        method: 'eth_accounts'
                    });

                    if (accounts.length > 0) {
                        this.account = accounts[0];
                        this.web3 = new Web3(window.ethereum);
                        this.updateUI();
                    }
                } catch (error) {
                    console.error('Error checking connection:', error);
                }
            }
        }

        async connectWallet() {
            if (typeof window.ethereum === 'undefined') {
                this.showNotification(
                    'Please install MetaMask or another Web3 wallet to continue.',
                    'error'
                );
                return;
            }

            try {
                // Request account access
                const accounts = await window.ethereum.request({
                    method: 'eth_requestAccounts'
                });

                this.account = accounts[0];
                this.web3 = new Web3(window.ethereum);

                // Check if correct network
                const chainId = await this.web3.eth.getChainId();
                const requiredChainId = parseInt(this.settings.chainId);

                if (chainId !== requiredChainId) {
                    await this.switchNetwork(requiredChainId);
                }

                this.updateUI();
                this.showNotification('Wallet connected successfully!', 'success');

            } catch (error) {
                console.error('Error connecting wallet:', error);

                if (error.code === 4001) {
                    this.showNotification('Connection request rejected', 'error');
                } else {
                    this.showNotification('Failed to connect wallet', 'error');
                }
            }
        }

        async switchNetwork(chainId) {
            const networkParams = this.getNetworkParams(chainId);

            try {
                await window.ethereum.request({
                    method: 'wallet_switchEthereumChain',
                    params: [{ chainId: Web3.utils.toHex(chainId) }],
                });
            } catch (switchError) {
                // Network not added, try adding it
                if (switchError.code === 4902) {
                    try {
                        await window.ethereum.request({
                            method: 'wallet_addEthereumChain',
                            params: [networkParams],
                        });
                    } catch (addError) {
                        console.error('Error adding network:', addError);
                        throw new Error('Failed to add network');
                    }
                } else {
                    throw switchError;
                }
            }
        }

        getNetworkParams(chainId) {
            const networks = {
                1: {
                    chainId: '0x1',
                    chainName: 'Ethereum Mainnet',
                    nativeCurrency: { name: 'Ether', symbol: 'ETH', decimals: 18 },
                    rpcUrls: ['https://mainnet.infura.io/v3/'],
                    blockExplorerUrls: ['https://etherscan.io'],
                },
                56: {
                    chainId: '0x38',
                    chainName: 'Binance Smart Chain',
                    nativeCurrency: { name: 'BNB', symbol: 'BNB', decimals: 18 },
                    rpcUrls: ['https://bsc-dataseed.binance.org/'],
                    blockExplorerUrls: ['https://bscscan.com'],
                },
                137: {
                    chainId: '0x89',
                    chainName: 'Polygon',
                    nativeCurrency: { name: 'MATIC', symbol: 'MATIC', decimals: 18 },
                    rpcUrls: ['https://polygon-rpc.com/'],
                    blockExplorerUrls: ['https://polygonscan.com'],
                },
            };

            return networks[chainId] || networks[1];
        }

        disconnect() {
            this.account = null;
            this.web3 = null;
            this.updateUI();
            this.showNotification('Wallet disconnected', 'warning');
        }

        updateUI() {
            const isConnected = this.account !== null;

            if (isConnected) {
                // Update button text
                $('.swc-connect-btn .swc-wallet-text').text(this.settings.strings.connected);
                $('.swc-connect-btn').addClass('connected');

                // Show address
                const shortAddress = this.account.substring(0, 6) + '...' + this.account.substring(38);
                $('.swc-address').text(shortAddress);
                $('.swc-address-display').text('Connected: ' + shortAddress);

                // Show wallet info
                $('.swc-wallet-info').fadeIn();
                $('.swc-connected-info').fadeIn();
                $('.swc-purchase-form').fadeIn();

                // Get and display balance
                this.updateBalance();
            } else {
                // Reset UI
                $('.swc-connect-btn .swc-wallet-text').text(this.settings.strings.connectWallet);
                $('.swc-connect-btn').removeClass('connected');
                $('.swc-wallet-info').fadeOut();
                $('.swc-connected-info').fadeOut();
                $('.swc-purchase-form').fadeOut();
            }
        }

        async updateBalance() {
            if (!this.web3 || !this.account) return;

            try {
                const balance = await this.web3.eth.getBalance(this.account);
                const ethBalance = this.web3.utils.fromWei(balance, 'ether');
                $('.swc-balance').text(parseFloat(ethBalance).toFixed(4));
            } catch (error) {
                console.error('Error getting balance:', error);
            }
        }

        updatePrice() {
            const amount = parseFloat($('#swc-amount').val()) || 0;
            const pricePerToken = parseFloat(this.settings.tokenPrice) || 0;
            const totalPrice = amount * pricePerToken;

            $('.swc-total-price').text(totalPrice.toFixed(6));
        }

        async buyTokens() {
            if (!this.account) {
                this.showNotification('Please connect your wallet first', 'error');
                return;
            }

            const amount = parseFloat($('#swc-amount').val());
            if (!amount || amount <= 0) {
                this.showNotification('Please enter a valid amount', 'error');
                return;
            }

            const pricePerToken = parseFloat(this.settings.tokenPrice);
            const totalPrice = amount * pricePerToken;
            const receiverAddress = this.settings.receiverAddress;

            if (!receiverAddress) {
                this.showNotification('Receiver address not configured', 'error');
                return;
            }

            try {
                // Show processing status
                this.showTransactionStatus('processing', this.settings.strings.processing);
                $('.swc-buy-btn').prop('disabled', true).html('<span class="swc-spinner"></span> ' + this.settings.strings.processing);

                // Send transaction
                const txParams = {
                    from: this.account,
                    to: receiverAddress,
                    value: this.web3.utils.toWei(totalPrice.toString(), 'ether'),
                    gas: 21000,
                };

                const txHash = await window.ethereum.request({
                    method: 'eth_sendTransaction',
                    params: [txParams],
                });

                // Record transaction
                await this.recordTransaction(txHash, amount);

                // Show success
                this.showTransactionStatus('success', this.settings.strings.success, txHash);
                this.showNotification('Purchase successful!', 'success');

                // Reset form
                $('#swc-amount').val('1000');
                this.updatePrice();

            } catch (error) {
                console.error('Transaction error:', error);

                let errorMessage = this.settings.strings.error;

                if (error.code === 4001) {
                    errorMessage = this.settings.strings.userRejected;
                } else if (error.message && error.message.includes('insufficient funds')) {
                    errorMessage = this.settings.strings.insufficientFunds;
                }

                this.showTransactionStatus('error', errorMessage);
                this.showNotification(errorMessage, 'error');
            } finally {
                $('.swc-buy-btn').prop('disabled', false).html('<span>' + this.settings.strings.buyNow + '</span>');
            }
        }

        async recordTransaction(txHash, amount) {
            try {
                const response = await $.ajax({
                    url: this.settings.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'swc_verify_transaction',
                        nonce: this.settings.nonce,
                        tx_hash: txHash,
                        address: this.account,
                        amount: amount,
                    }
                });

                return response;
            } catch (error) {
                console.error('Error recording transaction:', error);
            }
        }

        showTransactionStatus(type, message, txHash = null) {
            const $status = $('.swc-transaction-status');
            $status.removeClass('success error processing').addClass(type);
            $status.find('.swc-status-message').text(message);

            if (txHash) {
                const chainId = this.settings.chainId || '1';
                const explorerUrl = this.getExplorerUrl(chainId);
                const txUrl = `${explorerUrl}/tx/${txHash}`;

                $status.find('.swc-tx-link').attr('href', txUrl).show();
            } else {
                $status.find('.swc-tx-link').hide();
            }

            $status.fadeIn();

            // Auto-hide after 10 seconds for success/error
            if (type !== 'processing') {
                setTimeout(() => {
                    $status.fadeOut();
                }, 10000);
            }
        }

        getExplorerUrl(chainId) {
            const explorers = {
                '1': 'https://etherscan.io',
                '56': 'https://bscscan.com',
                '137': 'https://polygonscan.com',
                '43114': 'https://snowtrace.io',
                '250': 'https://ftmscan.com',
                '42161': 'https://arbiscan.io',
                '10': 'https://optimistic.etherscan.io',
                '5': 'https://goerli.etherscan.io',
                '97': 'https://testnet.bscscan.com',
            };

            return explorers[chainId] || 'https://etherscan.io';
        }

        showNotification(message, type = 'success') {
            const $notification = $('<div class="swc-notification ' + type + '">' +
                '<p class="swc-notification-message">' + message + '</p>' +
                '</div>');

            $('body').append($notification);

            setTimeout(() => {
                $notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        }

        showWalletInfo() {
            // Toggle wallet info display
            $('.swc-wallet-info').slideToggle();
        }
    }

    // Initialize when document is ready
    $(document).ready(function() {
        window.spawcoinWallet = new SpawcoinWalletConnector();
    });

})(jQuery);

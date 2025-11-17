/**
 * Spawcoin Wallet Connector - Admin JavaScript
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Copy shortcode to clipboard
        $('.swc-shortcode-box code').on('click', function() {
            const text = $(this).text();
            copyToClipboard(text);
            showCopyNotification($(this));
        });

        // Validate Ethereum addresses
        $('input[name="contract_address"], input[name="receiver_address"]').on('blur', function() {
            const address = $(this).val();
            if (address && !isValidEthereumAddress(address)) {
                $(this).css('border-color', '#ef4444');
                showValidationMessage($(this), 'Invalid Ethereum address format');
            } else {
                $(this).css('border-color', '');
                hideValidationMessage($(this));
            }
        });

        // Validate token decimals
        $('input[name="token_decimals"]').on('input', function() {
            const value = parseInt($(this).val());
            if (value < 0 || value > 18) {
                $(this).css('border-color', '#ef4444');
                showValidationMessage($(this), 'Token decimals must be between 0 and 18');
            } else {
                $(this).css('border-color', '');
                hideValidationMessage($(this));
            }
        });

        // Validate token price
        $('input[name="token_price"]').on('input', function() {
            const value = parseFloat($(this).val());
            if (value <= 0) {
                $(this).css('border-color', '#ef4444');
                showValidationMessage($(this), 'Token price must be greater than 0');
            } else {
                $(this).css('border-color', '');
                hideValidationMessage($(this));
            }
        });

        // Form submission validation
        $('form').on('submit', function(e) {
            let hasErrors = false;

            // Validate contract address
            const contractAddress = $('input[name="contract_address"]').val();
            if (contractAddress && !isValidEthereumAddress(contractAddress)) {
                e.preventDefault();
                hasErrors = true;
                alert('Please enter a valid token contract address');
                $('input[name="contract_address"]').focus();
                return false;
            }

            // Validate receiver address
            const receiverAddress = $('input[name="receiver_address"]').val();
            if (receiverAddress && !isValidEthereumAddress(receiverAddress)) {
                e.preventDefault();
                hasErrors = true;
                alert('Please enter a valid receiver wallet address');
                $('input[name="receiver_address"]').focus();
                return false;
            }

            // Validate token decimals
            const decimals = parseInt($('input[name="token_decimals"]').val());
            if (decimals < 0 || decimals > 18) {
                e.preventDefault();
                hasErrors = true;
                alert('Token decimals must be between 0 and 18');
                $('input[name="token_decimals"]').focus();
                return false;
            }

            // Validate token price
            const price = parseFloat($('input[name="token_price"]').val());
            if (price <= 0) {
                e.preventDefault();
                hasErrors = true;
                alert('Token price must be greater than 0');
                $('input[name="token_price"]').focus();
                return false;
            }

            if (hasErrors) {
                return false;
            }
        });

        // Auto-refresh transactions page every 30 seconds if on transactions page
        if ($('.swc-transactions-table-wrap').length > 0) {
            setInterval(function() {
                // Only refresh if user is viewing the page
                if (!document.hidden) {
                    checkForNewTransactions();
                }
            }, 30000);
        }
    });

    // Helper function to validate Ethereum addresses
    function isValidEthereumAddress(address) {
        return /^0x[a-fA-F0-9]{40}$/.test(address);
    }

    // Helper function to copy text to clipboard
    function copyToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();

        try {
            document.execCommand('copy');
        } catch (err) {
            console.error('Failed to copy:', err);
        }

        document.body.removeChild(textarea);
    }

    // Show copy notification
    function showCopyNotification($element) {
        const $notification = $('<div class="swc-copy-notification">Copied!</div>');
        $element.after($notification);

        setTimeout(function() {
            $notification.fadeOut(function() {
                $(this).remove();
            });
        }, 2000);
    }

    // Show validation message
    function showValidationMessage($input, message) {
        hideValidationMessage($input);

        const $message = $('<span class="swc-validation-error">' + message + '</span>');
        $input.after($message);
    }

    // Hide validation message
    function hideValidationMessage($input) {
        $input.siblings('.swc-validation-error').remove();
    }

    // Check for new transactions
    function checkForNewTransactions() {
        // This would typically make an AJAX call to check for new transactions
        // For now, we'll just log that we're checking
        console.log('Checking for new transactions...');
    }

    // Add custom CSS for notifications
    $('<style>')
        .text(`
            .swc-copy-notification {
                display: inline-block;
                margin-left: 10px;
                padding: 5px 10px;
                background: #10b981;
                color: white;
                border-radius: 4px;
                font-size: 12px;
                animation: swc-fadeIn 0.3s ease;
            }

            .swc-validation-error {
                display: block;
                color: #ef4444;
                font-size: 13px;
                margin-top: 5px;
                font-weight: 500;
            }
        `)
        .appendTo('head');

})(jQuery);

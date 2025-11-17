<?php
/**
 * Custom search form
 *
 * @package Spawcoin
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'spawcoin'); ?></span>
        <input type="search"
               class="search-field"
               placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'spawcoin'); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s"
               title="<?php echo esc_attr_x('Search for:', 'label', 'spawcoin'); ?>" />
    </label>
    <button type="submit" class="search-submit btn btn-primary">
        <span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'spawcoin'); ?></span>
        <span aria-hidden="true">🔍</span>
    </button>
</form>

<style>
.search-form {
    display: flex;
    gap: var(--spacing-sm);
    max-width: 600px;
    margin: var(--spacing-lg) auto;
}

.search-form label {
    flex: 1;
}

.search-field {
    width: 100%;
    padding: var(--spacing-md);
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: var(--radius-lg);
    color: var(--color-light);
    font-size: 1rem;
    font-family: var(--font-primary);
    transition: all var(--transition-base);
}

.search-field:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: var(--shadow-glow);
}

.search-submit {
    padding: var(--spacing-md) var(--spacing-lg);
    white-space: nowrap;
}

@media (max-width: 600px) {
    .search-form {
        flex-direction: column;
    }

    .search-submit {
        width: 100%;
    }
}
</style>

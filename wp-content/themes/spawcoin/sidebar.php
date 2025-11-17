<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Spawcoin
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>

<style>
.widget-area {
    padding: var(--spacing-lg);
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(99, 102, 241, 0.2);
    border-radius: var(--radius-xl);
    margin-top: var(--spacing-xl);
}

.widget {
    margin-bottom: var(--spacing-lg);
    padding-bottom: var(--spacing-lg);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.widget:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.widget-title {
    font-size: 1.25rem;
    margin-bottom: var(--spacing-md);
    color: var(--color-light);
}

.widget ul {
    list-style: none;
    padding: 0;
}

.widget li {
    padding: var(--spacing-xs) 0;
}

.widget a {
    color: var(--color-gray-light);
    transition: color var(--transition-base);
}

.widget a:hover {
    color: var(--color-primary-light);
}

@media (min-width: 1024px) {
    .has-sidebar {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: var(--spacing-xl);
    }

    .widget-area {
        margin-top: 0;
    }
}
</style>

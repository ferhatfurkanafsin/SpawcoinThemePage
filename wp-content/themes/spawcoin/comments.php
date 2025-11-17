<?php
/**
 * The template for displaying comments
 *
 * @package Spawcoin
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area card">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'spawcoin'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx(
                        '%1$s comment on &ldquo;%2$s&rdquo;',
                        '%1$s comments on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'spawcoin'
                    )),
                    number_format_i18n($comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'spawcoin'); ?></p>
            <?php
        endif;

    endif;

    comment_form(array(
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h3>',
        'class_submit'       => 'btn btn-primary',
    ));
    ?>

</div>

<style>
.comments-area {
    margin-top: var(--spacing-2xl);
    padding: var(--spacing-xl);
}

.comments-title {
    margin-bottom: var(--spacing-lg);
    font-size: 1.75rem;
}

.comment-list {
    list-style: none;
    padding: 0;
    margin: var(--spacing-lg) 0;
}

.comment-list .comment {
    padding: var(--spacing-md);
    margin-bottom: var(--spacing-md);
    background: rgba(30, 41, 59, 0.3);
    border-radius: var(--radius-lg);
    border-left: 3px solid var(--color-primary);
}

.comment-list .children {
    list-style: none;
    margin-left: var(--spacing-xl);
}

.comment-author {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    margin-bottom: var(--spacing-sm);
}

.comment-author .avatar {
    border-radius: var(--radius-full);
}

.comment-author .fn {
    font-weight: 600;
    color: var(--color-primary-light);
}

.comment-metadata {
    font-size: 0.875rem;
    color: var(--color-gray);
    margin-bottom: var(--spacing-sm);
}

.comment-metadata a {
    color: var(--color-gray);
}

.comment-content {
    margin-bottom: var(--spacing-sm);
    line-height: 1.6;
}

.reply {
    margin-top: var(--spacing-sm);
}

.reply a {
    font-size: 0.875rem;
    color: var(--color-primary);
}

.comment-form {
    margin-top: var(--spacing-xl);
}

.comment-form-comment,
.comment-form-author,
.comment-form-email,
.comment-form-url {
    margin-bottom: var(--spacing-md);
}

.comment-form label {
    display: block;
    margin-bottom: var(--spacing-xs);
    color: var(--color-light);
    font-weight: 500;
}

.comment-form input[type="text"],
.comment-form input[type="email"],
.comment-form input[type="url"],
.comment-form textarea {
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

.comment-form input[type="text"]:focus,
.comment-form input[type="email"]:focus,
.comment-form input[type="url"]:focus,
.comment-form textarea:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: var(--shadow-glow);
}

.comment-form textarea {
    min-height: 150px;
    resize: vertical;
}

.form-submit {
    margin-top: var(--spacing-md);
}

.no-comments {
    color: var(--color-gray);
    font-style: italic;
}
</style>

<?php

/** @var \App\Model\Comment $comment */
/** @var \App\Service\Router $router */

$title = $comment->getAuthor();
$bodyClass = "show";

ob_start();
?>

    <h1><?= htmlspecialchars($comment->getAuthor()) ?></h1>

    <article>
        <?= htmlspecialchars($comment->getContent()) ?>
    </article>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('comment-index') ?>">
                Back to list
            </a>
        </li>

        <li>
            <a href="<?= $router->generatePath('comment-edit', [
                'id' => $comment->getId()
            ]) ?>">
                Edit
            </a>
        </li>

        <li>
            <a href="<?= $router->generatePath('comment-delete', [
                'id' => $comment->getId()
            ]) ?>">
                Delete
            </a>
        </li>
    </ul>

<?php
$main = ob_get_clean();

include __DIR__
    . DIRECTORY_SEPARATOR . '..'
    . DIRECTORY_SEPARATOR . 'base.html.php';
<?php

/** @var \App\Model\Comment[] $comments */
/** @var \App\Service\Router $router */

$title = "Comments List";
$bodyClass = "index";

ob_start();
?>

<h1>Comments List</h1>

<ul class="index-actions">
    <li>
        <a href="<?= $router->generatePath('comment-create') ?>">
            Create new
        </a>
    </li>
</ul>

<?php if (empty($comments)): ?>

    <p>No comments yet.</p>

<?php else: ?>

    <?php foreach ($comments as $comment): ?>

        <article class="post">

            <header>
                <h2>
                    <a href="<?= $router->generatePath('comment-show', [
                            'id' => $comment->getId()
                    ]) ?>">
                        <?= htmlspecialchars($comment->getAuthor()) ?>
                    </a>
                </h2>
            </header>

            <p>
                <?= htmlspecialchars($comment->getContent()) ?>
            </p>

            <ul class="action-list">
                <li>
                    <a href="<?= $router->generatePath('comment-show', [
                            'id' => $comment->getId()
                    ]) ?>">
                        Details
                    </a>
                </li>

                <li>
                    <a href="<?= $router->generatePath('comment-edit', [
                            'id' => $comment->getId()
                    ]) ?>">
                        Edit
                    </a>
                </li>
            </ul>

        </article>

    <?php endforeach; ?>

<?php endif; ?>

<?php
$main = ob_get_clean();

include __DIR__
        . DIRECTORY_SEPARATOR . '..'
        . DIRECTORY_SEPARATOR . 'base.html.php';
?>

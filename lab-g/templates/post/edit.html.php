<?php

/** @var \App\Model\Post $post */
/** @var \App\Service\Router $router */

$title = "Edit Post";
$bodyClass = "edit";

ob_start();
?>

    <h1>Edit Post</h1>

    <form action="<?= $router->generatePath('post-edit', ['id' => $post->getId()]) ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="hidden" name="id" value="<?= $post->getId() ?>">
    </form>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('post-index') ?>">
                Back to list
            </a>
        </li>

        <li>
            <form method="post"
                  action="<?= $router->generatePath('post-delete', ['id' => $post->getId()]) ?>">
                <input type="hidden"
                       name="id"
                       value="<?= $post->getId() ?>">

                <input type="submit"
                       value="Delete"
                       onclick="return confirm('Delete post?')">
            </form>
        </li>
    </ul>

<?php
$main = ob_get_clean();

include __DIR__ . '/../base.html.php';
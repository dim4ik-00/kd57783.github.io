<?php

/** @var \App\Model\Post $post */
/** @var \App\Service\Router $router */

$title = $post->getSubject();
$bodyClass = "show";

ob_start();
?>

    <h1><?= htmlspecialchars($post->getSubject()) ?></h1>

    <article>
        <?= htmlspecialchars($post->getContent()) ?>
    </article>

    <ul class="action-list">
        <li>
            <a href="<?= $router->generatePath('post-index') ?>">
                Back to list
            </a>
        </li>

        <li>
            <a href="<?= $router->generatePath('post-edit', [
                    'id' => $post->getId()
            ]) ?>">
                Edit
            </a>
        </li>

        <li>
            <a href="<?= $router->generatePath('post-delete', [
                    'id' => $post->getId()
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
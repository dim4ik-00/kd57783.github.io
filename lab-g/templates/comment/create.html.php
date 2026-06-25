<?php

/** @var \App\Service\Router $router */

$title = "Add new comment";
$bodyClass = "create";

ob_start();
?>

    <h1>Add new comment</h1>

    <form action="<?= $router->generatePath('comment-create') ?>" method="post">

        <p>
            Author:
            <input type="text" name="comment[author]">
        </p>

        <p>
            Comment content:
            <textarea name="comment[content]"></textarea>
        </p>

        <input type="submit" value="Submit text">

    </form>

    <p>
        <a href="<?= $router->generatePath('comment-index') ?>">
            Back to list
        </a>
    </p>

<?php
$main = ob_get_clean();

include __DIR__
        . DIRECTORY_SEPARATOR . '..'
        . DIRECTORY_SEPARATOR . 'base.html.php';
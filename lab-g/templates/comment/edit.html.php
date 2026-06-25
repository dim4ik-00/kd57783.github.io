<?php

/** @var \App\Model\Comment $comment */
/** @var \App\Service\Router $router */

$title = "Edit comment";
$bodyClass = "edit";

ob_start();
?>

<h1>Edit comment</h1>

<form action="<?= $router->generatePath('comment-edit', [
    'id' => $comment->getId()
]) ?>" method="post">


    <p>
        Author:
        <input type="text"
               name="comment[author]"
               value="<?= htmlspecialchars($comment->getAuthor()) ?>">
    </p>

    <p>
        Content:
        <textarea name="comment[content]"><?= htmlspecialchars($comment->getContent()) ?></textarea>
    </p>

    <input type="submit" value="Save">


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
?>

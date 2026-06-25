<?php /** @var \App\Service\Router $router */ ?>

<ul>
    <li><a href="<?= $router->generatePath('home') ?>">Home</a></li>
    <li><a href="<?= $router->generatePath('post-index') ?>">Posts</a></li>
    <li><a href="<?= $router->generatePath('comment-index') ?>">Komentarze</a></li>
</ul>
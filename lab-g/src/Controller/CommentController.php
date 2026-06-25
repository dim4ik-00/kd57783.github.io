<?php

namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Comment;
use App\Service\Config;
use App\Service\Router;
use App\Service\Templating;

class CommentController
{
    private function getPdo(): \PDO
    {
        return new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
    }

    public function indexAction(Templating $templating, Router $router): ?string
    {
        $pdo = $this->getPdo();

        $comments = Comment::findAllByPostId(2, $pdo);

        return $templating->render('comment/index.html.php', [
            'comments' => $comments,
            'router' => $router,
        ]);
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $pdo = $this->getPdo();

            $comment = Comment::fromArray($requestPost);
            $comment->setPostId(2);
            $comment->save($pdo);

            $router->redirect(
                $router->generatePath('comment-index')
            );

            return null;
        }

        return $templating->render('comment/create.html.php', [
            'router' => $router,
        ]);
    }

    public function showAction(int $id, Templating $templating, Router $router): ?string
    {
        $pdo = $this->getPdo();

        $comment = Comment::find($id, $pdo);

        if (!$comment) {
            throw new NotFoundException("Comment not found");
        }

        return $templating->render('comment/show.html.php', [
            'comment' => $comment,
            'router' => $router,
        ]);
    }

    public function editAction(int $id, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $pdo = $this->getPdo();

        $comment = Comment::find($id, $pdo);

        if (!$comment) {
            throw new NotFoundException("Comment not found");
        }

        if ($requestPost) {
            $comment->fill($requestPost);
            $comment->save($pdo);

            $router->redirect(
                $router->generatePath('comment-index')
            );

            return null;
        }

        return $templating->render('comment/edit.html.php', [
            'comment' => $comment,
            'router' => $router,
        ]);
    }

    public function deleteAction(int $id, Router $router): ?string
    {
        $pdo = $this->getPdo();

        $comment = Comment::find($id, $pdo);

        if (!$comment) {
            throw new NotFoundException("Comment not found");
        }

        $comment->delete($pdo);

        $router->redirect(
            $router->generatePath('comment-index')
        );

        return null;
    }
}
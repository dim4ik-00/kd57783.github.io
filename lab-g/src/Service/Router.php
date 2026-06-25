<?php

namespace App\Service;

class Router
{
    private array $routes = [
        'home' => [
            'controller' => 'PostController',
            'action' => 'indexAction',
        ],
        'post-index' => [
            'controller' => 'PostController',
            'action' => 'indexAction',
        ],
        'post-create' => [
            'controller' => 'PostController',
            'action' => 'createAction',
        ],
        'post-edit' => [
            'controller' => 'PostController',
            'action' => 'editAction',
        ],
        'post-show' => [
            'controller' => 'PostController',
            'action' => 'showAction',
        ],
        'post-delete' => [
            'controller' => 'PostController',
            'action' => 'deleteAction',
        ],
        'comment-index' => [
            'controller' => 'CommentController',
            'action' => 'indexAction',
        ],
        'comment-create' => [
            'controller' => 'CommentController',
            'action' => 'createAction',
        ],
        'comment-edit' => [
            'controller' => 'CommentController',
            'action' => 'editAction',
        ],
        'comment-show' => [
            'controller' => 'CommentController',
            'action' => 'showAction',
        ],
        'comment-delete' => [
            'controller' => 'CommentController',
            'action' => 'deleteAction',
        ],
    ];

    public function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    public function generatePath(string $routeName, array $params = []): string
    {
        if (!isset($this->routes[$routeName])) {
            throw new \InvalidArgumentException("Route '$routeName' not found");
        }

        $path = '/index.php?action=' . $routeName;
        if ($routeName === 'home') {
            $path = '/index.php';
        }

        if ($params) {
            unset($params['action']);
            if (!empty($params)) {
                $path .= '&' . http_build_query($params);
            }
        }

        return $path;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
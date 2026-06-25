<?php

namespace App\Model;

class Comment
{
    private ?int $id = null;
    private ?int $postId = null;
    private ?string $author = null;
    private ?string $content = null;
    private ?string $createdAt = null;

    public static function fromArray(array $array): self
    {
        $comment = new self();
        $comment->fill($array);
        return $comment;
    }

    public function fill(array $array): self
    {
        if (isset($array['id'])) $this->id = (int)$array['id'];
        if (isset($array['post_id'])) $this->postId = (int)$array['post_id'];
        if (isset($array['author'])) $this->author = $array['author'];
        if (isset($array['content'])) $this->content = $array['content'];
        if (isset($array['created_at'])) $this->createdAt = $array['created_at'];

        return $this;
    }

    public static function findAllByPostId(int $postId, \PDO $pdo): array
    {
        $stmt = $pdo->prepare("SELECT * FROM comment WHERE post_id = :post_id ORDER BY created_at DESC");
        $stmt->execute([':post_id' => $postId]);
        $comments = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $comments[] = self::fromArray($row);
        }
        return $comments;
    }

    public function save(\PDO $pdo): void
    {
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE comment SET author = :author, content = :content WHERE id = :id");
            $stmt->execute([
                ':author' => $this->author,
                ':content' => $this->content,
                ':id' => $this->id
            ]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO comment (post_id, author, content, created_at) VALUES (:post_id, :author, :content, :created_at)");
            $stmt->execute([
                ':post_id' => $this->postId,
                ':author' => $this->author,
                ':content' => $this->content,
                ':created_at' => date('Y-m-d H:i:s')
            ]);
            $this->id = (int)$pdo->lastInsertId();
        }
    }
    public static function find(int $id, \PDO $pdo): ?self
    {
        $stmt = $pdo->prepare("SELECT * FROM comment WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return self::fromArray($row);
    }

    public function delete(\PDO $pdo): void
    {
        $stmt = $pdo->prepare("DELETE FROM comment WHERE id = :id");

        $stmt->execute([
            ':id' => $this->id
        ]);
    }
    public function getId(): ?int { return $this->id; }
    public function getPostId(): ?int { return $this->postId; }
    public function setPostId(?int $postId): void { $this->postId = $postId; }
    public function getAuthor(): ?string { return $this->author; }
    public function setAuthor(?string $author): void { $this->author = $author; }
    public function getContent(): ?string { return $this->content; }
    public function setContent(?string $content): void { $this->content = $content; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
}
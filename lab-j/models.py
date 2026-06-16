from datetime import datetime

from db import get_connection


class Comment:
    """Lightweight, hand-written ORM for the `comment` model (no external ORM)."""

    def __init__(self, id=None, post_id=None, author=None, content=None, created_at=None):
        self.id = id
        self.post_id = post_id
        self.author = author
        self.content = content
        self.created_at = created_at

    @staticmethod
    def from_row(row) -> "Comment":
        return Comment(
            id=row["id"],
            post_id=row["post_id"],
            author=row["author"],
            content=row["content"],
            created_at=row["created_at"],
        )

    @staticmethod
    def find_all_by_post_id(post_id: int) -> list["Comment"]:
        connection = get_connection()
        rows = connection.execute(
            "SELECT * FROM comment WHERE post_id = ? ORDER BY created_at DESC",
            (post_id,),
        ).fetchall()
        connection.close()
        return [Comment.from_row(row) for row in rows]

    @staticmethod
    def find(comment_id: int):
        connection = get_connection()
        row = connection.execute(
            "SELECT * FROM comment WHERE id = ?",
            (comment_id,),
        ).fetchone()
        connection.close()
        return Comment.from_row(row) if row else None

    def save(self) -> None:
        connection = get_connection()
        if self.id:
            connection.execute(
                "UPDATE comment SET author = ?, content = ? WHERE id = ?",
                (self.author, self.content, self.id),
            )
        else:
            self.created_at = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            cursor = connection.execute(
                "INSERT INTO comment (post_id, author, content, created_at) "
                "VALUES (?, ?, ?, ?)",
                (self.post_id, self.author, self.content, self.created_at),
            )
            self.id = cursor.lastrowid
        connection.commit()
        connection.close()

    def delete(self) -> None:
        connection = get_connection()
        connection.execute("DELETE FROM comment WHERE id = ?", (self.id,))
        connection.commit()
        connection.close()

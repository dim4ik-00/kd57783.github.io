from datetime import datetime

from flask import Flask, abort, redirect, render_template, request, url_for

from models import Comment

app = Flask(__name__)

# The ported model belongs to a single demo post (mirrors LAB G behaviour).
POST_ID = 1


@app.context_processor
def inject_now():
    return {"current_year": datetime.now().year}


@app.route("/")
def index():
    comments = Comment.find_all_by_post_id(POST_ID)
    return render_template("comment/index.html", comments=comments)


@app.route("/comment/<int:comment_id>")
def show(comment_id):
    comment = Comment.find(comment_id)
    if comment is None:
        abort(404)
    return render_template("comment/show.html", comment=comment)


@app.route("/comment/create", methods=["GET", "POST"])
def create():
    if request.method == "POST":
        comment = Comment(
            post_id=POST_ID,
            author=request.form.get("author"),
            content=request.form.get("content"),
        )
        comment.save()
        return redirect(url_for("index"))
    return render_template("comment/create.html")


@app.route("/comment/<int:comment_id>/edit", methods=["GET", "POST"])
def edit(comment_id):
    comment = Comment.find(comment_id)
    if comment is None:
        abort(404)
    if request.method == "POST":
        comment.author = request.form.get("author")
        comment.content = request.form.get("content")
        comment.save()
        return redirect(url_for("index"))
    return render_template("comment/edit.html", comment=comment)


@app.route("/comment/<int:comment_id>/delete", methods=["POST"])
def delete(comment_id):
    comment = Comment.find(comment_id)
    if comment is None:
        abort(404)
    comment.delete()
    return redirect(url_for("index"))


if __name__ == "__main__":
    app.run(host="127.0.0.1", port=57783, debug=True)

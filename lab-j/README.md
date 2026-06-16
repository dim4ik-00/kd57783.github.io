# LAB J - Server-Side Rendering with Flask

Port of the `Comment` CRUD model from LAB G (PHP) to Flask 3.1.x using Jinja2
templates and SQLite (`sqlite3` module, no external ORM).

## Requirements

- Python 3.14
- Flask 3.1.x (see `requirements.txt`)

## Setup

```bat
py -m venv venv
venv\Scripts\activate
pip install -r requirements.txt
```

## Initialize the database (only if data.db is missing)

```bat
python db.py
```

## Run

```bat
python app.py
```

The application starts on http://127.0.0.1:57783

## hello.py

Prints the environment info required by the lab:

```bat
python hello.py
```

## Structure

- `app.py` - Flask routes (controllers)
- `models.py` - `Comment` model (hand-written data layer, no ORM)
- `db.py` - SQLite connection helper + schema initializer
- `templates/layout.html` - base layout, inherited by the action templates
- `templates/comment/*.html` - Jinja2 templates for the CRUD actions
- `static/style.css` - styles ported from LAB G
- `sql/01-comment.sql` - SQLite migration

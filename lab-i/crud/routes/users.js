var express = require('express');
var router = express.Router();

let posts = [
  {
    id: 1,
    subject: 'Pierwszy post',
    content: 'To jest treść pierwszego posta'
  }
];

router.get('/', function(req, res) {
  res.send('Lista postów');
});

router.get('/show/:id', function(req, res) {
  const post = posts.find(p => p.id == req.params.id);

  if (!post) {
    return res.status(404).send('Post not found');
  }

  res.render('post/show', { post });
});

router.get('/create', function(req, res) {
  res.render('post/create');
});

router.get('/edit/:id', function(req, res) {
  const post = posts.find(p => p.id == req.params.id);

  if (!post) {
    return res.status(404).send('Post not found');
  }

  res.render('post/edit', { post });
});

router.get('/delete/:id', function(req, res) {
  const post = posts.find(p => p.id == req.params.id);

  if (!post) {
    return res.status(404).send('Post not found');
  }

  res.render('post/delete', { post });
});S


module.exports = router;
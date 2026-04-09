let map;

function init() {
  map = L.map('map').setView([53.4285, 14.5528], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    crossOrigin: true
  }).addTo(map);

  Notification.requestPermission();
}

document.getElementById('getLocation').addEventListener('click', function() {
  navigator.geolocation.getCurrentPosition(function(pos) {
    const lat = pos.coords.latitude;
    const lon = pos.coords.longitude;
    map.setView([lat, lon], 16);
    L.marker([lat, lon]).addTo(map);
  });
});

document.getElementById('downloadMap').addEventListener('click', function() {
  document.getElementById('puzzle-board').classList.remove('win');
  const canvas = document.createElement('canvas');
  canvas.width = 600;
  canvas.height = 350;
  const ctx = canvas.getContext('2d');

  const tiles = document.querySelectorAll('.leaflet-tile-container img');
  let loaded = 0;

  tiles.forEach(function(tile) {
    const img = new Image();
    img.crossOrigin = "Anonymous";
    img.src = tile.src;
    img.onload = function() {
      const rect = tile.getBoundingClientRect();
      const mapRect = document.getElementById('map').getBoundingClientRect();
      ctx.drawImage(img, rect.left - mapRect.left, rect.top - mapRect.top, rect.width, rect.height);
      loaded++;
      if (loaded === tiles.length) {
        createPuzzle(canvas);
      }
    };
  });
});

function createPuzzle(source) {
  const piecesArea = document.getElementById('puzzle-pieces');
  const board = document.getElementById('puzzle-board');
  piecesArea.innerHTML = '';
  board.innerHTML = '';

  const pWidth = 150;
  const pHeight = 87.5;
  let piecesArray = [];

  for (let i = 0; i < 16; i++) {
    const r = Math.floor(i / 4), c = i % 4;
    const pCanvas = document.createElement('canvas');
    pCanvas.width = pWidth; pCanvas.height = pHeight;
    pCanvas.getContext('2d').drawImage(source, c * pWidth, r * pHeight, pWidth, pHeight, 0, 0, pWidth, pHeight);

    const piece = document.createElement('div');
    piece.className = 'piece';
    piece.draggable = true;
    piece.id = 'p' + i;
    piece.style.backgroundImage = 'url(' + pCanvas.toDataURL() + ')';
    piece.dataset.correct = i;
    piece.addEventListener('dragstart', function(e) { e.dataTransfer.setData('text', e.target.id); });
    piecesArray.push(piece);

    const slot = document.createElement('div');
    slot.className = 'slot';
    slot.dataset.idx = i;
    slot.addEventListener('dragover', function(e) { e.preventDefault(); });
    slot.addEventListener('drop', onDrop);
    board.appendChild(slot);
  }
  piecesArray.sort(() => Math.random() - 0.5).forEach(p => piecesArea.appendChild(p));
}

function onDrop(e) {
  e.preventDefault();
  const id = e.dataTransfer.getData('text');
  const piece = document.getElementById(id);
  if (e.target.classList.contains('slot') && !e.target.hasChildNodes()) {
    e.target.appendChild(piece);
    checkResult();
  }
}

function checkResult() {
  const slots = document.querySelectorAll('.slot');
  let correct = 0;
  slots.forEach(function(s) {
    if (s.firstChild && s.firstChild.dataset.correct == s.dataset.idx) correct++;
  });

  if (correct === 16) {
    console.debug("Gratulacje! Wszystkie puzzle na miejscu.");
    document.getElementById('puzzle-board').classList.add('win');
    if (Notification.permission === "granted") {
      new Notification("Zadanie wykonane!", { body: "Mapa ułożona pomyślnie!" });
    }
  }
}

window.onload = init;

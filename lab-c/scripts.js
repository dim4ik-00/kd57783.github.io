let map;

function initMap() {
  // Inicjalizacja mapy Leaflet [cite: 15]
  map = L.map('map').setView([52.2297, 21.0122], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap',
    crossOrigin: true
  }).addTo(map);

  // Zapytanie o powiadomienia [cite: 32]
  if (Notification.permission !== "granted") {
    Notification.requestPermission();
  }
}

// Obsługa geolokalizacji [cite: 14, 34]
document.getElementById('getLocation').addEventListener('click', () => {
  navigator.geolocation.getCurrentPosition(pos => {
    const { latitude, longitude } = pos.coords;
    map.setView([latitude, longitude], 16);
    L.marker([latitude, longitude]).addTo(map);
  });
});

// Pobieranie mapy i generowanie puzzli [cite: 16, 17, 35, 36]
document.getElementById('downloadMap').addEventListener('click', () => {
  const board = document.getElementById('puzzle-board');
  board.classList.remove('win');

  const canvas = document.createElement('canvas');
  canvas.width = 600;
  canvas.height = 350;
  const ctx = canvas.getContext('2d');

  const tiles = document.querySelectorAll('.leaflet-tile-container img');
  let loaded = 0;

  tiles.forEach(tile => {
    const img = new Image();
    img.crossOrigin = "Anonymous";
    img.src = tile.src;
    img.onload = () => {
      const rect = tile.getBoundingClientRect();
      const mapRect = document.getElementById('map').getBoundingClientRect();
      ctx.drawImage(img, rect.left - mapRect.left, rect.top - mapRect.top, rect.width, rect.height);
      loaded++;
      if (loaded === tiles.length) generatePuzzles(canvas);
    };
  });
});

function generatePuzzles(sourceCanvas) {
  const piecesArea = document.getElementById('puzzle-pieces');
  const board = document.getElementById('puzzle-board');
  piecesArea.innerHTML = '';
  board.innerHTML = '';

  const pWidth = 150;
  const pHeight = 87.5;

  let pieces = [];
  for (let i = 0; i < 16; i++) {
    const r = Math.floor(i / 4), c = i % 4;
    const pCanvas = document.createElement('canvas');
    pCanvas.width = pWidth;
    pCanvas.height = pHeight;

    pCanvas.getContext('2d').drawImage(
      sourceCanvas,
      c * pWidth, r * pHeight, pWidth, pHeight,
      0, 0, pWidth, pHeight
    );

    const piece = document.createElement('div');
    piece.className = 'piece';
    piece.draggable = true;
    piece.id = `p-${i}`;
    piece.style.backgroundImage = `url(${pCanvas.toDataURL()})`;
    piece.dataset.correctPos = i;

    // Drag & Drop [cite: 18, 37]
    piece.addEventListener('dragstart', e => e.dataTransfer.setData('text', e.target.id));
    pieces.push(piece);

    const slot = document.createElement('div');
    slot.className = 'slot';
    slot.dataset.index = i;
    slot.addEventListener('dragover', e => e.preventDefault());
    slot.addEventListener('drop', handleDrop);
    board.appendChild(slot);
  }
  // Mieszanie puzzli [cite: 36]
  pieces.sort(() => Math.random() - 0.5).forEach(p => piecesArea.appendChild(p));
}

function handleDrop(e) {
  e.preventDefault();
  const id = e.dataTransfer.getData('text');
  const piece = document.getElementById(id);
  if (e.target.classList.contains('slot') && !e.target.hasChildNodes()) {
    e.target.appendChild(piece);
    checkWin();
  }
}

function checkWin() {
  const slots = document.querySelectorAll('.slot');
  let correct = 0;
  slots.forEach(s => {
    // Weryfikacja czy element na miejscu [cite: 38]
    if (s.firstChild && s.firstChild.dataset.correctPos == s.dataset.index) {
      correct++;
    }
  });

  if (correct === 16) {
    console.debug("Gratulacje! Wszystkie puzzle na miejscu.");
    document.getElementById('puzzle-board').classList.add('win');

    // Powiadomienie systemowe [cite: 19, 39]
    if (Notification.permission === "granted") {
      new Notification("LAB C", { body: "Mapa ułożona pomyślnie!" });
    }
  }
}

window.onload = initMap;

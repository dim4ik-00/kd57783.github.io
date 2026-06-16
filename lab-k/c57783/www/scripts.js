const API_KEY = "5eb830ac60296eca8c68aecd1750b906";

function getWeather() {
  const city = document.getElementById("city").value;
  if (!city) return alert("Wpisz miasto!");

  getCurrentWeather(city);
  getForecast(city);
}

function getCurrentWeather(city) {
  const xhr = new XMLHttpRequest();
  const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${API_KEY}&units=metric&lang=pl`;

  xhr.open("GET", url, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const data = JSON.parse(xhr.responseText);

      console.log("Current Weather Data:", data);

      const icon = data.weather[0].icon;
      const iconUrl = `https://openweathermap.org/img/wn/${icon}@2x.png`;

      document.getElementById("current").innerHTML = `
            <div class="card">
                <h2>${data.name}</h2>
                <div id="time"></div>
                <div class="current-box">
                    <img src="${iconUrl}">
                    <div>
                        <div class="big-temp">${data.main.temp}°C</div>
                        <p>Odczuwalna: ${data.main.feels_like}°C</p>
                        <p style="text-transform: capitalize;">${data.weather[0].description}</p>
                    </div>
                </div>
            </div>
        `;
      startClock();
    }
  };

  xhr.send();
}

function startClock() {
  if (window.clockInterval) clearInterval(window.clockInterval);

  window.clockInterval = setInterval(() => {
    const now = new Date();
    const date = now.toLocaleDateString();
    const time = now.toLocaleTimeString();

    const timeElement = document.getElementById("time");
    if (timeElement) {
      timeElement.innerHTML = `${date} ${time}`;
    }
  }, 1000);
}

function getForecast(city) {
  const url = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${API_KEY}&units=metric&lang=pl`;

  fetch(url)
    .then(res => res.json())
    .then(data => {
      console.log("Forecast Data (5 days):", data);

      let html = `<div class="forecast-title">Prognoza na 5 dni</div>`;

      data.list.forEach(item => {
        const icon = item.weather[0].icon;
        const iconUrl = `https://openweathermap.org/img/wn/${icon}.png`;

        const dateObj = new Date(item.dt_txt);
        const date = dateObj.toLocaleDateString();
        const time = dateObj.getHours() + ":00";

        html += `
          <div class="forecast-item">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; width: 100%;">
              <div style="min-width: 100px;"><strong>${date}</strong></div>
              <div style="min-width: 60px;">${time}</div>
              <img src="${iconUrl}" alt="icon">
              <div style="min-width: 80px;">
                <strong>${item.main.temp}°C</strong>
              </div>
              <div style="flex: 1; text-align: right; color: #94a3b8; font-size: 0.9em;">
                ${item.weather[0].description}
              </div>
            </div>
          </div>
        `;
      });

      document.getElementById("forecast").innerHTML = html;
    })
    .catch(err => console.error("Błąd pobierania prognozy:", err));
}

fetch('https://wttr.in/Jember?format=j1')
    .then(r => r.json())
    .then(data => {
        const c = data.current_condition[0];
        const desc = c.weatherDesc[0].value;
        const temp = c.temp_C;
        const feel = c.FeelsLikeC;
        document.getElementById('weather-text').textContent =
            temp + '°C · ' + desc + ' · Terasa ' + feel + '°C';
    })
    .catch(() => {
        document.getElementById('weather-text').textContent = '29°C · Cerah Berawan';
    });
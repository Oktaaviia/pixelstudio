fetch('https://wttr.in/Jember?format=j1&lang=id')
    .then(r => r.json())
    .then(data => {
        const c = data.current_condition[0];
        let desc = c.lang_id ? c.lang_id[0].value : c.weatherDesc[0].value;
        
        // Manual translation mapping fallback in case wttr.in returns English
        const translationMap = {
            "sunny": "Cerah",
            "clear": "Cerah",
            "partly cloudy": "Cerah Berawan",
            "cloudy": "Berawan",
            "overcast": "Mendung",
            "mist": "Kabut Ringan",
            "fog": "Kabut",
            "patchy rain nearby": "Gerimis Ringan",
            "light rain": "Hujan Ringan",
            "moderate rain": "Hujan Sedang",
            "heavy rain": "Hujan Lebat",
            "thundery outbreaks nearby": "Hujan Petir"
        };
        
        if (translationMap[desc.toLowerCase()]) {
            desc = translationMap[desc.toLowerCase()];
        }
        
        const temp = c.temp_C;
        const feel = c.FeelsLikeC;
        document.getElementById('weather-text').textContent =
            'Jember: ' + temp + '°C · ' + desc + ' · Terasa ' + feel + '°C';
    })
    .catch(() => {
        document.getElementById('weather-text').textContent = 'Jember: 29°C · Cerah Berawan';
    });
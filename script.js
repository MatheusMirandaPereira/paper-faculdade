document.querySelector('#search').addEventListener('submit', async (event) => {
    event.preventDefault();

    const cityName = document.querySelector('#city_name').value;

    if (!cityName) {
        document.querySelector("#weather").classList.remove('show');
        showAlert('Você precisa digitar uma cidade...');
        return;
    }

    const formData = new FormData();
    formData.append('city_name', cityName);

    const response = await fetch('weather.php', {
        method: 'POST',
        body: formData
    });

    const json = await response.json();

    if (json.error) {
        showAlert(json.error);
        document.querySelector("#weather").classList.remove('show');
    } else {
        showInfo(json);
    }
});

function showInfo(json) {
    showAlert('');

    document.querySelector("#weather").classList.add('show');

    document.querySelector(".title").innerHTML = `${json.city}, ${json.country}`;
    document.querySelector('.temp_value').innerHTML = `${json.temp.toFixed(1).toString().replace('.', ',')} <sup>cº</sup>`;
    document.querySelector(".temp_description").innerHTML = `${json.description}`;
    document.querySelector('.temp_img').setAttribute('src', `https://openweathermap.org/img/wn/${json.tempIcon}@2x.png`);
    document.querySelector('.temp_max').innerHTML = `${json.tempMax.toFixed(1).toString().replace('.', ',')} <sup>cº</sup>`;
    document.querySelector('.temp_min').innerHTML = `${json.tempMin.toFixed(1).toString().replace('.', ',')} <sup>cº</sup>`;
}

function showAlert(msg) {
    document.querySelector('#alert').innerHTML = msg;
}

@extends('base')
@section('content')
    <div class="row">
        <div class="col-md-2 d-block" id="without_data"></div>
        <div class="col-md-2 ml-4 d-none mb-5" id="with_data">
            <div class="card">
                <div class="card-body" id="weather_information_card">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end align-items-center">
                            Today in &nbsp; <b id="city"></b>
                            &nbsp;
                            <img alt="" id="weather_img">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 d-flex justify-content-between align-items-center">
                            <h4 id="temperature"></h4>
                            &nbsp;
                            <h4 id="temperature_fahrenheit"></h4>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>
                                General
                            </label> <br>
                            <b id="general"></b>
                        </div>
                        <div class="col-md-4">
                            <label>
                                Description
                            </label> <br>
                            <b id="description"></b>
                        </div>
                        <div class="col-md-4">
                            <label>
                                Humidity
                            </label> <br>
                            <b id="humidity"></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" style="height: 900px;">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="text-center" id="overlay" style="display: none">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: new google.maps.LatLng(38.89511, -77.03637),
                zoom: 6,
            });

            map.addListener('click', async (city) => {
                let lat_lng = city.latLng.toJSON();

                await requestData(lat_lng);
            })
        }

        window.initMap = initMap;

        async function requestData(lat_lng) {

            loading(1);

            let url = window.location.origin;

            let response = await axios.get(url+`/weather/get-city-weather?q=${JSON.stringify(lat_lng)}`);
            if(response.data.state != 200) {
                loading(2);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: response.data.message,
                });
                console.log(response.data.error);
                return;
            }

            let data = response.data.data;

            let city = document.getElementById('city');
            if(city){
                city.innerHTML = data?.name;
            }

            let temperature = document.getElementById('temperature');
            let temperature_fahrenheit = document.getElementById('temperature_fahrenheit');
            if(temperature && temperature_fahrenheit){
                let real_temp = data.main.temp;
                let converted_to_celcius = (real_temp - 273.15);
                let converted_to_fahrenheit = ((converted_to_celcius * (9/5)) + 32);
                temperature.innerHTML = '+'+Math.round(converted_to_celcius)+'°C';
                temperature_fahrenheit.innerHTML = '+'+Math.round(converted_to_fahrenheit)+'°F';
            }

            let weather_img = document.getElementById('weather_img');
            if(weather_img) {
                weather_img.setAttribute('src', `https://openweathermap.org/img/wn/${data.weather[0]?.icon}@2x.png`);
            }

            let general = document.getElementById('general');
            if(general) {
                general.innerHTML = data?.weather[0]?.main;
            }

            let description = document.getElementById('description');
            if(description) {
                description.innerHTML = data?.weather[0]?.description;
            }

            let humidity = document.getElementById('humidity');
            if(humidity) {
                humidity.innerHTML = Math.round(data?.main.humidity)+'%';
            }

            loading(2);
        }

        function loading(type) {
            if(type == 1) {
                document.getElementById('with_data').classList.remove('d-block');
                document.getElementById('with_data').classList.add('d-none');
                document.getElementById('without_data').classList.remove('d-none');
                document.getElementById('without_data').classList.add('d-block');
                document.getElementById('overlay').style.display = "flex";
            } else {
                document.getElementById('with_data').classList.remove('d-none');
                document.getElementById('with_data').classList.add('d-block');
                document.getElementById('without_data').classList.remove('d-block');
                document.getElementById('without_data').classList.add('d-none');
                document.getElementById('overlay').style.display = "none";
            }
        }
    </script>
@endpush

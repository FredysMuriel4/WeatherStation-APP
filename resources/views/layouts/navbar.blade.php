@yield('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light p-3" style="background-color: #0B1632 !important; color: #26A3B9 !important;">
    <a class="navbar-brand">
        <img src="{{asset('img/weather_icon.png')}}" alt="" width="8%" class="index">
        <b class="index"> WeatherStation APP </b>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/weather/history" title="Inicio" style="color: #26A3B9;">
                    <i class="fad fa-history"></i>
                    <b> History </b>
                </a>
            </li>
        </ul>
    </div>
</nav>
<script>
    let index = document.getElementsByClassName('index');
    if(index) {
        for (const i of index) {
            i.addEventListener('click', () => {
                location.href="/";
            });
        }
    }
</script>

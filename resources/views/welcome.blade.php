<h1>Выберите город:</h1>
@if(session()->has('selected_city'))
    <p>Город: {{ session('selected_city') }}</p>
    <a href="{{route('about', session('selected_city'))}}">О нас</a>
    <a href="{{route('news', session('selected_city'))}}">Новости</a>
@endif
<ul>
    @foreach($cities as $city)
        <li>
            <a href="{{ session()->has('selected_city') &&  session('selected_city') == $city['name'] ? '' : route('select.city', $city['slug']) }}" 
                style="{{ session()->has('selected_city') &&  session('selected_city') == $city['name'] ? 'font-weight:bold;' : '' }}">
                {{ $city['name'] }}
            </a>
        </li>
    @endforeach
</ul>
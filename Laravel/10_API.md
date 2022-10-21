# API

Een gebruiksvriendelijke applicatie bestaat zeker en vast uit een duidelijke, overzichtelijke en snelle front-end. Om dat te verwezenlijken hebben we meer nodig dan enkel back-end development. Je kan een applicatie vooral sneller maken door via JavaScript data op te halen of door te sturen naar de back-end (server).

Laravel voorziet voor ons al standaard een manier om onze API te structureren en splitsen van onze gewone 'web' requests.

De routes van de API kan je terugvinden onder `routes/api.php`. Elke route die hierin gedefinieerd staat kan je aanroepen vanaf `/api`.

Hier kan je uiteraard ook weer kiezen tussen de get of post methode.

Onderstaande voorbeeld maakt een API route aan die bereikbaar is via /api/users/{zoek}

```
// Onderstaande route kan je bijvoorbeeld aanroepen via: /api/users/di
Route::get('/users/{q}', function ($q) {
    $users = User::select('id', 'name')->where('name', 'LIKE', '%' . $q . '%')->get();
    return json_encode($users);
});
```

## HTTP response: Content-Type

Echter staat bij bovenstaande route de http header nog steeds op de standaard HTML. Dus afhankelijk van welke content je via je API terugstuurt, moet je ook het Content-Type aanpassen via de headers. Onderstaande is dus beter.

```
Route::get('/users/{q}', function ($q) {
    $users = User::select('id', 'name')->where('name', 'LIKE', '%' . $q . '%')->get();
    return response( json_encode($users) )
                ->header('Content-Type', 'text/plain');
});
```

> Afhankelijk van je browser zal je een duidelijk verschil zien in het renderen van de response.

## Ophalen via fetch

In de edit pagina van projecten kan ik er dan bijvoorbeeld voor zorgen dat er gezocht kan worden op een naam. Zonder dat alle users initieel worden opgehaald.

```

<p>
Users
<input type="text" id="search_user">
<div id="checkboxes">
@foreach($project->users as $user)
    <label><input type="checkbox" name="users[]" value="{{ $user->id }}" checked> {{ $user->name }}</label>
@endforeach
</div>
</p>

...

<script>
let $search_user = document.getElementById('search_user');
let $checkboxes = document.getElementById('checkboxes');

$search_user.addEventListener('keyup', (evt) => {
    var search_string = $search_user.value;
    if( search_string.length ) {
        fetch('/api/users/' + search_string)
            .then((response) => response.json())
            .then((data) => {
                $checkboxes.innerHTML = '';
                data.forEach( ($user) => {
                    $checkboxes.innerHTML += '<label><input type="checkbox" name="users[]" value="' + $user.id + '"> ' + $user.name + '</label>'
                });
            });
    }
});
</script>
```

## Views renderen in API

Je moet uiteraard niet altijd JSON terugsturen naar de client. Het voordeel van JSON is dat dit een weinig data vergt. Echter moet je er dan wel rekening mee houden dat je de HTML moet opbouwen via JavaScript. En je dus 2x eenzelfde view moet onderhouden. Een in blade voor de back-end en een in JS voor de front-end.

Je kan via de API ook HTML terugsturen. Je rendert dus al meteen de HTML.

```
Route::get('/users/{q}', function ($q) {
    $users = User::select('id', 'name')->where('name', 'LIKE', '%' . $q . '%')->get();
    $content = '';
    foreach($users as $user) {
        $content .= view('users.item', ['user' => $user])->render();
    }
    return $content;
});
```
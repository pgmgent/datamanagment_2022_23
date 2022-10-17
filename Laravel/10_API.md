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
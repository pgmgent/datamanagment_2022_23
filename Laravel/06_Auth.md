# Authenticatie

Voor de eindopdracht is het de bedoeling dat jullie een back-office maken waar we de inhoud van de database kunnen beheren.

De meest eenvoudige manier om dit te doen is gebruik te maken van een package waarin reeds de routes, controllers en views vooraf zijn gemaakt en geïnstalleerd worden.

Het nadeel is dat bij de meeste reeds een keuze is gemaakt voor front-end CSS framework. En dat er geen ongestijlde package bestaat.

Persoonlijk vind ik de package van `laravel ui` de minst overladen package en dus het eenvoudigst aan te passen. Deze maakt gebruik van Bootstrap maar deze is eenvoudig weg te halen. Maar zelf verwijzen ze in hun documentatie naar de meer recentere Laravel Breeze starter kit. Bij Laravel Breeze worden er heel wat meer routes, views en components geïnstalleerd die allemaal gestijld zijn met Tailwind. Waardoor deze minder flexibel is om aan te passen. Maar indien je voor je backoffice toch Tailwind wenst te gebruiken misschien een goede keuze.

## Laravel UI

Installeer de `laravel/ui` package

```
composer require laravel/ui
```

En voer daarna een van onderstaande installatie script uit. 

> **Let wel op** dat indien je zelf reeds een `layout/app.blaze.php` bestand hebt. Je deze eventueel hernoemt of dupliceert als backup. Want het installatie script zal een nieuwe layout installeren met dezelfde naam (hij vraagt wel eerst bevestiging)

```
// Kies een van onderstaande
php artisan ui bootstrap --auth
php artisan ui vue --auth
php artisan ui react --auth
```

Je zal zien dat er nu Routes, Controllers en Views zijn aangemaakt om in te loggen, te registeren en naar het dashboard te gaan.

Wat betreft het dashboard zit er een fout in deze package. Pas de route home aan naar dashboard:

```
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Aanpassen naar
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
```

Je kan nu zelf een gebruiker aanmaken via `/register` en daarna inloggen via `/login`.

## Larabel Breeze

Voor Laravel Breeze moet je gelijkaardige stappen doorlopen. Installeer de package:

```
composer require laravel/breeze --dev
```

Om daarna de scripts te runnen en de javascript en css te builden.

```
php artisan breeze:install
 
php artisan migrate
npm install
npm run dev
```

Je kan nu zelf een gebruiker aanmaken via `/register` en daarna inloggen via `/login`.

## Authenticatie toepassen

De bedoeling is dat je vanaf nu delen van je website kan afschermen.

Dit kan op verschillende manieren. Je kan een volledige Controller beveiligen. Hiervoor gebruik je de constructor van die class en de middleware van auth. Hieronder een voorbeeld van de `AdminController.php`.

```
class AdminController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
}
```

Je kan uiteraard ook 1 bepaalde method beveiligen van een Controller. Bv de edit method.

```
class ProjectController extends Controller {
    public function edit() {
        $this->middleware('auth');
    }
}
```

Of meteen in de routing:

```
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');
```

## Huidige user ophalen

```
use Illuminate\Support\Facades\Auth;
 
// Retrieve the currently authenticated user...
$user = Auth::user();
echo $user->email;
```

## Middleware zelf aanmaken

We hebben al gezien dat de middleware er kan voor zorgen dat er gekeken wordt of een bezoeker al dan niet is ingelogd.

Maar meestal willen we ook gaan valideren of een ingelogde gebruiker bepaalde rechten heeft.

Hiervoor kunnen we zelf een middleware aanmaken. Maak in eerste instantie de middleware class aan `app/Http/Middleware/AuthenticateAdmin.php` met onderstaande voorbeeldcode. Hierbij zal een bezoeker gecontroleerd worden of hij is ingelogd en de naam 'George' heeft.

```
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateAdmin extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (! $request->user() || $request->user()->name !== 'George') {
            return redirect('/');
        }

        return $next($request);
    }
}
```

Daarna moeten we deze middleware toevoegen aan de lijst van routeMiddleware in `app/Http/Kernel.php`.

```
 protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.admin' => \App\Http\Middleware\AuthenticateAdmin::class,
    ...
];
```

Vanaf nu kunnen we deze middleware gaan gebruiken. De meest eenvoudige manier is om dit rechtstreeks in onze route te doen. Hieronder een voorbeeld van een pagina die dus enkel bereikbaar is voor ingelogde personen met de naam 'George'.

```
Route::get('/george', function () {
    return 'Enkel voor ingelogde gebruikers met de naam George';
})->middleware('auth.admin');
```
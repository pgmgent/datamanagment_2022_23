# Introductie Laravel

## PHP Frameworks 

Development in 'plain' PHP gebeurt niet veel meer. Vooral omdat er vaak veel repetitief werk is en hierbij steeds met alle security regels moet rekening houden. Om het werk van developers eenvoudiger te maken zijn er ook bij PHP verschillende frameworks en CMSen.

Momenteel zijn er 3 grote spelers binnen de frameworks: Laravel, Symfony en CodeIgniter. Volgens Google Trends is in [Vlaanderen](https://trends.google.nl/trends/explore?geo=BE&q=%2Fm%2F0jwy148,%2Fm%2F09cjcl,%2Fm%2F02qgdkj) Laravel de koploper met 75%. [Wereldwijd](https://trends.google.nl/trends/explore?q=%2Fm%2F0jwy148,%2Fm%2F09cjcl,%2Fm%2F02qgdkj) is het verschil zelfs nog groter. 

Via JobAt kon ik, op datum van 1 oktober 2022, 26 jobs voor PHP Developers terugvinden,  9 daarvan voor Laravel en 8 voor Symfony. Daar is het verschil dus minder groot. Bij ICTjobs.be is er 1 vacature meer voor Symfony, voor CodeIgniter is er momenteel zelfs maar 1 vacature.

De keuze binnen de opleiding is gevallen voor Laravel. Maar de concepten van MVC zijn bij ieder platform gelijkaardig. Daarom moet een switch naar een ander framework in jullie verder loopbaan geen probleem mogen vormen. 

## Installatie Laravel

Om Laravel te installeren hebben we eerst en vooral [Composer](https://getcomposer.org/download/) nodig.

Voer daarna volgende commando's uit in je CLI:

```
composer create-project laravel/laravel my-first-project 
cd my-first-project
php artisan serve
```

Hierna kan je surfen naar de url die de Artisan CLI interface heeft gestart.

## Routing

Bij elk van deze frameworks wordt gebruik gemaakt van een `.htaccess` file die je bij Laravel kan terugvinden onder de `/public` folder. Deze htaccess zorgt ervoor dat elke url (dat niet bestaat) wordt opgevangen door de `index.php` van die folder.

Er dient dus een andere manier te zijn dan het filesystem om de correcte pagina in te laden. 

Hiervoor maakt Laravel gebruik van een Routing Class. De configuratie van de routing voor de website kan je terugvinden onder `routes/web.php`.

Maak bij wijze van test onderstaande routing aan en test deze door te surfen naar [http://127.0.0.1:8000/hello](http://127.0.0.1:8000/hello)

```
Route::get('/hello', function () {
    echo 'Hello World';
});
```

We kunnen ook dynamische parameters toevoegen aan onze url. Maak onderstaande nieuwe routing aan en surf naar bijvoorbeeld [http://127.0.0.1:8000/hello/PGM](http://127.0.0.1:8000/hello/PGM). 

```
Route::get('/hello/{name}', function ($name) {
    echo 'Hello ' . $name;
});
```

Je kan ook een redirect doen van de ene naar een andere URL.

```
Route::redirect('/hello/world', '/hello', 301);
```

> **Let wel op dat deze route boven de route /hello/{name} staat!**

Zoals je kon zien stond er in het project reeds een route op de '/' van je website. Hierbij zie je dat Laravel de view functie aanroept en een waarde meegeeft.

## Views

Deze view kan je terugvinden onder `/resources/views`, als je dus `view('welcome')` aanroept zal de `welcome.blade.php` uitgevoerd worden.

Hierbij zie je dat Laravel standaard gebruikt maakt van de Blade template engine. Maar kan je ook verder PHP gebruiken want het is en blijft een PHP-pagina.

Maak een view aan voor de route hello en koppel beide reeds aangemaakte routes aan deze view.

Maak de view dynamisch zodat de naam op het scherm wordt getoond. Dit kan door de parameter mee te geven met de view functie:

```
Route::get('/hello/{name}', function ($name) {
    return view('hello', ['name' => $name]);
});
```
In de template kan je dan de naam printen via php of nog eenvoudiger, via blade.

```
<h1>Hello via php: <?= $name; ?></h1>
<h1>Hello via blade:  {{ $name }}</h1>
```

## Controller

Je zou, in theorie, alle functionaliteit kunnen schrijven in de Routing config maar dat is niet de bedoeling. Dat is het werk van een Controller binnen een MVC framework.

Maak een nieuwe controller aan `CourseController.php` in de folder `/app/Http/Controllers`. Hierin hebben we ook methods nodig die aangeroepen kunnen worden vanuit de Routing. Plaats onderstaande code in de `CourseController.php`.

```
<?php

namespace App\Http\Controllers;


class CourseController extends Controller
{
    public function index() {
        return view('course.list');
    }

    public function detail($id) {
        return view('course.detail', [
            'course_id' => $id
        ]);
    }
}
```

In de routing moeten we nu de CourseController en bijhorende method aanroepen in plaats van rechtstreeks de view. 

```
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/course/{id}', [CourseController::class, 'detail']); 
```

**Let wel op dat je ook de namespace gaat toevoegen bovenaan de routing config.**

```
use App\Http\Controllers\CourseController;
```

Als laatste moeten we nog de 2 views aanmaken. Zoals je kan zien roepen we deze via de CourseController op via `view('course.list')`. We moeten dus een nieuwe folder `course` aanmaken in de views folder met daarin 2 views: `list.blade.php` en `detail.blade.php`. Op die manier kunnen we onze views mooi structureren.

## Blade layouts

We hebben nu al enkele views aangemaak, telkens met hun eigen HTML, head en body. Qua onderhoud niet zo handig als we een aanpassing moeten doen of een extra CSS of JS bestand moeten linken.

De oplossing hiervoor zijn blade templates. Je maakt 1 of meerdere basis template waarin placeholders zitten voor de inhoud van je pagina's (views).

Maak volgend bestand aan: `resources/views/layouts/app.blade.php` met een basis HTML en 1 of meerdere placeholders.

```
<!DOCTYPE html>
<html lang='nl'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') - App Name</title>
    </head>
    <body>
        @section('header')
        <header>
            <!-- Dit is de standaard header, indien niets gedefineerd in de view zal deze verschijnen. -->
            <div class="brand">App Name</div>
        </header>
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
```

In je view defineer je welke layout je wenst te gebruiken en vul je de inhoud in.

```
<!-- resources/views/course/detail.blade.php -->
 
@extends('layouts.app')
 
@section('title', 'Course Detail')
 
@section('content')
    <h1>Detailpagina van het vak met id: {{ $course_id }}</h1>
    <p>Hier zal de inhoud komen</p>
@endsection
```

## Model

Nu moeten we nog de correcte inhoud uit onze database kunnen ophalen. Dit gebeurt in de model.

Maar daarvoor moeten we eerst een database hebben. Hiervoor moet je eerst de juiste connectie maken in de `.env` file. Pas de connectiegegevens aan volgens jouw MySQL database:

```
DB_DATABASE=pgm-laravel
DB_USERNAME=root
DB_PASSWORD=secret123
```

Daarna moeten we de migration scripts runnen van Laravel. Bekijk alvast eens de bestaande migrations `database/migrations/`.

Voor daarna onderdtaande commando uit in je CLI.

```
php artisan migrate
```

Indien de database die je hebt gedefineerd in je `.env` nog niet bestaat, zal je de vraag krijgen om deze aan te maken.

We kunnen nu zelf migrations schrijven ofwel bestaande tabellen importeren of aanmaken rechstreeks in de database of via een DBMS.

Voor de eerste oefening imporeren we de pgm courses sql van vorige les.

### Model aanmaken

Daarna kunnen we ons eerste model aanmaken en afleiden van een basis Model. Hierdoor erven we meteen alle methods over van dit basis Model.

Maak de model `Course.php` aan in de folder `/app/Models/` met onderstaande code.

```
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Course extends Model
{

}
```

Het basis model gaat uit van de tabel `courses` (Class name in onderkast + 's') en de primary key `id`.

> Indien je dit anders wenst dan moet je dit definiëren aan het begin van je model.
> ```
>    protected $table = 'my_courses';
>    protected $primaryKey = 'course_id';
>```


Via de Eloquent ORM kan je nu data ophalen via static functies van je model. (Meer info over de mogelijkheden)[https://laravel.com/docs/4.2/eloquent] of hieronder enkele die je kan testen binnen de courses tabel en Course model.

```
//Alle records ophalen
$courses = Course::all();
var_dump($courses);

//Het vak ophalen met primary key 1
$course = Course::find(1);
var_dump($course);

//Zoek vakken van Dieter De Weirdt
$courses = Course::where('teacher_short', '=', 'DDW')->get();
var_dump($courses);
```

Pas nu de Controller aan zodat je de inhoud kan doorgeven aan de View. In de view moet je de inhoud ook ophalen.

## Meer info

(Blade templates)[https://laravel.com/docs/9.x/blade]

# CRUD via Eloquent ORM

Laravel maakt gebruik van een Object-relational mapper (ORM) om eenvoudig interactie te hebben met de database. 

Een ORM vertaald relationele data om naar object georiënteerde programma code.

Dit om het schrijven van SQL statements te vereenvoudigen en de kans op SQL Injecten te verkleinen.

Je kan het vergelijken met `TypeORM` or `Prisma` binnen Node.js

## Basis
Standaard wordt ieder Model uitgerust met de methods die gebruik maken van dit ORM. Het ORM zorgt er dus voor dat database records worden omgevormd naar Objecten die we kunnen gebruiken.

Zo hebben we reeds de methods `all()` en `find()` gezien bij de introductie:

```
//Alle records ophalen
$courses = Course::all();
var_dump($courses);

//Het vak ophalen met primary key 1
$course = Course::find(1);
var_dump($course);
```

Uiteraard zullen applicaties gebruik maken van meer uitdagende SQL queries om data op te halen.

## Query opbouwen

Een query opbouwen kan je vergelijken met het schrijven van een sql query. Het grootste verschil is vooral dat de volgorde bij SQL altijd gerespecteerd moet worden. Maar bij het opbouwen via de Eloquent ORM is dat niet meer van belang. Hoewel het me logisch en leesbaar lijkt om dit nog steeds te behouden.

```
SELECT * FROM flights 
WHERE active = 1 AND from = 'BRU'
ORDER BY departure_date DESC
LIMIT 20
```

Als we bovenstaande SQL statement in Laravel willen opbouwen via een Model `Flight` dan zal dit als volgt gebeuren.

```
$flights = Flight::where('active', 1)
            ->where('from', 'BRU')
            ->orderBy('departure_date', 'DESC')
            ->limit(20)
            ->get();
```

Indien je queries moet uitvoeren dat ruimer zijn dan 1 model of indien er geen model is kan je ook de `DB` Model gebruiken hiervoor

```
$flights = DB::table('flights')
                ->where('active', 1)
                ->where('from', 'BRU')
                ->orderBy('departure_date', 'DESC')
                ->limit(20)
                ->get();
```

[Een volledig overzicht van de mogelijkheden kan je terugvinden op de Laravel handleiding](https://laravel.com/docs/9.x/queries#limit-and-offset)

## Aanmaken van nieuwe records

Via de models kan je ook eenvoudig een nieuw record aanmaken in de database.

```
$flight = new Flight();
$flight->name = 'Tuifly to Barcelona';
$flight->from = 'BRU';
$flight->to = 'BCN';
$flight->departure_date = '2022-12-01 14:35:00';
$flight->save();
```

## Record aanpassen

Hetzelfde kunnen we doen voor het aanpassen van een record.

```
$flight = Flight::find(123);
$flight->departure_date = '2022-12-01 16:05:00';
$flight->save();
```

## Verwijderen

Het verwijderen van 1 record komt overeen met het wijzigen, maar uiteraard met gebruik van de delete method.

```
$flight = Flight::find(123);
$flight->delete();

// Of korter geschreven
Flight::find(123)->delete();
```

Je kan ook meerdere records dat voldoen aan een zoekopdracht in 1 actie verwijderen.

```
//Alle vluchten naar Barcelona uit de database verwijderen
Flight::where('to', 'BCN')->delete();
```

**Let op!** Bij het verwijderen van records zijn die ook meteen verdwenen. Een soort prullenmand bestaat niet echt binnen MySQL.

## Soft delete of zacht verwijderen

Laravel heeft wel een ingebouwde manier om records niet meteen te wissen.

Hierbij wordt een extra kolom toegevoegd `deleted_at`. Indien een record verwijderd is zal hier de datum ingevuld worden. Het records zal dus blijven bestaan in de database maar zal niet meer opgehaald worden bij een gewone `get()` of `find()`.

In je model moet je aangeven dat deze werkt via zo een soft delete:

```
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class Flight extends Model
{
    use SoftDeletes;
}
```

Uiteraard moet ook eerst de `deleted_at` kolom aangemaakt worden. Dit kan via een migration.

```
Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('from');
            $table->string('to');
            $table->date('departure_date');
            $table->softDeletes();
            $table->timestamps();
        });
```
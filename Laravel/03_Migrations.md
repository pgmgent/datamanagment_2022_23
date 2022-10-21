# Laravel migrations

Via de PHP Artisan van Laravel kan je migrations aanmaken en uitvoeren op je database.

Maak een eerste migrations file aan via het commando

```
php artisan make:migration create_projects_table
```

Je zal merken dat eer een nieuwe php migration file is aangemaakt on `data/migrations/` met de timestamp.

Als je deze zou uitvoeren dan zal deze een tabel projects aanmaken met een id en de timestamps created_at en updated_at.

Om al eens op voorhand te kijken wat een migration zal uitvoeren van SQL queries kan je de migration starten met de extra parameter `pretend`.

```
php artisan migrate --pretend
```

We moeten dus eerst nog enkele extra kolommen toevoegen vooraleer we de migration gaan uitvoeren. Bij iedere kolom moeten we het data type meegeven. (Bekijk hier het overzicht van datatypes)[https://laravel.com/docs/9.x/migrations#available-column-types].

```
Schema::create('projects', function (Blueprint $table) {
    $table->id();
    $table->string('name', 150);
    $table->text('description');
    $table->boolean('publish');
    $table->timestamps();
});
```

Als de migration in orde is kunnen we deze testen via de pretend of meteen uitvoeren:

```
php artisan migrate --pretend
php artisan migrate
```

Je kan nu meerdere migrations aanmaken per tabel. Maar je kan uiteraard ook aanpassingen doen aan een tabel. Bijvoorbeeld het toevoegen van een extra kolom.

```
Schema::table('projects', function (Blueprint $table) {
    $table->integer('year');
});
```

(Meer info in de handleiding van Laravel)[https://laravel.com/docs/9.x/migrations]



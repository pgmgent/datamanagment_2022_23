# Forms and Security

We kunnen nu ook templates maken waarin formulier voorkomen. We gaan ervanuit gaan dat de indien we gegevens willen ophalen we de GET methode gebruiken. Als we gegevens naar de database willen sturen de POST gebruiken. Uiteraard zijn er steeds uitzonderingen op deze regel.

## CSRF: Cross Site Request Forgery

Om je te wapenen tegen CSRF heeft Laravel een middleware voorzien om de request te controleren hierop.

Bij het aanmaken van een formulier moet je dan wel een include doen via `@csrf`. Dit zal een soort sessie ID meegeven als hidden field in je formulier. Hierop zal Laravel dan controleren of de request weldegelijk van je eigen website komt en niet van een externe fishing website.

```
<form method="POST">
    @csrf
</form>
```

## Editeren

### Stap 1: Maak een template aan 

Deze template voorzie je van een formulier om de content aan te passen. **(Vergeet de csrf niet)**

```
@section('content')
<h1>Edit Course</h1>
<form method="POST">
    @csrf
    <label>    
        Name:
        <input type="text" name="name" value="{{ $course->name }}">
    </label>

    <label>    
        Description:
        <textarea name="description">{!! $course->description !!}</textarea>
    </label>

    <button type="submit">Aanpassen</button>
</form>
@endsection
```

Stap 2: Routes aanmaken. Zoals je hieronder kan zien maak ik zowel een `get` als `post` route aan. Elk verwijzen ze naar een andere method binnen de CourseConroller.

```
Route::get('/course/{id}/edit', [CourseController::class, 'edit']);
Route::post('/course/{id}/edit', [CourseController::class, 'save']);
```

Stap 3: De methods aanmaken in de `CourseController` class.

```
public function edit($id) {
    $course = Course::findOrFail($id);

    return view('course.edit', [
        'course' => $course
    ]);
}

public function save(Request $request, $id) {
    $course = Course::findOrFail($id);

    //Eventueel extra server side validatie toevoegen
    $course->name = $request->input('name');
    $course->description = $request->input('description');
    $success = $course->save();

    if($success) {    
        return redirect('/course/' . $course->id);   
    }
}
```

## Aanmaken

We zouden nu zowel de template als de methods kunnen dupliceren voor het aanmaken van een nieuw record. Maar zoals het een goede programmeur betaamt, zijn we wat 'lui', en willen we zoveel mogelijk hergebruiken. Het grootste verschil tussen aanpassen en editeren is dat we bij het aanpassen een course ophalen uit de database en bij het aanmaken een nieuwe leeg object gebruiken.

Eerst en vooral moeten we ervoor zorgen dat we nieuwe routes aanmaken `/course/create`. En dat we deze ook doorverwijzen naar de edit en save method.

>**Let hierbij op dat deze boven de routes staan van `/course/{id}` anders zal hij 'create' aanzien als een id dat doorgegeven moet worden naar de detail controller.**

```
Route::get('/course/create', [CourseController::class, 'edit']);
Route::post('/course/create', [CourseController::class, 'save']);
```

Als je dit gaat testen zal je zien dat dit de foutmelding `Too few arguments to function` zal genereren. Dit kunnen we oplossen door een standaard waarde te geven aan de `$id` bij de method edit. Daarbij moeten we dan ook controleren op deze `$id`. Indien deze niet is meegegeven dient er een nieuw object te worden aangemaakt van die class.

```
public function edit($id = null) {
    $course = ($id) ? Course::findOrFail($id) : new Course();

    ...
}

public function save(Request $request, $id = null) {
    $course = ($id) ? Course::findOrFail($id) : new Course();

    ...
}
```

Je kan er nu ook voor zorgen dat er, bij de creatie van een course, een duidelijkere tekst staat bij de titel (*'Create course'*) en submit knop (*'Add course'*). 

Gebruik hiervoor dezelfde verkorte schrijfwijze voor een if/else statement.

```
<h1>{{ ($course->id) ? 'Edit course' : 'Create course' }}</h1>
```

Deze labels staan nu standaard steeds in het Engels, je kan ervoor zorgen dat deze labels afhankelijk bv van de voorkeuren van de bezoeker aangepast worden. Dit gebeurd adhv localisatie. (Zie 9_Localisation.md)

## Form validatie

Naast het beveiligen tegen hacking moeten we er ook steeds voor zorgen dat onze database op een correcte manier en met geldige data wordt ingevuld.

Dit moet zowel client- als serverside gevalideerd worden om de gebruiksvriedelijkheid (UX) van onze applicatie te optimaliseren.

Clientside zal dit gebeuren door enerzijds de juiste input-types. Bijvoorbeeld `<input type="email">` voor een e-mail adres. of dat er een `required` attribuut wordt meegegeven. Of het aantal karaketers beperken via het `maxlength` attribuut. Daarenboven kan je ook validatie doen via JavaScript voordat deze doorgestuurd wordt naar de server. 

Daarnaast is er niets zo vervelend als een database met bijvoorbeeld telefoonnummers waarbij 10 verschillende notaties worden aangenomen. (Met of zonder landcode, geschreven als +32 of 0032, de ene met spaties de andere met dots en nog andere met een slash tussen.) Meestal kies je voor een bepaalde notatie en wil je dat dit consistent is. Echter zal de gebruiker dat niet standaard doen

Of kan je een input mask te plaatsen op een invulveld, om de gebruiker te begeleiden in het invullen van een formulier. Bv bij rijksregister nummer `data-mask="99.99.99-999.99"`. Dit zorgt er voor dat alle gebruiker steeds in dezelfde vorm het rijksregister nummer zullen ingeven. Dit kan echter nog niet via standaar HTML en moet je dus een JavaScript library toevoegen.

Eens alles door de front-end op een correcte manier werd gevalideerd zal het formulier (via de POST) doorgestuurd worden naar de server. Nu is het aan onze controller om de data te valideren.

```
<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
class CourseController extends Controller
{
    public function save(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'required',
        ]);
 
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
 
        // Retrieve the validated input...
        $validated = $validator->validated();
 
        ...
    }
}
```

[Een volledig overzicht van Form validation.](https://laravel.com/docs/9.x/validation)
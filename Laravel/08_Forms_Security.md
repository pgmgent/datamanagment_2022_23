# Editeer formulieren en beveiliging

We kunnen nu ook templates maken waarin formulier voorkomen. We gaan er vanuit gaan dat, indien we gegevens willen ophalen, we best de GET methode gebruiken. En als we gegevens naar de database willen sturen de POST van toepassing is. Uiteraard zijn er steeds uitzonderingen op deze regel. Hieronder gaan we verder in op het versturen van gegevens die in de database zullen worden opgeslagen en dus de POST methode zal gebruikt worden.

## CSRF: Cross Site Request Forgery

Om je te wapenen tegen CSRF heeft Laravel een middleware voorzien om de request te controleren op de oorsprong van de request.

Bij het aanmaken van een formulier moet je dan wel een include doen via `@csrf`. Dit zal een soort sessie ID meegeven als hidden input in je formulier. Hierop zal Laravel dan controleren of de request wel degelijk van je eigen website komt en niet van een externe (fishing) website.

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
<h1>Edit Project</h1>
<form method="POST">
    @csrf
    <label>    
        Name:
        <input type="text" name="name" value="{{ $project->name }}">
    </label>

    <label>    
        Description:
        <textarea name="description">{!! $project->description !!}</textarea>
    </label>

    <button type="submit">Aanpassen</button>
</form>
@endsection
```

### Stap 2: Routes aanmaken. 

Zoals je hieronder kan zien maak ik zowel een `get` als `post` route aan. Elk verwijzen ze naar een andere method binnen de ProjectConroller.

```
Route::get('/project/{id}/edit', [ProjectController::class, 'edit']);
Route::post('/project/{id}/edit', [ProjectController::class, 'save']);
```

### Stap 3: De methods aanmaken 

Maak onderstaande methods aan in de `ProjectController` class. Pas de waardes aan van je object en gebruik de `save()` method, van ons ORM, om de aanpassingen op te slaan in de database.

```
public function edit($id) {
    $project = Project::findOrFail($id);

    return view('project.edit', [
        'project' => $project
    ]);
}

public function save(Request $request, $id) {
    $project = Project::findOrFail($id);

    //Eventueel extra server side validatie toevoegen
    $project->name = $request->input('name');
    $project->description = $request->input('description');
    $success = $project->save();

    if($success) {    
        return redirect('/project/' . $project->id);   
    }
}
```

## Aanmaken 

We zouden nu zowel de template als de methods kunnen dupliceren voor het aanmaken van een nieuw record. Maar zoals het een goede programmeur betaamt, zijn we wat 'lui', en willen we zoveel mogelijk code hergebruiken. Het grootste verschil tussen aanpassen en editeren is dat we bij het aanpassen, eerst een project ophalen uit de database en bij het aanmaken, een nieuw leeg object initialiseren.

Eerst en vooral moeten we ervoor zorgen dat we nieuwe routes aanmaken `/project/create`. En dat we deze ook doorverwijzen naar de edit en save methods van de controller.

>**Let hierbij op dat deze boven de routes staan van `/project/{id}` anders zal hij 'create' aanzien als een id dat doorgegeven moet worden naar de detail controller.**

```
Route::get('/project/create', [ProjectController::class, 'edit']);
Route::post('/project/create', [ProjectController::class, 'save']);
```

Als je dit gaat testen zal je zien dat dit de foutmelding `Too few arguments to function` zal genereren. Dit kunnen we oplossen door een standaard waarde te geven aan de `$id` parameter bij de edit method. Daarna moeten we dan ook controleren op deze `$id`. Indien deze niet is meegegeven dient er een nieuw object te worden aangemaakt van die class.

```
public function edit($id = null) {
    $project = ($id) ? Project::findOrFail($id) : new Project();

    ...
}

public function save(Request $request, $id = null) {
    $project = ($id) ? Project::findOrFail($id) : new Project();

    ...
}
```

Je kan er nu ook voor zorgen dat er, bij de creatie van een project, een duidelijkere tekst staat bij de titel (*'Create project'*) en submit knop (*'Add project'*). 

Gebruik hiervoor dezelfde verkorte schrijfwijze voor een if-then-else statement.

```
<h1>{{ ($project->id) ? 'Edit project' : 'Create project' }}</h1>
```

Deze labels staan nu steeds in het Engels, je kan er voor zorgen dat deze labels afhankelijk van de taalvoorkeur van de bezoeker aangepast worden. Dit gebeurt adhv lokalisatie. (Zie 9_Localisation.md)

## Form validatie

Naast het beveiligen tegen hacking moeten we er ook steeds voor zorgen dat onze database op een correcte manier en met geldige data wordt ingevuld.

Dit moet zowel client- als serverside gevalideerd worden om de gebruiksvriedelijkheid (UX) van onze applicatie te optimaliseren.

Clientside zal dit gebeuren door enerzijds de juiste input-types. Bijvoorbeeld `<input type="email">` voor een e-mail adres. En dat er een `required` attribuut wordt meegegeven indien de gebruiker verplicht het veld moet invullen. Of het aantal karakters beperken via het `maxlength` attribuut. Daarenboven kan je ook validatie doen via JavaScript vooraleer deze doorgestuurd wordt naar de server. 

Daarnaast is er niets zo vervelend als een database met bijvoorbeeld telefoonnummers waarbij 10 verschillende notaties worden aangenomen door gebruikers. (Met of zonder landcode, geschreven als +32 of 0032, de ene met spaties de andere met dots en nog andere met een slash tussenin.) Meestal kies je voor een bepaalde notatie en wil je dat dit consistent is voor alle records. Echter zal de gebruiker dat niet standaard doen.

Een oplossing hiervoor is het gebruik van een mask, om de gebruiker te begeleiden in het invullen van een formulier. Bv bij rijksregister nummer `data-mask="99.99.99-999.99"`. Dit zorgt er voor dat alle gebruiker steeds in dezelfde vorm het rijksregister nummer zullen ingeven. Dit kan echter nog niet via standaard HTML en moet je een JavaScript library toevoegen.

Eens alles door de front-end op een correcte manier werd gevalideerd zal het formulier (via de POST) doorgestuurd worden naar de server. Nu is het aan onze controller om de data te valideren.

```
<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
class ProjectController extends Controller
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

## Een-op-veel relatie

Indien er een een-op-veel relatie ligt tussen verschillende tabellen. Is het niet zo moeilijk om deze relatie tot stand te brengen in de database. We moeten enkel de primary key (PK) van de andere tabel opslaan als foreign key (FK) in de huidige tabel.

Meestal zal je hiervoor gebruik maken in je formulier van een `<select>` input.

```
<label>    
    Customer:
    <select name="customer_id">
        <option value="">{{ __('Select customer...')__ }}</option>
    @foreach($customers as $customer)
        <option value="{{ $customer->id }}" {{ ($project->customer_id == $customer->id) ? 'selected' : '' }}>{{ $customer->name }}</option>
    @endforeach
    </select>
</label>
```

## Veel-op-veel relatie

Bij een veel op veel relatie kan je ook een `select` gebruiken met het attribuut `multiple`. Maar dit is niet zo gebruiksvriendelijk. Een betere optie is om checkboxen te voorzien. 

```
<p>
Users:
@foreach($users as $user)
    @php $is_selected = ($project->users->contains('id', $user->id)) ? 'checked' : ''; @endphp
    <label><input type="checkbox" name="users[]" value="{{ $user->id }}" {{ $is_selected }}> {{ $user->name }}</label>
@endforeach
</p>
```

Merk op dat de er vierkante haakjes staan in de name van de checkbox. De waardes van de aangevinkte checkboxes zullen als array verstuurd worden naar de server en kunnen opgehaald worden aan de hand van de key `users` (dus zonder vierkante haakjes).

> Zijn er te veel records om allemaal een checkbox van te maken. Dan kan je ook een JavaScript library installeren dat een autocomplete select maakt waarbij je meerdere waardes / tags kan opgeven. Deze worden dan aangevuld via AJAX en een API binnen je applicatie. 
[Voorbeeld JS libraries via GitHub](https://github.com/topics/select-multiple?l=javascript&o=desc&s=) 

### Sync veel-op-veel

Hieronder zie je hoe je de synchronisatie van de tussen-tabel moet doen. Dit doe je aan de hand van de method `sync`. Nieuwe id's zullen toegevoegd worden, ontbrekende zullen verwijderd worden.

> Let wel op dat dit, bij nieuwe projecten, gebeurt nadat je het project hebt opgeslagen. Anders kan de relatie niet gemaakt worden omdat de `$project->id` nog niet toegekend is.

```
public function save(Request $request, $id = null) {
    ...

    $success = $project->save();

    //Veel-op-veel relatie synchroniseren
    $project->users()->sync($request->input('users'));
    
    ... 
}
```
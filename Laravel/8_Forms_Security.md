# Forms and Security

We kunnen nu ook templates maken waarin formulier voorkomen. We gaan ervanuit gaan dat de indien we gegevens willen ophalen we de GET methode gebruiken. Als we gegevens naar de database willen sturen de POST gebruiken. Uiteraard zijn er steeds uitzonderingen op deze regel.

## CSRF: Cross Site Redirect Forgery

Om je te wapenen tegen CSRF heeft Laravel een middleware voorzien om de request te controleren hierop.

Bij het aanmaken van een formulier moet je dan wel een include doen via `@csrf`. Dit zal een soort sessie ID meegeven als hidden field in je formulier. Hierop zal Laravel dan controleren of de request weldegelijk van je eigen website komt en niet van een externe fishing website.

```
<form method="POST">
    @csrf
</form>
```

## Editeren

Stap 1: Maak een template aan met een formulier om je content aan te passen. 

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

public function save($id, Request $request) {
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

TBC
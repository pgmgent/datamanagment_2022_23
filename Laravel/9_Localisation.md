# Lokalisatie, vertalen van de gebruikersinterface

Bij Laravel kan je ervoor zorgen de volledige interface vertaald wordt. Dit gebeurt aan de hand van de `Localisation` feature.

Indien je niet meteen de bedoeling hebt om te werken met lokalisatie is het toch aangeraden om labels meteen mee te geven op de correcte manier. Zodanig dat je in de toekomst, wanneer je toch de interface wil vertalen je dit niet overal moet doen. Dit bespaart je veel werk nadien.

De lokalisatie van labels gebeurt aan de hand van de dubbele underscore `__` helper. Hierin geef je dan de parameter mee die opgezocht moet worden in de localisation-file (JSON). Indien er geen lokalisatie beschikbaar is, dan zal standaard de tekst geplaatst worden die werd meegegeven als parameter.

De labels op onze edit course pagina passen we dus best als volgt.

```
<h1>{{ ($course->id) ? __('Edit course') : __('Create course') }}</h1>
```

Indien je dan een lokalisatie bestand `lang/nl.json` aanmaakt met hierin:

```
{
    "Edit course": "Vak aanpassen",
    "Create course": "Vak aanmaken"
}
```

Dan kan je eenvoudig je interface vertalen:

```
use Illuminate\Support\Facades\App;
 
App::setLocale('nl');
```

[Lees meer over Lokalisatie](https://laravel.com/docs/9.x/localization)


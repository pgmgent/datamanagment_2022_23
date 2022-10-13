# File Storage

In een applicatie zullen we ook meerder bestanden willen hosten. Dit kunnen afbeeldingen, video's of andere documenten zijn.

In kleinere applicaties en websites zullen deze op dezelfde hosting staan als de website zelf. Maar bij grotere applicaties waarbij veel afbeeldingen of video's geüpload worden door een gebruiker. Dan kan het interessant zijn om deze te hosten op een aparte hosting waarbij je bijvoorbeeld niet betaald voor diskspace maar wel voor bandbreedte. Een voorbeeld hiervan is Amazon S3.

## Link folder

Laravel geeft ons de mogelijkheid om eenvoudig te switchen tussen deze technieken aan de hand van de `config/storage.php`. Hierin staat reeds standaard gedefinieerd dat onze `storage/app/public` gekoppeld zal worden met de folder `public/storage`.

Hiervoor moet een link gemaakt worden in de public folder naar de storage folder. Een link is een soort virtuele folder die doorverwijst naar de bron folder. Maak de link aan via onderstaande commando.

```
php artisan storage:link
```

Je zal nu merken dat er een folderlink is toegevoegd aan je public folder.

## Asset ophalen

Vanaf nu kan je in de `storage/app/public` bestanden plaatsen. Bijvoorbeeld `images/afbeelding.jpg`.

In je views kan je deze dan oproepen op onderstaande manier.

```
<img src="{{ asset('storage/images/afbeelding.jpg') }}">
```

## Assets opladen


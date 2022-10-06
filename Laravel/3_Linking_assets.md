# Linking styles and scripts

De scripts en styles die je wenst te gebruiken moeten steeds in de `public` folder staan.

Je kan dit doen door je files rechtsreeks in de `public/css/` te plaasten. Of je kan gebruik maken via Laravel Mix (Webpack). Dit is een node package die styles en scripts kan bundelen, minifien en plaatsen op de juiste locatie.

Hoe dan ook moet je vanuit je templates of layout linken naar je css op onderstaande manier.
```
<link rel="stylesheet" href="{{ asset('css/style.css'); }} ">
```

## Vite gebruiken

Standaard gebruikt Laravel Vite voor asset bundeling en compiling. Installeer eerst de node packages.

```
npm install
```

Pas nadien de `vite.config.js` aan in de root van je project. Om nadien de build uit te voeren.

```
npm run build
```

Je zal zien dat vite ook een versienummer geeft aan de css. Om te linken vanuit je html moet je onderstaande code gebruiken.
```
<head>
    ...
    @vite(['resources/css/app.css'])
</head>
```

Het is natuurlijk wel vervelend om, na ieder aanpassing in CSS of JavaScript, dit commando te moeten uitvoeren. Vandaar dat je ook een watch kan starten. Voeg hiervoor een watch script toe aan `package.json`

```
"scripts": {
    "dev": "vite",
    "build": "vite build",
    "watch": "vite build --watch"
},
```

Nadien kan je de watch starten.

```
npm run watch
```

## Webpack gebruiken

Installeer de package `laravel-mix` via `npm`. Indien er nog geen npm aanwezig is in het project moet je eerst `npm init` doen.

```
npm install laravel-mix --save-dev
```

Maak nu het bestand `webpack.mix.js` aan in de root van je project.

Om een build te doen van je css kan je onderstaande script toevoegen aan het javascript bestand.

```
let mix = require('laravel-mix');

mix.postCss('resources/css/app.css', 'public/css');
mix.minify('public/css/app.css');
```

Run het script met onderstaande commando in je CLI. Je zal zien dat in de public folder nu 2 bestanden zijn toegevoegd aan je css folder `app.css` en `app.min.css`. 

```
npx mix
```

Je merkt wellicht op dat de minified versie dezelfde is. Dit komt doordat hij in development de minify niet uitvoert. Dit kan je forceren door `--production` mee te geven met het commando.

```
npx mix --production
```

Het is natuurlijk wel vervelend om, na ieder aanpassing in CSS of JavaScript, dit commando te moeten uitvoeren. Vandaar dat je ook een watch kan starten. Deze zal bij iedere aanpassing het script uitvoeren.

```
npx mix watch
```

### Sass / Scss en mix

Wens je gebruik te maken van Sass of Scss dan zal mix ook deze bestanden compileren naar een css bestand.

Hiervoor hebben we de sass compiler package nodig:

```
npm install sass-loader@^12.1.0 sass resolve-url-loader@^5.0.0 --save-dev --legacy-peer-deps
```

En moeten we onderstaande regel toevoegen aan `webpack.mix.js`.
**Let wel:** je moet de watch opnieuw starten bij aanpassingen aan `webpack.mix.js` 

```
mix.sass('resources/scss/style.scss', 'public/css');
```


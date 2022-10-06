# Linking styles and scripts

De scripts en styles die je wenst te gebruiken moeten steeds in de `public` folder staan.

Je kan dit doen door je files rechtsreeks in de `public/css/` te plaasten. Of je kan gebruik maken via Laravel Mix. Dit is een node package die styles en scripts kan bundelen, minifien en plaatsen op de juiste locatie.

Hoe dan ook moet je vanuit je templates of layout linken naar je css op onderstaande manier.
```
<link rel="stylesheet" href="{{ asset('css/style.css'); }} ">
```

## Mix gebruiken


...

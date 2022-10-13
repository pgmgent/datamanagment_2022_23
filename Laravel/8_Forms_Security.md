# Forms and Security

We kunnen nu ook templates maken waarin formulier voorkomen. We gaan ervanuit gaan dat de indien we gegevens willen ophalen we de GET methode gebruiken. Als we gegevens naar de database willen sturen de POST gebruiken. Uiteraard zijn er steeds uitzonderingen op deze regel.

## Form



## CSRF: Cross Site Redirect Forgery

Om je te wapenen tegen CSRF heeft Laravel een middleware voorzien om de request te controleren hierop.

Bij het aanmaken van een formulier moet je dan wel een include doen via `@csrf`. Dit zal een soort sessie ID meegeven als hidden field in je formulier. Hierop zal Laravel dan controleren of de request weldegelijk van je eigen website komt en niet van een externe fishing website.

```
<form method="POST">
    @csrf
</form>
```
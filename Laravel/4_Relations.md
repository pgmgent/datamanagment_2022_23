# Relaties tussen tabellen

## One-to-Many

In je database zullen er ook tabellen zijn waartussen relaties bestaan. In het voorbeeld van projecten kan dit een klant zijn.

Eerst zullen we een migration moeten maken waarbij we de link moeten leggen tussen 2 tabellen. Let wel dat beide tabellen reeds bestaan of dat de 2e tabel reeds aangemaakt is voor je de relatie legt. Maak dus een nieuwe migration file aan met onderstaande code.

```
Schema::create('customers', function (Blueprint $table) {
    $table->id();
    $table->string('name', 150);
    $table->timestamps();
});

Schema::table('projects', function (Blueprint $table) {
    $table->foreignId('customer_id');
});
```

Maak ondertussen ook een model voor customers aan (zie Introductie.md)

Dan kunnen we de relatie leggen tussen beide models op onderstaande manier.

```
class Project extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
```

Deze method kan je dan in je controller of views aanroepen als property.

```
    $project = Project::find($id);
    echo $project->customer->name;
```

Bij customers kunnen we dan de relatie leggen met projects. Dit gebeurt aan de hand van de method `hasMany`. Want een klant kan meerdere projecten hebben.

```
<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Customer extends Model
{
    /**
     * Get the project from customer.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
``` 

```
    $customer = Customer::find($id);
    foreach($customer->projects as $project) {
        echo $project->name . ', ';
    }
```

## Many-to-many

Als we een veel op veel relatie wensen te realiseren moeten we eerst een tussentabel of pivot table aanmaken via de migrations.

Bijvoorbeeld de tussentabel `project_user`. Want 1 project kan door meerdere users uitgevoerd worden en 1 user kan meerdere projecten hebben.

```
Schema::create('project_user', function (Blueprint $table) {
    $table->foreignId('user_id');
    $table->foreignId('project_id');
    $table->primary(['user_id', 'project_id']);
});
```

Daarna kan je bij beide Models de relatie aanmaken zoals hieronder aangegeven.

```
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class User extends Model
{
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
```

```
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Projects extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
```

## Relatie doorheen een andere tabel

Indien je 3 bestaande tabellen met bijhorende models hebt. Waartussen telkens een een-op-veel relatie ligt. Bijvoorbeeld: Motorcycles -> Types -> Brands.

Waarbij 1 brand meerdere types heeft en 1 type meerdere motorcycles bevat. Dan kan je een relatie leggen van Motorcycle naar Brand, doorheen de Types tabel.

```
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Motorcycle extends Model
{
    public function brand()
    {
        return $this->hasOneThrough(Brand::class, Type::class);
    }
}
```

Het omgekeerde kan je ook doen met `hasManyThrough`. Dus bijvoorbeeld van Brand naar Motorcycles.

```
<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Brand extends Model
{
    public function motorcycles()
    {
        return $this->hasManyThrough(Motorcycle::class, Type::class);
    }
}
```
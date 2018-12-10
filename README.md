# Service Repository resource generator

This repo is for generating template files for the Service Repository pattern.


**Usage**

Resource names should be provided in singular. Controller names will be converted to plural.
```php
php artisan resources:create Car
```

This will create a Controller, Request, Resource, Model, Service and Repository.

The folder structure will be:

    ├── App                   
        ├── Http    
            ├── Controllers
            ├── Requests
                ├── Car
            ├── Resources 
                ├── Car              
        ├── Models
        ├── Repositories                     
        ├── Services                    

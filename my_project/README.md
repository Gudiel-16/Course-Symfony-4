
### Estructura de carpetas

* config:
    * routes `->` dev `->` .yml
        * Son anotaciones para poder acceder a los controladores
    * packages: tienen configuracion del sistema
        * `cache.yaml`: apunta a nuestra carpeta var del sistema
        * `doctrine.yaml`: ORM que usa symfony para manejar bases de datos
        * `framework.yaml`: van a ir confugraciones del sistema
        * `security.yaml`: va administrar las rutas accesibles a nuestro sistema
        * `mailer.yaml`: gestor de emails que tiene symfony por defecto
        * `translation.yml`: manejar traducciones
        * `twig`: manera en que symfony manaje los template y archivos html con css y php.
* public: todos los archivos publicos, como hojas de estilo, js, img.
* src: tendra los controladores, entidades, repositorios, formularios.
* templates: se manejan con twig.
* tests: pruebas de proyecto
* translations: traducciones del proyecto.
* var: almacena toda la cache y los log.
* vendor: contiene todo lo que descargamos.

### Referencias

* https://symfony.com/bundles/SymfonyMakerBundle/current/index.html
* https://twig.symfony.com/doc/
* https://symfony.com/doc/current/doctrine.html
* https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/basic-mapping.html
* https://www.doctrine-project.org/projects/doctrine-orm/en/latest/reference/dql-doctrine-query-language.html
* https://symfony.com/doc/current/forms.html
* https://symfony.com/doc/current/reference/forms/types.html
* https://symfony.com/doc/current/forms.html
* https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.rst
* https://ourcodeworld.com/articles/read/91/how-to-register-an-user-in-a-custom-controller-with-fosuserbundle-in-symfony#google_vignette

### Comandos

* Crear proyecto:

```
composer create-project symfony/website-skeleton:"^4.4" my_project_directory
```

* Crear controlador

```
php bin/console make:controller
```

* Crear base de datos
    * Pide nombre de la db

```
php bin/console doctrine:database:create
```

* Crear entidad (tabla)
    * Pide nombre de la entidad

```
php bin/console make:entity
```

* Crear migracion:

```
//  compara las migraciones y luego la ejecuta (guarda un registro)
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate

// otra forma: forza el cambio
php bin/console doctrine:schema:update --force
```

* Crear formulario:

```
php bin/console make:form
```
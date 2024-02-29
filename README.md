## About Laravel

Lola is a cli that boosts your . Built on top off [Laravel-Zero](https://laravel-zero.com)

## Features
- [Commands](#commands)
- [Archetictures](#archetictures)

## Commands

You can build you own custom commands in lola that is basically a list of commands that you want to a shortcut for it

### Adding Commands

```shell
lola cmd:add "install filamentphp in laravel project"

 Enter the command that you want to add (if you have finished inserting your commands type `exit`):

>>  composer require filament/filament -W

Enter the command that you want to add (if you have finished inserting your commands type `exit`):

>>  php artisan filament:install --panels

Enter the command that you want to add (if you have finished inserting your commands type `exit`):

>> exit

added a new command
```

### Executing Commands

and now you can execute this command:

```shell
lola cmd:exec 

the name of the command that you are searching for:

[install-filamentphp-in-laravel-project] install filamentphp in laravel project

>> install-filamentphp-in-laravel-project
```

### Exporting Commands

```shell
lola cmd:export

the name of the command that you want to export:

[install-filamentphp-in-laravel-project] install filamentphp in laravel project

>> install-filamentphp-in-laravel-project
```

this command will generate a json file called **lola-commands.json**

### Deleting Commands

```shell
lola cmd:delete install-filamentphp-in-laravel-project
```

### Importing Commands

```shell
lola cmd:import

The path of json file (default is lola-commands.json):

>> lola-commands.json
```

## Archetictures

As a developer you always find things that you want always to use like some code for some configurations for payments or integrating with third party package. **Lola** makes that possible by saving a directory or maybe a file and we call this in **Lola** archeticture.

### Adding Archetictures

```shell
lola arch:add ".gitignore file for laravel"

 What is the path of your archeticture? (default is current path):
 >> .gitignore

added a new archeticture
```

### Publishing Archetictures

and now you can publish this Archeticture:

```shell
lola arch:publish 

the name of the archeticture that you are searching for:
  [gitignore-file-for-laravel] .gitignore file for laravel

>> gitignore-file-for-laravel
```

### Exporting Archetictures

```shell
lola arch:export

the name of the archeticture that you want to export:

[gitignore-file-for-laravel] .gitignore file for laravel

>> gitignore-file-for-laravel
```

this Archeticture will generate a json file called **lola-archetictures.json**

### Deleting Archetictures

```shell
lola arch:delete install-filamentphp-in-laravel-project
```

### Importing Archetictures

```shell
lola arch:import

The path of json file (default is lola-archetictures.json):

>> lola-archetictures.json
```

## License

Lola cli is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Notes:
- if there is no commands or archs then an exception will pop up so i need to check when there is no records
- need to find a way to print archeticture better
- add a command to show the commands and archeticture with details
- check if a file is already exsits then it should ask if the user like to overwrite it or not and add some option to overwrite 
- deploy it to github and ask Jawad and Afraa to try building it and contribute to it
- add some issues about features that you want to add in the future
- publish it in packagist and try composer require global loaidev6/lola
- write a convenient documentation 
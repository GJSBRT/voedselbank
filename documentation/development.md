# Development
Setting up a development enviroment is simple! This document will asume a Linux enviroment

## Requirements
- A recent MySQL database version
- Php 8.1 or newer
- Composer, any recent version will do
- NodeJS 16 or newer
- A web server, any will do as long as it supports Php

## Installing packages
First we will install our Composer packages. This can be done with the following command.
```sh
composer install
```

After we have installed our Composer packages we will install our NodeJS packages with the following command.
```sh
npm ci
```

## Setting up Laravel
Copy the example enviroment file and name it `.env`. You can do this with the following command. 
Also edit the applicable fields.
```sh
cp .env.example .env
```

Lets create our key with the following command
```sh
php artisan key:generate
```

Now we will run our migrations with the following command
```sh
php artisan migrate
```

## Building the application
Run vite to build the application. You can do so with the following command.
```sh
npm run build
```
You can use the following command to watch for changes while you develop
```sh
npm run dev
```

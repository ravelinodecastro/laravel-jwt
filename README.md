
## Cloning Repository

```
git clone https://github.com/ravelinodecastro/laravel-jwt.git
```
```
composer install
```
Create .env and copy all content from .env.exemple and paste there and then run:
```
php artisan key:generate
```
Create a database and set the conection values into .env
```
php artisan migrate
```
```
php artisan serve
```


## Starting with a new project
Assuming that you already have laravel installed with the database configuration, let start by installing JWT.
```
composer require tymon/jwt-auth
```
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```
```
php artisan jwt:secret
```
In config/auth.php set defaults guard to api and in guards api set drive to jwt

Now import JWTSubject in user model and some JWT methods in the user model.
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

       /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

}

```

Now, you need to create your controllers, routes and views. I'll skip this steps, you can check it on this repository.

You will need to create a middleware, in app/Http/Middleware

create AddToken.php
```
<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AddToken
{
    public function handle($request, Closure $next){
        $token = isset($_COOKIE["jwt_token"])?$_COOKIE["jwt_token"]:"";
        $request->headers->set("Authorization", "Bearer $token");
        $response = $next($request);
        return $response;
    }
}

```
And then import it on: app/Http/Kernel.php in $middleware this:  \App\Http\Middleware\AddToken::class,


In the front-end you only need to call something like this:
```
async function login(){
      await fetch('/api/login', {
          method: 'POST',
          headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
          },
          body: JSON.stringify({email: document.getElementById('email').value, password: document.getElementById('password').value})
      })
      .then((res)=>{ return res.json(); })
      .then((data)=>{
          document.cookie = `jwt_token= ${data.data.access_token}`;
          window.open("/", "_self");
      })
      .catch((error)=>{
          alert(error)
          console.error(error)
      })

  }
```

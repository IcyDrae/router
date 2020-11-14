
![license](https://img.shields.io/apm/l/vim-mode)
![release](https://img.shields.io/github/v/release/reardgjoni/router)
![last-commit](https://img.shields.io/github/last-commit/reardgjoni/router/master)
![packagist](https://img.shields.io/packagist/v/rgjoni/router)
# Router

This is a small routing package with a focus in separation of concern and logical modularity while keeping the implementation simple enough.

Starting from the need of having an HTTP router to use with my API's/projects, this project
quickly turned into a big learning experience on OO and the HTTP specification.

#### Table of contents

1. [Routing](#routing)<br>
2. [Static routing, workflow](#static-routing--usage-workflow)<br>
3. [Dynamic routing](#dynamic-routing)<br>
4. [Subrouting(groups)](#subrouting)<br>
5. [Handling](#handling)<br>
6. [HEAD requests](#head-requests)<br>
7. [Errors](#error-handling)<br>
8. [Acknowledgements](#acknowledgements)<br>
9. [Contributing](#contributing)<br>

#### Installation

``` composer require rgjoni/router ```

### Namespace

```php
Gjoni\Router
```

### Dependencies
none

### Prerequisites

- PHP 7.4 or greater
- an entry script with (preferably)bootstrapping capabilities(eg ``` index.php ```)
- a server configuration that points all requests to the entry script- example can be found
[here](config/myproject.conf)

### Supported methods
GET, HEAD, POST, PUT, PATCH, DELETE

### Routing

The library offers static and dynamic routing(using placeholders), as well as subrouting(route groups)
while also utilizing the ```Controller@method``` annotation and callbacks as the handler.

Controller mapping, custom 404 callbacks & json error handling are also included in the package.

#### Setting controller mapping

In the case of using the "Controller@method" annotation, there is a default namespace mapping set to ```App\Controllers```(of which there may only be one).
This can be overridden (as the first thing in the workflow) if you want to use your own.

```php
Router::setMap("MyAppNamespace\Controllers");
```

#### Static routing & usage workflow

```php

require_once dirname(__DIR__) . "/bootstrap.php";

use Gjoni\Router\Router;

Router::get("/about", $handler);

Router::run();
```

That's about it as far as the usage workflow goes-
call the Router with the desired method, path & handler and run it.

#### Homepage

```php
use Gjoni\Router\Router;

Router::get("/", $handler);
```

#### Dynamic routing

The arguments MUST be enclosed by curly brackets(```{arg}```) and match the following regular expression
```regexp
[a-zA-Z0-9\_]+
```

Usage:

```php
use Gjoni\Router\Router;

Router::get("/groups/{id}", $handler);

Router::run();
```


The argument name(in this case id) does not have to match the one in the handler.

Multiple arguments example:

```php
use Gjoni\Router\Router;

Router::get("/groups/{group_id}/meetups/{meetup_id}", $handler);
```

In the case of a route with multiple arguments, the argument names MUST NOT conflict one another,
this is because of how the parser works- it creates an array key for each argument(using its name).

#### Subrouting

When needed, bundling routes together for specific sections is easily implemented.

Subroutes MUST be declared using the group method and placed inside a
callback function- the below example will build the expected routes(eg. "/admin/settings").

The group name MUST be preceded by a slash(/), as well as the subroutes(in this example ``` settings ``` etc).

```php
use Gjoni\Router\Router;

Router::group("/admin", function() {
    Router::get("/", $handler);
    Router::get("/settings", $settingsHandler);
    Router::post("/settings/{id}", $updateHandler);
    Router::get("/users", $fetchUsersHandler);
});
```

Nested subrouting is also possible, the groups will then just append to each other(``` /group1/group2/route ```).

### Handling

As mentioned above, this router supports two types of handling:

- "Controller@method"

The first part of the handler(before @) MUST only include the controller name which in turn MUST
reside in namespace (see [namespace section](#setting-controller-mapping)).

```php
use Gjoni\Router\Router;

Router::group("/api", function() {
    Router::get("/auth/login", "AuthenticationController@login");
    Router::get("/user/{id}", "UserController@profile");
});

Router::run();
```

Depending on how you handled your namespace, an instance of the controller
will be created and the method will be called, with or without the arguments.

If no method was passed or a typo was made regarding the separator @ (eg ```AuthenticationControllerlogin```)
an exception is thrown and handled; another one is thrown if the class is not found in the namespace.

- anonymous functions

```php
use Gjoni\Router\Router;

Router::get("/me", function() {
    /** some cool user experience */
});

Router::post("/settings/{setting_name}", function($id) {
    /** some more magic */
});

Router::run();
```

### HEAD requests

As the [RFC2616](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.4) HTTP specification implies,
the router will redirect HEAD requests to identical, matching GET routes.


### Error handling

The errors are all handled and returned in JSON form and are the value of an ```error``` key

#### 404 - Not found

If for some reason the router cannot find a route in the declaration,
a default 404 error will be thrown:

```json
{"error":"Route not found."}
```

##### Custom 404's

If wanting to handle your own 404 errors, you may do so using the ```setNotFound``` method and a closure:

```php
use Gjoni\Router\Router;

Router::setNotFound(function() {
    /** special error handling */
});
```

#### 400 - Not allowed characters

If the URL matches the following pattern: ```[^-:\/a-zA-Z\d]```
an error "Not accepted characters in URL" is thrown.

#### 405 - Method not allowed

In the case of a route having been found but the request not corresponding, a MethodNotAllowedException is thrown:

```json
{"error":"Method not allowed."}
```

### Acknowledgements

As I started with this project I knew next to nothing about routing and how would I go about
solving this problem.

Only after having read the code of the following libraries,
thinking about the patterns at play there and experimenting myself was I able to understand
enough and find a solution that fit my needs and satisfied me.

- [nikic/fastroute](https://github.com/nikic/FastRoute) <br>
- [klein/klein.php](https://github.com/klein/klein.php) <br>
- [noahbuscher/macaw](https://github.com/noahbuscher/macaw) <br>
- [bramus/router](https://github.com/bramus/router)

### Contributing

Pull requests and issues are welcome, please refer to [CONTRIBUTING.md](docs/CONTRIBUTORS.md)

### License

[MIT](LICENSE)





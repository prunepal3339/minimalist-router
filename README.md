## A simple router in core PHP with support for dynamic paramter routing and named routing.

## Extension based templating engine
### It currently supports
* Basic Templating
* Sandbox PHP Templating (PHP maa available ko kuraa sabai available hunchha, but environment chaahi sandboxed hunxa, )
* HTML in PHP (PHX)  (sasta JSX)
* Advanced Templating (sasta Twig)

//templates/user.php
user.php
```
<?php foreach($users as $user): ?>
    echo $user->name;
<?php endforeach; ?> // PHP in HTML
```

```
return this->render('home/index.html.twig', [
    'users' => [
        ['id' => 1, 'name' => 'Nisha'],
    ]
 ]);
```

```
Advanced Templating Engine
 {% for user in users %}
 <p>{{user.name}}</p>
 {% endfor %}
```


```
Ability to write custom HTML tags in PHP --> HTMLInPHP i.e. PHX engine
```
## A simple router in core PHP with support for dynamic paramter routing and named routing.

## Extension based templating engine
### It currently supports
* Basic Templating
* Sandbox PHP Templating (PHP maa available ko kuraa sabai available hunchha, but environment chaahi sandboxed hunxa, )
* HTML in PHP (PHX)  (sasta JSX)
* Advanced Templating (sasta Twig)

//templates/user.php
user.php

<?php foreach($users as $user): ?>
    <?php if>
<?php foreach; ?> // PHP in HTML


==> output HTML

return this->render('home/index.html.twig', [
    'users' => [
        ['id' => 1, 'name' => 'Nischa'],
    ]
 ]);


 {% for user in users %}
 <p>{{user.name}}</p>
 {% endfor %} -- Advanced Templating Engine


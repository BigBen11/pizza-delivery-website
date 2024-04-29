<?php
header('Content-Type: text/html; charset=utf-8');
echo <<< HTML
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First-Page</title>
  </head>
  <body>
    <h1>First-Page Demo</h1>
    <hr>
HTML;

$data = [
    0 => [
        'firstname' => 'Thomas',
        'lastname'=> 'Hofmann',
        'age' => '34',
    ],
    1 => [
        'firstname' => 'Max',
        'lastname'=> 'Mustermann',
        'age' => '55',
    ],
    2 => [
      'firstname' => 'Lisa',
      'lastname'=> 'Müller',
      'age' => '35',
  ],
];

// echo "<pre>";
// var_dump($data);
// echo "</pre>";

/*
  Code Snippets für echo
  
  echo '<ul>';
  echo '</ul>';
  echo '<li>';
  echo '</li>';
  echo $item['firstname'];
  echo $item['lastname'];
  echo $item['age'];

*/

/*
  Code Snippets für HEREDOC

  $firstname = $item['firstname'];
  $lastname = $item['lastname'];
  $age = $item['age'];

  echo <<< HTML

  HTML;
*/

// HTML Code erzeugen, was ist zu tun?


echo '<ul>';
foreach($data as $item) {
    echo $item['firstname'];
    echo $item['lastname'];
    echo $item['age'];
    
    echo '<br></br>';
}
echo '</ul>';



echo <<< HTML
</body>
</html>
HTML;
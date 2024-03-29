<html>
<body>
<?php
  // this is the solution to questions 2.1 and 2.2

  // establish db connection
  try {
    // here i have added the host and port only to get it running on goanna:
    $pdo = new PDO('mysql:host=goanna.cs.rmit.edu.au;dbname=xbox;port=50000', 'xbox', 'secret');
    // this would be fine for the exam:
    // $pdo = new PDO('mysql:host=localhost;dbname=xbox', 'xbox', 'secret');
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
?>
<?php
  if (isset($_POST['submit']) && $_POST['submit'] == 'Submit'):
    // get the options from the database
    try {
      $query = 'SELECT * FROM game WHERE typeid = ? ORDER BY name';
      $statement = $pdo->prepare($query);
      $values = array($_POST['typeid']);
      $statement->execute($values);
      $games = $statement->fetchAll(PDO::FETCH_OBJ);
      // echo '<pre>';
      // print_r($games);
      // echo '</pre>';
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }

    foreach ($games as $game):
      echo $game->name . "<br/>";
    endforeach;
  else:
    // get the options from the database
    try {
      $query = 'SELECT * FROM type ORDER BY type';
      $statement = $pdo->prepare($query);
      $values = array();
      $statement->execute($values);
      $types = $statement->fetchAll(PDO::FETCH_OBJ);
      // echo '<pre>';
      // print_r($types);
      // echo '</pre>';
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
?>
<form action="xbox.php" method="POST">
<select name="typeid">
<?php foreach($types as $type): ?>
  <option value="<?php echo $type->id; ?>"><?php echo $type->type; ?></option>
<?php endforeach; ?>
</select>

<input type="submit" name="submit" value="Submit">
</form>
<?php
  endif;
?>

</body>
</html>

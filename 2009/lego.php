<html>
<body>
<?php
  // establish db connection
  try {
    // here i have added the host and port only to get it running on goanna:
    $pdo = new PDO('mysql:host=goanna.cs.rmit.edu.au;dbname=lego;port=50000', 'lego', 'secret');
    // this would be fine for the exam:
    // $pdo = new PDO('mysql:host=localhost;dbname=lego', 'lego', 'secret');
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
?>
<?php
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
<form action="getproducts.php" method="GET">
<select name="type">
  <option value="0">All</option>
<?php foreach($types as $type): ?>
  <option value="<?php echo $type->id; ?>"><?php echo $type->type; ?></option>
<?php endforeach; ?>
</select>
<br/>
Minimum price: <input type="text" name="min_price" value="0"/>
<br/>
Maximum price: <input type="text" name="max_price" value="1000"/>
<br/>
Minimum number of purchases: <input type="text" name="min_purchases" value="0"/>
<br/>

<input type="submit" name="submit" value="Submit">
</form>

</body>
</html>

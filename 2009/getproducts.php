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
    $values = array();
    $query = 'SELECT product.*, type.type AS type, purchase.quantity AS
quantity FROM product, purchase, type WHERE product.id =
purchase.productid AND product.type = type.id AND ';

    if ($_GET['type'] > 0) {
      $query .= 'type.id = ? AND ';
      $values[] = $_GET['type'];
    }
    // i've simplified the price check by only using dollars:
    $query .= 'dollars >= ? and dollars <= ? and quantity >= ?;';
    $values[] = $_GET['min_price'];
    $values[] = $_GET['max_price'];
    $values[] = $_GET['min_purchases'];

    $statement = $pdo->prepare($query);
    $statement->execute($values);
    $products = $statement->fetchAll(PDO::FETCH_OBJ);
    // echo '<pre>';
    // print_r($products);
    // echo '</pre>';
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
?>

<table>
<tr>
  <th>name</th>
  <th>type</th>
  <th>cost</th>
</tr>
<?php
  foreach ($products as $product):
?>
<tr>
  <td><?php echo $product->name; ?></td>
  <td><?php echo $product->type; ?></td>
  <td>$<?php echo $product->dollars; ?>.<?php echo $product->cents ?></td>
</tr>

<?php
  endforeach;
?>
</table>

</body>
</html>

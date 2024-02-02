<!doctype html>
<html>
  <header>
    <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
</header>
  <body>
    <div id="conteneur">
      <h1>Les équipes de National League</h1>    
      <table border= "1">
      <tr>
        <td>ID</td>
        <td>Club</td>
      </tr>
      
      <?php
        require('ctrl.php');
        $lst = getEquipes();
        $id = 0;
        foreach ($lst as $lst) {
          ?>
          <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $lst; ?></td>
          </tr>
          <?php
          $id = $id +1;
      }
      ?>
      </table>
    </div>
  </body>
</html>
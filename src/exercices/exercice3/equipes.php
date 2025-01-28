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
        $listeEquipe = getEquipes();
        for($lines = 0; $lines < count($listeEquipe); $lines++):
          echo "<tr>";
          echo "<td>" . $lines+1 . "</td>";
          echo "<td>" . $listeEquipe[$lines] . "</td>";
          echo "</tr>";
        endfor;
      ?>
      </table>
    </div>
  </body>
</html>
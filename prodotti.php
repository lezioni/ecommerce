<?php
include 'libs/db.php';
$db = creaConnessionePDO();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Corso DB SQL</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'include/header.php'; ?>
    <main>
      <div class="container-fluid">
        <div class="row banner-home">
          <div class="col-md-9">
            <h1>I nostri prodotti</h1>
          </div>
        </div>

        <table class="table">
          <thead>
          <tr>
            <th>Macrocategoria</th>
            <th>Categoria</th>
            <th>Nome</th>
            <th>Prezzo</th>
          </tr>
          </thead>
          <tbody>
          <?php

          $macrocategoria_id = $_GET['macrocategoria_id'] ?? 0;
          
          $stmt = $db->prepare('SELECT m.nome as macrocategoria, c.nome as categoria, p.* 
                                FROM prodotti p 
                                join categorie c on (p.categoria_id = c.id)
                                join macrocategorie m on (c.macrocategoria_id = m.id)
                                ORDER BY macrocategoria, categoria, p.nome');
          
          if ( $macrocategoria_id > 0 ) {
            $stmt = $db->prepare('SELECT m.nome as macrocategoria, c.nome as categoria, p.* 
            FROM prodotti p 
            join categorie c on (p.categoria_id = c.id)
            join macrocategorie m on (c.macrocategoria_id = m.id)
            where m.id = :macrocategoria_id
            ORDER BY macrocategoria, categoria, p.nome');
            $stmt->bindParam(':macrocategoria_id', $macrocategoria_id, PDO::PARAM_INT);

          }

          $stmt->execute();

          foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $prodotto) {
          ?>
            <tr>
              <td><?= $prodotto['macrocategoria'] ?></td>
              <td><?= $prodotto['categoria'] ?></td>
              <td><a href="prodotto.php?id=<?=$prodotto['id']?>"><?= $prodotto['nome'] ?></a></td>
              <td><?= $prodotto['prezzo'] ?> &euro;</td>
            </tr>
          <?php } ?>
          </tbody>
        </table>

      </div>
    </main>
    <?php include 'include/footer.php'; ?>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</html>

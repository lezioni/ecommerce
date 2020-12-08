<?php
include 'libs/db.php';

$db = creaConnessionePDO();

// lettura parametro da URL
$id = $_GET['id'];

/*
$stmt = $db->prepare('SELECT macrocategorie.nome as macrocategoria, categorie.nome as categoria, prodotti.* 
                      FROM prodotti, macrocategorie, categorie
                      WHERE prodotti.categoria_id = categorie.id
                      AND categorie.macrocategoria_id = macrocategorie.id
                      AND prodotti.id = :id');
*/

$stmt = $db->prepare('SELECT m.nome as macrocategoria, c.nome as categoria, p.* 
                      FROM prodotti p 
                      join categorie c on (p.categoria_id = c.id)
                      join macrocategorie m on (c.macrocategoria_id = m.id)
                      WHERE p.id = :id');
                      

// bind parametro alla query
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$prodotto = $stmt->fetch(PDO::FETCH_ASSOC);

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
      <div class="row">
        <div class="col-md-12">
          <h1><?= $prodotto['nome'] ?></h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h2><?= $prodotto['macrocategoria'] ?> &gt; <?= $prodotto['categoria'] ?></h2>
          <h3><?= $prodotto['descrizione'] ?></h3>
          <div>
            <strong>Prezzo</strong>: <?= $prodotto['prezzo'] ?>
          </div>
          <br>
          <div>
            <a href="#" class="btn btn-success">Acquista</a>
          </div>
        </div>
      </div>
    </main>
    <?php include 'include/footer.php'; ?>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
</html>

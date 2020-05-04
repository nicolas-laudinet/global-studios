<?php

//contient la fonction resize_crop_image
require('../lib/resize_crop_image.php');

/**
  * Ajoute un studio à la table studios
  *
  * @param {object} $data - La variable superglobale $_POST contenant les infos du formulaire
  * @param {PDO Object} $db - Un objet PDO connecté à la base de données
  */
function recordStudio($data, $db) {
  $statement = $db->prepare(
    "INSERT INTO studios (country_id, name, members, foundation, description, site, mail)
    VALUES (:country_id, :name, :members, :foundation, :description, :site, :mail)"
  );

 $statement->bindValue(':country_id', (int)$data['country']);
 $statement->bindValue(':name', $data['name']);
 $statement->bindValue(':members', $data['members']);
 $statement->bindValue(':foundation', (int)$data['foundation']);
 $statement->bindValue(':description', $data['description']);
 $statement->bindValue(':site', $data['website']);
 $statement->bindValue(':mail', $data['email']);

 $statement->execute();

 $id = $db->lastInsertId();
 return $id;
}


/**
  * Publie un travail d'un studio
  * en enregistrant les l'images et les infos correspondantes
  *
  * @param {Array} $work - Un tableau contenant toutes les information sur le travail à publier
  * @param {Integer} $studioId - L'id du studio correspondant au travail à publier
  * @param {PDO Object} $db - L'objet PDO de la base de données à peupler
  */
function recordWork($work, $studioId, $db) {
  //enregistrement de l'image et récuperation de son nom tel qu'enregistré dans le répertoire /images
  $imgPath = recordWorkImage($work['image']);
  //enregistrement des informations sur le travail
  recordWorkDatas($work, $studioId, $imgPath, $db);
}


/**
  * Enregistre l'image d'un travail d'un studio dans le repertoire /images
  *
  * @param {Array} $image - Un tableau contenant toutes les information l'image à enregistrer
  */
function recordWorkImage($image) {
  $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/images';
  $targetFile = preg_replace("/[^a-z0-9\_\-\.]/i", '', basename($image["name"]));
  $targetPath = $targetDir . '/' . $targetFile;

  resize_crop_image(1500, 1000, $image['tmp_name'], $targetPath);

  return $targetFile;
}

/**
  * Publie les informations sur le travail d'un studio en base (table "works")
  *
  * @param {Array} $image - Un tableau contenant toutes les information l'image à enregistrer
  * @param {Integer} $studioId - L'id du studio correspondant au travail à publier
  * @param {PDO Object} $db - L'objet PDO de la base de données à peupler
  */
function recordWorkDatas($work, $studioId, $imgPath, $db) {
  $statement = $db->prepare(
    "INSERT INTO works (studio_id, img_path, alt_text, title, description, featured)
    VALUES (:studio_id, :img_path, :alt_text, :title, :description, :featured)"
  );

  if(!isset($work['thumbnail'])) $work['thumbnail'] = 0;

  $statement->bindValue(':studio_id', $studioId);
  $statement->bindValue(':img_path', $imgPath);
  $statement->bindValue(':alt_text', $work['altText']);
  $statement->bindValue(':title', $work['workName']);
  $statement->bindValue(':description', $work['imageDescr']);
  $statement->bindValue(':featured', (int)$work['thumbnail']);

 $statement->execute();
}


/**
  * Tri les champs de $_POST et $_FILES et regroupe ceux faisant partie d'un groupe "Work"
  * Tous les champs d'un même "Work" sont regroupés dans un tableau, y compris les infos sur l'image
  * Chaque tableau de champs d'un "Work" est regroupé dans un tableau qui est retourné
  *
  * @param {object} $data - Un tableau regroupant les variables superglobales superglobale $_POST et $_FILES
  * @return {array} $works - Un tableau contenant tous les travaux envoyés
  */
function sortWorksData ($data) {

  $works = [];

  for($i = 0; $i < $data['worksCount']; $i++) {

    foreach($data as $key => $value) {
      //si on trouve le charctère "-" dans la clef,
      //on récupère la position du caractère "-"
      if (($hyphenPos = strpos($key, "-")) !== false) {
        //on récupère le nombre venant après le tiret
        $workNumber = substr($key, $hyphenPos + 1);
        //on récupère le nom de la clef sans le nombre
        $keyName = substr($key, 0, $hyphenPos);
        //si le nombre correspond à l'itération en cours
        if($workNumber == $i) {
          $works[$i][$keyName] = $value;
        }
      }
    }
  }

  return $works;
}

/**
  * Enregistre le message d'un utilisateur venant de la page Contact
  *
  * @param {object} $request - La variable superglobale $_POST contenant les données du formulaire
  *
  *
  */

function recordMessage($request, $db) {
  $statement = $db->prepare(
    "INSERT INTO messages (author, mail, body)
    VALUES (:author, :mail, :body)"
  );

  $statement->bindValue(':author', $request['name']);
  $statement->bindValue(':mail', $request['mail']);
  $statement->bindValue(':body', $request['body']);

  if($statement->execute()) {
    return true;
  } else {
    return false;
  }
}

?>

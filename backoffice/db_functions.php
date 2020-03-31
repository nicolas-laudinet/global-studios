<?php

/**
  * Tri les champs de la requête POST et regroupe ceux faisant partie d'un groupe "Work"
  * Tous les champs d'un même "Work" sont regroupés dans un tableau
  * Chaque tableau de champs d'un "Work" est regroupé dans un tableau qui est retourné
  *
  * @param {object} $data - Une variable superglobale $_POST
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
  * Ajoute un studio à la table studios
  * @param {object} $data - La variable superglobale $_POST contenant les infos du formulaire
  * @param {PDO Object} $db - Un objet PDO connecté à la base de données
  */
function addStudioToDb($data, $db) {
  $statement = $db->prepare(
    "INSERT INTO studios (country_id, name, members, foundation, description, site, mail)
    VALUES (:country_id, :name, :members, :foundation, :description, :site, :mail)"
  );

   $statement->bindValue(':country_id', (int)$data['country']);
   $statement->bindValue(':name', $data['name']);
   $statement->bindValue(':members', $data['members']);
   $statement->bindValue(':foundation', $data['foundation']);
   $statement->bindValue(':description', $data['description']);
   $statement->bindValue(':site', $data['website']);
   $statement->bindValue(':mail', $data['email']);

   $statement->execute();
}

?>

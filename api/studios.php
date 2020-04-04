<?php
header('Content-Type: application/json');

include('../db_connection.php');

if(isset($_GET['id']) && !empty($_GET['id'])) {

  $studio = fetchData($db, 'studios', $_GET['id']);
  $works = fetchData($db, 'works', $_GET['id'], 'studio_id');

  $sortedStudio = sortStudioData($studio, $works);
  $JSON = json_encode($sortedStudio, JSON_PRETTY_PRINT);

} else {

  $studios = fetchData($db, 'studios');
  $works = fetchData($db, 'works');

  $sortedStudios = sortStudioData($studios, $works);
  $JSON = json_encode($sortedStudios, JSON_PRETTY_PRINT);


}


echo($JSON);


/**
  * Execute une requête SQL allant chercher toutes les lignes d'une table, ou les lignes correspondantes si l'id est précisé.
  *
  * @param {PDO Object} $db - Un objet PDO connecté à la base de données
  * @param {String} $table - Le nom de la table à requêter
  * @param {Integer || String} $id (optional) - Un id ou autre valeur qu'on peut optionellement préciser pour affiner la requête
  * @param {String} $idKey (optional) - Le nom de la clé dont la valeur est précisée dans le paramètre $id, 'id' par défaut
  *
  * @return {Object} $studio - Un tableau contenant les informations d'un studio triées
  */
function fetchData($db, $table, $id = null, $idKey = 'id') {

  if($id) {
    $SQL_Query = "SELECT * FROM " . $table . " WHERE " . $table . "." . $idKey . " = :id";
    $statement = $db->prepare($SQL_Query);
    $statement->bindValue(':id', $id);

  } else {
    $SQL_Query = "SELECT * FROM " . $table;
    $statement = $db->prepare($SQL_Query);

  }

  $statement->execute();

  return $statement->fetchAll(PDO::FETCH_ASSOC);

}


/**
  * Tri les informations récupérées dans une requete à la base de données joignant les tables "studios" et "works"
  * Les informations concernant les travaux du studio sont poussées dans un tableau "works"
  *
  * @param {Array} $arrays - Un tableau contenant le resultat d'une requête joignant les tables "studios" et "works"
  * @return {Object} $studio - Un tableau contenant les informations d'un studio triées
  */
function sortStudioData($studios, $works) {
  $studiosArray = [];

  foreach($studios as $studio) {
    $worksArray = [];

    foreach($works as $work) {
      if($studio['id'] === $work['studio_id']) {
        $worksArray[] = $work;
      }
    }
    $studio['works'] = $worksArray;
    $studiosArray[] = $studio;
  }

  return $studiosArray;
}



/**
  * Tri les informations récupérées dans une requete à la base de données joignant les tables "studios" et "works"
  * Les informations concernant les travaux du studio sont poussées dans un tableau "works"
  *
  * @param {Array} $arrays - Un tableau contenant le resultat d'une requête joignant les tables "studios" et "works"
  * @return {Object} $studio - Un tableau contenant les informations d'un studio triées
  */
// function sortStudioData($arrays) {
//   $studio = [];
//   $worksArray = [];
//
//   foreach($arrays as $index => $array) {
//     $work = [];
//
//     foreach($array as $key => $value) {
//
//       if($key == 'name' ||
//          $key == 'members' ||
//          $key == 'foundation' ||
//          $key == 'site'  ||
//          $key == 'added_at' ||
//          $key == 'country_id' ||
//          $key == 'mail')
//       {
//
//         $studio[$key] = $value;
//
//       }  else {
//
//         $work[$key] = $value;
//
//       }
//     }
//
//     $worksArray[] = $work;
//
//   }
//   $studio['works'] = $worksArray;
//   return $studio;
// }


 ?>

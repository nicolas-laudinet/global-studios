<?php

//contient la variable $db
include('../db_connection.php');

include('db_functions.php');

if(!empty($_POST['delete-id'])) {
  $values = array('id' => $_POST['delete-id']);

  $statement = $db->prepare("DELETE FROM studios WHERE id = :id");
  $statement->execute($values);
  echo 'deleted';

  $statement = $db->prepare("DELETE FROM works WHERE studio_id = :id");
  $statement->execute($values);
}


//enregistrement des données envoyées pour mettre à jour le studio
if(!empty($_POST['studio-id'])) {

  $studioDatas = $_POST;

  updateStudio($_POST['studio-id'], $studioDatas, $db);

  if(!empty($_FILES)) {
    $studioDatas = array_merge($_POST, $_FILES);
  }

  $works = sortWorksData($studioDatas);

  foreach($works as $work) {
    updateWork($_POST['thumbnail'], $work, $_POST['studio-id'], $work['id'], $db);
  }
}

$studioExists = false;
// chargement du studio
if(isset($_GET['selected-studio-id'])) {
    $studio_json = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/api/studios.php?id=' . $_GET['selected-studio-id']);
    $studio = json_decode($studio_json);
    $studio = $studio[0];
    if(!empty($studio)) $studioExists = true;
}

//recupération de la liste des studios
$studios_json = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/api/studios.php');
$studiosList = json_decode($studios_json);

//chargement des pays
$contries_json = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . '/api/countries.php');
$countries = json_decode($contries_json);


 ?>


 <!DOCTYPE html>
 <html>
   <?php $pageTitle = 'Add Studio' ?>
   <?php include('bo_head.php') ?>

   <body>

     <div class="container">

       <?php include('./bo_menu.php'); ?>

       <!-- INFOS ABOUT THE STUDIO ------------------------------------------------------>
       <hr>
       <h2>Update a studio</h2>

       <form class="select-studio-form" action="/backoffice/update_studio.php" method="GET">
         <div class="row">
             <select class="select-studio" name="selected-studio-id">
               <?php foreach($studiosList as $oStudio) { ?>
                 <option <?php if(isset($_GET['selected-studio-id'])) echo $oStudio->id === $_GET['selected-studio-id'] ? 'selected' : ''; ?> value="<?= $oStudio->id ?>"><?= $oStudio->name ?></option>
               <?php } ?>
             </select>
             <input type="submit" name="" value="Select studio">
         </div>
       </form>

       <?php if($studioExists) { ?>

         <form method="POST" enctype="multipart/form-data">

           <input id="studioId" type="hidden" name="studio-id" value="<?= $studio->id ?>">

           <div class="row">

             <div class="form-group col-md-6">
               <label for="name">Studio Name</label>
               <input name="name" type="text" class="form-control" id="name" value="<?= $studio->name ?>">
             </div>

             <div class="form-group col-md-6">
               <label for="foundation">Foundation Year</label>
               <input name="foundation" type="number" class="form-control" id="foundation" value="<?= $studio->foundation ?>">
             </div>

           </div><!-- .row -->

           <div class="row">

             <div class="form-group col-md-6">
               <label for="email">Studio Email</label>
               <input name="email" type="email" class="form-control" id="email" value="<?= $studio->mail ?>">
             </div>

             <div class="form-group col-md-6">
               <label for="website">Studio Website</label>
               <input name="website" type="text" class="form-control" id="website" value="<?= $studio->site ?>">
             </div>

           </div><!-- .row -->

           <div class="row">

             <div class="form-group col-md-6">
               <label for="members">Studio Members</label>
               <input name="members" type="text" class="form-control" id="members" value="<?= $studio->members ?>">
             </div>

             <div class="form-group col-md-6">
               <label for="country">Country</label>
               <select name="country" class="form-control" id="country">

                 <!-- affiche la la liste des options dans le select à partir de la table countries -->


                 <?php foreach($countries as $country) { ?>
                   <?php $selected = false; ?>
                   <?php if ($country->id === $studio->country_id) $selected = true; ?>

                   <!-- l'option est selectionnée si elle correspond au pays du studio affiché -->
                   <option <?= $selected ? 'selected' : '' ?> value="<?= $country->id ?>"><?= $country->name ?></option>

                 <?php } ?>

               </select>
             </div>

           </div><!-- .row -->

           <div class="row">
             <div class="form-group col-md-12">
               <label for="description">Studio Description</label>
               <textarea name="description" class="form-control" id="description" rows="6"><?= $studio->description ?></textarea>
             </div>
           </div><!-- .row -->




           <!-- IMAGES & INFOS ABOUT THE STUDIO'S WORKS ---------------------------------------->
           <hr>
           <h2>Update a Work</h2>

           <?php foreach($studio->works as $index => $work) { ?>

             <div class="work">

               <button style="display:none" type="button" class="deleteWorkBtn close" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>

               <div class="row">

                 <div class="form-group col-md-6">
                   <label for="workName-<?= $index ?>">Work Name</label>
                   <input name="workName-<?= $index ?>" type="text" class="form-control" id="workName-<?= $index ?>" value="<?= $work->title ?>">
                 </div>

                 <div class="form-group col-md-6">
                   <label for="altText-<?= $index ?>">Image Alt Text</label>
                   <input name="altText-<?= $index ?>" type="text" class="form-control" id="altText-<?= $index ?>" value="<?= $work->alt_text ?>">
                 </div>

               </div><!-- .row -->

               <div class="row">

                 <div class="form-group col-md-6">
                   <label for="image-<?= $index ?>">Modify the project image</label>
                   <input name="image-<?= $index ?>" type="file" class="form-control-file" id="image-<?= $index ?>">
                   <img class="work-img" src="/images/<?= $work->img_path ?>">
                 </div>

                 <div class="form-radio col-md-6">
                   <label class="form-radio-label" for="thumbnail-<?= $index ?>">Select as the studio thumbnail image :</label>
                   <br>
                   <input name="thumbnail" type="radio" value="<?= $work->id ?>" id="thumbnail-<?= $index ?>" <?= $work->featured ? 'checked' : '' ?> >
                 </div>

               </div><!-- .row -->

               <div class="row">
                 <div class="form-group col-md-12">
                   <label for="imageDescr-<?= $index ?>">Work Description</label>
                   <textarea class="form-control" name="imageDescr-<?= $index ?>" id="imageDescr-<?= $index ?>" rows="6"><?= $work->description ?></textarea>
                 </div>
               </div><!-- .row -->

               <input type="hidden" name="id-<?= $index ?>" value="<?= $work->id ?>">

             </div><!-- .work -->

           <?php } ?>

           <div class="row">
             <button id="addWork" type="button" class="btn btn-secondary" name="addWork">Add Another Work</button>
           </div>

           <input id="worksCount" type="hidden" name="worksCount" value="1">

           <div class="row">
             <input type="submit" value="Modifier le studio" class="btn btn-primary btn-lg mx-auto">
           </div>

         </form>
         <div class="row">
           <form method="post">
             <input type="hidden" name="delete-id" value="<?= $studio->id ?>">
             <input class="btn btn-danger" type="submit" name="delete-studio" value="Delete studio">
           </form>
         </div>


    <?php } ?> <!-- if studio exists -->

     </div><!-- .container -->

   </body>
 </html>

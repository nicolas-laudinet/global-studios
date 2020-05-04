<?php

//contient la variable $db
include('../db_connection.php');

//contient sortWorksData() et $addStudioToDb
include('db_functions.php');


if(isset($_POST) && !empty($_POST) && isset($_FILES) && !empty($_FILES)) {

  $studioId = recordStudio($_POST, $db);

  $mergedArrays = array_merge($_POST, $_FILES);

  $works = sortWorksData($mergedArrays);

  foreach($works as $work) {
    recordWork($work, $studioId, $db);
  }
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add a Studio</title>
    <link rel="stylesheet" href="../lib/bootstrap.min.css">
    <link rel="stylesheet" href="backoffice.css">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <script defer type="text/javascript" src="../lib/jquery-3.4.1.min.js"></script>
    <script defer type="text/javascript" src="handle_work_forms.js"></script>
    <!-- <script defer type="text/javascript" src="send_form_data.js"></script> -->
  </head>

  <body>

    <div class="container">

      <header>
        <h1>HEADER</h1>
      </header>

      <!-- INFOS ABOUT THE STUDIO ------------------------------------------------------>
      <hr>
      <h2>Add a studio</h2>

      <form method="POST" enctype="multipart/form-data">

        <div class="row">

          <div class="form-group col-md-6">
            <label for="name">Studio Name</label>
            <input name="name" type="text" class="form-control" id="name">
          </div>

          <div class="form-group col-md-6">
            <label for="foundation">Foundation Year</label>
            <input name="foundation" type="number" class="form-control" id="foundation">
          </div>

        </div><!-- .row -->

        <div class="row">

          <div class="form-group col-md-6">
            <label for="email">Studio Email</label>
            <input name="email" type="email" class="form-control" id="email">
          </div>

          <div class="form-group col-md-6">
            <label for="website">Studio Website</label>
            <input name="website" type="text" class="form-control" id="website">
          </div>

        </div><!-- .row -->

        <div class="row">

          <div class="form-group col-md-6">
            <label for="members">Studio Members</label>
            <input name="members" type="text" class="form-control" id="members">
          </div>

          <div class="form-group col-md-6">
            <label for="country">Country</label>
            <select name="country" class="form-control" id="country">
              <option value="1">Italy</option>
              <option value="2">Spain</option>
              <option value="3">France</option>
              <option value="4">Germany</option>
              <option value="9">Japan</option>
            </select>
          </div>

        </div><!-- .row -->

        <div class="row">
          <div class="form-group col-md-12">
            <label for="description">Studio Description</label>
            <textarea name="description" class="form-control" id="description" rows="6"></textarea>
          </div>
        </div><!-- .row -->




        <!-- IMAGES & INFOS ABOUT THE STUDIO'S WORKS ---------------------------------------->
        <hr>
        <h2>Add a Work</h2>

        <div class="work">

          <button style="display:none" type="button" class="deleteWorkBtn close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

          <div class="row">

            <div class="form-group col-md-6">
              <label for="workName-0">Work Name</label>
              <input name="workName-0" type="text" class="form-control" id="workName-0">
            </div>

            <div class="form-group col-md-6">
              <label for="altText-0">Image Alt Text</label>
              <input name="altText-0" type="text" class="form-control" id="altText-0">
            </div>

          </div><!-- .row -->

          <div class="row">

            <div class="form-group col-md-6">
              <label for="image-0">Select the project image</label>
              <input name="image-0" type="file" class="form-control-file" id="image-0">
            </div>

            <div class="form-radio col-md-6">
              <label class="form-radio-label" for="thumbnail-0">Select as the studio thumbnail image :</label>
              <br>
              <input name="thumbnail-0" type="radio" value="1" id="thumbnail-0">
            </div>

          </div><!-- .row -->

          <div class="row">
            <div class="form-group col-md-12">
              <label for="imageDescr-0">Work Description</label>
              <textarea class="form-control" name="imageDescr-0" id="imageDescr-0" rows="6"></textarea>
            </div>
          </div><!-- .row -->

        </div><!-- .work -->

        <div class="row">
          <button id="addWork" type="button" class="btn btn-secondary" name="addWork">Add Another Work</button>
        </div>

        <input id="worksCount" type="hidden" name="worksCount" value="1">

        <div class="row">
          <input type="submit" value="Ajouter le studio" class="btn btn-primary btn-lg mx-auto">
        </div>

      </form>

    </div><!-- .container -->

  </body>
</html>

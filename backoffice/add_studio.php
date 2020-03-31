<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add a Studio</title>
    <link rel="stylesheet" href="../lib/bootstrap.min.css">
    <link rel="stylesheet" href="backoffice.css">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <script defer type="text/javascript" src="../lib/jquery-3.4.1.min.js"></script>
    <script defer type="text/javascript" src="backoffice.js">

    </script>
  </head>

  <body>

    <header>
      <h1>HEADER</h1>
    </header>



    <div class="container">

      <!-- INFOS ABOUT THE STUDIO ------------------------------------------------------>
      <hr>
      <h2>Add a studio</h2>

      <form method="post">

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
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>

        </div><!-- .row -->

        <div class="row">
          <div class="form-group col-md-12">
            <label for="description">Studio Description</label>
            <textarea class="form-control" id="description" rows="6"></textarea>
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
              <label for="workName">Work Name</label>
              <input name="workName" type="text" class="form-control" id="workName">
            </div>

            <div class="form-group col-md-6">
              <label for="altText">Image Alt Text</label>
              <input name="altText" type="text" class="form-control" id="altText">
            </div>

          </div><!-- .row -->

          <div class="row">

            <div class="form-group col-md-6">
              <label for="image">Select the project image</label>
              <input name="image" type="file" class="form-control-file" id="image">
            </div>

            <div class="form-check col-md-6">
              <label class="form-check-label" for="thumbnail">Select as the studio thumbnail image :</label>
              <br>
              <input name="thumbnail" type="checkbox" class="" id="thumbnail">
            </div>

          </div><!-- .row -->

          <div class="row">
            <div class="form-group col-md-12">
              <label for="imageDescr">Work Description</label>
              <textarea class="form-control" id="imageDescr" rows="6"></textarea>
            </div>
          </div><!-- .row -->

        </div><!-- .work -->

        <div class="row">
          <button id="addWork" type="button" class="btn btn-secondary" name="addWork">Add Another Work</button>
        </div>

        <input type="hidden" name="worksNumber">

      </form>

    </div><!-- .container -->

  </body>
</html>

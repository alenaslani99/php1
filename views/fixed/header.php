 <?php
  $menus = getOneTable("menus");
 ?>
 <!-- header -->
 <nav class="py-2 bg-body-tertiary border-bottom">
        <div class="container d-flex flex-wrap">
              <ul class="nav me-auto">
                <?php
                foreach($menus as $m):
                ?>
                <li class="nav-item"><a href="<?= $m->link?>" class="nav-link link-body-emphasis px-2"><?= $m->name?></a></li>
                <?php
                endforeach;
                ?>
                <?php 
                  if(isset($_SESSION['user']) && $_SESSION['user']->role_name == 'Admin'):                
                ?>
                <li class="nav-item"><a href="index.php?page=admin" class="nav-link link-body-emphasis px-2">Admin Panel</a></li>
                <?php
                endif;
                ?>
              </ul>
              <ul class="nav">
                <?php
                if(isset($_SESSION['user'])):
                ?>
                <li class="nav-item"><a href="model/logout.php" class="nav-link link-body-emphasis px-2">Logout</a></li>
                <?php 
                endif;
                if(!isset($_SESSION['user'])):
                ?>
                <li class="nav-item"><a href="index.php?page=login" class="nav-link link-body-emphasis px-2">Login</a></li>
                <li class="nav-item"><a href="index.php?page=register" class="nav-link link-body-emphasis px-2">Sign up</a></li>
                <?php
                endif;
                ?>
              </ul>
        </div>
    </nav>
    <header class="py-3 mb-4 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <a href="index.php?page=home" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
              
              <span class="fs-4">MechanicBlog</span>
            </a>
        </div>
    </header>
<!-- endheader -->
<?php
    if(isset($_SESSION['user'])):
    $id = $_SESSION['user']->id_user;
    $query = "SELECT * FROM survey WHERE id_user = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if(!$result):
?>
<div class="container p-3 ">
  <div class="row d-flex justify-content-center">
    <div class="col-lg-6 bg-warning">
      <div class="row d-flex justify-content-center rounded-pill">
        <div class="col-lg-6">
          <p class="fs-5">Do you follow Formula 1?</p>
        </div>
        <div class="col-lg-2">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="question" id="yes" value="yes"/>
            <label class="form-check-label" for="inlineRadio1">Yes</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="question" id="no" value="no"/>
            <label class="form-check-label" for="inlineRadio2">No</label>
          </div>
        </div>
        <div class="col-lg-4 mt-2">
          <button type="submit" id="save" class="btn btn-outline-dark">Save answer</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="msgquestion" class="m-3"></div>
<?php
endif;
endif;
?>
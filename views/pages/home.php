<?php
  $query = "SELECT a.*,c.*,arts.article_status_name,i.*,u.name,u.last_name FROM articles a JOIN categories as c ON a.id_category=c.id_category JOIN article_status as arts ON a.id_article_status=arts.id_article_status JOIN images i ON a.id_article=i.id_article JOIN users u ON a.id_user=u.id_user WHERE arts.article_status_name='ok' AND i.status_image = 'ok'";
  if(isset($_GET['cate'])){
    $cat = $_GET['cate'];
    if($cat != 0){
      $query .= "AND c.id_category = $cat";
    }
  }
  if(isset($_GET['search'])){
    $search = $_GET['search'];
    if($search != ""){
      $query .= " AND a.title LIKE '%".$search ."%'";
    }
  }
  // $query .= "ORDER BY a.created_at DESC";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $articles = $stmt->fetchAll();
  $categories = getOneTable("categories");
?>
<!-- articles -->
<div class="container">
<form action="<?= $_SERVER["PHP_SELF"] ?>" method="GET">
  <div class="row mb-3">
    <div class="col-lg-4 ">
    <select name="cate" class="form-select" aria-label="Default select example">
        <option value="0">All</option>
        <?php
        foreach($categories as $c):
          if(isset($_GET['cate']) && $_GET['cate'] == $c->id_category):
        ?>
         <option selected  value="<?= $c->id_category?>"><?= $c->category_name?></option>
        <?php
        else:
        ?>
        <option  value="<?= $c->id_category?>"><?= $c->category_name?></option>
        <?php
        endif;
        endforeach;
        ?>
      </select>
      </div>
      <div class="col-lg-4">
        <?php
          if(isset($_GET['search'])):
        ?>
      <input type="search" name="search" id="search" value="<?= $_GET['search']?>" class="form-control" placeholder="Search..." aria-label="Search">
      <?php
      else:
      ?>
      <input type="search" name="search" id="search" class="form-control" placeholder="Search..." aria-label="Search">
      <?php
      endif;
      ?>
      </div>
      <div class="col-lg-4 d-flex justify-content-center ">
      <input type="submit" class="btn btn-secondary w-100" value="Sort" />
      </div>
      </form>
    </div>
  </div>
</div>
<div class="container">
        <?php
          if(count($articles)):
          foreach($articles as $art):
            $text = $art->article_text;
            $subtext = substr($text,0,100)."...";
        ?>
        <div class="row d-flex justify-content-center mb-3">
          <div class="col-lg-4">
            <img src="assets/images/<?= $art->src?>" class="img-fluid" alt="car1"/>
          </div>
          <div class="col-lg-4">
            <p class="fw-light m-0"><?= $art->created_at?></p>
            <p class="fw-normal m-0"><?= $art->name?> <?= $art->last_name?></p>
            <p class="fs-4 fw-bold"><?= $art->title?></p>
            <p class="lh-sm"><?= $subtext?></p>
            <a href="index.php?page=singleartical&id=<?= $art->id_article?>" class="btn btn-outline-secondary text-uppercase">Read more</a>
          </div>
        </div>
          <?php
            endforeach;
          else:
          ?>
          <div class="alert alert-danger" role="alert">
            We don't have any at the moment
          </div>

          <?php
          endif;
          ?>
</div>
<!-- endarticles -->
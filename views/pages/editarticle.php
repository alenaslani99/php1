<?php
if(isset($_SESSION['user']) && $_SESSION['user']->role_name == 'Admin' && isset($_GET['id'])):
    $id = $_GET['id'];
    $artical = getArticles($id);
    $categories = getOneTable("categories");
?>
<div class="container">
        <form>
        <p class="h1 text-center">Edit article</p>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="title" value="<?= $artical->title?>" placeholder=""/>
                    <label for="title">Title</label>
                    <div id="msgtitle">
                    <p class="text-danger"> Please provide a valid title.</p>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-6 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="category" aria-label="Floating label select example">
                        <option value="0">Choose</option>
                        <?php
                        foreach($categories as $cat):
                            if($cat->id_category == $artical->id_category):
                        ?>
                        <option selected value="<?= $cat->id_category?>"><?= $cat->category_name?></option>
                        <?php
                        else:
                        ?>
                        <option value="<?= $cat->id_category?>"><?= $cat->category_name?></option>
                        <?php
                        endif;
                        endforeach;
                        ?>
                    </select>
                    <label for="category">Category</label>
                </div>
            <div id="msgcategory">
            <p class="text-danger"> Please select category.</p>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-3">
                <div>
                    <div class="form-floating">
                        <textarea class="form-control h-100" placeholder="Leave a comment here" value="" id="text"><?= $artical->article_text?></textarea>
                        <label for="text">Text</label>
                    </div>
                    <div id="msgtext"><p class="text-danger"> Please provide a valid text.</p></div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-4 mb-3">
            <img src="assets/images/<?= $artical->src?>" class="img-thumbnail w-50" alt="...">
            </div>
            <div class="col-lg-4 mb-3">
            <input class="form-control form-control-lg h-100" id="image" type="file"/>
            <input type="hidden" id="imgprev" value="<?= $artical->id_image?>" />
            </div>
        </div>
        <input type="hidden" id="id" value="<?= $id?>"/>
        <div class="row mt-4">
            <divi class="col-lg-12">
                <button type="button" id="updateartical" class="btn btn-outline-primary">Update article</button>
            </div>
        </div>
        
        <div id="msgupdate"></div>
        
    </div>
<?php
endif;
?>
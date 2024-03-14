<!-- footer -->
<div class="container">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <?php
              foreach($menus as $m):
            ?>
            <li class="nav-item"><a href="<?= $m->link?>" class="nav-link px-2 text-body-secondary"><?= $m->name?></a></li>
            <?php
              endforeach;
            ?>
            <li class="nav-item"><a href="php1.pdf" class="nav-link px-2 text-body-secondary">Documentation</a></li>
          </ul>
          <p class="text-center text-body-secondary">&copy; 2024 Company, Inc</p>
        </footer>
    </div>
<!-- endfooter -->

<!-- scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- endscripts -->
</body>
</html>
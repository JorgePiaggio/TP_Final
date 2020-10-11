<main class="py-5">
     <section id="listado" class="mb-5">
          <form action="<?php echo FRONT_ROOT?>Cinema/Add" method="post">
          <div class="container">
               <h3 class="mb-3">Add Cinema</h3>

               <div class="bg-light-p-4">
                    <div class="row">
                         <div class="col-lg-3">
                              <label for="">Cinema</label>
                              <input type="text" name="name" class="form-control form-control-ml" required>
                         </div>                         
                         
                         <div class="col-lg-3">
                              <label for="">Street</label>
                              <input type="text" name="street" class="form-control form-control-ml" required>
                         </div>

                         <div class="col-lg-3">
                              <label for="">Number</label>
                              <input type="number" name="number" class="form-control form-control-ml" required>
                         </div>

                         <div class="col-lg-3">
                              <label for="">Phone</label>
                              <input type="number" name="phone" class="form-control form-control-ml" required>
                         </div>

                         <div class="col-lg-3">
                              <label for="">Email</label>
                              <input type="email" name="email" class="form-control form-control-ml" required>
                         </div>
                         <div class="col-lg-3">
                              <span>&nbsp;</span>
                              <button type="submit" name="" class="btn btn-primary ml-auto d-block">Agregar</button>
                         </div>

                    </div>                    
               </div>
          </div>
          </form>
     </section>
</main>

<?php include('footer.php') ?>

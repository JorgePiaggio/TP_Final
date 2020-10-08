<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Cinemas</h2>

               <table class="table bg-light">
                    <thead class="bg-dark text-white">
                         <th>Name</th>
                         <th>Addres</th>
                         <th>Phone</th>
                         <th>Email</th>
                    </thead>
                    <tbody>
                    <?php foreach($cinemaList as $cinema){ ?>
                         <tr>
                              <td><?php echo $cinema->getName(); ?> </td>     
                              <td><?php echo $cinema->getAddress(); ?> </td>
                              <td><?php echo $cinema->getPhone(); ?> </td>
                              <td><?php echo $cinema->getEmail(); ?> </td>
                         </tr>
                    <?php } ?>
                    </tbody>
               </table>
          </div>
     </section>
</main>


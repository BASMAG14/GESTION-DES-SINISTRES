<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<table id="list" class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Contact #</th>
						<th>Address</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM customers order by concat(lastname,', ',firstname,' ',middlename) asc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo $row['contact'] ?></b></td>
						<td><b><?php echo $row['address'] ?></b></td>
						<td><b><?php echo $row['email'] ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item" href="./index.php?page=edit_customer&id=<?php echo $row['id'] ?>">Modifier</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_customer" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Supprimer</a>
		                    </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	
  
  $(document).ready(function () {
    if ($.fn.dataTable.isDataTable('#list')) {
      $('#list').DataTable().destroy();
    }
    $('#list').DataTable({
      language: {
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:     "Afficher _MENU_ éléments",
        info:           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
        infoEmpty:      "Affichage de l'élément 0 à 0 sur 0 élément",
        infoFiltered:   "(filtré de _MAX_ éléments au total)",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun élément à afficher",
        emptyTable:     "Aucune donnée disponible dans le tableau",
        paginate: {
          first:      "Premier",
          previous:   "Précédent",
          next:       "Suivant",
          last:       "Dernier"
        },
        aria: {
          sortAscending:  ": activer pour trier la colonne par ordre croissant",
          sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
      }
    });







	$('.delete_customer').click(function(){
	_conf(" Êtes-vous sûr de vouloir supprimer ce client ?","delete_customer",[$(this).attr('data-id')])
	})
	})
	function delete_customer($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_customer',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Données supprimées avec succès",'succès')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
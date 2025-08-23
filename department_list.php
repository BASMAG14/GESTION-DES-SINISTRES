<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<button class="btn btn-sm text-white btn-block" type='button' id="new_department" style="background-color: #28a745;">
  <i class="fa fa-plus"></i> nouveau Département
</button>

			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th>#</th>
						<th>Nom</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM departments order by  name asc");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['name']) ?></b></td>
						<td><b><?php echo $row['description'] ?></b></td>
						<td class="text-center ">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item edit_department" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Modifier</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_department" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">supprimer</a>
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
 


	$('#new_department').click(function(){
		uni_modal("New Department","manage_department.php")
	})
	$('.edit_department').click(function(){
		uni_modal("Edit Department","manage_department.php?id="+$(this).attr('data-id'))
	})
	$('.delete_department').click(function(){
	_conf("Êtes-vous sûr de vouloir supprimer ce département ? ","delete_department",[$(this).attr('data-id')])
	})
	
	})
	function delete_department($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_department',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Données supprimées avec succès",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
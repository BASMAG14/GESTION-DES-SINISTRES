<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-info">
		<div class="card-body">
			<table class="table table-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="25%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date de création</th>
						<th>Sinistre</th>
						<th>Objet</th>
						<th>Description</th>
						<th>Statut</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$where = '';
					if($_SESSION['login_type'] == 2)
						$where .= " where t.department_id = {$_SESSION['login_department_id']} ";
					if($_SESSION['login_type'] == 3)
						$where .= " where t.customer_id = {$_SESSION['login_id']} ";
					$qry = $conn->query("SELECT t.*,concat(c.lastname,', ',c.firstname,' ',c.middlename) as cname FROM tickets t inner join customers c on c.id= t.customer_id $where order by unix_timestamp(t.date_created) desc");
					while($row= $qry->fetch_assoc()):
						$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']),$trans);
						$desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo date("M d, Y",strtotime($row['date_created'])) ?></b></td>
						<td><b><?php echo ucwords($row['cname']) ?></b></td>
						<td><b><?php echo $row['subject'] ?></b></td>
						<td><b class="truncate"><?php echo strip_tags($desc) ?></b></td>
						<td>
							<?php if($row['status'] == 0): ?>
								<span class="badge badge-primary">En attente / Ouvert</span>
							<?php elseif($row['status'] == 1): ?>
								<span class="badge badge-Info">En cours</span>
							<?php elseif($row['status'] == 2): ?>
								<span class="badge badge-success">Terminé</span>
							<?php else: ?>
								<span class="badge badge-secondary">Fermé</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_ticket" href="./index.php?page=view_ticket&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="./index.php?page=edit_ticket&id=<?php echo $row['id'] ?>">Modifier</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_ticket" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Supprimer</a>
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
  


	$('.delete_ticket').click(function(){
	_conf("Êtes-vous sûr de vouloir supprimer cette sinistre?","delete_ticket",[$(this).attr('data-id')])
	})
	})
	function delete_ticket($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_ticket',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Données supprimées avec succès.",'succès')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
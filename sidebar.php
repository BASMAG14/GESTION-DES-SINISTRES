<aside class="main-sidebar sidebar-light-success elevation-4">


    <div class="dropdown">
   	<a href="javascript:void(0)" class="brand-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <span 
  class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center text-white font-weight-500"
  style="background-color: #b2f2bb; color: #000; width: 38px; height: 38px; border-radius: 50%;">
  <?php echo strtoupper(substr($_SESSION['login_firstname'], 0,1).substr($_SESSION['login_lastname'], 0,1)) ?>
</span>


        <span class="brand-text font-weight-light"><?php echo ucwords($_SESSION['login_firstname'].' '.$_SESSION['login_lastname']) ?></span>

      </a>
      <div class="dropdown-menu" style="">
        <a class="dropdown-item manage_account" href="javascript:void(0)" data-id="<?php echo $_SESSION['login_id'] ?>">Gérer le compte</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="ajax.php?action=logout">Déconnexion</a>
      </div>
    </div>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau de bord
              </p>
            </a>
            
          </li>    
        <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_customer">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Client
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_customer" class="nav-link nav-new_customer tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Ajouter un nouveau</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=customer_list" class="nav-link nav-customer_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_staff">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Agent
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_staff" class="nav-link nav-new_staff tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Ajouter un nouveau</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=staff_list" class="nav-link nav-staff_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=department_list" class="nav-link nav-department_list">
              <i class="nav-icon fas fa-columns"></i>
              <p>
               Département
              </p>
            </a>
          </li>     
        <?php endif; ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_ticket nav-view_ticket">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>
                Sinistre
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_ticket" class="nav-link nav-new_ticket tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Ajouter un nouveau</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=ticket_list" class="nav-link nav-ticket_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Liste</p>
                </a>
              </li>
            </ul>
          </li> 
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
  		var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		if($('.nav-link.nav-'+page).length > 0){
  			$('.nav-link.nav-'+page).addClass('active')
          console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
  		}
      $('.manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id='+$(this).attr('data-id'))
      })
  	})
  </script>
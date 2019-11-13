<!DOCTYPE html>
<html lang="pt">

<head>
  
  <?php
      include "../bibliotecas.php";
  ?>

  <script type="text/javascript">
			$(document).ready(function(){
				$('#formCadastrarCondominio').submit(function(){					
					var data = $("#formCadastrarCondominio").serialize();
					$.ajax({
						type : 'POST',
						url  : '../faz_cadastro_condominio.php',
						data : data,
						dataType: 'json',
						success: function( response )
						{
							if(response == '1'){
                const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                  })

                  Toast.fire({
                        type: 'success',
                        title: 'Condominio cadastrado'
                  })
                //regarrega página automaticamente;  
                setTimeout(function(){
                                        window.location.reload(1);
                }, 3000);

                  $('#modalAdicionarCondominio').modal('hide');
              }else if(response == '0'){
                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: 'Esse email já foi cadastrado!'
                })
              }
						}
					});
					return false;
        });
        
        $('#formApagarCondominio').submit(function(){					
            var data = $("#formApagarCondominio").serialize();
            $.ajax({
              type : 'POST',
              url  : '../deleta_condominio.php',
              data : data,
              dataType: 'json',
              success: function( response )
              {
                if(response == "1"){
                    
                  const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                  })

                  Toast.fire({
                        type: 'success',
                        title: 'Condominio apagado'
                  })

                  //regarrega página automaticamente;  
                  setTimeout(function(){
                                        window.location.reload(1);
                                    }, 2000);

                }else if(response == "0"){
                    Swal.fire(
                      'Opps..?',
                      'Email não existe',
                      'question'
                    )
                }else if(response == "2"){
                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Não é possível apagar o registro, existem vinculações em aberto!'
                  })             
                }
                $('#modalExcluirColetor').modal('hide');
              }
            });
            return false;
        })

        $( "#logout" ).click(function() { 
          window.location.href = '../index.php';      
        });

			});
  </script>
 
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="azure" data-background-color="white" data-image="../../bootstrap-css-js/assets/img/side.jpg">
      <div class="logo">
        <a href="#" class="simple-text logo-normal">
          TrashAll
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="./pageDashboard.php">
                  <i class="material-icons">dashboard</i>
                  <p>Dashboard</p>
                </a>
              </li>
          <li class="nav-item">
            <a class="nav-link" href="./pageColetor.php">
              <i class="material-icons">dashboard</i>
              <p>Cadastrar coletor</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./pageCondominio.php">
              <i class="material-icons">person</i>
              <p>Cadastrar condominío</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
              <h3>
                Trashall -
                <small class="text-muted">Cadastrar Condominío</small>
              </h3>
          </div>
        
          <div class="collapse navbar-collapse justify-content-end">            
            <ul class="navbar-nav">        
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Perfil</a>
                  <a class="dropdown-item" href="#">Configurações</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" id="logout" href="#">Sair</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      
      <div id="acoes">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAdicionarCondominio">
                Adicionar</button>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalExcluirColetor">
                Excluir</button>
            
      </div><br><br>
        
      <div class="table-responsive col-md-12">
        <table id="coletasColetor" class="table table-striped" cellspacing="0" cellpadding="0">
      <thead>

            <?php
                  require_once '../init.php';
                  $PDO = db_connect();
                  try{
                      $sql = "SELECT * FROM condominio c
                        LEFT JOIN endereco e ON c.id_condominio = e.id_condominio 
                        LEFT JOIN contato ct ON c.id_condominio = ct.id_condominio
                       ORDER BY data_cadastro DESC";
                      $stmt = $PDO->prepare($sql);
                      $stmt->execute();

                      echo "<thead>";
                        echo "<th>Nome condominio</th>";
                        echo "<th>Login</th>";
                        echo "<th>Endereço</th>";
                        echo "<th>Contato</th>";
                        echo "<th>Data Cadastro</th>";
                        
                      echo "</thead>";
                      
                      //constroí a tabela
                      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                          echo " <td>";
                            echo $row['nome_condominio'];
                          echo "</td>";
                          echo " <td>";
                            echo $row['login_usuario'];
                          echo "</td>";
                          echo "<td>";
                              $endereco = $row['logradouro'].' '.$row['numero'].' '.$row['bairro'].' - '.
                                          $row['cidade'].'/'.$row['estado'];
                              echo $endereco;
                          echo "</td>";
                          echo "<td>";
                          if($row['descricao'] != ''){
                            echo $row['descricao'];
                          }else{
                            echo "-";
                          }
                            
                          echo "</td>";
                          echo " <td>";
                            echo date('d/m/Y H:i:s',strtotime($row['data_cadastro']));
                          echo "</td>";
                        
                        echo "</tr>";
                      }

                      
                  }catch(PDOException $erro_2){
                      echo 'erro'.$erro_2->getMessage();       
                  }
            ?>
      </table>

      <!-- End Navbar -->
  </div>
  <!--   Core JS Files   -->
  <script src="../../bootstrap-css-js/assets/js/core/jquery.min.js"></script>
  <script src="../../bootstrap-css-js/assets/js/core/popper.min.js"></script>
  <script src="../../bootstrap-css-js/assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../../bootstrap-css-js/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="../../bootstrap-css-js/assets/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="../../bootstrap-css-js/assets/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="../../bootstrap-css-js/assets/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="../../bootstrap-css-js/assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../../bootstrap-css-js/assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="../../bootstrap-css-js/assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="../../bootstrap-css-js/assets/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="../../bootstrap-css-js/assets/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="../../bootstrap-css-js/assets/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="../../bootstrap-css-js/assets/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <script src="../../bootstrap-css-js/assets/js/plugins/jquery-jvectormap.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="../../bootstrap-css-js/assets/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="../../bootstrap-css-js/assets/js/plugins/arrive.min.js"></script>

  <!-- Chartist JS -->
  <script src="../../bootstrap-css-js/assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../../bootstrap-css-js/assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../bootstrap-css-js/assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="../../bootstrap-css-js/assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

    });
  </script>

<!-- Modal cadastrar condominio-->
<div class="modal fade" id="modalAdicionarCondominio" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalLongoExemplo">Cadastrar condominio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formCadastrarCondominio" action="" method="post">
            <div class="modal-body">
              
                  Nome: <input type="nome" name="txtNomeCondominio" id="txtNomeCondominio">
                  Email usuário: <input type="email" name="txtEmailCondominio" id="txtEmailCondominio">
                  Senha : <input type="password" name="txtSenhaCondominio" id="txtSenhaCondominio">
                  <br>
                  Cep: <input tyte="text" name="txtCepCondominio" id="txtCepCondominio">
                  Logradouro: <input type="text" name = "txtLogradouroCondominio" id = "txtLogradouroCondominio">
                  Número: <input type="number" name ="txtNumeroCondominio" maxlength="5" id ="txtNumeroCondominio">
                  <br>
                  Bairro: <input type="text" name ="txtBairroCondominio" id ="txtBairroCondominio">
                  Cidade: <input type="text" name ="txtCidadeCondominio" id ="txtCidadeCondominio">
                  <br>
                  Contato: <input type="email"  name="txtContatoCondominio" id="txtContatoCondominio">

              
            </div>
            <div class="modal-footer">
              <input type="submit" value='Confirmar' id="btnConfirmar" class="btn btn-success">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>             
          
            </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal excluir coletor-->
<div class="modal fade" id="modalExcluirColetor" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalLongoExemplo">Exclusão condomínio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formApagarCondominio" action="" method="post">
            <div class="modal-body">            
                  Email: <input type="email" required name="txtEmailCondominioExlusao" id="txtEmailCondominioExlusao">  
            </div>
            <div class="modal-footer">
              <input type="submit" id="btnConfirmaExclusao" value="Confirmar" class="btn btn-success">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>             
          
            </div>
      </form>
    </div>
  </div>
</div>



</body>

</html>

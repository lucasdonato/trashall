<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
          include "../bibliotecas.php";
          session_start();
    ?>
</head>
<script>

$(document).ready(function(){
  
          $( ".cancelarSolicitacao" ).click(function() {

                                /*recuperar o id da solicitacao aqui*/              
                                let id_solicitacao = $(this)                // Representa o elemento clicado (checkbox)
                                    .closest('tr')  // Encontra o elemento pai do seletor mais próximo
                                    .find('td') // Encontra o elemento do seletor (todos os tds)
                                    .eq(0)      // pega o primeiro elemento (contagem do eq inicia em 0)
                                    .text();    // Retorna o texto do elemento


            Swal.fire({
                  title: 'Cancelar e excluir solicitação?',
                  text: "Essa ação não poderá ser desfeita",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sim, cancelar e excluir!'
                }).then((result) => {
                  if (result.value) {
                    
                        $.ajax({
                                type : 'POST',
                                url  : '../cancelar_solicitacao_condominio.php',
                                data : {id_solicitacao : id_solicitacao},
                          
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
                                            title: 'Solicitação cancelada e excluída'
                                      })
                                        //regarrega página automaticamente;  
                                        setTimeout(function(){
                                            window.location.reload(1);
                                        }, 3000);
                                  }else if(response == '0'){
                                    console.log(response);
                                  }
                                }
                          });

                  }
            })
        }); 

        $( "#logout" ).click(function() { 
          window.location.href = '../index.php';      
        });
          /*faz o filtro manipulando o html*/
          $( "input[name='situacao_coleta']" ).click(function() { 
                          var situacao_radio = $("input[name='situacao_coleta']:checked").val();

                          $("#solicitacoesCondominio tbody tr").each(function(){                  
                              
                            /*PEGA O ID DA IMAGEM, ESSA É A FAMOSA POG
                            PROGRAMAÇÃO ORIENTADA A GAMBIARRA*/
                            var situacao_table =  $(this).find( ".status img" ).attr("id");               

                              if(situacao_radio == 'TODOS'){
                                  location.reload();
                              }else if(situacao_radio != situacao_table){
                                  $(this).hide();
                              }else{
                                  $(this).show();
                              }
                          });
                    });
                    /*fim manipulação filtros*/


});

</script>

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
                <a class="nav-link" href="pageDashboard.php">
                  <i class="material-icons">dashboard</i>
                  <p>Dashboard</p>
                </a>
              </li>
          
          <li class="nav-item active">
            <a class="nav-link" href="solicitacoes_condominio.php">
              <i class="material-icons">remove_red_eye</i>
              <p>Acompanhar Solicitações</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="solicitar_coleta_condominio.php">
              <i class="material-icons">rate_review</i>
              <p>Solicitar coleta</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="minhas_coletas.php">
              <i class="material-icons">list</i>
              <p>Minhas Coletas</p>
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
                <small class="text-muted">Acompanhamento solicitações</small>
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
      <!-- End Navbar -->
       <!-- inicio dos filtros -->

       <br><br><br><br>

        <!-- MONTA OS RADIOBUTTONS -->
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" id="todos" name="situacao_coleta" value="TODOS" checked>
          <label style='color:black;' class="custom-control-label" for="todos">TODOS</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" id="emAberto" name="situacao_coleta" value="EM ABERTO">
          <label style='color:black;' class="custom-control-label" for="emAberto">EM ABERTO</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" id="confirmada" name="situacao_coleta" value="CONFIRMADA">
          <label style='color:black;' class="custom-control-label" for="confirmada">CONFIRMADA</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" id="rejeitada" name="situacao_coleta" value="REJEITADA">
          <label style='color:black;' class="custom-control-label" for="rejeitada">REJEITADA</label>
        </div>

        <br>

        <!-- fim dos filtros -->

      <div class="table-responsive col-md-12">
        <table id="solicitacoesCondominio" class="table table-striped" cellspacing="0" cellpadding="0">
        <?php
            require_once '../init.php';
            $PDO = db_connect();
            try{
                  $sql = "SELECT s.*,ce.nome_empresa
                          FROM solicitacoes s 
                          JOIN coletor_empresa ce ON s.id_coletor = ce.id_coletor
                          WHERE id_condominio = :id_condominio
                          ORDER BY s.data_solicitacao DESC"; 

                  $stmt = $PDO->prepare($sql);
                  $stmt->bindParam(':id_condominio', $_SESSION['id_condominio']);
                  $stmt->execute();

                  echo "<thead>";
                          echo "<th style='display:none;'>id_solicitacao</th>";
                          echo "<th>Nome do Coletor</th>";
                          echo "<th>Data Solicitação</th>";
                          echo "<th>Observações</th>";
                          echo "<th>Situação</th>";
                          echo "<th class'actions'>Ações</th>";
                  echo "</thead>";                 

                  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                        echo "<td style='display:none;'>";
                          echo $row['id_solicitacao'];
                        echo "</td>";
                      echo "<td>";
                        echo $row['nome_empresa'];
                      echo "</td>";
                      echo "<td>";
                        echo date('d/m/Y H:i:s',strtotime($row['data_solicitacao']));
                      echo "</td>";
                      echo "<td>";
                        echo $row['observacoes'];
                      echo "</td>";
                      
                      /*VALIDA O TIPO DE SITUACAO
                      PARA ALTERAR A CORD EXIBIDA NA COLUNA*/
                      echo "<td class='status'>";
                          if($row['situacao'] == 'EM ABERTO'){
                            echo "<img id='EM ABERTO' src='../../imagens/time.png' title='Solicitação em aberto, aguardando coletor.'>";

                          }else if($row['situacao'] == 'REJEITADA'){
                            echo "<img src='../../imagens/cancel.png' id='REJEITADA' title='Solicitação rejeitada pelo coletor.'>";

                          }else if($row['situacao'] == 'CONFIRMADA'){
                            echo "<img src='../../imagens/ok.png' id='CONFIRMADA' title='Solicitação confirmada pelo coletor, uma coleta foi gerada!'>";
                          }                         

                      echo "</td>";
                      echo "<td class='actions'>";
                          if($row['situacao'] == 'CONFIRMADA' || $row['situacao'] == 'REJEITADA'){
                            echo "<button type='button' title='Clique aqui para visualizar dados da coleta vinculada.' class='btn btn-info visualizarColeta'>Visualizar</button>";
                          }else if($row['situacao'] == 'EM ABERTO'){
                            echo "<a class='btn btn-danger btn-xs cancelarSolicitacao' title='Clique aqui para cancelar a solicitação.' href='#' data-toggle='modal' data-target='#delete-modal'>Cancelar</a>";
                          }   
                      echo "</td>";
                    echo "</tr>";

                  }

            }catch(PDOException $erro_2){
              echo 'erro'.$erro_2->getMessage();       
          } 

        ?>

         </table>
 
     </div>
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
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
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

<script>

    /*RESPONSÁVEL POR CARREGAR O MODAL 
    COM OS DADOS DA COLETA, PARA ISSO É NECESSÁRIO
    REALIZAR UMA REQUISIÇÃO EM OUTRO ARQUIVO PHP*/
    $(document).ready(function() {
          $(".visualizarColeta").click(function() { 

              /*RECUPERA O ID DA SOLICITACAO*/           
                       let id_solicitacao = $(this)             
                                    .closest('tr')  
                                    .find('td') 
                                    .eq(0)      
                                    .text();
                        
              $('#ExemploModalCentralizado').modal('show'); 
              $(".modal-body").load('../coleta_vinculada.php?id_solicitacao=' + id_solicitacao);
          });
    });

</script>

<!-- Modal -->
<div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">Informações sobre a coleta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <!-- AQUI É PREENCHIDO AUTOMATICAMENTE COM O LOAD 
        DO JQUERY QUE UTILIZAMOS-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


</body>

</html>

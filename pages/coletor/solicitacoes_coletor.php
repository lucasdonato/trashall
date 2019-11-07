<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
          include "../bibliotecas.php";
          session_start();
    ?>
</head>

<script type="text/javascript">
			$(document).ready(function(){
          /*COMO O ELEMENTO REPETE, DEVEMOS PASSAR A CLASSE NA TD
          COMO O ID É ÚNICO, APENAS 1 TD SERÁ CLICÁVEL*/
          $( ".aceitarColeta" ).click(function() {

                /*recuperar o id da solicitacao aqui*/              
                let id_solicitacao = $(this)                // Representa o elemento clicado (checkbox)
                                    .closest('tr')  // Encontra o elemento pai do seletor mais próximo
                                    .find('td') // Encontra o elemento do seletor (todos os tds)
                                    .eq(0)      // pega o primeiro elemento (contagem do eq inicia em 0)
                                    .text();    // Retorna o texto do elemento

                /*enviar o id da solicitacao para o faz_coleta
                no faz_coleta usar o id da solicitacao para enviar os 
                dddos para a tabela de coleta;*/

                Swal.fire({
                  title: 'Aceitar coleta?',
                  text: "Essa ação não poderá ser desfeita",
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sim, aceitar!',
                  cancelButtonText: "Cancelar",
                  background: '#98FB98'
              }).then((result) => {
                  if (result.value) {
                    /*DEVE CRIAR UM REGISTRO NA TABELA COLETA_ANDAMENTO
                    DEVE ALTERA O STATUS DA SOLICITAÇÃO PARA CONFIRMADA*/                    
                    $.ajax({
                            type : 'POST',
                            url  : '../faz_coleta.php',
                            data : {id_solicitacao : id_solicitacao},
                      
                            success: function( response )
                            {
                              if(response == '1'){
                                Swal.fire(
                                  'Good Job!',
                                  'Coleta em andamento, acesse o menu "Minhas coletas"',
                                  'success'
                                )      
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

            $( ".negarColeta" ).click(function() {

                    /*recuperar o id da solicitacao aqui*/              
                    let id_solicitacao = $(this)                // Representa o elemento clicado (checkbox)
                                    .closest('tr')  // Encontra o elemento pai do seletor mais próximo
                                    .find('td') // Encontra o elemento do seletor (todos os tds)
                                    .eq(0)      // pega o primeiro elemento (contagem do eq inicia em 0)
                                    .text();    // Retorna o texto do elemento
              
              Swal.fire({
                  title: 'Rejeitar coleta?',
                  text: "Essa ação não poderá ser desfeita",
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sim, rejeitar!',
                  cancelButtonText: "Cancelar",
                  background: '#FFA07A'
              }).then((result) => {
                  if (result.value) {                 
                    $.ajax({
                            type : 'POST',
                            url  : '../rejeitar_coleta.php',
                            data : {id_solicitacao : id_solicitacao},
                      
                            success: function( response )
                            {
                              if(response == '1'){
                                Swal.fire(
                                  'Good Job!',
                                  'Coleta negada"',
                                  'success'
                                )
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
                  <i class="material-icons">content_paste</i>
                  <p>Dashboard</p>
                </a>
              </li>
            <li class="nav-item">
                <a class="nav-link" href="feedback_condominio.php">
                  <i class="material-icons">dashboard</i>
                  <p>Feedback</p>
                </a>
              </li>
          <li class="nav-item active">
            <a class="nav-link" href="solicitacoes_condominio.php">
              <i class="material-icons">dashboard</i>
              <p>Acompanhar solicitações</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="coletas_coletor.php">
              <i class="material-icons">person</i>
              <p>Minhas coletas</p>
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
                <small class="text-muted">Minhas solicitações</small>
              </h3>
          </div>
          
      </nav>
      <!-- End Navbar -->
      
      <br><br><br><br><br>
      <div class="table-responsive col-md-12">
        <table id="solicitacoesColetor" class="table table-striped" cellspacing="0" cellpadding="0">
        <?php
            require_once '../init.php';
            $PDO = db_connect();
            try{
                $sql = "SELECT s.*,c.nome_condominio FROM solicitacoes s
                JOIN condominio c ON s.id_condominio = c.id_condominio
                WHERE s.id_coletor = :id_coletor
                ORDER BY s.data_solicitacao DESC";

                  $stmt = $PDO->prepare($sql);
                  $stmt->bindParam(':id_coletor', $_SESSION['id_coletor']);
                  $stmt->execute();

                  echo "<thead>";
                          echo "<th style='display:none;'>id_solicitacao</th>";
                          echo "<th>Condomínio</th>";
                          echo "<th>Data Solicitação</th>";
                          echo "<th>Situação</th>";
                          echo "<th class'actions'>O que vamos fazer?</th>";
                  echo "</thead>";                 

                  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td style='display:none;' class='idsolicitacao'>";
                        echo $row['id_solicitacao'];
                      echo "</td>";
                      echo "<td>";
                        echo $row['nome_condominio'];
                      echo "</td>";
                      echo "<td>";
                        echo date('d/m/Y H:i:s',strtotime($row['data_solicitacao']));
                      echo "</td>";
                      
                      /*VALIDA O TIPO DE SITUACAO
                      PARA ALTERAR A CORD EXIBIDA NA COLUNA*/
                      echo "<td>";
                          if($row['situacao'] == 'EM ABERTO'){
                            echo "<img src='../../imagens/time.png'>";

                          }else if($row['situacao'] == 'REJEITADA'){
                            echo "<img src='../../imagens/cancel.png'>";

                          }else if($row['situacao'] == 'CONFIRMADA'){
                            echo "<img  src='../../imagens/ok.png'>";
                          }

                      echo "</td>";
                      echo "<td class='actions'>";
                              /*apenas solicitações confirmadas ficam com o botão
                              visualizar ativo*/
                              if($row['situacao'] == 'CONFIRMADA' || ($row['situacao'] == 'REJEITADA')){
                                echo "<button type='button' class='btn btn-info' data-toggle='modal' 
                                  data-target='#ExemploModalCentralizado'>Visualizar</button>";
                                  echo "";
                                  echo "";
                              }else if($row['situacao'] == 'EM ABERTO'){
                                echo "<a class='btn btn-success btn-xs aceitarColeta'  href='#'>Aceitar</a>";
                                echo "<a class='btn btn-danger btn-xs negarColeta'  href='#' data-toggle='modal' data-target='#delete-modal'>Negar</a>";
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

<!-- Modal -->
<div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModalCentralizado">Informações sobre a coleta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        implementar depois
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success">Salvar mudanças</button>
      </div>
    </div>
  </div>
</div>


</body>

</html>

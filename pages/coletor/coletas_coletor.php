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
       
          $( ".finalizarColeta" ).click(function() { 
                /*recuperar o id da solicitacao aqui*/              
                let id_coleta = $(this)                // Representa o elemento clicado (checkbox)
                                    .closest('tr')  // Encontra o elemento pai do seletor mais próximo
                                    .find('td') // Encontra o elemento do seletor (todos os tds)
                                    .eq(0)      // pega o primeiro elemento (contagem do eq inicia em 0)
                                    .text();    // Retorna o texto do elemento

                                    Swal.fire({
                  title: 'Encerrar coleta?',
                  text: "Essa ação não poderá ser desfeita",
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sim, finalizar!',
                  cancelButtonText: "Cancelar"
              }).then((result) => {
                  if (result.value) {                  
                    $.ajax({
                            type : 'POST',
                            url  : '../finaliza_coleta.php',
                            data : {id_coleta : id_coleta},
                      
                            success: function( response )
                            {
                              if(response == '1'){
                                Swal.fire({
                                      title: 'Avalie a coleta',
                                      input: 'text',
                                      icon: 'info',
                                      inputAttributes: {
                                        autocapitalize: 'off'
                                      },
                                      showCancelButton: true,
                                      confirmButtonText: 'Enviar',
                                      showLoaderOnConfirm: true,
                                      preConfirm: (login) => {
                                          //regarrega página automaticamente;  
                                          setTimeout(function(){
                                              window.location.reload(1);
                                            }, 2000);   
                                      },
                                      allowOutsideClick: () => !Swal.isLoading()
                                    })                                    
                                                            
                              }else if(response == '0'){
                                console.log(response);
                              }
                            }
                      });                   
                  }
                })
          });

          $( ".cancelarColeta" ).click(function() { 
                 /*recuperar o id da solicitacao aqui*/              
                 let id_coleta = $(this)                // Representa o elemento clicado (checkbox)
                                    .closest('tr')  // Encontra o elemento pai do seletor mais próximo
                                    .find('td') // Encontra o elemento do seletor (todos os tds)
                                    .eq(0)      // pega o primeiro elemento (contagem do eq inicia em 0)
                                    .text();    // Retorna o texto do elemento


                                    Swal.fire({
                  title: 'Cancelar coleta?',
                  text: "Essa ação não poderá ser desfeita",
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sim, cancelar!',
                  cancelButtonText: "Sair"
              }).then((result) => {
                  if (result.value) {                  
                    $.ajax({
                            type : 'POST',
                            url  : '../cancelarColeta.php',
                            data : {id_coleta : id_coleta},
                      
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
                                        title: 'Coleta cancelada'
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
        
        $( ".enviaWPP" ).click(function() { 
              /*recupera contato do condominio para enviar
              a mensagem via zap zap*/
                   var contato_condominio = $(this)        
                                    .closest('tr')
                                    .find('td') 
                                    .eq(5)      
                                    .text(); 
              
              /*link de redirecionamento com os parametros para o zap*/
              window.open("https://api.whatsapp.com/send?phone="+contato_condominio+"&text=Ol%C3%A1%2C%20sua%20coleta%20foi%20finalizada!");
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
          <li class="nav-item">
            <a class="nav-link" href="solicitacoes_coletor.php">
              <i class="material-icons">dashboard</i>
              <p>Acompanhar solicitações</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="solicitar_coleta_condominio.php">
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
                <small class="text-muted">Minhas Coletas</small>
              </h3>
          </div>
          
      </nav>
      <!-- End Navbar -->

      <script>
          $(document).ready(function(){       
                $( ".classMaps" ).click(function() { 
                   /*recupera o endereço para 
                   montar o maps no modal */
                   var enderecoMaps = $(this)        
                                    .closest('tr')
                                    .find('td') 
                                    .eq(6)      
                                    .text();                                        

                    /*realiza um append no HTML passando via parametro
                    a váriavel de endereço que foi recuperado acima
                    é necessário remover antes para não ficar criando um novo frame
                    sempre que for clicado no ícone*/
                    $('#frameMaps').remove();
                    $("#conteudoMaps").append('<iframe id="frameMaps" width="100%" height="500" src="https://maps.google.com/maps?q='+enderecoMaps+'&output=embed"></iframe>');
                    $('#modalMaps').modal('show');                
                  
                });

          }); 
      </script>
      
      <br><br><br><br><br>
      <div class="table-responsive col-md-12">
        <table id="coletasColetor" class="table table-striped" cellspacing="0" cellpadding="0">
        <?php
            require_once '../init.php';
            $PDO = db_connect();
            try{
               
                $sql = "SELECT ca.id_coleta,ca.status,ca.data_coleta, cole.nome_empresa, cond.nome_condominio, e.*, s.peso,cont.descricao
                        FROM coleta_andamento ca 
                        JOIN coletor_empresa cole ON ca.id_coletor = cole.id_coletor
                        JOIN condominio cond ON ca.id_condominio = cond.id_condominio
                        JOIN endereco e ON ca.id_endereco_destino = e.id_endereco
                        JOIN solicitacoes s ON s.id_solicitacao = ca.id_solicitacao
                        JOIN contato cont ON cont.id_condominio = ca.id_condominio
                        WHERE ca.id_coletor = :id_coletor
                        ORDER BY ca.data_coleta DESC";

                  $stmt = $PDO->prepare($sql);
                  $stmt->bindParam(':id_coletor', $_SESSION['id_coletor']);
    
                  //se executar a consulta
                  if($stmt->execute()){
                        
                    echo "<thead>";
                        echo "<th style='display:none;'>id_coleta</th>";
                        echo "<th>Status</th>";
                        echo "<th>Data da coleta</th>";
                        echo "<th>Peso total</th>";
                        echo "<th>Condomínio</th>";
                        echo "<th>Contato</th>";
                        echo "<th>Local da coleta</th>";
                        echo "<th>Maps</th>";
                        echo "<th>Acões</th>";
                    echo "</thead>";   
  
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                            echo "<td style='display:none;'>";
                                    echo $row['id_coleta'];
                            echo "</td>";
                            echo "<td>";
                                    echo $row['status'];
                            echo "</td>";
                            echo "<td>";
                                    echo date('d/m/Y H:i:s',strtotime($row['data_coleta']));
                            echo "</td>";
                            echo "<td>";
                                    echo $row['peso'].' KG';
                            echo "</td>";
                            echo "<td>";
                                    echo $row['nome_condominio'];
                            echo "</td>";    
                            echo "<td>";
                                    echo $row['descricao'];
                            echo "</td>";                          
                            echo "<td>";
                                    $endereco = $row['logradouro'].' '.$row['numero'].' '.$row['bairro'].' - '.
                                                $row['cidade'].'/'.$row['estado'];
                                    echo $endereco;
                            echo "</td>";
                            echo "<td>";
                                    echo '<img class="classMaps" data-toggle="modal" data-target="#" src="../../imagens/maps.png" title="Clique aqui para ver a localização do endereço."';
                            echo "</td>";
                            echo "<td>";
                                if($row['status'] == 'EM ANDAMENTO'){
                                    echo '<img class="finalizarColeta" src="../../imagens/ok.png" title="Clique aqui para finalizar a coleta."';
                                    echo "<br>";
                                    echo '<img class="cancelarColeta" src="../../imagens/cancel.png" title="Clique aqui para cancelar a coleta."';
                                }else if($row['status'] == 'CANCELADA'){
                                    echo '<img  class="" src="../../imagens/silverblock_6302.png" title="Essa coleta foi cancelada."';
                                }else{
                                    echo '<img class="enviaWPP" src="../../imagens/Whatsapp_icon-icons.com_66931.png" title="Enviar WhatsApp para o condominío."';
                                }
                                
                            echo "</td>";
                        echo "</tr>";

                    }

                 }
            }catch(PDOException $erro_2){
                echo 'erro'.$erro_2->getMessage();       
            }
        
        ?>
         </table> 
     </div>
  </div>

<!-- Large modal responsavel por mostrar a localização do mapa-->
<div class="modal fade" id="modalMaps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Localização</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="conteudoMaps" class="modal-body">             
  
            <!-- VIA JQUERY OS DADOS SÃO INSERIDOS AQUI-->
      </div>
    </div>
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

</body>
</html>

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
                                
                                $("input[name='id_coleta_ratings']").val(id_coleta);
                                $('#modalRatings').modal('show');                                                                 
                                                            
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
              window.open("https://api.whatsapp.com/send?phone=+55"+contato_condominio+"&text=Ol%C3%A1%2C%20sua%20coleta%20foi%20finalizada!");
        });

        $("input[name='rate']").click(function() {  

            /*pega o valor da avaliação para
            salvar no banco de dados..*/
            avaliacao = $(this).val();  

            /*PEGA O ID DA COLETA DE MODO GAMBIARRA, MAS FUNCIONA*/
            id_coleta_ratings = $("input[name='id_coleta_ratings']").val();

            $.ajax({
                            type : 'POST',
                            url  : '../avaliacao_coleta.php',
                            data : {
                              id_coleta_ratings : id_coleta_ratings,
                              avaliacao : avaliacao
                            },
                      
                            success: function( response )
                            {
                             if(response == '1'){
                                $('#modalRatings').modal('hide');  
                                      const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                      })

                                    Toast.fire({
                                          type: 'success',
                                          title: 'Feedback registrado'
                                    })  
                                     //regarrega página automaticamente;  
                                      setTimeout(function(){
                                        window.location.reload(1);
                                    }, 2000);
                                                            
                              }else if(response == '0'){
                                console.log(response);
                              }
                            }
              });
          });

          /*faz logout no sistema*/
          $( "#logout" ).click(function() { 
            window.location.href = '../index.php';    
          });
        
          /*faz o filtro manipulando o html*/
          $( "input[name='situacao_coleta']" ).click(function() { 
            var qtd_linhas = 0;
                var situacao_radio = $("input[name='situacao_coleta']:checked").val();
                $("#coletasColetor tbody tr").each(function(){                  
                    var situacao_table =  $(this).find( ".status" ).text();
                    if(situacao_radio == 'TODOS'){
                      qtd_linhas++;
                        location.reload();
                    }else if(situacao_radio != situacao_table){
                        $(this).hide();
                    }else{
                        $(this).show();
                        qtd_linhas++;
                    }
                });
                  /*SE A TABELA NÃO TIVER RESULTADOS, MOSTRA O ALERTA*/
                  if(qtd_linhas == 0){
                                $('#alert_table').show();          
                            }else{
                                $('#alert_table').hide();
                            }
          });
          /*fim manipulação filtros*/
    });
</script>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="azure" data-background-color="white" data-image="../../bootstrap-css-js/assets/img/side.jpg">
      <div class="logo">
       <a href="#" class="simple-text logo-normal">     
            <img src="../../imagens/trashall.png">
            <br>
              <?php echo $_SESSION['tipo_entidade']; ?> 
          </a>
      </div>
      <div class="sidebar-wrapper">
      <ul class="nav">
            <li class="nav-item ">
                <a class="nav-link" href="pageDashboard.php">
                  <i class="material-icons">dashboard</i>
                  <p>Dashboard</p>
                </a>
              </li>
         
          <li class="nav-item">
            <a class="nav-link" href="solicitacoes_coletor.php">
              <i class="material-icons">remove_red_eye</i>
              <p>Acompanhar Solicitações</p>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="coletas_coletor.php">
              <i class="material-icons">list</i>
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
                 
                <small class="text-muted">Minhas Coletas</small>
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
      
        <!-- End Navbar -->
      
          <!-- inicio dos filtros -->

          <br><br><br><br>

                  <!-- MONTA OS RADIOBUTTONS -->
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="todos" name="situacao_coleta" value="TODOS" checked>
                    <label style='color:black;' class="custom-control-label" for="todos">TODOS</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="emAndamento" name="situacao_coleta" value="EM ANDAMENTO">
                    <label style='color:black;' class="custom-control-label" for="emAndamento">EM ANDAMENTO</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="finalizada" name="situacao_coleta" value="FINALIZADA">
                    <label style='color:black;' class="custom-control-label" for="finalizada">FINALIZADA</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" id="cancelada" name="situacao_coleta" value="CANCELADA">
                    <label style='color:black;' class="custom-control-label" for="cancelada">CANCELADA</label>
                  </div>
          
          <br>

          <!-- fim dos filtros -->

      <div class="table-responsive col-md-12">
        <table id="coletasColetor" class="table table-striped" cellspacing="0" cellpadding="0">
        <?php
            include '../init.php';
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
                        echo "<th>Peso</th>";
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
                            echo "<td class='status'>";
                                    echo $row['status'];
                            echo "</td>";
                            echo "<td>";
                                    echo date('d/m/Y H:i:s',strtotime($row['data_coleta']) - 10800);
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

                 $count = $stmt->rowCount();
                 if($count == 0){
                   /*APOSTO QUE ESSAS POG (RECURSO TÉNICOS)
                   VOCÊS NUNCA VIRAM HEHEHEHE*/
                     echo "
                         <script>
                             $(document).ready(function(){
                                 $('#alert_table').show(); 
                             });
                         </script>
                     ";
                 }
            }catch(PDOException $erro_2){
                echo 'erro'.$erro_2->getMessage();       
            }
        ?>
         </table> 
     </div>
     <div style='display:none;' id="alert_table">            
        <div class="alert alert-warning" role="alert"> Nenhum registro encontrado!</div>
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


<!-- Modal -->
<div class="modal fade" id="modalRatings" tabindex="-1" role="dialog" aria-labelledby="modalRatings" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRatings">Avalie a coleta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <style>
            *{
                margin: 0;
                padding: 0;
            }
            .rate {
                float: left;
                height: 46px;
                padding: 0 10px;
            }
            .rate:not(:checked) > input {
                position:absolute;
                top:-9999px;
            }
            .rate:not(:checked) > label {
                float:right;
                width:1em;
                overflow:hidden;
                white-space:nowrap;
                cursor:pointer;
                font-size:30px;
                color:#ccc;
            }
            .rate:not(:checked) > label:before {
                content: '★ ';
            }
            .rate > input:checked ~ label {
                color: #ffc700;    
            }
            .rate:not(:checked) > label:hover,
            .rate:not(:checked) > label:hover ~ label {
                color: #deb217;  
            }
            .rate > input:checked + label:hover,
            .rate > input:checked + label:hover ~ label,
            .rate > input:checked ~ label:hover,
            .rate > input:checked ~ label:hover ~ label,
            .rate > label:hover ~ input:checked ~ label {
                color: #c59b08;
        }

      </style>
      <div class="rate">
            <input type="radio" id="star5" name="rate" value="5" />
            <label for="star5" title="Muito bom">5 stars</label>
            <input type="radio" id="star4" name="rate" value="4" />
            <label for="star4" title="Bom">4 stars</label>
            <input type="radio" id="star3" name="rate" value="3" />
            <label for="star3" title="Regular">3 stars</label>
            <input type="radio" id="star2" name="rate" value="2" />
            <label for="star2" title="Ruim">2 stars</label>
            <input type="radio" id="star1" name="rate" value="1" />
            <label for="star1" title="Muito Ruim">1 star</label>
           
        </div>
        <!-- gambiarra para avaloar a coleta -->
        <input type="hidden" name='id_coleta_ratings'>
      </div>
      <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>  
      </div>
    </div>
  </div>
</div>


</body>
</html>

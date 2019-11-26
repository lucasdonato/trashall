<!DOCTYPE html>
<html lang="pt">

<head>
    <?php
          include "../bibliotecas.php";
          session_start();
    ?>
</head>
<style>

  table>td{
    font-weight:bold;
  }

</style>
<script type="text/javascript">
			$(document).ready(function(){
				$('#formFazSolicitacao').submit(function(){					
					var data = $("#formFazSolicitacao").serialize();
					$.ajax({
						type : 'POST',
						url  : '../faz_solicitacao.php',
						data : data,
						dataType: 'json',
						success: function( response )
						{		
              if(response == '1'){
                    
                Swal.fire({
                    type: 'success',
                    title: 'Solicitação enviada ao coletor!',
                    text: "Você pode acompanhar suas solicitações no menu 'Acompanhar Solicitações'",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, acessar!',
                    cancelButtonText: 'Não, obrigado!'
                  }).then((result) => {
                    if (result.value) {
                      /*caso o cliente queira trocar de página
                      será feito com o timeout de 1,5 segundos*/
                      setTimeout(function() {
                          window.location.href = "./solicitacoes_condominio.php";
                      }, 1500);
                    }else{
                      /*recarrega a página para
                      limpar os dados do modal*/ 
                      location.reload();
                    }
                  })  
                  
						    }
                /*fecha o modal após o ajax realizar
                a requisição*/
                $('#modalColetor').modal('hide');
            }
					});
					return false;
        });

        $( "#logout" ).click(function() { 
          window.location.href = '../index.php';      
        });
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
            <li class="nav-item">
                <a class="nav-link" href="pageDashboard.php">
                  <i class="material-icons">dashboard</i>
                  <p>Dashboard</p>
                </a>
              </li>
          
          <li class="nav-item">
            <a class="nav-link" href="solicitacoes_condominio.php">
              <i class="material-icons">remove_red_eye</i>
              <p>Acompanhar Solicitações</p>
            </a>
          </li>
          <li class="nav-item active">
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
                 
                <small class="text-muted">Solicitar Coleta</small>
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
        
          <script>
              $(document).ready(function(){
                $("#pesquisa_coletor").on("keyup", function() {
                  var value = $(this).val().toLowerCase();
                  $("#list_coletores tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                  });
                });
              });     

              /*responsável por popular os campos do modal com as 
              informações sobre o coletor*/
              $(document).ready(function() {
                  $("tr").click(function() { //ação disparada ao clicar na linha da tabela

                      $("#nomeempresa").text($(this).find('td[name="nomeempresa"]').html());
                      $("#contato").text($(this).find('td[name="contato"]').html());
                      $("#materiais_coletados").text($(this).find('td[name="materiais_coletados"]').html());
                      $("#logradouro").text($(this).find('td[name="endereco"]').html());
                      $("#txtIdCondominio").val($(this).find('td[name="id_coletor_coluna"]').html());
                      
                  });
              });
              
            </script>
            
      </div><br>


      <div class="modal fade" id="modalColetor" tabindex="-1" role="dialog" aria-labelledby="TituloModalLongoExemplo" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="TituloModalLongoExemplo">Nova Solicitação</h5>
              </div>
              <div style='margin:0 auto 0 auto;' id="conteudo-solicitacao">  
              <fieldset>
                      <legend>Informações coletor</legend>
                  </fieldset>
                <form id="formFazSolicitacao" action="" method="post">   
                  Nome: <span class="font-weight-light" id="nomeempresa"></span>
                  <br>
                  Contato: <span class="font-weight-light" id="contato"></span>
                  <br>
                  Materiais coletados: <span class="font-weight-light" id="materiais_coletados"></span>
                  <br>
                  Endereço: <span class="font-weight-light" id="logradouro"></span>
                  <br><hr>  
                  
                  <!-- CAMPO OCULTO PARA ESCONDER O
                  ID DO CONDOMINIO -->
                  <fieldset>
                      <legend>Dados coleta:</legend>
                  </fieldset>
                  Peso aproximado em KG: <input name="txtPesoAproximado" required form-control type="number">
                  <br>
                  <input type="text" style="display:none;" class="font-weight-light" name="txtIdCondominio" id="txtIdCondominio">

                  Quais são os materias que serão coletados? :<br>

                      <!-- Default checked -->
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="checkMaterial[]" value="papel" class="custom-control-input" id="checkPapel">
                        <label class="custom-control-label" for="checkPapel">Papel</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="checkMaterial[]" value="plastico" class="custom-control-input" id="checkPlastico">
                        <label class="custom-control-label" for="checkPlastico">Plástico</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="checkMaterial[]" value="metal" class="custom-control-input" id="checkMetal">
                        <label class="custom-control-label" for="checkMetal">Metal</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="checkMaterial[]" value="vidro" class="custom-control-input" id="checkVidro">
                        <label class="custom-control-label" for="checkVidro">Vidro</label>
                      </div>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="checkMaterial[]" value="orgânico" class="custom-control-input" id="checkAluminio">
                        <label class="custom-control-label" for="checkAluminio">Orgânico</label>
                      </div>   
                    
                      <div class="form-group">
                          <textarea class="form-control" placeholder='Alguma observação?' name="obs_solicitacao" rows="3"></textarea>
                        </div>

                  </div>
                  <div class="modal-footer">
                    <input type="submit" id="btnEnviaSolicitacao" value="Solicitar" class="btn btn-success">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>                    
                  </div>
              </form> 
            </div>   
          </div>
      </div>

    <label for="formGroupExampleInput">Pesquisar:</label>
    <input type="text" class="form-control" id="pesquisa_coletor" placeholder="Faça sua busca">

    <div class='col-lg-6 col-md-12'>
              <div class='card'>
                <div class='card-header card-header-info'>
                  <h4 class='card-title'>Coletores disponíveis</h4>
                  <p class='card-category'>Escolha abaixo um coletor para coletar o seu lixo!</p>
                </div>
                <div class='card-body table-responsive'>
                  <table id='list_coletores' class='table-hover'>
                    <?php
                          require_once '../init.php';
                          $PDO = db_connect();
                          try{
                            $sql = "SELECT ce.id_coletor,ce.nome_empresa,ce.materiais_coletados,ct.descricao,
                                      e.logradouro,e.bairro,e.numero
                                    FROM coletor_empresa ce
                                    LEFT JOIN endereco e ON ce.id_coletor = e.id_coletor 
                                    LEFT JOIN contato ct ON ce.id_coletor = ct.id_coletor
                                    ORDER BY data_cadastro DESC";
                              $stmt = $PDO->prepare($sql);
                              $stmt->execute();

                                echo "<thead class='text-info'>";
                                  echo "<th>Nome Coletor</th>";

                                  //colunas ocultas na listagem
                                  echo "<th style='display:none;'>Login</th>"; 
                                  echo "<th style='display:none;'>Materiais reciclados</th>"; 
                                  echo "<th style='display:none;'>Logradouro</th>"; 
                                  echo "<th style='display:none;'>id_coletor</th>";
                                echo "<thead class='text-info'>";
                              
                              //constroí a tabela
                              while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr data-toggle='modal' data-target='#modalColetor'>";
                                  echo " <td name='nomeempresa'>";
                                  echo $row['nome_empresa'];
                                  echo "</td>";  
                                  echo " <td name='contato' style='display:none;'>";
                                  if($row['descricao'] != ''){
                                    echo $row['descricao'];
                                  }else{
                                    echo "";
                                  }
                                  echo "</td>";  
                                  echo " <td name='materiais_coletados' style='display:none;'>";
                                  $ma = json_decode($row['materiais_coletados']);
                                  foreach ($ma as $value) {
                                    echo $value.", ";
                                  } 
                                  echo "</td>";     

                                  /*esses ids precisam ser ocultos
                                  servem apenas para inserir na tabela de solicitações*/                          
                                  echo " <td name='id_coletor_coluna' style='display:none;'>";
                                  echo $row['id_coletor'];
                                  echo "</td>";     

                                  echo " <td name='endereco' style='display:none;'>";
                                  if($row['logradouro'] != ''){
                                    
                                    echo $row['logradouro'].', '. $row['numero']. ', '. $row['bairro'];
                                  }else{
                                    echo "";
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

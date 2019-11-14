<!DOCTYPE html>
<html lang="pt">
<script src="../script.js"></script>
<script src = "https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> 
  <?php 
    include '../bibliotecas.php';
    session_start(); 
    
  ?>
<head>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../../bootstrap-css-js/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../../bootstrap-css-js/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Trashall
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../bootstrap-css-js/assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../../bootstrap-css-js/assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="azure" data-background-color="white" data-image="../../bootstrap-css-js/assets/img/side.jpg">
      <div class="logo">
        <a href="#" class="simple-text logo-normal">TrashAll 
          <br>          
          
        </a>
      </div>
      <div class="sidebar-wrapper">
      <ul class="nav">
            <li class="nav-item active">
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
     
      </nav>
      <!-- End Navbar -->


      <?php
      require '../init.php';

      //solicitações
      $total_solicitacoes_rejeitadas_dashboard_condominio = total_solicitacoes_rejeitadas_dashboard_condominio($_SESSION['id_condominio']);
      $total_solicitacao_emaberto_dashboard_condominio = total_solicitacao_emaberto_dashboard_condominio($_SESSION['id_condominio']);
      $total_solicitacoes = total_solicitacoes_dashboard_condominio($_SESSION['id_condominio']);
      $total_solicitacoes_confirmadas = total_solicitacoes_confirmadas_dashboard_condominio($_SESSION['id_condominio']);

      //coletas
      $total_coletas = total_coletas_dashboard_condominio($_SESSION['id_condominio']);
      $total_coletas_concluidas = total_coletasFinalizadas_dashboard_condominio($_SESSION['id_condominio']);
      $total_coletas_canceladas_dashboard_condominio = total_coletas_canceladas_dashboard_condominio($_SESSION['id_condominio']);
      $total_coletas_andamento_dashboard_condominio = total_coletas_andamento_dashboard_condominio($_SESSION['id_condominio']);
    
  ?>

      <!-- inicio dashboards -->
      <br><br><br><br><br><br><br>

      <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">restore_from_trash</i>
                  </div>
                  <p class="card-category">Total solicitações</p>
                  <h2 class="card-title"><?php echo $total_solicitacoes ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
       </div>

       <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">timer</i>
                  </div>
                  <p class="card-category">Solicitações em aberto</p>
                  <h2 class="card-title"><?php echo $total_solicitacao_emaberto_dashboard_condominio ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
      </div>

       <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">cancel</i>
                  </div>
                  <p class="card-category">Solicitações rejeitadas</p>
                  <h2 class="card-title"><?php echo $total_solicitacoes_rejeitadas_dashboard_condominio ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">check_box</i>
                  </div>
                  <p class="card-category">Solicitações confirmadas</p>
                  <h2 class="card-title"><?php echo $total_solicitacoes_confirmadas ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
       </div>

      <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">restore_from_trash</i>
                  </div>
                  <p class="card-category">Total coletas</p>
                  <h2 class="card-title"><?php echo $total_coletas ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
        </div>

       <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">timer</i>
                  </div>
                  <p class="card-category">Coletas em andamento</p>
                  <h2 class="card-title"><?php echo $total_coletas_andamento_dashboard_condominio ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
       </div>

       <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">cancel</i>
                  </div>
                  <p class="card-category">Coletas canceladas</p>
                  <h2 class="card-title"><?php echo $total_coletas_canceladas_dashboard_condominio ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
          </div>   
       
      <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">check_box</i>
                  </div>
                  <p class="card-category">Coletas concluídas</p>
                  <h2 class="card-title"><?php echo $total_coletas_concluidas ?></h2>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">date_range</i> Período total
                  </div>
                </div>
              </div>
       </div>
  
      
    <!-- FIM DASHBOARDS -->

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

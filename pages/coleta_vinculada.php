<?php
        session_start();
        require 'init.php';          
        
        /*RECUPERA O ID DA solicitacao VIA GET
        PARA RECUPERAR A COLETA CERTA E MONTAR 
        A TABELA NO MODAL*/
        $id_solicitacao = $_GET['id_solicitacao'];
        $PDO = db_connect();

        $sql = "SELECT ca.*,cole.nome_empresa,cont.descricao,s.peso,s.materiais_coletados FROM coleta_andamento ca
                JOIN solicitacoes s ON ca.id_solicitacao = s.id_solicitacao
                JOIN coletor_empresa cole ON cole.id_coletor = ca.id_coletor
                JOIN contato cont ON cont.id_coletor = ca.id_coletor
                WHERE ca.id_solicitacao = :id_solicitacao"; 


        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id_solicitacao', $id_solicitacao);

            if($stmt->execute()){

                  /*PEGA A QUANTIDADE DE LINHAS
                  QUE FORAM ATINGIDAS PELA CONSULTA
                  PARA VALIDAÇÃO*/
                  $count = $stmt->rowCount();

                  /*SÓ MONTA A TABELA SE EXISTIR
                  DADOS*/
                  if($count > 0){
                        echo '<table class="table table-striped" cellspacing="0" cellpadding="0">';
                              try{     
                                    echo "<thead>";                  
                                          echo "<th>Data coleta</th>";  
                                          echo "<th>Materiais da coleta</th>"; 
                                          echo "<th>Peso</th>";
                                          echo "<th>Coletor</th>"; 
                                          echo "<th>Contato</th>"; 
                                    echo "</thead>";               

                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>";
                                          echo date('d/m/Y H:i:s',strtotime($row['data_coleta']));                             
                                    echo "</td>";
                                    echo "<td>";
                                          echo $row['materiais_coletados'];                  
                                    echo "</td>"; echo "<td>";
                                          echo $row['peso']. ' KG';
                                    echo "</td>"; echo "<td>";
                                          echo $row['nome_empresa'];                   
                                    echo "</td>"; echo "<td>";
                                          echo $row['descricao'];               
                                    echo "</td>";
                                    echo "</tr>";
                                    }

                              }catch(PDOException $erro_2){
                                    echo 'erro'.$erro_2->getMessage();       
                              } 
                        echo "</table>"; 
                  }else{
                        echo '<div class="alert alert-warning" role="alert">';
                        echo 'Sem informações de coleta para essa solicitação.';
                        echo '</div>'; 
                  }
                
        }else{
                var_dump($stmt->errorInfo());
        }
?>
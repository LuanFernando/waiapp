<?php

/**
 * Endpoint FinanceManager.php
 * Created in 2023-11-02 by Luan Fernando
 * HTTP : GET /POST /DELETE / UPDATE
 * */ 

include_once('../connection.php');

 if($_SERVER['REQUEST_METHOD'] === 'GET'){

    if($_GET['action'] == 'infoMensalidade'){
        $idAluno = $_GET['idAluno'];

        if($idAluno > 0){
             
            try {
                    # Lista todos os anos que o aluno tem mensalidades no sistema
                    // Preparar a declaração SQL
                    $stmt = $conn->prepare("SELECT DISTINCT DATE_FORMAT(dataVencimento, '%Y') As year 
                    FROM monthly_payment 
                    WHERE idAluno = ?
                    ORDER BY year DESC ");
            
                    // Vincular os parâmetros
                    $stmt->bind_param("i", $idAluno);

                    // Executar a consulta
                    $stmt->execute();
                
                } catch (\Exception $e) {
                    echo $e;
                }

                // Obter resultados
                $result = $stmt->get_result();
                
                if($result != null){
                    $pago = 0;
                    $pendente = 0;
                    $desconto = 0;

                    # option de anos que contem mensalidades do aluno
                    $optionYear = "<option value=''></option>";
                    while ($row = $result->fetch_assoc()) {
                        $optionYear .= "<option value='{$row['year']}'>{$row['year']}</option>";
                    }
    
                    # Valores Pagos/Pendentes do aluno
                    $queryConsult2 = "SELECT * FROM monthly_payment WHERE idAluno = ?";
                    $stmt2 = $conn->prepare($queryConsult2);
                    $stmt2->bind_param("i", $idAluno);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
    
                    if($result2->num_rows > 0){
                        while ($row = $result2->fetch_assoc()) {
                            
                            if($row['dataPagamento'] != null && $row['idUsuarioBaixa'] != null && $row['status_pagamento'] == 'pago'){
                                $pago += $row['valor'];
                            } else if($row['dataPagamento'] == null && $row['idUsuarioBaixa'] == null && $row['status_pagamento'] == 'pendente'){
                                $pendente += $row['valor'];
                            }
                        }
                    }
                
                    $response = [
                        'warning' => 0, 
                        'error' => 0, 
                        'success' => 1, 
                        'message' => null,
                        'optionYear' => $optionYear, 
                        'pago' => 'R$ '.number_format($pago, 2 , ',' , '.'),
                        'pendente' => 'R$ '.number_format($pendente, 2 , ',' , '.'),
                        'desconto' => 'R$ '.number_format($desconto, 2 , ',' , '.')
                    ];
                    echo json_encode($response);
                } else{
                    $optionYear = "<option value=''></option>";
    
                    // Aluno não tem nenhuma ,mensalidade no sistema
                    $response = [
                        'warning' => 0, 
                        'error' => 0, 
                        'success' => 1, 
                        'message' => null,
                        'optionYear' => $optionYear,
                        'pago' => 0,
                        'pendente' => 0,
                        'desconto' => 0
                    ];
                    echo json_encode($response);
                }

        } else {
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel identificar o ID do usuário!'];
            echo json_encode($response);
        }
    } else if($_GET['action'] == 'mensalidadePorAno'){
        $idAluno = $_GET['idAluno'];
        $ano = $_GET['ano'];
        $table = ""; 

        if($idAluno > 0){

            try {
                // Preparar a declaração SQL
                $stmt = $conn->prepare("SELECT 
                mp.id ,
                mp.valor As Valor,
                DATE_FORMAT(mp.dataVencimento ,'%d/%m/%Y') As DataVencimento,
                DATE_FORMAT(mp.dataPagamento ,'%d/%m/%Y') As DataPagamento,
                mp.formaPagamento As FormaPagamento,
                COALESCE((SELECT u.name FROM user u WHERE u.id = mp.idUsuarioBaixa), '') As UsuarioBaixa,
                mp.observacoes As Observacaoes,
                mp.status_pagamento As Status 
                FROM monthly_payment mp
                WHERE mp.idAluno = ? AND DATE_FORMAT(mp.dataVencimento,'%Y') = ?
                ORDER BY mp.id ASC");
        
                // Vincular os parâmetros
                $stmt->bind_param("ii", $idAluno , $ano);

                // Executar a consulta
                $stmt->execute();
            
            } catch (\Exception $e) {
                echo $e;
            }

             // Obter resultados
             $result = $stmt->get_result();
                
             if($result != null){

                $table .= "<table class='table' id='tableMensalidades'>";
                $table .= "<thead>";
                $table .= "<tr>";
                $table .= "<th width='6%'>Data Vencimento</th>";
                $table .= "<th width='6%'>Data Pagamento</th>";
                $table .= "<th width='6%'>Valor (R$)</th>";
                $table .= "<th width='6%'>Forma Pagamento</th>";
                $table .= "<th width='20%'>Usuário Baixa</th>";
                $table .= "<th width='10%'>Observações</th>";
                $table .= "<th width='6%'>Status</th>";
                $table .= "<th width='30%'>Opções</th>";
                $table .= "</tr>";
                $table .= "</thead>";

                $table .= "<tbody>";
                
                while ($row = $result->fetch_assoc()) {

                    $valor = number_format($row['Valor'], 2 , ',' , '.');

                    $table .= "<tr>";
                    $table .= "<td>{$row['DataVencimento']}</td>";
                    $table .= "<td>{$row['DataPagamento']}</td>";
                    $table .= "<td>{$valor}</td>";
                    $table .= "<td>{$row['FormaPagamento']}</td>";
                    $table .= "<td>{$row['UsuarioBaixa']}</td>";
                    $table .= "<td>{$row['Observacaoes']}</td>";
                    $table .= "<td>{$row['Status']}</td>";
                    $table .= "<td class='td-actions'>";
                        $table .= "<a href='#' data-id='{$row['id']}' onclick='pagarMensalidade({$row['id']})' class='btn-mensalidade-pagar'>Pagar</a>";
                        $table .= "<a href='#' data-id='{$row['id']}' onclick='cancelarMensalidade({$row['id']})' class='btn-mensalidade-cancelar'>Cancelar</a>";
                    $table .= "</td>";
                    $table .= "</tr>"; 
                }

                $table .= "</tbody>";
                $table .= "</table>";
             }

             $response = ['warning' => 0, 'success' => 1, 'error' => 0 ,'message' => null , 'table' => $table , 'script' => null];
             echo json_encode($response);

        } else{
            $response = ['warning' => 0, 'error' => 1, 'success' => 0, 'message' => 'Não foi possivel identificar o ID do usuário!'];
            echo json_encode($response);
        }
    }

 } else if($_SERVER['REQUEST_METHOD'] === 'POST'){

 }
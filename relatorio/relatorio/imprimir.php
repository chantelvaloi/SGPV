<?php

// Carregar o Composer
require './vendor/autoload.php';

// Incluir conexao com BD
include_once './conexao.php';

// QUERY para recuperar os registros do banco de dados
$query_usuarios = "SELECT codigo_utente, nome_utente, email FROM utente";

// Prepara a QUERY
$result_usuarios = $conn->prepare($query_usuarios);

// Executar a QUERY
$result_usuarios->execute();

// Informacoes para o PDF
$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
//$dados .= "<link rel='stylesheet' href='http://localhost/celke/css/custom.css'";
$dados .= "<title> Gerar PDF</title>";
$dados .= "</head>";
$dados .= "<body>";
$dados .= "<h1>Realtorio Mensal</h1>";
$dados .= "";

// Ler os registros retornado do BD
while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
    //var_dump($row_usuario);
    extract($row_usuario);
    $dados .= "ID: $codigo_utente <br>";
    $dados .= "Nome: $nome_utente <br>";
    $dados .= "E-mail: $email <br>";
    $dados .= "<hr>";
}

//$dados .= "<img src='imagens/celke.jpg'><br>";
$dados .= "</body>";
$dados .= "</html>";


// Referenciar o namespace Dompdf
use Dompdf\Dompdf;

// Instanciar e usar a classe dompdf
$dompdf = new Dompdf(['enable_remote' => true]);

// Instanciar o metodo loadHtml e enviar o conteudo do PDF
$dompdf->loadHtml($dados);

// Configurar o tamanho e a orientacao do papel
// landscape - Imprimir no formato paisagem
//$dompdf->setPaper('A4', 'landscape');
// portrait - Imprimir no formato retrato
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Gerar o PDF
$dompdf->stream();
//nadminhub-master\relatorio\relatorio\gerar_pdf.php
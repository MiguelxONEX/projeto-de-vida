<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto de vida</title>
    <link rel="stylesheet" href="../vida/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <div class="container">
        <nav class="nav-menu">
            <div class="logo">
                <img src="../vida/gggggg.png" alt="Logo">
            </div>
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="menu-content">
                <ul class="nav-list">
                    <li><a href="../vida/index.html">Início</a></li>
                    <li><a href="../vida/profissao.html">Profissão</a></li>
                    <li><a href="teste-de-personalidade-base/index.php">Teste de Personalidade</a></li>
                    <li><a href="../vida/soueu.html">Quem sou eu?</a></li>
                    
                </ul>
            </div>
        </nav>
        <div>
<?php

function getDataFrom16PersonalitiesLink($Link){
    $raw_page = file_get_contents($Link);

    $start_data_needle = ':data="';
    $loc_start_data =  strpos($raw_page,$start_data_needle);

    $data_with_rest_of_page = substr($raw_page, $loc_start_data+strlen($start_data_needle));

    $loc_start_rest_of_page = strpos($data_with_rest_of_page,'fullTypeHtml');

    $data_raw = substr($data_with_rest_of_page, 0, $loc_start_rest_of_page-7);
    $data_raw = $data_raw. "}";
    $data_raw = html_entity_decode($data_raw);


    $data = json_decode($data_raw, true, 512, JSON_THROW_ON_ERROR);
    return $data;
}

$gender = $_POST['gender'];
$answers = [];

$random_answer_override = false;

if($random_answer_override == false){
    foreach($_POST as $key => $value){
        if($key != "gender"){
            array_push($answers,[
                "id" => $key,
                "value" => intval($value)
            ]);
        }
    }
}else{
    foreach($_POST as $key => $value){
        if($key != "gender"){
            array_push($answers,[
                "id" => $key,
                "value" => rand(-3,3)
            ]);
        }
    }
}

$final_result = [
    "answers" => $answers,
    "gender" => $gender
];

$url = "http://localhost:14140/api/personality/submit";
// Initialize cURL session
$ch = curl_init($url);

// Setup request
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($final_result));

// Execute request
$responseraw = curl_exec($ch);


// Close session
curl_close($ch);

$response = json_decode($responseraw,true);

$data = getDataFrom16PersonalitiesLink($response['ogLink']);
?>


<?php
$jsonAnim = file_get_contents($data['avatar']['staticBodyJson']);
$svgData = file_get_contents($data['avatar']['staticBodyPath']);
?>

<!-- FOTINHA DO PERSONAGEM EM PÉ -->
<div id="lottie-animation" style="width:400px">
    <?=$svgData?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.5/lottie.min.js"></script>
<script src="handleLottieAnim.js"></script>
<script>
    initAnim('<?=$jsonAnim?>');
</script>


<!-- NOME DA PERSONALIDADE -->
<p><?=$data['personalityShort']?></p>
<!-- LINK DA PERSONALIDADE 16Personalities -->
<a href="<?=$response['ogLink']?>">Link da personalidade no site oficial da 16Personalities</a>
<br>
<!-- LINK DA INFORMAÇÃO EM 16Personalities -->
<a href="<?=$data['personalityLink']?>">Saiba mais sobre essa personalidade no site 16Personalities</a>
<!-- PONTUAÇÃO DA PERSONALIDADE -->
<div style='display:flex; flex-direction:column; width: 500px;'>
    <?php foreach($data['details']['traits'] as $trait):?>
        <p><?=$trait['pct']. "% " . $trait['trait']?></p>
        <div style="width: 100%; height: 10px; background-color: lightgray; border-radius: 500px; overflow:none;">
            <div style="background-color:<?=$trait['color']?>; width:<?=$trait['pct']?>%; opacity:0.5; height:100%; border-radius: 500px;">

            </div>
        </div>
    <?php endforeach;?>
</div>
</div>
<script src="../vida/script.js"></script>
</html>
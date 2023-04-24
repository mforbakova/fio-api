<?php

use App\SendMoney;
use App\ShowBalance;
use Symfony\Component\Dotenv\Dotenv;

require_once('vendor/autoload.php');

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

// echo $_ENV['APP_NAME'];
$error = '';
$poslat = '';
$balance = '';
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    try
    { 
        if(!is_numeric($_POST['sender']) && !is_numeric($_POST['amount']) && !is_numeric($_POST['account']) && null == ($_POST['amount']))
        {
            throw new Exception('Zadaná nečíselná hodnota!');
        }
        
        if(preg_match('/(([0-9]){10,10}\/([2][0][1][0]))$/', $_POST['sender'])) {
            $accountFrom = $_POST['sender'];

            if(preg_match('/((([0-9]){0,7}-?[0-9]){10,10}\/([0-9]){4,4})/', str_replace(' ', '', $_POST['account'])))
            {
            $account = $_POST['account'];
            $amount = trim($_POST['amount']);
            $sendMoney = new SendMoney();
            $sendMoney->sendMoney($accountFrom, $account, $amount);
            echo "Peniaze odoslané";
            }
        }
        else {
            throw new Exception('Neplatné číslo účtu');
        }        
    }

    catch (Exception $e) {
        $error= $e->getMessage();
    };
}

?><!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Download Bootstrap to get the compiled CSS and JavaScript, source code, or include it with your favorite package managers like npm, RubyGems, and more.">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Hugo 0.98.0">

        <meta name="docsearch:language" content="en">
        <meta name="docsearch:version" content="5.2">
        <title>IB fio</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </head>
    <body>  
        <div class="m-5">
            <?php
                $showBalance = new ShowBalance();
                echo '<br>';
                echo $showBalance->getBalance();
            ?></div><hr>
                <h2 class="error text-danger ms-4"><?= $error ?></h2>
                <div class="col-sm-6 m-5">
                    <form action="index.php" method="post" class="shadow p-3 mb-5 bg-body rounded"><br>
                        Z účtu:<br />
                        <p class="small">Zadávajte číslo účtu vo formáte: "xxxxxxxxxx/2010"</p>
                        <input type="text" name="sender"><br /><br />
                        Na účet:<br />
                        <p class="small">Zadávajte číslo účtu vo formáte: "xxxxxxxxxx/xxxx" alebo s predčíslím</p>
                        <input type="text" name="account"><br /><br />
                        Koľko kč chcete poslať? <br />
                        <input type="number" name="amount"><br /><br />
                        <input type="submit">
                    </form>   
                </div>
            <div class="col-sm-6 m-5">
                <br>
                <?= $poslat; ?>
            </div>
        </div>
        <hr>
    </body>
</html>
 
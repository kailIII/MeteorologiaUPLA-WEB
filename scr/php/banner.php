<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="../js/actualizarIndex.js"></script>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap-theme.min.css">
</head>
<body>

<div class="row hidden-xs" style="padding-bottom: 10px;">
    <div class="col-md-10 col-md-offset-1 col-sm-12 " style=" padding-bottom: 7px; border-bottom: 1px solid ">
        <div class="col-md-4 col-sm-4">
            <img src="scr\img\uplafi.png"/>
        </div>
        <div class="col-md-4 col-sm-4">
            <img src="scr\img\armada.png"/>
        </div>
        <div class="col-md-4 col-sm-4">
            <img src="scr\img\conaf.png"/>
        </div>
    </div>
</div>

<?php
$lat='-33.7886';
$lon='-71.6873';

$sun_info = date_sun_info(strtotime("now"),$lat ,$lon );
date_default_timezone_set('America/Santiago');
include "moon.php";

$sunrise = date("H:i",$sun_info['sunrise']);
$sunset = date("H:i",$sun_info['sunset']);
$civil_twilight_begin = date("H:i",$sun_info['civil_twilight_begin']);
$civil_twilight_end = date("H:i",$sun_info['civil_twilight_end']);

$m=date('m');
$d=date('d');
$y=date('Y');

$moon=Moon::calculateMoonTimes($m,$d,$y,  $lat, $lon);

$moonrise1 = date("H:i",$moon->moonrise );
$moonrise = date("H:i", strtotime("$moonrise1 + 1 hours"));

$moonset1 = date("H:i",$moon->moonset);
$moonset = date("H:i", strtotime("$moonset1 + 1 hours"));

//Calculo de intervalo de horas
function resta($inicio, $fin)
{
    $dif=date("H:i", strtotime("00:00") + strtotime($fin) - strtotime($inicio) );
    return $dif;
}

$dur_de_dia=resta($sunrise,$sunset);
$luz_de_dia=resta($civil_twilight_begin,$civil_twilight_end);

?>

<div class="row" style="padding-top: 5px; padding-bottom: 20px">

    <div class="col-md-10 col-md-offset-1">

        <div class="col-md-3">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13269.836758480427!2d-71.6968742!3d-33.7487981!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzPCsDQ0JzU2LjAiUyA3McKwNDInMDAuMCJX!5e0!3m2!1ses-419!2scl!4v1443649161129"
                    iframe width="100%" height="245px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  style="border:0" allowfullscreen></iframe>
        </div>

        <div class="col-md-9 ">
            <div class="row">

                <div class="row">
                    <div class="col-md-12">
                        <h4>
                            <strong>
                                Estación Meteorológica El Yali
                            </strong>
                        </h4>
                    </div>
                 </div>

                <div class='row' >
                    <div class="col-md-12">
                        <p class="text-justify">
                            La facultad de Ingeniería de la Universidad de Playa Ancha en colaboración con la Dirección de Meteorologia de la Armada de Chile y la Corporación Nacional Forestal (CONAF) se encuentra habilitando estaciones meteorológicas Davis en diferentes áreas protegidas de la Región de Valparaiso. </br>
                            La estación meteorológica en uso es el Davis Vantage Pro2, y estas paginas se actualizan cada 5 minutos. El dia meteorológico utilizado en esta estación termina a la medianoche.</p><br>
                    </div>
                </div>

                <!-- Fases lunares y solares -->

                    <div class="row">

                        <div class="col-md-3 col-xs-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-justify"><strong>Amanecer:</strong>

                                    <?php echo ' '.$civil_twilight_begin;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-justify"><strong>Anochecer:</strong>

                                    <?php echo ' '.$civil_twilight_end;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-justify"><strong>Luz del dia:</strong>

                                    <?php echo ' '.$luz_de_dia;?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-xs-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-justify"><strong>Salida del sol:</strong>
                                    <?php echo ' '.$sunrise;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-justify"><strong>Puesta del sol:</strong>

                                    <?php echo ' '.$sunset;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-justify"><strong>Duración del dia:</strong>

                                    <?php echo ' '.$dur_de_dia;?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xs-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-left"><strong>Salida de la luna:</strong>

                                    <?php echo ' '.$moonrise;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-left"><strong>Puesta de la luna:</strong>
                                    <?php echo ' '.$moonset;?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Fase de la luna:</strong>

                                    <?php
                                    function moon_phase($year, $month, $day)
                                    {
                                        /*
                                        modified from http://www.voidware.com/moon_phase.htm
                                        */
                                        $c = $e = $jd = $b = 0;
                                        if ($month < 3)
                                        {
                                            $year--;
                                            $month += 12;
                                        }
                                        ++$month;
                                        $c = 365.25 * $year;
                                        $e = 30.6 * $month;
                                        $jd = $c + $e + $day - 694039.09;	//jd is total days elapsed
                                        $jd /= 29.5305882;					//divide by the moon cycle
                                        $b = (int) $jd;						//int(jd) -> b, take integer part of jd
                                        $jd -= $b;							//subtract integer part to leave fractional part of original jd
                                        $b = round($jd * 8);				//scale fraction from 0-8 and round
                                        if ($b >= 8 )
                                        {
                                            $b = 0;//0 and 8 are the same so turn 8 into 0
                                        }
                                        switch ($b)
                                        {
                                            case 0:
                                                return 'Luna Nueva';

                                                break;
                                            case 1:
                                                return 'Luna Nueva Visible';

                                                break;
                                            case 2:
                                                return 'Luna Cuarto Creciente';

                                                break;
                                            case 3:
                                                return 'Luna Gibosa Creciente';

                                                break;
                                            case 4:
                                                return 'Luna Llena';

                                                break;
                                            case 5:
                                                return 'Luna Gibosa Menguante';

                                                break;
                                            case 6:
                                                return 'Luna Cuarto Menguante';

                                                break;
                                            case 7:
                                                return 'Luna Menguante';

                                                break;
                                            default:
                                                return 'Error';
                                        }
                                    }
                                    $timestamp = time();

                                    $fase = moon_phase(date('Y', $timestamp), date('n', $timestamp), date('j', $timestamp));
                                    echo $fase;
                                    switch ($fase)
                                    {
                                        case 'Luna Nueva':
                                            $luna='n'                                ;

                                            break;
                                        case 'Luna Nueva Visible':
                                            $luna='n_v'                                ;

                                            break;
                                        case 'Luna Cuarto Creciente':
                                            $luna='c_c'                                ;

                                            break;
                                        case 'Luna Gibosa Creciente':
                                            $luna='g_c'                                ;

                                            break;
                                        case 'Luna Llena':
                                            $luna='ll'                                ;

                                            break;
                                        case 'Luna Gibosa Menguante':
                                            $luna='g_m'                                ;

                                            break;
                                        case 'Luna Cuarto Menguante':
                                            $luna='c_m'                                ;

                                            break;
                                        case 'Luna Menguante':
                                            $luna='m'                                ;

                                            break;
                                        default:
                                            return 'Error';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <img src="scr\img\fase\<?php echo $luna ?>.png" height="100px" class="center-block img-circle"/>
                        </div>
                    </div>

    </div>

</div>

    </div>

</div>



</body>

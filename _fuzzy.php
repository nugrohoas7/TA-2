<?php
function grafikfungsikeanggotaandefence()
{
?>
    
<?php
}
function grafikfungsikeanggotaanheading()
{
?>
    
<?php
}
function grafikfungsikeanggotaanshooting()
{
?>
    
<?php
}
function grafikoutput()
{
?>
   
<?php
}
function gambarrules()
{
?>
    
<?php
}
function nilaigrafikdefence($defence)
{
    if (defenceminimum($defence) != 0) {
        echo "Akurasi Defence Tidak Layak (" . defenceminimum($defence) . ")";
        echo "<br>";
    }
    if (defenceoptimal($defence) != 0) {
        echo "Akurasi Defence Cukup Layak (" . defenceoptimal($defence) . ")";
        echo "<br>";
    }
    if (defencemaksimal($defence) != 0) {
        echo "Akurasi Defence Layak (" . defencemaksimal($defence) . ")";
        echo "<br>";
    }
    echo "<br>";
}
function nilaigrafikheading($heading)
{
    if (tidaklembab($heading) != 0) {
        echo "Akurasi Heading Tidak Layak (" . tidaklembab($heading) . ")";
        echo "<br>";
    }
    if (sangatsesuai($heading) != 0) {
        echo "Akurasi Heading Cukup Layak (" . sangatsesuai($heading) . ")";
        echo "<br>";
    }
    if (lembab($heading) != 0) {
        echo "Akurasi Heading Layak (" . lembab($heading) . ")";
        echo "<br>";
    }
    echo "<br>";
}
function nilaigrafikshooting($shooting)
{
    if (shootingkering($shooting) != 0) {
        echo "Akurasi Shooting Tidak Layak(" . shootingkering($shooting) . ")";
        echo "<br>";
    }
    if (shootingideal($shooting) != 0) {
        echo "Akurasi Shooting Cukup Layak (" . shootingideal($shooting) . ")";
        echo "<br>";
    }
    if (shootingbanjir($shooting) != 0) {
        echo "Akurasi Shooting Layak (" . shootingbanjir($shooting) . ")";
        echo "<br>";
    }
    echo "<br>";
}
function hasilfuzzifikasi($defence, $heading, $shooting)
{
    echo "<h4><b>Hasil Fuzzifikasi: </b></h4>";
    echo "<p><b>Nilai Fuzzy Shooting: </b></p>";
    nilaigrafikdefence($defence);
    echo "<p><b>Nilai Fuzzy Heading: </b></p>";
    nilaigrafikheading($heading);
    echo "<p><b>Nilai Fuzzy Defence: </b></p>";
    nilaigrafikshooting($shooting);
}
function inferensi($defence, $heading, $shooting)
{
    echo "<h4><b>Rules yang digunakan: </b></h4>";
    $x = 0;
    $no = 1;
    $kondisi = [];
    $nilaidefence = [defenceminimum($defence), defenceoptimal($defence), defencemaksimal($defence)];
    $nilaiheading = [tidaklembab($heading), sangatsesuai($heading), lembab($heading)];
    $nilaishooting = [shootingkering($shooting), shootingideal($shooting), shootingbanjir($shooting)];

    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            for ($k = 0; $k < 3; $k++) {
                if (($nilaidefence[$i] > 0) && ($nilaiheading[$j] > 0) && ($nilaishooting[$k] > 0)) {
                    $minimal[$x] = min($nilaidefence[$i], $nilaiheading[$j], $nilaishooting[$k]);
                    if ($k == 0) {
                        $kondisi[$x] = "bek";
                    } else if (($i == 2) && ($k == 1) && ($j < 2)) {
                        $kondisi[$x] = "bek";
                    } else {
                        $kondisi[$x] = "Striker";
                    }
                    echo "<p>" . $no . ". IF Defence = " . $nilaidefence[$i] . " AND Heading = " . $nilaiheading[$j] . " AND Shooting = " . $nilaishooting[$k] . " THAN Posisi Pemain = " . $kondisi[$x] . "(" . $minimal[$x] . ")</p>";
                    $x++;
                }
                $no++;
            }
        }
    }
    //Nilai Fuzzy Output
    $nilai_banyak = 0;
    $nilai_sedikit = 0;
    for ($l = 0; $l < $x; $l++) {
        if ($kondisi[$l]  == "Striker") {
            $nilai_banyak = max($minimal[$l], $nilai_banyak);
        } else {
            $nilai_sedikit = max($minimal[$l], $nilai_sedikit);
        }
    }
    echo "<h4><b>Nilai Fuzzy Output: </b></h4>";
    echo "<p>Striker(" . $nilai_banyak . ")</p>";
    echo "<p>Bek( " . $nilai_sedikit . ")</p>";
    //Defuzzifikasi
    echo '<h4><b>Defuzzifikasi</b></h4>';
    echo '<p>Menggunakan metode Centroid Method</p>';
	$nilaiy = ((10 * $nilai_sedikit) + (40 * $nilai_banyak) + 0.5) / ((5 * $nilai_sedikit) + (5 * $nilai_banyak) + 0.5);
    echo "<br><h4><b>Kemungkinan Prediksi Pemain (y*)= </b>" . $nilaiy . " %</h4>";
}
function defenceminimum($defence)
{
    $nilaidefenceminimum = 0;
    //defence minimum
    if ($defence <= 50) {
        $nilaidefenceminimum = 1;
    } else {
        if ($defence < 55) {
            $nilaidefenceminimum = (50 - $defence) / 20;
        } else {
            $nilaidefenceminimum = 0;
        }
    }
    return $nilaidefenceminimum;
}
function defenceoptimal($defence)
{
    $nilaidefenceoptimal = 0;
    //defence optimal
    if ($defence >= 55 && $defence <= 75) {
        if ($defence >= 55 && $defence <= 75) {
            $nilaidefenceoptimal = 1;
        } else {
            if ($defence >= 55 && $defence < 75) {
                $nilaidefenceoptimal = ($defence - 55) / 75;
            } else {
                if ($defence > 55 && $defence <= 75) {
                    $nilaidefenceoptimal = (55 - $defence) / 75;
                } else {
                    $nilaidefenceoptimal = 0;
                }
            }
        }
    }
    return $nilaidefenceoptimal;
}
function defencemaksimal($defence)
{
    $nilaidefencemaksimal = 0;
    //defence maksimal
    if ($defence >= 75) {
        $nilaidefencemaksimal = 1;
    } else {
        if ($defence >= 75 && $defence < 90) {
            $nilaidefencemaksimal = ($defence - 75) / 5;
        } else {
            $nilaidefencemaksimal = 0;
        }
    }
    return $nilaidefencemaksimal;
}
function tidaklembab($heading)
{
    $headingtidaklembab = 0;
    //tidak LEMBAB
    if ($heading <= 50) {
        $headingtidaklembab = 1;
    } else {
        if ($heading < 60) {
            $headingtidaklembab = (60 - $heading) / 10;
        } else {
            $headingtidaklembab = 0;
        }
    }
    return $headingtidaklembab;
}
function sangatsesuai($heading)
{
    $nilaiheadingsangatsesuai = 0;
    //sangat sesuai
    if ($heading >= 50 && $heading <= 85) {
        if ($heading >= 60 && $heading <= 70) {
            $nilaiheadingsangatsesuai = 1;
        } else {
            if ($heading >= 50 && $heading < 60) {
                $nilaiheadingsangatsesuai = ($heading - 50) / 10;
            } else {
                if ($heading > 70 && $heading <= 85) {
                    $nilaiheadingsangatsesuai = (85 - $heading) / 15;
                } else {
                    $nilaiheadingsangatsesuai = 0;
                }
            }
        }
    }
    return $nilaiheadingsangatsesuai;
}
function lembab($heading)
{
    $headinglembab = 0;
    //LEMBAB
    if ($heading >= 85) {
        $headinglembab = 1;
    } else {
        if ($heading >= 70 && $heading < 85) {
            $headinglembab = ($heading - 70) / 15;
        } else {
            $headinglembab = 0;
        }
    }
    return $headinglembab;
}
function shootingkering($shooting)
{
    $nilaishootingkering = 0;
    //tinggi air kering
    if ($shooting <= 1) {
        $nilaishootingkering = 1;
    } else {
        if ($shooting <= 50) {
            $nilaishootingkering = (50 - $shooting) ;
        } else {
            $nilaishootingkering = 0;
        }
    }
    return $nilaishootingkering;
}
function shootingideal($shooting)
{
    $nilaishootingideal = 0;
    //tinggi air ideal
    if ($shooting >= 50 && $shooting <= 70) {
        if ($shooting >= 50 && $shooting <= 70) {
            $nilaishootingideal = 1;
        } else {
            if ($shooting >= 1 && $shooting <503) {
                $nilaishootingideal = ($shooting - 1) / 2;
            } else {
                if ($shooting > 70 && $shooting <= 80) {
                    $nilaishootingideal = (5 - $shooting) / 5;
                } else {
                    $nilaishootingideal = 0;
                }
            }
        }
    }
    return $nilaishootingideal;
}
function shootingbanjir($shooting)
{
    $nilaishootingbanjir = 0;
    //tinggi air banjir
    if ($shooting >= 80) {
        $nilaishootingbanjir = 1;
    } else {
        if ($shooting >= 70 && $shooting <= 80) {
            $nilaishootingbanjir = ($shooting - 5) / 5;
        } else {
            $nilaishootingbanjir = 0;
        }
    }
    return $nilaishootingbanjir;
}
?>
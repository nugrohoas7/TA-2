<?php include_once('_header.php'); ?>

<div class="box">
    <h1>Perhitungan Fuzzy</h1>
    <p>Prediksi Posisi Pemain<br><br><br></p>
    <form method="post" action="">
        <div class="form-group row">
            <label class="col-sm-2">Defence</label>
            <div class="col-sm-10">
                <input type="number" name="defence" step=0.01 class="form-control" placeholder="Masukkan Tingkat akurasi 1-100" value="<?php if (isset($_POST["submit"])) echo $_POST["defence"] ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Heading</label>
            <div class="col-sm-10">
                <input type="number" name="heading" step=0.01 class="form-control" placeholder="Masukkan Tingkat akurasi 1-100" value="<?php if (isset($_POST["submit"])) echo $_POST["heading"] ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2">Shooting</label>
            <div class="col-sm-10">
                <input type="number" name="shooting" step=0.01 class="form-control" placeholder="Masukkan Tingkat akurasi 1-10" value="<?php if (isset($_POST["submit"])) echo $_POST["shooting"] ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<?php
include "_fuzzy.php";

if (isset($_POST["submit"])) {
?>
    <div class="card card-body">
    <?php
    //grafik defence
    grafikfungsikeanggotaandefence();
    nilaigrafikdefence($_POST["defence"]);
    //grafik heading
    grafikfungsikeanggotaanheading();
    nilaigrafikheading($_POST["heading"]);
    //grafik tinggi air
    grafikfungsikeanggotaanshooting();
    nilaigrafikshooting($_POST["shooting"]);
    //output
    grafikoutput();
    gambarrules();
    hasilfuzzifikasi($_POST["defence"], $_POST["heading"], $_POST["shooting"]);
    inferensi($_POST["defence"], $_POST["heading"], $_POST["shooting"]);
    echo "</div>";
}

include_once('_foother.php');
    ?>
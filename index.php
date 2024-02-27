<?php 
include "config.php"; 

$sql = $conn->query("SELECT * FROM kontrol WHERE id=1");
$row = $sql->fetch_array();

$relay = $row['relay'];
$servo = $row['servo'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

  <title>controller IOT</title>
</head>

<body>

  <!-- judul halaman -->
  <div class="container" style="text-align: center; padding: 20px 0;">
    <h1>kontroller relay dan servo <br> menggunakan web service</h1>
  </div>

  <!-- card kontroller -->
  <div class="container" style="display: flex; justify-content: space-around;">

    <div class="card mb-3" style="width: 18rem;">
      <div class="card-header" style="background-color: red; text-align: center;">
        <h3>Lampu</h3>
      </div>
      <div class="card-body">
        <div class="form-check form-switch" style="font-size: 50px;">
          <input class="form-check-input" type="checkbox" id="relay" onchange="ubahstatus(this.checked)" <?php echo ($relay == 1) ?"checked" : "";?>>
          <label class="form-check-label" for="relay" id="status"><?php echo ($relay == 1) ? "ON" : "OFF";?></label>
        </div>
      </div>
    </div>

    <div class="card mb-3" style="width: 18rem;">
      <div class="card-header" style="background-color: rgb(0, 4, 255); text-align: center;">
        <h3>servo</h3>
      </div>
      <div class="card-body" style="text-align: center;">
        <label for="relay" class="form-label">posisi sudut servo <span id="sudut"><?php echo $servo; ?></span></label>
        <input type="range" class="form-range" id="servo" min="0" max="180" step="1" value="<?php echo $servo; ?>"
          onchange="ubahsudut(this.value)">
      </div>
    </div>
  </div>

  <script>
    function ubahstatus(status) {
      if (status == true) {
        status ="ON"
      } else {
        status ="OFF"
      }
      document.getElementById('status').innerHTML = status;
      // ajax perubah relay database
      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          document.getElementById('status').innerHTML = xhttp.responseText;
        }
      }
      xhttp.open("get","model.php?stat=" + status, true);
      xhttp.send();
    }

    function ubahsudut(sudut) {
      document.getElementById('sudut').innerHTML = sudut;

      // ajax perubah servo database
      var xhttp = new XMLHttpRequest();

      xhttp.onreadystatechange = function () {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          document.getElementById('sudut').innerHTML = xhttp.responseText;
        }
      }
      xhttp.open("get","model.php?sud=" + sudut, true);
      xhttp.send();
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>
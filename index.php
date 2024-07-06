<?php
function getUserIP() {
  if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
  }
  $client = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote = $_SERVER['REMOTE_ADDR'];
  if (filter_var($client, FILTER_VALIDATE_IP)) {
    $ip = $client;
  } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
    $ip = $forward;
  } else {
    $ip = $remote;
  }
  return $ip;
}
$deteksi_perangkat = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
if($deteksi_perangkat) {
    $perangkat = "Handphone,Tablet";
}
else {
    $perangkat = "Computer or Notebook";
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
    $browser = 'Netscape';
}
else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
    $browser = 'Mozilla Firefox';
}
else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
    $browser = 'Chrome';
}
else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
    $browser = 'Opera';
}
else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
    $browser = 'Internet Explorer';
}
else {
    $browser = 'Other';
}  
$ip = getUserIP();
$ipnya = $ip;
$jo = file_get_contents("http://ipwho.is/$ipnya");
$joe = json_decode($jo, true);
$isp = $joe["connection"]["isp"];
$city = $joe["city"];
$country = $joe["country"];
$flag = $joe["flag"]["emoji"];
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Monytccc</title>
  <meta charset="utf-8">
  <link rel="canonical" href="<?php echo $actual_link ?>" />
<meta content="width=device-width,initial-scale=1,shrink-to-fit=no" name="viewport">
<meta name="description" content="What's My IP? - Check your IP Address here">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<style>
  /* tampilan untuk perangkat desktop */
  @media screen and (min-width: 768px) {

    body {
      font-size: 16px;
    }
    .title {
      font-size: 48px;
    }
    .data {
      font-size: 32px;
    }
    .localip {
      font-size: 28px;
      margin-bottom: 20px;
    }
    .info {
      font-size: 24px;
      
    }
  }

  /* tampilan untuk perangkat mobile */
  @media screen and (max-width: 767px) {
    
    body {
      font-size: 14px;
    }
    .title {
      font-size: 8vw;
    }
    .data {
      font-size: 6vw;
    }
    .localip {
      font-size: 5vw;
      margin-bottom: 10px;
    }
    .info {
      font-size: 4vw;
    }
  }

  /* ubah ukuran gambar */
  img {
    max-width: 100%;
    height: auto;
  }
  body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    color: #fff; /* ubah warna teks menjadi putih */
    background-color: #000; /* ubah warna latar belakang menjadi hitam */
    display: table;
    position: fixed;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif
  }
   .container {
    text-align: center;
    display: table-cell;
    vertical-align: middle
  }
</style>
</head>
<body>
<div class="container">
<img src="https://files.monytccc.eu.org/Monytccc.png" width="200" height="200" alt="monytccc" draggable="false"> 
<div class="title">
<br>
<?php echo $ip ?>
</div>
<div class="data">
<p>
<small>Country: <?php echo $country ?> <?php echo $flag ?> <br> City: <?php echo $city ?> <br>Device: <?php echo $perangkat ?> <br> Browser: <?php echo $browser ?> <br> Sistem Operasi: <?php echo $_SERVER['HTTP_USER_AGENT'] ?> <br>ISP: <?php echo $isp ?> </small>
</p>
</div>
<p class="localip" id="localip">
DNS Server: Checking...
</p>
<div class="info">
<p>
<small>Created by <a href="https://www.monytccc.eu.org/" style="color:#b0bec5">Monytccc</a>
</small>
</p>
</div>
</div>
<script>
fetch("https://edns.ip-api.com/json")
.then(a => a.json().then(r => {
document.getElementById("localip").innerHTML = "DNS Server: " + (r.dns.geo)
}))
</script>
  <script type="text/javascript">document.oncontextmenu = function() {return false;}</script>
</body>
</html>

<?php
$curl = curl_init();
// creat webhook
$data = array(
  'webhook' => 'https://226b-14-167-140-250.ap.ngrok.io/qlnss/thuchiskyward/example.php',
  'secure_token' => 'Hieunguyen',
  'income_only' => true
);
$postdata = json_encode($data);
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://oauth.casso.vn/v2/webhooks",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $postdata,
  CURLOPT_HTTPHEADER => array(
    "Authorization: Apikey AK_CS.cb863d4018ab11edae737153ab5bb610.tHXM0O5tiHz6vxqbchUFqN3HHpUyVJCyBHNHk6siq1uLuTca142YsGQandzOsmhnP2vIM43y",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
?>
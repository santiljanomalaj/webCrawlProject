<?php
  require_once('includes/selector.inc');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>scraping page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
      td,th{
        /* text-align:center; */
        vertical-align: middle!important;
      }
      .content{
        margin-top:1%;
        width:92%
      }
      .title{
        margin-top:3%;
        color:green;
        text-align:center;
      }
    </style>
  </head>
  <body>
  <h1 class="title">Malaysia Phone Product</h1>
      <div class="container">
    <table class="table table-striped table-responsive-md table-hover">
      <thead>
        <tr>
          <th>
            No
          </th>
          <th>
            Name
          </th>
          <th>
            Phone Number
          </th>
        </tr>
    </thead>
    <tbody>
    <?php
      set_time_limit(0);
      if(isset($_POST['advertise'])){
          $allPhoneData="";
          $k=1;
          $adsDataPhone=explode("=", $_POST['advertise']);
          if(!$adsDataPhone[1]){
            $realPhoneData=explode("&", $adsDataPhone[1]);
          }
          else {
            $realPhoneData[0]=1;
          }
          $adsDataPhone=explode("?",$adsDataPhone[0]);
          for($i=$realPhoneData[0];$i<$realPhoneData[0]+1;$i++)
          {
            $adsData=file_get_contents($adsDataPhone[0]."?o=".$i."&q=&so=1&th=1");
            $selectPhoneUrl=select_elements('.thumbnail_images', $adsData);
            for($j=0;$j<40;$j++){
              if(isset($selectPhoneUrl[$j]['children'][2]['attributes']['href']))
              {
                  $phoneInfo=file_get_contents($selectPhoneUrl[$j]['children'][2]['attributes']['href']);
                  $selectPhoneName=select_elements('.complex_header', $phoneInfo);
                  $selectContactNumber=select_elements('.moreless', $phoneInfo);
                  $selectNumber = explode('01',$selectContactNumber[0]['text']);
                  $phoneName=$selectPhoneName[0]['children'][0]['text'];
                  if(isset($selectNumber[1])){
                    // $prefixNumber = explode('.', $selectNumber[1]);
                    // $exactPrefix = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$prefixNumber[0]);
                    $allPhoneData.="<tr><td>".$k++."</td><td>".$phoneName."</td><td><b>01".$selectNumber[1]."</b></td></tr>";
                  }
              }
              else if(!isset($selectPhoneUrl[$j]['children'][2]['attributes']['href']))
              {
                  $phoneInfo=file_get_contents($selectPhoneUrl[$j]['children'][1]['attributes']['href']);
                  $selectPhoneName=select_elements('.complex_header', $phoneInfo);
                  $selectContactNumber=select_elements('.moreless', $phoneInfo);
                  $selectNumber = explode('01',$selectContactNumber[0]['text']);
                  $phoneName=$selectPhoneName[0]['children'][0]['text'];
                  if(isset($selectNumber[1])){
                    // $prefixNumber = explode('.', $selectNumber[1]);
                    // $exactPrefix = preg_split('/(?<=[0-9])(?=[a-z]+)/i',$prefixNumber[0]);
                    $allPhoneData.="<tr><td>".$k++."</td><td>".$phoneName."</td><td><b>01".$selectNumber[1]."</b></td></tr>";
                  }
              }
          }
        }
        echo $allPhoneData;
      }
    ?>    
    </tbody>
    </table>
    </div>
  </body>
</html>
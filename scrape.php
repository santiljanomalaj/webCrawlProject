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
  <h1 class="title">malaysia Phone Product</h1>
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
      if(isset($_POST['advertise'])){
          $allPhoneData="";
          $k=1;
          $adsDataPhone=explode("?", $_POST['advertise']);
          for($i=1;$i<3;$i++)
          {
            // echo "<a href='".$adsDataPhone[0]."?o=".$i."&q=&so=1&th=1'>kgs</a><br>";
            $adsData=file_get_contents($adsDataPhone[0]."?o=".$i."&q=&so=1&th=1");
            $selectPhoneUrl=select_elements('.thumbnail_images', $adsData);
            for($j=0;40;$j++){
              if(isset($selectPhoneUrl[$j]['children'][2]['attributes']['href']))
              {
                if(isset($selectPhoneUrl[$j]['children'][2]['attributes']['href'])){
                  $phoneInfo=file_get_contents($selectPhoneUrl[$j]['children'][2]['attributes']['href']);
                  $selectPhoneName=select_elements('.complex_header', $phoneInfo);
                  $selectPhoneNumber=select_elements('#number-space', $phoneInfo);
                  $phoneName=$selectPhoneName[0]['children'][0]['text'];
                  if(isset($selectPhoneNumber[0]['children'][0]['children'][1]['children'][0]['attributes']['src']) && isset($selectPhoneNumber[0]['children'][1]['children'][1]['children'][0]['attributes']['src'])){
                    $prefixNumber=$selectPhoneNumber[0]['children'][0]['children'][1]['children'][0]['attributes']['src'];
                    $phoneNumber=$selectPhoneNumber[0]['children'][1]['children'][1]['children'][0]['attributes']['src'];
                    $allPhoneData.="<tr><td>".$k++."</td><td>".$phoneName."</td><td><img src='".$prefixNumber."'><img src='".$phoneNumber."'></td></tr>";
                  }
                }
              }
              else if(!isset($selectPhoneUrl[$j]['children'][2]['attributes']['href']))
              {
                if(isset($selectPhoneUrl[$j]['children'][1]['attributes']['href'])){
                  $phoneInfo=file_get_contents($selectPhoneUrl[$j]['children'][1]['attributes']['href']);
                  $selectPhoneName=select_elements('.complex_header', $phoneInfo);
                  $selectPhoneNumber=select_elements('#number-space', $phoneInfo);
                  $phoneName=$selectPhoneName[0]['children'][0]['text'];
                  if(isset($selectPhoneNumber[0]['children'][0]['children'][1]['children'][0]['attributes']['src']) && isset($selectPhoneNumber[0]['children'][1]['children'][1]['children'][0]['attributes']['src'])){
                    $prefixNumber=$selectPhoneNumber[0]['children'][0]['children'][1]['children'][0]['attributes']['src'];
                    $phoneNumber=$selectPhoneNumber[0]['children'][1]['children'][1]['children'][0]['attributes']['src'];
                    $allPhoneData.="<tr><td>".$k++."</td><td>".$phoneName."</td><td><img src='".$prefixNumber."'><img src='".$phoneNumber."'></td></tr>";
                  }
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
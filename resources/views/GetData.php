<?php

include_once 'dbconnect.php';
header('Content-Type: application/json');

 header("Access-Control-Allow-Origin: *");


function isBoolean($value)
{
    if ($value && strtolower($value) !== "false") {
        return true;
    } else {
        return false;
    }
}


 function sendActivationMail($TO, $userId, $type)
 {
     $url="https://eventic.sd/tanker/check.php";
            
     $data = array('email' => $TO, 'id' => '90', 'type' => $type);
     $ch = curl_init($url);
     # Setup request to send json via POST.
     $payload = json_encode($data);
     
     curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
     # Return response instead of printing.
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     # Send request.
     $result = curl_exec($ch);
     curl_close($ch);
     # Print response.
     echo "<pre>" . $result. "</pre>";
 }


switch ($_GET['action']) {

    case 'activationUser':
    $userID=$_GET['kfjklewf'];
sendActivationMail("heem1999@gmail.com", $userId, 'c');

        break;

 case 'getTankerData':
$res['trucks_type'] = array();
    $result_place_categories= mysqli_query($con, "SELECT * FROM  trucks_type");
    while ($place_categories = mysqli_fetch_assoc($result_place_categories)) {
        $res['trucks_type'][] = $place_categories;
    }
                              
    $res['payload_type'] = array();
    $result_place_categories= mysqli_query($con, "SELECT * FROM  payload_type");
    while ($place_categories = mysqli_fetch_assoc($result_place_categories)) {
        $res['payload_type'][] = $place_categories;
    }
            echo json_encode($res);
        break;

case 'getMyOrders':

 $userID=$_GET['userID'];
 $res['my_orders'] = array();
          
$result_my_orders= mysqli_query($con, "SELECT * FROM  orders where user_id =$userID ORDER BY order_date DESC");
                while ($my_orders = mysqli_fetch_assoc($result_my_orders)) {
                    $res['my_orders'][] = $my_orders;
                }
            $i=0;
foreach ($res['my_orders'] as $item) {
    $orderID=$item['id'];
    $result= mysqli_query($con, "SELECT * FROM  order_details where order_id =$orderID");
    while ($order_details = mysqli_fetch_assoc($result)) {
        $oredr['orders_details'] []= $order_details;
        $res['my_orders'][$i]['orders_details'][]=$order_details;
        $j=0;
        foreach ($oredr['orders_details'] as $item2) {
            $order_details_id= $item2['id'];
            $result_my_orders1= mysqli_query($con, "SELECT * FROM  order_sources where order_details_id =$order_details_id");
            while ($order_sources = mysqli_fetch_assoc($result_my_orders1)) {
                $oredr['orders_source'][] = $order_sources;
            }
            $res['my_orders'][$i]['orders_details'][$j]['orders_source']= $oredr['orders_source'];
            $oredr['orders_source']=[];
            $j=$j+1;
        }
    }
    $i=$i+1;
}

$result_AllProducts= mysqli_query($con, "SELECT * FROM  drivers");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_drivers'][] = $AllProducts;
}

 $result_AllProducts= mysqli_query($con, "SELECT * FROM  supervisors");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_supervisors'][] = $AllProducts;
}

 $result_AllProducts= mysqli_query($con, "SELECT * FROM  branches");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_branches'][] = $AllProducts;
}

 $result_AllProducts= mysqli_query($con, "SELECT * FROM  sp_company");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_sp_company'][] = $AllProducts;
}

    echo json_encode($res);
 break;


 
 case 'getMyOrders_driver':

 $server_id=$_GET['drv_id'];
 $isSupervisor=isBoolean($_GET['isSupervisor']);
 $res['my_orders'] = array();
 $res['companyDerive'] =false;
 
          if ($isSupervisor==true) {//this the Supervisor
              $result_my_orders= mysqli_query($con, "SELECT * FROM  orders where server_id =$server_id and order_kind ='c' ORDER BY order_date DESC");
              while ($my_orders = mysqli_fetch_assoc($result_my_orders)) {
                  $res['my_orders'][] = $my_orders;
              }
              $i=0;
              foreach ($res['my_orders'] as $item) {
                  $orderID=$item['id'];
                  $result= mysqli_query($con, "SELECT * FROM  order_details where order_id =$orderID");
                  while ($order_details = mysqli_fetch_assoc($result)) {
                      $oredr['orders_details'] []= $order_details;
                      $res['my_orders'][$i]['orders_details'][]=$order_details;
                      $j=0;
                      foreach ($oredr['orders_details'] as $item2) {
                          $order_details_id= $item2['id'];
                          $result_my_orders1= mysqli_query($con, "SELECT * FROM  order_sources where order_details_id =$order_details_id");
                          while ($order_sources = mysqli_fetch_assoc($result_my_orders1)) {
                              $oredr['orders_source'][] = $order_sources;
                          }
                          $res['my_orders'][$i]['orders_details'][$j]['orders_source']= $oredr['orders_source'];
                          $oredr['orders_source']=[];
                          $j=$j+1;
                      }
                  }
                  $i=$i+1;
              }
          } else {//this is driver
              //check the kind of driver
              $branch_ID=0;

              $result_my_orders= mysqli_query($con, "SELECT * FROM  drivers where id=$server_id");
              while ($drivers = mysqli_fetch_assoc($result_my_orders)) {
                  $branch_ID=$drivers['branch_ID'];
              }

              if ($branch_ID==0) {//personal driver
    

                  $result_my_orders= mysqli_query($con, "SELECT * FROM  orders where server_id =$server_id and order_kind ='p' ORDER BY order_date DESC");
                  while ($my_orders = mysqli_fetch_assoc($result_my_orders)) {
                      $res['my_orders'][] = $my_orders;
                  }
                  $i=0;
                  foreach ($res['my_orders'] as $item) {
                      $orderID=$item['id'];
                      $result= mysqli_query($con, "SELECT * FROM  order_details where order_id =$orderID");
                      while ($order_details = mysqli_fetch_assoc($result)) {
                          $oredr['orders_details'] []= $order_details;
                          $res['my_orders'][$i]['orders_details'][]=$order_details;
                          $j=0;
                          foreach ($oredr['orders_details'] as $item2) {
                              $order_details_id= $item2['id'];
                              $result_my_orders1= mysqli_query($con, "SELECT * FROM  order_sources where order_details_id =$order_details_id");
                              while ($order_sources = mysqli_fetch_assoc($result_my_orders1)) {
                                  $oredr['orders_source'][] = $order_sources;
                              }
                              $res['my_orders'][$i]['orders_details'][$j]['orders_source']= $oredr['orders_source'];
                              $oredr['orders_source']=[];
                              $j=$j+1;
                          }
                      }
                      $i=$i+1;
                  }
              } else {
                  $res['companyDerive'] =true;
                  $result= mysqli_query($con, "SELECT * FROM  order_details where driver_id =$server_id");
                  while ($order_details = mysqli_fetch_assoc($result)) {
                      $res['my_orders'] []= $order_details;
                  }
                  //$res['my_orders'][$i]['orders_details'][]=$order_details;
                  $j=0;
                  foreach ($res['my_orders'] as $item2) {
                      $order_details_id= $item2['id'];
                      $result_my_orders1= mysqli_query($con, "SELECT * FROM  order_sources where order_details_id =$order_details_id");
                      while ($order_sources = mysqli_fetch_assoc($result_my_orders1)) {
                          //$oredr['orders_source'][] = $order_sources;
                          $res['my_orders'][$j]['orders_source'][]= $order_sources;
                      }
    
                      // $oredr['orders_source']=[];
                      $j=$j+1;
                  }
              }
          }


$result_AllProducts= mysqli_query($con, "SELECT * FROM  drivers");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_drivers'][] = $AllProducts;
}

 $result_AllProducts= mysqli_query($con, "SELECT * FROM  supervisors");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_supervisors'][] = $AllProducts;
}

 $result_AllProducts= mysqli_query($con, "SELECT * FROM  branches");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_branches'][] = $AllProducts;
}

 $result_AllProducts= mysqli_query($con, "SELECT * FROM  sp_company");
while ($AllProducts = mysqli_fetch_assoc($result_AllProducts)) {
    $res['All_sp_company'][] = $AllProducts;
}

    echo json_encode($res);
 break;


case 'getSearchedEvents':
$search = $_GET['search'];
$searchCheck=1;
            $result = mysqli_query($con, "SELECT * FROM events_data where Events_Title like '%".$search."%'");

            $res['Events'] = array();

            while ($Events_data = mysqli_fetch_assoc($result)) {
                $res['Events'][] = $Events_data;
                $searchCheck=0;
            }

 if ($searchCheck==1) {
     $result = mysqli_query($conAR, "SELECT * FROM events_data where Events_Title like '%".$search."%'");

     $res['Events'] = array();

     while ($Events_data = mysqli_fetch_assoc($result)) {
         $res['Events'][] = $Events_data;
     }
 }
            echo json_encode($res);
        break;

case 'getAllCategories':

                    $result = mysqli_query($con, "SELECT * FROM main_category");

                    $res['Categories'] = array();

                    while ($Categories_data = mysqli_fetch_assoc($result)) {
                        $res['Categories'][] = $Categories_data;
                    }


                    echo json_encode($res);
        break;

}
?>




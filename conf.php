<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jsTree";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
    /* check connection */
    if(isset($_GET['operation'])) {
        try {
          $result = null;
          switch($_GET['operation']) {
            case 'get_node':
              $node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
              $sql = "SELECT * FROM `jstree` ";
              $res = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
                //iterate on results row and create new index array of data
                while( $row = mysqli_fetch_assoc($res) ) {
                  $data[] = $row;
                }
                $itemsByReference = array();
       
              // Build array of item references:
              foreach($data as $key => &$item) {
                 $itemsByReference[$item['id']] = &$item;
                 // Children array:
                 $itemsByReference[$item['id']]['children'] = array();
                 $itemsByReference[$item['id']]['text'] = $itemsByReference[$item['id']]['name'];
                 // Empty data class (so that json_encode adds "data: {}" )
                 $itemsByReference[$item['id']]['data'] = new StdClass();
              }
       
              // Set items as children of the relevant parent item.
              foreach($data as $key => &$item)
                 if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                  $itemsByReference [$item['parent_id']]['children'][] = &$item;
       
              // Remove items that were added to parents elsewhere:
              foreach($data as $key => &$item) {
                 if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                  unset($data[$key]);
              }
              $result = $data;
              break;
              case 'create_node':
                $node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
                
                $nodeText = isset($_GET['name']) && $_GET['name'] !== '' ? $_GET['name'] : '';
                print_r($_GET['name']);
                $sql ="INSERT INTO `jstree` (`name`, `isFile`, `parent_id`) VALUES('".$nodeText."', '".$nodeText."', '".$node."')";
                // print_r($sql);
                mysqli_query($conn, $sql);
                
                $result = array('id' => mysqli_insert_id($conn));
         
                break;
              case 'rename_node':
                $node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
                //print_R($_GET);
                $nodeText = isset($_GET['name']) && $_GET['name'] !== '' ? $_GET['name'] : '';
                $sql ="UPDATE `jstree` SET `name`='".$nodeText."',`isFile`='".$nodeText."' WHERE `id`= '".$node."'";
                mysqli_query($conn, $sql);
                break;
            case 'delete_node':
              $node = isset($_GET['id']) && $_GET['id'] !== '#' ? (int)$_GET['id'] : 0;
              $sql ="DELETE FROM `jstree` WHERE `id`= '".$node."'";
              mysqli_query($conn, $sql);
              break;
            default:
              throw new Exception('Unsupported operation: ' . $_GET['operation']);
              break;
          }
          header('Content-Type: application/json; charset=utf-8');
          echo json_encode($result);
        }
        catch (Exception $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
          header('Status:  500 Server Error');
          echo $e->getMessage();
        }
        die();
      }
?>

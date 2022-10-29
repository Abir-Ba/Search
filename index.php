<?php
 $servername = "localhost";
 $username = "root";
 $password = ""; // Your database Password
 $dbname = ""; // Your Database Name
$cnx = mysqli_connect($servername,$username,$password,$dbname);
if(isset($_POST["submit"]))  
{  
     if(!empty($_POST["search"]))  
     {  
          $query = str_replace(" ", "+", $_POST["search"]);  
          header("location:index.php?search=" . $query);  
     }  
}  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<body>
<br /><br />  
           <div class="container" style="width:500px;">  
                <form method="POST">  
                     <label>Search</label>  
                     <input type="text" name="search" class="form-control" value="<?php if(isset($_GET["search"])) echo $_GET["search"]; ?>" />  
                     <br />  
                     <input type="submit" name="submit" class="btn btn-primary" value="Search" />  
                </form>  
                <br /><br />  


            <div>
 <table class="table">
 <?php 
 $table = [] ;
 $tableId = [];

                     if(isset($_GET["search"]))  
                     {  
                          $condition = '';  
                          $searchText = $_GET["search"];
                          $query = explode(" ", $searchText); 
                          foreach($query as $text)  
                          {  
                              var_dump(!empty($text));
                              if ( !empty($text) ){
                               $condition .= "(Nom LIKE '%".mysqli_real_escape_string($cnx, $text)."%' OR Dosage LIKE '%".mysqli_real_escape_string($cnx, $text)."%') AND ";
                              }  
                          }  
                          $condition = substr($condition, 0, -5);  
                          $sql_query = "SELECT * FROM Medicament WHERE " . $condition;  
                          $result = mysqli_query($cnx, $sql_query);  
                          if(mysqli_num_rows($result) > 0)  
                          {  
                               while($row = mysqli_fetch_array($result))  
                               {  
                               
                                  $table[] = [$row["idMedicament"],$row["Nom"],$row["Dosage"]];
                                  $tableId[] = $row["idMedicament"];
                               }  
                          }
                          $condition = '';
                          foreach($query as $text)  
                          {  
                               $condition .= "(Nom LIKE '%".mysqli_real_escape_string($cnx, $text)."%' OR Dosage LIKE '%".mysqli_real_escape_string($cnx, $text)."%') OR ";  
                          }  
                          $condition = substr($condition, 0, -4);  
                          $sql_query = "SELECT * FROM Medicament WHERE " . $condition;  
                          $result = mysqli_query($cnx, $sql_query); 
                         
                          // concat results ordred 
                          // data (workbench)
                          // how to remove last space
                          if(mysqli_num_rows($result) > 0)  
                          {   
                               while($row = mysqli_fetch_array($result))  
                               {  
                                   
                                   if(  !in_array($row["idMedicament"] , $tableId)){
                                        $table[] = [$row["idMedicament"],$row["Nom"],$row["Dosage"]];
                                        $tableId[] = $row["idMedicament"];
                                  }
                                  
                               } 
                              
                          }  
                          else  
                          {  
                               echo '<td>Data not Found</td>';  
                          }  
                          
                     }  
                     ?>  
  <thead class="thead-dark">
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nom</th>
      <th scope="col">Dosage</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $i = 0;
  
  while($i < count($tableId)){
     echo '  <tr><th scope="row">'.$table[$i][0].'</th>
     <td>'.$table[$i][1].'</td>
     <td>'.$table[$i][2].'</td>
   </tr>' 
   ;
   $i++ ;
  }
  ?>
  </tbody>
</table>
            </div>
</body>
</html>
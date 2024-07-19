<?php
    $database = DB::connect();
    $data = new Club($database);
    $rows = $data->getAll();   
?>

<table class="table">
  
<thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Club</th>
      <th scope="col">Country</th>
    </tr>
</thead>
<tbody>
    <?php
        foreach($rows as $row): 
    ?>
    <tr>
      <th scope="row"><?php echo $row[0]?></th>
      <td><?php echo $row[1]?></td>
      <td><?php echo $row[2]?></td>
      <td><?php echo $row[3]?></td>
      <td><?php echo $row[4]?></td>
    </tr>
    
    <?php endforeach?>
</tbody>

</table>
<?php
if ($result){
  $id=1;
  foreach ($result as $value) {
  ?>
  <tr>
    <td> <?php echo $id ?></td>
    <td><?php echo escape($value ['title']) ?></td>
    <td>
      <?php echo escape(substr($value ['content'],0,50).'. . . .')?>
    </td>
    <td>
      <div class="btn-group">
        <div class="container">
          <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-primary">Edit</a>
        </div>
        <div class="container">
          <a href="delete.php?id=<?php echo $value['id'] ?>"
            onclick="return confirm('Are you sure you want to delete this item?')"
            class="btn btn-danger">Delete</a>
        </div>
      </div>
    </td>
  </tr>







  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="?pagenumber=1">First</a></li>
    <li class="page-item <?php if($pagenumber <=1){ echo 'disabled'; } ?>">
      <a class="page-link" href="<?php if($pagenumber <=1){ echo '#';}else{ echo "?pagenumber=".($pagenumber-1);} ?>">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#"><?php echo $pagenumber; ?></a></li>
    <li class="page-item <?php if($pagenumber >= $totalpages){ echo 'disabled';} ?>">
      <a class="page-link" href="<?php if ($pagenumber >=$totalpages){ echo '#'; }else{ echo "?pagenumber=".($pagenumber+1);} ?>">Next</a>
    </li>
    <li class="page-item"><a class="page-link" href="?pagenumber=<?php echo $totalpages ?>">Last</a></li>
  </ul>

<?php
$id ++;
}
}

 ?>

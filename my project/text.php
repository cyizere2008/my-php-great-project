<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <table class="border mt-[3rem] mx-auto">
    <!-- table  header row -->
    <tr class="border">
        <th class="border">activityNo</th>
        <th class="border">Description</th>
        <th class="border">ClubId</th>
        <th class="border" colspan=2>Options</th>
    </tr>


    <?php

    include 'db_connection.php';

    $query=mysqli_query($conn,"SELECT * FROM activities");
   while($records= mysqli_fetch_array($query)){
    ?>

    <tr > 
        <td class="border"><?php echo $records['activityNo']?></td>
        <td class="border"><?php echo $records['description']?></td>
        <td class="border"><?php echo $records['clubId']?></td> 
        <td class="border"><a href="./delete.php?delete_id=<?php echo $records['activityNo']?>"><button>DELETE 🗑</button></a></td>
        <td class="border"><a href="./update.php?update_id=<?php echo $records['activityNo']?>"><button>UPDATE ✏</button></a></td>
        
    </tr>

    <?php  }?>
    
  </table>  
</body>
</html>
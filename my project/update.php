<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Edit Activity</title>
</head>
<body class="bg-[#34495e] text-gray-200 font-sans">
<?php
    // It's good practice to include PHP files at the top
    include 'db_connection.php';

    // It's safer to cast the ID to an integer
    $update_id = $_GET['update_id'];

    $query = mysqli_query($conn, "SELECT * FROM activities WHERE activityNo= $update_id");
    
    // Using mysqli_fetch_assoc is often clearer
    while($record = mysqli_fetch_assoc($query)){
?>
    <form class="bg-white w-[90%] md:w-[60%] lg:w-[40%] gap-4 mt-16 p-8 flex flex-col rounded-lg mx-auto shadow-2xl" action="./update_codes.php" method="POST">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Edit Activity</h1>
        
        <input type="hidden" name="id" value='<?php echo htmlspecialchars($record['activityNo']); ?>'>
        
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <input id="description" class="border border-gray-300 text-gray-800 w-full p-2 rounded-md focus:ring-2 focus:ring-orange-500" type="text" name="description" value='<?php echo htmlspecialchars($record['description']); ?>'>
        </div>

        <div>
            <label for="clubid" class="block text-sm font-medium text-gray-700 mb-1">Club ID</label>
            <input id="clubid" class="border border-gray-300 text-gray-800 w-full p-2 rounded-md focus:ring-2 focus:ring-orange-500" type="text" name="clubid" value='<?php echo htmlspecialchars($record['clubId']); ?>'>
        </div>
        
        <button class="bg-orange-700 text-white font-bold py-2 px-4 rounded-md hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 mt-4" type="update">Save Changes</button>

    </form>

<?php 
    } // End of while loop
?>
</body>
</html>
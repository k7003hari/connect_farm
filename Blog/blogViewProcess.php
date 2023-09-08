<?php
	session_start();

	require '../db.php';

    $sql = "SELECT * FROM blogdata ORDER BY blogId DESC";
    $result = mysqli_query($conn, $sql);

    while($row = $result->fetch_array()):
?>

        <?= $row['likes']; ?>

    <?php endwhile; ?>

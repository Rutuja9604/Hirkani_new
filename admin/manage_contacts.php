<?php include("../connect/connection.php"); ?>
<h2>Contact Messages</h2>
<table border="1" cellpadding="10">
  <tr><th>Name</th><th>Email</th><th>Message</th></tr>
  <?php
  $result = $conn->query("SELECT * FROM contact");
  while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['message']}</td></tr>";
  }
  ?>
</table>

<?php
include 'db.php';

// Check connection
if ($conn) {
    echo "✅ Database connected successfully!";
} else {
    echo "❌ Connection failed!";
}
?>

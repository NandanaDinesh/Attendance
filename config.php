<?php
session_start();
$conn = new mysqli("localhost","root","123","attendance");
if ($conn->connect_error) {
    die("Database connection failed");
}

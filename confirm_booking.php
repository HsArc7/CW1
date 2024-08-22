<?php
session_start();
require 'db.php'; // Ensure this is included to access $pdo

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve booking details from POST data
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_amount = $_POST['total_amount'];
    $user_id = $_SESSION['user_id'];

    try {
        // Prepare and execute the booking insertion query
        $stmt = $pdo->prepare("
            INSERT INTO bookings (user_id, car_id, start_date, end_date, total_amount) 
            VALUES (:user_id, :car_id, :start_date, :end_date, :total_amount)
        ");

        $stmt->execute([
            ':user_id' => $user_id,
            ':car_id' => $car_id,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':total_amount' => $total_amount
        ]);

        // Send a confirmation email
        $user_stmt = $pdo->prepare("SELECT email FROM users WHERE id = :user_id");
        $user_stmt->execute([':user_id' => $user_id]);
        $user = $user_stmt->fetch(PDO::FETCH_ASSOC);

        $to = $user['email'];
        $subject = 'Booking Confirmation';
        $message = "Dear User,\n\nYour booking has been confirmed.\nCar ID: $car_id\nStart Date: $start_date\nEnd Date: $end_date\nTotal Amount: $total_amount\n\nThank you for choosing our service.";
        $headers = 'From: no-reply@carrentalkathmandu.com' . "\r\n" .
                   'Reply-To: no-reply@carrentalkathmandu.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        // Redirect with success parameter
        header("Location: confirm_booking.php?success=1");
        exit();
    } catch (PDOException $e) {
        echo 'Booking failed: ' . htmlspecialchars($e->getMessage());
        exit();
    }
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<h1>Booking Confirmed!</h1>";
    echo "<p>Your booking was successful. You will receive a confirmation email shortly.</p>";
} else {
    echo "<p>No booking was made. Please try again.</p>";
}
?>

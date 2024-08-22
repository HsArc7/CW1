<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

try {
    // Fetch all available cars from the database
    $stmt = $pdo->query("SELECT * FROM cars");
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Database query failed: ' . htmlspecialchars($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Book a Car - Car Rental Kathmandu</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Book Your Car</h2>

        <form action="confirm_booking.php" method="POST">
            <label for="car_id">Select Car:</label>
            <select name="car_id" id="car_id" required>
                <option value="" disabled selected>Select a car</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?php echo htmlspecialchars($car['id']); ?>"
                            data-price="<?php echo htmlspecialchars($car['price']); ?>">
                        <?php echo htmlspecialchars($car['name']); ?> - Rs<?php echo htmlspecialchars($car['price']); ?>/day
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" required>

            <label for="total_amount">Total Amount:</label>
            <input type="text" name="total_amount" id="total_amount" readonly>

            <button type="submit">Confirm Booking</button>
        </form>
    </div>

    <script>
        const carSelect = document.getElementById('car_id');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const totalAmountInput = document.getElementById('total_amount');

        function calculateTotalAmount() {
            const carPrice = carSelect.options[carSelect.selectedIndex].getAttribute('data-price');
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate && endDate && carPrice) {
                const timeDifference = endDate.getTime() - startDate.getTime();
                const dayDifference = Math.ceil(timeDifference / (1000 * 3600 * 24)); // Use Math.ceil to include the end date

                const totalAmount = carPrice * dayDifference;
                totalAmountInput.value = totalAmount ? `Rs ${totalAmount}` : '';
            }
        }

        carSelect.addEventListener('change', calculateTotalAmount);
        startDateInput.addEventListener('change', calculateTotalAmount);
        endDateInput.addEventListener('change', calculateTotalAmount);
    </script>
</body>
</html>

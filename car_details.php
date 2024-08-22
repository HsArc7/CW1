<?php include 'header.php'; ?>
<main>
    <section class="car-details">
        <h1>Car Details</h1>
        <p>Explore our fleet of vehicles below.</p>
        <div class="car-list">
            <?php
            include 'car_data.php';
            foreach ($cars as $car) {
                echo '<div class="car-item">';
                echo '<h2>' . htmlspecialchars($car['name']) . '</h2>';
                echo '<img src="' . htmlspecialchars($car['image']) . '" alt="' . htmlspecialchars($car['name']) . '">';
                echo '<p><strong>Price:</strong> Rs' . htmlspecialchars($car['price']) . '/day</p>';
                echo '<p><strong>Description:</strong> ' . htmlspecialchars($car['description']) . '</p>';
                echo '<p><strong>Features:</strong> ' . htmlspecialchars($car['features']) . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>

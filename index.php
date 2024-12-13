<?php
// Array of cars with detailed information
$cars = [
    [
        "name" => "Toyota Camry",
        "year" => 2022,
        "model" => "Sedan",
        "countries" => ["USA", "Japan", "Canada", "Australia"],
        "colors" => ["White", "Black"],
        "rating" => 4
    ],
    [
        "name" => "Ford Mustang",
        "year" => 2023,
        "model" => "Sports Car",
        "countries" => ["USA", "Canada", "Germany"],
        "colors" => ["Blue", "Yellow", "Red", "Black"],
        "rating" => 5
    ],
    [
        "name" => "Honda Civic",
        "year" => 2021,
        "model" => "Compact",
        "countries" => ["Japan", "USA", "UK", "Canada"],
        "colors" => ["Gray", "White", "Blue", "Red"],
        "rating" => 4
    ],
    [
        "name" => "Tesla Model 3",
        "year" => 2023,
        "model" => "Electric",
        "countries" => ["USA", "Canada", "Germany", "Norway"],
        "colors" => ["White", "Black", "Red", "Blue"],
        "rating" => 5
    ]
];

// Sorting functionality
if (isset($_GET['sort'])) {
    $sortType = $_GET['sort'];
    
    usort($cars, function($a, $b) use ($sortType) {
        if ($sortType === 'name') {
            return strcmp($a['name'], $b['name']);
        } elseif ($sortType === 'year_asc') {
            return $a['year'] - $b['year'];
        } elseif ($sortType === 'year_desc') {
            return $b['year'] - $a['year'];
        }
    });
}

// Search functionality
$searchQuery = isset($_GET['search']) ? trim(strtolower($_GET['search'])) : '';
$filteredCars = array_filter($cars, function($car) use ($searchQuery) {
    return $searchQuery === '' || 
           stripos(strtolower($car['name']), $searchQuery) !== false ||
           stripos(strtolower($car['model']), $searchQuery) !== false ||
           stripos((string)$car['year'], $searchQuery) !== false ||
           in_array(ucfirst($searchQuery), $car['countries']) ||
           in_array(ucfirst($searchQuery), $car['colors']);
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Showcase</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Car Showcase</h1>
        
        <div class="controls">
            <form method="get">
                <input type="text" name="search" placeholder="Search by model" 
                       value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit">Search</button>
            </form>

            <div class="sort-buttons">
                <a href="?sort=name" class="btn">Sort by Name</a>
                <a href="?sort=year_asc" class="btn">Sort by Year (Ascending)</a>
                <a href="?sort=year_desc" class="btn">Sort by Year (Descending)</a>
            </div>
        </div>

        <div class="card-container">
            <?php if (empty($filteredCars)): ?>
                <p class="no-results">No results found</p>
            <?php else: ?>
                <?php foreach ($filteredCars as $car): ?>
                    <div class="card">
                        <h2><?php echo htmlspecialchars($car['name']); ?></h2>
                        <p><strong>Year:</strong> <?php echo $car['year']; ?></p>
                        <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                        
                        <div class="car-details">
                            <div class="countries">
                                <strong>Available Countries:</strong>
                                <ul>
                                    <?php foreach ($car['countries'] as $country): ?>
                                        <li><?php echo htmlspecialchars($country); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            
                            <div class="colors">
                                <strong>Available Colors:</strong>
                                <ul>
                                    <?php foreach ($car['colors'] as $color): ?>
                                        <li><?php echo htmlspecialchars($color); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>

                        <div class="rating">
                            <strong>Rating:</strong>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="star <?php echo $i <= $car['rating'] ? 'filled' : ''; ?>">★</span>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
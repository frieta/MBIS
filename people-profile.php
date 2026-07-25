<?php
require_once __DIR__ . '/people.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$person = getPersonBySlug($slug);

if (!$person) {
  header('Location: index.php');
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($person['name']) ?> — Profile</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container profile-shell">
    <div class="profile-card">
      <img src="<?= htmlspecialchars($person['photo']) ?>" alt="<?= htmlspecialchars($person['name']) ?>">
      <div>
        <p class="profile-meta"><?= htmlspecialchars($person['role']) ?></p>
        <h3><?= htmlspecialchars($person['name']) ?></h3>
        <p><?= htmlspecialchars($person['details']) ?></p>
        <p><?= htmlspecialchars($person['bio']) ?></p>
        <a href="index.php">← Back to showcase</a>
      </div>
    </div>
  </main>
</body>
</html>

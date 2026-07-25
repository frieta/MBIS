<?php
require_once __DIR__ . '/people.php';

$studentDir = __DIR__ . '/student_works';
$files = [];
if (is_dir($studentDir)) {
  $all = scandir($studentDir);
  foreach ($all as $f) {
    if ($f === '.' || $f === '..') continue;
    if (is_file($studentDir . '/' . $f) && preg_match('/\.html?$/i', $f)) {
      $files[] = $f;
    }
  }
  sort($files, SORT_NATURAL | SORT_FLAG_CASE);
}

function parseFilename($filename) {
  $name = pathinfo($filename, PATHINFO_FILENAME);
  $parts = explode('_', $name);
  $result = [
    'lastname' => '',
    'firstname' => '',
    'grade' => '',
    'section' => '',
    'displayName' => htmlspecialchars(str_replace('_', ' ', $name))
  ];
  if (count($parts) >= 3) {
    $result['lastname'] = $parts[0];
    $result['firstname'] = $parts[1];
    $sec = $parts[2];
    if (preg_match('/^(\d+)([A-Za-z\s\-]*)$/', $sec, $m)) {
      $result['grade'] = $m[1];
      $result['section'] = trim($m[2]);
    } else {
      $result['section'] = $sec;
    }
    $result['displayName'] = htmlspecialchars($result['lastname'] . ' ' . $result['firstname']);
  }
  return $result;
}

function normalizeName($value) {
  $value = strtolower($value);
  $value = preg_replace('/[^a-z0-9]+/', '', $value);
  return $value;
}

function findThumbnail($studentPicDir, $file) {
  $parts = parseFilename($file);
  $candidates = [];

  if (!empty($parts['lastname']) || !empty($parts['firstname'])) {
    $candidates[] = normalizeName($parts['lastname'] . $parts['firstname']);
    $candidates[] = normalizeName($parts['lastname'] . $parts['firstname'] . $parts['grade']);
    $candidates[] = normalizeName($parts['lastname'] . $parts['firstname'] . $parts['grade'] . $parts['section']);
    $candidates[] = normalizeName($parts['lastname'] . $parts['firstname'] . $parts['section']);
  }

  $candidates[] = normalizeName(pathinfo($file, PATHINFO_FILENAME));
  $candidates[] = normalizeName(str_replace(['_', ' '], '', pathinfo($file, PATHINFO_FILENAME)));

  if (!is_dir($studentPicDir)) {
    return 'student_pics/placeholder.svg';
  }

  $extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
  $images = [];
  foreach (scandir($studentPicDir) as $entry) {
    if ($entry === '.' || $entry === '..') continue;
    $path = $studentPicDir . '/' . $entry;
    if (!is_file($path)) continue;
    $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
    if (!in_array($ext, $extensions, true)) continue;
    $images[] = $entry;
  }

  foreach ($images as $image) {
    $imageBase = normalizeName(pathinfo($image, PATHINFO_FILENAME));
    foreach ($candidates as $candidate) {
      if ($candidate !== '' && ($imageBase === $candidate || strpos($imageBase, $candidate) !== false || strpos($candidate, $imageBase) !== false)) {
        return 'student_pics/' . rawurlencode($image);
      }
    }
  }

  return 'student_pics/placeholder.svg';
}

$profileCards = $peopleProfiles;

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Code for Nutrition 2026 — Showcase</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="hero">
    <div class="hero-inner">
      <div class="hero-text">
        <h1>Code for Nutrition 2026 Showcase</h1>
        <p class="lead">Welcome to the Code for Nutrition 2026 Showcase! On July 23, 2026, Grade 10 students at Malainen Bago Integrated School competed in the Healthy Plate Webpage Challenge. Using only standard HTML elements, participants had 90 minutes to design creative, informative webpages promoting healthy eating habits. Browse their hard work below!</p>
        <p class="meta">Event: Healthy Plate Webpage Challenge — July 23, 2026</p>
      </div>
      <div class="hero-image">
        <img src="assets/poster.png" alt="Event poster" loading="lazy">
      </div>
    </div>
  </header>

  <main class="container">
    <section class="event-overview" aria-labelledby="overview-title">
      <div class="overview-header">
        <p class="eyebrow">Event Overview</p>
        <h2 id="overview-title">About the Code for Nutrition 2026 Challenge</h2>
        <p class="overview-lead">
          The poster shows a simple but important goal: help Grade 10 learners build a webpage that promotes healthy living,
          using only HTML and their own creativity. The showcase below collects those student submissions in one place.
        </p>
      </div>

      <div class="overview-grid">
        <article class="overview-card overview-card-wide" style="font-size: 1.4rem; line-height: 1.5;">
          <h3>What the challenge was about</h3>
          <p>
            On <strong>July 23, 2026</strong>, Grade 10 students of <strong>Malainen Bago Integrated School</strong>
            created a one-page HTML project inspired by the “My Healthy Plate” theme. Each entry was designed to explain
            healthy food choices, encourage good nutrition, and present information in a clear and attractive way.
          </p>
          <p>
            The activity was limited to a <strong>90-minute</strong> competition window, so students had to plan quickly,
            organize content carefully, and build a webpage that was both informative and visually appealing.
          </p>
        </article>

        <article class="overview-card" style="font-size: 1.1rem; line-height: 1.5;">
          <h3>Competition focus</h3>
          <ul>
            <li>Open only to <strong>Grade 10 students</strong></li>
            <li>One informative, creative HTML webpage per participant</li>
            <li>Theme: <strong>healthy eating and nutrition awareness</strong></li>
            <li>Output should use standard HTML elements and simple layout ideas</li>
          </ul>
        </article>

        <article class="overview-card">
          <h3>Required webpage content</h3>
          <ul>
            <li>A webpage title and main heading</li>
            <li>At least one paragraph about healthy nutrition</li>
            <li>At least one image related to the topic</li>
            <li>An ordered or unordered list</li>
            <li>A table presenting nutrition-related information</li>
            <li>An appropriate background color or visual style</li>
          </ul>
        </article>
      </div>

      <div class="overview-footer">
        <div>
          <strong>Allowed tools:</strong> Notepad, Notepad++, Atom, Visual Studio Code, Sublime Text, and other HTML editors.
        </div>
        <div>
          <strong>Submission note:</strong> Students were expected to develop a webpage on the spot from scratch and Save it in the computer that they will use the facilitators and judges will then check their.
        </div>
      </div>
    </section>

    <section>
      <h2>Participating Students & their Works</h2>
      <p class="hint">Students submissions for the Code for Nutrition 2026 Challenge. <br><i>Click on any card to view the student's work.</i></p>
      <?php if (empty($files)): ?>
        <div class="empty">No student submissions found in <code>student_works/</code>.</div>
      <?php else: ?>
        <div class="gallery">
          <?php foreach ($files as $f): ?>
            <?php
              $url = 'student_works/' . rawurlencode($f);
              $parts = parseFilename($f);
              $thumb = findThumbnail(__DIR__ . '/student_pics', $f);
            ?>
            <a class="card" href="<?= $url ?>" target="_blank" rel="noopener noreferrer">
              <div class="card-thumb">
                <?php if ($thumb): ?>
                  <img src="<?= htmlspecialchars($thumb) ?>" alt="<?= $parts['displayName'] ?>">
                <?php else: ?>
                  <span>HTML</span>
                <?php endif; ?>
              </div>
              <div class="card-body">
                <h3><?= $parts['displayName'] ?></h3>
                <p class="grade">
                  <?php if ($parts['grade']): ?>
                    Grade <?= htmlspecialchars($parts['grade']) ?>
                    <?php if ($parts['section']): ?> — <?= htmlspecialchars($parts['section']) ?><?php endif; ?>
                  <?php else: ?>
                    <?= htmlspecialchars($parts['section']) ?>
                  <?php endif; ?>
                </p>
                <p class="filename"><?= htmlspecialchars($f) ?></p>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>

    <section>
      <h2>Facilitators &amp; Judges</h2>
     <p class="hint">Facilitators and judges for the Code for Nutrition 2026 Challenge. <br><i>Click on any card to view the person's profile.</i></p>
      <div class="gallery">
        <?php foreach ($profileCards as $person): ?>
          <a class="card" href="<?= htmlspecialchars($person['link']) ?>" rel="noopener noreferrer">
            <div class="card-thumb">
              <img src="<?= htmlspecialchars($person['photo']) ?>" alt="<?= htmlspecialchars($person['name']) ?>">
            </div>
            <div class="card-body">
              <h3><?= htmlspecialchars($person['name']) ?></h3>
              <p class="grade"><?= htmlspecialchars($person['role']) ?></p>
              <p class="filename"><?= htmlspecialchars($person['bio'] ?? $person['details'] ?? '') ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <footer class="footer">
    <p>Malainen Bago Integrated School — Code for Nutrition 2026</p>
  </footer>
</body>
</html>

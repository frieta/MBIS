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
  <style>
    /* Custom Grid Layout matching image_63173b.png */
    .custom-overview-layout {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr;
      gap: 1.5rem;
      width: 100%;
    }
    .custom-full-width {
      grid-column: 1 / -1;
    }
    
    /* Mobile Optimization */
    @media (max-width: 900px) {
      .custom-overview-layout {
        grid-template-columns: 1fr 1fr;
      }
      .custom-overview-layout article:first-child {
        grid-column: 1 / -1;
      }
    }
    @media (max-width: 768px) {
      .custom-overview-layout {
        grid-template-columns: 1fr;
      }
      .custom-overview-layout article:first-child {
        grid-column: auto;
      }
      .custom-full-width {
        grid-column: 1 / -1;
      }
    }
  </style>
</head>
<body>
  <header class="hero">
    <div class="hero-inner">
      <div class="hero-text">
        <h1>Code for Nutrition 2026 Showcase</h1>
        <p class="lead">Welcome to the Code for Nutrition 2026 Showcase! This website features the official student outputs from the Code for Nutrition 2026: Healthy Plate Webpage Challenge, held on July 23, 2026, at the MBIS ICT Laboratory. The competition showcased the HTML webpages developed by the 18 Grade 10 Computer Programming students of Malainen Bago Integrated School. Applying the knowledge and skills they acquired during the first five (5) weeks of their Grade 10 TLE – Computer Programming lessons, students created informative and creative webpages that promote healthy eating, balanced nutrition, and the Healthy Plate concept. Explore their digital projects and discover how beginning web developers used technology to promote healthier lifestyles.</p>
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
        <h2 id="overview-title">About the Challenge</h2>
        <p class="overview-lead">
          The Code for Nutrition 2026: Healthy Plate Webpage Challenge served as the first major practical application of the students' learning in Computer Programming. During the first five weeks of instruction, students learned the fundamentals of HTML together with basic CSS formatting, including webpage structure, headings, paragraphs, lists, hyperlinks, images, tables, text formatting, and webpage background colors. To demonstrate these newly acquired skills, students designed and developed an educational webpage that promotes healthy eating and nutrition awareness while applying proper webpage organization, creativity, and coding techniques.
        </p>
      </div>

      <div class="overview-grid custom-overview-layout">
        <article class="overview-card" style="font-size: 1.3rem; line-height: 1.5;">
          <h3>Competition Objectives</h3>
          <p>The challenge aimed to:</p>
          <ul>
            <li>Apply the HTML and basic CSS skills learned during the first five weeks of Grade 10 Computer Programming.</li>
            <li>Develop informative webpages that promote healthy nutrition and balanced eating habits.</li>
            <li>Strengthen students' creativity, logical thinking, and webpage design skills.</li>
            <li>Encourage students to communicate health information through technology.</li>
            <li>Inspire students to explore additional HTML and CSS techniques beyond the classroom lessons.</li>
          </ul>
        </article>

        <article class="overview-card" style="font-size: 1.1rem; line-height: 1.5;">
          <h3>What Students Learned</h3>
          <p>Before participating in the competition, students successfully completed lessons on:</p>
          <ul>
            <li>HTML document structure</li>
            <li>Headings and paragraphs</li>
            <li>Text formatting</li>
            <li>Ordered and unordered lists</li>
            <li>Hyperlinks</li>
            <li>Images, Tables, and Forms</li>
            <li>Basic CSS styling & Background colors</li>
          </ul>
          <p style="margin-top: 10px;">These lessons became the foundation for the webpages showcased in this competition.</p>
        </article>

        <article class="overview-card" style="font-size: 1.1rem; line-height: 1.5;">
          <h3>Competition Requirements</h3>
          <p>Each participant created one (1) informative HTML webpage that included:</p>
          <ul>
            <li>A webpage title and a main heading</li>
            <li>Informative paragraphs</li>
            <li>Healthy Plate image</li>
            <li>Healthy food recommendations</li>
            <li>Lists and Tables</li>
            <li>Appropriate CSS webpage styling</li>
          </ul>
        </article>

        <article class="overview-card custom-full-width" style="font-size: 1.2rem; line-height: 1.5;">
          <h3>Innovation Through Advanced HTML & CSS</h3>
          <p>
            Students were encouraged to go beyond the required competencies by independently exploring additional HTML and CSS techniques. Participants who incorporated advanced webpage features—such as improved layouts, additional HTML elements, enhanced CSS styling, multimedia integration, semantic HTML tags, responsive design concepts, or other creative webpage enhancements—received additional consideration under the Technical Skills and Creativity criteria.
          </p>
          <p style="margin-top: 10px;">
            Students who used only the HTML and CSS concepts covered during the first five weeks were not penalized. The innovation component simply recognized learners who demonstrated initiative by applying techniques beyond the classroom lessons.
          </p>
        </article>
      </div>
    </section>

    <section>
      <h2>Student Webpage Showcase</h2>
      <p class="hint">The webpages featured below represent the creativity, technical skills, and hard work of the 18 Grade 10 Computer Programming students who participated in the Code for Nutrition 2026: Healthy Plate Webpage Challenge.<br><br>Each project reflects the students' understanding of HTML and basic CSS while promoting nutrition awareness through educational web design.</p>
      
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
      <h2>Facilitator & Judges</h2>
      <p class="overview-lead">The success of the Code for Nutrition 2026: Healthy Plate Webpage Challenge was made possible through the guidance of dedicated educators and professionals who facilitated the activity and evaluated the students' outputs based on technical excellence and nutrition content.</p>
      <br><p class="hint"><i>Click on any card to view the person's profile.</i></p><br>
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
    <p>© 2026 Malainen Bago Integrated School<br>Code for Nutrition 2026: Healthy Plate Webpage Challenge<br>Empowering Digital Creativity Through Nutrition Education.</p>
  </footer>
</body>
</html>
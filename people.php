<?php
$peopleProfiles = [
  [
    'slug' => 'honeylynne-soriano',
    'name' => 'Ms. HONEYLYNNE A. SORIANO',
    'role' => 'Facilitator / Teacher',
    'details' => 'Dedicated ICT Educator and Company System Developer with more than ten years of experience in website development, systems implementation, workflow automation, and project management.',
    'photo' => 'profiles/Honey.jpg',
    'bio' => 'She teaches Grade 10 TLE – Computer Programming and facilitates practical coding sessions in the ICT Laboratory.',
    'link' => 'profiles/honeylynne-soriano.html'
  ],
  [
    'slug' => 'ferdinan-rieta',
    'name' => 'Mr. Ferdinan Rieta',
    'role' => 'Technical and Coding Judge',
    'details' => 'An accomplished Information Technology professional with strong experience in information systems, web development, and digital operations.',
    'photo' => 'profiles/Ferdinan.jpg',
    'bio' => 'He brings valuable industry experience and technical expertise to the evaluation of student outputs.',
    'link' => 'profiles/ferdinan-rieta.html'
  ],
  [
    'slug' => 'tizza-rama-munoz',
    'name' => 'Ms. Tizza Rama Muñoz',
    'role' => 'Nutrition and Health Judge',
    'details' => 'A dedicated judge with a healthcare background who supports students in promoting health, nutrition, and wellness through creativity and technology.',
    'photo' => 'profiles/Tizza.jpg',
    'bio' => 'She is honored to serve as a judge and support learners in promoting health, nutrition, and environmental stewardship.',
    'link' => 'profiles/judge-2.html'
  ]
];

function getPersonBySlug($slug) {
  global $peopleProfiles;

  foreach ($peopleProfiles as $person) {
    if (($person['slug'] ?? '') === $slug) {
      return $person;
    }
  }

  return null;
}
?>

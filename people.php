<?php
$peopleProfiles = [
  [
    'slug' => 'honeylynne-soriano',
    'name' => 'Ms. HONEYLYNNE A. SORIANO',
    'role' => 'Activity Facilitator',
    'details' => 'Grade 10 TLE – Computer Programming Teacher',
    'photo' => 'profiles/Honey.jpg',
    'bio' => 'She teaches Grade 10 TLE – Computer Programming and facilitates practical coding sessions in the ICT Laboratory.',
    'link' => 'profiles/honeylynne-soriano.html'
  ],
  [
    'slug' => 'ferdinan-rieta',
    'name' => 'Mr. Ferdinan Rieta',
    'role' => 'Technical Judge',
    'details' => 'Evaluated HTML coding accuracy, webpage design, technical implementation, innovation, and user experience.',
    'photo' => 'profiles/Ferdinan.jpg',
    'bio' => 'He brings valuable industry experience and technical expertise to the evaluation of student outputs.',
    'link' => 'profiles/ferdinan-rieta.html'
  ],
  [
    'slug' => 'tizza-rama-munoz',
    'name' => 'Ms. Tizza Rama Muñoz',
    'role' => 'Nutrition and Health Judge',
    'details' => 'Evaluated nutrition accuracy, healthy plate concepts, educational value, and relevance to the Nutrition Month theme.',
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

<?php
/**
 * JSON-LD Schema generator
 *
 * Variables (set before including):
 *   $schema_type — 'organization', 'service', 'faq', 'webpage', 'breadcrumb'
 *   $schema_data — Associative array with schema-specific data
 *
 * Organization schema is always output.
 * Page-specific schema is output conditionally based on $schema_type.
 */

$schema_type = isset($schema_type) ? $schema_type : 'webpage';
$schema_data = isset($schema_data) ? $schema_data : [];

// --- Organization schema (always present) ---
$org_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'Automation SeQure',
    'url' => 'https://automationsequre.nl',
    'description' => 'AI-automatisering en AI governance voor bedrijven en gemeenten',
    'email' => 'info@automationsequre.nl',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Almere',
        'addressCountry' => 'NL'
    ]
];
?>
<script type="application/ld+json"><?= json_encode($org_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
<?php

// --- Page-specific schema ---
if ($schema_type === 'service' && !empty($schema_data)):
    $service_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $schema_data['name'] ?? '',
        'description' => $schema_data['description'] ?? '',
        'provider' => [
            '@type' => 'Organization',
            'name' => 'Automation SeQure'
        ],
        'url' => $schema_data['url'] ?? '',
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'NL'
        ]
    ];
    if (!empty($schema_data['offers'])) {
        $service_schema['offers'] = $schema_data['offers'];
    }
?>
<script type="application/ld+json"><?= json_encode($service_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
<?php endif; ?>

<?php if ($schema_type === 'faq' && !empty($schema_data['questions'])):
    $faq_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => []
    ];
    foreach ($schema_data['questions'] as $q) {
        $faq_schema['mainEntity'][] = [
            '@type' => 'Question',
            'name' => $q['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $q['answer']
            ]
        ];
    }
?>
<script type="application/ld+json"><?= json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
<?php endif; ?>

<?php if ($schema_type === 'webpage' && !empty($schema_data)):
    $webpage_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $schema_data['name'] ?? '',
        'description' => $schema_data['description'] ?? '',
        'url' => $schema_data['url'] ?? '',
        'inLanguage' => 'nl-NL',
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => 'Automation SeQure',
            'url' => 'https://automationsequre.nl'
        ]
    ];
?>
<script type="application/ld+json"><?= json_encode($webpage_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
<?php endif; ?>

<?php if ($schema_type === 'breadcrumb' && !empty($schema_data['items'])):
    $breadcrumb_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => []
    ];
    $position = 1;
    foreach ($schema_data['items'] as $item) {
        $breadcrumb_schema['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $item['name'],
            'item' => $item['url']
        ];
        $position++;
    }
?>
<script type="application/ld+json"><?= json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?></script>
<?php endif; ?>

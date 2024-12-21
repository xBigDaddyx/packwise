<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description"
        content="Suitify, is an innovative hotel management system designed to streamline hotel operations, improve guest satisfaction, and drive efficiency. With a focus on simplicity, adaptability, and cutting-edge features, Suitify empowers hotels to deliver exceptional service in today’s fast-paced, digital world." />
    <link rel="canonical" href="https://suitify.cloud/" />

    <!-- Robots & Indexing -->
    <meta name="robots" content="index, follow" />

    <!-- Keyword Tags (Less impactful nowadays, but still can be included) -->
    <meta name="keywords"
        content="Suitify, hotel management system, cloud-based hotel software, hospitality management, hotel booking system, reservation management, property management system, hotel operations software, housekeeping automation, guest communication tools, revenue management, hotel software solution, hotel technology, seamless hotel management, hotel management platform, modern hotel software, online hotel management, hotel business tools, efficient hotel operations, hotel management services" />

    <!-- Favicon & App Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#000000">

    <!-- Structured Data (Example: JSON-LD Schema.org) -->
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "SoftwareApplication",
            "name": "Suitify",
            "url": "https://suitify.cloud/",
            "image": "https://suitify.cloud/images/og.webp",
            "description": "Suitify, is an innovative hotel management system designed to streamline hotel operations, improve guest satisfaction, and drive efficiency. With a focus on simplicity, adaptability, and cutting-edge features, Suitify empowers hotels to deliver exceptional service in today’s fast-paced, digital world.",
            "applicationCategory": "SoftwareApplication",
            "operatingSystem": "All",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "USD",
                "category": "Free"
            }
        }
    </script>

    <!-- Basic OG Tags -->
    <meta property="og:title" content="Suitify - Your hotel management system" />
    <meta property="og:description"
        content="Suitify, is an innovative hotel management system designed to streamline hotel operations, improve guest satisfaction, and drive efficiency. With a focus on simplicity, adaptability, and cutting-edge features, Suitify empowers hotels to deliver exceptional service in today’s fast-paced, digital world." />
    <meta property="og:url" content="https://suitify.cloud" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://suitify.cloud/images/og.webp" />

    <!-- Optional: Additional Tags -->
    <meta property="og:site_name" content="Suitify" />
    <meta property="og:locale" content="en_US" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Suitify - Your hotel management system" />
    <meta name="twitter:description"
        content="Suitify, is an innovative hotel management system designed to streamline hotel operations, improve guest satisfaction, and drive efficiency. With a focus on simplicity, adaptability, and cutting-edge features, Suitify empowers hotels to deliver exceptional service in today’s fast-paced, digital world." />
    <meta name="twitter:image" content="https://suitify.cloud/images/og.webp" />
    <meta name="twitter:site" content="@YourTwitterHandle" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>

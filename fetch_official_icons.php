<?php
// Script to download official SVGs from Devicon and Simple-Icons repositories

$dir = __DIR__ . '/assets/images/tech';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

$tech_urls = [
    'php' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg',
    'mysql' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original.svg',
    'javascript' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/javascript/javascript-original.svg',
    'typescript' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/typescript/typescript-original.svg',
    'html5' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/html5/html5-original.svg',
    'css3' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/css3/css3-original.svg',
    'tailwind' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/tailwindcss/tailwindcss-original.svg',
    'threejs' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/threejs/threejs-original.svg',
    'react' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/react/react-original.svg',
    'nodejs' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/nodejs/nodejs-original.svg',
    'electron' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/electron/electron-original.svg',
    'expo' => 'https://raw.githubusercontent.com/simple-icons/simple-icons/develop/icons/expo.svg',
    'anthropic' => 'https://raw.githubusercontent.com/simple-icons/simple-icons/develop/icons/anthropic.svg',
    'python' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/python/python-original.svg',
    'git' => 'https://raw.githubusercontent.com/devicons/devicon/master/icons/git/git-original.svg'
];

foreach ($tech_urls as $name => $url) {
    $content = @file_get_contents($url);
    if ($content && strlen($content) > 50) {
        file_put_contents($dir . '/' . $name . '.svg', $content);
        echo "Successfully fetched official SVG for: " . $name . "\n";
    } else {
        echo "Failed to fetch: " . $name . " from " . $url . "\n";
    }
}

echo "Icon fetch complete!\n";
?>

<?php
// Script to generate SVG icons for all 15 developer technologies

$dir = __DIR__ . '/assets/images/tech';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// 1. PHP 8+
$php = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 2C6.477 2 2 6.477 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="#777BB4" fill-opacity="0.15"/>
  <text x="12" y="16" font-family="sans-serif" font-size="10" font-weight="900" fill="#777BB4" text-anchor="middle">PHP</text>
</svg>';

// 2. MySQL
$mysql = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 2C6.477 2 2 6.477 2 12C2 17.523 6.477 22 12 22C17.523 22 22 17.523 22 12C22 6.477 17.523 2 12 2Z" fill="#00758F" fill-opacity="0.15"/>
  <path d="M7 16V10L10 14L13 10V16" stroke="#00758F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M17 16V10" stroke="#00758F" stroke-width="2" stroke-linecap="round"/>
</svg>';

// 3. JavaScript
$js = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect x="2" y="2" width="20" height="20" rx="4" fill="#F7DF1E"/>
  <path d="M13 18C13 16 14.5 15.5 15.5 15.5C16.5 15.5 17 16 17 17C17 18.5 15 19 14.5 19.5" stroke="#181816" stroke-width="1.8" stroke-linecap="round"/>
  <path d="M8 14V18C8 19.5 6.5 19 6 18.5" stroke="#181816" stroke-width="1.8" stroke-linecap="round"/>
</svg>';

// 4. TypeScript
$ts = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect x="2" y="2" width="20" height="20" rx="4" fill="#3178C6"/>
  <text x="12" y="16" font-family="sans-serif" font-size="11" font-weight="bold" fill="#FFFFFF" text-anchor="middle">TS</text>
</svg>';

// 5. HTML5
$html5 = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M3 3L5 20L12 22L19 20L21 3H3Z" fill="#E34F26" fill-opacity="0.15" stroke="#E34F26" stroke-width="1.5"/>
  <path d="M7 7H17L16.5 11H7.5L8 15L12 16L16 15L16.2 13" stroke="#E34F26" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';

// 6. CSS3
$css3 = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M3 3L5 20L12 22L19 20L21 3H3Z" fill="#1572B6" fill-opacity="0.15" stroke="#1572B6" stroke-width="1.5"/>
  <path d="M17 7H7L7.5 11H16.5L16 15L12 16L8 15" stroke="#1572B6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';

// 7. Tailwind CSS
$tailwind = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 6C9 6 7.5 7.5 7.5 10.5C7.5 12 8.25 12.75 9 13.5C10.5 15 12 15.75 12 18C12 20 10.5 21 8 21C5.5 21 4.5 19.5 4.5 19.5M16.5 3C13.5 3 12 4.5 12 7.5C12 9 12.75 9.75 13.5 10.5C15 12 16.5 12.75 16.5 15C16.5 17 15 18 12.5 18" stroke="#38BDF8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';

// 8. Three.js
$threejs = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 2L2 20H22L12 2Z" fill="#181816" fill-opacity="0.15" stroke="#181816" stroke-width="1.5"/>
  <path d="M12 6L6 17H18L12 6Z" fill="#181816"/>
</svg>';

// 9. React Native
$react = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <ellipse cx="12" cy="12" rx="9" ry="4" stroke="#61DAFB" stroke-width="1.5" transform="rotate(30 12 12)"/>
  <ellipse cx="12" cy="12" rx="9" ry="4" stroke="#61DAFB" stroke-width="1.5" transform="rotate(90 12 12)"/>
  <ellipse cx="12" cy="12" rx="9" ry="4" stroke="#61DAFB" stroke-width="1.5" transform="rotate(150 12 12)"/>
  <circle cx="12" cy="12" r="2" fill="#61DAFB"/>
</svg>';

// 10. Node.js
$nodejs = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 2L21 7V17L12 22L3 17V7L12 2Z" fill="#339933" fill-opacity="0.15" stroke="#339933" stroke-width="1.5"/>
  <path d="M12 6V18M7 9.5L17 14.5M17 9.5L7 14.5" stroke="#339933" stroke-width="1.5" stroke-linecap="round"/>
</svg>';

// 11. Electron
$electron = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <ellipse cx="12" cy="12" rx="9" ry="3.5" stroke="#47848F" stroke-width="1.5" transform="rotate(0 12 12)"/>
  <ellipse cx="12" cy="12" rx="9" ry="3.5" stroke="#47848F" stroke-width="1.5" transform="rotate(60 12 12)"/>
  <ellipse cx="12" cy="12" rx="9" ry="3.5" stroke="#47848F" stroke-width="1.5" transform="rotate(120 12 12)"/>
  <circle cx="12" cy="12" r="1.8" fill="#47848F"/>
</svg>';

// 12. Expo
$expo = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M4 19L12 4L20 19H4Z" stroke="#000000" stroke-width="2" stroke-linejoin="round"/>
  <path d="M9 13L12 8L15 13H9Z" fill="#000000"/>
</svg>';

// 13. Anthropic AI Tools (Claude AI Symbol)
$anthropic = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M12 2V22M2 12H22M4.93 4.93L19.07 19.07M4.93 19.07L19.07 4.93" stroke="#D97757" stroke-width="2.2" stroke-linecap="round"/>
</svg>';

// 14. Python
$python = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M11.5 2C7.5 2 7 3.5 7 5.5V8.5H12V9.5H5.5C3.5 9.5 2 11 2 13.5C2 16 3.5 17.5 5.5 17.5H7.5V15.5C7.5 13.5 9 12 11 12H14V9.5C14 7.5 12.5 6 10.5 6H7.5" fill="#3776AB" fill-opacity="0.2" stroke="#3776AB" stroke-width="1.2"/>
  <path d="M12.5 22C16.5 22 17 20.5 17 18.5V15.5H12V14.5H18.5C20.5 14.5 22 13 22 10.5C22 8 20.5 6.5 18.5 6.5H16.5V8.5C16.5 10.5 15 12 13 12H10V14.5C10 16.5 11.5 18 13.5 18H16.5" fill="#FFD43B" fill-opacity="0.3" stroke="#D4A017" stroke-width="1.2"/>
  <circle cx="9.5" cy="4.5" r="1" fill="#3776AB"/>
  <circle cx="14.5" cy="19.5" r="1" fill="#D4A017"/>
</svg>';

// 15. Git & GitHub
$git = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M21 11.5L12.5 3C12.2 2.7 11.8 2.7 11.5 3L3 11.5C2.7 11.8 2.7 12.2 3 12.5L11.5 21C11.8 21.3 12.2 21.3 12.5 21L21 12.5C21.3 12.2 21.3 11.8 21 11.5Z" fill="#F05032" fill-opacity="0.15" stroke="#F05032" stroke-width="1.5"/>
  <circle cx="15" cy="9" r="2" fill="#F05032"/>
  <circle cx="9" cy="15" r="2" fill="#F05032"/>
  <circle cx="9" cy="9" r="2" fill="#F05032"/>
  <path d="M9 11V13M9 15L13.5 10.5" stroke="#F05032" stroke-width="1.5" stroke-linecap="round"/>
</svg>';

file_put_contents($dir . '/php.svg', $php);
file_put_contents($dir . '/mysql.svg', $mysql);
file_put_contents($dir . '/javascript.svg', $js);
file_put_contents($dir . '/typescript.svg', $ts);
file_put_contents($dir . '/html5.svg', $html5);
file_put_contents($dir . '/css3.svg', $css3);
file_put_contents($dir . '/tailwind.svg', $tailwind);
file_put_contents($dir . '/threejs.svg', $threejs);
file_put_contents($dir . '/react.svg', $react);
file_put_contents($dir . '/nodejs.svg', $nodejs);
file_put_contents($dir . '/electron.svg', $electron);
file_put_contents($dir . '/expo.svg', $expo);
file_put_contents($dir . '/anthropic.svg', $anthropic);
file_put_contents($dir . '/python.svg', $python);
file_put_contents($dir . '/git.svg', $git);

echo "All 15 Developer SVG Icons created successfully!\n";
?>

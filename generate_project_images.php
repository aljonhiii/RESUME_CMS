<?php
// Script to generate SVG Mockup Images for Aljon Reyes's Portfolio Projects

$dir = __DIR__ . '/assets/images';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// Project 1 SVG: Zamboanga Tour Guide Booking System
$svg1 = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="800" height="520" viewBox="0 0 800 520" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect width="800" height="520" rx="20" fill="#E6E5E0"/>
  <!-- App Window Container -->
  <rect x="40" y="40" width="720" height="440" rx="16" fill="#F5F4F0" stroke="#181816" stroke-opacity="0.12" stroke-width="2"/>
  <!-- Top Bar -->
  <path d="M40 56C40 47.1634 47.1634 40 56 40H744C752.837 40 760 47.1634 760 56V80H40V56Z" fill="#181816"/>
  <circle cx="64" cy="60" r="5" fill="#FF5F56"/>
  <circle cx="80" cy="60" r="5" fill="#FFBD2E"/>
  <circle cx="96" cy="60" r="5" fill="#27C93F"/>
  <text x="400" y="64" fill="#E6E5E0" font-family="sans-serif" font-size="12" font-weight="600" text-anchor="middle" letter-spacing="1">ZAMBOANGA TOUR GUIDE BOOKING SYSTEM</text>
  
  <!-- Sidebar -->
  <rect x="60" y="100" width="180" height="360" rx="10" fill="#5B695C"/>
  <text x="80" y="135" fill="#F5F4F0" font-family="sans-serif" font-size="14" font-weight="bold">EXPLORE ZAMBOANGA</text>
  <rect x="75" y="160" width="150" height="32" rx="6" fill="#F5F4F0" fill-opacity="0.2"/>
  <text x="90" y="181" fill="#F5F4F0" font-family="sans-serif" font-size="12">🗺️ Fort Pilar Tour</text>
  <rect x="75" y="202" width="150" height="32" rx="6" fill="#F5F4F0" fill-opacity="0.1"/>
  <text x="90" y="223" fill="#F5F4F0" font-family="sans-serif" font-size="12">🏝️ Santa Cruz Island</text>
  <rect x="75" y="244" width="150" height="32" rx="6" fill="#F5F4F0" fill-opacity="0.1"/>
  <text x="90" y="265" fill="#F5F4F0" font-family="sans-serif" font-size="12">⛵ Vinta Regatta</text>
  
  <rect x="75" y="380" width="150" height="40" rx="8" fill="#181816"/>
  <text x="150" y="405" fill="#F5F4F0" font-family="sans-serif" font-size="12" font-weight="bold" text-anchor="middle">Book Guide Now →</text>

  <!-- Main Content Grid -->
  <rect x="260" y="100" width="480" height="170" rx="10" fill="#FFFFFF" stroke="#181816" stroke-opacity="0.08"/>
  <text x="280" y="130" fill="#181816" font-family="sans-serif" font-size="16" font-weight="bold">Featured Local Guide: Maria Santos</text>
  <text x="280" y="152" fill="#555555" font-family="sans-serif" font-size="12">Certified Cultural & Heritage Specialist • 4.9 ★ (128 reviews)</text>
  <rect x="280" y="170" width="100" height="26" rx="13" fill="#5B695C" fill-opacity="0.15"/>
  <text x="330" y="187" fill="#5B695C" font-family="sans-serif" font-size="11" font-weight="bold" text-anchor="middle">Chavacano / EN</text>
  <rect x="390" y="170" width="120" height="26" rx="13" fill="#5B695C" fill-opacity="0.15"/>
  <text x="450" y="187" fill="#5B695C" font-family="sans-serif" font-size="11" font-weight="bold" text-anchor="middle">History Specialist</text>

  <rect x="280" y="210" width="440" height="42" rx="8" fill="#F5F4F0"/>
  <text x="300" y="235" fill="#181816" font-family="sans-serif" font-size="12" font-weight="500">Selected Date: Oct 12, 2026 | Slots: 3 Available | Status: Verified</text>

  <!-- Two Cards Below -->
  <rect x="260" y="285" width="230" height="175" rx="10" fill="#FFFFFF" stroke="#181816" stroke-opacity="0.08"/>
  <text x="275" y="315" fill="#181816" font-family="sans-serif" font-size="14" font-weight="bold">Booking Calendar</text>
  <rect x="275" y="330" width="200" height="110" rx="6" fill="#E6E5E0" fill-opacity="0.5"/>
  <text x="375" y="390" fill="#5B695C" font-family="sans-serif" font-size="12" font-weight="bold" text-anchor="middle">PHP PDO Calendar API</text>

  <rect x="510" y="285" width="230" height="175" rx="10" fill="#FFFFFF" stroke="#181816" stroke-opacity="0.08"/>
  <text x="525" y="315" fill="#181816" font-family="sans-serif" font-size="14" font-weight="bold">Tourist Reviews</text>
  <rect x="525" y="330" width="200" height="110" rx="6" fill="#E6E5E0" fill-opacity="0.5"/>
  <text x="625" y="390" fill="#5B695C" font-family="sans-serif" font-size="12" font-weight="bold" text-anchor="middle">Verified Feedback</text>
</svg>';

// Project 2 SVG: ERP Help Desk Ticketing System
$svg2 = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="800" height="520" viewBox="0 0 800 520" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect width="800" height="520" rx="20" fill="#181816"/>
  <!-- App Container -->
  <rect x="40" y="40" width="720" height="440" rx="16" fill="#242422" stroke="#5B695C" stroke-width="1.5"/>
  
  <!-- Header Bar -->
  <rect x="40" y="40" width="720" height="48" rx="16" fill="#2D2D2A"/>
  <circle cx="64" cy="64" r="5" fill="#FF5F56"/>
  <circle cx="80" cy="64" r="5" fill="#FFBD2E"/>
  <circle cx="96" cy="64" r="5" fill="#27C93F"/>
  <text x="400" y="68" fill="#8A9A86" font-family="sans-serif" font-size="12" font-weight="bold" text-anchor="middle" letter-spacing="1">ERP HELP DESK TICKETING SYSTEM</text>

  <!-- Metrics Row -->
  <rect x="60" y="105" width="155" height="85" rx="10" fill="#181816"/>
  <text x="80" y="130" fill="#8A9A86" font-family="sans-serif" font-size="11" font-weight="600">OPEN TICKETS</text>
  <text x="80" y="165" fill="#F5F4F0" font-family="sans-serif" font-size="28" font-weight="bold">42</text>

  <rect x="230" y="105" width="155" height="85" rx="10" fill="#181816"/>
  <text x="250" y="130" fill="#8A9A86" font-family="sans-serif" font-size="11" font-weight="600">RESOLVED TODAY</text>
  <text x="250" y="165" fill="#5B695C" font-family="sans-serif" font-size="28" font-weight="bold">128</text>

  <rect x="400" y="105" width="155" height="85" rx="10" fill="#181816"/>
  <text x="420" y="130" fill="#8A9A86" font-family="sans-serif" font-size="11" font-weight="600">AVG RESPONSE</text>
  <text x="420" y="165" fill="#F5F4F0" font-family="sans-serif" font-size="28" font-weight="bold">14m</text>

  <rect x="570" y="105" width="150" height="85" rx="10" fill="#5B695C"/>
  <text x="645" y="142" fill="#F5F4F0" font-family="sans-serif" font-size="13" font-weight="bold" text-anchor="middle">+ New Ticket</text>
  <text x="645" y="162" fill="#F5F4F0" fill-opacity="0.7" font-family="sans-serif" font-size="11" text-anchor="middle">Express / Node API</text>

  <!-- Ticket Table -->
  <rect x="60" y="210" width="660" height="245" rx="10" fill="#181816"/>
  <text x="85" y="240" fill="#8A9A86" font-family="sans-serif" font-size="12" font-weight="bold">TICKET ID</text>
  <text x="200" y="240" fill="#8A9A86" font-family="sans-serif" font-size="12" font-weight="bold">SUBJECT</text>
  <text x="450" y="240" fill="#8A9A86" font-family="sans-serif" font-size="12" font-weight="bold">PRIORITY</text>
  <text x="580" y="240" fill="#8A9A86" font-family="sans-serif" font-size="12" font-weight="bold">STATUS</text>
  <line x1="60" y1="252" x2="720" y2="252" stroke="#2D2D2A" stroke-width="1"/>

  <!-- Row 1 -->
  <text x="85" y="280" fill="#F5F4F0" font-family="monospace" font-size="12">#TK-8902</text>
  <text x="200" y="280" fill="#F5F4F0" font-family="sans-serif" font-size="12">Database connection latency spike</text>
  <rect x="450" y="265" width="60" height="22" rx="4" fill="#FF5F56" fill-opacity="0.2"/>
  <text x="480" y="280" fill="#FF5F56" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">HIGH</text>
  <rect x="580" y="265" width="80" height="22" rx="4" fill="#FFBD2E" fill-opacity="0.2"/>
  <text x="620" y="280" fill="#FFBD2E" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">IN PROGRESS</text>

  <!-- Row 2 -->
  <text x="85" y="325" fill="#F5F4F0" font-family="monospace" font-size="12">#TK-8903</text>
  <text x="200" y="325" fill="#F5F4F0" font-family="sans-serif" font-size="12">ERP User clearance & permissions</text>
  <rect x="450" y="310" width="60" height="22" rx="4" fill="#5B695C" fill-opacity="0.4"/>
  <text x="480" y="325" fill="#8A9A86" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">MED</text>
  <rect x="580" y="310" width="80" height="22" rx="4" fill="#27C93F" fill-opacity="0.2"/>
  <text x="620" y="325" fill="#27C93F" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">RESOLVED</text>

  <!-- Row 3 -->
  <text x="85" y="370" fill="#F5F4F0" font-family="monospace" font-size="12">#TK-8904</text>
  <text x="200" y="370" fill="#F5F4F0" font-family="sans-serif" font-size="12">Server SSL certificate renewal</text>
  <rect x="450" y="355" width="60" height="22" rx="4" fill="#FF5F56" fill-opacity="0.2"/>
  <text x="480" y="370" fill="#FF5F56" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">CRITICAL</text>
  <rect x="580" y="355" width="80" height="22" rx="4" fill="#5B695C" fill-opacity="0.4"/>
  <text x="620" y="370" fill="#F5F4F0" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">ASSIGNED</text>
</svg>';

// Project 3 SVG: LipatDorm Moving & Cargo-Sharing Platform
$svg3 = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="800" height="520" viewBox="0 0 800 520" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect width="800" height="520" rx="20" fill="#E6E5E0"/>
  <!-- Mobile Phone Mockup Center Left -->
  <rect x="120" y="40" width="240" height="440" rx="36" fill="#181816" stroke="#5B695C" stroke-width="4"/>
  <rect x="135" y="55" width="210" height="410" rx="26" fill="#F5F4F0"/>
  <!-- Phone Notch -->
  <rect x="195" y="62" width="90" height="18" rx="9" fill="#181816"/>
  <!-- Phone App UI -->
  <text x="240" y="105" fill="#181816" font-family="sans-serif" font-size="16" font-weight="bold" text-anchor="middle">LipatDorm App</text>
  <text x="240" y="122" fill="#5B695C" font-family="sans-serif" font-size="11" font-weight="600" text-anchor="middle">DORM & CARGO SHARING</text>

  <!-- Route Map Box -->
  <rect x="150" y="135" width="180" height="160" rx="14" fill="#E6E5E0"/>
  <path d="M165 240 Q 210 160 315 220" stroke="#5B695C" stroke-width="4" stroke-dasharray="6 6" fill="none"/>
  <circle cx="165" cy="240" r="7" fill="#181816"/>
  <circle cx="315" cy="220" r="7" fill="#5B695C"/>
  <text x="175" y="275" fill="#181816" font-family="sans-serif" font-size="10" font-weight="bold">A: Campus Dorm</text>
  <text x="250" y="275" fill="#5B695C" font-family="sans-serif" font-size="10" font-weight="bold">B: New Apartment</text>

  <!-- Vehicle Options -->
  <rect x="150" y="305" width="180" height="45" rx="10" fill="#181816"/>
  <text x="165" y="332" fill="#F5F4F0" font-family="sans-serif" font-size="12" font-weight="bold">🚚 Shared Pickup</text>
  <text x="315" y="332" fill="#8A9A86" font-family="sans-serif" font-size="12" font-weight="bold" text-anchor="end">₱350</text>

  <rect x="150" y="358" width="180" height="45" rx="10" fill="#5B695C"/>
  <text x="240" y="385" fill="#F5F4F0" font-family="sans-serif" font-size="13" font-weight="bold" text-anchor="middle">Confirm Booking →</text>

  <!-- Desktop Dashboard Preview Right -->
  <rect x="400" y="80" width="340" height="360" rx="16" fill="#FFFFFF" stroke="#181816" stroke-opacity="0.1" stroke-width="2"/>
  <rect x="400" y="80" width="340" height="45" rx="16" fill="#5B695C"/>
  <text x="570" y="108" fill="#F5F4F0" font-family="sans-serif" font-size="14" font-weight="bold" text-anchor="middle">Dorm Moving Logistics Hub</text>

  <rect x="420" y="145" width="300" height="70" rx="8" fill="#F5F4F0"/>
  <text x="435" y="170" fill="#181816" font-family="sans-serif" font-size="13" font-weight="bold">React Native & Node Express Integration</text>
  <text x="435" y="195" fill="#555555" font-family="sans-serif" font-size="11">Real-time driver matching & automated fare calculation</text>

  <rect x="420" y="230" width="140" height="80" rx="8" fill="#E6E5E0"/>
  <text x="490" y="265" fill="#181816" font-family="sans-serif" font-size="20" font-weight="bold" text-anchor="middle">850+</text>
  <text x="490" y="290" fill="#5B695C" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">MOVES COMPLETED</text>

  <rect x="580" y="230" width="140" height="80" rx="8" fill="#E6E5E0"/>
  <text x="650" y="265" fill="#5B695C" font-family="sans-serif" font-size="20" font-weight="bold" text-anchor="middle">40%</text>
  <text x="650" y="290" fill="#181816" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">COST REDUCTION</text>

  <rect x="420" y="325" width="300" height="90" rx="8" fill="#181816"/>
  <text x="570" y="365" fill="#F5F4F0" font-family="sans-serif" font-size="14" font-weight="bold" text-anchor="middle">Proposed Cargo-Sharing Protocol</text>
  <text x="570" y="388" fill="#8A9A86" font-family="sans-serif" font-size="11" text-anchor="middle">MySQL Spatial Querying & Dynamic Dispatch</text>
</svg>';

// Project 4 SVG: Student Attendance & Academic Performance Management System
$svg4 = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="800" height="520" viewBox="0 0 800 520" fill="none" xmlns="http://www.w3.org/2000/svg">
  <rect width="800" height="520" rx="20" fill="#F5F4F0"/>
  <rect x="40" y="40" width="720" height="440" rx="16" fill="#FFFFFF" stroke="#181816" stroke-opacity="0.1" stroke-width="2"/>

  <!-- Top bar -->
  <rect x="40" y="40" width="720" height="55" rx="16" fill="#181816"/>
  <text x="70" y="73" fill="#F5F4F0" font-family="sans-serif" font-size="15" font-weight="bold">ACADEMIC PERFORMANCE & ATTENDANCE SYSTEM</text>
  <rect x="580" y="55" width="160" height="26" rx="13" fill="#5B695C"/>
  <text x="660" y="72" fill="#F5F4F0" font-family="sans-serif" font-size="11" font-weight="bold" text-anchor="middle">BS Computer Tech</text>

  <!-- Left Stats Panel -->
  <rect x="65" y="115" width="310" height="150" rx="12" fill="#E6E5E0"/>
  <text x="85" y="145" fill="#181816" font-family="sans-serif" font-size="14" font-weight="bold">ATTENDANCE OVERVIEW</text>
  <!-- Chart Bars -->
  <rect x="90" y="210" width="24" height="30" rx="4" fill="#5B695C"/>
  <rect x="130" y="180" width="24" height="60" rx="4" fill="#5B695C"/>
  <rect x="170" y="165" width="24" height="75" rx="4" fill="#181816"/>
  <rect x="210" y="175" width="24" height="65" rx="4" fill="#5B695C"/>
  <rect x="250" y="160" width="24" height="80" rx="4" fill="#181816"/>
  <rect x="290" y="190" width="24" height="50" rx="4" fill="#5B695C"/>
  <text x="210" y="258" fill="#555555" font-family="sans-serif" font-size="10" font-weight="bold" text-anchor="middle">Weekly Attendance Trend</text>

  <!-- Right At-Risk Panel -->
  <rect x="400" y="115" width="335" height="150" rx="12" fill="#5B695C" fill-opacity="0.1" stroke="#5B695C" stroke-width="1"/>
  <text x="420" y="145" fill="#181816" font-family="sans-serif" font-size="14" font-weight="bold">⚠️ Early Warning Indicator</text>
  <rect x="420" y="160" width="295" height="40" rx="6" fill="#FFFFFF"/>
  <text x="435" y="184" fill="#181816" font-family="sans-serif" font-size="12" font-weight="bold">Juan Dela Cruz — Grade: 72% | Absences: 4</text>
  <rect x="420" y="210" width="295" height="40" rx="6" fill="#FFFFFF"/>
  <text x="435" y="234" fill="#181816" font-family="sans-serif" font-size="12" font-weight="bold">Ana Reyes — Grade: 74% | Absences: 3</text>

  <!-- Bottom Table -->
  <rect x="65" y="285" width="670" height="170" rx="12" fill="#E6E5E0" fill-opacity="0.5"/>
  <text x="85" y="315" fill="#181816" font-family="sans-serif" font-size="13" font-weight="bold">STUDENT PERFORMANCE DIRECTORY</text>
  <line x1="85" y1="325" x2="715" y2="325" stroke="#181816" stroke-opacity="0.1" stroke-width="1"/>
  <text x="85" y="350" fill="#5B695C" font-family="sans-serif" font-size="11" font-weight="bold">STUDENT NAME</text>
  <text x="280" y="350" fill="#5B695C" font-family="sans-serif" font-size="11" font-weight="bold">COURSE</text>
  <text x="450" y="350" fill="#5B695C" font-family="sans-serif" font-size="11" font-weight="bold">ATTENDANCE</text>
  <text x="600" y="350" fill="#5B695C" font-family="sans-serif" font-size="11" font-weight="bold">STATUS</text>

  <text x="85" y="380" fill="#181816" font-family="sans-serif" font-size="12">Reyes, Aljon M.</text>
  <text x="280" y="380" fill="#181816" font-family="sans-serif" font-size="12">BS Application Dev</text>
  <text x="450" y="380" fill="#181816" font-family="sans-serif" font-size="12">98.5%</text>
  <text x="600" y="380" fill="#5B695C" font-family="sans-serif" font-size="12" font-weight="bold">EXCELLENT</text>

  <text x="85" y="410" fill="#181816" font-family="sans-serif" font-size="12">Santos, Gabriel P.</text>
  <text x="280" y="410" fill="#181816" font-family="sans-serif" font-size="12">BS Application Dev</text>
  <text x="450" y="410" fill="#181816" font-family="sans-serif" font-size="12">94.0%</text>
  <text x="600" y="410" fill="#5B695C" font-family="sans-serif" font-size="12" font-weight="bold">GOOD</text>
</svg>';

file_put_contents($dir . '/project1.svg', $svg1);
file_put_contents($dir . '/project2.svg', $svg2);
file_put_contents($dir . '/project3.svg', $svg3);
file_put_contents($dir . '/project4.svg', $svg4);

echo "SVG Images created successfully!\n";
?>

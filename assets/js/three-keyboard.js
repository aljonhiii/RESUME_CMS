/**
 * ALJON REYES — 3D DEVELOPER PORTFOLIO
 * Interactive 3D Mechanical Keyboard Skill Pad (Three.js + GSAP + Scroll Entrance)
 * Pitch Dark Frame, Deep Saturated Custom Keycap Palette, Solid Enclosed Chassis
 */

function init3DKeyboard() {
  const container = document.getElementById('keyboard-3d-container');
  const sectionEl = document.getElementById('skills');
  if (!container || typeof THREE === 'undefined') return;
  container.innerHTML = '';

  // Skills Dataset with Rich Dark Keycap Palette & High Contrast Icons
  // Skills Dataset with Sleek Dark Keycap Badges & 100% High-Contrast Icon Visibility
  const SKILLS_DATA = [
    {
      id: 'js',
      keyChar: 'J',
      title: 'JavaScript (ES6+)',
      category: 'Frontend & Interactive Engine',
      desc: "The dynamic engine of the web — event loops, async/await, and running everywhere from browsers to microcontrollers.",
      color: 0xF59E0B,
      sideColor: 0xD97706,
      textColor: '#FFFFFF',
      badgeBg: '#181A20',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'assets/images/tech/javascript.svg',
      col: 0, row: 0
    },
    {
      id: 'ts',
      keyChar: 'T',
      title: 'TypeScript',
      category: 'Type-Safe Architecture',
      desc: "JavaScript's overachieving cousin who's always flexing type safety, strict interfaces, and zero runtime surprises.",
      color: 0x0284C7,
      sideColor: 0x0369A1,
      textColor: '#FFFFFF',
      badgeBg: '#0F172A',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/TypeScript.svg',
      col: 1, row: 0
    },
    {
      id: 'php',
      keyChar: 'P',
      title: 'PHP 8+',
      category: 'Server-Side Core',
      desc: "The resilient legend powering dynamic web applications with modern OOP features, PDO security, and rapid performance.",
      color: 0x4F46E5,
      sideColor: 0x3730A3,
      textColor: '#FFFFFF',
      badgeBg: '#1E1B4B',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'assets/images/tech/php.svg',
      col: 2, row: 0
    },
    {
      id: 'mysql',
      keyChar: 'M',
      title: 'MySQL / MariaDB',
      category: 'Relational Database',
      desc: "The trusted vault of relational data — ACID-compliant storage, optimized queries, and normalized schemas built for scale.",
      color: 0x005C53,
      sideColor: 0x04433D,
      textColor: '#FFFFFF',
      badgeBg: '#042F2C',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/MySQL.svg',
      col: 3, row: 0
    },
    {
      id: 'html',
      keyChar: 'H',
      title: 'HTML5',
      category: 'Web Structure',
      desc: "The indestructible architectural skeleton holding together every website, application layout, and DOM structure.",
      color: 0xEA580C,
      sideColor: 0xC2410C,
      textColor: '#FFFFFF',
      badgeBg: '#431407',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/HTML5.svg',
      col: 4, row: 0
    },

    {
      id: 'css',
      keyChar: 'C',
      title: 'CSS3',
      category: 'Visual Styling & Layout',
      desc: "Styling mastercraft turning plain HTML blueprints into pixel-perfect visual art with smooth animations and responsive flexbox/grid.",
      color: 0x2563EB,
      sideColor: 0x1D4ED8,
      textColor: '#FFFFFF',
      badgeBg: '#172554',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/CSS3.svg',
      col: 0, row: 1
    },
    {
      id: 'tailwind',
      keyChar: 'W',
      title: 'Tailwind CSS',
      category: 'Utility-First Styling',
      desc: "Utility-first CSS speed run — bespoke design systems, rapid UI prototyping, and zero context switching.",
      color: 0x0284C7,
      sideColor: 0x0369A1,
      textColor: '#FFFFFF',
      badgeBg: '#0F172A',
      badgeBorder: '#38BDF8',
      icon: 'svgs/Tailwind CSS.svg',
      col: 1, row: 1
    },
    {
      id: 'three',
      keyChar: '3',
      title: 'Three.js & WebGL',
      category: '3D Web Graphics',
      desc: "Breaking out of 2D flatland — GPU-accelerated WebGL 3D scenes, camera controls, custom lighting, and interactive spatial visuals.",
      color: 0x18181B,
      sideColor: 0x09090B,
      textColor: '#FFFFFF',
      badgeBg: '#12141A',
      badgeBorder: 'rgba(255, 255, 255, 0.3)',
      icon: 'svgs/Three.js.svg',
      invertIcon: true,
      col: 2, row: 1
    },
    {
      id: 'react',
      keyChar: 'R',
      title: 'React Native',
      category: 'Cross-Platform Mobile',
      desc: "Crafting native iOS and Android mobile applications with declarative component state and fluid user interfaces.",
      color: 0x0F172A,
      sideColor: 0x020617,
      textColor: '#38BDF8',
      badgeBg: '#090D16',
      badgeBorder: '#61DAFB',
      icon: 'svgs/React.svg',
      col: 3, row: 1
    },
    {
      id: 'node',
      keyChar: 'N',
      title: 'Node.js & Express',
      category: 'Asynchronous Runtime',
      desc: "Event-driven, non-blocking I/O JavaScript runtime built for high-throughput REST APIs and scalable backend services.",
      color: 0x16A34A,
      sideColor: 0x15803D,
      textColor: '#FFFFFF',
      badgeBg: '#052E16',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/Node.js.svg',
      col: 4, row: 1
    },

    {
      id: 'electron',
      keyChar: 'E',
      title: 'Electron',
      category: 'Desktop Software',
      desc: "Packaging web technologies into robust, cross-platform desktop applications for Windows, macOS, and Linux.",
      color: 0x334155,
      sideColor: 0x1E293B,
      textColor: '#38BDF8',
      badgeBg: '#0F172A',
      badgeBorder: '#47CBDF',
      icon: 'svgs/Electron.svg',
      col: 0, row: 2
    },
    {
      id: 'expo',
      keyChar: 'X',
      title: 'Expo',
      category: 'Mobile Toolchain',
      desc: "Universal React Native platform powering seamless mobile app builds, hardware APIs, and over-the-air updates.",
      color: 0x18181B,
      sideColor: 0x09090B,
      textColor: '#FFFFFF',
      badgeBg: '#181A22',
      badgeBorder: 'rgba(255, 255, 255, 0.35)',
      icon: 'assets/images/tech/expo.svg',
      col: 1, row: 2
    },
    {
      id: 'android',
      keyChar: 'A',
      title: 'Android Development',
      category: 'Mobile Operating System',
      desc: "Building native Android mobile applications with Java/Kotlin, SDK components, and mobile device integration.",
      color: 0x059669,
      sideColor: 0x047857,
      textColor: '#FFFFFF',
      badgeBg: '#064E3B',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/Android.svg',
      col: 2, row: 2
    },
    {
      id: 'python',
      keyChar: 'Y',
      title: 'Python',
      category: 'Automation & Scripting',
      desc: "Clean, elegant, and versatile programming language used for backend automation scripts, data processing, and utilities.",
      color: 0x1E3A8A,
      sideColor: 0x172554,
      textColor: '#FACC15',
      badgeBg: '#0F172A',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/Python.svg',
      col: 3, row: 2
    },
    {
      id: 'git',
      keyChar: 'G',
      title: 'Git & GitHub',
      category: 'Version Control',
      desc: "The ultimate time machine for code — branching, merging, pull requests, and safeguarding source control history.",
      color: 0xC2410C,
      sideColor: 0x9A3412,
      textColor: '#FFFFFF',
      badgeBg: '#451A03',
      badgeBorder: 'rgba(255, 255, 255, 0.2)',
      icon: 'svgs/Git.svg',
      col: 4, row: 2
    }
  ];

  // DOM Elements for Left Panel Info
  const techCatEl = document.getElementById('tech-cat');
  const techTitleEl = document.getElementById('tech-title');
  const techDescEl = document.getElementById('tech-desc');
  const techKeyKbd = document.getElementById('tech-key-kbd');

  // Scene setup
  const scene = new THREE.Scene();

  // Camera setup - Balanced 3D perspective with generous padding on all sides
  const width = container.clientWidth || 650;
  const height = container.clientHeight || 480;
  const aspect = width / height;
  const camera = new THREE.PerspectiveCamera(30, aspect, 0.1, 1000);
  camera.position.set(0, 8.6, 9.6);
  camera.lookAt(0, 0.25, 0);

  // Renderer setup
  const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
  renderer.setSize(width, height);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  renderer.shadowMap.enabled = true;
  renderer.shadowMap.type = THREE.PCFSoftShadowMap;

  const canvasEl = renderer.domElement;
  canvasEl.style.position = 'absolute';
  canvasEl.style.top = '0';
  canvasEl.style.left = '0';
  canvasEl.style.width = '100%';
  canvasEl.style.height = '100%';

  container.appendChild(canvasEl);

  const maxAnisotropy = renderer.capabilities.getMaxAnisotropy();

  // Natural Soft Studio Lighting (Zero Overexposure)
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.55);
  scene.add(ambientLight);

  const mainLight = new THREE.DirectionalLight(0xffffff, 0.85);
  mainLight.position.set(5, 12, 7);
  mainLight.castShadow = true;
  mainLight.shadow.mapSize.width = 2048;
  mainLight.shadow.mapSize.height = 2048;
  mainLight.shadow.bias = -0.0005;
  scene.add(mainLight);

  const fillLight = new THREE.DirectionalLight(0x94a3b8, 0.35);
  fillLight.position.set(-6, 8, -4);
  scene.add(fillLight);

  // Keyboard Group - Perfectly proportioned 3D macropad with zero bottom line clipping
  const keyboardGroup = new THREE.Group();
  keyboardGroup.scale.set(0.92, 0.92, 0.92);
  keyboardGroup.position.set(0, 0.1, 0);
  keyboardGroup.rotation.x = 0.38;
  keyboardGroup.rotation.y = -0.40;
  keyboardGroup.rotation.z = 0.05;
  scene.add(keyboardGroup);

  // Grid dimensions & Generous Enclosed Base Frame
  const cols = 5;
  const rows = 3;
  const keySpacingX = 1.34;
  const keySpacingZ = 1.34;
  const baseWidth = cols * keySpacingX + 1.15;
  const baseDepth = rows * keySpacingZ + 1.15;
  const baseHeight = 0.75;                      // Solid deep enclosure
  const cornerRadius = 0.65;                    // Generous smooth rounded corners matching reference image

  // Helper to create 2D Rounded Rectangle Shape
  function createRoundedRectShape(w, d, r) {
    const shape = new THREE.Shape();
    const x = -w / 2;
    const y = -d / 2;
    shape.moveTo(x + r, y);
    shape.lineTo(x + w - r, y);
    shape.quadraticCurveTo(x + w, y, x + w, y + r);
    shape.lineTo(x + w, y + d - r);
    shape.quadraticCurveTo(x + w, y + d, x + w - r, y + d);
    shape.lineTo(x + r, y + d);
    shape.quadraticCurveTo(x, y + d, x, y + d - r);
    shape.lineTo(x, y + r);
    shape.quadraticCurveTo(x, y, x + r, y);
    return shape;
  }

  // Extrude Solid Rounded Black Aluminum Chassis
  const baseShape = createRoundedRectShape(baseWidth, baseDepth, cornerRadius);
  const extrudeSettings = {
    depth: baseHeight,
    bevelEnabled: true,
    bevelSegments: 8,
    steps: 1,
    bevelSize: 0.16,      // Thick smooth rounded bevel edge
    bevelThickness: 0.16, // Matching depth
    curveSegments: 16
  };

  const caseGeo = new THREE.ExtrudeGeometry(baseShape, extrudeSettings);
  caseGeo.rotateX(Math.PI / 2);

  // Pitch Obsidian Dark Aluminum Frame (Matching reference image chassis)
  const caseMat = new THREE.MeshStandardMaterial({
    color: 0x12141A,
    roughness: 0.35,
    metalness: 0.75
  });

  const caseMesh = new THREE.Mesh(caseGeo, caseMat);
  caseMesh.position.y = -0.42;
  caseMesh.receiveShadow = true;
  caseMesh.castShadow = true;
  keyboardGroup.add(caseMesh);

  // Inner Switch Plate (Dark Charcoal Recessed Well)
  const plateShape = createRoundedRectShape(baseWidth - 0.2, baseDepth - 0.2, 0.45);
  const plateSettings = {
    depth: 0.08,
    bevelEnabled: true,
    bevelSize: 0.05,
    bevelThickness: 0.05,
    curveSegments: 12
  };
  const plateGeo = new THREE.ExtrudeGeometry(plateShape, plateSettings);
  plateGeo.rotateX(Math.PI / 2);

  const plateMat = new THREE.MeshStandardMaterial({
    color: 0x090A0E,
    roughness: 0.5,
    metalness: 0.6
  });
  const plateMesh = new THREE.Mesh(plateGeo, plateMat);
  plateMesh.position.y = -0.04;
  keyboardGroup.add(plateMesh);

  // Key Objects Storage
  const keyMeshMap = new Map();
  const keyObjectsList = [];

  // Ultra-HD 1024x1024 Canvas Texture Generator with High-Contrast Icon Recoloring
  function createKeycapTexture(skill) {
    const canvas = document.createElement('canvas');
    canvas.width = 1024;
    canvas.height = 1024;
    const ctx = canvas.getContext('2d');

    function drawKeycap(imgObj = null) {
      ctx.clearRect(0, 0, 1024, 1024);

      // 1. Rich Saturated Keycap Base Fill
      ctx.fillStyle = '#' + skill.color.toString(16).padStart(6, '0');
      ctx.fillRect(0, 0, 1024, 1024);

      // 2. Inner Top Bevel Accent Stroke Frame
      ctx.strokeStyle = 'rgba(255, 255, 255, 0.45)';
      ctx.lineWidth = 26;
      ctx.strokeRect(36, 36, 952, 952);

      // 3. Top Right Keyboard Letter Shortcut (Big & Bold)
      ctx.fillStyle = skill.textColor || '#FFFFFF';
      ctx.font = 'bold 110px Inter, sans-serif';
      ctx.textAlign = 'right';
      ctx.fillText(skill.keyChar, 890, 160);

      // 4. Center High-Contrast Badge Container (Ultra Large & Clear)
      const badgeWidth = 540;
      const badgeHeight = 540;
      const posX = (1024 - badgeWidth) / 2;
      const posY = (1024 - badgeHeight) / 2 + 35;
      const cornerR = 72;

      ctx.save();
      // Drop Shadow
      ctx.shadowColor = 'rgba(0, 0, 0, 0.35)';
      ctx.shadowBlur = 28;
      ctx.shadowOffsetY = 12;

      // Badge Fill
      ctx.fillStyle = skill.badgeBg || '#FFFFFF';
      ctx.beginPath();
      if (typeof ctx.roundRect === 'function') {
        ctx.roundRect(posX, posY, badgeWidth, badgeHeight, cornerR);
      } else {
        ctx.moveTo(posX + cornerR, posY);
        ctx.lineTo(posX + badgeWidth - cornerR, posY);
        ctx.quadraticCurveTo(posX + badgeWidth, posY, posX + badgeWidth, posY + cornerR);
        ctx.lineTo(posX + badgeWidth, posY + badgeHeight - cornerR);
        ctx.quadraticCurveTo(posX + badgeWidth, posY + badgeHeight, posX + badgeWidth - cornerR, posY + badgeHeight);
        ctx.lineTo(posX + cornerR, posY + badgeHeight);
        ctx.quadraticCurveTo(posX, posY + badgeHeight, posX, posY + badgeHeight - cornerR);
        ctx.lineTo(posX, posY + cornerR);
        ctx.quadraticCurveTo(posX, posY, posX + cornerR, posY);
        ctx.closePath();
      }
      ctx.fill();
      ctx.restore();

      // Badge Border Line
      ctx.save();
      ctx.strokeStyle = skill.badgeBorder || 'rgba(0, 0, 0, 0.15)';
      ctx.lineWidth = 12;
      ctx.beginPath();
      if (typeof ctx.roundRect === 'function') {
        ctx.roundRect(posX, posY, badgeWidth, badgeHeight, cornerR);
      } else {
        ctx.moveTo(posX + cornerR, posY);
        ctx.lineTo(posX + badgeWidth - cornerR, posY);
        ctx.quadraticCurveTo(posX + badgeWidth, posY, posX + badgeWidth, posY + cornerR);
        ctx.lineTo(posX + badgeWidth, posY + badgeHeight - cornerR);
        ctx.quadraticCurveTo(posX + badgeWidth, posY + badgeHeight, posX + badgeWidth - cornerR, posY + badgeHeight);
        ctx.lineTo(posX + cornerR, posY + badgeHeight);
        ctx.quadraticCurveTo(posX, posY + badgeHeight, posX, posY + badgeHeight - cornerR);
        ctx.lineTo(posX, posY + cornerR);
        ctx.quadraticCurveTo(posX, posY, posX + cornerR, posY);
        ctx.closePath();
      }
      ctx.stroke();
      ctx.restore();

      // 5. Draw SVG Icon inside Badge (or Bold Fallback Typography)
      const currentImg = imgObj || skill.loadedImg;
      if (currentImg && currentImg.complete && currentImg.naturalWidth !== 0) {
        const iconSize = 400;
        const iconX = posX + (badgeWidth - iconSize) / 2;
        const iconY = posY + (badgeHeight - iconSize) / 2;
        if (skill.invertIcon) {
          ctx.save();
          ctx.filter = 'brightness(0) invert(1)';
          ctx.drawImage(currentImg, iconX, iconY, iconSize, iconSize);
          ctx.restore();
        } else {
          ctx.drawImage(currentImg, iconX, iconY, iconSize, iconSize);
        }
      } else {
        ctx.fillStyle = '#FFFFFF';
        ctx.textAlign = 'center';
        ctx.font = 'bold 180px Oswald, sans-serif';
        ctx.fillText(skill.keyChar, 512, posY + badgeHeight / 2 + 60);
      }
    }

    // Initial sync render
    drawKeycap(null);

    const texture = new THREE.CanvasTexture(canvas);
    texture.anisotropy = maxAnisotropy;

    // Load Image & Trigger Texture Update
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => {
      skill.loadedImg = img;
      drawKeycap(img);
      texture.needsUpdate = true;
    };
    img.src = skill.icon;

    return texture;
  }

  // Create Tapered High-Profile Keycap Geometry with Normalized Top Plateau UVs
  function createKeycapGeometry() {
    const w = 0.94;
    const d = 0.94;
    const r = 0.22;
    const x = -w / 2;
    const y = -d / 2;

    const shape = new THREE.Shape();
    shape.moveTo(x + r, y);
    shape.lineTo(x + w - r, y);
    shape.quadraticCurveTo(x + w, y, x + w, y + r);
    shape.lineTo(x + w, y + d - r);
    shape.quadraticCurveTo(x + w, y + d, x + w - r, y + d);
    shape.lineTo(x + r, y + d);
    shape.quadraticCurveTo(x, y + d, x, y + d - r);
    shape.lineTo(x, y + r);
    shape.quadraticCurveTo(x, y, x + r, y);

    const extrudeSettings = {
      depth: 0.38,
      bevelEnabled: true,
      bevelSegments: 8,
      steps: 1,
      bevelSize: 0.13,      // Tapers outward down to ~1.20 width base
      bevelThickness: 0.14,  // Soft rounded shoulder
      curveSegments: 16
    };

    const geo = new THREE.ExtrudeGeometry(shape, extrudeSettings);

    // Normalize UV coordinates on the top plateau face (z >= 0.51) so textures map 1:1
    const posAttr = geo.attributes.position;
    const uvAttr = geo.attributes.uv;
    for (let i = 0; i < posAttr.count; i++) {
      const vz = posAttr.getZ(i);
      if (vz >= 0.51) {
        const vx = posAttr.getX(i);
        const vy = posAttr.getY(i);
        const u = (vx + w / 2) / w;
        const v = (vy + d / 2) / d;
        uvAttr.setXY(i, u, v);
      }
    }
    uvAttr.needsUpdate = true;

    geo.rotateX(-Math.PI / 2);
    return geo;
  }

  const sharedKeycapGeo = createKeycapGeometry();

  // Create Keycaps Grid
  const startX = -((cols - 1) * keySpacingX) / 2;
  const startZ = -((rows - 1) * keySpacingZ) / 2;

  SKILLS_DATA.forEach((skill) => {
    const posX = startX + skill.col * keySpacingX;
    const posZ = startZ + skill.row * keySpacingZ;

    const topTexture = createKeycapTexture(skill);

    const topMat = new THREE.MeshStandardMaterial({
      map: topTexture,
      roughness: 0.25,
      metalness: 0.05
    });

    const sideMat = new THREE.MeshStandardMaterial({
      color: skill.sideColor || skill.color,
      roughness: 0.35,
      metalness: 0.08
    });

    const keyMesh = new THREE.Mesh(sharedKeycapGeo, [topMat, sideMat]);
    keyMesh.position.set(posX, 0.22, posZ);
    keyMesh.castShadow = true;
    keyMesh.receiveShadow = true;

    keyMesh.userData = {
      skill: skill,
      originalY: 0.22,
      isPressed: false
    };

    keyboardGroup.add(keyMesh);
    keyObjectsList.push(keyMesh);
    keyMeshMap.set(skill.keyChar.toUpperCase(), keyMesh);
    keyMeshMap.set(skill.id, keyMesh);
  });

  // Active Skill Selection Function
  let activeSkillId = null;

  function selectSkill(keyMesh, triggerPressAnimation = true) {
    if (!keyMesh || !keyMesh.userData) return;
    const skill = keyMesh.userData.skill;

    if (activeSkillId === skill.id && !triggerPressAnimation) return;
    activeSkillId = skill.id;

    if (triggerPressAnimation) {
      gsap.killTweensOf(keyMesh.position);
      gsap.to(keyMesh.position, {
        y: keyMesh.userData.originalY - 0.2,
        duration: 0.08,
        ease: 'power2.out',
        onComplete: () => {
          gsap.to(keyMesh.position, {
            y: keyMesh.userData.originalY,
            duration: 0.28,
            ease: 'back.out(2.2)'
          });
        }
      });
    }

    if (techTitleEl && techDescEl && techCatEl && techKeyKbd) {
      gsap.to([techCatEl, techTitleEl, techDescEl, techKeyKbd], {
        opacity: 0,
        y: -12,
        duration: 0.14,
        onComplete: () => {
          techCatEl.textContent = skill.category.toUpperCase();
          techTitleEl.textContent = skill.title;
          techDescEl.textContent = `"${skill.desc}"`;
          techKeyKbd.textContent = skill.keyChar;

          techCatEl.style.color = '#' + skill.color.toString(16).padStart(6, '0');

          gsap.to([techCatEl, techTitleEl, techDescEl, techKeyKbd], {
            opacity: 1,
            y: 0,
            duration: 0.26,
            stagger: 0.04,
            ease: 'power2.out'
          });
        }
      });
    }
  }

  // Default Select TypeScript (T)
  const defaultKey = keyMeshMap.get('T');
  if (defaultKey) selectSkill(defaultKey, false);

  // Default selection
  const defaultMesh = keyMeshMap.get('T') || keyObjectsList[1];
  if (defaultMesh) {
    selectSkill(defaultMesh, false);
  }

  // Raycaster for Hover & Click
  const raycaster = new THREE.Raycaster();
  const mouse = new THREE.Vector2();
  let hoveredMesh = null;

  function onPointerMove(event) {
    const rect = renderer.domElement.getBoundingClientRect();
    mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
    mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);
    const intersects = raycaster.intersectObjects(keyObjectsList);

    if (intersects.length > 0) {
      const hitMesh = intersects[0].object;
      if (hoveredMesh !== hitMesh) {
        hoveredMesh = hitMesh;
        document.body.style.cursor = 'pointer';
        selectSkill(hoveredMesh, true);
      }
    } else {
      if (hoveredMesh) {
        document.body.style.cursor = 'default';
        hoveredMesh = null;
      }
    }
  }

  function onPointerDown(event) {
    if (hoveredMesh) {
      selectSkill(hoveredMesh, true);
    }
  }

  container.addEventListener('pointermove', onPointerMove);
  container.addEventListener('pointerdown', onPointerDown);

  // Physical Keyboard Input
  window.addEventListener('keydown', (e) => {
    const pressedKey = e.key.toUpperCase();
    if (keyMeshMap.has(pressedKey)) {
      const targetMesh = keyMeshMap.get(pressedKey);
      selectSkill(targetMesh, true);
    }
  });

  // Mouse Parallax
  let targetRotX = 0.32;
  let targetRotY = -0.36;

  window.addEventListener('mousemove', (e) => {
    const windowHalfX = window.innerWidth / 2;
    const windowHalfY = window.innerHeight / 2;
    const mouseX = (e.clientX - windowHalfX) / windowHalfX;
    const mouseY = (e.clientY - windowHalfY) / windowHalfY;

    targetRotY = -0.36 + mouseX * 0.12;
    targetRotX = 0.32 + mouseY * 0.08;
  });

  // Render Loop & Immediate Frame 0 Render
  renderer.render(scene, camera);

  function animate() {
    requestAnimationFrame(animate);

    keyboardGroup.rotation.y += (targetRotY - keyboardGroup.rotation.y) * 0.05;
    keyboardGroup.rotation.x += (targetRotX - keyboardGroup.rotation.x) * 0.05;

    renderer.render(scene, camera);
  }
  animate();

  // Immediately set section visible
  if (sectionEl) sectionEl.classList.add('is-visible');

  // Scroll Entrance Intersection Observer
  if ('IntersectionObserver' in window && sectionEl) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            keyObjectsList.forEach((mesh, index) => {
              gsap.fromTo(
                mesh.position,
                { y: mesh.userData.originalY - 0.35 },
                {
                  y: mesh.userData.originalY,
                  duration: 0.5,
                  delay: index * 0.02,
                  ease: 'back.out(1.8)'
                }
              );
            });

            observer.unobserve(sectionEl);
          }
        });
      },
      { threshold: 0.05 }
    );
    observer.observe(sectionEl);
  }

  // Window Resize
  window.addEventListener('resize', () => {
    const width = container.clientWidth || 650;
    const height = container.clientHeight || 480;
    camera.aspect = width / height;
    camera.updateProjectionMatrix();
    renderer.setSize(width, height);
  });
}

function startKeyboardApp() {
  if (typeof THREE !== 'undefined') {
    init3DKeyboard();
  } else {
    let attempts = 0;
    const interval = setInterval(() => {
      attempts++;
      if (typeof THREE !== 'undefined') {
        clearInterval(interval);
        init3DKeyboard();
      } else if (attempts > 100) {
        clearInterval(interval);
      }
    }, 100);
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', startKeyboardApp);
} else {
  startKeyboardApp();
}

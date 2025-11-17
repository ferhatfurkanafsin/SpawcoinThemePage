/**
 * Three.js 3D Scene for Spawcoin Theme
 * Creates an animated 3D background with particles and geometric shapes
 */

(function() {
    'use strict';

    // Wait for DOM and Three.js to be ready
    if (typeof THREE === 'undefined') {
        console.warn('Three.js not loaded yet');
        return;
    }

    const canvas = document.getElementById('three-canvas');
    if (!canvas) {
        console.warn('Canvas element not found');
        return;
    }

    // Scene setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(
        75,
        window.innerWidth / window.innerHeight,
        0.1,
        1000
    );

    const renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        alpha: true,
        antialias: true
    });

    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    // Camera position
    camera.position.z = 5;

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const pointLight = new THREE.PointLight(0x6366f1, 1, 100);
    pointLight.position.set(5, 5, 5);
    scene.add(pointLight);

    const pointLight2 = new THREE.PointLight(0xec4899, 1, 100);
    pointLight2.position.set(-5, -5, 5);
    scene.add(pointLight2);

    // Create particle system
    const particlesGeometry = new THREE.BufferGeometry();
    const particlesCount = 1500;
    const posArray = new Float32Array(particlesCount * 3);

    for (let i = 0; i < particlesCount * 3; i++) {
        posArray[i] = (Math.random() - 0.5) * 20;
    }

    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));

    const particlesMaterial = new THREE.PointsMaterial({
        size: 0.02,
        color: 0x6366f1,
        transparent: true,
        opacity: 0.8,
        blending: THREE.AdditiveBlending
    });

    const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
    scene.add(particlesMesh);

    // Create geometric shapes
    const shapes = [];

    // Torus
    const torusGeometry = new THREE.TorusGeometry(1, 0.4, 16, 100);
    const torusMaterial = new THREE.MeshStandardMaterial({
        color: 0x6366f1,
        wireframe: true,
        transparent: true,
        opacity: 0.3
    });
    const torus = new THREE.Mesh(torusGeometry, torusMaterial);
    torus.position.set(2, 0, 0);
    scene.add(torus);
    shapes.push(torus);

    // Icosahedron
    const icoGeometry = new THREE.IcosahedronGeometry(0.8, 0);
    const icoMaterial = new THREE.MeshStandardMaterial({
        color: 0xec4899,
        wireframe: true,
        transparent: true,
        opacity: 0.3
    });
    const ico = new THREE.Mesh(icoGeometry, icoMaterial);
    ico.position.set(-2, 0, 0);
    scene.add(ico);
    shapes.push(ico);

    // Octahedron
    const octaGeometry = new THREE.OctahedronGeometry(0.7, 0);
    const octaMaterial = new THREE.MeshStandardMaterial({
        color: 0x14b8a6,
        wireframe: true,
        transparent: true,
        opacity: 0.3
    });
    const octa = new THREE.Mesh(octaGeometry, octaMaterial);
    octa.position.set(0, 2, -2);
    scene.add(octa);
    shapes.push(octa);

    // Mouse movement
    let mouseX = 0;
    let mouseY = 0;
    let targetX = 0;
    let targetY = 0;

    const onMouseMove = (event) => {
        mouseX = (event.clientX / window.innerWidth) * 2 - 1;
        mouseY = -(event.clientY / window.innerHeight) * 2 + 1;
    };

    window.addEventListener('mousemove', onMouseMove);

    // Touch support for mobile
    const onTouchMove = (event) => {
        if (event.touches.length > 0) {
            mouseX = (event.touches[0].clientX / window.innerWidth) * 2 - 1;
            mouseY = -(event.touches[0].clientY / window.innerHeight) * 2 + 1;
        }
    };

    window.addEventListener('touchmove', onTouchMove);

    // Handle window resize
    const onWindowResize = () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    };

    window.addEventListener('resize', onWindowResize);

    // Animation loop
    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);

        const elapsedTime = clock.getElapsedTime();

        // Animate particles
        particlesMesh.rotation.y = elapsedTime * 0.05;
        particlesMesh.rotation.x = elapsedTime * 0.03;

        // Animate shapes
        shapes.forEach((shape, index) => {
            shape.rotation.x = elapsedTime * (0.3 + index * 0.1);
            shape.rotation.y = elapsedTime * (0.2 + index * 0.1);
            shape.position.y = Math.sin(elapsedTime + index) * 0.5;
        });

        // Smooth mouse following
        targetX = mouseX * 0.5;
        targetY = mouseY * 0.5;

        camera.position.x += (targetX - camera.position.x) * 0.05;
        camera.position.y += (targetY - camera.position.y) * 0.05;

        // Lights animation
        pointLight.position.x = Math.sin(elapsedTime) * 5;
        pointLight.position.y = Math.cos(elapsedTime) * 5;

        pointLight2.position.x = Math.cos(elapsedTime * 0.7) * 5;
        pointLight2.position.y = Math.sin(elapsedTime * 0.7) * 5;

        renderer.render(scene, camera);
    }

    // Start animation
    animate();

    // Cleanup function
    window.addEventListener('beforeunload', () => {
        window.removeEventListener('mousemove', onMouseMove);
        window.removeEventListener('touchmove', onTouchMove);
        window.removeEventListener('resize', onWindowResize);

        // Dispose of geometries and materials
        particlesGeometry.dispose();
        particlesMaterial.dispose();
        shapes.forEach(shape => {
            shape.geometry.dispose();
            shape.material.dispose();
        });

        renderer.dispose();
    });

})();

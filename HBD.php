<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8" />
<title>สุขสันต์วันเกิดคับ หม่ามี๊!</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sarabun&display=swap');

    body {
        margin: 0;
        font-family: 'Sarabun', sans-serif;
        background: linear-gradient(to right, #ffe1e1, #ffd3a5);
        overflow: hidden;
        text-align: center;
        position: relative;
    }

    .snow-container {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .falling {
        position: absolute;
        width: 60px;
        height: auto;
        animation: fall linear infinite;
    }

    @keyframes fall {
        0% {
            transform: translateY(-100px) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(100vh) rotate(360deg);
            opacity: 0.6;
        }
    }

    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        padding: 40px;
        max-width: 600px;
        margin: 100px auto 30px;
        position: relative;
        z-index: 10;
        animation: fadeIn 2s ease-in-out;
    }

    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #ff6f61;
        margin-bottom: 20px;
    }

    h1 {
        color: #ff6f61;
        margin-bottom: 0;
    }

    p {
        font-size: 20px;
        color: #444;
        margin-top: 8px;
    }

    @keyframes fadeIn {
        0% {opacity: 0; transform: scale(0.9);}
        100% {opacity: 1; transform: scale(1);}
    }

    .btn {
        cursor: pointer;
        background: #ff6f61;
        border: none;
        color: white;
        font-size: 18px;
        padding: 12px 25px;
        border-radius: 30px;
        margin: 10px 8px 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        transition: background 0.3s ease;
        user-select: none;
        z-index: 20;
        position: relative;
    }

    .btn:hover:not(:disabled) {
        background: #e6554a;
    }

    .btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    .cake {
        position: fixed;
        bottom: -100px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        opacity: 0.9;
        animation: cakeUp 5s ease forwards;
        z-index: 15;
        pointer-events: none;
    }

    @keyframes cakeUp {
        0% {
            bottom: -100px;
            opacity: 0;
            transform: translateX(-50%) scale(0.5);
        }
        50% {
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }
        100% {
            bottom: 120vh;
            opacity: 0;
            transform: translateX(-50%) scale(1.2);
        }
    }

    .firework {
        position: fixed;
        width: 150px;
        height: 150px;
        pointer-events: none;
        user-select: none;
        z-index: 30;
        border-radius: 50%;
        opacity: 0;
    }

    .firework .particle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: radial-gradient(circle, #fff 0%, #f00 70%);
        border-radius: 50%;
        opacity: 1;
        animation: particleMove 1s forwards;
    }

    @keyframes particleMove {
        to {
            transform: translate(var(--x), var(--y)) scale(0);
            opacity: 0;
        }
    }

    #gift-message {
        font-size: 24px;
        color: #ff4081;
        margin-top: 20px;
        font-weight: 700;
        display: none;
        animation: fadeIn 3s ease forwards;
        z-index: 20;
        position: relative;
    }
</style>
</head>
<body>

    <!-- หิมะ -->
    <div class="snow-container" id="snow-container"></div>

    <!-- กล่องข้อความ -->
    <div class="card">
        <img src="img/profile.jpg" alt="Profile Picture" class="profile-img" />
        <h1>🎉 เซอร์ไพรส์! สุขสันต์วันเกิดนะคับหม่ามี๊! 🎂</h1>
        <p>นี้เป็นครั้งแรกเลยนะครับของผมในวันเกิดคุณหวานใจ<br>ขอให้มีความสุขในทุกวันนะครับวันไหนท้อแท้ยังมีลูกชายคนนี้นะครับ!!💖<br>ปีนี้จงพบแต่เรื่องราวดี ๆ ในปีนี้คับ</p>
    </div>

    <!-- ปุ่มเปิดของขวัญ -->
    <div>
        <button class="btn" id="btn-open-gift">🎁 เปิดของขวัญ</button>
    </div>

    <!-- ข้อความของขวัญ -->
    <div id="gift-message">ขอบคุณที่เกิดมาสร้างรอบยิ้มให้ทุกคนนะครับ! 💝 สุขสันต์วันเกิดอีกครั้งนะครับผม!</div>

<script>
    // หิมะ
    const imageSrc = "img/icon-removebg-preview.png";
    const container = document.getElementById("snow-container");

    function createSnowImage() {
        const img = document.createElement("img");
        img.src = imageSrc;
        img.classList.add("falling");
        img.style.left = Math.random() * window.innerWidth + "px";
        const size = Math.random() * 20 + 60;
        img.style.width = size + "px";
        img.style.animationDuration = (Math.random() * 3 + 5) + "s";
        container.appendChild(img);
        setTimeout(() => {
            img.remove();
        }, 10000);
    }
    setInterval(createSnowImage, 300);

    // เค้กลอยขึ้น
    function createCake() {
        const cake = document.createElement("img");
        cake.src = "img/profile.jpg";
        cake.classList.add("cake");
        cake.style.left = (window.innerWidth/2 + (Math.random() * 100 - 50)) + "px";
        document.body.appendChild(cake);
        setTimeout(() => {
            cake.remove();
        }, 5000);
    }

    // พลุ
    function createFirework(x, y) {
        const firework = document.createElement("div");
        firework.classList.add("firework");
        firework.style.left = (x - 75) + "px";
        firework.style.top = (y - 75) + "px";
        firework.style.opacity = 1;

        for(let i=0; i<12; i++) {
            const particle = document.createElement("div");
            particle.classList.add("particle");
            const angle = (360 / 12) * i;
            const radius = 80 + Math.random() * 20;
            const rad = angle * (Math.PI / 180);
            particle.style.setProperty('--x', (Math.cos(rad)*radius) + "px");
            particle.style.setProperty('--y', (Math.sin(rad)*radius) + "px");
            particle.style.animationDelay = (i*0.05) + "s";
            firework.appendChild(particle);
        }

        document.body.appendChild(firework);

        setTimeout(() => {
            firework.remove();
        }, 1100);
    }

    // เปิดของขวัญ
    const btnOpenGift = document.getElementById('btn-open-gift');
    const giftMessage = document.getElementById('gift-message');

    btnOpenGift.addEventListener('click', () => {
        giftMessage.style.display = 'block';
        createCake();
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 3;

        for (let i = 0; i < 5; i++) {
            setTimeout(() => {
                const offsetX = (Math.random() * 200) - 100;
                const offsetY = (Math.random() * 100) - 50;
                createFirework(centerX + offsetX, centerY + offsetY);
            }, i * 400);
        }

        btnOpenGift.disabled = true;
        btnOpenGift.textContent = "🎉 ของขวัญถูกเปิดแล้ว";

        // 🔁 เปลี่ยนหน้าไป note.php หลังจากแสดงพลุ
        setTimeout(() => {
            window.location.href = "note.php";
        }, 3000);
    });
</script>

</body>
</html>

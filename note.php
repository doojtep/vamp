<?php
$filename = "notes.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $note = trim($_POST["note"]);
    $date = trim($_POST["date"]);
    if ($note !== "" && $date !== "") {
        file_put_contents($filename, $date . "|||" . $note . "\n", FILE_APPEND);
    }
    header("Location: show_note.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <title>เพิ่มโน้ตของคุณ</title>
  <style>
    @font-face {
      font-family: 'FkAprilBold';
      src: url('/HBD/font/FkAprilBold.ttf') format('truetype');
    }

    body {
      font-family: 'FkAprilBold', sans-serif;
      background: linear-gradient(to right, #ffe1f0, #ffd6ec);
      padding: 30px;
      max-width: 800px;
      margin: auto;
      position: relative;
      overflow-x: hidden;
      z-index: 10; /* ✅ อยู่หน้าหิมะ */
    }

    h1 {
      color: #d63384;
      margin-bottom: 25px;
      font-size: 2.2rem;
      text-align: center;
      position: relative;
      z-index: 10;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
      margin-bottom: 5px;
      color: #a64f79;
      position: relative;
      z-index: 10;
    }

    input[type="date"], textarea {
      width: 100%;
      padding: 12px;
      font-size: 16px;
      box-sizing: border-box;
      font-family: 'FkAprilBold', sans-serif;
      border: 2px solid #f8a5c2;
      border-radius: 8px;
      background-color: #fff0f6;
      color: #333;
      position: relative;
      z-index: 10;
    }

    textarea {
      height: 150px;
      resize: vertical;
      margin-top: 5px;
      white-space: pre-wrap;
      overflow-wrap: break-word;
      min-height: 150px;
      max-height: 500px;
      overflow-y: auto;
    }

    button {
      margin-top: 20px;
      padding: 12px 25px;
      font-size: 16px;
      background-color: #ff69b4;
      color: white;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-family: 'FkAprilBold', sans-serif;
      transition: background-color 0.3s ease, transform 0.2s ease;
      position: relative;
      z-index: 10;
    }

    button:hover {
      background-color: #ff4081;
      transform: scale(1.03);
    }

    /* หิมะ */
    .snow-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0; /* ✅ อยู่ข้างหลังทุกอย่าง */
    }

    .falling {
      position: absolute;
      width: 60px;
      height: auto;
      animation: fall linear infinite;
      z-index: 0;
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
  </style>
</head>
<body>

  <!-- หิมะ -->
  <div class="snow-container" id="snow-container"></div>

  <h1>🎂 เพิ่มโน้ตของคุณ 🎈</h1>
  <form method="post">
    <label for="date">📅 วันที่:</label>
    <input type="date" id="date" name="date" required>

    <label for="note">📝 โน้ต:</label>
    <textarea id="note" name="note" placeholder="พิมพ์โน้ตของคุณที่นี่..." required></textarea>
    
    <button type="submit">💖 บันทึกโน้ต</button>
  </form>

  <script>
    // หิมะรูปแมว
    const imageSrc = "img/cat.png"; // ✅ ใช้รูปแมวที่คุณวางไว้
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

    // ขยาย textarea อัตโนมัติ
    const textarea = document.getElementById('note');
    textarea.addEventListener('input', () => {
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    });
  </script>
</body>
</html>

<?php
$filename = "notes.txt";

// อ่านโน้ตจากไฟล์
$savedNote = file_exists($filename) ? file_get_contents($filename) : "";
$lines = array_filter(array_map('trim', explode("\n", $savedNote)));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = isset($_POST['index']) ? (int)$_POST['index'] : null;

    if ($index !== null && isset($lines[$index])) {
        $parts = explode("|||", $lines[$index]);
        if (count($parts) < 3) {
            $parts[2] = 'unlocked';
        }

        if (isset($_POST['delete_note'])) {
            if (trim($parts[2]) !== 'locked') {
                unset($lines[$index]);
                $lines = array_values($lines);
            }
        } elseif (isset($_POST['toggle_lock'])) {
            $parts[2] = (trim($parts[2]) === 'locked') ? 'unlocked' : 'locked';
            $lines[$index] = implode("|||", $parts);
        }
    }
    file_put_contents($filename, implode("\n", $lines));
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

$pins = ["📌", "📎", "🧷", "🔖", "🖇️"];
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <title>โน้ตที่บันทึกไว้</title>
  <style>
    @font-face {
      font-family: 'FkAprilBold';
      src: url('/HBD/font/FkAprilBold.ttf') format('truetype');
    }
    body {
      font-family: 'FkAprilBold', sans-serif;
      background: linear-gradient(135deg, #ffe6f0, #ffd9e8);
      padding: 30px 20px;
      margin: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      color: #7b3954;
    }
    h1 {
      font-size: 2.8rem;
      margin-bottom: 35px;
      text-shadow: 1px 1px 3px rgba(255, 192, 203, 0.7);
    }
    .notes-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 30px;
      max-width: 960px;
      width: 100%;
    }
    .note {
      position: relative;
      z-index: 1;
      width: 220px;
      min-height: 200px;
      background-color: #fff9c4;
      border-radius: 18px;
      box-shadow: 0 8px 20px rgba(203, 182, 212, 0.3);
      padding: 25px 20px 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 17px;
      line-height: 1.5;
      text-align: center;
      color: #7b3954;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .note:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 30px rgba(203, 182, 212, 0.6);
    }
    .pin {
      position: absolute;
      top: -18px;
      left: -18px;
      font-size: 42px;
      filter: drop-shadow(0 0 2px rgba(203, 182, 212, 0.5));
      transform: rotate(-15deg);
    }
    .note-date {
      position: absolute;
      bottom: 12px;
      right: 15px;
      font-size: 13px;
      color: #a5708d;
      opacity: 0.8;
      font-style: italic;
    }
    form {
      margin-top: 12px;
    }
    button {
      font-size: 22px;
      margin: 0 6px;
      cursor: pointer;
      background: none;
      border: none;
      transition: transform 0.2s ease;
      color: #7b3954;
    }
    button:hover {
      transform: scale(1.3);
      color: #a5708d;
    }
    a {
      margin-top: 40px;
      display: inline-block;
      text-decoration: none;
      color: #a5708d;
      font-weight: 700;
      font-size: 18px;
      border: 2px solid #a5708d;
      padding: 10px 25px;
      border-radius: 30px;
      transition: background-color 0.3s ease, color 0.3s ease;
      box-shadow: 0 5px 10px rgba(203, 182, 212, 0.3);
    }
    a:hover {
      background-color: #a5708d;
      color: white;
      box-shadow: 0 8px 18px rgba(203, 182, 212, 0.6);
    }
  </style>
</head>
<body>
  <h1>โน้ตของคุณ</h1>

  <div class="notes-container">
    <?php foreach ($lines as $i => $line): ?>
      <?php
        $parts = explode("|||", $line);
        if (count($parts) < 3) {
          $parts[2] = 'unlocked';
        }
        $noteDate = htmlspecialchars(trim($parts[0]));
        $noteText = htmlspecialchars(trim($parts[1]));
        $isLocked = trim($parts[2]) === 'locked';
        $pin = $pins[array_rand($pins)];
      ?>
      <div class="note" data-index="<?= $i ?>">
        <div class="pin"><?= $pin ?></div>
        <div><?= nl2br($noteText) ?></div>
        <div class="note-date"><?= $noteDate ?></div>

        <form method="POST" class="note-form">
          <input type="hidden" name="index" value="<?= $i ?>">
          <button type="submit" name="toggle_lock" class="lock-btn" title="<?= $isLocked ? 'ปลดล็อกโน้ต' : 'ล็อกโน้ต' ?>" data-locked="<?= $isLocked ? '1' : '0' ?>">
            <?= $isLocked ? '🔒' : '🔓' ?>
          </button>
          <?php if (!$isLocked): ?>
            <button type="submit" name="delete_note" title="ลบโน้ตนี้" onclick="return confirm('คุณแน่ใจที่จะลบโน้ตนี้?');">🗑</button>
          <?php endif; ?>
        </form>
      </div>
    <?php endforeach; ?>
  </div>

  <a href="note.php">📝 กลับไปเพิ่มโน้ต</a>

  <script>
    // สลับไอคอนกุญแจตอนกดโดยไม่ต้องรีเฟรชหน้า (แต่ข้อมูลจริงจะอัพเดตหลังรีเฟรช)
    document.querySelectorAll('.lock-btn').forEach(button => {
      button.addEventListener('click', function(event) {
        // ป้องกันฟอร์มส่งไปทันที ให้ทำงานแบบไดนามิกก่อน
        // ส่วนนี้จะส่งฟอร์มตามปกติหลังจากคลิก (เพื่ออัพเดตไฟล์)
        // แต่เราสลับไอคอนไว้ก่อนหน้าส่ง form

        // สลับสถานะล็อกใน attribute และไอคอน
        const locked = this.getAttribute('data-locked') === '1';
        if (locked) {
          this.textContent = '🔓';
          this.setAttribute('title', 'ล็อกโน้ต');
          this.setAttribute('data-locked', '0');
          // แสดงปุ่มลบ
          const deleteBtn = this.parentElement.querySelector('button[name="delete_note"]');
          if (deleteBtn) deleteBtn.style.display = 'inline';
        } else {
          this.textContent = '🔒';
          this.setAttribute('title', 'ปลดล็อกโน้ต');
          this.setAttribute('data-locked', '1');
          // ซ่อนปุ่มลบ
          const deleteBtn = this.parentElement.querySelector('button[name="delete_note"]');
          if (deleteBtn) deleteBtn.style.display = 'none';
        }
        // ปล่อยให้ form ส่งปกติ เพื่ออัพเดตข้อมูลใน server
      });
    });
  </script>
</body>
</html>

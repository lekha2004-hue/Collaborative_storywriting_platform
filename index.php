<?php
require 'config.php';

$page_id = 1; // Single shared page

// Load all blocks
$stmt = $db->prepare("SELECT * FROM blocks WHERE page_id = ? ORDER BY id ASC");
$stmt->bind_param("i", $page_id);
$stmt->execute();
$result = $stmt->get_result();
$blocks = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<!DOCTYPE html>
<html>
<head>
  <title>StoryWeave</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f8f9fa;
      padding: 30px;
      max-width: 800px;
      margin: auto;
      color: #333;
    }

    h1 {
      font-size: 28px;
      margin-bottom: 20px;
      text-align: center;
    }

    .block {
      background: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 12px 16px;
      margin-bottom: 10px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.05);
      min-height: 40px;
      cursor: text;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    .block:focus {
      outline: none;
      border-color: #007bff;
      box-shadow: 0 0 0 3px rgba(0,123,255,0.2);
    }

    button {
      display: block;
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin: 20px auto;
      transition: background 0.2s;
    }

    button:hover {
      background-color: #0056b3;
    }

    #status {
      text-align: center;
      font-size: 14px;
      color: gray;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <h1>📝 Collaborative Page</h1>
  <div id="blocks">
    <?php foreach ($blocks as $block): ?>
      <div class="block" contenteditable="true" data-id="<?= $block['id'] ?>">
        <?= htmlspecialchars($block['content']) ?>
      </div>
    <?php endforeach; ?>
  </div>
  <button onclick="addBlock()">+ Add Block</button>
  <div id="status">Last synced: never</div>

  <script>
    const status = document.getElementById("status");

    document.querySelectorAll(".block").forEach(block => {
      block.addEventListener("blur", () => {
        const id = block.dataset.id;
        const content = block.innerText;
        fetch("save_block.php", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({id, content})
        }).then(() => {
          status.innerText = "Last synced: just now";
        });
      });
    });

    function addBlock() {
      fetch("add_block.php")
        .then(res => res.text())
        .then(html => {
          const div = document.createElement("div");
          div.innerHTML = html;
          const newBlock = div.firstChild;
          document.getElementById("blocks").appendChild(newBlock);
          newBlock.contentEditable = true;
          newBlock.className = "block";
          newBlock.focus();
          newBlock.addEventListener("blur", () => {
            const id = newBlock.dataset.id;
            const content = newBlock.innerText;
            fetch("save_block.php", {
              method: "POST",
              headers: {"Content-Type": "application/json"},
              body: JSON.stringify({id, content})
            }).then(() => {
              status.innerText = "Last synced: just now";
            });
          });
        });
    }

    setInterval(() => {
      fetch("fetch_blocks.php")
        .then(res => res.json())
        .then(data => {
          document.querySelectorAll(".block").forEach(div => {
            const id = div.dataset.id;
            const updated = data.find(b => b.id == id);
            if (updated && document.activeElement !== div) {
              div.innerText = updated.content;
            }
          });
          status.innerText = "Last synced: " + new Date().toLocaleTimeString();
        });
    }, 5000);
  </script>
</body>
</html>

  </style>
</head>
<body>
  <h1>Collaborative Page</h1>
  <div id="blocks">
    <?php foreach ($blocks as $block): ?>
      <div class="block" contenteditable="true" data-id="<?= $block['id'] ?>">
        <?= htmlspecialchars($block['content']) ?>
      </div>
    <?php endforeach; ?>
  </div>
  <button onclick="addBlock()">+ Add Block</button>

  <script>
    // Save content on blur
    document.querySelectorAll(".block").forEach(block => {
      block.addEventListener("blur", () => {
        const id = block.dataset.id;
        const content = block.innerText;
        fetch("save_block.php", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({id, content})
        });
      });
    });

    // Add new block
    function addBlock() {
      fetch("add_block.php")
        .then(res => res.text())
        .then(html => {
          const div = document.createElement("div");
          div.innerHTML = html;
          document.getElementById("blocks").appendChild(div.firstChild);
        });
    }

    // Poll for updates every 5s
    setInterval(() => {
      fetch("fetch_blocks.php")
        .then(res => res.json())
        .then(data => {
          document.querySelectorAll(".block").forEach(div => {
            const id = div.dataset.id;
            const updated = data.find(b => b.id == id);
            if (updated && document.activeElement !== div) {
              div.innerText = updated.content;
            }
          });
        });
    }, 5000);
  </script>
</body>
</html>

<?php
require 'config.php';

// $page_id must be passed from room.php
if (!isset($page_id)) {
    die("Page not found.");
}

// Fetch all blocks for this page
$stmt = $db->prepare("SELECT * FROM blocks WHERE page_id = ? ORDER BY id ASC");
$stmt->bind_param("i", $page_id);
$stmt->execute();
$result = $stmt->get_result();
$blocks = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Collaborative Room</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f0f2f5;
      padding: 30px;
      max-width: 800px;
      margin: auto;
      color: #333;
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h1 {
      font-size: 30px;
      margin-bottom: 25px;
      text-align: center;
      color: #0056b3;
    }

    .block {
      background: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 14px 18px;
      margin-bottom: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
      min-height: 45px;
      cursor: text;
      transition: all 0.25s ease;
      animation: slideUp 0.4s ease;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .block:hover {
      box-shadow: 0 6px 12px rgba(0,0,0,0.12);
    }

    .block:focus {
      outline: none;
      border-color: #007bff;
      box-shadow: 0 0 0 4px rgba(0,123,255,0.2);
    }

    .button-group {
      display: flex;
      justify-content: center;
      gap: 16px;
      margin: 25px 0 15px 0;
      flex-wrap: wrap;
    }

    button {
      background-color: #007bff;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.25s, transform 0.2s;
    }

    button:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }

    #status {
      text-align: center;
      font-size: 14px;
      color: gray;
      margin-top: 15px;
    }

    .share-button {
      display: block;
      margin: 20px auto 0 auto;
      background: white;
      color: #007bff;
      border: 2px solid #007bff;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 8px;
      transition: all 0.25s ease;
    }

    .share-button:hover {
      background: #007bff;
      color: white;
    }

    @media (max-width: 600px) {
      button {
        width: 100%;
      }
      .button-group {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <h1>📝 Collaborative Room</h1>

  <div id="blocks">
    <?php foreach ($blocks as $block): ?>
      <div class="block" contenteditable="true" data-id="<?= $block['id'] ?>">
        <?= htmlspecialchars($block['content']) ?>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="button-group">
    <button onclick="addBlock()">+ Add Block</button>
    <button onclick="deleteBlockWithAlert()">- Delete Block</button>
  </div>

  <div id="status">Last synced: never</div>

  <button onclick="copyLink()" class="share-button">🔗 Share Room</button>

<script>
  const status = document.getElementById("status");

  // Save block on blur
  document.querySelectorAll(".block").forEach(block => {
    block.addEventListener("blur", () => {
      const id = block.dataset.id;
      const content = block.innerText;
      fetch("save_block.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, content })
      }).then(() => {
        status.innerText = "Last synced: just now";
      });
    });
  });

  // Add new block
  function addBlock() {
    fetch("add_block.php?page_id=<?= $page_id ?>")
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
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id, content })
          }).then(() => {
            status.innerText = "Last synced: just now";
          });
        });
      });
  }

  // Delete block with alert
  function deleteBlockWithAlert() {
    if (confirm("Are you sure you want to delete the last block?")) {
      deleteBlock();
    }
  }

  // Delete block logic
  function deleteBlock() {
    const blocks = document.querySelectorAll(".block");
    if (blocks.length > 0) {
      const lastBlock = blocks[blocks.length - 1];
      const id = lastBlock.dataset.id;

      fetch("delete_block.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
      }).then(() => {
        lastBlock.remove();
        status.innerText = "Last synced: just now";
      });
    } else {
      alert("No blocks to delete!");
    }
  }

  // Copy link to clipboard
  function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
      alert("Room link copied!");
    });
  }

  // Poll for block updates
  setInterval(() => {
    fetch("fetch_blocks.php?page_id=<?= $page_id ?>")
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

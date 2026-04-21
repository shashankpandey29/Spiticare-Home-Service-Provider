function sendMessage() {
  const input = document.getElementById("userInput");
  const message = input.value.trim();
  if (!message) return;

  const chatBox = document.getElementById("chatBox");

  // Show user message
  chatBox.innerHTML += `<div class="user-msg">${message}</div>`;
  chatBox.scrollTop = chatBox.scrollHeight;

  input.value = "";

  // Show typing animation
  const typingDiv = document.createElement("div");
  typingDiv.className = "typing";
  typingDiv.id = "typingIndicator";
  typingDiv.innerHTML = `
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  `;

  chatBox.appendChild(typingDiv);
  chatBox.scrollTop = chatBox.scrollHeight;

  // Fetch bot response (with delay for realism)
  fetch("chatbot.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ message })
  })
  .then(res => res.json())
  .then(data => {
    // Simulate typing delay
    setTimeout(() => {
      typingDiv.remove(); // remove typing animation
      chatBox.innerHTML += `<div class="bot-msg">${data.reply}</div>`;
      chatBox.scrollTop = chatBox.scrollHeight;
    }, 1200); // 1.2 seconds delay
  });
}

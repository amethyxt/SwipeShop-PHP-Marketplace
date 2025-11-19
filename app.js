const ws = new WebSocket('ws://localhost:3000/server');

const userInfoModal = document.querySelector('.user-info-modal');
const userInfoForm = document.querySelector('.user-info-form');

const chatHeader = document.querySelector('.chat-header');
const chatMessages = document.querySelector('.chat-messages');
const chatInputForm = document.querySelector('.chat-input-form');
const chatInput = document.querySelector('.chat-input');
const clearChatBtn = document.querySelector('.clear-chat-button');

let messageSender = '';
let chatCode = '';

// Function to create chat message elements
const createChatMessageElement = (message) => `
  <div class="message ${message.sender === messageSender ? 'blue-bg' : 'gray-bg'}">
    <div class="message-sender">${message.sender}</div>
    <div class="message-text">${message.text}</div>
    ${message.image ? `<img src="${message.image}" alt="Sent Image" class="message-image" />` : ''}
    <div class="message-timestamp">${message.timestamp}</div>
  </div>
`;

// Function to update the message sender and chat code
const updateMessageSender = (name, code) => {
  messageSender = name;
  chatCode = code;
  chatHeader.innerText = `${name} chatting with code: ${code}`;
  chatInput.placeholder = `Type here, ${messageSender}...`;
  chatInput.focus(); // Auto-focus the input field
};

// Event listener for receiving messages from the server
ws.onmessage = (event) => {
  const message = JSON.parse(event.data);
  chatMessages.innerHTML += createChatMessageElement(message);
};

// Event listener for the user info form submission
userInfoForm.addEventListener('submit', (e) => {
  e.preventDefault();
  const username = e.target.username.value;
  const chatCodeValue = e.target.chatCode.value;

  updateMessageSender(username, chatCodeValue);
  ws.send(JSON.stringify({ type: 'join', chatCode: chatCodeValue }));
  userInfoModal.style.display = 'none';
});

// Send message function
const sendMessage = (e) => {
  e.preventDefault();

  if (ws.readyState !== WebSocket.OPEN) {
    console.error('WebSocket connection is not open');
    return;
  }

  const timestamp = new Date().toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
  const message = { sender: messageSender, text: chatInput.value, timestamp, chatCode };

  const fileInput = document.querySelector('.file-input');
  if (fileInput.files.length > 0) {
    const file = fileInput.files[0];
    const reader = new FileReader();
  
    reader.onload = (event) => {
      const imageBase64 = event.target.result;
      const imageMessage = { ...message, image: imageBase64 };
      console.log('Image base64:', imageBase64); // ตรวจสอบว่าการแปลงไฟล์เป็น base64 สำเร็จหรือไม่
      ws.send(JSON.stringify(imageMessage));
    };
  
    reader.readAsDataURL(file);
  } else {
    ws.send(JSON.stringify(message)); // ส่งข้อความธรรมดา
  }

  // Clear input field
  chatInputForm.reset();

  // Scroll to bottom of chat messages
  chatMessages.scrollTop = chatMessages.scrollHeight;
};


// Event listener for sending messages
chatInputForm.addEventListener('submit', sendMessage);

// Event listener for clearing chat
clearChatBtn.addEventListener('click', () => {
  localStorage.clear();
  chatMessages.innerHTML = '';
});

// Function to generate a unique chat code
function generateChatCode() {
  return Math.random().toString(36).substr(2, 9); // Random string for chat code
}

// Add event listener when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
  const chatButtons = document.querySelectorAll('.chat-btn');

  chatButtons.forEach(button => {
    button.addEventListener('click', function() {
      const buyerId = this.getAttribute('data-buyer-id');
      const itemId = this.getAttribute('data-item-id');
      const chatCode = generateChatCode();

      const username = prompt("Please enter your username:");
      if (username) { // Ensure username is provided
        window.location.href = `index.html?chatCode=${chatCode}&username=${username}`;
        
        // Optional: Send notification to the seller
        sendNotification(username, chatCode, itemId);
      }
    });
  });
});

// Function to send notification to the seller
function sendNotification(username, chatCode, itemId) {
  fetch('notification.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ username, chatCode, itemId }),
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === 'success') {
      console.log('Notification sent successfully');
    } else {
      console.error('Error sending notification:', data.message);
    }
  });
}

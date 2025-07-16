function setupAutoResizeTextarea() {
    const textarea = document.getElementById('chatbot-user-input');
    const maxHeight = 120;
    
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        const newHeight = Math.min(this.scrollHeight, maxHeight);
        this.style.height = newHeight + 'px';
        this.style.overflowY = newHeight >= maxHeight ? 'auto' : 'hidden';
    });

    document.getElementById('chatbot-toggle').addEventListener('click', function() {
        if (document.getElementById('chatbot-box').classList.contains('hidden')) {
            setTimeout(() => textarea.focus(), 300);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const closeBtn = document.getElementById('chatbot-close');
    const chatBox = document.getElementById('chatbot-box');
    const messagesContainer = document.getElementById('chatbot-messages');
    const userInput = document.getElementById('chatbot-user-input');
    const sendBtn = document.getElementById('chatbot-send');

    // ✅ Simpan session_id di localStorage
    let sessionId = localStorage.getItem("chatbot_session_id");
    if (!sessionId) {
        sessionId = crypto.randomUUID();
        localStorage.setItem("chatbot_session_id", sessionId);
    }

    toggleBtn.addEventListener('click', function() {
        if (chatBox.classList.contains('visible')) {
            chatBox.style.opacity = '0';
            chatBox.style.transform = 'translateY(20px)';
            setTimeout(() => {
                chatBox.classList.remove('visible');
            }, 300);
        } else {
            chatBox.classList.add('visible');
            void chatBox.offsetWidth;
            chatBox.style.opacity = '1';
            chatBox.style.transform = 'translateY(0)';
            setTimeout(() => userInput.focus(), 300);
        }
    });

    closeBtn.addEventListener('click', function() {
        chatBox.style.opacity = '0';
        chatBox.style.transform = 'translateY(20px)';
        setTimeout(() => {
            chatBox.classList.remove('visible');
        }, 300);
    });

    sendBtn.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    setupAutoResizeTextarea();

    function sendMessage() {
        const message = userInput.value.trim();
        if (message === '') return;

        addMessage(message, 'user');
        userInput.value = '';
        userInput.style.height = 'auto';
        userInput.focus();

        showTypingIndicator();

        fetch("/ask-ai", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                content: message,
                session_id: sessionId
            })
        })
        .then(res => res.json())
        .then(data => {
            removeTypingIndicator();
            addMessage(data.reply, "ai");

            // Pastikan session_id tetap tersimpan jika API mengembalikan session baru
            if (data.session_id && data.session_id !== sessionId) {
                sessionId = data.session_id;
                localStorage.setItem('chatbot_session_id', sessionId);
            }
        })
        .catch(error => {
            removeTypingIndicator();
            addMessage("Terjadi kesalahan dalam menghubungi AI.", "ai");
            console.error("AI error:", error);
        });
    }

    function addMessage(text, sender) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chatbot-message', sender + '-message');
        const formattedText = text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\n/g, "<br>");
        messageElement.innerHTML = formattedText;
        messagesContainer.appendChild(messageElement);
        scrollToBottom();
    }

    function showTypingIndicator() {
        const typingElement = document.createElement('div');
        typingElement.classList.add('typing-indicator');
        typingElement.id = 'typing-indicator';
        typingElement.innerHTML = '<span></span><span></span><span></span>';
        messagesContainer.appendChild(typingElement);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const typingElement = document.getElementById('typing-indicator');
        if (typingElement) typingElement.remove();
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    setTimeout(() => {
        if (chatBox.classList.contains('visible')) return;
        const hasInteracted = localStorage.getItem('chatbotInteracted');
        if (!hasInteracted) {
            chatBox.classList.add('visible');
            void chatBox.offsetWidth;
            chatBox.style.opacity = '1';
            chatBox.style.transform = 'translateY(0)';
            localStorage.setItem('chatbotInteracted', 'true');
        }
    }, 10000);
});

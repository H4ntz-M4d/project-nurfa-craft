function setupAutoResizeTextarea() {
    const textarea = document.getElementById('chatbot-user-input');
    const maxHeight = 120; // Sesuaikan dengan max-height di CSS
    
    // Auto-resize saat input
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        const newHeight = Math.min(this.scrollHeight, maxHeight);
        this.style.height = newHeight + 'px';
        this.style.overflowY = newHeight >= maxHeight ? 'auto' : 'hidden';
    });
    
    
    // Fokus ke textarea saat chatbox dibuka
    document.getElementById('chatbot-toggle').addEventListener('click', function() {
        if (document.getElementById('chatbot-box').classList.contains('hidden')) {
            setTimeout(() => textarea.focus(), 300); // Beri sedikit delay untuk animasi
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const toggleBtn = document.getElementById('chatbot-toggle');
    const closeBtn = document.getElementById('chatbot-close');
    const chatBox = document.getElementById('chatbot-box');
    const messagesContainer = document.getElementById('chatbot-messages');
    const userInput = document.getElementById('chatbot-user-input');
    const sendBtn = document.getElementById('chatbot-send');
    
    // Toggle chatbox
    toggleBtn.addEventListener('click', function() {
        chatBox.classList.toggle('hidden');
    });
    
    // Close chatbox
    closeBtn.addEventListener('click', function() {
        chatBox.classList.add('hidden');
    });
    
    // Send message on button click
    sendBtn.addEventListener('click', sendMessage);
    
    // Send message on Enter key
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
        
        // Add user message to chat
        addMessage(message, 'user');
        userInput.value = '';
        userInput.style.height = 'auto';
        userInput.focus();
        
        // Show typing indicator
        showTypingIndicator();
        
        // Simulate AI response (replace with actual API call)
        setTimeout(() => {
            removeTypingIndicator();
            const aiResponse = generateAIResponse(message);
            addMessage(aiResponse, 'ai');
        }, 1000);
    }
    
    function addMessage(text, sender) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chatbot-message');
        messageElement.classList.add(sender + '-message');
        
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
        if (typingElement) {
            typingElement.remove();
        }
    }
    
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    // Simple response generation (replace with actual API call)
    function generateAIResponse(userMessage) {
        const responses = [
            "I understand you're asking about: " + userMessage + ". Can you provide more details?",
            "That's an interesting question! Here's what I know about this topic...",
            "I can help with that. Let me look up some information for you.",
            "Thanks for your message! I'm still learning, but I'll do my best to assist you.",
            "I've noted your question about " + userMessage + ". Is there anything specific you'd like to know?"
        ];
        
        return responses[Math.floor(Math.random() * responses.length)];
    }
    
    // Optional: Auto-open after 10 seconds if not interacted with
    setTimeout(() => {
        if (!chatBox.classList.contains('hidden')) return;
        const hasInteracted = localStorage.getItem('chatbotInteracted');
        if (!hasInteracted) {
            chatBox.classList.remove('hidden');
            localStorage.setItem('chatbotInteracted', 'true');
        }
    }, 10000);
});
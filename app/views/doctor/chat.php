<?php
/**
 * View: Giao diện chat cho bác sĩ
 * Path: views/doctor/chat.php
 */
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Header -->
            <div class="card border-bottom-0 rounded-top">
                <div class="card-header bg-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">💬 Nhắn tin với BN. <?= htmlspecialchars($appointment['patient_name']) ?></h5>
                            <small>Lịch khám: <?= date('d/m/Y H:i', strtotime($appointment['appointment_date'] . ' ' . $appointment['appointment_time'])) ?></small>
                        </div>
                        <a href="<?= BASE_URL ?>/doctor/appointments" class="btn btn-sm btn-light">← Quay lại</a>
                    </div>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messages-container" class="card border-top-0 rounded-bottom" style="height: 500px; overflow-y: auto; background: #f8f9fa;">
                <div class="p-3" id="messages-list">
                    <!-- Messages được load qua JS -->
                </div>
            </div>

            <!-- Send Form -->
            <form id="send-form" class="mt-3">
                <div class="input-group">
                    <input type="hidden" id="appointment_id" value="<?= $appointment['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    
                    <textarea 
                        id="message-input" 
                        class="form-control" 
                        rows="3" 
                        name="content" 
                        placeholder="Nhập tin nhắn..."
                        style="resize: none;"
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-success mt-2 w-100">
                    ✈️ Gửi
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    #messages-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .message {
        display: flex;
        margin-bottom: 10px;
        animation: slideIn 0.3s ease-in-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message.received {
        justify-content: flex-start;
    }

    .message-content {
        max-width: 70%;
        word-wrap: break-word;
    }

    .message.sent .message-bubble {
        background: #198754;
        color: white;
        border-radius: 18px 18px 4px 18px;
    }

    .message.received .message-bubble {
        background: #e9ecef;
        color: #333;
        border-radius: 18px 18px 18px 4px;
    }

    .message-bubble {
        padding: 10px 15px;
        padding: 12px 16px;
        font-size: 0.95rem;
        line-height: 1.4;
    }

    .message-time {
        font-size: 0.75rem;
        color: #999;
        margin-top: 4px;
        padding: 0 8px;
    }

    .message.sent .message-time {
        text-align: right;
    }

    .empty-message {
        text-align: center;
        color: #999;
        padding: 30px;
        font-style: italic;
    }
</style>

<script>
// Biến toàn cục
const appointmentId = document.getElementById('appointment_id').value;
const currentUserId = <?= Auth::id() ?>;
let lastMessageId = 0;
const messagesList = document.getElementById('messages-list');
const messagesContainer = document.getElementById('messages-container');

/**
 * Tạo HTML cho một tin nhắn
 */
function createMessageElement(msg) {
    const isSent = parseInt(msg.sender_id) === parseInt(currentUserId);
    const messageClass = isSent ? 'sent' : 'received';
    const time = new Date(msg.created_at).toLocaleTimeString('vi-VN', {
        hour: '2-digit',
        minute: '2-digit'
    });

    const div = document.createElement('div');
    div.className = `message ${messageClass}`;
    div.innerHTML = `
        <div class="message-content">
            <div class="message-bubble">${htmlspecialchars(msg.content)}</div>
            <div class="message-time">${time}</div>
        </div>
    `;
    return div;
}

/**
 * Thêm tin nhắn vào chat box
 */
function appendMessage(msg) {
    // Nếu là tin đầu tiên
    if (messagesList.querySelector('.empty-message')) {
        messagesList.innerHTML = '';
    }

    const messageElement = createMessageElement(msg);
    messagesList.appendChild(messageElement);
    
    // Auto scroll xuống cuối
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    
    // Update lastMessageId
    lastMessageId = Math.max(lastMessageId, parseInt(msg.id));
}

/**
 * Escape HTML
 */
function htmlspecialchars(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

/**
 * Tải tin nhắn mới từ server
 */
function loadMessages() {
    fetch(`<?= BASE_URL ?>/messages/fetch/${appointmentId}?last_id=${lastMessageId}`)
        .then(res => res.json())
        .then(data => {
            if (data.success && data.messages && data.messages.length > 0) {
                data.messages.forEach(appendMessage);
            }
        })
        .catch(err => console.error('Lỗi tải tin:', err));
}

/**
 * Gửi tin nhắn
 */
document.getElementById('send-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const content = document.getElementById('message-input').value.trim();
    const csrfToken = document.querySelector('input[name="csrf_token"]').value;

    if (!content) {
        alert('Vui lòng nhập tin nhắn');
        return;
    }

    try {
        const response = await fetch('<?= BASE_URL ?>/messages/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                appointment_id: appointmentId,
                content: content,
                csrf_token: csrfToken
            })
        });

        const data = await response.json();

        if (data.success) {
            document.getElementById('message-input').value = '';
            // Tải tin nhắn mới ngay lập tức
            setTimeout(loadMessages, 200);
        } else {
            alert('Lỗi: ' + (data.error || 'Không thể gửi tin'));
        }
    } catch (error) {
        console.error('Lỗi gửi tin:', error);
        alert('Lỗi kết nối tới server');
    }
});

// Tải tin nhắn lần đầu
loadMessages();

// Reload mỗi 3 giây
setInterval(loadMessages, 3000);
</script>

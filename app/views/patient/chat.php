<div class="card card-custom"><div class="card-header bg-white d-flex justify-content-between"><h5 class="mb-0"><i class="fas fa-comments me-2"></i>Chat</h5><span class="badge bg-primary"><?= e($appointment['doctor_name'] ?? $appointment['patient_name'] ?? '') ?></span></div>
<div class="card-body p-0"><div class="chat-container">
    <div class="chat-messages" id="chatMessages">
        <?php foreach ($messages as $m): ?>
        <div class="chat-bubble <?= $m['sender_id'] == Auth::id() ? 'sent' : 'received' ?>">
            <?= e($m['content']) ?><div class="time"><?= time_ago($m['created_at']) ?></div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($messages)): ?><p class="text-center text-muted py-3">Chưa có tin nhắn nào. Hãy bắt đầu trò chuyện!</p><?php endif; ?>
    </div>
    <div class="chat-input p-3">
        <input type="text" id="chatInput" class="form-control" placeholder="Nhập tin nhắn...">
        <button class="btn btn-gradient" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div></div></div>
<script>
const chatMessages = document.getElementById('chatMessages');
chatMessages.scrollTop = chatMessages.scrollHeight;

function sendMessage() {
    const input = document.getElementById('chatInput');
    if (!input.value.trim()) return;
    const receiverId = <?= json_encode($appointment['doctor_id'] ?? $appointment['patient_id'] ?? 0) ?>;
    fetch('<?= url('/api/chat/send') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `appointment_id=<?= $appointment_id ?>&receiver_id=${receiverId}&content=${encodeURIComponent(input.value)}`
    }).then(r => r.json()).then(() => {
        chatMessages.innerHTML += `<div class="chat-bubble sent">${input.value}<div class="time">Vừa xong</div></div>`;
        input.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
}
document.getElementById('chatInput').addEventListener('keydown', e => { if (e.key === 'Enter') sendMessage(); });

// Polling nw messages
setInterval(() => {
    fetch('<?= url('/api/chat/messages/' . $appointment_id) ?>')
        .then(r => r.json())
        .then(data => {
            if (data.messages) {
                chatMessages.innerHTML = '';
                data.messages.forEach(m => {
                    chatMessages.innerHTML += `<div class="chat-bubble ${m.sender_id == <?= Auth::id() ?> ? 'sent' : 'received'}">${m.content}<div class="time">${m.created_at}</div></div>`;
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }).catch(() => {});
}, 5000);
</script>

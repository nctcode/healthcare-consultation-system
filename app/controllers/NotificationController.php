<?php
class NotificationController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $notifModel = new Notification();
        $this->view('patient/notifications', [
            'title'         => 'Thông báo',
            'notifications' => $notifModel->byUser(Auth::id()),
        ], 'dashboard');
    }

    public function apiList(): void
    {
        $this->requireAuth();
        $notifModel = new Notification();
        $this->json([
            'unread' => $notifModel->unreadCount(Auth::id()),
            'notifications' => $notifModel->byUser(Auth::id(), 5),
        ]);
    }

    public function markRead(string $id): void
    {
        $this->requireAuth();
        (new Notification())->markRead((int)$id);
        $this->json(['success' => true]);
    }
}

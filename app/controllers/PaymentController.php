<?php
class PaymentController extends Controller
{
    public function pay(string $id): void
    {
        $this->requireRole('patient');
        $paymentModel = new Payment();
        $payment = $paymentModel->findFull((int)$id);
        if (!$payment) { $this->redirect('/patient/payments'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/patient/payments'); return; }
            $paymentModel->update((int)$id, [
                'method' => $this->input('method'),
                'status' => 'completed',
                'paid_at'=> date('Y-m-d H:i:s'),
                'transaction_id' => 'TXN-' . strtoupper(bin2hex(random_bytes(6))),
            ]);
            $_SESSION['flash_success'] = 'Thanh toán thành công!';
            $this->redirect('/patient/payments');
        }

        $this->view('patient/pay', [
            'title'   => 'Thanh toán',
            'payment' => $payment,
        ], 'dashboard');
    }
}

<?php
class PaymentController extends Controller
{
    public function pay(string $id): void
    {
        $this->requireRole('patient');
        $patient = (new Patient())->findByUserId(Auth::id());
        if (!$patient) { $this->redirect('/patient/payments'); return; }

        $paymentModel = new Payment();
        $payment = $paymentModel->findFull((int)$id);
        if ($payment && (int)$payment['patient_id'] !== (int)$patient['id']) {
            $payment = null;
        }
        if (!$payment) { $this->redirect('/patient/payments'); return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->validateCSRF()) { $this->redirect('/patient/payments'); return; }

            if ($payment['status'] === 'completed') {
                $_SESSION['flash_error'] = 'Hóa đơn này đã thanh toán trước đó.';
                $this->redirect('/patient/payments');
                return;
            }

            $method = $this->input('method', 'cash');
            $allowedMethods = ['cash', 'transfer', 'ewallet', 'qr_code'];
            if (!in_array($method, $allowedMethods, true)) {
                $_SESSION['flash_error'] = 'Phương thức thanh toán không hợp lệ.';
                $this->redirect('/patient/payments/' . (int)$id);
                return;
            }

            // Thanh toán tiền mặt giả lập xác nhận ngay tại quầy.
            if ($method === 'cash') {
                $paymentModel->update((int)$id, [
                    'method' => $method,
                    'status' => 'completed',
                    'paid_at'=> date('Y-m-d H:i:s'),
                    'transaction_id' => 'TXN-CASH-' . strtoupper(bin2hex(random_bytes(4))),
                ]);
                $_SESSION['flash_success'] = 'Thanh toán thành công!';
                $this->redirect('/patient/payments');
                return;
            }

            $transactionId = 'TXN-' . strtoupper(bin2hex(random_bytes(6)));
            $paymentModel->update((int)$id, [
                'method' => $method,
                'status' => 'pending',
                'transaction_id' => $transactionId,
                'paid_at' => null,
            ]);

            $this->redirect('/payment-gateway/mock/' . (int)$id . '?txn=' . urlencode($transactionId));
            return;
        }

        $this->view('patient/pay', [
            'title'   => 'Thanh toán',
            'payment' => $payment,
        ], 'dashboard');
    }
}

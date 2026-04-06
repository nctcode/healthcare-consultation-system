<?php
/**
 * PaymentGatewayController - Giả lập cổng thanh toán
 */
class PaymentGatewayController extends Controller
{
    public function mock(string $id): void
    {
        $this->requireRole('patient');

        $patient = (new Patient())->findByUserId(Auth::id());
        if (!$patient) { $this->redirect('/patient/payments'); return; }

        $payment = (new Payment())->findFull((int)$id);
        if (!$payment || (int)$payment['patient_id'] !== (int)$patient['id']) {
            $this->redirect('/patient/payments');
            return;
        }

        $txn = $this->query('txn', '');
        if (!$txn || $payment['transaction_id'] !== $txn) {
            $_SESSION['flash_error'] = 'Phiên giao dịch không hợp lệ.';
            $this->redirect('/patient/payments');
            return;
        }

        $this->view('patient/payment_gateway', [
            'title'   => 'Cổng thanh toán',
            'payment' => $payment,
            'txn'     => $txn,
        ], 'dashboard');
    }

    public function callback(): void
    {
        $this->requireRole('patient');

        $paymentId = (int)$this->query('payment_id', 0);
        $result = $this->query('result', 'failed');
        $txn = $this->query('txn', '');

        $patient = (new Patient())->findByUserId(Auth::id());
        if (!$patient || $paymentId <= 0 || !$txn) {
            $_SESSION['flash_error'] = 'Kết quả thanh toán không hợp lệ.';
            $this->redirect('/patient/payments');
            return;
        }

        $paymentModel = new Payment();
        $payment = $paymentModel->findByPatient($paymentId, (int)$patient['id']);

        if (!$payment || $payment['transaction_id'] !== $txn) {
            $_SESSION['flash_error'] = 'Không xác minh được giao dịch thanh toán.';
            $this->redirect('/patient/payments');
            return;
        }

        if ($result === 'success') {
            $paymentModel->update($paymentId, [
                'status' => 'completed',
                'paid_at' => date('Y-m-d H:i:s'),
            ]);
            $_SESSION['flash_success'] = 'Thanh toán thành công!';
        } else {
            $paymentModel->update($paymentId, [
                'status' => 'failed',
                'paid_at' => null,
            ]);
            $_SESSION['flash_error'] = 'Thanh toán thất bại. Vui lòng thử lại.';
        }

        $this->redirect('/patient/payments');
    }
}

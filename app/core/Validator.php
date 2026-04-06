<?php
/**
 * Validator - Kiểm tra dữ liệu đầu vào
 */
class Validator
{
    /** @var array Lỗi validation */
    private array $errors = [];

    /** @var array Dữ liệu cần validate */
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validate một trường
     * @param string $field Tên trường
     * @param string $label Nhãn hiển thị (tiếng Việt)
     * @param string $rules Quy tắc (VD: 'required|email|min:6|max:255')
     */
    public function validate(string $field, string $label, string $rules): self
    {
        $value = $this->data[$field] ?? '';
        $ruleList = explode('|', $rules);

        foreach ($ruleList as $rule) {
            $param = null;
            if (str_contains($rule, ':')) {
                [$rule, $param] = explode(':', $rule, 2);
            }

            switch ($rule) {
                case 'required':
                    if (empty(trim((string)$value))) {
                        $this->errors[$field] = "{$label} không được để trống.";
                    }
                    break;
                case 'email':
                    if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $this->errors[$field] = "{$label} không hợp lệ.";
                    }
                    break;
                case 'min':
                    if (!empty($value) && strlen($value) < (int)$param) {
                        $this->errors[$field] = "{$label} phải có ít nhất {$param} ký tự.";
                    }
                    break;
                case 'max':
                    if (!empty($value) && strlen($value) > (int)$param) {
                        $this->errors[$field] = "{$label} không được quá {$param} ký tự.";
                    }
                    break;
                case 'numeric':
                    if (!empty($value) && !is_numeric($value)) {
                        $this->errors[$field] = "{$label} phải là số.";
                    }
                    break;
                case 'date':
                    if (!empty($value) && !strtotime($value)) {
                        $this->errors[$field] = "{$label} không đúng định dạng ngày.";
                    }
                    break;
                case 'in':
                    $options = explode(',', $param);
                    if (!empty($value) && !in_array($value, $options)) {
                        $this->errors[$field] = "{$label} không hợp lệ.";
                    }
                    break;
                case 'match':
                    $matchValue = $this->data[$param] ?? '';
                    if ($value !== $matchValue) {
                        $this->errors[$field] = "{$label} không khớp.";
                    }
                    break;
            }

            // Nếu đã có lỗi cho field này, skip các rule tiếp
            if (isset($this->errors[$field])) break;
        }

        return $this;
    }

    /**
     * Kiểm tra có lỗi không
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Lấy danh sách lỗi
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Lấy lỗi đầu tiên
     */
    public function firstError(): ?string
    {
        return $this->errors ? reset($this->errors) : null;
    }
}

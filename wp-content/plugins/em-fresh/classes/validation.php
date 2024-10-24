<?php
defined('ABSPATH') or die();

class EM_Validation
{
    protected $class;

    /**
     * Constructor: setups filters and actions
     *
     * @since 1.0
     *
     */
    function __construct($class = false)
    {
        if ($class != false) {
            $this->class = $class;
        }
    }

    /**
     * data
     */
    function data($data = [], $valids = [])
    {
        $errors = [];

        foreach ($valids as $field => $require) {
            if (isset($data[$field]) && $data[$field] != '') {
                $value = $data[$field];

                foreach (explode(',', $require) as $require) {
                    $list = explode(':', $require);

                    $error = $this->item($value, $list[0], isset($list[1]) ? $list[1] : null);

                    if ($error != '') {
                        $errors[$field] = $error;

                        break;
                    }
                }
            } else {
                $errors[$field] = 'Dữ liệu rỗng';
            }
        }

        return $errors;
    }

    /**
     * item
     */
    function item($value = '', $type = '', $rule = null)
    {
        $error = '';

        $error_text = 'Không đúng định dạng';

        if ($type == 'email') {
            if ($this->email($value) == false) {
                $error = "$error_text email";
            }
        } else if ($type == 'phone') {
            if ($this->phone($value) == false) {
                $error = "$error_text số điện thoại";
            }
        } else if ($type == 'preg' && is_string($rule) && preg_match($rule, $value) == false) {
            $error = $error_text;
        } else if ($type == 'number') {
            if (is_numeric($value) == false || $value == 0) {
                $error = "$error_text số";
            }
        } else if ($type == 'length') {
            if (strlen($value) != $rule) {
                $error = "Chiều dài chưa đủ";
            }
        } else if ($type == 'minlength') {
            if (strlen($value) < $rule) {
                $error = "Chiều dài tối thiểu là $rule";
            }
        } else if ($type == 'maxlength') {
            if (strlen($value) > $rule) {
                $error = "Chiều dài tối đa là $rule";
            }
        } else if ($type == 'min' && is_numeric($rule)) {
            if (intval($value) < $rule) {
                $error = "Giá trị tối thiểu là $rule";
            }
        } else if ($type == 'max' && is_numeric($rule)) {
            if (intval($value) > $rule) {
                $error = "Giá trị tối đa là $rule";
            }
        }

        if ($error == '' && $rule == 'exists' && $this->exists([$type => $value])) {
            $error = "Đã tồn tại";
        }

        if($error != '') {
            $error = "$value : $error";
        }

        return $error;
    }

    /**
     * email
     */
    function email($value = '')
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /**
     * phone number
     */
    function phone($value = '')
    {
        if (strlen($value) == 10 && preg_match('/[0-9]/', $value) && substr($value, 0, 1) == '0') {
            return true;
        }

        return false;
    }

    /**
     * password
     */
    function password($value = '')
    {
        if (preg_match('/^[a-zA-Z0-9!@#$%^&*]{8,20}$/', $value)) {
            return true;
        }

        return false;
    }

    /**
     * url
     */
    function url($value = '')
    {
        if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
            return true;
        }

        return false;
    }

    /**
     * exists
     */
    function exists($args = [])
    {
        if (is_object($this->class) && method_exists($this->class, 'exists')) {
            return $this->class->exists($args);
        }

        return false;
    }
}

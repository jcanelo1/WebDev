<?php
require_once('constants.php');

class Rest {
    protected $request;
    protected $serviceName;
    protected $param;

    public function __construct() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->throwError(REQUEST_METHOD_NOT_VALID, 'Requested method is not valid.');
        }
        $handler = fopen('php://input', 'r');
        $this->request = stream_get_contents($handler);
        $this->validateRequest();
    }

    public function validateRequest() {
        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            $this->throwError(REQUEST_CONTENT_TYPE_NOT_VALID, 'Requested content type is not valid.');
        }
        $data = json_decode($this->request, true);
        if (!isset($data['name']) || $data['name'] == '') {
            $this->throwError(API_NAME_REQUIRED, "API name required.");
        }
        $this->serviceName = $data['name'];
        if (!is_array($data['param'])) {
            $this->throwError(API_PARAM_REQUIRED, "API param required.");
        }
        $this->param = $data['param'];
    }

    public function processApi() {
        $api = new API;
    
        if (!method_exists($api, $this->serviceName)) {
            $this->throwError(API_DOES_NOT_EXIST, "API does not exist.");
        }
    
        // Optionally pass $param to API method
        call_user_func([$api, $this->serviceName], $this->param);
    }

    public function validateParameter($fieldName, $value, $dataType, $required = true) {
        if ($required && empty($value)) {
            $this->throwError(VALID_PARAMETER_REQUIRED, $fieldName . " parameter is required.");
        }
        switch ($dataType) {
            case BOOLEAN:
                if (!is_bool($value)) {
                    $this->throwError(VALID_PARAMETER_DATATYPE_REQUIRED, "Datatype is not valid for " . $fieldName);
                }
                break;
            case INTEGER:
                if (!is_numeric($value)) {
                    $this->throwError(VALID_PARAMETER_DATATYPE_REQUIRED, "Datatype is not valid for " . $fieldName . " . It should be numeric");
                }
                break;
            case STRING:
                if (!is_string($value)) {
                    $this->throwError(VALID_PARAMETER_DATATYPE_REQUIRED, "Datatype is not valid for " . $fieldName . " . It should be string.");
                }
                break;
            default:
                $this->throwError(VALID_PARAMETER_DATATYPE_REQUIRED, "Datatype is not valid for " . $fieldName . ".");
        }
        return $value;
    }

    public function throwError($code, $message) {
        header("content-type: application/json");
        $errorMsg = json_encode(['status' => $code, 'message' => $message]);
        echo $errorMsg;
        exit;
    }

    public function returnResponse($code, $data) {
        header("content-type: application/json");
        $response = json_encode(['response' => ['status' => $code, "result" => $data]]);
        echo $response;
        exit;
    }
}
?>
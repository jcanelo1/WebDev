<?php
define('SECRET_KEY', 'yorksj123');
define('APP_NAME', 'DunderMifflinPortal');
define('APP_ENV', 'development');
define('APP_DEBUG', true);

define('SUCCESS_RESPONSE', 200);
define('INVALID_USER_PASSWORD', 108);
define('JWT_PROCESSING_ERROR', 300);

define('DATA_TYPE_STRING', '3');
define('SESSION_TIMEOUT', 1800);

define('TABLE_USERS', 'users');
define('TABLE_CONTACT_MESSAGES', 'contact_messages');

define('EMAIL_FROM', 'no-reply@dundermifflin.com');
define('EMAIL_CONTACT_RECEIVER', 'support@dundermifflin.com');

define('ENABLE_LOGGING', true);
define('LOG_FILE_PATH', __DIR__ . '/../logs/app.log');
?>
Simple File Logger
==================

[![Build Status](https://travis-ci.org/digital-canvas/simple-file-logger.svg?branch=master)](https://travis-ci.org/digital-canvas/simple-file-logger)


A simple logger that logs messages to a file.

## Installation

Install with composer

```bash
php composer.phar require digital-canvas/simple-file-logger
```

or add the following to your composer.json

```json
"digital-canvas/simple-file-logger" : "dev-master"
```

```php
// Create Logger instance
$file = "path/to/log/file.log";
$logger = new SimpleFileLogger($file);

// Log DEBUG message
$logger->debug("DEBUG log message");
$logger->log(SimpleFileLogger::DEBUG, "DEBUG log message");

// Log INFO message
$logger->info("INFO log message");
$logger->log(SimpleFileLogger::INFO, "INFO log message");

// Log NOTICE message
$logger->notice("NOTICE log message");
$logger->log(SimpleFileLogger::NOTICE, "NOTICE log message");

// Log WARNING message
$logger->warning("WARNING log message");
$logger->log(SimpleFileLogger::WARNING, "WARNING log message");

// Log ERROR message
$logger->error("ERROR log message");
$logger->log(SimpleFileLogger::ERROR, "ERROR log message");

// Log CRITICAL message
$logger->critical("CRITICAL log message");
$logger->log(SimpleFileLogger::CRITICAL, "CRITICAL log message");

// Log ALERT message
$logger->alert("ALERT log message");
$logger->log(SimpleFileLogger::ALERT, "ALERT log message");

// Log EMERGENCY message
$logger->emergency("EMERGENCY log message");
$logger->log(SimpleFileLogger::EMERGENCY, "EMERGENCY log message");

// Log with extra data
$logger->log(SimpleFileLogger::INFO, "INFO log message", array('user' => "Bob", "exception" => new Exception()));

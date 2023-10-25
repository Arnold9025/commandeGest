<?php function logVisitor()
{
    $record = $_SERVER['REMOTE_ADDR'] . ' ' . date(DATE_RFC822) . PHP_EOL;
    file_put_contents("log/visitors.log", $record, FILE_APPEND);
}

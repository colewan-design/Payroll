<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$conn = mysqli_connect("bsu-info.tech", "u455679702_cps", "OpK3RKh]!h9", "u455679702_cps");

$filePath = "backup_database.sql";
function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';
    
    if (file_exists($filePath)) {
        $lines = file($filePath);
        
        foreach ($lines as $line) {
            
            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            
            $sql .= $line;
            
            if (substr(trim($line), - 1, 1) == ';') {
                // Check if the line contains a CREATE TABLE statement
                if (strpos($sql, 'CREATE TABLE') !== false) {
                    // Get the table name from the CREATE TABLE statement
                    preg_match('/CREATE TABLE `(.*)`/', $sql, $matches);
                    $tableName = $matches[1];
                    
                    // Drop the table if it already exists
                    $dropSql = "DROP TABLE IF EXISTS `$tableName`;";
                    mysqli_query($conn, $dropSql);
                }
                
                $result = mysqli_query($conn, $sql);
                if (! $result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach
        
        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
    } // end if file exists 
    return $response;
}
restoreMysqlDB($filePath,$conn);
header('Location: employees.php#restoreSuccessModal');
?>

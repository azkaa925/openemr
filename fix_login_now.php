<?php
/**
 * AUTOMATIC FIX SCRIPT FOR TELETONICMD LOGIN
 *
 * This script will automatically update your OpenEMR database
 * to use the custom TeletonicMD login template
 *
 * USAGE:
 * 1. SSH into your VPS: ssh root@157.173.212.240
 * 2. cd /var/www/html (or your OpenEMR directory)
 * 3. Run: php fix_login_now.php
 *
 * This will automatically fix everything!
 */

echo "\n";
echo "================================================\n";
echo "TeletonicMD Login Auto-Fix Script\n";
echo "================================================\n\n";

// Step 1: Check if we're in the right directory
if (!file_exists('interface/globals.php')) {
    echo "❌ ERROR: Not in OpenEMR directory!\n";
    echo "Please run this from your OpenEMR root directory.\n";
    echo "Try: cd /var/www/html/openemr\n";
    exit(1);
}

echo "✅ Found OpenEMR installation\n\n";

// Step 2: Load database configuration
if (!file_exists('sites/default/sqlconf.php')) {
    echo "❌ ERROR: Cannot find database configuration!\n";
    echo "Looking for: sites/default/sqlconf.php\n";
    exit(1);
}

require_once('sites/default/sqlconf.php');
echo "✅ Loaded database configuration\n\n";

// Step 3: Connect to database
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbase;charset=utf8mb4";
    $pdo = new PDO($dsn, $login, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to database successfully\n\n";
} catch (Exception $e) {
    echo "❌ ERROR: Cannot connect to database!\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}

// Step 4: Check current settings
echo "Checking current settings...\n";
echo "----------------------------------------\n";

$stmt = $pdo->query("SELECT gl_name, gl_value FROM globals WHERE gl_name IN ('login_page_layout', 'login_tagline_text', 'show_tagline_on_login')");
$current = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

foreach ($current as $key => $value) {
    echo "  $key: " . substr($value, 0, 60) . "...\n";
}
echo "\n";

// Step 5: Update the configuration
echo "Applying TeletonicMD customizations...\n";
echo "----------------------------------------\n";

$updates = [
    'login_page_layout' => 'login/layouts/teletonicmd_custom.html.twig',
    'login_tagline_text' => 'Welcome to TeleTonicMD Secure Telemedicine Portal',
    'show_tagline_on_login' => '1'
];

foreach ($updates as $key => $value) {
    try {
        // Check if the key exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM globals WHERE gl_name = ?");
        $checkStmt->execute([$key]);
        $exists = $checkStmt->fetchColumn() > 0;

        if ($exists) {
            // Update existing value
            $stmt = $pdo->prepare("UPDATE globals SET gl_value = ? WHERE gl_name = ?");
            $stmt->execute([$value, $key]);
            echo "  ✅ Updated: $key\n";
        } else {
            // Insert new value
            $stmt = $pdo->prepare("INSERT INTO globals (gl_name, gl_value) VALUES (?, ?)");
            $stmt->execute([$key, $value]);
            echo "  ✅ Inserted: $key\n";
        }
    } catch (Exception $e) {
        echo "  ❌ Failed to update $key: " . $e->getMessage() . "\n";
    }
}

echo "\n";

// Step 6: Verify the updates
echo "Verifying updates...\n";
echo "----------------------------------------\n";

$stmt = $pdo->query("SELECT gl_name, gl_value FROM globals WHERE gl_name IN ('login_page_layout', 'login_tagline_text', 'show_tagline_on_login')");
$updated = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$success = true;
foreach ($updates as $key => $expectedValue) {
    if (isset($updated[$key]) && $updated[$key] === $expectedValue) {
        echo "  ✅ $key: CORRECT\n";
    } else {
        echo "  ❌ $key: FAILED\n";
        $success = false;
    }
}

echo "\n";

// Step 7: Check if template files exist
echo "Checking template files...\n";
echo "----------------------------------------\n";

$templatePath = 'templates/login/layouts/teletonicmd_custom.html.twig';
if (file_exists($templatePath)) {
    echo "  ✅ Template file exists: $templatePath\n";
    echo "     Size: " . filesize($templatePath) . " bytes\n";
} else {
    echo "  ❌ Template file MISSING: $templatePath\n";
    echo "     Run: git pull origin master\n";
    $success = false;
}

$cssPath = 'interface/themes/teletonic_custom/main.css';
if (file_exists($cssPath)) {
    echo "  ✅ CSS file exists: $cssPath\n";
    echo "     Size: " . filesize($cssPath) . " bytes\n";
} else {
    echo "  ❌ CSS file MISSING: $cssPath\n";
    echo "     Run: git pull origin master\n";
    $success = false;
}

echo "\n";

// Step 8: Final status
echo "================================================\n";
if ($success) {
    echo "✅ SUCCESS! TeletonicMD login is configured!\n";
    echo "================================================\n\n";
    echo "Next steps:\n";
    echo "1. Clear your browser cache (Ctrl+Shift+R)\n";
    echo "2. Restart Apache: systemctl restart apache2\n";
    echo "3. Visit: https://157.173.212.240\n";
    echo "\n";
    echo "You should now see:\n";
    echo "- 'Welcome to TeleTonicMD Secure Telemedicine Portal' tagline\n";
    echo "- Pastel blue and lavender colors\n";
    echo "- Modern medical interface\n";
} else {
    echo "⚠️  PARTIAL SUCCESS - Some issues remain\n";
    echo "================================================\n\n";
    echo "Please check the errors above and:\n";
    echo "1. Make sure files are up to date: git pull origin master\n";
    echo "2. Check file permissions: chown -R www-data:www-data .\n";
    echo "3. Restart services: systemctl restart apache2\n";
}

echo "\n";
?>
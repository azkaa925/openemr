<?php
/**
 * TeletonicMD Login Configuration Checker
 * Run this file on your VPS to diagnose login template issues
 *
 * Usage: Place in OpenEMR root and access via browser or run: php check_login_config.php
 */

// Check if we're in CLI or web mode
$isCLI = php_sapi_name() === 'cli';
$nl = $isCLI ? "\n" : "<br>";
$bold = $isCLI ? "\033[1m" : "<strong>";
$boldEnd = $isCLI ? "\033[0m" : "</strong>";
$green = $isCLI ? "\033[32m" : "<span style='color: green'>";
$red = $isCLI ? "\033[31m" : "<span style='color: red'>";
$yellow = $isCLI ? "\033[33m" : "<span style='color: orange'>";
$colorEnd = $isCLI ? "\033[0m" : "</span>";

if (!$isCLI) {
    echo "<pre style='font-family: monospace; padding: 20px; background: #f5f5f5;'>";
}

echo $bold . "========================================$nl";
echo "TeletonicMD Login Configuration Checker$nl";
echo "========================================" . $boldEnd . "$nl$nl";

// 1. Check current directory
echo $bold . "1. Current Directory:" . $boldEnd . "$nl";
echo "   " . getcwd() . "$nl$nl";

// 2. Check if globals.inc.php exists
echo $bold . "2. Checking globals.inc.php:" . $boldEnd . "$nl";
$globalsPath = 'library/globals.inc.php';
if (file_exists($globalsPath)) {
    echo "   $green✓ File exists$colorEnd$nl";

    // Load the globals file
    require_once($globalsPath);

    // Check login_page_layout setting
    echo $nl . $bold . "3. Login Page Layout Configuration:" . $boldEnd . "$nl";
    if (isset($GLOBALS['login_page_layout'])) {
        $layout = $GLOBALS['login_page_layout'];
        echo "   Current setting: $yellow" . $layout . "$colorEnd$nl";

        if (strpos($layout, 'teletonicmd_custom') !== false) {
            echo "   $green✓ Custom TeletonicMD template is configured!$colorEnd$nl";
        } else {
            echo "   $red✗ Custom template NOT configured$colorEnd$nl";
            echo "   Expected: login/layouts/teletonicmd_custom.html.twig$nl";
        }
    } else {
        echo "   $red✗ login_page_layout not found in globals$colorEnd$nl";
    }

    // Check tagline
    echo $nl . $bold . "4. Login Tagline Configuration:" . $boldEnd . "$nl";
    if (isset($GLOBALS['login_tagline_text'])) {
        $tagline = $GLOBALS['login_tagline_text'];
        echo "   Current tagline: $yellow" . $tagline . "$colorEnd$nl";

        if (strpos($tagline, 'TeleTonicMD') !== false) {
            echo "   $green✓ Custom tagline is set!$colorEnd$nl";
        } else {
            echo "   $red✗ Default tagline still in use$colorEnd$nl";
        }
    }
} else {
    echo "   $red✗ File not found at $globalsPath$colorEnd$nl";
    echo "   Make sure you run this from OpenEMR root directory$nl";
}

// 3. Check if custom template file exists
echo $nl . $bold . "5. Custom Template File:" . $boldEnd . "$nl";
$templatePath = 'templates/login/layouts/teletonicmd_custom.html.twig';
if (file_exists($templatePath)) {
    echo "   $green✓ Template exists at: $templatePath$colorEnd$nl";
    echo "   File size: " . filesize($templatePath) . " bytes$nl";
    echo "   Last modified: " . date('Y-m-d H:i:s', filemtime($templatePath)) . "$nl";
} else {
    echo "   $red✗ Template NOT found at: $templatePath$colorEnd$nl";
}

// 4. Check if CSS file exists
echo $nl . $bold . "6. Custom CSS File:" . $boldEnd . "$nl";
$cssPath = 'interface/themes/teletonic_custom/main.css';
if (file_exists($cssPath)) {
    echo "   $green✓ CSS exists at: $cssPath$colorEnd$nl";
    echo "   File size: " . filesize($cssPath) . " bytes$nl";
    echo "   Last modified: " . date('Y-m-d H:i:s', filemtime($cssPath)) . "$nl";
} else {
    echo "   $red✗ CSS NOT found at: $cssPath$colorEnd$nl";
}

// 5. Check Git status
echo $nl . $bold . "7. Git Repository Status:" . $boldEnd . "$nl";
if (is_dir('.git')) {
    echo "   $green✓ Git repository detected$colorEnd$nl";

    // Get current branch
    $branch = trim(shell_exec('git branch --show-current 2>&1'));
    echo "   Current branch: $yellow$branch$colorEnd$nl";

    // Get last commit
    $lastCommit = trim(shell_exec('git log -1 --oneline 2>&1'));
    echo "   Last commit: $lastCommit$nl";

    // Check for uncommitted changes
    $status = shell_exec('git status --short 2>&1');
    if (empty(trim($status))) {
        echo "   $green✓ No uncommitted changes$colorEnd$nl";
    } else {
        echo "   $yellow⚠ Uncommitted changes detected$colorEnd$nl";
    }
} else {
    echo "   $red✗ Not a git repository$colorEnd$nl";
}

// 6. Database check (if possible)
echo $nl . $bold . "8. Database Configuration Check:" . $boldEnd . "$nl";
if (file_exists('sites/default/sqlconf.php')) {
    include_once('sites/default/sqlconf.php');

    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbase";
        $pdo = new PDO($dsn, $login, $pass);

        // Check login_page_layout in database
        $stmt = $pdo->query("SELECT gl_value FROM globals WHERE gl_name = 'login_page_layout'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "   Database value: $yellow" . $result['gl_value'] . "$colorEnd$nl";

            if (strpos($result['gl_value'], 'teletonicmd_custom') !== false) {
                echo "   $green✓ Database has custom template configured!$colorEnd$nl";
            } else {
                echo "   $red✗ Database needs updating$colorEnd$nl";
                echo "   Run: UPDATE globals SET gl_value='login/layouts/teletonicmd_custom.html.twig' WHERE gl_name='login_page_layout';$nl";
            }
        }

        // Check tagline in database
        $stmt = $pdo->query("SELECT gl_value FROM globals WHERE gl_name = 'login_tagline_text'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "   Tagline in DB: $yellow" . substr($result['gl_value'], 0, 50) . "...$colorEnd$nl";
        }

    } catch (Exception $e) {
        echo "   $yellow⚠ Could not connect to database: " . $e->getMessage() . "$colorEnd$nl";
    }
} else {
    echo "   $yellow⚠ Could not find database configuration$colorEnd$nl";
}

// 7. Summary and recommendations
echo $nl . $bold . "========================================$nl";
echo "SUMMARY & RECOMMENDATIONS$nl";
echo "========================================" . $boldEnd . "$nl$nl";

$issues = [];

if (!file_exists($templatePath)) {
    $issues[] = "Custom template file is missing - run: git pull origin master";
}

if (!file_exists($cssPath)) {
    $issues[] = "Custom CSS file is missing - run: git pull origin master";
}

if (isset($GLOBALS['login_page_layout']) && strpos($GLOBALS['login_page_layout'], 'teletonicmd_custom') === false) {
    $issues[] = "Template not configured - update via Admin > Globals > Login Page";
}

if (empty($issues)) {
    echo $green . "✅ Everything looks good! The custom login should be working.$colorEnd$nl";
    echo "If you still don't see changes, try:$nl";
    echo "1. Clear browser cache (Ctrl+Shift+R)$nl";
    echo "2. Restart Apache: systemctl restart apache2$nl";
    echo "3. Check error logs: tail -f /var/log/apache2/error.log$nl";
} else {
    echo $red . "Issues found:$colorEnd$nl";
    foreach ($issues as $issue) {
        echo "• $issue$nl";
    }
}

echo $nl . "Run this checker after making changes to verify configuration.$nl";

if (!$isCLI) {
    echo "</pre>";
}
?>
<?php
/**
 * UBarter PWA Icon Generator
 * Run: php generate-icons.php
 * Requires GD extension (included with PHP on most systems)
 */

$sizes   = [72, 96, 128, 144, 152, 192, 384, 512];
$outDir  = __DIR__ . '/public/images/icons';
$bgColor = [123, 15, 16];   // #7b0f10
$fgColor = [255, 255, 255]; // white

if (!is_dir($outDir)) {
    mkdir($outDir, 0755, true);
    echo "Created: $outDir\n";
}

foreach ($sizes as $size) {
    $img = imagecreatetruecolor($size, $size);

    // Enable anti-aliasing
    imageantialias($img, true);

    $bg = imagecolorallocate($img, ...$bgColor);
    $fg = imagecolorallocate($img, ...$fgColor);

    // Fill background
    imagefill($img, 0, 0, $bg);

    // Round corners (mask)
    $radius = (int)($size * 0.2);
    imagefilledellipse($img, $radius, $radius, $radius * 2, $radius * 2, $bg);
    imagefilledellipse($img, $size - $radius, $radius, $radius * 2, $radius * 2, $bg);
    imagefilledellipse($img, $radius, $size - $radius, $radius * 2, $radius * 2, $bg);
    imagefilledellipse($img, $size - $radius, $size - $radius, $radius * 2, $radius * 2, $bg);

    // Draw "U" letter centered
    $fontSize  = (int)($size * 0.45);
    $fontPath  = null;

    // Try to use a system font; fallback to built-in
    $possibleFonts = [
        'C:/Windows/Fonts/arialbd.ttf',
        'C:/Windows/Fonts/arial.ttf',
        '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
        '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
    ];

    foreach ($possibleFonts as $f) {
        if (file_exists($f)) { $fontPath = $f; break; }
    }

    if ($fontPath) {
        $bbox = imagettfbbox($fontSize, 0, $fontPath, 'U');
        $tw   = $bbox[2] - $bbox[0];
        $th   = abs($bbox[7] - $bbox[1]);
        $tx   = (int)(($size - $tw) / 2);
        $ty   = (int)(($size + $th) / 2);
        imagettftext($img, $fontSize, 0, $tx, $ty, $fg, $fontPath, 'U');
    } else {
        // Built-in font fallback
        $fw  = imagefontwidth(5)  * strlen('U');
        $fh  = imagefontheight(5);
        $tx  = (int)(($size - $fw) / 2);
        $ty  = (int)(($size - $fh) / 2);
        imagestring($img, 5, $tx, $ty, 'U', $fg);
    }

    $filePath = "$outDir/icon-{$size}x{$size}.png";
    imagepng($img, $filePath);
    imagedestroy($img);
    echo "Generated: $filePath\n";
}

echo "\nAll icons generated successfully!\n";

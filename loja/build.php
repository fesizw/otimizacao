<?php
/**
 * Script de build para minificação de assets
 * Uso: php build.php
 */

echo "=== Build de Assets ===\n\n";

// Diretórios
$cssDir = __DIR__ . '/publico/css/';
$jsDir = __DIR__ . '/publico/js/';

/**
 * Minifica CSS removendo espaços, comentários e quebras de linha
 */
function minifyCSS($css) {
    // Remove comentários
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // Remove espaços antes e depois de : ; { }
    $css = preg_replace('/\s*([{}:;,])\s*/', '$1', $css);
    // Remove espaços múltiplos
    $css = preg_replace('/\s+/', ' ', $css);
    // Remove espaços no início e fim
    $css = trim($css);
    // Remove últimos pontos e vírgulas antes de }
    $css = str_replace(';}', '}', $css);
    
    return $css;
}

/**
 * Minifica JavaScript básico (remove espaços e comentários)
 */
function minifyJS($js) {
    // Remove comentários de linha (cuidado com URLs)
    $js = preg_replace('#(?<!:)//(?!/).*$#m', '', $js);
    // Remove comentários de bloco
    $js = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $js);
    // Remove quebras de linha múltiplas
    $js = preg_replace('/\n+/', "\n", $js);
    // Remove espaços no início das linhas
    $js = preg_replace('/^\s+/m', '', $js);
    
    return trim($js);
}

// Processar CSS
echo "Processando CSS...\n";
$cssFiles = ['style.css'];

foreach ($cssFiles as $file) {
    $inputPath = $cssDir . $file;
    $outputPath = $cssDir . str_replace('.css', '.min.css', $file);
    
    if (file_exists($inputPath)) {
        $original = file_get_contents($inputPath);
        $minified = minifyCSS($original);
        file_put_contents($outputPath, $minified);
        
        $originalSize = strlen($original);
        $minifiedSize = strlen($minified);
        $reduction = round((1 - $minifiedSize / $originalSize) * 100, 1);
        
        echo "  ✓ {$file}: {$originalSize} bytes -> {$minifiedSize} bytes (-{$reduction}%)\n";
    }
}

// Processar JS (apenas os que criamos, não libs externas)
echo "\nProcessando JS...\n";
$jsFiles = glob($jsDir . '*.js');

foreach ($jsFiles as $inputPath) {
    $file = basename($inputPath);
    
    // Pular arquivos já minificados
    if (strpos($file, '.min.js') !== false) {
        continue;
    }
    
    $outputPath = $jsDir . str_replace('.js', '.min.js', $file);
    
    $original = file_get_contents($inputPath);
    $minified = minifyJS($original);
    file_put_contents($outputPath, $minified);
    
    $originalSize = strlen($original);
    $minifiedSize = strlen($minified);
    $reduction = $originalSize > 0 ? round((1 - $minifiedSize / $originalSize) * 100, 1) : 0;
    
    echo "  ✓ {$file}: {$originalSize} bytes -> {$minifiedSize} bytes (-{$reduction}%)\n";
}

echo "\n=== Build concluído! ===\n";

<?php
$dir = 'app/Models/';
foreach(scandir($dir) as $file) {
    if(str_ends_with($file, '.php')) {
        $content = file_get_contents($dir.$file);
        $content = preg_replace('/use HasFactory;/', "use HasFactory;\n    protected \$guarded = [];", $content);
        file_put_contents($dir.$file, $content);
    }
}
echo "Models updated.\n";

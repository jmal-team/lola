<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FileDirectoryHelper
{
    public static function createFile(string $path, $content)
    {
        try {
            mkdir(str($path)->beforeLast('/')->value(), recursive: true);
        } catch (\Throwable $th) {
        } finally {
            File::put($path, $content);
        }
    }

    public static function getContent(string $path)
    {
        if (File::isDirectory($path)) {
            return static::getDirectoryContent($path);
        }

        return [static::getFileContent($path)];
    }

    private static function getDirectoryContent(string $path): array
    {
        $content = [];
        $files = File::allFiles($path);
        $files = collect($files)->map(fn (\Symfony\Component\Finder\SplFileInfo $item) => str($item->getRelativePath() . '/' . $item->getFilename())
            ->prepend(str($path)->afterLast('/') . '/')
            ->value())->toArray();
        foreach ($files as $filePath) {
            $content[] = static::getFileContent($filePath);
        }

        return $content;
    }

    private static function getFileContent(string $path): array
    {
        return [
            'name' => $path,
            'content' => File::get($path),
        ];
    }
}

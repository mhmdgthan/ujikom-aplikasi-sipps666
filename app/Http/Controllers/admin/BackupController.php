<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {
        $backups = collect(Storage::disk('local')->files('backups'))
            ->filter(function ($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'sql';
            })
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'size' => Storage::disk('local')->size($file),
                    'date' => Storage::disk('local')->lastModified($file),
                    'path' => $file
                ];
            })
            ->sortByDesc('date');

        return view('admin.backup.index', compact('backups'));
    }

    public function create()
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);
            
            // Create backups directory if not exists
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            // Get all tables
            $tables = DB::select('SHOW TABLES');
            $database = config('database.connections.mysql.database');
            
            $sql = "-- Database Backup\n";
            $sql .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
            
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                
                // Get table structure
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                $sql .= "-- Table: {$tableName}\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable->{'Create Table'} . ";\n\n";
                
                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table {$tableName}\n";
                    foreach ($rows as $row) {
                        $values = array_map(function($value) {
                            return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                        }, (array) $row);
                        $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }
            
            // Write to file
            file_put_contents($path, $sql);
            
            // Auto download the backup file
            return response()->download($path, $filename);
                
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $path = 'backups/' . $filename;
        
        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->download($path);
        }
        
        return redirect()->route('admin.backup.index')
            ->with('error', 'File backup tidak ditemukan');
    }

    public function destroy($filename)
    {
        $path = 'backups/' . $filename;
        
        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup berhasil dihapus');
        }
        
        return redirect()->route('admin.backup.index')
            ->with('error', 'File backup tidak ditemukan');
    }

    public function downloadApp()
    {
        try {
            set_time_limit(300); // 5 minutes
            ini_set('memory_limit', '512M');
            
            $filename = 'app_backup_' . date('Y-m-d_H-i-s') . '.zip';
            $zipPath = storage_path('app/backups/' . $filename);
            
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
                throw new \Exception('Cannot create zip file');
            }

            // Only include essential directories
            $includeDirs = ['app', 'config', 'database', 'public', 'resources', 'routes'];
            $basePath = base_path();

            foreach ($includeDirs as $dir) {
                $dirPath = $basePath . DIRECTORY_SEPARATOR . $dir;
                if (is_dir($dirPath)) {
                    $this->addDirToZip($zip, $dirPath, $dir);
                }
            }

            // Add essential files
            $essentialFiles = ['composer.json', 'artisan', '.htaccess'];
            foreach ($essentialFiles as $file) {
                $filePath = $basePath . DIRECTORY_SEPARATOR . $file;
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $file);
                }
            }

            $zip->close();
            
            if (file_exists($zipPath)) {
                return response()->download($zipPath, $filename);
            }
            
            throw new \Exception('Zip file not created');
            
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function addDirToZip($zip, $dirPath, $zipPath)
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dirPath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $filePath = $file->getRealPath();
            $relativePath = $zipPath . substr($filePath, strlen($dirPath));
            
            if ($file->isDir()) {
                $zip->addEmptyDir($relativePath);
            } else {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }
}
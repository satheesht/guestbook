<?php
/**
 * Created by Satheesh Thangavel.
 * User: bml
 * Date: 11/2/18
 * Time: 3:49 PM
 */
namespace Detectify\Traits;
use Detectify\Exceptions\CouldNotSetEnvException;

/**
 * Reading environment file : Inspired by Dotenv package php
 * Trait Env
 * @package Detectify\Traits
 */
Trait Env{


    /**
     * Read lines from the file, auto detecting line endings.
     *
     * @param string $filePath
     * @return array
     */
    protected function readLinesFromFile($filePath)
    {
        // Read file into an array of lines with auto-detected line endings
        $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        ini_set('auto_detect_line_endings', $autodetect);
        return $lines;
    }

    /**
     * Load `.env` file in given directory.
     *
     * @param $filePath
     * @return array
     * @throws CouldNotSetEnvException
     */
    public function loadEnv($filePath)
    {
        if(!$this->isFileIsReadable($filePath)){
            throw new CouldNotSetEnvException();
        }
        $lines = $this->readLinesFromFile($filePath);
        foreach ($lines as $line) {
            if (!$this->isComment($line) && $this->isLooksLikeSetter($line)) {
                $this->setEnvironmentVariable($line);
            }
        }
        return $lines;
    }

    /**
     * Set an environment variable.
     *
     * This is done using:
     * - putenv,
     * - $_ENV,
     * - $_SERVER.
     *
     * The environment variable value is stripped of single and double quotes.
     *
     * @param $line
     * @return void
     */
    public function setEnvironmentVariable($line)
    {
        list($name,$value) = explode("=",$line);
        if (function_exists('putenv')) {
            putenv("$name=$value");
        }
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }

    /**
     * Checks the file is readable
     * @param $file
     * @return bool
     */
    protected function isFileIsReadable($file)
    {
        return is_readable($file) || is_file($file);
    }

    /**
     * Determine if the line in the file is a comment, e.g. begins with a #.
     *
     * @param string $line
     *
     * @return bool
     */
    protected function isComment($line)
    {
        $line = ltrim($line);
        return isset($line[0]) && $line[0] === '#';
    }

    /**
     * Determine if the given line looks like it's setting a variable.
     *
     * @param string $line
     *
     * @return bool
     */
    protected function isLooksLikeSetter($line)
    {
        return strpos($line, '=') !== false;
    }

}
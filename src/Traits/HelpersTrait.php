<?php

namespace SystemInc\LaravelAdmin\Traits;

use Image;
use Storage;

trait HelpersTrait
{
    /**
     * Sanitize elements.
     */
    protected function sanitizeElements($element)
    {
        return trim(strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $element)), '_');
    }

    /**
     * Generate nested page list.
     */
    protected function generateNestedPageList($pages, $navigation = '')
    {
        $navigation .= '<ul class="border">';

        foreach ($pages as $page) {
            $navigation .= '<li>';
            $navigation .= '<a href="pages/edit/'.$page->id.'">'.$page->title.'</a>';

            if ($page->subpages()->count()) {
                $navigation = $this->generateNestedPageList($page->subpages(), $navigation);
            }

            $navigation .= '</li>';
        }

        $navigation .= '</ul>';

        return $navigation;
    }

    /**
     * Save uploaded image. Overwrites existing.
     * Prepends 'images/' to storage key by default if it doesn't exists already.
     *
     * @param \Symfony\Component\HttpFoundation\File $image
     * @param string                                 $storage_key
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function saveImage($image, $storage_key = '')
    {
        if (!$image || !$image->isValid()) {
            throw new \Exception('Missing or invalid image');
        }

        if (!in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'gif', 'png', 'svg'])) {
            throw new \Exception('Image extension not allowed');
        }

        $storage_key = trim($storage_key);

        if (ends_with($storage_key, '/')) {
            $directory = $storage_key;
            $filename = $this->sanitizeFilename($image->getClientOriginalName());
        } else {
            $directory = dirname($storage_key);
            $filename = basename($storage_key);
        }

        if (!starts_with($directory, 'images')) {
            $directory = 'images/'.$directory;
        }

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0755, true);
        }

        $storage_key = $directory.DIRECTORY_SEPARATOR.$filename;

        Storage::put($storage_key, file_get_contents($image));

        return $storage_key;
    }

    /**
     * Save uploaded image with randomly generated name.
     *
     * @param \Symfony\Component\HttpFoundation\File $image
     * @param string                                 $directory
     *
     * @return string
     */
    protected function saveImageWithRandomName($image, $directory)
    {
        $storage_key = $directory.'/'.str_random(5).'.'.$image->getClientOriginalExtension();

        return $this->saveImage($image, $storage_key);
    }

    /**
     * Update existing image. Delete previous version.
     *
     * @param string                                 $storage_key
     * @param \Symfony\Component\HttpFoundation\File $image
     *
     * @return string
     */
    protected function updateImage($storage_key, $image)
    {
        if (!$image || !$image->isValid()) {
            return false;
        }

        if (Storage::exists($storage_key)) {
            Storage::delete($storage_key);
        }

        return $this->saveImage($image, $storage_key);
    }

    /**
     * Upload PDF.
     *
     * @param \Symfony\Component\HttpFoundation\File $file
     * @param string                                 $storage_path
     *
     * @return string|false
     */
    public static function savePdf($file, $storage_dir)
    {
        if ($file && $file->isValid()) {
            $dirname = 'pdf/'.$storage_dir.'/'.$file->getClientOriginalName();

            if (!Storage::exists('pdf/'.$storage_dir)) {
                Storage::makeDirectory('pdf/'.$storage_dir, 0755, true);
            }

            Storage::put($dirname, file_get_contents($file));

            return $dirname;
        }

        return false;
    }

    /**
     * Sanitize slug leave "/".
     *
     * @param string $slug
     *
     * @return string
     */
    public function sanitizeSlug($slug)
    {
        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-\/]/', '/\/+/', '/-+/'], ['', '/', '-'], $slug)), '-');
    }

    /**
     * Signature for console.
     */
    public function consoleSignature()
    {
        $this->line('');
        $this->line('');
        $this->line('');
        $this->line(' ////.           `/////      -/////////:.       -////-   `////.     :///: :///////////  .////       ');
        $this->line(' NNNN/           yNNNNN+     oNNNNNNNNNNNs     `mNNNNN.   yNNNh    .NNNN- yNNNNNNNNNNN  +NNNN       ');
        $this->line(' MMMM/          +NMMdMMN-    oMMMm```+MMMM.    hMMmmMMd`  `mMMN/   hMMMo  yMMMh.......  +MMMN       ');
        $this->line(' MMMM/         -NMMy.NMMd`   oMMMNoosdMMNy    oMMM//MMMs   -NMMm` /NMMh   yMMMNdddddd/  +MMMN       ');
        $this->line(' MMMM/        `mMMN-`oMMMy   oMMMNhNMMMd:    :NMMd..dMMN/   +MMMs`mMMm.   yMMMmyyyyyy:  +MMMN       ');
        $this->line(' MMMM+......  yMMMNmmNMMMN+  oMMMm`.dMMNd-  `mMMMNmmNMMMN.   yMMNhMMN:    yMMMh```````  +MMMN.......');
        $this->line(' MMMMNmmmmmm.+NMMdoooosNMMN- oMMMm  `hMMMm- hMMMyooooyMMMd`  `mMMMMMo     yMMMNmmmmmmm. +MMMMmmmmmmy');
        $this->line(' yyyyyyyyyyy.yyyy-     oyyyo /yyys   `syyys:yyyy`    `yyyy:   -yyyys`     +yyyyyyyyyyy. :yyyyyyyyyyo');
        $this->line('                                                                                                    ');
        $this->line('                                                                                                    ');
        $this->line('                  -////.      ///////:-`     :////:    :////:  `////`  -///-    `///:               ');
        $this->line('                 -NMMMMd`    `MMMMMMMMMMd:   mMMMMM-  -MMMMMm  .MMMM-  yMMMMs   :MMMd               ');
        $this->line('                `mMMmNMMs    `MMMM+::sNMMN:  mMMmMMh  hMMmMMm  .MMMM-  yMMMMMd. :MMMd               ');
        $this->line('                yMMN-sMMM/   `MMMM:   sMMMh  mMMyhMM::MMhyMMm  .MMMM-  yMMMNMMN/:MMMd               ');
        $this->line('               +MMMs `mMMN.  `MMMM:   oMMMd  mMMy-MMddMM-yMMm  .MMMM-  yMMMosMMMdMMMd               ');
        $this->line('              -NMMMMMMMMMMd` `MMMM:  -mMMMs  mMMy hMMMMh yMMm  .MMMM-  yMMM+ :NMMMMMd               ');
        $this->line('             `mMMMsoooodMMMs `MMMMNNNMMMNs   mMMy -MMMM- yMMm  .MMMM-  yMMM+  .hMMMMd               ');
        $this->line('             /yyys     .yyyy.`yyyyyyyso/`    syy+  oyyo  +yys  `yyyy.  +yyy:    oyyyo               ');
        $this->line('                                                                                                    ');
        $this->line('');
        $this->line(' __________________________________________________________________________________________________ ');
        $this->line('');
    }

    public function sanitizeFilename($string)
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u'  => 'A',
            '/[ÍÌÎÏ]/u'   => 'I',
            '/[íìîï]/u'   => 'i',
            '/[éèêë]/u'   => 'e',
            '/[ÉÈÊË]/u'   => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u'  => 'O',
            '/[úùûü]/u'   => 'u',
            '/[ÚÙÛÜ]/u'   => 'U',
            '/ç/'         => 'c',
            '/Ç/'         => 'C',
            '/ñ/'         => 'n',
            '/Ñ/'         => 'N',
            '/–/'         => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'  => ' ', // Literally a single quote
            '/[“”«»„]/u'  => ' ', // Double quote
            '/ /'         => ' ', // nonbreaking space (equiv. to 0x160)
        ];

        $string = urldecode($string);
        $string = strtolower($string);
        $string = preg_replace(array_keys($utf8), array_values($utf8), $string);
        $string = preg_replace(['#[\\s-]+#', '#[^a-z0-9\. -]+#'], ['-', ''], $string);

        return $string;
    }
}

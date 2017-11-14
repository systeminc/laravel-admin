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
     * Generate nasted page list.
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
     * Save image.
     */
    protected function saveImage($image, $path, $keepOriginal = false)
    {
        if ($image && $image->isValid()) {
            $image_name = str_random(5);

            $original = '/'.$image_name.'.'.$image->getClientOriginalExtension();
            $storage_key = 'images/'.$path.$original;

            if ($image->getClientOriginalExtension() === 'svg') {
                Storage::put($storage_key, file_get_contents($image));
            } elseif ($keepOriginal) {
                $original_image = Image::make($image)->orientate()->interlace()->encode();

                Storage::put($storage_key, $original_image);
            } else {
                $original_image = Image::make($image)->orientate()->interlace()
                    ->fit(1920, 1080, function ($constraint) {
                        $constraint->upsize();
                    })->encode();

                Storage::put($storage_key, $original_image);
            }

            return $storage_key;
        }

        return false;
    }

    /**
     * Handle image upload and resize.
     */
    protected function resizeImage($width, $height, $path, $output_path, $image)
    {
        if (!Storage::files($path)) {
            Storage::makeDirectory($path, 493, true);
        }

        if ($image->getClientOriginalExtension() === 'svg') {
            Storage::put($output_path, file_get_contents($image));
        } else {
            $image = Image::make($image)->orientate()
                ->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->interlace()->encode();
            Storage::put($output_path, $image);
        }

        return $output_path;
    }

    /**
     * Upload pdf.
     *
     * @param pdf $file
     * @param string|path  'pdf/'.$storage_path
     *
     * @return type
     */
    public static function uploadPdf($file, $storage_path)
    {
        if ($file && $file->isValid()) {
            $dirname = 'pdf/'.$storage_path.'/'.$file->getClientOriginalName();

            if (!Storage::exists('pdf')) {
                Storage::makeDirectory('pdf');
            }

            if (!Storage::exists('pdf/'.$storage_path)) {
                Storage::makeDirectory('pdf/'.$storage_path);
            }

            Storage::put($dirname, file_get_contents($file));

            return $dirname;
        }

        return false;
    }

    /**
     * Remove pdf.
     *
     * @param source $file
     *
     * @return type
     */
    public static function removePdf($file)
    {
        if (Storage::exists($file)) {
            Storage::delete($file);

            return;
        }

        return $file;
    }

    /**
     *  Sanitize slug leave "/".
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

    public function cleanSpecialChars($string)
    {
        return strtolower(
            preg_replace(
                ['#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'],
                ['-', ''],
                $this->cleanString(urldecode($string))
            )
        );
    }

    private function cleanString($text)
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

        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }
}

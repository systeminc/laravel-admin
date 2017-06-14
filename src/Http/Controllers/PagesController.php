<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\Page;
use SystemInc\LaravelAdmin\PageElement;
use SystemInc\LaravelAdmin\PageElementType;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\PageElementValidation;
use SystemInc\LaravelAdmin\Validations\PageValidation;
use Validator;

class PagesController extends Controller
{
    use HelpersTrait;

    public function __construct()
    {
        if (config('laravel-admin.modules.pages') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'This modules is disabled in config/laravel-admin.php')->send();
        }
    }

    /**
     * Pages controller index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $pages = Page::whereParentId(null)->get();

        $navigation = $this->generateNestedPageList($pages);

        return view('admin::pages.index', compact('pages', 'navigation'));
    }

    /**
     * Create page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate($page_id = false)
    {
        $pages = Page::all();

        return view('admin::pages.create', compact('pages', 'page_id'));
    }

    /**
     * Save new page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {
        // validation
        $validation = Validator::make($request->all(), PageValidation::rules(), PageValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }
        $page = new Page();
        $page->fill($request->all());

        if (empty($request->parent_id)) {
            $page->parent_id = null;
        }

        $page->elements_prefix = $this->sanitizeElements($request->elements_prefix);
        $page->slug = $this->sanitizeSlug($request->slug);

        $page->save();

        return redirect($request->segment(1).'/pages/edit/'.$page->id);
    }

    /**
     * Update page.
     *
     * @param Request $request
     * @param int     $page_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $page_id)
    {
        $data = $request->all();

        // validation
        $validation = Validator::make($data, PageValidation::rules($page_id), PageValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $page = Page::find($page_id);

        $elements_prefix = $this->sanitizeElements($request->elements_prefix);
        $data['parent_id'] = empty($request->parent_id) ? null : $request->parent_id;

        //CHECK IT IS RENAMED ELEMENT PREFIX AND CHANGE ALL PREFIX FOR PAGE ELEMENTS
        $this->checkIfIsChangedElementPrefixAndUpdatePrefix($elements_prefix, $page);

        $page->fill($data);

        $page->elements_prefix = $elements_prefix;
        $page->slug = $this->sanitizeSlug($request->slug);
        $page->save();

        return back();
    }

    /**
     * Edit page.
     *
     * @param int $page_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($page_id)
    {
        $page = Page::find($page_id);

        $pages = Page::all();

        $element_types = PageElementType::all();

        return view('admin::pages.edit', compact('page', 'pages', 'element_types'));
    }

    /**
     * Delete page and all elements for it.
     *
     * @param Request $request
     * @param int     $page_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete(Request $request, $page_id)
    {
        $page = Page::find($page_id);

        $elements = PageElement::wherePage_id($page_id)->get();

        foreach ($elements as $element) {
            $this->getDeleteElement($request, $element->id);
        }

        $page->delete();

        return redirect($request->segment(1).'/pages');
    }

    /**
     * Add new element.
     *
     * @param Request $request
     * @param int     $page_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postNewElement(Request $request, $page_id)
    {
        $page = Page::find($page_id);

        $page_element_type_id = $request->page_element_type_id;

        return view('admin::pages.add_element', compact('page', 'page_element_type_id'));
    }

    /**
     * Add new element in storage.
     *
     * @param Request $request
     * @param int     $page_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postAddElement(Request $request, $page_id)
    {
        // validation
        $validation = Validator::make($request->all(), PageElementValidation::rules(), PageElementValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $element = new PageElement();

        $element->create([
            'key'                  => $request->elements_prefix.'.'.$this->sanitizeElements($request->title),
            'title'                => $request->title,
            'content'              => $request->page_element_type_id == 3 ? $this->handleFileElement($request->file('content'), $request->elements_prefix) : $request->content,
            'page_id'              => $page_id,
            'page_element_type_id' => $request->page_element_type_id,
        ]);

        return redirect($request->segment(1).'/pages/edit/'.$page_id)->with('success', 'Element added');
    }

    /**
     * Edit element for page.
     *
     * @param int $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEditElement($element_id)
    {
        $element = PageElement::find($element_id);

        $keys = explode('.', $element->key);
        $key = $keys[1];

        $mime = empty($element->content) || $element->page_element_type_id !== 3 ? null : Storage::mimeType($element->content);

        return view('admin::pages.edit-element', compact('element', 'mime', 'key'));
    }

    /**
     * Delete element's file from storage.
     *
     * @param int $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDeleteElementFile($element_id)
    {
        $element = PageElement::find($element_id);

        Storage::delete($element->content);

        $element->content = null;
        $element->save();

        return back();
    }

    /**
     * Update element.
     *
     * @param Request $request
     * @param int     $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdateElement(Request $request, $element_id)
    {
        // validation
        $validation = Validator::make($request->all(), PageElementValidation::rules(), PageElementValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $element = PageElement::find($element_id);

        $element->update([
            'key'     => $element->page->elements_prefix.'.'.$this->sanitizeElements($request->key),
            'title'   => $request->title,
            'content' => $request->hasFile('content') ? $this->handleFileElement($request->file('content'), $element->page->elements_prefix) : $request->content,
        ]);

        return redirect($request->segment(1).'/pages/edit/'.$element->page_id)->with('success', 'Element updated');
    }

    /**
     * Delete element from storage.
     *
     * @param Request $request
     * @param int     $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDeleteElement(Request $request, $element_id)
    {
        $element = PageElement::find($element_id);

        if ($element->page_element_type_id == 3 && !empty($element->content)) {
            Storage::delete($element->content);
        }

        $page_id = $element->page_id;
        $element->delete();

        return redirect($request->segment(1).'/pages/edit/'.$page_id)->with('success', 'Element Deleted');
    }

    /**
     * Rename element prefix if is changed.
     */
    private function checkIfIsChangedElementPrefixAndUpdatePrefix($elements_prefix, $page)
    {
        if ($page->elements_prefix !== $elements_prefix) {
            foreach (PageElement::wherePageId($page->id)->get() as $element) {
                $element_key = explode('.', $element->key);

                $element->key = $elements_prefix.'.'.$element_key[1];

                PageElement::find($element->id)->update($element->toArray());
            }
        }

        return true;
    }

    /**
     * Handle with file element.
     */
    private function handleFileElement($file, $elements_prefix)
    {
        if ($file && $file->isValid()) {
            $dirname = 'pages/'.$elements_prefix.'/'.$file->getClientOriginalName();

            Storage::put($dirname, file_get_contents($file));

            return $dirname;
        }
    }
}

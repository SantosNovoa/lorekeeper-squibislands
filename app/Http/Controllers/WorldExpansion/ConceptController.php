<?php

namespace App\Http\Controllers\WorldExpansion;

use App\Http\Controllers\Controller;
use App\Models\Item\ItemCategory;
use App\Models\WorldExpansion\Concept;
use App\Models\WorldExpansion\ConceptCategory;
use App\Models\WorldExpansion\FloraCategory;
use App\Models\WorldExpansion\LocationType;
use Auth;
use Illuminate\Http\Request;

class ConceptController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Concept Controller
    |--------------------------------------------------------------------------
    |
    | This controller shows concepts and their categories.
    |
    */

    /**
     * Shows the concepts page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getConceptCategories(Request $request) {
        $query = ConceptCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('worldexpansion.concept_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),

        ]);
    }

    /**
     * Shows the locations page.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getConceptCategory($id) {
        $category = ConceptCategory::find($id);
        if (!$category) {
            abort(404);
        }

        return view('worldexpansion.concept_category_page', [
            'category' => $category,
        ]);
    }

    /**
     * Shows the locations page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getConcepts(Request $request) {
        $query = Concept::with('category')->orderBy('sort', 'DESC');
        $data = $request->only(['category_id', 'name', 'sort']);
        if (isset($data['category_id']) && $data['category_id'] != 'none') {
            $query->where('category_id', $data['category_id']);
        }
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        }

        if (isset($data['sort'])) {
            switch ($data['sort']) {
                case 'alpha':
                    $query->sortAlphabetical();
                    break;
                case 'alpha-reverse':
                    $query->sortAlphabetical(true);
                    break;
                case 'category':
                    $query->sortCategory();
                    break;
                case 'newest':
                    $query->sortNewest();
                    break;
                case 'oldest':
                    $query->sortOldest();
                    break;
            }
        } else {
            $query->sortCategory();
        }

        if (!Auth::check() || !(Auth::check() && Auth::user()->isStaff)) {
            $query->visible();
        }

        return view('worldexpansion.concepts', [
            'concepts'   => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + ConceptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows the locations page.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getConcept($id) {
        $concept = Concept::find($id);
        if (!$concept || !$concept->is_active && (!Auth::check() || !(Auth::check() && Auth::user()->isStaff))) {
            abort(404);
        }

        return view('worldexpansion.concept_page', [
            'concept'             => $concept,
            'concept_categories'  => ConceptCategory::get(),
            'flora_categories'    => FloraCategory::get(),
            'item_categories'     => ItemCategory::get(),
            'location_types'      => LocationType::get(),
        ]);
    }
}

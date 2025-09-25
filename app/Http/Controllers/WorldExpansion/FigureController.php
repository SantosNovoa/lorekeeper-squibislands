<?php

namespace App\Http\Controllers\WorldExpansion;

use App\Http\Controllers\Controller;
use App\Models\Item\ItemCategory;
use App\Models\WorldExpansion\EventCategory;
use App\Models\WorldExpansion\FactionType;
use App\Models\WorldExpansion\Figure;
use App\Models\WorldExpansion\FigureCategory;
use Auth;
use Illuminate\Http\Request;

class FigureController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Figure Controller
    |--------------------------------------------------------------------------
    |
    | This controller shows figures and their categories, as well as the
    | main World Info page created in the World Expansion extension.
    |
    */

    /**
     * Shows the figures page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFigureCategories(Request $request) {
        $query = FigureCategory::query();
        $name = $request->get('name');
        if ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        }

        return view('worldexpansion.figure_categories', [
            'categories' => $query->orderBy('sort', 'DESC')->paginate(20)->appends($request->query()),

        ]);
    }

    /**
     * Shows the figures page.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFigureCategory($id) {
        $category = FigureCategory::find($id);
        if (!$category) {
            abort(404);
        }

        return view('worldexpansion.figure_category_page', [
            'category' => $category,
        ]);
    }

    /**
     * Shows the figures page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFigures(Request $request) {
        $query = Figure::with('category')->orderBy('sort', 'DESC');
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

        return view('worldexpansion.figures', [
            'figures'    => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + FigureCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows the figures page.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getFigure($id) {
        $figure = Figure::find($id);
        if (!$figure || !$figure->is_active && (!Auth::check() || !(Auth::check() && Auth::user()->isStaff))) {
            abort(404);
        }

        // dd(
        //     'TODO:',
        //     '- Create variable to pass in with only attachments',
        //     '- Create variable to pass in with only attachers',
        //     '- Create variable to pass in with both attachments and attachers, for for instance figures'
        // );

        return view('worldexpansion.figure_page', [
            'figure'                  => $figure,
            'figure_categories'       => FigureCategory::get(),
            'item_categories'         => ItemCategory::get(),
            'event_categories'        => EventCategory::get(),
            'faction_categories'      => FactionType::get(),
        ]);
    }
}

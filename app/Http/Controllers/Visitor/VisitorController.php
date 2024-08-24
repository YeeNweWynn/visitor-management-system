<?php

namespace App\Http\Controllers\Visitor;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enums\CheckInType;
use App\Enums\PurposeOfVisit;
use App\Http\Requests\VisitorCreateRequest;
use App\Http\Requests\VisitorUpdateRequest;
use App\Modules\Visitor\VisitorModuleInterface;
use App\Modules\CheckIn\CheckInModuleInterface;
use Illuminate\Support\Facades\Redirect;

class VisitorController extends Controller
{

    public function __construct(
        protected VisitorModuleInterface $visitor, 
        protected CheckInModuleInterface $checkIn
    ) {}
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $visitors = $this->visitor->search($request->all());
        $checkinTypes = array_map(fn($type) => [
            'value' => $type->Type(),
            'label' => $type->name
        ], CheckInType::cases());
        $purposeOfVisit = array_map(fn($type) => [
            'value' => $type->Type(),
            'label' => $type->name
        ], PurposeOfVisit::cases());
        
        return Inertia::render('Visitor/Index', [
            'visitors' => $visitors,
            'checkinTypes' => $checkinTypes,
            'purposeOfVisit' => $purposeOfVisit,
        ]);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Visitor/Edit', [
            'visitor' => [],
            'isUpdate' => false,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VisitorCreateRequest $request)
    {
        $validated = $request->validated();

        $visitor = $this->visitor->create($request->user(), $validated);
        //return Inertia::render('Visitor/Edit', ['visitor' => $visitor, 'isUpdate' => true]);
        return Redirect::route('visitor.index')->with('success', 'Visitor created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $visitor = $this->visitor->find($id);

        return Inertia::render('Visitor/Edit', [
            'visitor' => $visitor,
            'isUpdate' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VisitorUpdateRequest $request, int $id)
    {
        $validated = $request->validated();
        $visitor = $this->visitor->find($id);
        $updated = $this->visitor->update($visitor, $validated);
        if ($updated) {
            return Redirect::route('visitor.index')->with('success', 'Visitor updated successfully!');
        }
        return Redirect::route('visitor.index')->with('error', 'Update failed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

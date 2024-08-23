<?php

namespace App\Http\Controllers\CheckIn;

use Inertia\Inertia;
use App\Models\CheckIn;
use App\Enums\VisitStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\CheckIn\CheckInModuleInterface;
use App\Modules\Visitor\VisitorModuleInterface;
use Illuminate\Support\Facades\Redirect;

class CheckInController extends Controller
{
    public function __construct(
        protected CheckInModuleInterface $checkin,
        protected VisitorModuleInterface $visitor
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $checkIns = $this->checkin->search($request->all());
        $visitStatus = array_map(fn($type) => [
            'value' => $type->Type(),
            'label' => $type->name
        ], VisitStatus::cases());
        
        return Inertia::render('CheckIn/Index', ['checkIns' => $checkIns, 'visitStatus' => $visitStatus]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'purpose_of_visit' => 'required',
        ]);

        $visitor = $this->visitor->find($request['visitor_id']);

        if (is_null($visitor)) {
            return Redirect::back()->with('error', 'Cannot find visitor!');
        }
        
        $activeCheckin = $this->checkin->findActiveCheckInOf($visitor);

        if ($activeCheckin) {
            return Redirect::back()->with('error', 'Visitor already checkedin!');
        }

        if ($this->checkin->checkIn($request->user(), $visitor, $request->all())) {
            return Redirect::back()->with('success', 'Successfully checked in!');
        }

        return Redirect::back()->with('error', 'Failed to check in!');
    }

   /**
     * Display the specified resource.
     */
    public function show(CheckIn $checkIn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CheckIn $checkIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CheckIn $checkin)
    {
        if ($this->checkin->checkOut($checkin)) {
            return Redirect::back()->with('success', 'Successfully checked out!');
        }
        return Redirect::back()->with('error', 'Failed to check out!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CheckIn $checkIn)
    {
        //
    }
}

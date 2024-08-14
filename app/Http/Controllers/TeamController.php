<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Player;
use App\Traits\HasImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\TeamResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Validations\TeamValidationRules;
use App\Models\PositionCatalog;

class TeamController extends Controller
{
    use TeamValidationRules, HasImages;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Auth::user()->teams;

        if ($teams) {

            return TeamResource::collection($teams);
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->teamStoreValidationRules());
        
        try {
            $user_id = Auth::id();

            $new_team = Team::create([
                'name' => $request->name,
                'logo_path' => $this->storeImageLocally($request->logo),
                'user_id' => $user_id,
            ]);

            $new_team->user()->associate($user_id);

            foreach ($request->players as $player) {

                $new_player = Player::create([
                    'name' => $player['name'],
                    'number' => $player['number'],
                    'team_id' => $new_team->id
                ]);

                foreach ($player['positions'] as $position_acronym) {

                    Log::info($position_acronym);

                    $position_id = PositionCatalog::where($position_acronym, '=', 'acronym')->get()->id;

                    Log::info($position_id);

                    $new_player->positions()->attach($position_id);
                }

                $new_player->team()->associate($new_team);

                $new_player->save();
            }
            
            $new_team->save();

            return response()->json("Creado con éxito", 201);

        } catch (\Throwable $th) {
            Log::error($th);

            return response()->json("Ocurrió un problema.", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new TeamResource(Team::find($id));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

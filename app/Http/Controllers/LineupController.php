<?php

namespace App\Http\Controllers;

use App\Models\Lineup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LineupResource;
use App\Models\Team;
use App\Traits\HasImages;

class LineupController extends Controller
{

    use HasImages;

    public function index(string $team_id)
    {
        $team = Team::find($team_id);
        $lineups = $team->lineups;

        if ($lineups) {
            return [
                'team_logo' => $this->getImageFromPath($team->logo_path),
                'team_name' => $team->name,
                'lineups' => LineupResource::collection($lineups)
            ];
        }
        
        return [
            'team_logo' => $this->getImageFromPath($team->logo_path),
            'team_name' => $team->name,
            'lineups' => []
        ];
    }

    public function store(Request $request, string $team_id) 
    {
        try {
            
            $newLineup = Lineup::create([
                'name' => $request->name,
                'team_id' => $team_id,
            ]);

            foreach ($request->players as $player) {
                $newLineup->players()->attach($player,
                    ['position_id', $player->position[0]['id']]
                );
            }

            $newLineup->save();

            return response()->json('Insertado con éxito', 201);

        } catch (\Throwable $th) {
            
            Log::error($th);

            return response()->json('Ocurrió un problema', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $lineup_id)
    {
        return new LineupResource(Lineup::find($lineup_id));
    }
}

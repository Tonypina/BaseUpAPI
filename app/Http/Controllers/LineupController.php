<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Team;
use App\Models\Lineup;
use App\Models\Player;
use App\Traits\HasImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\LineupResource;

class LineupController extends Controller
{

    use HasImages;

    public function index(string $team_id)
    {
        try {
            $team = Team::find($team_id);
            $lineups = $team->lineups;
    
            if ($lineups) {
                return [
                    'data' => [
                        'team_logo' => $this->getImageFromPath($team->logo_path),
                        'team_name' => $team->name,
                        'lineups' => LineupResource::collection($lineups)
                    ]
                ];
            }
            
            return [
                'data' => [
                    'team_logo' => $this->getImageFromPath($team->logo_path),
                    'team_name' => $team->name,
                    'lineups' => []
                ]
            ];
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function store(Request $request, string $team_id) 
    {
        try {
            
            $newLineup = Lineup::create([
                'name' => $request->name,
                'team_id' => $team_id,
            ]);

            foreach ($request->players as $player) {

                $savedPlayer = Player::find($player['id']);

                Log::info($savedPlayer);

                $newLineup->players()->attach($savedPlayer,
                    ['position_id', $player['positions'][0]['id']]
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
